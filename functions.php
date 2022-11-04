<?php

/**
 * Theme functions and definitions
 *
 * @package HelloElementorChild
 */

/**
 * Load child theme css and optional scripts
 *
 * @return void
 */
function hello_elementor_child_enqueue_scripts()
{
	wp_enqueue_style(
		'hello-elementor-child-style',
		get_stylesheet_directory_uri() . '/style.css',
		[
			'hello-elementor-theme-style',
		],
		'1.0.0'
	);
	wp_enqueue_style(
		'hello-elementor-child-theme',
		get_stylesheet_directory_uri() . '/theme.css',
		[
			'hello-elementor-theme-style',
		],
		'1.0.0'
	);
	wp_enqueue_style(
		'hello-elementor-child-min-css',
		get_stylesheet_directory_uri() . '/assets/font-awesome/css/font-awesome.min.css',
		[
			'hello-elementor-theme-style',
		],
		'1.0.0'
	);
	wp_enqueue_style(
		'hello-elementor-child-min-owl-css',
		get_stylesheet_directory_uri() . '/assets/css/owl.carousel.min.css',
		[
			'hello-elementor-theme-style',
		],
		'1.0.0'
	);
}
add_action('wp_enqueue_scripts', 'hello_elementor_child_enqueue_scripts', 20);


function mytheme_custom_scripts()
{
	$scriptSrc = get_stylesheet_directory_uri() . '/assets/js/owl.carousel.min.js';
	wp_enqueue_script('myhandle', $scriptSrc, array(), '1.0',  false);
}
add_action('wp_enqueue_scripts', 'mytheme_custom_scripts');
/**
 * Register Product Tabs Widget.
 *
 * Include widget file and register widget class.
 *
 * @since 1.0.0
 * @param \Elementor\Widgets_Manager $widgets_manager Elementor widgets manager.
 * @return void
 */
//Registering a new elementor widget
function register_product_tabs_widgets($widgets_manager)
{

	require_once(__DIR__ . '/elementor/widgets/products-tabs/class-products-tabs.php');
	require_once(__DIR__ . '/elementor/widgets/top-bar/class-top-bar.php');
	require_once(__DIR__ . '/elementor/widgets/products-carousel/class-products-carousel.php');
	$widgets_manager->register(new \Products_tabs());
	$widgets_manager->register(new \Top_bar());
	$widgets_manager->register(new \Products_carousel());
}
add_action('elementor/widgets/register', 'register_product_tabs_widgets');

function register_my_menus()
{
	register_nav_menus(
		array(
			'additional-menu' => __('Additional Menu'),
			'header-menu' => __('Header Menu'),
			'another-menu' => __('Another Menu'),
			'extra-menu' => __('Extra Menu')
		)
	);
}
add_action('init', 'register_my_menus');

/*
*  Coldest categories name get
*/

add_action('widgets_init', 'my_awesome_sidebar');
function my_awesome_sidebar()
{
	$args = array(
		'name'          => 'mini cart Sidebar',
		'id'            => 'awesome-sidebar',
		'before_title'  => '<h2 class="widgettitle">',
		'after_title'   => '</h2>'
	);

	register_sidebar($args);
}
add_action('widgets_init', 'my_awesome_sidebar1');
function my_awesome_sidebar1()
{
	$args = array(
		'name'          => 'footer Sidebar',
		'id'            => 'footer-sidebar',
		'before_title'  => '<h2 class="widgettitle">',
		'after_title'   => '</h2>'
	);

	register_sidebar($args);
}

add_action('widgets_init', 'my_sidebar');
function my_sidebar()
{
	$args = array(
		'name'          => 'menu Sidebar',
		'id'            => 'menu-sidebar',
		'before_title'  => '<h2 class="widgettitle">',
		'after_title'   => '</h2>'
	);

	register_sidebar($args);
}

add_action('widgets_init', 'my_awesome_sidebar2');
function my_awesome_sidebar2()
{
	$args = array(
		'name'          => 'footer menu Sidebar',
		'id'            => 'footer-menu-sidebar',
		'before_title'  => '<h2 class="widgettitle">',
		'after_title'   => '</h2>'
	);

	register_sidebar($args);
}
add_action('widgets_init', 'my_awesome_sidebar3');
function my_awesome_sidebar3()
{
	$args = array(
		'name'          => 'footer email Sidebar',
		'id'            => 'footer-email-sidebar',
		'before_title'  => '<h2 class="widgettitle">',
		'after_title'   => '</h2>'
	);

	register_sidebar($args);
}

