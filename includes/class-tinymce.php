<?php

defined( 'ABSPATH' ) || exit;

class QTI_TinyMCE {

	public function __construct() {
		add_action( 'admin_head', array( $this, 'inject_data' ) );
		add_filter( 'mce_external_plugins', array( $this, 'register_plugin' ) );
		add_filter( 'mce_buttons', array( $this, 'register_button' ) );
	}

	public function inject_data() {
		$screen = get_current_screen();
		if ( ! $screen || empty( $screen->post_type ) ) {
			return;
		}
		$snippets = get_option( 'quick_text_insert_snippets', array() );
		if ( empty( $snippets ) ) {
			return;
		}
		?>
		<script>window.qtiSnippets = <?php echo json_encode( $snippets ); ?>;</script>
		<?php
	}

	public function register_plugin( $plugins ) {
		$plugins['quicktextinsert'] = QTI_PLUGIN_URL . 'assets/js/editor-plugin.js';
		return $plugins;
	}

	public function register_button( $buttons ) {
		$buttons[] = 'quicktextinsert';
		return $buttons;
	}
}
