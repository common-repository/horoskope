<?PHP $a = 2 ?>
<?PHP $settings = $textCreator->getWebmasterSettings() ?>
<div id="CollapsiblePanel2" class="CollapsiblePanel">
  <div class="CollapsiblePanelTab" tabindex="<?PHP echo $a ?>"><h2><?PHP echo __('Webmaster', 'horoskope') ?>:</h2></div>
  <div class="CollapsiblePanelContent" style="padding:5px;">
    <p>
    	<?PHP echo __('In dieser Aufklappkarte beantragst Du deinen pers&ouml;nlichen AfiliTxt- Account und kannst die ersten Horoskope f&uuml;r das PlugIn einlesen.', 'horoskope') ?>
    </p>
    <form method="post">
      <table class="form-table">
        <tr valign="top">
          <td><b><?PHP echo __('Einstellungen', 'horoskope') ?>:</b></td>
        </tr>
        <tr valign="top">
          <td>
            <ul>
              <li><?PHP echo __('Webmaster-ID', 'horoskope') ?>:<br /><input type="text" name="wmid" value="<?PHP echo $settings['wmid'] ? $settings['wmid'] : time() ?>" class=""  style="width:95%" /></li>
              <li><?PHP echo __('Sprache', 'horoskope') ?>:<br />
              	<select name="language" style="width:95%">
									<?PHP 
                    $selected = '';
                    if($settings['language'] == 'de_DE'){
                      $selected = 'selected="selected"';
                    }
                  ?>
  								<option value="de_DE" <?PHP echo $selected ?>>DEUTSCH</option>
								</select>
               </li>
            <ul>
          </td>
        </tr>
				<?PHP if($textCreator->hasUser() && get_option( 'afilitxt-webmaster-settings' )){ ?>
        <tr valign="top">
          <td>
            <ul>
              <li><hr /></li>
              <li><strong><?PHP echo __('Solange hier noch ein Button zu sehen ist, m&uuml;ssen noch Horoskope eingelesen werden! Klicke auf einen der Button, um weitere Horoskope einzulesen.', 'horoskope') ?></strong><br /></li>
              <li>
								<?PHP if(!get_option('horoskop-liebe')){ ?>
                  <input type="submit" name="loadHoroskope" value="<?PHP echo __('Liebeshoroskope', 'horoskope') ?>" class="button-primary" />
                <?PHP	} else { ?>
                	Liebeshoroskope bereits eingelesen |
                <?PHP	} ?>
                <?PHP if(!get_option('horoskop-partner')){ ?>
                  <input type="submit" name="loadHoroskope" value="<?PHP echo __('Partnerhoroskope', 'horoskope') ?>" class="button-primary" />
                <?PHP	} else { ?>
                	Partnerhoroskope bereits eingelesen |
                <?PHP	} ?>
                <?PHP if(!get_option('horoskop-tag')){ ?>
                  <input type="submit" name="loadHoroskope" value="<?PHP echo __('Tageshoroskope', 'horoskope') ?>" class="button-primary" />
                <?PHP	} else { ?>
                	Tageshoroskope bereits eingelesen
                <?PHP	} ?>
              </li>
              <li><hr /></li>
            <ul>
          </td>
        </tr>
        <?PHP	} ?>
      </table>
      <p class="submit" style="text-align: right">
				<?PHP if(!$textCreator->hasUser() || !get_option( 'afilitxt-webmaster-settings' )){ ?>
					<?PHP if( $textCreator->hasUser() ){ ?>
  	      	<input type="submit" name="save_webmaster_settings" value="<?PHP echo __('Grundeinstellungen speichern', 'horoskope') ?>" class="button-primary" />
	        <?PHP	} else { ?>
  	      	<input type="submit" name="save_webmaster_settings" value="<?PHP echo __('Account beantragen', 'horoskope') ?>" class="button-primary" />
	        <?PHP	} ?>
        <?PHP	} else { ?>
	        <input type="submit" name="delete_webmaster_settings" value="<?PHP echo __('Account l&ouml;schen', 'horoskope') ?>" class="button-primary" />
        <?PHP	} ?>
      </p>
    </form>
  </div>
</div>