add_action('widgets_init', 'pages_menu');
function pages_menu()
{
	$args = array(
		'name'          => 'pages menu Sidebar',
		'id'            => 'pages-menu-sidebar',
		'before_title'  => '<h2 class="widgettitle">',
		'after_title'   => '</h2>'
	);

	register_sidebar($args);
}

if (!function_exists('coldest_wc_get_taxonomies_by_query')) {
	/**
	 * Get taxonomies by search
	 *
	 * @since 1.0.0
	 */
	function coldest_wc_get_taxonomies_by_query()
	{

		$orderby = 'name';
		$order = 'asc';
		$hide_empty = false;
		$cat_args = array(
			'orderby'    => $orderby,
			'order'      => $order,
			'hide_empty' => $hide_empty,
		);

		$product_categories = get_terms('product_cat', $cat_args);

		if (!empty($product_categories)) {
			$tfc_category = [];
			foreach ($product_categories as $key => $category) {
				$tfc_category[$category->slug] = $category->name;
			}
			$data = $tfc_category;
			return $data;
		}
	}
}





add_action('wp_ajax_woocommerce_ajax_add_to_cart', 'woocommerce_ajax_add_to_cart');
add_action('wp_ajax_nopriv_woocommerce_ajax_add_to_cart', 'woocommerce_ajax_add_to_cart');

function woocommerce_ajax_add_to_cart()
{

	$product_id = apply_filters('woocommerce_add_to_cart_product_id', absint($_POST['product_id']));
	$quantity = empty($_POST['quantity']) ? 1 : wc_stock_amount($_POST['quantity']);
	$variation_id = absint($_POST['variation_id']);
	$passed_validation = apply_filters('woocommerce_add_to_cart_validation', true, $product_id, $quantity);
	$product_status = get_post_status($product_id);

	if ($passed_validation && WC()->cart->add_to_cart($product_id, $quantity, $variation_id) && 'publish' === $product_status) {

		do_action('woocommerce_ajax_added_to_cart', $product_id);

		if ('yes' === get_option('woocommerce_cart_redirect_after_add')) {
			wc_add_to_cart_message(array($product_id => $quantity), true);
		}

		WC_AJAX::get_refreshed_fragments();
	} else {

		$data = array(
			'error' => true,
			'product_url' => apply_filters('woocommerce_cart_redirect_after_error', get_permalink($product_id), $product_id)
		);

		echo wp_send_json($data);
	}

	wp_die();
}


function tfclinkedproduct_custom_woo_data_tab($tabs)
{

	$tabs['pixelnet_custom_tab'] = array(
		'label'     => __('Product Size/Icon', 'tfclinkedproduct'), //Navigation Label Name
		'target'    => 'tfclinkedproduct_custom_tab_content', //The HTML ID of the tab content wrapper
		'class' => array('show_if_simple', 'show_if_variable'), //Show if the product type is simple
		'priority' => 99,
	);

	return $tabs;
}
add_filter('woocommerce_product_data_tabs', 'tfclinkedproduct_custom_woo_data_tab');

function tfclinkedproduct_custom_tab_content()
{
	global $post;
	$field_value = metadata_exists('post', $post->ID, '_tfc_my_custom_field_text') ? get_post_meta($post->ID, '_tfc_my_custom_field_text', true) : '';
	$field2_value = metadata_exists('post', $post->ID, '_tfc_my_custom_field2_text') ? get_post_meta($post->ID, '_tfc_my_custom_field2_text', true) : '';
?>

	<div id="tfclinkedproduct_custom_tab_content" class="panel woocommerce_options_panel">

		<?php
		//Create some fields
		woocommerce_wp_text_input(array(
			'id' => 'tfc_my_custom_field_text',
			'name' => 'tfc_my_input_field_name',
			'value' => $field_value,
			'label' => __('My Field Label', 'tfclinkedproduct'),
			'placeholder' => __('My Text Input Field', 'tfclinkedproduct'),
			'description' => __('Describe what this field does in short.', 'tfclinkedproduct'),
			'desc_tip' => true,
		));
		?>
		<p class="form-row form-row-first upload_image tfc-wd-100">
			<a href="#" class="upload_image_button tips " rel="">
				<img src="/wp-content/uploads/woocommerce-placeholder-300x300.png">
				<input type="hidden" name="variation_customize_img_id" class="upload_image_id" value="">
			</a>
		</p>

		<!-- Custom HTML Form Field -->
		<p class="form-field my_custom_field2_text_field ">
			<label for="my_custom_field_text">My HTML Field Label</label>
			<input type="text" class="short" style="" name="tfc_my_input_field2_name" id="tfc_my_custom_field2_text" value="<?php esc_html_e($field2_value); ?>" placeholder="My Text Input Field2 Placeholder">
		</p>

	</div>
	<?php
}
add_action('woocommerce_product_data_panels', 'tfclinkedproduct_custom_tab_content');

