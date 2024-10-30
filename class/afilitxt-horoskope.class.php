<?PHP
class mbrAfiliTxtAddHoroskope
{
	protected
		$version = '1.3.2',
		$spezial = FALSE,
		$textCreatorAccountUrl = 'http://[SERVER]/web/index.php/getAccount/language/[language]/version/[version]/filesize_widget/[filesize].xml',
		$textCreatorDataUrl = 'http://[SERVER]/web/index.php/main/loadText/id/[userid]/pw/[kennwort]/kategorie/[kategorie]/gender/[gender]/[parameter].xml',
		$user_id = NULL,
		$kennwort = NULL,
		$parameter = NULL,
		$settings = NULL,
		$lastUpdate = NULL,
		$plugin_url = NULL,
		$post_categories = NULL,
		$errors = NULL,
		$database = NULL;
		
	public function __construct($plugin_url = NULL, $data_server = 'localhost/textCreator') {
		global $wpdb, $table_prefix;
		$this->database = $wpdb;
		$this->user_id = get_option( 'afilitxt-id' );
		$this->kennwort = get_option( 'afilitxt-kennwort' );
		$this->lastUpdate = get_option( 'afilitxt-horoskope-last-clean' );
		$this->plugin_url = $plugin_url;
		$this->textCreatorAccountUrl = str_replace( '[SERVER]', $data_server, $this->textCreatorAccountUrl );
		$this->textCreatorDataUrl = str_replace( '[SERVER]', $data_server, $this->textCreatorDataUrl );
	}

	public function getTyp(){
		return $this->typ;
	}

	public function hasErrors(){
		if( $this->errors == NULL ){
			return false;
		} else {
			return true;
		}
	}

	public function getErrors(){
		return $this->errors;
	}

	public function getWebmasterSettings() {
		if( $this->settings == NULL ){
			$this->settings = get_option( 'afilitxt-webmaster-settings' );
		}
		return $this->settings;
	}

	public function saveWebmasterSettings( $vars = NULL ) {
		if( $vars !== NULL && is_array( $vars ) ){
			$this->settings['wmid'] = $vars['wmid'];
			$this->settings['language'] = $vars['language'];
			update_option( 'afilitxt-webmaster-settings', $this->settings );
		}
	}

	public function deleteWebmasterSettings() {
		delete_option( 'afilitxt-webmaster-settings' );
		delete_option( 'afilitxt-horoskope-liebe' );
		delete_option( 'afilitxt-horoskope-partner' );
		delete_option( 'afilitxt-horoskope-tag' );
		delete_option( 'horoskop-liebe' );
		delete_option( 'horoskop-partner' );
		delete_option( 'horoskop-tag' );
		delete_option( 'widget_horoskop-widget' );
	}

	public function getKennwort() {
		return $this->kennwort;
	}

	public function getUserId() {
		return $this->user_id;
	}

	public function getDatabase() {
		return $this->database;
	}

	public function getVersion() {
		return $this->version;
	}

	public function hasUser() {
		if( $this->user_id != NULL && $this->kennwort != NULL ) {
			return true;
		} else {
			return false;
		}
	}

	public function getNewAccount() {
		global $wpdb, $table_prefix;
		if( !$this->hasUser() ){
			$version = explode( '.', $this->version );
			$curlWrapper = new CurlWrapper;
	
			$settings = get_option( 'afilitxt-webmaster-settings' );
			$language = 'de_DE';
			if( is_array( $settings ) && array_key_exists( 'language', $settings ) ){
				$language = $settings['language'];
			}
			$url = str_replace( '[language]', $language, $this->textCreatorAccountUrl );
			$url = str_replace( '[version]', implode( '-', $version ), $url );
			$url = str_replace( '[filesize]', filesize( WP_PLUGIN_DIR . '/horoskope/class/afilitxt-horoskope.class.php' ), $url );
			$data = $curlWrapper->getRequest( $url );
	
			$mydata = $data['xmlelement'];
			if( !$mydata->errors->error ){
				$this->user_id = db_escape( $mydata->id );
				$this->kennwort = db_escape( $mydata->kennwort );
	
				update_option( 'afilitxt-id', $this->user_id );
				update_option( 'afilitxt-kennwort', $this->kennwort );
				
				#$this->loadHoroskope();
			} else {
				if ( is_admin() ) {
					echo '<div id="message" class="error">';
				} else {
					echo '<div id="message" class="updated fade">';
				}
				echo "<p><strong>" . $mydata->errors->error[0] . "</strong></p></div>";
			}
		}
	}

