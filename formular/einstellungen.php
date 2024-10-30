<div class="wrap">
  <?PHP include_once( dirname(__FILE__) . "/allgemein.php" ) ?>
  <?PHP include_once( dirname(__FILE__) . "/grunddaten.php" ) ?>
  <?PHP include_once( dirname(__FILE__) . "/webmaster.php" ) ?>
</div>
<script type="text/javascript">
	<!--
	var opt = new Array();
	opt['contentIsOpen'] = false;
	var CollapsiblePanel1 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel1", opt);

	opt['contentIsOpen'] = true;
	var CollapsiblePanel<?PHP echo $b ?> = new Spry.Widget.CollapsiblePanel("CollapsiblePanel2", opt);
	//-->
</script>
