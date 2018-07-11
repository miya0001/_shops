<?php

namespace _Shops;
use Miya;

class Shop_Meta extends Miya\WP\Custom_Field
{
	/**
	 * Fires at the `admin_enqueue_scripts` hook.
	 *
	 * @param string $hook The hook like `post.php` or so.
	 */
	public function admin_enqueue_scripts( $hook )
	{
		wp_enqueue_style(
			'shop-meta',
            plugins_url( 'css/style.min.css', dirname( __FILE__ ) ),
            false,
            filemtime( dirname( dirname( __FILE__ ) ) . '/css/style.min.css' )
		);
	}

	/**
	 * Displays the form for the metabox. The nonce will be added automatically.
	 *
	 * @param \WP_Post $post The object of the post.
	 * @param array $args The argumets passed from `add_meta_box()`.
	 */
	public function form( $post, $args )
	{
		?>
		<table class="shop-meta">
			<tr><th>郵便番号</th><td><input type="text" name="zip" value="<?php $this->_meta( '_zip' ) ?>"></td></tr>
			<tr><th>住所</th><td><input type="text" name="addr" value="<?php $this->_meta( '_addr' ) ?>"></td></tr>
			<tr><th>電話番号</th><td><input type="text" name="tel" value="<?php $this->_meta( '_tel' ) ?>"></td></tr>
			<tr><th>URL</th><td><input type="text" name="url" value="<?php $this->_meta( '_url' ) ?>"></td></tr>
		</table>
		<?php
	}

	/**
	 * Save the metadata from the `form()`. The nonce will be verified automatically.
	 *
	 * @param int $post_id The ID of the post.
	 */
	public function save( $post_id )
	{
		update_post_meta( $post_id, '_zip', $_POST['zip'] );
		update_post_meta( $post_id, '_addr', $_POST['addr'] );
		update_post_meta( $post_id, '_tel', $_POST['tel'] );
		update_post_meta( $post_id, '_url', $_POST['url'] );
	}

	protected function _meta( $key )
	{
		echo esc_attr( get_post_meta( get_the_ID(), $key, true ) );
	}
}