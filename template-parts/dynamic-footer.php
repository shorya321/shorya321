<?php
/**
 * The template for displaying footer.
 *
 * @package HelloElementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$is_editor = isset( $_GET['elementor-preview'] );
$site_name = get_bloginfo( 'name' );
$tagline   = get_bloginfo( 'description', 'display' );
$footer_class = did_action( 'elementor/loaded' ) ? esc_attr( hello_get_footer_layout_class() ) : '';
$footer_nav_menu = wp_nav_menu( [
	'theme_location' => 'menu-2',
	'fallback_cb' => false,
	'echo' => false,
] );
?>
<footer id="site-footer" class="site-footer dynamic-footer tfc-footer <?php echo esc_attr( $footer_class ); ?>" role="contentinfo">
	<div class="footer-inner">
		<div class="site-branding show-<?php echo esc_attr( hello_elementor_get_setting( 'hello_footer_logo_type' ) ); ?>">
			<?php if ( has_custom_logo() && ( 'title' !== hello_elementor_get_setting( 'hello_footer_logo_type' ) || $is_editor ) ) : ?>
				<div class="site-logo tfc-footer-logo <?php echo esc_attr( hello_show_or_hide( 'hello_footer_logo_display' ) ); ?>">
					<?php the_custom_logo(); ?>
					<?php dynamic_sidebar('footer-menu-sidebar'); ?>
				</div>
			<?php endif;

			if ( $site_name && ( 'logo' !== hello_elementor_get_setting( 'hello_footer_logo_type' ) ) || $is_editor ) : ?>
				<h4 class="site-title <?php echo esc_attr( hello_show_or_hide( 'hello_footer_logo_display' ) ); ?>">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php esc_attr_e( 'Home', 'hello-elementor' ); ?>" rel="home">
						<?php echo esc_html( $site_name ); ?>
					</a>
				</h4>
			<?php endif;
			
			if ( $tagline || $is_editor ) : ?>
				<p class="site-description <?php echo esc_attr( hello_show_or_hide( 'hello_footer_tagline_display' ) ); ?>">
					<?php echo esc_html( $tagline ); ?>
				</p>
			<?php endif; ?>
			<div class="tfc-widget-footer">
			<div class="tfc-footer-menu">
				<?php dynamic_sidebar('footer-sidebar'); ?>
			</div>
			<div class="tfc-footer-menu">
				<?php dynamic_sidebar('menu-sidebar'); ?>
			</div>
			<div class="tfc-footer-menu">
				<?php dynamic_sidebar('menu-sidebar'); ?>
			</div>
		</div>
		</div>
		
		<?php if ( $footer_nav_menu ) : ?>
			<nav class="site-navigation <?php echo esc_attr( hello_show_or_hide( 'hello_footer_menu_display' ) ); ?>" role="navigation">
				<?php
				// PHPCS - escaped by WordPress with "wp_nav_menu"
				echo $footer_nav_menu; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				?>
			</nav>
		<?php endif; ?>
		<div class="tfc-email-section">
			<?php dynamic_sidebar('footer-email-sidebar'); ?>
		</div>
		<div class="tfc-extra-pages">
			<?php dynamic_sidebar('pages-menu-sidebar'); ?>
		</div>	
	</div>
</footer>
