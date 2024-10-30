<?PHP 
preg_match_all( '/(\[afilitxt_horoskope_liebe\])/U', $theContent, $subscan, PREG_SET_ORDER );
if( !empty( $subscan ) ){
  $horoskope = get_option( 'horoskop-liebe' );
	if( get_option( 'afilitxt-webmaster-settings' ) ){
		$outPut = '<div id="horoskop">';
		foreach( $horoskope as $key => $horoskop ){
			$horoskop = str_replace('\"', '"', $horoskop);
			$horoskop = str_replace("\'", "'", $horoskop);
			$outPut .= '<div class="horoskop-row white">';
			$outPut .= '<h3>' . $sternzeichen[$key][0] . '</h3>';
			$outPut .= '<p>' . $horoskop . '</p>';
			$outPut .= '</div>';
		}
		$outPut .= '</div>';
	}
	
  $theContent = preg_replace( '/(\[afilitxt_horoskope_liebe\])/U', $outPut, $theContent );
}

preg_match_all( '/(\[afilitxt_horoskope_liebe_icon\])/U', $theContent, $subscan, PREG_SET_ORDER );
if( !empty( $subscan ) ){
  $horoskope = get_option( 'horoskop-liebe' );
	if( get_option( 'afilitxt-webmaster-settings' ) ){
		$outPut = '<div id="horoskop">';
		foreach( $horoskope as $key => $horoskop ){
			$horoskop = str_replace('\"', '"', $horoskop);
			$horoskop = str_replace("\'", "'", $horoskop);
			$outPut .= '<div class="horoskop-row white">';
			$outPut .= '<h3>' . $sternzeichen[$key][0] . '</h3>';
			$outPut .= '<p><img src="' . TEXTCREATOR_PLUGIN_HOROSKOPE . 'images/post_' . $key . '.png" style="float:left" />' . $horoskop . '</p>';
			$outPut .= '</div>';
		}
		$outPut .= '</div>';
	}
	
  $theContent = preg_replace( '/(\[afilitxt_horoskope_liebe_icon\])/U', $outPut, $theContent );
}

preg_match_all( '/(\[afilitxt_horoskope_partner\])/U', $theContent, $subscan, PREG_SET_ORDER );
if( !empty( $subscan ) ){
  $horoskope = get_option( 'horoskop-partner' );
	if( get_option( 'afilitxt-webmaster-settings' ) ){
		$outPut = '<div id="horoskop">';
		foreach( $horoskope as $key => $horoskop ){
			$horoskop = str_replace('\"', '"', $horoskop);
			$horoskop = str_replace("\'", "'", $horoskop);
			$outPut .= '<div class="horoskop-row white">';
			$outPut .= '<h3>' . $sternzeichen[$key][0] . '</h3>';
			$outPut .= '<p>' . $horoskop . '</p>';
			$outPut .= '</div>';
		}
		$outPut .= '</div>';
	}
	
  $theContent = preg_replace( '/(\[afilitxt_horoskope_partner\])/U', $outPut, $theContent );
}

preg_match_all( '/(\[afilitxt_horoskope_partner_icon\])/U', $theContent, $subscan, PREG_SET_ORDER );
if( !empty( $subscan ) ){
  $horoskope = get_option( 'horoskop-partner' );
	if( get_option( 'afilitxt-webmaster-settings' ) ){
		$outPut = '<div id="horoskop">';
		foreach( $horoskope as $key => $horoskop ){
			$horoskop = str_replace('\"', '"', $horoskop);
			$horoskop = str_replace("\'", "'", $horoskop);
			$outPut .= '<div class="horoskop-row white">';
			$outPut .= '<h3>' . $sternzeichen[$key][0] . '</h3>';
			$outPut .= '<p><img src="' . TEXTCREATOR_PLUGIN_HOROSKOPE . 'images/post_' . $key . '.png" style="float:left" />' . $horoskop . '</p>';
			$outPut .= '</div>';
		}
		$outPut .= '</div>';
	}
	
  $theContent = preg_replace( '/(\[afilitxt_horoskope_partner_icon\])/U', $outPut, $theContent );
}

preg_match_all( '/(\[afilitxt_horoskope_tag\])/U', $theContent, $subscan, PREG_SET_ORDER );
if( !empty( $subscan ) ){
  $horoskope = get_option( 'horoskop-tag' );
	if( get_option( 'afilitxt-webmaster-settings' ) ){
		$outPut = '<div id="horoskop" style="width:100%">';
		foreach( $horoskope as $key => $horoskop ){
			$horoskop = str_replace('\"', '"', $horoskop);
			$horoskop = str_replace("\'", "'", $horoskop);
			$outPut .= '<div class="horoskop-row white">';
			$outPut .= '<h3>' . $sternzeichen[$key][0] . '</h3>';
			$outPut .= '<p>' . $horoskop . '</p>';
			$outPut .= '</div>';
		}
		$outPut .= '</div>';
	}
	
  $theContent = preg_replace( '/(\[afilitxt_horoskope_tag\])/U', $outPut, $theContent );
}

preg_match_all( '/(\[afilitxt_horoskope_tag_icon\])/U', $theContent, $subscan, PREG_SET_ORDER );
if( !empty( $subscan ) ){
  $horoskope = get_option( 'horoskop-tag' );
	if( get_option( 'afilitxt-webmaster-settings' ) ){
		$outPut = '<div id="horoskop" style="width:100%">';
		foreach( $horoskope as $key => $horoskop ){
			$horoskop = str_replace('\"', '"', $horoskop);
			$horoskop = str_replace("\'", "'", $horoskop);
			$outPut .= '<div class="horoskop-row white">';
			$outPut .= '<h3>' . $sternzeichen[$key][0] . '</h3>';
			$outPut .= '<p><img src="' . TEXTCREATOR_PLUGIN_HOROSKOPE . 'images/post_' . $key . '.png" style="float:left" />' . $horoskop . '</p>';
			$outPut .= '</div>';
		}
		$outPut .= '</div>';
	}
	
  $theContent = preg_replace( '/(\[afilitxt_horoskope_tag_icon\])/U', $outPut, $theContent );
}
?>