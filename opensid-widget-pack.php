<?php
/**
 * Plugin Name: OpenSID Widget Pack
 * Description: Widget WordPress untuk menampilkan data yang diambil langsung dari web OpenSID.
 * Plugin URI: https://github.com/ndunks/opensid-widget-pack
 * Author: Mochamad Arifin
 * Author URI: http://klampok.id/
 */

define( 'OPENSID_WP_URL', plugins_url( '', __FILE__ ) . '/' );

class OpenSID_Widget_Pack
{
    public static $title = 'OpenSID Widget Pack';
    public static $name = 'opensid_widget_pack';
    public static $version = '1.0.1';
    public static $me = false;

    public function __construct()
    {
        self::$me = &$this;

        add_action( 'init', array( $this, 'init' ) );
        add_action( 'wp_print_scripts', array( $this, 'javascripts' ) );
        add_action( 'wp_print_styles', array( $this, 'stylesheets' ) );
        add_action( 'widgets_init', array( $this, 'widgets_init' ) );
    }

    public function init()
    {
        if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
            wp_register_script( self::$name, OPENSID_WP_URL . 'script.js', ['jquery'], null );
            wp_register_style( self::$name, OPENSID_WP_URL . 'style.css', [], null );
        } else {
            wp_register_script( self::$name, OPENSID_WP_URL . 'script.js', ['jquery'], self::$version );
            wp_register_style( self::$name, OPENSID_WP_URL . 'style.css', [], self::$version );
        }
        if ( !defined( 'OPENSID_KONEKTOR' ) ) {
            add_action( 'admin_notices', [$this, 'notice_no_konektor'] );
        }
    }

    public function widgets_init()
    {
        $widgets_dir = plugin_dir_path( __FILE__ ) . 'widgets/';

        // Keep it simple to make it secure
        include $widgets_dir . 'perangkat.php';
    }

    public function notice_no_konektor()
    {
        ?>
    <div class="error notice">
        <p><?php echo "Harap install plugin <a href=\"https://github.com/ndunks/opensid-konektor\">OpenSID Konektor</a>" ?></p>
    </div>
    <?php
}

    public function javascripts()
    {
        wp_enqueue_script( self::$name );
    }

    public function stylesheets()
    {
        wp_enqueue_style( self::$name );
    }

    public static function run()
    {
        return self::$me ? self::$me : new OpenSID_Widget_Pack();
    }
}

OpenSID_Widget_Pack::run();