	public function loadHoroskope(){
		global $wpdb, $table_prefix;

		$this->errors = array();
		
		$feedList = array(
			11 => 'Widder', 
			8 => 'Stier', 
			12 => 'Zwilling',
			3 => 'Krebs', 
			4 => 'Loewe', 
			2 => 'Jungfrau', 
			9 => 'Waage', 
			6 => 'Skorpion', 
			5 => 'Schuetze', 
			7 => 'Steinbock', 
			10 => 'Wassermann', 
			1 => 'Fische', 
		);

		$sternzeichen = array(
			1 => __( 'Fische', 'horoskope' ), 
			2 => __( 'Jungfrau', 'horoskope' ), 
			3 => __( 'Krebs', 'horoskope' ), 
			4 => __( 'L&ouml;we', 'horoskope' ), 
			5 => __( 'Sch&uuml;tze', 'horoskope' ), 
			6 => __( 'Skorpion', 'horoskope' ), 
			7 => __( 'Steinbock', 'horoskope' ), 
			8 => __( 'Stier', 'horoskope' ), 
			9 => __( 'Waage', 'horoskope' ), 
			10 => __( 'Wassermann', 'horoskope' ), 
			11 => __( 'Widder', 'horoskope' ), 
			12 => __( 'Zwilling', 'horoskope' )
		);

		$checksumme = filesize( WP_PLUGIN_DIR . '/horoskope/class/afilitxt-horoskope.class.php' );

		$horoskop = array();
		if( get_option( 'afilitxt-horoskope-liebe' ) < ( time() - 84600 ) ) {
			if( $this->spezial ) {
				$this->getPostCategories();
			}
			$horoskop = array();
			foreach( $feedList as $key => $value ) {
				$parameter = 'typ/liebe/name/' . strtolower( $value ) . '/anzahl/1/filesize_widget/' . $checksumme;
				$horoskop[$key] = $this->importItem( $key, $parameter );
				if( $this->spezial && $horoskop[$key] != NULL ) {
					$postData = array(
							'post_date'      => gmdate( 'Y-m-d H:i:s', ( time() + ( get_option( 'gmt_offset' ) * 3600 ) - rand( 0, 7200 ) ) ),
							'post_category'  => array( ( array_key_exists( strtolower( $value ), $this->post_categories ) ? $this->post_categories[strtolower( $value )] : 1 ) ),
							'post_author'    => 1,
							'post_content'   => '<img src="' . $this->plugin_url . 'images/post_' . $key . '.png" style="float:left" />' . $horoskop[$key],
							'post_title'     => __( 'Liebeshoroskop', 'horoskope' ) . ' ' . $sternzeichen[$key],
							'post_status'    => 'publish',
							'post_type'      => "post",
							'comment_status' => get_option( 'default_comment_status' ),
							'ping_status'    => get_option( 'default_ping_status' ),
							'post_name'      => db_escape( sanitize_title( __( 'Liebeshoroskop', 'horoskope' ) . ' ' . $sternzeichen[$key] ) ),
					);
					// add the post
					$newPostId = wp_insert_post( $postData );
	
					$keywords = array( __( 'Horoskop', 'horoskope' ), __( 'Sternzeichen', 'horoskope' ), __( 'Liebeshoroskop', 'horoskope' ), $sternzeichen[$key] );
					wp_set_object_terms( $newPostId, $keywords, 'post_tag', $append = false );
				}
			}
			update_option( 'horoskop-liebe', $horoskop );
			update_option( 'afilitxt-horoskope-liebe', time() );
		} elseif ( get_option( 'afilitxt-horoskope-partner' ) < ( time() - 84600 ) ) {
			$this->getPostCategories();
			$horoskop = array();
			foreach( $feedList as $key => $value ) {
				$parameter = 'typ/partner/name/' . strtolower( $value ) . '/anzahl/1/filesize_widget/' . $checksumme;
				$horoskop[$key] = $this->importItem( $key, $parameter );
				if( $this->spezial && $horoskop[$key] != NULL ) {
					$postData = array(
							'post_date'      => gmdate( 'Y-m-d H:i:s', ( time() + ( get_option( 'gmt_offset' ) * 3600 ) - rand( 0, 7200 ) ) ),
							'post_category'  => array( ( array_key_exists( strtolower( $value ), $this->post_categories ) ? $this->post_categories[strtolower( $value )] : 1 ) ),
							'post_author'    => 1,
							'post_content'   => '<img src="' . $this->plugin_url . 'images/post_' . $key . '.png" style="float:left" />' . $horoskop[$key],
							'post_title'     => __( 'Partnerhoroskop', 'horoskope' ) . ' ' . $sternzeichen[$key],
							'post_status'    => 'publish',
							'post_type'      => "post",
							'comment_status' => get_option( 'default_comment_status' ),
							'ping_status'    => get_option( 'default_ping_status' ),
							'post_name'      => db_escape( sanitize_title( __( 'Partnerhoroskop', 'horoskope' ) . ' ' . $sternzeichen[$key] ) ),
					);
					// add the post
					$newPostId = wp_insert_post( $postData );
	
					$keywords = array( __( 'Horoskop', 'horoskope' ), __( 'Sternzeichen', 'horoskope' ), __( 'Partnerhoroskop', 'horoskope' ), $sternzeichen[$key] );
					wp_set_object_terms( $newPostId, $keywords, 'post_tag', $append = false );
				}
			}
			update_option( 'horoskop-partner', $horoskop );
			update_option( 'afilitxt-horoskope-partner', time() );
		} elseif ( get_option( 'afilitxt-horoskope-tag' ) < ( time() - 84600 ) ) {
			$this->getPostCategories();
			$horoskop = array();
			foreach( $feedList as $key => $value ) {
				$parameter = 'typ/tag/name/' . strtolower( $value ) . '/anzahl/1/filesize_widget/' . $checksumme;
				$horoskop[$key] = $this->importItem( $key, $parameter );
				if( $this->spezial && $horoskop[$key] != NULL ) {
					$postData = array(
							'post_date'      => gmdate( 'Y-m-d H:i:s', ( time() + ( get_option( 'gmt_offset' ) * 3600 ) - rand( 0, 7200 ) ) ),
							'post_category'  => array( ( array_key_exists( strtolower( $value ), $this->post_categories ) ? $this->post_categories[strtolower( $value )] : 1 ) ),
							'post_author'    => 1,
							'post_content'   => '<img src="' . $this->plugin_url . 'images/post_' . $key . '.png" style="float:left" />' . $horoskop[$key],
							'post_title'     => __( 'Tageshoroskop', 'horoskope' ) . ' ' . $sternzeichen[$key],
							'post_status'    => 'publish',
							'post_type'      => "post",
							'comment_status' => get_option( 'default_comment_status' ),
							'ping_status'    => get_option( 'default_ping_status' ),
							'post_name'      => db_escape( sanitize_title( __( 'Tageshoroskop', 'horoskope' ) . ' ' . $sternzeichen[$key] ) ),
					);
					// add the post
					$newPostId = wp_insert_post($postData);
	
					$keywords = array( __( 'Horoskop', 'horoskope' ), __( 'Sternzeichen', 'horoskope' ), __( 'Tageshoroskop', 'horoskope' ), $sternzeichen[$key]);
					wp_set_object_terms($newPostId, $keywords, 'post_tag', $append = false);
				}
			}
			update_option( 'horoskop-tag', $horoskop );
			update_option( 'afilitxt-horoskope-tag', time() );
		}
		if( !empty( $this->errors ) ) {
			if ( is_admin() ) {
				echo '<div id="message" class="error">';
			} else {
				echo '<div id="message" class="updated fade">';
			}
			echo "<p><strong>" . $this->errors[0] . "</strong></p></div>";
		}
	}

