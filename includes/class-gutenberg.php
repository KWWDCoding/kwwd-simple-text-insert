<?php

defined( 'ABSPATH' ) || exit;

class KWWD_STI_Gutenberg {

	public function __construct() {
		add_action( 'init', array( $this, 'register_blocks' ) );
		add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_assets' ) );
	}

	public function register_blocks() {
		if ( ! function_exists( 'register_block_type' ) ) {
			return;
		}

		$snippets = get_option( 'quick_text_insert_snippets', array() );

		foreach ( $snippets as $snippet ) {
			$slug = isset( $snippet['slug'] ) ? $snippet['slug'] : sanitize_title( $snippet['name'] );
			if ( ! $slug ) {
				continue;
			}

			$block_name = 'quick-text-insert/' . $slug;

			register_block_type( $block_name, array(
				'api_version'     => 3,
				'render_callback' => function ( $attrs ) {
					return isset( $attrs['content'] ) ? wp_kses_post( $attrs['content'] ) : '';
				},
				'attributes'      => array(
					'content' => array( 'type' => 'string', 'default' => $snippet['text'] ),
				),
			) );
		}
	}

	public function enqueue_assets() {
		$snippets = get_option( 'quick_text_insert_snippets', array() );

		if ( empty( $snippets ) ) {
			return;
		}

		foreach ( $snippets as $i => $s ) {
			if ( ! isset( $s['slug'] ) ) {
				$snippets[ $i ]['slug'] = sanitize_title( $s['name'] );
			}
		}

		$handle = 'qti-gutenberg';

		wp_enqueue_script(
			$handle,
			KWWD_STI_PLUGIN_URL . 'assets/js/gutenberg-plugin.js',
			array( 'wp-blocks', 'wp-element', 'wp-i18n' ),
			KWWD_STI_VERSION,
			true
		);

		wp_localize_script( $handle, 'qtiSnippets', $snippets );
	}
}
