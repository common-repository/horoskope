<?php
/**
 *
 * Plugin Name: Horoskop PlugIn
 * Plugin URI: http://www.cms-easysystem.de/
 * Description: Dieses PlugIn liefert jeden Tag Horoskope als Seite oder als Widget;
 * Version: 1.3.2
 * Author: Michael Breunig
 * Author URI: http://www.cms-easysystem.de
 */

if( !class_exists( 'CurlWrapper' ) ){
	require_once( dirname( __FILE__ ) . "/class/sfCurlWrapper.class.php" );
}
require_once( dirname( __FILE__ ) . "/class/afilitxt-horoskope.class.php" );
require_once( dirname( __FILE__ ) . "/class/class-widget.php" );
require_once( dirname( __FILE__ ) . "/function.php" );

/**
 * Used for escaping strings
 *
 */
if( !function_exists( 'db_escape' ) ){
	function db_escape( $string ) {
		// strip slashes
		if( get_magic_quotes_gpc() ) {
				$string = stripslashes($string);
		}
		// quote if not integer
		if( !is_numeric( $string ) ) {
				$string = mysql_escape_string($string);
		}
		return $string;
	}
}

if( !function_exists( 'afilitxtHoroskope' ) ){
	/**
	 * Standartfunktionen für die EroTxt PlugIns
	 *
	 */
	function afilitxtHoroskope()
	{
		// global stuff
		global $wpdb,$table_prefix;
	
		$textCreator = new mbrAfiliTxtAddHoroskope(TEXTCREATOR_PLUGIN_HOROSKOPE, TEXTCREATOR_DATA_SERVER);
		if( isset( $_POST['save_webmaster_settings'] ) ) {
			$textCreator->saveWebmasterSettings( $_POST );
			$textCreator->getNewAccount();
		}
		
		if( isset( $_POST['delete_webmaster_settings'] ) ) {
			$textCreator->deleteWebmasterSettings( $_POST );
		}
		
		include_once( dirname( __FILE__ ) . "/formular/einstellungen.php" );
	}
}

class AfiliTxtHoroskop
{
	var $automatic = TRUE;
	/**
	 * Constructor
	 *
	 * @return TextCreatorImport
	 */
	function AfiliTxtHoroskop()
	{
		// global stuff
		global $wpdb;

		// Actions
		register_activation_hook( __FILE__, array( &$this, 'installPlugin' ) );
		register_deactivation_hook( __FILE__, array( &$this, 'uninstallPlugin' ) );
		add_action( 'init', array( &$this, 'initPlugin' ) );
		$plugIns = get_option( 'active_plugins' );
		if( in_array( 'horoskope/horoskope.php', $plugIns ) ){
			add_action( 'admin_menu', array( $this, 'addAdminMenu' ) );
			add_action( 'widgets_init', array( $this, 'addWidget' ) );

			add_filter( 'the_content', array( $this, 'parseContent' ), 11 );
		}
	}

	/**
	 * Install function - called when the plugin is enabled
	 *
	 */
	function installPlugin()
	{
		// global stuff
		global $wpdb, $table_prefix;
	}
	
	/**
	 * Uninstall function - gets called when the plugin is disabled
	 *
	 */
	function uninstallPlugin()
	{
		// global stuff
		global $wpdb;
	}

	/**
	 * Gets called, when the plugin is initialized
	 *
	 */
	function initPlugin()
	{
		#mbr Hier wird geprüft, ob dieser Blog schon einen Account besitzt
		if( $this->automatic == TRUE ){
			$textCreator = new mbrAfiliTxtAddHoroskope(TEXTCREATOR_PLUGIN_HOROSKOPE, TEXTCREATOR_DATA_SERVER);
			if( $textCreator->hasUser() && get_option( 'afilitxt-webmaster-settings' ) ){
				$textCreator->loadHoroskope();
			}
		}
		wp_register_style( 'horoskop_style.css', TEXTCREATOR_PLUGIN_HOROSKOPE . 'horoskop_style.css', array(), '1.0.1' );
		wp_enqueue_style( 'horoskop_style.css' );
	}

	/**
	 * Adds the Widget to the blog
	 *
	 */
	function addWidget()
	{
		register_widget( 'Horoskop_Widget' );
	}

