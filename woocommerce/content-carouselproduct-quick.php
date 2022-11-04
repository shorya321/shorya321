<?php

/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined('ABSPATH') || exit;
global $product;

// Ensure visibility.
if (empty($product) || !$product->is_visible()) {
	return;
}

global $product;


$fc_prod_variation_id = get_query_var('fc_prod_variation_id');

// Pa_size name get
$tfc_pa_size_name = get_query_var('tfcpasizename');

// Check varaition instock/outofstock name get
$tfc_variation_stock_quantity = get_query_var('tfc_variation_stock_quantity');

do_action('woocommerce_before_shop_loop_item');
?>
<div class="product-element-top">
	<a href="<?php echo esc_url(get_permalink()); ?>?attribute_pa_color=<?php echo $fc_prod_variation_id['attributes']['attribute_pa_color']; ?>&attribute_pa_size=<?php echo $tfc_pa_size_name ?>" class="product-image-link">
		<?php
		/**
		 * woocommerce_before_shop_loop_item_title hook
		 *
		 * @hooked woocommerce_show_product_loop_sale_flash - 10
		 * @hooked woodmart_template_loop_product_thumbnail - 10
		 */
		// do_action('woocommerce_before_shop_loop_item_title');
		$variationImage = !empty($fc_prod_variation_id['image']['src']) ? $fc_prod_variation_id['image']['src'] : site_url() . '/wp-content/uploads/woocommerce-placeholder-300x300.png'
		?>
		<img src="<?php echo $variationImage; ?>">
	</a>


	<div class="product-title">
		<h3 class="wd-entities-title tfc-custom-filter-prod-title">
			<?php
			$tfc_attributeName =  $fc_prod_variation_id['attributes']['attribute_pa_color'];
			$tfc_attr_replaced = str_replace('-', ' ', $tfc_attributeName);
			?>
			<a href="<?php echo esc_url(get_permalink()); ?>?attribute_pa_color=<?php echo $fc_prod_variation_id['attributes']['attribute_pa_color']; ?>&attribute_pa_size=<?php echo $tfc_pa_size_name ?>"><?php echo $product->get_title(); ?> </a>
		</h3>
		<p><?php echo ucwords($tfc_attr_replaced); ?> <?php if ($tfc_pa_size_name) : echo '|';
														endif; ?> <?php echo $tfc_pa_size_name ?></p>
		<p> <span class="price"><span class="woocommerce-Price-amount amount">
					<bdi><span class="woocommerce-Price-currencySymbol">$</span><?php echo $fc_prod_variation_id['display_price']; ?></bdi>
				</span>
			</span>
		</p>
	</div>

	<div class="tfc-variable-main-button">
		<div class="wc-fc-variation-add-cart woodmart-custom-add-btn">
			<div class="woocommerce-variation-add-to-cart variations_button">
				<form class="fc_variation_attribute_form tfc-single-variation-filtre-form variations_form cart">
					<input type="hidden" name="product_id" value="<?php echo $product->get_id(); ?>" class="fc_product_id">
					<input type="hidden" name="add-to-cart" value="<?php echo $product->get_id(); ?>" class="fc_add-to-cart">
					<input type="hidden" name="quantity" value="1" class="fc_product_qty">
					<input type="hidden" name="attribute_pa_color" value="<?php echo $fc_prod_variation_id['attributes']['attribute_pa_color']; ?>" class="fc_attribute_pa_blue">
					<input type="hidden" name="attribute_pa_size" value="<?php echo $tfc_pa_size_name ?>">
					<input type="hidden" name="variation_id" class="variation_id" value="<?php echo $fc_prod_variation_id['variation_id']; ?>">
					<button type="submit" class="single_add_to_cart_button button alt">Add To Bag</button>
				</form>
			</div>
		</div>
	</div>

</div>