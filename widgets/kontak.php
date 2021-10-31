<?php

register_widget( 'OpenSID_Widget_Kontak' );

class OpenSID_Widget_Kontak extends WP_Widget
{
    static $default_value = [
        'title' => 'Kontak Desa',
        'whatsapp' => '0857XXXXXXXX',
        'telepon' => '021XXXXXX',
        'email' => 'admin@contoh.com',
        'facebook_link' => 'https://www.facebook.com/',
        'facebook_name' => 'Facebook',
        'youtube_link' => 'https://www.youtube.com/',
        'youtube_name' => 'Youtube',
        'instagram_link' => 'https://www.instagram.com/',
        'instagram_name' => 'Instagram',
    ];

    public function __construct()
    {
        parent::__construct(
            // Base ID of your widget
            'opensid_widget_kontak',
            // Widget name will appear in UI
            'OpenSID Widget Kontak',
            // Widget description
            array( 'description' => 'OpenSID: Menampilkan kontak desa' )
        );
    }


    public function widget( $args, $instance )
    {
        global $OpenSID;
        if ( empty( @$OpenSID ) ) {
            return;
        }
        if(empty(@$instance['configured'])){
            $instance = self::$default_value;
        }
        extract($instance);
        $title = apply_filters( 'widget_title', $title );

        echo $args['before_widget'];
        echo '<ul class="list-group">';
        if ( $title ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }

        if( !empty($whatsapp) ){ ?>
            <li class="list-group-item">
                <a
                    style="color: #18af63"
                    href="https://api.whatsapp.com/send?phone=<?php echo esc_attr( $whatsapp ); ?>"
                    target="_BLANK">
                        <i class="bi-whatsapp"></i>
                        <?php echo esc_html( $whatsapp ); ?>
                </a>
            </li>
        <?php }
        
        if( !empty($telepon) ){ ?>
            <li class="list-group-item">
                <a
                    style="color: #0098a1"
                    href="tel:<?php echo esc_attr( $telepon ); ?>"
                    target="_BLANK">
                        <i class="bi-telephone"></i>
                        <?php echo esc_html( $telepon ); ?>
                </a>
            </li>
        <?php }

        if(!empty($email)){ ?>
            <li class="list-group-item">
                <a
                    style="color: #ef5f5f"
                    href="mailto:<?php echo esc_attr( $email ); ?>"
                    target="_BLANK">
                        <i class="bi-envelope"></i>
                        <?php echo esc_html( $email ); ?>
                </a>
            </li>
        <?php }
        
        if(!empty($facebook_link)){ ?>
            <li class="list-group-item">
                <a
                    style="color: #176cab"
                    href="<?php echo esc_url( $facebook_link ); ?>"
                    target="_BLANK">
                        <i class="bi-facebook"></i>
                        <?php echo esc_html( $facebook_name ?: self::$default_value['facebook_name'] ); ?>
                </a>
            </li>
        <?php }
        
        if(!empty($youtube_link)){ ?>
            <li class="list-group-item">
                <a
                    style="color: #f90000"
                    href="<?php echo esc_url( $youtube_link ); ?>"
                    target="_BLANK">
                        <i class="bi-youtube"></i>
                        <?php echo esc_html( $youtube_name ?: self::$default_value['youtube_name'] ); ?>
                </a>
            </li>
        <?php }
        
        if(!empty($instagram_link)){ ?>
            <li class="list-group-item">
                <a
                    style="color: #d50778"
                    href="<?php echo esc_url( $instagram_link ); ?>"
                    target="_BLANK">
                        <i class="bi-instagram"></i>
                        <?php echo esc_html( $instagram_name ?: self::$default_value['instagram_name'] ); ?>
                </a>
            </li>
        <?php }

        echo '</ul>';
        echo $args['after_widget'];
    }

    function update( $new_instance, $old_instance )
    {
        $new_instance['configured'] = true;
        return $new_instance;
    }

    function form( $instance )
    {
        if( !@$instance['configured'] ){
            $instance = self::$default_value;
        }

        foreach( array_keys(self::$default_value) as $key ){
            $label = ucwords( str_replace('_', ' ', $key) );
            $id = $this->get_field_id( $key );
            $name = $this->get_field_name( $key );
            $value = esc_attr( @$instance[$key] );
            ?>
                <p>
                    <label for="<?php echo $id; ?>"><?php _e( "$label:" ); ?></label>
                    <input class="widefat"
                        id="<?php echo $id; ?>"
                        name="<?php echo $name; ?>"
                        type="text"
                        value="<?php echo $value; ?>" />
                </p>
            <?php
        }
    }
}
