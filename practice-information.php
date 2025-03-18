<?php
/*
Plugin Name: UCMPGS - Practice Info Settings
Description: Doctor Practice Information
Version: 1.2.3
Author: JVA
*/

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

class PracticeInfoSettings
{
  public function __construct()
  {
    add_action('admin_menu', [$this, 'create_settings_page']);
    add_action('admin_init', [$this, 'setup_settings']);
    add_action('admin_enqueue_scripts', [$this, 'enqueue_scripts']);
    add_action('init', [$this, 'register_shortcodes']); // Register shortcodes
  }

  // Create the settings page in the WordPress admin
  public function create_settings_page()
  {
    add_options_page(
      'Practice Info Settings',   // Page title
      'UCMPGS - Practice Info',   // Menu title
      'manage_options',           // Capability
      'practice-info-settings',   // Menu slug
      [$this, 'settings_page_content'] // Function to display the page content
    );
  }

  // Setup settings and sections
  public function setup_settings()
  {
    // Register settings for the first location
    register_setting('practice_info_group', 'doctor_name');
    register_setting('practice_info_group', 'practice_name');
    register_setting('practice_info_group', 'practice_technique');
    register_setting('practice_info_group', 'practice_address');
    register_setting('practice_info_group', 'practice_website');
    register_setting('practice_info_group', 'practice_email');
    register_setting('practice_info_group', 'contact_number');
    register_setting('practice_info_group', 'call_tracking_number');
    register_setting('practice_info_group', 'cta_label');
    register_setting('practice_info_group', 'offer_page_link');
    register_setting('practice_info_group', 'google_map_link');
    register_setting('practice_info_group', 'practice_hours');

    // Register settings for the second location
    register_setting('practice_info_group', 'doctor_name_2');
    register_setting('practice_info_group', 'practice_name_2');
    register_setting('practice_info_group', 'practice_technique_2');
    register_setting('practice_info_group', 'practice_address_2');
    register_setting('practice_info_group', 'practice_website_2');
    register_setting('practice_info_group', 'practice_email_2');
    register_setting('practice_info_group', 'contact_number_2');
    register_setting('practice_info_group', 'call_tracking_number_2');
    register_setting('practice_info_group', 'cta_label_2');
    register_setting('practice_info_group', 'offer_page_link_2');
    register_setting('practice_info_group', 'google_map_link_2');
    register_setting('practice_info_group', 'practice_hours_2');
    register_setting('practice_info_group', 'show_second_location');


    // Register new setting for final contact number option
    register_setting('practice_info_group', 'final_contact_number_option');
    register_setting('practice_info_group', 'final_contact_number_option_2');

    // Add settings section for the first location
    add_settings_section('practice_info_section', 'First Location - Practice Information', null, 'practice-info-settings');

    // Add settings fields for the first location
    add_settings_field('doctor_name', 'Doctor Name', [$this, 'render_text_field'], 'practice-info-settings', 'practice_info_section', ['label_for' => 'doctor_name']);
    add_settings_field('practice_name', 'Practice Name', [$this, 'render_text_field'], 'practice-info-settings', 'practice_info_section', ['label_for' => 'practice_name']);
    add_settings_field('practice_technique', 'Practice Technique', [$this, 'render_text_field'], 'practice-info-settings', 'practice_info_section', ['label_for' => 'practice_technique']);
    add_settings_field('practice_address', 'Address', [$this, 'render_text_field'], 'practice-info-settings', 'practice_info_section', ['label_for' => 'practice_address']);
    add_settings_field('practice_website', 'Website', [$this, 'render_text_field'], 'practice-info-settings', 'practice_info_section', ['label_for' => 'practice_website']);
    add_settings_field('practice_email', 'Email', [$this, 'render_text_field'], 'practice-info-settings', 'practice_info_section', ['label_for' => 'practice_email']);
    add_settings_field('contact_number', 'Contact Number', [$this, 'render_text_field'], 'practice-info-settings', 'practice_info_section', ['label_for' => 'contact_number']);
    add_settings_field('call_tracking_number', 'Call Tracking Number', [$this, 'render_text_field'], 'practice-info-settings', 'practice_info_section', ['label_for' => 'call_tracking_number']);
    add_settings_field('cta_label', 'CTA Label', [$this, 'render_text_field'], 'practice-info-settings', 'practice_info_section', ['label_for' => 'cta_label']);
    add_settings_field('offer_page_link', 'Offer Page Link', [$this, 'render_text_field'], 'practice-info-settings', 'practice_info_section', ['label_for' => 'offer_page_link']);
    add_settings_field('google_map_link', 'Google Map Link', [$this, 'render_text_field'], 'practice-info-settings', 'practice_info_section', ['label_for' => 'google_map_link']);
    add_settings_field('practice_hours', 'Practice Hours', [$this, 'render_wysiwyg_field'], 'practice-info-settings', 'practice_info_section', ['label_for' => 'practice_hours']);

    add_settings_field('final_contact_number_option', 'Final Contact Number', [$this, 'render_contact_selection_field'], 'practice-info-settings', 'practice_info_section', ['label_for' => 'final_contact_number_option']);
    // Add settings section for the second location
    add_settings_section('practice_info_section_2', 'Second Location - Practice Information', null, 'practice-info-settings2');

    add_settings_field('show_second_location', 'Show Second Location', [$this, 'render_toggle_field'], 'practice-info-settings', 'practice_info_section', ['label_for' => 'show_second_location']);
    // Add settings fields for the second location
    add_settings_field('doctor_name_2', 'Doctor Name', [$this, 'render_text_field'], 'practice-info-settings2', 'practice_info_section_2', ['label_for' => 'doctor_name_2']);
    add_settings_field('practice_name_2', 'Practice Name', [$this, 'render_text_field'], 'practice-info-settings2', 'practice_info_section_2', ['label_for' => 'practice_name_2']);
    add_settings_field('practice_technique_2', 'Practice Technique', [$this, 'render_text_field'], 'practice-info-settings2', 'practice_info_section_2', ['label_for' => 'practice_technique_2']);
    add_settings_field('practice_address_2', 'Address', [$this, 'render_text_field'], 'practice-info-settings2', 'practice_info_section_2', ['label_for' => 'practice_address_2']);
    add_settings_field('practice_website_2', 'Website', [$this, 'render_text_field'], 'practice-info-settings2', 'practice_info_section_2', ['label_for' => 'practice_website_2']);
    add_settings_field('practice_email_2', 'Email', [$this, 'render_text_field'], 'practice-info-settings2', 'practice_info_section_2', ['label_for' => 'practice_email_2']);
    add_settings_field('contact_number_2', 'Contact Number', [$this, 'render_text_field'], 'practice-info-settings2', 'practice_info_section_2', ['label_for' => 'contact_number_2']);
    add_settings_field('call_tracking_number_2', 'Call Tracking Number', [$this, 'render_text_field'], 'practice-info-settings2', 'practice_info_section_2', ['label_for' => 'call_tracking_number_2']);
    add_settings_field('cta_label_2', 'CTA Label', [$this, 'render_text_field'], 'practice-info-settings2', 'practice_info_section_2', ['label_for' => 'cta_label_2']);
    add_settings_field('offer_page_link_2', 'Offer Page Link', [$this, 'render_text_field'], 'practice-info-settings2', 'practice_info_section_2', ['label_for' => 'offer_page_link_2']);
    add_settings_field('google_map_link_2', 'Google Map Link', [$this, 'render_text_field'], 'practice-info-settings2', 'practice_info_section_2', ['label_for' => 'google_map_link_2']);
    add_settings_field('practice_hours_2', 'Practice Hours', [$this, 'render_wysiwyg_field2'], 'practice-info-settings2', 'practice_info_section_2', ['label_for' => 'practice_hours_2']);

    // Add new field for contact number selection
    add_settings_field('final_contact_number_option_2', 'Final Contact Number', [$this, 'render_contact_selection_field2'], 'practice-info-settings2', 'practice_info_section_2', ['label_for' => 'final_contact_number_option_2']);
  }

