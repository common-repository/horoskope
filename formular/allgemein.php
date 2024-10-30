<h2><a href="<?PHP echo 'http://afilitxt.com'?>" target="_blank"><?PHP echo 'AfiliTxt' ?>-Horoskop Editor</a> <?PHP echo $textCreator->getVersion() ?></h2>
<p>
	<?PHP printf( __( '%s liefert Dir Horoskoptexte als Seite Widget direkt in deinen Blog.', 'horoskope' ), 'AfiliTxt.com' ) ?>
	<?PHP printf( __( 'Nachdem Du einen Zugang bei %s beantragt hast, musst Du die einzelnen Horoskoptypen einlesen.', 'horoskope' ), 'AfiliTxt.com' ) ?>
</p>
<p>
	<?PHP echo __( '<strong>Diese Platzhalter kannst Du in eine Seite einbauen. An dieser Stelle werden alle aktuellen Horoskope angezeigt. Weitere Platzhalter und wichtige Hinweise findest Du in der Hilfe!</strong>', 'horoskope' ) ?>
	<br /><?PHP echo __( 'Liebeshoroskope: <strong><span style="font-size:1.2em">[afilitxt_horoskope_liebe]</span></strong>', 'horoskope' ) ?>
	&nbsp;|&nbsp;<?PHP echo __( 'Partnerhoroskope: <strong><span style="font-size:1.2em">[afilitxt_horoskope_partner]</span></strong>', 'horoskope' ) ?>
	&nbsp;|&nbsp;<?PHP echo __( 'Tageshoroskope: <strong><span style="font-size:1.2em">[afilitxt_horoskope_tag]</span></strong>', 'horoskope' ) ?>
</p>

