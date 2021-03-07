<?php

register_widget( 'OpenSID_Widget_Perangkat' );

class OpenSID_Widget_Perangkat extends WP_Widget
{

    public function __construct()
    {
        parent::__construct(
            // Base ID of your widget
            'opensid_widget_perangkat',
            // Widget name will appear in UI
            'OpenSID Widget Perangkat',
            // Widget description
            array( 'description' => 'OpenSID: Menampilkan perangkat desa' )
        );
    }

    public function widget( $args, $instance )
    {
        global $OpenSID;
        if ( empty( @$OpenSID ) ) {
            return;
        }
        extract( $args );
        $title = apply_filters( 'widget_title', $instance['title'] );
        echo $before_widget;
        if ( $title ) {
            echo $before_title . $title . $after_title;
        }
        echo '<div class="slider-wrapper">';
        //echo '<a href="#" class="control_next">></a><a href="#" class="control_prev"><</a>';
        echo '<ul class="slider-arrow"><li class="arrow-left" role="button">&lt;</li><li class="arrow-right" role="button">&gt;</li></ul>';
        echo '<ul class="slider-items">';
        foreach ( $OpenSID->listAparat() as $aparat ) {
            printf( '<li>
                    <img class="widget-aparat-foto" src="%s"/>
                    <div class="slider-caption">
                        <span class="widget-aparat-nama">%s</span><br/>
                        <span class="widget-aparat-jabatan">%s</span>
                    </div>
                    </li>', esc_attr( $aparat['foto'] ), esc_html( $aparat['nama'] ), esc_html( $aparat['jabatan'] ) );
        }
        echo '</ul>';
        echo "</div>";

        echo $after_widget;
    }

    function update( $new_instance, $old_instance )
    {
        $instance = $old_instance;
        $instance['title'] = strip_tags( $new_instance['title'] );
        return $instance;
    }

    function form( $instance )
    {
        $title = esc_attr( @$instance['title'] );

        ?>
         <p>
          <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' );?></label>
          <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
        <?php
}

}
