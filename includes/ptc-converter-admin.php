<?php

/* Add menu item to the admin menu */
add_action('admin_menu', 'ptc_converter_page_menu');

function ptc_converter_page_menu()
{
    add_submenu_page(
        'tools.php',
        'Post Case Converter',
        'Post Case Converter',
        'manage_options',
        'ptc-converter',
        'ptc_converter_page'
    );
}

/* Plugin page content */
function ptc_converter_page()
{
    /* Check if nonce is set and valid */
    if (isset($_POST['ptc_converter_nonce']) && wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['ptc_converter_nonce'])), 'ptc_converter_nonce_action'))
    {
        
        if (isset($_POST['submit'])) {
            /* Sanitize and validate inputs */
            $selected_case = isset($_POST['selected_case']) ? sanitize_text_field(wp_unslash($_POST['selected_case'])) : '';
            $selected_post_type = isset($_POST['selected_post_type']) ? sanitize_text_field(wp_unslash($_POST['selected_post_type'])) : '';

            if (!empty($selected_case))
            {
                $args = array(
                    'post_type'      => $selected_post_type,
                    'post_status'    => 'publish',
                    'posts_per_page' => -1,
                    'fields'         => array('ID', 'post_title')
                );

                $query = new WP_Query($args);

                echo '<h2>Convert Post Titles to ' . esc_html(ucfirst($selected_case)) . ' Case</h2>';

                if ($query->have_posts()) {
                    echo '<table class="post-case-table">';
                    echo '<thead>';
                    echo '<tr>';
                    echo '<th>#</th>';
                    echo '<th>Before Edit</th>';
                    echo '<th>After Edit</th>';
                    echo '<th>Edit</th>';
                    echo '</tr>';
                    echo '</thead>';
                    echo '<tbody>';
                    foreach ($query->posts as $index => $post) {
                        $post_id = $post->ID;
                        $post_title = $post->post_title;
                        $converted_title = convert_title_case($post_title, $selected_case);
                        echo '<tr>';
                        echo '<td>' . esc_html(($index + 1)) . '</td>';
                        echo '<td>' . esc_html($post_title) . '</td>';
                        echo '<td>' . esc_html($converted_title) . '</td>';
                        echo '<td><button class="update-post-title" data-post-id="' . esc_attr($post_id) . '" data-converted-title="' . esc_attr($converted_title) . '">Edit</button></td>';
                        echo '</tr>';
                    }
                    echo '</tbody>';
                    echo '</table>';
                } else {
                    echo '<p>No posts found.</p>';
                }
            }
        }
    } else {
        /* Display the form */
        echo '<h2>Convert Post Titles</h2>';
        echo '<form method="post">';
        wp_nonce_field('ptc_converter_nonce_action', 'ptc_converter_nonce');
        echo '<label for="selected_post_type">Select Post Type:</label>';
        echo '<select name="selected_post_type" id="selected_post_type">';
        $post_types = get_post_types(array('public' => true), 'objects');

        foreach ($post_types as $post_type) {
            echo '<option value="' . esc_attr($post_type->name) . '">' . esc_html($post_type->label) . '</option>';
        }

        echo '</select>';
        echo '<br /><br />';
        echo '<label for="selected_case">Select Case:</label>';
        echo '<select name="selected_case" id="selected_case">';
        echo '<option value="lowercase">Lowercase</option>';
        echo '<option value="uppercase">Uppercase</option>';
        echo '<option value="capitalized">Capitalized</option>';
        echo '</select>';
        echo '<br /><br />';
        echo '<input type="submit" name="submit" value="Convert" />';
        echo '</form>';
    }
}
