<?php
// Add menu item to the admin menu
add_action('admin_menu', 'post_case_converter_menu');

function post_case_converter_menu() {
    add_submenu_page(
        'tools.php', // Change the parent menu to Tools
        'Post Case Converter',
        'Post Case Converter',
        'manage_options',
        'post-title-case-converter',
        'post_title_case_converter_page'
    );
}

// Plugin page content
function post_title_case_converter_page() {
    if (isset($_POST['submit'])) {
        $selected_case = $_POST['selected_case'];
        $selected_post_type = $_POST['selected_post_type']; // Get the selected post type
        if (!empty($selected_case)) {
            global $wpdb;
            $posts_table = $wpdb->prefix . 'posts';

            $query = $wpdb->prepare(
				"SELECT ID, post_title FROM $posts_table WHERE post_type = %s AND post_status = 'publish'" . ($selected_case === 'uppercase' ? " AND (post_title REGEXP BINARY '[[:lower:]]' OR post_title REGEXP BINARY '[[:upper:]]')" : "") . ($selected_case === 'capitalized' ? " AND (post_title REGEXP BINARY '[[:lower:]]' OR post_title REGEXP BINARY '[[:upper:]]')" : "") . ($selected_case === 'lowercase' ? " AND (post_title REGEXP BINARY '[[:upper:]]' OR post_title NOT REGEXP BINARY '[[:lower:]]')" : ""),
                $selected_post_type // Use the selected post type in the query
            );
            $results = $wpdb->get_results($query);

            echo '<h2>Convert Post Titles to ' . ucfirst($selected_case) . ' Case</h2>';

            if ($results) {
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
                foreach ($results as $index => $result) {
                    $post_id = $result->ID;
                    $post_title = $result->post_title;
                    $converted_title = convert_title_case($post_title, $selected_case);
                    echo '<tr>';
                    echo '<td>' . ($index + 1) . '</td>';
                    echo '<td>' . $post_title . '</td>';
                    echo '<td>' . $converted_title . '</td>';
                    //echo '<td><button class="update-post-title">Edit</button></td>';
                    echo '<td><button class="update-post-title" data-post-id="' . $post_id . '" data-converted-title="' . $converted_title . '">Edit</button></td>';
                    echo '</tr>';
                }
                echo '</tbody>';
                echo '</table>';
            } else {
                echo '<p>No posts found.</p>';
            }
        }
    } else {
        echo '<h2>Convert Post Titles</h2>';
        echo '<form method="post">';
        echo '<label for="selected_post_type">Select Post Type:</label>'; // Add the post type selection
        echo '<select name="selected_post_type" id="selected_post_type">';
        $post_types = get_post_types(array('public' => true), 'objects');
        foreach ($post_types as $post_type) {
            echo '<option value="' . $post_type->name . '">' . $post_type->label . '</option>';
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