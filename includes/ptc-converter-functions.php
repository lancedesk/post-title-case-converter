<?php
/* Enqueue necessary scripts for AJAX */
function ptc_converter_enqueue_scripts()
{
    wp_enqueue_script('jquery');
    wp_enqueue_script('ptc_converter-script', plugin_dir_url(__FILE__) . '../js/scripts.js', array('jquery'), null, true);
    wp_enqueue_style('ptc_converter-style', plugin_dir_url(__FILE__) . '../css/style.css');

    /* Localize the script with AJAX URL and nonce */
    wp_localize_script('ptc_converter-script', 'ajax_data', [
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce'   => wp_create_nonce('ptc_converter_nonce')
    ]);
}

/* Enqueue necessary scripts and styles for the plugin */
add_action('admin_enqueue_scripts', 'ptc_converter_enqueue_scripts');

/* Function to convert title case */
function convert_title_case($title, $case)
{
    switch ($case)
    {
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