	/**
	 * Imports a complete feed item
	 *
	 * @param string $parameter the items data
	 * @param number $postCategory the posts category
	 */
	private function importItem( $key, $parameter = '' )
	{
		// global stuff
		global $wpdb, $table_prefix;		

		$checksumme = filesize( WP_PLUGIN_DIR . '/horoskope/class/afilitxt-horoskope.class.php' );

		$curlWrapper = new CurlWrapper;
		$url = str_replace( '[userid]', $this->user_id, $this->textCreatorDataUrl );
		$url = str_replace( '[kennwort]', $this->kennwort, $url );
		$url = str_replace( '[kategorie]', 12, $url );
		$url = str_replace( '[gender]', 3, $url );
		#mbr Parameter werden ausgewertet und hinzugefügt
		$url = str_replace( '[parameter]', $parameter, $url );
		$data = $curlWrapper->getRequest( $url );
		$mydata = $data['xmlelement'];
		if( $mydata->items->item ){
			$datas = $mydata->items->item;
			foreach( $datas as $data ){
				return db_escape( $data->text );
				break;
			}
		}
		if( $mydata->errors->error ){
			$datas = $mydata->errors->error;
			foreach( $datas as $data ){
				$this->errors[] = $data . '(' . $checksumme . ')';
			}
		}
		return NULL;
	}

	private function getPostCategories() 
	{
		$myCats = array();
		$sternzeichen = array(
			1 =>'fische', 
			2 => 'jungfrau', 
			3 => 'krebs', 
			4 => 'loewe', 
			5 => 'schuetze', 
			6 => 'skorpion', 
			7 => 'steinbock', 
			8 => 'stier', 
			9 => 'waage', 
			10 => 'wassermann', 
			11 => 'widder', 
			12 => 'zwilling'
		);
		$cats = get_categories( "get=all" );
		if( is_array( $cats ) ) {
			foreach( $cats as $key => $cat ) {
				if( in_array( $cat->slug, $sternzeichen ) ) {
					$myCats[$cat->slug] = $cat->term_id;
				}
			}
			$this->post_categories = $myCats;
		}
	}
}
?>