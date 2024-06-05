<?php

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

class Open_Whatsapp_Chat_Settings {
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    /**
     * Start up
     */
    public function __construct() {
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );

        $check_position = get_option( 'owc_position' );

        if ( ! isset( $check_position ) || empty( $check_position ) ) {
            update_option( 'owc_position', intval( 1 ) );
        }
    }

    /**
     * Add options page
     */
    public function add_plugin_page() {
        // This page will be under "Settings"
        add_options_page(
            __( 'Settings Admin', 'open-whatsapp-chat' ),
            'Open WhatsApp Chat',
            'manage_options',
            'open-whatsapp-chat',
            array( $this, 'create_admin_page' )
        );
    }

    /**
     * Options page callback
     */
    public function create_admin_page() {
        // Set class property
        $this->options = get_option( 'owc_option' );
        ?>
        <div class="wrap owc-settings-wrap">
            <h1><?php _e( 'Open WhatsApp Chat Plugin Settings', 'open-whatsapp-chat' ); ?></h1>
            <form method="post" action="options.php">
            <?php
                // This prints out all hidden setting fields
                settings_fields( 'owc_option_group' );
                do_settings_sections( 'open-whatsapp-chat' );
                echo '<div class="owc-line">';
                    $text_button = __( 'Save Settings', 'open-whatsapp-chat' );
                    submit_button( $text_button );
                echo '</div>';
            ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function page_init() {
        register_setting(
            'owc_option_group', // Option group
            'owc_option', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            'setting_section_id', // ID
            '', // Title
            '', // Callback
            'open-whatsapp-chat' // Page
        );

        add_settings_field(
            'owc_number', // ID
            __( 'WhatsApp Number', 'open-whatsapp-chat' ), // Title
            array( $this, 'owc_number_callback' ), // Callback
            'open-whatsapp-chat', // Page
            'setting_section_id' // Section
        );

        add_settings_field(
            'owc_message', // ID
            __( 'WhatsApp Message', 'open-whatsapp-chat' ), // Title
            array( $this, 'owc_message_callback' ), // Callback
            'open-whatsapp-chat', // Page
            'setting_section_id' // Section
        );

        add_settings_field(
            'owc_button', // ID
            __( 'WhatsApp Button Text', 'open-whatsapp-chat' ), // Title
            array( $this, 'owc_button_callback' ), // Callback
            'open-whatsapp-chat', // Page
            'setting_section_id' // Section
        );

        add_settings_field(
            'owc_exceptions', // ID
            __( 'Exceptions pages', 'open-whatsapp-chat' ), // Title
            array( $this, 'owc_exceptions_callback' ), // Callback
            'open-whatsapp-chat', // Page
            'setting_section_id' // Section
        );
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input contains all settings fields as array keys
     */
    public function sanitize( $input ) {

        $new_input = array();

        if ( isset( $input['owc_number'] ) ) {
            $new_input['owc_number'] = $this->sanitize_multiline_input( $input['owc_number'] );
        }

        if ( isset( $input['owc_button'] ) )
            $new_input['owc_button'] = sanitize_text_field( $input['owc_button'] );

        if ( isset( $input['owc_message'] ) )
            $new_input['owc_message'] = sanitize_text_field( $input['owc_message'] );

        if ( isset( $input['owc_exceptions'] ) ) {
            $new_input['owc_exceptions'] = $this->sanitize_multiline_input( $input['owc_exceptions'] );
        }

        return $new_input;

    }

    /**
     * Sanitize multiline input (e.g., phone numbers, exception URLs)
     *
     * @param mixed $input
     * @return array
     */
    private function sanitize_multiline_input( $input ) {
        $input_str = '';

        if ( is_string( $input ) ) {
            $input_str = $input;
        } elseif ( is_array( $input ) ) {
            $input_str = implode( "\n", $input );
        }

        $lines = preg_split( '/\r\n|\r|\n/', $input_str );

        $lines = array_map( 'sanitize_text_field', $lines );
        $lines = array_filter( $lines );
        $lines = array_values( $lines );

        return $lines;
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function owc_number_callback() {
        $numbers = isset( $this->options['owc_number'] ) ? $this->options['owc_number'] : array();
        echo '<textarea id="owc_number" name="owc_option[owc_number]">' . implode( "\n", array_map( 'esc_attr', $numbers ) ) . '</textarea>';
        echo '<span class="owc-desc">' . __( 'Only numbers, example 5511988887777. Add one number per line. When adding more than one number, they will be used sequentially.', 'open-whatsapp-chat' ) . '</span>';
    }

    /**
     * Get the settings option array and print one of its values
     * @version     0.0.1
     * @since       25/02/2019
     */
    public function owc_button_callback() {
        printf(
            '<input type="text" id="owc_button" name="owc_option[owc_button]" value="%s" /><span class="owc-desc">' . __( 'Empty for use only the WhatsApp logo.', 'open-whatsapp-chat' ) . '</span>',
            isset( $this->options['owc_button'] ) ? esc_attr( $this->options['owc_button'] ) : ''
        );
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function owc_message_callback() {
        printf(
            '<textarea id="owc_message" name="owc_option[owc_message]">%s</textarea><span class="owc-desc">' . __( 'Shortcuts available: [title] -> print the page or post title.', 'open-whatsapp-chat' ) . '</span>',
            isset( $this->options['owc_message'] ) ? esc_attr( $this->options['owc_message'] ) : ''
        );
    }

    public function owc_exceptions_callback() {
        $exceptions = isset( $this->options['owc_exceptions'] ) ? $this->options['owc_exceptions'] : array();
        echo '<textarea id="owc_exceptions" name="owc_option[owc_exceptions]">' . implode( "\n", array_map( 'esc_attr', $exceptions ) ) . '</textarea>';
        echo '<span class="owc-desc">' . __( 'Add one URL by line.', 'open-whatsapp-chat' ) . '</span>';
    }
}

if ( is_admin() ) {
    $owc_settings_page = new Open_Whatsapp_Chat_Settings();
}
