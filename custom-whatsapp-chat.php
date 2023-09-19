<?php
/**
 * Plugin Name: Dynamic WhatsApp Chat Button
 * Description: Adds a WhatsApp chat button to your site with dynamic phone number and button image URL.
 * Version: 1.0
 * Author: Abhinav Saxena
 */

// Register a settings page in the admin dashboard
function whatsapp_chat_button_settings() {
    add_options_page('WhatsApp Chat Button Settings', 'WhatsApp Chat Button', 'manage_options', 'whatsapp-chat-button-settings', 'whatsapp_chat_button_settings_page');
    add_action('admin_init', 'register_whatsapp_chat_button_settings');
}
add_action('admin_menu', 'whatsapp_chat_button_settings');

// Register plugin settings
function register_whatsapp_chat_button_settings() {
    register_setting('whatsapp-chat-button-group', 'whatsapp_phone_number');
    register_setting('whatsapp-chat-button-group', 'whatsapp_button_image_url');
}

// Create the settings page in the admin dashboard
function whatsapp_chat_button_settings_page() {
    ?>
    <div class="wrap">
        <h2>WhatsApp Chat Button Settings</h2>
        <form method="post" action="options.php">
            <?php settings_fields('whatsapp-chat-button-group'); ?>
            <?php do_settings_sections('whatsapp-chat-button-group'); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">WhatsApp Phone Number:</th>
                    <td>
                        <input type="text" name="whatsapp_phone_number" value="<?php echo esc_attr(get_option('whatsapp_phone_number')); ?>" />
                        <p class="description">Enter your WhatsApp phone number with the country code, e.g., +11234567890.</p>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">WhatsApp Button Image URL:</th>
                    <td>
                        <input type="text" name="whatsapp_button_image_url" value="<?php echo esc_attr(get_option('whatsapp_button_image_url')); ?>" />
                        <p class="description">Enter the URL of the WhatsApp button image.</p>
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

// Add WhatsApp button to the footer with CSS
function add_dynamic_whatsapp_button() {
    $phone_number = get_option('whatsapp_phone_number');
    $button_image_url = get_option('whatsapp_button_image_url');

    if (!empty($phone_number) && !empty($button_image_url)) {
        
            // Enqueue the CSS file
            wp_enqueue_style('whatsapp-chat-button-css', plugins_url('css/whatsapp-chat-button.css', __FILE__));
        
        ?>
        <!-- WhatsApp Chat Button -->
        <div id="whatsapp-button">
            <a href="https://api.whatsapp.com/send?phone=<?php echo esc_attr($phone_number); ?>" target="_blank" rel="noopener">
                <img src="<?php echo esc_url($button_image_url); ?>" alt="WhatsApp Chat">
            </a>
        </div>
        <?php
    }
}

// Hook the function to the wp_footer action
add_action('wp_footer', 'add_dynamic_whatsapp_button');
