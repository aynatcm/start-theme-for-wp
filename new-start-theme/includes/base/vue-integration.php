<?php

//Add shortcode to render vue on the frontend
function add_vue_calculator()
{
    return '<div id="app-calculator"></div>';
}

add_shortcode('app_calculator', 'add_vue_calculator');


// ruta REST para calculadora
function acf_config_api_route()
{
    register_rest_route('wp/v2', '/calculator_settings', array(
        'methods' => 'GET',
        'callback' => 'get_acf_calculator_options',
    ));
}

add_action('rest_api_init', 'acf_config_api_route');

// Callback para obtener los datos de ACF
function get_acf_calculator_options()
{
    $options = array(
        'title_calculator' => get_field('title_calculator','option'),
        'min_price_for_house' => get_field('min_price_for_house', 'option'),
        'max_price_for_house' => get_field('max_price_for_house', 'option'),
        'min_value_for_down_payment' => get_field('min_value_for_down_payment', 'option'),
        'max_value_for_down_payment' => get_field('max_value_for_down_payment', 'option'),
        'min_annual_interest_rate' => get_field('min_annual_interest_rate', 'option'),
        'max_annual_interest_rate' => get_field('max_annual_interest_rate', 'option'),
        'min_value_for_loan_term' => get_field('min_value_for_loan_term', 'option'),
        'max_value_for_loan_term' => get_field('max_value_for_loan_term', 'option'),
        'commission_percentage' => get_field('commission_percentage', 'option'),
        'svsd_factor' => get_field('svsd_factor', 'option'),
        'biac' => get_field('biac', 'option'),
    );

    return new WP_REST_Response($options, 200);
}


?>