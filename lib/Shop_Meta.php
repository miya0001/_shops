<?php

namespace _Shops;
use Miya;

class Shop_Meta extends Miya\WP\Custom_Field
{
    protected $labels;
    protected $headings;

    public function __construct( $id, $title, array $options = array() ) {
	    $this->labels = apply_filters( 'shop_meta_labels', array(
            'kana'         => 'ふりがな',
		    'zip'          => '郵便番号',
		    'address'      => '住所',
		    'tel'          => '電話番号',
		    'url'          => 'URL',
		    'open'         => '営業時間',
		    'holiday'      => '定休日',
		    'parking'      => '駐車場',
		    'reservation' => '予約',
		    'note'         => '備考',
	    ) );

	    $this->headings = apply_filters( 'shop_meta_labels', array(
            'contact' => '連絡先',
            'info'    => '営業案内',
        ) );

	    parent::__construct( $id, $title, $options );
    }

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
        <h3><?php $this->headings( 'contact' ); ?></h3>
		<table class="shop-meta">
            <tr><th><?php $this->label( 'kana' ); ?></th><td><input type="text" name="kana" value="<?php $this->_meta( '_kana' ) ?>"></td></tr>
			<tr><th><?php $this->label( 'zip' ); ?></th><td><input type="text" name="zip" value="<?php $this->_meta( '_zip' ) ?>"></td></tr>
			<tr><th><?php $this->label( 'address' ); ?></th><td><input type="text" name="address" value="<?php $this->_meta( '_address' ) ?>"></td></tr>
			<tr><th><?php $this->label( 'tel' ); ?></th><td><input type="text" name="tel" value="<?php $this->_meta( '_tel' ) ?>"></td></tr>
			<tr><th><?php $this->label( 'url' ); ?></th><td><input type="text" name="url" value="<?php $this->_meta( '_url' ) ?>"></td></tr>
        </table>

        <h3><?php $this->headings( 'info' ); ?></h3>
        <table class="shop-meta">
			<tr><th><?php $this->label( 'open' ); ?></th><td><input type="text" name="open" value="<?php $this->_meta( '_open' ) ?>"></td></tr>
			<tr><th><?php $this->label( 'holiday' ); ?></th><td><input type="text" name="holiday" value="<?php $this->_meta( '_holiday' ) ?>"></td></tr>
			<tr><th><?php $this->label( 'parking' ); ?></th><td><input type="text" name="parking" value="<?php $this->_meta( '_parking' ) ?>"></td></tr>
			<tr><th><?php $this->label( 'reservation' ); ?></th><td><input type="text" name="reservation" value="<?php $this->_meta( '_reservation' ) ?>"></td></tr>
            <tr><th><?php $this->label( 'note' ); ?></th><td><textarea name="note"><?php echo esc_textarea( get_post_meta( get_the_ID(), '_note', true ) ); ?></textarea></td></tr>
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
		$keys = array( 'kana', 'zip', 'address', 'tel', 'url', 'open',
                    'holiday', 'parking', 'note', 'reservation', 'note' );
		foreach ( $keys as $key ) {
		    if ( empty( $_POST[ $key ] ) ) {
			    update_post_meta( get_the_ID(), '_' . $key, "" );
            } else {
			    update_post_meta( get_the_ID(), '_' . $key, $_POST[ $key ] );
            }
		}
	}

	protected function _meta( $key )
	{
		echo esc_attr( get_post_meta( get_the_ID(), $key, true ) );
	}

	protected function label( $key )
	{
		echo esc_html( $this->labels[ $key ] );
	}

	protected function headings( $key )
	{
		echo esc_html( $this->headings[ $key ] );
	}
}
