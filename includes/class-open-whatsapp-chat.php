<?php
/**
 * Open_Whatsapp_Chat
 *
 * @package Open_Whatsapp_Chat/Classes
 * @version	1.0.0
 * @since 1.0.0
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

class Open_Whatsapp_Chat {

	/**
	 * Setup the plugin
	 */
	public function __construct() {

		if ( is_admin() ) {
			self::owc_admin_includes();
			add_action( 'admin_head', array( $this, 'owc_admin_css' ), 50 );
		}

		add_action( 'wp_enqueue_scripts', array( $this, 'owc_css' ), 50 );
		add_action( 'wp_footer', array( $this, 'owc_print_button' ), 50 );

	}

	/**
	 * Admin includes.
	 */
	private static function owc_admin_includes() {
		include_once dirname( OWC_FILE ) . '/admin/class-open-whatsapp-chat-settings.php';
	}

	/**
	 * Enqueue the CSS.
	 *
	 * @return void
	 */
	public function owc_css() {
		wp_enqueue_style( 'owc-css', plugins_url( '/assets/css/style.css', OWC_FILE ) );
	}

	/**
	 * Enqueue the Admin CSS.
	 *
	 * @return void
	 */
	public function owc_admin_css() {
		wp_enqueue_style( 'owc-admin-css', plugins_url( '/assets/css/style-admin.css', OWC_FILE ) );
	}

	/**
	*
	* Verifica qual o navegador está sendo usado.
	* Passe como parâmetro o nome do navegador que deseja testar
	* por exemplo "Firefox".
	*
	* @author      Everaldo Matias <http://everaldomatias.github.io>
	* @version     0.0.1
	* @since       15/11/2018
	* @return      Booleano
	*
	*/
	public function owc_what_browser( $browser ) {
		if ( isset( $_SERVER['HTTP_USER_AGENT'] ) ) {
			$agent = $_SERVER['HTTP_USER_AGENT'];
		}

		if ( strlen( strstr( $agent, $browser ) ) > 0 ) {
		    return true;
		}
	}

	/**
	 * Print button on front end.
	 *
	 * @return void
	 */
	public function owc_print_button() {

		$owc_option = get_option( 'owc_option' );
		if ( $owc_option['owc_number'] && $owc_option['owc_message'] ) {

			if ( $this->owc_what_browser( 'Firefox' ) ) {
		    	$link = 'https://web.whatsapp.com/send?phone='	;
		    } else {
		    	$link = 'https://wa.me/'	;
		    }

		    $message = urlencode( $owc_option['owc_message'] );
		    $message = str_replace( '+', '%20', $message );

		    if ( ! empty( $owc_option['owc_button'] ) ) {

		    	echo '<a target="_blank" href="' . esc_url( $link ) . esc_html( $owc_option['owc_number'] ) . '?text=' . $message . '" class="owc-button owc-text" title="' . __( 'Open the WhatsApp Chat', 'open-whatsapp-chat' ) . '">';
		        echo '<span>' . esc_html( $owc_option['owc_button'] ) . '</span>';
				echo '</a>';
		    	
		    } else {

		    	echo '<a target="_blank" href="' . esc_url( $link ) . esc_html( $owc_option['owc_number'] ) . '?text=' . $message . '" class="owc-button" title="' . __( 'Open the WhatsApp Chat', 'open-whatsapp-chat' ) . '">';
				echo '</a>';

		    }

		}

	}

}

new Open_Whatsapp_Chat();