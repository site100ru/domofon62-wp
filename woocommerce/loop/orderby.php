<?php
/**
 * Show options for ordering
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/orderby.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<div class="col-md-6 mb-3 mb-md-0">
	<!-- Поиск -->
	<?php echo do_shortcode('[fibosearch]'); ?>
</div>
<div class="col-md-3 d-none d-md-block">
	<form class="woocommerce-ordering mb-3 mb-md-0" method="get" style="background: #FFFFFF; border-radius: 5px; width: 100%; height: 60px!important; align-items: center; display: flex!important;">
		
		<select name="orderby" class="orderby form-select" aria-label="<?php esc_attr_e( 'Shop order', 'woocommerce' ); ?>" style="width: 100%; padding-left: 15px;">
			<?php foreach ( $catalog_orderby_options as $id => $name ) : ?>
				<option value="<?php echo esc_attr( $id ); ?>" <?php selected( $orderby, $id ); ?>><?php echo esc_html( $name ); ?></option>
			<?php endforeach; ?>
		</select>
		<input type="hidden" name="paged" value="1" />
		<?php wc_query_string_form_fields( null, array( 'orderby', 'submit', 'paged', 'product-page' ) ); ?>
	</form>
</div>