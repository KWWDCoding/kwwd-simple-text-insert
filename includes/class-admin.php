<?php

defined( 'ABSPATH' ) || exit;

class KWWD_STI_Admin {

	private $option_name = 'quick_text_insert_snippets';

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );
		add_action( 'admin_post_kwwd_sti_save_snippet', array( $this, 'handle_save' ) );
		add_action( 'admin_post_kwwd_sti_delete_snippet', array( $this, 'handle_delete' ) );
	}

	public function add_admin_menu() {
		add_options_page(
			'Simple Text Insert',
			'Simple Text Insert',
			'manage_options',
			'quick-text-insert',
			array( $this, 'render_page' )
		);
	}

	public function get_snippets() {
		return get_option( $this->option_name, array() );
	}

	public function render_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$snippets = $this->get_snippets();
		?>
		<div class="wrap">
			<h1>Simple Text Insert</h1>

			<h2>Add New Snippet</h2>
			<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
				<?php wp_nonce_field( 'kwwd_sti_save_action', 'kwwd_sti_nonce' ); ?>
				<input type="hidden" name="action" value="kwwd_sti_save_snippet">
				<table class="form-table">
					<tr>
						<th><label for="snippet_name">Name</label></th>
						<td><input type="text" id="snippet_name" name="snippet_name" class="regular-text" required></td>
					</tr>
					<tr>
						<th><label for="snippet_text">Text to Insert</label></th>
						<td><textarea id="snippet_text" name="snippet_text" rows="6" class="large-text" required></textarea></td>
					</tr>
				</table>
				<?php submit_button( 'Add Snippet' ); ?>
			</form>

			<hr>

			<h2>Existing Snippets</h2>
			<?php if ( empty( $snippets ) ) : ?>
				<p>No snippets yet. Add one above.</p>
			<?php else : ?>
				<table class="widefat striped">
					<thead>
						<tr>
							<th>Name</th>
							<th>Text Preview</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ( $snippets as $index => $snippet ) : ?>
							<tr>
								<td><?php echo esc_html( $snippet['name'] ); ?></td>
								<td><code><?php echo esc_html( substr( $snippet['text'], 0, 80 ) . ( strlen( $snippet['text'] ) > 80 ? '...' : '' ) ); ?></code></td>
								<td>
									<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" style="display:inline">
										<?php wp_nonce_field( 'kwwd_sti_delete_action', 'kwwd_sti_nonce' ); ?>
										<input type="hidden" name="action" value="kwwd_sti_delete_snippet">
										<input type="hidden" name="snippet_index" value="<?php echo esc_attr( $index ); ?>">
										<button class="button button-small" onclick="return confirm('Delete this snippet?')">Delete</button>
									</form>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			<?php endif; ?>
		</div>
		<?php
	}

	public function handle_save() {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( 'Unauthorized.' );
		}
		check_admin_referer( 'kwwd_sti_save_action', 'kwwd_sti_nonce' );

		$name = sanitize_text_field( wp_unslash( $_POST['snippet_name'] ?? '' ) );
		$text = wp_kses_post( wp_unslash( $_POST['snippet_text'] ?? '' ) );

		if ( empty( $name ) || empty( $text ) ) {
			wp_die( 'Both fields are required.' );
		}

		$slug = sanitize_title( $name ) . '-' . substr( wp_hash( $name . $text . time() ), 0, 6 );

		$snippets   = $this->get_snippets();
		$snippets[] = array( 'name' => $name, 'text' => $text, 'slug' => $slug );
		update_option( $this->option_name, $snippets );

		wp_safe_redirect( admin_url( 'options-general.php?page=quick-text-insert' ) );
		exit;
	}

	public function handle_delete() {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( 'Unauthorized.' );
		}
		check_admin_referer( 'kwwd_sti_delete_action', 'kwwd_sti_nonce' );

		$index = intval( $_POST['snippet_index'] ?? -1 );
		$snippets = $this->get_snippets();

		if ( isset( $snippets[ $index ] ) ) {
			unset( $snippets[ $index ] );
			update_option( $this->option_name, array_values( $snippets ) );
		}

		wp_safe_redirect( admin_url( 'options-general.php?page=quick-text-insert' ) );
		exit;
	}
}