function tfclinkedproduct_save_product_custom_tab($post_id)
{
	$product = wc_get_product($post_id);

	$field1 = isset($_POST['tfc_my_input_field_name']) && !empty($_POST['tfc_my_input_field_name']) ? sanitize_text_field($_POST['tfc_my_input_field_name']) : '';
	$field2 = isset($_POST['tfc_my_input_field2_name']) && !empty($_POST['tfc_my_input_field2_name']) ? sanitize_text_field($_POST['tfc_my_input_field2_name']) : '';
	$product->update_meta_data('_tfc_my_custom_field_text', $field1);
	$product->update_meta_data('_tfc_my_custom_field2_text', $field2);

	$product->save();
}


add_action('woocommerce_process_product_meta', 'tfclinkedproduct_save_product_custom_tab');

function cfwc_display_custom_field()
{
	global $post;
	// Check for the custom field value
	$product = wc_get_product($post->ID);
	$tfc_size = $product->get_meta('_tfc_my_custom_field_text');
	if ($tfc_size) { ?>
		<div id="tfc-custom-size">
			<div class="tfc-current-size">
				<strong>Size:</strong>
				<span><?php echo  esc_html($tfc_size); ?></span>
			</div>
			<ul class="tfc-size-variants">
				<li>
					<a href="/20-oz-wide-mouth" class="" data-base-url="/20-oz-wide-mouth">
						<div class="label">
							<?php echo  esc_html($tfc_size); ?>
						</div>
						<div class="image">
							<img src="https://surefootme.s3.amazonaws.com/hydroflask/hfux-123/HF-123+Vector+assets/Wide_20oz.svg" alt="">
						</div>
					</a>
				</li>
			</ul>
		</div>

<?php }
}

add_action('woocommerce_before_add_to_cart_button', 'cfwc_display_custom_field');


add_action('woocommerce_before_order_notes', 'wps_add_select_checkout_field');
function wps_add_select_checkout_field( $checkout ) {

	woocommerce_form_field( 'tfcordertype', array(
	    'type'          => 'select',
	    'class'         => array( 'wps-drop' ),
	    'label'         => __( 'Select order type' ),
	    'options'       => array(
	    	'blank'		=> __( 'Select order', 'wps' ),
	        'delivery'	=> __( 'Delivery', 'wps' ),
	        'takeway'	=> __( 'Takeway', 'wps' ),
	        'dine-in' 	=> __( 'Dine-in', 'wps' )
	    )
 ),
	$checkout->get_value( 'tfcordertype' ));

}

//* Process the checkout
add_action('woocommerce_checkout_process', 'wps_select_checkout_field_process');
function wps_select_checkout_field_process() {
   global $woocommerce;

   // Check if set, if its not set add an error.
   if ($_POST['tfcordertype'] == "blank")
	wc_add_notice( '<strong>Please select a order type</strong>', 'error' );

}

//* Update the order meta with field value
add_action('woocommerce_checkout_update_order_meta', 'wps_select_checkout_field_update_order_meta');
function wps_select_checkout_field_update_order_meta( $order_id ) {

  if ($_POST['tfcordertype']) update_post_meta( $order_id, 'tfcordertype', esc_attr($_POST['tfcordertype']));

}

//* Display field value on the order edition page
add_action( 'woocommerce_admin_order_data_after_billing_address', 'wps_select_checkout_field_display_admin_order_meta', 10, 1 );
function wps_select_checkout_field_display_admin_order_meta($order){

	echo '<p><strong>'.__('Delivery option').':</strong> ' . get_post_meta( $order->id, 'tfcordertype', true ) . '</p>';

}

//* Add selection field value to emails
add_filter('woocommerce_email_order_meta_keys', 'wps_select_order_meta_keys');
function wps_select_order_meta_keys( $keys ) {

	$keys['Tfcordertype:'] = 'tfcordertype';
	return $keys;
	
}