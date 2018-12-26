<?php
/*
 * Plugin Name: My Custom Edit
 * Plugin URI: https://minhduongads.com/
 * Author: Thanh Tung
 * Author URI: https://minhduongads.com/
 * Description: Plugin My Custom Edit custom for kiddyacademy.edu.vn
 * Version: 1.0.1
 * Text Domain: nextcore
 */

if ( ! defined( 'ABSPATH' ) ) exit;

class MyCustomEdit{
    private static $instance;
    protected $name = "basespeed";
    protected $repo = "mycustomedit";
    protected $ver = '1.0.1';

    public static function getInstance(){
        if (!isset(self::$instance) && !(self::$instance instanceof MyCustomEdit)) {
            self::$instance = new MyCustomEdit();
            self::$instance->setup();
            self::$instance->EnqueueScript();
            self::$instance->Update();
            self::$instance->Customer();
        }

        return self::$instance;
    }

    public function setup(){
        if (!defined('DIR')) {
            define('DIR', plugin_dir_path(__FILE__));
        }

        if (!defined('URL')) {
            define('URL', plugin_dir_url(__FILE__));
        }
    }

    public function Update(){
        include_once DIR . 'includes/update.php';
        define( 'WP_GITHUB_FORCE_UPDATE', true );
        if (is_admin()) { // note the use of is_admin() to double check that this is happening in the admin
            $config = array(
                'slug' => plugin_basename(__FILE__), // this is the slug of your plugin
                'proper_folder_name' => $this->repo, // this is the name of the folder your plugin lives in
                'api_url' => 'https://api.github.com/repos/'.$this->name.'/'.$this->repo, // the GitHub API url of your GitHub repo
                'raw_url' => 'https://raw.github.com/'.$this->name.'/'.$this->repo.'/master', // the GitHub raw url of your GitHub repo
                'github_url' => 'https://github.com/'.$this->name.'/'.$this->repo, // the GitHub url of your GitHub repo
                'zip_url' => 'https://github.com/'.$this->name.'/'.$this->repo.'/archive/master.zip', // the zip url of the GitHub repo
                'sslverify' => true, // whether WP should check the validity of the SSL cert when getting an update, see https://github.com/jkudish/WordPress-GitHub-Plugin-Updater/issues/2 and https://github.com/jkudish/WordPress-GitHub-Plugin-Updater/issues/4 for details
                'requires' => $this->ver, // which version of WordPress does your plugin require?
                'tested' => $this->ver, // which version of WordPress is your plugin tested up to?
                'readme' => 'README.md', // which file to use as the readme for the version number
                'access_token' => '', // Access private repositories by authorizing under Appearance > GitHub Updates when this example plugin is installed
            );
            new WP_GitHub_Updater($config);
        }
    }

    public function EnqueueScript(){
        /**
         * Never worry about cache again!
         */
        function pure_load_scripts($hook) {

            // create my own version codes
            $pure_js_ver  = date("ymd-Gis", filemtime( plugin_dir_path( __FILE__ ) . 'assets/js/js.js' ));
            $pure_css_ver = date("ymd-Gis", filemtime( plugin_dir_path( __FILE__ ) . 'assets/css/css.css' ));

            //
            wp_enqueue_script( 'pure_js', plugins_url( 'assets/js/js.js', __FILE__ ), array(), $pure_js_ver );
            wp_register_style( 'pure_css',    plugins_url( 'assets/css/css.css',    __FILE__ ), false,   $pure_css_ver );
            wp_enqueue_style ( 'pure_css' );

        }
        add_action('wp_enqueue_scripts', 'pure_load_scripts',100);
    }

    public function Customer(){
        add_action('wp_head',function (){
           echo "<h2 style='position: relative;z-index: 999999999999999999999;color: red;'>Welcome to plugin KiddEdit ver 1.0.1</h2>";
        });
    }


}

function getMyCustomEdit(){
    return MyCustomEdit::getInstance();
}

getMyCustomEdit();









