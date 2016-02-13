<?php
/*
Plugin Name: Newton Job Board
Description: Quick integration of Newton Job Board.
Version: 0.1.0
Author: Mad Science Dept. MSDLab.com
Author URI: http://msdlab.com
GitHub Plugin URI: https://github.com/msdlab/newton-job-board
GitHub Branch: master
License: GPL v2
*/

if(!class_exists('GitHubPluginUpdater')){
    require_once (plugin_dir_path(__FILE__).'/lib/resource/GitHubPluginUpdater.php');
}

if ( is_admin() ) {
    new GitHubPluginUpdater( __FILE__, 'msdlab', "newton_job_board" );
}


class NewtonJobBoard{
	private $the_path;
	private $the_url;
	public $icon_size;
	function NewtonJobBoard(){$this->__construct();}
    function __construct(){
		$this->the_path = plugin_dir_path(__FILE__);
		$this->the_url = plugin_dir_url(__FILE__);
		/*
		 * Pull in some stuff from other files
		 */
		//$this->requireDir($this->the_path . 'lib/inc');
        require_once($this->the_path . 'lib/inc/settings.php');
        require_once($this->the_path . 'lib/inc/widgets.php');
        wp_register_style('font-awesome-style','//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css');
        add_action('admin_enqueue_scripts', array(&$this,'add_admin_scripts') );
        add_action('admin_enqueue_scripts', array(&$this,'add_admin_styles') );
        // init process for registering our button
         add_action('init', array(&$this,'njb_shortcode_button_init'));
         
        add_shortcode('newton-job-board', array(&$this,'njb_shortcode_handler'));
	}

        function add_admin_scripts() {
            global $current_screen;
            if($current_screen->id == 'settings_page_njb-options'){
                wp_enqueue_script('bootstrap-jquery','//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js',array('jquery'));
                wp_enqueue_script('timepicker-jquery',$this->the_url.'lib/js/jquery.timepicker.min.js',array('jquery'));
            }
        }
        
        function add_admin_styles() {
            global $current_screen;
            if($current_screen->id == 'settings_page_njb-options'){
                wp_register_style('bootstrap-style','//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css');
                wp_register_style('font-awesome-style','//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css',array('bootstrap-style'));
                wp_enqueue_style('font-awesome-style');
            }
            wp_enqueue_style('njb-style',$this->the_url.'lib/css/style.css');
        }  

        function njb_shortcode_button_init() {
        
              //Abort early if the user will never see TinyMCE
              if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') && get_user_option('rich_editing') == 'true')
                   return;
        
              //Add a callback to regiser our tinymce plugin   
              add_filter("mce_external_plugins", array(&$this,'njb_register_tinymce_plugin')); 
        
              // Add a callback to add our button to the TinyMCE toolbar
              add_filter('mce_buttons', array(&$this,'njb_add_tinymce_button'));
        }
        
        
        //This callback registers our plug-in
        function njb_register_tinymce_plugin($plugin_array) {
            $plugin_array['njb_button'] = $this->the_url.'lib/js/njb_tinymce_button.js';
            return $plugin_array;
        }
        
        //This callback adds our button to the toolbar
        function njb_add_tinymce_button($buttons) {
                    //Add the button ID to the $button array
            $buttons[] = "njb_button";
            return $buttons;
        }
        
        //the shortcode hander
        function njb_shortcode_handler($atts = array()){
            extract( shortcode_atts( array(
                'jsid' => 'gnewtonjs',
                'baseurl' => '//newton.newtonsoftware.com/career/iframe.action',
            ), $atts ) );
            $clientid = get_option('njb_clientid');
            $js_string = '
<script id="'.$jsid.'" type="text/javascript" src="'.$baseurl.'?clientId='.$clientid.'"></script>';
            return $js_string;
        }


function requireDir($dir){
	$dh = @opendir($dir);

	if (!$dh) {
		throw new Exception("Cannot open directory $dir");
	} else {
		while (($file = readdir($dh)) !== false) {
			if ($file != '.' && $file != '..') {
				$requiredFile = $dir . DIRECTORY_SEPARATOR . $file;
				if ('.php' === substr($file, strlen($file) - 4)) {
					require_once $requiredFile;
				} elseif (is_dir($requiredFile)) {
					requireDir($requiredFile);
				}
			}
		}
	closedir($dh);
	}
	unset($dh, $dir, $file, $requiredFile);
}
	//end of class
}
$njb = new NewtonJobBoard();