<div id="CollapsiblePanel1" class="CollapsiblePanel">
  <div class="CollapsiblePanelTab" tabindex="0">
    <h2>
      <?PHP echo __( 'ACCOUNT', 'horoskope' ) ?>: <?PHP echo $textCreator->hasUser() ? $textCreator->getUserId() : '' ?> 
      <?php if( TEXTCREATOR_HOROSKOPE_GUTHABEN ){ ?>
        <?PHP printf( __( 'Dein Guthaben %s W&ouml;rter &uuml;ber 4 Buchstaben', 'horoskope' ), get_option( 'afilitxt-guthaben' ) ) ?>
      <?php } ?>
    </h2>
  </div>
  <div class="CollapsiblePanelContent" style="padding:5px;">
		<?PHP if( TEXTCREATOR_HOROSKOPE_GUTHABEN ){ ?>
    <p>
      <?PHP echo __( 'Damit Texte in deinen Blog geladen werden k&ouml;nnen, musst Du ein ein positives Guthaben bei AfiliTxt haben.', 'horoskope' ) ?>
      <?PHP echo __( 'Du kannst dein Guthaben auf der Seite von <a href="http://www.afilitxt.com/webmaster" target="_blank">AfiliTxt</a> aufladen.', 'horoskope' ) ?>
    </p>
    <?php } ?>
    <form method="post">
      <table class="form-table">
        <tr valign="top">
          <td><b><?PHP echo __( 'IP-Adresse', 'horoskope' ) ?></b></td>
          <td><b><?PHP echo __( 'ID', 'horoskope' ) ?></b></td>
          <td><b><?PHP echo __( 'Kennwort', 'horoskope' ) ?></b></td>
        </tr>
        <tr valign="top">
          <td><b><input type="text" name="ip" value="<?PHP echo $_SERVER['REMOTE_ADDR'] ?>" style="width:95%" readonly="readonly"></b></td>
          <td><b><input type="text" name="id" value="<?PHP echo $textCreator->getUserId() ?>" style="width:95%" readonly="readonly"></b></td>
          <td><b><input type="text" name="kennwort" value="<?PHP echo $textCreator->getKennwort() ?>" style="width:95%" readonly="readonly"></b></td>
        </tr>
      </table>
    </form>
  </div>
</div>