  public function render_contact_selection_field($args)
  {
    $option = get_option($args['label_for'], 'contact_number'); // Default to regular contact number
?>
    <select id="<?php echo esc_attr($args['label_for']); ?>" name="<?php echo esc_attr($args['label_for']); ?>">
      <option value="contact_number" <?php selected($option, 'contact_number'); ?>>Regular Contact Number</option>
      <option value="call_tracking_number" <?php selected($option, 'call_tracking_number'); ?>>Call Tracking Number</option>
    </select>
    <p><em>Bricks: {echo:get_final_contact_number}</em></p>
    <p><em>Oxygen: [oxygen data="phpfunction" function="get_final_contact_number"]</em></p>
    <p><em>Shortcode: [get_final_contact_number]</em></p>
  <?php
  }

  public function render_contact_selection_field2($args)
  {
    $option = get_option($args['label_for'], 'contact_number_2'); // Default to regular contact number
  ?>
    <select id="<?php echo esc_attr($args['label_for']); ?>" name="<?php echo esc_attr($args['label_for']); ?>">
      <option value="contact_number_2" <?php selected($option, 'contact_number_2'); ?>>Regular Contact Number</option>
      <option value="call_tracking_number_2" <?php selected($option, 'call_tracking_number_2'); ?>>Call Tracking Number</option>
    </select>
    <p><em>Bricks: {echo:get_final_contact_number_2}</em></p>
    <p><em>Oxygen: [oxygen data="phpfunction" function="get_final_contact_number_2"]</em></p>
    <p><em>Shortcode: [get_final_contact_number_2]</em></p>
  <?php
  }

