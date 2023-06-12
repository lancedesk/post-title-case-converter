<?php
// Enqueue necessary scripts for AJAX
function post_case_converter_enqueue_scripts() {
    wp_enqueue_script('jquery');
    wp_enqueue_script('post-case-converter-script', plugin_dir_url(__FILE__) . '../js/scripts.js', array('jquery'));
    wp_localize_script('post-case-converter-script', 'postCaseConverter', array('ajaxUrl' => admin_url('admin-ajax.php')));
    wp_enqueue_style('post-case-converter-style', plugin_dir_url(__FILE__) . '../css/style.css');
}

// Enqueue necessary scripts and styles for the plugin
add_action('admin_enqueue_scripts', 'post_case_converter_enqueue_scripts');

// Function to convert title case
function convert_title_case($title, $case) {
    switch ($case) {
        case 'lowercase':
            return strtolower($title);
        case 'uppercase':
            return strtoupper($title);
        case 'capitalized':
            return ucwords(strtolower($title));
        default:
            return $title;
    }
}