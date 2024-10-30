<?PHP 
if( !function_exists( 'loadHeaderHoroskope' ) ){
	function loadHeaderHoroskope(){
		$data_js = 'js/spry/SpryCollapsiblePanel.js';
		$data_css = 'js/spry/SpryCollapsiblePanel.css';
		if ( file_exists( WP_PLUGIN_DIR . '/horoskope/' . $data_js ) ){
			wp_register_script( 'SpryCollapsiblePanel.js', TEXTCREATOR_PLUGIN_HOROSKOPE . $data_js, array('jquery'), '1.0.2' );
			wp_enqueue_script( 'SpryCollapsiblePanel.js' );
		}
		if ( file_exists( WP_PLUGIN_DIR . '/horoskope/' . $data_css ) ){
			wp_register_style( 'SpryCollapsiblePanel.css', TEXTCREATOR_PLUGIN_HOROSKOPE . $data_css, array(), '1.0.1' );
			wp_enqueue_style( 'SpryCollapsiblePanel.css' );
		}
	}
}
if( !defined( 'TEXTCREATOR_PLUGIN_HOROSKOPE' ) ){
	define( 'TEXTCREATOR_PLUGIN_HOROSKOPE', plugin_dir_url( __FILE__ ) );
}
if( !defined( 'TEXTCREATOR_HOROSKOPE_GUTHABEN' ) ){
	define( 'TEXTCREATOR_HOROSKOPE_GUTHABEN', FALSE );
}
if( !defined('TEXTCREATOR_AFFILIATE' ) ){
	define( 'TEXTCREATOR_AFFILIATE', 'Horoskope' );
}
if( !defined('TEXTCREATOR_AFFILIATE_URL' ) ){
	define( 'TEXTCREATOR_AFFILIATE_URL', 'http://www.afilitxt.com' );
}
if( !defined('TEXTCREATOR_DATA_SERVER' ) ){
	define( 'TEXTCREATOR_DATA_SERVER', 'txttool.afilitxt.com' );
}

$locale = get_locale();
$locale_file = TEXTCREATOR_PLUGIN_HOROSKOPE . "languages/$locale.php";
if ( is_readable( $locale_file ) )
	require_once( $locale_file );
	
add_action( 'admin_enqueue_scripts', 'loadHeaderHoroskope' );
?>