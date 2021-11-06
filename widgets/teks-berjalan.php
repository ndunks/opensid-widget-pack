<?php

register_widget( 'OpenSID_Widget_Teks_Berjalan' );

class OpenSID_Widget_Teks_Berjalan extends WP_Widget
{

    public function __construct()
    {
        $widget_ops = array(
			'classname'                   => 'widget_owp_teks_berjalan',
			'description'                 => __( 'OpenSID: Menampilkan teks berjalan custom HTML atau kategori' ),
			'customize_selective_refresh' => true,
			'show_instance_in_rest'       => true,
		);
        parent::__construct(
            // Base ID of your widget
            'opensid_widget_teks_berjalan',
            // Widget name will appear in UI
            'OpenSID Widget Teks Berjalan',
            // Widget Opts
            $widget_ops
        );
    }

    public function widget( $args, $instance )
    {
        extract( $args );
        $title = apply_filters( 'widget_title', $instance['title'] );
        echo $before_widget;
        if ( $title ) {
            echo $before_title . $title . $after_title;
        }
        echo '<div class="teks-berjalan">';
        echo "<h3>TEKS JALAN</h3>";
        echo '</div>';

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
