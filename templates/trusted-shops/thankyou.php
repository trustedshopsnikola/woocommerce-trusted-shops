<?php
/**
 * Thankyou page
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.2.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$order = wc_get_order( $order_id );

?>

<div id="trustedShopsCheckout" style="display: none;">
	<span id="tsCheckoutOrderNr"><?php echo $order->id;?></span> 
	<span id="tsCheckoutBuyerEmail"><?php echo ( $order->billing_email ? $order->billing_email : '' ); ?></span>
	<span id="tsCheckoutBuyerId"><?php echo $order->user_id; ?></span>
	<span id="tsCheckoutOrderAmount"><?php echo $order->get_total(); ?></span>
	<span id="tsCheckoutOrderCurrency"><?php echo $order->get_order_currency(); ?></span>
	<span id="tsCheckoutOrderPaymentType"><?php echo WC_trusted_shops()->trusted_shops->get_payment_gateway( $order->payment_method );?></span>
	<span id="tsCheckoutOrderEstDeliveryDate"></span>
	<?php if ( WC_trusted_shops()->trusted_shops->is_product_reviews_enabled() ) : ?>
		<?php foreach( $order->get_items() as $item_id => $item ) : 
			
			$product = apply_filters( 'woocommerce_order_item_product', $order->get_product_from_item( $item ), $item ); 
			// Currently not supporting reviews for variations	
			if ( $product->is_type( 'variation' ) )
				$product = $product->parent;

			$image = '';
			if ( has_post_thumbnail( $product->id ) )
				$image = wp_get_attachment_image_src( get_post_thumbnail_id( $product->id ), apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ) );
	
			?>
			<span class="tsCheckoutProductItem">
				<span class="tsCheckoutProductUrl"><?php echo get_permalink( $product->id ); ?></span>
				<span class="tsCheckoutProductImageUrl"><?php echo ( ! empty( $image ) ? $image[0] : '' ); ?></span>
				<span class="tsCheckoutProductName"><?php echo get_the_title( $product->id ); ?></span>
				<span class="tsCheckoutProductSKU"><?php echo ( $product->get_sku() ? $product->get_sku() : $product->id ); ?></span>
				<span class="tsCheckoutProductGTIN"><?php echo apply_filters( 'woocommerce_gzd_trusted_shops_product_gtin', $product->get_attribute( $gtin_attribute ), $product ); ?></span>
				<span class="tsCheckoutProductMPN"></span>
				<span class="tsCheckoutProductBrand"></span>
 			</span>
		<?php endforeach; ?>
	<?php endif; ?>
</div>