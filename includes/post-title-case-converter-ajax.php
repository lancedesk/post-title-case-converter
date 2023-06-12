<?php
// AJAX action to update post title
add_action('wp_ajax_update_post_title', 'post_case_converter_ajax_update_post_title');

function post_case_converter_ajax_update_post_title() {
    if (isset($_POST['post_id']) && isset($_POST['converted_title'])) {
        $post_id = $_POST['post_id'];
        $converted_title = $_POST['converted_title'];

        wp_update_post(array(
            'ID' => $post_id,
            'post_title' => $converted_title,
        ));

        echo 'success';
    }

    wp_die();
}