  public function render_wysiwyg_field($args)
  {
    $option = get_option($args['label_for'], '');
    $brick_function = 'get_' . $args['label_for'];
    wp_editor($option, esc_attr($args['label_for']), [
      'textarea_name' => esc_attr($args['label_for']),
      'media_buttons' => true,
      'teeny'         => false,
      'quicktags'     => true,
      'editor_css'    => '<style>.wp-editor-container { max-width: 600px; } </style>',
      'textarea_rows' => 10,
    ]);
    echo '<p><em>Bricks: {echo:' . esc_html($brick_function) . '}</em></p>';
    echo '<p><em>Oxygen: [oxygen data="phpfunction" function="' . esc_html($brick_function) . '"] </em></p>';
    echo '<p><em>Shortcode: [' . esc_html($brick_function) . '] </em></p>';
  }

  public function render_wysiwyg_field2($args)
  {
    $option = get_option($args['label_for'], '');
    $brick_function = 'get_' . $args['label_for'];
    wp_editor($option, esc_attr($args['label_for']), [
      'textarea_name' => esc_attr($args['label_for']),
      'media_buttons' => true,
      'teeny'         => false,
      'quicktags'     => true,
      'editor_css'    => '<style>.wp-editor-container { max-width: 600px; } </style>',
      'textarea_rows' => 10,
    ]);
    echo '<p><em>Bricks: {echo:' . esc_html($brick_function) . '}</em></p>';
    echo '<p><em>Oxygen: [oxygen data="phpfunction" function="' . esc_html($brick_function) . '"] </em></p>';
    echo '<p><em>Shortcode: [' . esc_html($brick_function) . '] </em></p>';
  }

  public static function get_final_contact_number()
  {
    $selected_option = get_option('final_contact_number_option', 'contact_number'); // Default to regular contact number
    return get_option($selected_option, '');
  }

  public static function get_final_contact_number_2()
  {
    $selected_option = get_option('final_contact_number_option_2', 'contact_number_2'); // Default to regular contact number
    return get_option($selected_option, '');
  }


  // Render text fields
  public function render_text_field($args)
  {
    $option = get_option($args['label_for']);
    $brick_function = 'get_' . $args['label_for'];
    echo '<input type="text" id="' . esc_attr($args['label_for']) . '" name="' . esc_attr($args['label_for']) . '" value="' . esc_attr($option) . '" />';
    echo '<p><em>Bricks: {echo:' . esc_html($brick_function) . '}</em></p>';
    echo '<p><em>Oxygen: [oxygen data="phpfunction" function="' . esc_html($brick_function) . '"] </em></p>';
    echo '<p><em>Shortcode: [' . esc_html($brick_function) . '] </em></p>';
  }

