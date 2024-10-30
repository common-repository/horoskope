<?PHP
/**
 * Horoskop Widget class.
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update.  Nice!
 *
 * @since 0.1
 */
class Horoskop_Widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function Horoskop_Widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'horoskop', 'description' => __('Mit diesem Widget k&ouml;nnen Sie sich f&uuml;r jeden Tag ein Horoskop anzeigen lassen', 'horoskop') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'horoskop-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'horoskop-widget', __('Horoskop Widget', 'horoskope'), $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$typ = $instance['typ'];
		$sternzeichen = $instance['sternzeichen'];
		$bild = $instance['bild'];

		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $title )
			echo $before_title;
			if($bild == 'on'){
				echo '<img src="' . TEXTCREATOR_PLUGIN_HOROSKOPE . 'images/thumb_' . $sternzeichen . '.png" />';
			}
			echo $title;
			echo $after_title;

		/* Display name from widget settings if one was input. */		
		switch($typ){
			case 1: 
				$horoskope = get_option( 'horoskop-liebe' );
				break;
			case 2: 
				$horoskope = get_option( 'horoskop-partner' );
				break;
			default: 
				$horoskope = get_option( 'horoskop-tag' );
				break;
		}
		if( is_array( $horoskope ) ){
			foreach( $horoskope as $key => $value ){
				$value = html_entity_decode($value);
				$value = str_replace('\"','"', $value);
				$value = str_replace("\'","'", $value);
				if( $key == $sternzeichen ){
					echo '<p>' . $value . '</p>';
					break;
				}
			}
		}
		/* After widget (defined by themes). */
		echo $after_widget;
	}

	/**
	 * Update the widget settings.
	 */
	function update($new_instance, $old_instance) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['typ'] = $new_instance['typ'];
		$instance['sternzeichen'] = $new_instance['sternzeichen'];
		$instance['bild'] = $new_instance['bild'];
		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form($instance) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => __( 'Horoskope', 'horoskope' ), 
			'typ' => array( 1 => __( 'Liebeshoroskope', 'horoskope' ), 2 => __( 'Partnerhoroskope', 'horoskope' ), 3 => __( 'Tageshoroskope', 'horoskope' ) ), 
			'sternzeichen' => array( 1 => __( 'Fische', 'horoskope' ), 2 => __( 'Jungfrau', 'horoskope' ), 3 => __( 'Krebs', 'horoskope' ), 4 => __( 'L&ouml;we', 'horoskope' ), 5 => __( 'Sch&uuml;tze', 'horoskope' ), 6 => __( 'Skorpion', 'horoskope' ), 7 => __( 'Steinbock', 'horoskope' ), 8 => __( 'Stier', 'horoskope' ), 9 => __( 'Waage', 'horoskope' ), 10 => __( 'Wassermann', 'horoskope' ), 11 => __( 'Widder', 'horoskope' ), 12 => __( 'Zwilling', 'horoskope' ) ), 
		);
		$instance = wp_parse_args( ( array ) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="title"><?php _e( 'Titel:', 'horoskope' ); ?></label>
			<input id="<?PHP echo $this->get_field_id( 'title' ) ?>" name="<?PHP echo $this->get_field_name( 'title' ) ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>

		<!-- Typ: Select Box -->
		<p>
			<label for="<?PHP echo $this->get_field_id( 'typ' ) ?>"><?php _e( 'Horoskop:', 'horoskope' ); ?></label>
			<select id="<?PHP echo $this->get_field_id( 'typ' ) ?>" name="<?PHP echo $this->get_field_name( 'typ' ) ?>" style="width:100%;" >
      	<?PHP foreach( $defaults['typ'] as $key => $value ){ ?>
				<option value="<?PHP echo $key ?>" <?php if ( $key == $instance['typ'] ) echo 'selected="selected"'; ?>><?PHP echo $value ?></option>
      	<?PHP } ?>
      </select>
		</p>

		<!-- Sternzeichen: Select Box -->
		<p>
			<label for="<?PHP echo $this->get_field_id( 'sternzeichen' ) ?>"><?php _e( 'Sternzeichen:', 'horoskope' ); ?></label> 
			<select id="<?PHP echo $this->get_field_id( 'sternzeichen' ) ?>" name="<?PHP echo $this->get_field_name( 'sternzeichen' ) ?>" class="" style="width:100%;">
      	<?PHP foreach( $defaults['sternzeichen'] as $key => $value ){ ?>
				<option value="<?PHP echo $key ?>" <?php if ( $key == $instance['sternzeichen'] ) echo 'selected="selected"'; ?>><?PHP echo $value ?></option>
      	<?PHP } ?>
			</select>
		</p>

		<!-- Show Image? Checkbox -->
		<p>
			<input class="checkbox" type="checkbox" <?php checked( 'on', $instance['bild'], true ); ?> id="<?PHP echo $this->get_field_id( 'bild' ) ?>" name="<?PHP echo $this->get_field_name( 'bild' ) ?>" /> 
			<label for="<?PHP echo $this->get_field_id( 'bild' ) ?>"><?php _e( 'Icon?', 'horoskope' ); ?></label>
		</p>
	<?php
	}
}
?>