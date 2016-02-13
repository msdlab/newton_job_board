<?php
/*******************************
  THEME OPTIONS PAGE
********************************/

add_action('admin_menu', 'njb_theme_page');
function njb_theme_page ()
{
	if ( count($_POST) > 0 && isset($_POST['njb_settings']) )
	{
		$options = array (
		'clientid',
        );
		
		foreach ( $options as $opt )
		{
			delete_option ( 'njb_'.$opt, $_POST[$opt] );
			add_option ( 'njb_'.$opt, $_POST[$opt] );	
		}			
		 
	}
	add_menu_page(__('Newton Job Board'),__('Newton Job Board'), 'administrator', 'njb-options', 'njb_settings','dashicons-megaphone');
}
function njb_settings()
{

	?>
<style>
    span.note{
        display: block;
        font-size: 0.9em;
        font-style: italic;
        color: #999999;
    }
    body{
        background-color: transparent;
    }
    .input-table.even{background-color: rgba(0,0,0,0.1);padding: 2rem 0;}
    .input-table .description{display:none}
    .input-table li:after{content:".";display:block;clear:both;visibility:hidden;line-height:0;height:0}
    .input-table label{display:block;font-weight:bold;margin-right:1%;float:left;width:14%;text-align:right}
    .input-table label span{display:inline;font-weight:normal}
    .input-table span{color:#999;display:block}
    .input-table .input{width:85%;float:left}
    .input-table .input .half{width:48%;float:left}
    .input-table textarea,.input-table input[type='text'],.input-table select{display:inline;margin-bottom:3px;width:90%}
    .input-table .mceIframeContainer{background:#fff}
    .input-table h4{color:#999;font-size:1em;margin:15px 6px;text-transform:uppercase}
</style>
<div class="wrap">
	<h2>Newton Job Board Settings</h2>
	
<form method="post" action="">
      <ul class="input-table">
          <li>
              <label for="newton_code">ClientID</label>
              <div class="input">
                <input name="clientid" type="text" id="clientid" value="<?php echo get_option('njb_clientid'); ?>" class="regular-text" />
              </div>
          </li>
      </ul>

	<p class="submit">
	<input type="submit" name="Submit" class="button-primary" value="Save Changes" />
	<input type="hidden" name="njb_settings" value="save" style="display:none;" />
	</p>
</form>
</div>
<?php }