  public function render_toggle_field($args)
  {
    $option = get_option($args['label_for'], false);
    echo '<input type="checkbox" id="' . esc_attr($args['label_for']) . '" name="' . esc_attr($args['label_for']) . '" ' . checked($option, 'on', '') . ' />';
    echo '<label for="' . esc_attr($args['label_for']) . '">Enable Second Location</label>';
    echo $option;
  }


  public function settings_page_content()
  {
  ?>
    <div class="wrap">
      <h1>Practice Information Settings</h1>
      <form action="options.php" method="POST">
        <?php
        settings_fields('practice_info_group');
        do_settings_sections('practice-info-settings');

        // Render the second location section only if the toggle is enabled

        ?>
        <div id="practice-info-settings-2">
          <?php
          // if (get_option('show_second_location', false)) {
          do_settings_sections('practice-info-settings2');
          // }
          ?>
        </div>
        <?php

        submit_button();
        ?>
      </form>
    </div>
<?php
  }

  public function enqueue_scripts()
  {
    wp_enqueue_script('practice-info-toggle', plugins_url('js/toggle.js', __FILE__), ['jquery'], '1.0', true);
  }

  // Retrieve individual field values for the first location
  public static function get_practice_name()
  {
    return get_option('practice_name', '');
  }

  public static function get_practice_technique()
  {
    return get_option('practice_technique', '');
  }

  public static function get_doctor_name()
  {
    return get_option('doctor_name', '');
  }

  public static function get_practice_address()
  {
    return get_option('practice_address', '');
  }

  public static function get_practice_website()
  {
    return get_option('practice_website', '');
  }

  public static function get_practice_email()
  {
    return get_option('practice_email', '');
  }

  public static function get_contact_number()
  {
    return get_option('contact_number', '');
  }

  public static function get_call_tracking_number()
  {
    return get_option('call_tracking_number', '');
  }

  public static function get_cta_label()
  {
    return get_option('cta_label', '');
  }

  public static function get_offer_page_link()
  {
    return get_option('offer_page_link', '');
  }

  public static function get_google_map_link()
  {
    return get_option('google_map_link', '');
  }

  public static function get_practice_hours()
  {
    return get_option('practice_hours', '');
  }

  // Retrieve individual field values for the second location
  public static function get_practice_name_2()
  {
    return get_option('practice_name_2', '');
  }

  public static function get_practice_technique_2()
  {
    return get_option('practice_technique_2', '');
  }

  public static function get_doctor_name_2()
  {
    return get_option('doctor_name_2', '');
  }

  public static function get_practice_address_2()
  {
    return get_option('practice_address_2', '');
  }

  public static function get_practice_website_2()
  {
    return get_option('practice_website_2', '');
  }

  public static function get_practice_email_2()
  {
    return get_option('practice_email_2', '');
  }

  public static function get_contact_number_2()
  {
    return get_option('contact_number_2', '');
  }

  public static function get_call_tracking_number_2()
  {
    return get_option('call_tracking_number_2', '');
  }

  public static function get_cta_label_2()
  {
    return get_option('cta_label_2', '');
  }

  public static function get_offer_page_link_2()
  {
    return get_option('offer_page_link_2', '');
  }

  public static function get_google_map_link_2()
  {
    return get_option('google_map_link_2', '');
  }

  public static function get_practice_hours_2()
  {
    return get_option('practice_hours_2', '');
  }

