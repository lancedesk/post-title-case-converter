<?php
/* AJAX action to update post title */
add_action('wp_ajax_update_post_title', 'ptc_converter_ajax_update_post_title');

function ptc_converter_ajax_update_post_title()
{
    /* Verify the nonce */
    if (!isset($_POST['nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'])), 'ptc_converter_nonce'))
    {
        wp_send_json_error('Invalid nonce');
        wp_die();
    }

    /* Check if required fields are set */
    if (isset($_POST['post_id']) && isset($_POST['converted_title']))
    {
        /* Unslash and sanitize inputs */
        $post_id = isset($_POST['post_id']) ? intval(wp_unslash($_POST['post_id'])) : 0;
        $converted_title = isset($_POST['converted_title']) ? sanitize_text_field(wp_unslash($_POST['converted_title'])) : '';
        $nonce = isset($_POST['nonce']) ? sanitize_text_field(wp_unslash($_POST['nonce'])) : '';

        /* Verify nonce */
        if (!wp_verify_nonce($nonce, 'ptc_converter_nonce')) {
            wp_send_json_error('Invalid nonce');
        }

        /* Check if post ID and title are valid */
        if ($post_id && $converted_title) 
        {
            /* Update the post title */
            $result = wp_update_post(array(
                'ID' => $post_id,
                'post_title' => $converted_title,
            ));

            /* Check if the post was updated successfully */
            if ($result)
            {
                wp_send_json_success(array(
                    'status'  => 'success',
                    'message' => 'Post title updated successfully.'
                ));
            }
            else
            {
                wp_send_json_error(array(
                    'status'  => 'error',
                    'message' => 'Failed to update post title.'
                ));
            }
        }
        else
        {
            wp_send_json_error('Invalid post ID.');
        }
    }
    else
    {
        wp_send_json_error('Required fields are missing.');
    }

    wp_die();
}