	/**
	 * Adds the admin menu to the navigation
	 *
	 */
	function addAdminMenu()
	{
		// add it
		$this->admin_page = add_menu_page( 'Horoskope', 'Horoskope', 'edit_theme_options', 'afilitxtHoroskope', 'afilitxtHoroskope', '', 10004 );

		add_action( "load-{$this->admin_page}", array( &$this,'create_help_screen' ) );
	}

	/**
	 * Shows the admin menu
	 *
	 */
	function showAdminMenu()
	{
		// global stuff
		global $wpdb,$table_prefix;

		$textCreator = new mbrAfiliTxtAddHoroskope(TEXTCREATOR_PLUGIN_HOROSKOPE, TEXTCREATOR_DATA_SERVER);
		if( isset( $_POST['save_settings'] ) ) {
			$textCreator->saveSettings( $_POST );
		}
		if( isset( $_POST['get_user_account'] ) ) {
			$textCreator->getNewAccount();
		}
		include_once( dirname( __FILE__ ) . "/formular/einstellungen.php" );
	}

	/**
	 * Parses the content
	 *
	 * @param string $theContent the full text content
	 */
	function parseContent( $theContent )
	{
		#mbr Hier wird nach Platzhaltern [url_image] gesucht
		$sternzeichen = array(
			1 =>array('Fische', 'fische'), 
			2 => array('Jungfrau', 'jungfrau'), 
			3 => array('Krebs', 'krebs'), 
			4 => array('L&ouml;we','loewe'), 
			5 => array('Sch&uuml;tze', 'schuetze'), 
			6 => array('Skorpion', 'skorpion'), 
			7 => array('Steinbock', 'steinbock'), 
			8 => array('Stier', 'stier'), 
			9 => array('Waage', 'waage'), 
			10 => array('Wassermann', 'wassermann'), 
			11 => array('Widder', 'widder'), 
			12 => array('Zwilling', 'zwilling')
		);
		
		include_once( dirname( __FILE__ ) . "/parse_content.php" );

		return $theContent;
	}