  // Register shortcodes
  public function register_shortcodes()
  {
    add_shortcode('get_practice_name', [$this, 'shortcode_practice_name']);
    add_shortcode('get_doctor_name', [$this, 'shortcode_doctor_name']);
    add_shortcode('get_practice_technique', [$this, 'shortcode_practice_technique']);
    add_shortcode('get_practice_address', [$this, 'shortcode_practice_address']);
    add_shortcode('get_practice_website', [$this, 'shortcode_practice_website']);
    add_shortcode('get_practice_email', [$this, 'shortcode_practice_email']);
    add_shortcode('get_contact_number', [$this, 'shortcode_contact_number']);
    add_shortcode('get_call_tracking_number', [$this, 'shortcode_call_tracking_number']);
    add_shortcode('get_cta_label', [$this, 'shortcode_cta_label']);
    add_shortcode('get_offer_page_link', [$this, 'shortcode_offer_page_link']);
    add_shortcode('get_google_map_link', [$this, 'shortcode_google_map_link']);
    add_shortcode('get_practice_hours', [$this, 'shortcode_practice_hours']);
    add_shortcode('get_final_contact_number', [$this, 'shortcode_final_contact_number']);

    add_shortcode('get_practice_name_2', [$this, 'shortcode_practice_name_2']);
    add_shortcode('get_doctor_name_2', [$this, 'shortcode_doctor_name_2']);
    add_shortcode('get_practice_technique_2', [$this, 'shortcode_practice_technique_2']);
    add_shortcode('get_practice_address_2', [$this, 'shortcode_practice_address_2']);
    add_shortcode('get_practice_website_2', [$this, 'shortcode_practice_website_2']);
    add_shortcode('get_practice_email_2', [$this, 'shortcode_practice_email_2']);
    add_shortcode('get_contact_number_2', [$this, 'shortcode_contact_number_2']);
    add_shortcode('get_call_tracking_number_2', [$this, 'shortcode_call_tracking_number_2']);
    add_shortcode('get_cta_label_2', [$this, 'shortcode_cta_label_2']);
    add_shortcode('get_offer_page_link_2', [$this, 'shortcode_offer_page_link_2']);
    add_shortcode('get_google_map_link_2', [$this, 'shortcode_google_map_link_2']);
    add_shortcode('get_practice_hours_2', [$this, 'shortcode_practice_hours_2']);
    add_shortcode('get_final_contact_number_2', [$this, 'shortcode_final_contact_number_2']);
  }

  // Shortcode callback functions for the first location
  public function shortcode_practice_name()
  {
    return $this->get_practice_name();
  }

  public function shortcode_doctor_name()
  {
    return $this->get_doctor_name();
  }

  public function shortcode_practice_technique()
  {
    return $this->get_practice_technique();
  }

  public function shortcode_practice_address()
  {
    return $this->get_practice_address();
  }

  public function shortcode_practice_website()
  {
    return $this->get_practice_website();
  }

  public function shortcode_practice_email()
  {
    return $this->get_practice_email();
  }

  public function shortcode_contact_number()
  {
    return $this->get_contact_number();
  }

  public function shortcode_call_tracking_number()
  {
    return $this->get_call_tracking_number();
  }

  public function shortcode_cta_label()
  {
    return $this->get_cta_label();
  }

  public function shortcode_offer_page_link()
  {
    return $this->get_offer_page_link();
  }

  public function shortcode_google_map_link()
  {
    return $this->get_google_map_link();
  }

  public function shortcode_practice_hours()
  {
    return $this->get_practice_hours();
  }

  public function shortcode_final_contact_number()
  {
    return $this->get_final_contact_number();
  }

  // Shortcode callback functions for the second location
  public function shortcode_practice_name_2()
  {
    return $this->get_practice_name_2();
  }

  public function shortcode_doctor_name_2()
  {
    return $this->get_doctor_name_2();
  }

  public function shortcode_practice_technique_2()
  {
    return $this->get_practice_technique_2();
  }

  public function shortcode_practice_address_2()
  {
    return $this->get_practice_address_2();
  }

  public function shortcode_practice_website_2()
  {
    return $this->get_practice_website_2();
  }

  public function shortcode_practice_email_2()
  {
    return $this->get_practice_email_2();
  }

  public function shortcode_contact_number_2()
  {
    return $this->get_contact_number_2();
  }

  public function shortcode_call_tracking_number_2()
  {
    return $this->get_call_tracking_number_2();
  }

