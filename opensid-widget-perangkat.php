<?php
/**
 * Plugin Name: OpenSID Widget Perangkat
 * Description: Widget WordPress untuk menampilkan daftar perangkat desa yang diambil langsung dari data aplikasi OpenSID.
 * Plugin URI: https://github.com/ndunks/opensid-widget-perangkat
 * Author: Mochamad Arifin
 * Author URI: http://klampok.id/
 */

define( 'OPENSID_WP_DIR', plugin_dir_path( __FILE__ ) );
define( 'OPENSID_WP_URL', plugins_url( '', __FILE__ ) . '/' );

class OpenSID_Widget_Perangkat
{
    public static $title = 'OpenSID Widget Perangkat';
    public static $name = 'opensid_widget_perangkat';
    public static $version = '1.0.0';
    public static $me = false;

    public function __construct()
    {
        self::$me = &$this;

        add_action( 'init', array( $this, 'init' ) );
        add_action( 'wp_print_scripts', array( $this, 'javascripts' ) );
        add_action( 'wp_print_styles', array( $this, 'stylesheets' ) );
    }

    public function init()
    {
        wp_register_script( 'opensid-widget-perangkat', OPENSID_WP_URL . 'script.js', ['jquery'], self::$version );
        wp_register_style( 'opensid-widget-perangkat', OPENSID_WP_URL . 'style.css', [], self::$version );
        if ( !defined( 'OPENSID_KONEKTOR' ) ) {
            add_action( 'admin_notices', [$this, 'notice_no_konektor'] );
        }
    }

    public function notice_no_konektor()
    {
        ?>
    <div class="error notice">
        <p><?php echo "Harap install plugin OpenSID Konektor."; ?></p>
    </div>
    <?php
}

    public function javascripts()
    {
        wp_enqueue_script( 'opensid-widget-perangkat' );
    }

    public function stylesheets()
    {
        wp_enqueue_style( 'opensid-widget-perangkat' );
    }

    public static function run()
    {
        return self::$me ? self::$me : new OpenSID_Widget_Perangkat();
    }
}

OpenSID_Widget_Perangkat::run();
