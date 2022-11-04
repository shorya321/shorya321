<?php
/**
 * The template for displaying the footer.
 *
 * Contains the body & html closing tags.
 *
 * @package HelloElementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'footer' ) ) {
	if ( did_action( 'elementor/loaded' ) && hello_header_footer_experiment_active() ) {
		get_template_part( 'template-parts/dynamic-footer' );
	} else {
		get_template_part( 'template-parts/footer' );
	}
}
?>

<script>
	

jQuery(window).scroll(function(){
    if (jQuery(window).scrollTop() >= 30) {
      jQuery('.tfc-header-inner').addClass('fixed-header');
    }
    else {
      jQuery('.tfc-header-inner').removeClass('fixed-header');
    }
});



(function ($) {

$(document).on('click', '.single_add_to_cart_button', function (e) {
    e.preventDefault();

    var $thisbutton = $(this),
            $form = $thisbutton.closest('form.cart'),
            id = $thisbutton.val(),
            product_qty = $form.find('input[name=quantity]').val() || 1,
            product_id = $form.find('input[name=product_id]').val() || id,
            variation_id = $form.find('input[name=variation_id]').val() || 0;

    var data = {
        action: 'woocommerce_ajax_add_to_cart',
        product_id: product_id,
        product_sku: '',
        quantity: product_qty,
        variation_id: variation_id,
    };

    $(document.body).trigger('adding_to_cart', [$thisbutton, data]);

    $.ajax({
        type: 'post',
        url: wc_add_to_cart_params.ajax_url,
        data: data,
        beforeSend: function (response) {
            $thisbutton.removeClass('added').addClass('loading');
        },
        complete: function (response) {
            $thisbutton.addClass('added').removeClass('loading');
            $(document.body).trigger('wc_fragment_refresh');
        },
        success: function (response) {

            if (response.error && response.product_url) {
                window.location = response.product_url;
                return;
            } else {
                $(document.body).trigger('added_to_cart', [response.fragments, response.cart_hash, $thisbutton]);
            }
        },
    });

    return false;
});
})(jQuery);

</script>
<script type="text/javascript">
function checkForChanges(){
if (jQuery('.add_to_cart_button.ajax_add_to_cart').hasClass('added')){
jQuery(".raven-shopping-cart").click();
}
else{
setTimeout(checkForChanges, 500);
}
}
checkForChanges();
</script>
<?php wp_footer(); ?>

</body>
</html>


