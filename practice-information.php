<?php
/*
Plugin Name: UCMPGS - Practice Info Settings
Description: Doctor Practice Information
Version: 1.0
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
    // Register settings
    register_setting('practice_info_group', 'practice_name');
    register_setting('practice_info_group', 'practice_address');
    register_setting('practice_info_group', 'practice_website');
    register_setting('practice_info_group', 'practice_email');
    register_setting('practice_info_group', 'contact_number');
    register_setting('practice_info_group', 'call_tracking_number');
    register_setting('practice_info_group', 'cta_label');
    register_setting('practice_info_group', 'offer_page_link');

    // Add settings section
    add_settings_section('practice_info_section', 'Practice Information', null, 'practice-info-settings');

    // Add settings fields
    add_settings_field('practice_name', 'Practice Name', [$this, 'render_text_field'], 'practice-info-settings', 'practice_info_section', ['label_for' => 'practice_name']);
    add_settings_field('practice_address', 'Address', [$this, 'render_text_field'], 'practice-info-settings', 'practice_info_section', ['label_for' => 'practice_address']);
    add_settings_field('practice_website', 'Website', [$this, 'render_text_field'], 'practice-info-settings', 'practice_info_section', ['label_for' => 'practice_website']);
    add_settings_field('practice_email', 'Email', [$this, 'render_text_field'], 'practice-info-settings', 'practice_info_section', ['label_for' => 'practice_email']);
    add_settings_field('contact_number', 'Contact Number', [$this, 'render_text_field'], 'practice-info-settings', 'practice_info_section', ['label_for' => 'contact_number']);
    add_settings_field('call_tracking_number', 'Call Tracking Number', [$this, 'render_text_field'], 'practice-info-settings', 'practice_info_section', ['label_for' => 'call_tracking_number']);
    add_settings_field('cta_label', 'CTA Label', [$this, 'render_text_field'], 'practice-info-settings', 'practice_info_section', ['label_for' => 'cta_label']);
    add_settings_field('offer_page_link', 'Offer Page Link', [$this, 'render_text_field'], 'practice-info-settings', 'practice_info_section', ['label_for' => 'offer_page_link']);
  }

  // Render text fields
  public function render_text_field($args)
  {
    $option = get_option($args['label_for']);
    $brick_function = 'get_' . $args['label_for'];
    echo '<input type="text" id="' . esc_attr($args['label_for']) . '" name="' . esc_attr($args['label_for']) . '" value="' . esc_attr($option) . '" />';
    echo '<p><em>Bricks: {echo:' . esc_html($brick_function) . '}</em></p>';
  }

  // Display the settings page content
  public function settings_page_content()
  {
?>
    <div class="wrap">
      <h1>Practice Information Settings</h1>
      <form action="options.php" method="POST">
        <?php
        settings_fields('practice_info_group');
        do_settings_sections('practice-info-settings');
        submit_button();
        ?>
      </form>
    </div>
<?php
  }

  // Retrieve individual field values
  public static function get_practice_name()
  {
    return get_option('practice_name', '');
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
}

// Initialize the plugin
new PracticeInfoSettings();

// Create global wrapper functions
function get_practice_name()
{
  return PracticeInfoSettings::get_practice_name();
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

// Bricks Filter https://academy.bricksbuilder.io/article/filter-bricks-code-echo_function_names/
add_filter('bricks/code/echo_function_names', function () {
  return [
    'get_practice_name',
    'get_practice_address',
    'get_practice_website',
    'get_practice_email',
    'get_contact_number',
    'get_call_tracking_number',
    'get_cta_label',
    'get_offer_page_link',
  ];
});
