<?php

register_widget( 'OpenSID_Widget_Perangkat_Widget' );

class OpenSID_Widget_Perangkat_Widget extends WP_Widget
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
        var_dump( $OpenSID->listAparat() );
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