  public function shortcode_cta_label_2()
  {
    return $this->get_cta_label_2();
  }

  public function shortcode_offer_page_link_2()
  {
    return $this->get_offer_page_link_2();
  }

  public function shortcode_google_map_link_2()
  {
    return $this->get_google_map_link_2();
  }

  public function shortcode_practice_hours_2()
  {
    return $this->get_practice_hours_2();
  }

  public function shortcode_final_contact_number_2()
  {
    return $this->get_final_contact_number_2();
  }
}

// Initialize the plugin
new PracticeInfoSettings();

// Create global wrapper functions for the first location
function get_practice_name()
{
  return PracticeInfoSettings::get_practice_name();
}

function get_doctor_name()
{
  return PracticeInfoSettings::get_doctor_name();
}

function get_practice_technique()
{
  return PracticeInfoSettings::get_practice_technique();
}

function get_practice_address()
{
  return PracticeInfoSettings::get_practice_address();
}

function get_practice_website()
{
  return PracticeInfoSettings::get_practice_website();
}

function get_practice_email()
{
  return PracticeInfoSettings::get_practice_email();
}

function get_contact_number()
{
  return PracticeInfoSettings::get_contact_number();
}

function get_call_tracking_number()
{
  return PracticeInfoSettings::get_call_tracking_number();
}

function get_cta_label()
{
  return PracticeInfoSettings::get_cta_label();
}

function get_offer_page_link()
{
  return PracticeInfoSettings::get_offer_page_link();
}

function get_google_map_link()
{
  return PracticeInfoSettings::get_google_map_link();
}

function get_practice_hours()
{
  return PracticeInfoSettings::get_practice_hours();
}

function get_final_contact_number()
{
  return PracticeInfoSettings::get_final_contact_number();
}

// Create global wrapper functions for the second location
function get_practice_name_2()
{
  return PracticeInfoSettings::get_practice_name_2();
}

function get_doctor_name_2()
{
  return PracticeInfoSettings::get_doctor_name_2();
}

function get_practice_technique_2()
{
  return PracticeInfoSettings::get_practice_technique_2();
}

function get_practice_address_2()
{
  return PracticeInfoSettings::get_practice_address_2();
}

function get_practice_website_2()
{
  return PracticeInfoSettings::get_practice_website_2();
}

function get_practice_email_2()
{
  return PracticeInfoSettings::get_practice_email_2();
}

function get_contact_number_2()
{
  return PracticeInfoSettings::get_contact_number_2();
}

function get_call_tracking_number_2()
{
  return PracticeInfoSettings::get_call_tracking_number_2();
}

function get_cta_label_2()
{
  return PracticeInfoSettings::get_cta_label_2();
}

function get_offer_page_link_2()
{
  return PracticeInfoSettings::get_offer_page_link_2();
}

function get_google_map_link_2()
{
  return PracticeInfoSettings::get_google_map_link_2();
}

function get_practice_hours_2()
{
  return PracticeInfoSettings::get_practice_hours_2();
}

function get_final_contact_number_2()
{
  return PracticeInfoSettings::get_final_contact_number_2();
}

// Bricks Filter https://academy.bricksbuilder.io/article/filter-bricks-code-echo_function_names/
add_filter('bricks/code/echo_function_names', function () {
  return [
    'get_practice_name',
    'get_doctor_name',
    'get_practice_technique',
    'get_practice_address',
    'get_practice_website',
    'get_practice_email',
    'get_contact_number',
    'get_call_tracking_number',
    'get_cta_label',
    'get_offer_page_link',
    'get_google_map_link',
    'get_final_contact_number',
    'get_practice_hours',
    'get_practice_name_2',
    'get_doctor_name_2',
    'get_practice_technique_2',
    'get_practice_address_2',
    'get_practice_website_2',
    'get_practice_email_2',
    'get_contact_number_2',
    'get_call_tracking_number_2',
    'get_cta_label_2',
    'get_offer_page_link_2',
    'get_google_map_link_2',
    'get_practice_hours_2',
    'get_final_contact_number_2',
  ];
});