	public function create_help_screen() {
 
		/** 
		 * Create the WP_Screen object against your admin page handle
		 * This ensures we're working with the right admin page
		 */
		$this->admin_screen = get_current_screen();
 
		/**
		 * Content specified inline
		 */
		$message = 'Wenn Du einen kostenlosen Account bei AfiliTxt beantragt hast, arbeitet das Horoskop PlugIn von AffiliTxt v&ouml;llig selbst&auml;ndig.
			Alle 24 Stunden werden vollautomatisch neue Horoskope eingelesen, die Du &uuml;ber ein Widget oder &uuml;ber Platzhalter 
			in Artikel und Seiten anzeigen kannst. 
			<br /><br /><i>ACHTUNG: Dieses PlugIn ist eine kostenlose Version aus der AfiliTxt PlugIn Serie und kann
			Links zu Werbepartner enthalten!</i>';

		$this->admin_screen->add_help_tab(
			array(
				'title'    => __('ALLGEMEIN', 'horoskope'),
				'id'       => 'allgemein',
				'content'  => '<p>' . $message . '</p>',
				'callback' => false
			)
		);

		$this->admin_screen->add_help_tab(
			array(
				'title'    => __('ACCOUNT', 'horoskope'),
				'id'       => 'account',
				'content'  => '<p><strong>In der Aufklappkarte ACCOUNT findest Du deine Zugangsdaten zum AfiliTxt- Server.
													Diese Daten ben&ouml;tigst Du bei Supportanfragen beim AFILITXT.COM- Team.</strong>
													<br />Bei folgenden Fehlern kann nur der Support von AfiliTxt.com helfen:
													<ul>
														<li>Es wurde keine g&uuml;ltiger Benutzer gefunden</li>
														<li>Checksumme ist fehlerhaft</li>
														<li>Das Guthaben des Benutzer reicht nicht mehr aus</li>
														<li>Sie haben nicht die aktuelle Version...</li>
													</ul>
													<strong>Bis zur Kl&auml;rung des Problems solltest Du das PlugIn deaktivieren, damit dein Blog nicht unn&ouml;tig langsam wird!</strong>
													<br /><br /><i>&Auml;nderungen am PlugIn- Code kann dazu f&uuml;hren, dass keine Daten mehr vom AfiliTxt- Server abgerufen werden!</i> 
												</p>',
				'callback' => false
			)
		);
 
		$this->admin_screen->add_help_tab(
			array(
				'title'    => __('WEBMASTER', 'horoskope'),
				'id'       => 'webmaster',
				'content'  => '<p><strong>In dieser Aufklappkarte beantragst Du deinen pers&ouml;nlichen AfiliTxt- Account und 
													kannst die ersten Horoskope f&uuml;r das PlugIn einlesen.</strong>
													<ul>
														<li>Aus der Webmaster-ID und der Sprache wird auf dem AfiliTxt- Server dein pers&ouml;nlicher 
													Zugang f&uuml;r diesen Blog erzeugt.</li>
														<li>&Uuml;ber die Button &quot;Liebeshoroskope&quot;, &quot;Partnerhoroskope&quot; und &quot;Tageshoroskope&quot; 
													kannst Du die ersten Horoskope einlesen.</li>
														<li>Zur Zeit liefert AfiliTxt nur deutsche Horoskope.</li>
													</ul>
											</p>',
				'callback' => false
			)
		);
 
		$message = '<strong>Damit Du die Horoskope in Artikeln und Seiten einbauen kannst, platzierst Du an den gew&uuml;nschten Stellen folgende Platzhalter.</strong> 
			<ul>
				<li>Liebeshoroskope: <strong><span style="font-size:1.2em">[afilitxt_horoskope_liebe]</span> oder <span style="font-size:1.2em">[afilitxt_horoskope_liebe_icon]</span></strong></li>
				<li>Partnerhoroskope: <strong><span style="font-size:1.2em">[afilitxt_horoskope_partner]</span> oder <span style="font-size:1.2em">[afilitxt_horoskope_partner_icon]</span></strong></li>
				<li>Tageshoroskope: <strong><span style="font-size:1.2em">[afilitxt_horoskope_tag]</span> oder <span style="font-size:1.2em">[afilitxt_horoskope_tag_icon]</span></strong></li>
				<li>Die Platzhalter mit dem Zusatz &quot;_icon&quot; blenden zu jedem Sternzeichen ein Symbol ein. Diese Symbole findest Du im PlugIn Ordner 
						&quot;horoskope&quot; unter &quot;images&quot;</li>
				<li>Mit der CSS- Datei &quot;horoskop_style.css&quot; im PlugIn- Ordner horoskope kannst Du diese 
						Ausgaben an deine Bed&uuml;rfnisse anpassen</li>
			</ul>';
		
		$this->admin_screen->add_help_tab(
			array(
				'title'    => __('ARTIKEL / SEITEN', 'horoskope'),
				'id'       => 'horoskop',
				'content'  => '<p>' . $message . '</p>',
				'callback' => false
			)
		);
 
		$message = '<strong>Damit Du die Horoskope in einem Widget anzeigen kannst, wechselst Du in das Men&uuml; &quot;Design/Widget&quot;.
			Hier findest Du das Horoskop Widget. Platziere das Widget in die gew&uuml;nschte Sidebar.</strong> 
			<ul>
				<li>Gib diesem Widget einen Namen</li>
				<li>W&auml;hle den Horoskoptyp aus</li>
				<li>W&auml;hle ein Sternzeichen</li>
				<li>Lege fest, ob das Sternzeichensymbol angezeigt werden soll</li>
			</ul>
			<i>Wenn Du mehrer Sternzeichen anzeigen m&ouml;chtest, dann kannst Du mehrer Widgets erstellen.</i>';
		
		$this->admin_screen->add_help_tab(
			array(
				'title'    => __('WIDGET', 'horoskope'),
				'id'       => 'widget',
				'content'  => '<p>' . $message . '</p>',
				'callback' => false
			)
		);
 
		$this->admin_screen->set_help_sidebar(
			'<p>Hier findest Du eine Anleitung zum PlugIn &quot;Horoskope&quot; von <a href="http://afilitxt.com" target="_blank">AfiliTxt.com</a>
			<br /><br />Ein Anleitungsvideo findest Du <a href="http://afilitxt.com" target="_blank">HIER</a>
			<br /><br />Weiter Informationen findest Du unter <a href="http://afilitxt.com/horoskope" target="_blank">afilitxt.com/horoskope</a></p>'
		);
	}
}

// new instance
$cAfiliTxtHoroskop = new AfiliTxtHoroskop;
?>