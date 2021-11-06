<?php

//register_widget( 'OpenSID_Widget_Teks_Berjalan' );

register_block_type( 'opensid-widget-pack/teks-berjalan', array(
    'api_version' => 2,
    'editor_script' => OpenSID_Widget_Pack::$name,
    'editor_style' => OpenSID_Widget_Pack::$name,
    'render_callback' => 'opensid_widget_text_berjalan',
    'category' => "widgets",
    "attributes" => [
        "text" => [
            "type" => "string",
            "default" => "Silahkan Ubah Teks",
        ],
        "post_count" => [
            "type" => "number",
            "default" => 5
        ],
        "time" => [
            "type" => "number",
            "default" => 10
        ],
        "post_category" => [
            "type" => "string"
        ],
    ]
    // "supports" => [
    //     "align" => true,
    //     "html" => false
    // ]
) );
 
function opensid_widget_text_berjalan( $attributes, $content, $myblockdefs ) {
    ob_start();
    echo '<div class="widget_opensid_widget_teks_berjalan">';
    echo '<div class="widget_opensid_widget_teks_berjalan_item"
    style="animation : teks_berjalan ' . $attributes['time'] . 's linear infinite;"
    >';
    if( is_string($attributes['text']) ) {
        echo '<b>' . esc_html( $attributes['text'] ) . '</b> ';
    }
    if( is_int($attributes['post_count']) ) {
        $recent_posts = wp_get_recent_posts( array(
            'numberposts' => $attributes['post_count'],
            'post_status' => 'publish',
        ) );
        if ( count( $recent_posts ) > 0 ) {
            foreach ($recent_posts as $key => $post_id) {
                printf(
                    '<a href="%1$s">%2$s</a> ',
                    esc_url( get_permalink( $post_id ) ),
                    esc_html( get_the_title( $post_id ) )
                );
            }
        }
    }
    // echo '<pre>';
    // var_dump($attributes, $content);
    // echo '</pre>';
    echo '</div>';
    echo '</div>';
    return ob_get_clean();
}
