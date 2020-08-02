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
            'owc_button', // ID
            __( 'WhatsApp Button Text', 'open-whatsapp-chat' ), // Title 
            array( $this, 'owc_button_callback' ), // Callback
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
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input contains all settings fields as array keys
     */
    public function sanitize( $input ) {
        
        $new_input = array();

        $check_position = get_option( 'owc_option' );
        $check_position = $check_position['owc_position'];

        if ( ! isset( $check_position ) || empty( $check_position ) ) {
            $new_input['owc_position'] = '0';
        }

        if ( isset( $input['owc_number'] ) )
            
            $owc_numbers = sanitize_textarea_field( $input['owc_number'] );
            $owc_number_explode = explode( "\n", $owc_numbers );

            foreach ( $owc_number_explode as $each ) {
                $owc_number_arr[] = $each;
            }
            $owc_number_arr = array_filter( $owc_number_arr );

            $new_input['owc_number'] = $owc_number_arr;

        if ( isset( $input['owc_button'] ) )
            $new_input['owc_button'] = sanitize_text_field( $input['owc_button'] );

        if ( isset( $input['owc_message'] ) )
            $new_input['owc_message'] = sanitize_text_field( $input['owc_message'] );

        return $new_input;

    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function owc_number_callback() {

        echo '<textarea id="owc_number" name="owc_option[owc_number]">';

        if ( isset( $this->options['owc_number'] ) ) {
            foreach( $this->options['owc_number'] as $each ) {
                echo $each . "\n";
            }
        } else {
            echo '';
        }

        echo '</textarea><span class="owc-desc">' . __( 'Only numbers, example 5511988887777. Add one number per line. When adding more than one number, they will be used sequentially.', 'open-whatsapp-chat' ) . '</span>';
        
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
            '<textarea id="owc_message" name="owc_option[owc_message]">%s</textarea>',
            isset( $this->options['owc_message'] ) ? esc_attr( $this->options['owc_message'] ) : ''
        );
    }
}

if ( is_admin() )
    $owc_settings_page = new Open_Whatsapp_Chat_Settings();