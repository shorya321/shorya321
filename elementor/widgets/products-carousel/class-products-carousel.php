<?php

use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Plugin;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Image_Size;

if (!defined('ABSPATH')) {
	// Exit if accessed directly.
	exit;
}

class Products_carousel extends Widget_Base
{


	public function __construct($data = [], $args = null)
	{
		parent::__construct($data, $args);

		require_once(__DIR__ . '/products-carousel.php');
	}


	/**
	 * Get widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name()
	{
		return 'wd_product_carousel';
	}

	/**
	 * Get widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title()
	{
		return esc_html__('Products (carousel slider)', 'coldest');
	}

	/**
	 * Get widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon()
	{
		return 'fa fa-clipboard';
	}

	/**
	 * Enqueue style
	 */
	public function get_style_depends()
	{
		wp_register_style('coldest_products_carousel_style', get_stylesheet_directory_uri() . '/elementor/products-carousel/assets/css/products-carousel.css', array(), '1.0.0');
		return ['coldest_products_carousel_style'];
	}

	/**
	 * Enqueue script
	 */
	public function get_script_depends()
	{
		wp_register_script('coldest_products_carousel_js', get_stylesheet_directory_uri() . '/elementor/products-carousel/assets/js/products-carousel.js', array(), '1.0.0', true);
		return ['coldest_products_carousel_js'];
	}

	/**
	 * Register the widget controls.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function _register_controls()
	{
		
		
		/**
		 * Content tab.
		 */

		/**
		 * General settings.
		 */

		$this->start_controls_section(
			'general_content_section',
			[
				'label' => esc_html__('General', 'coldest'),
			]
		);

		$this->add_control(
			'title',
			[
				'label'   => esc_html__('Title', 'coldest'),
				'type'    => Controls_Manager::TEXT,
				'default' => 'Title text example',
			]
		);

		$this->end_controls_section();
		

		$this->start_controls_section(
			'general_content_section',
			[
				'label' => esc_html__('General', 'coldest'),
			]
		);

		$this->add_control(
			'post_type',
			[
				'label'       => esc_html__('Data source', 'coldest'),
				'description' => esc_html__('Select content type for your carousel.', 'coldest'),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'product',
				'options'     => array(
					'product'            => esc_html__('All Products', 'coldest'),
					'featured'           => esc_html__('Featured Products', 'coldest'),
					'sale'               => esc_html__('Sale Products', 'coldest'),
					'new'                => esc_html__('Products with NEW label', 'coldest'),
					'bestselling'        => esc_html__('Bestsellers', 'coldest'),
				),
			]
		);

		$this->add_control(
			'taxonomies',
			[
				'label' => esc_html__('Select Category', 'coldest'),
				'type' => Controls_Manager::SELECT2,
				'multiple' => true,
				'options' => coldest_wc_get_taxonomies_by_query(),
				'default' => '',
			]

		);

		$this->add_control(
			'orderby',
			[
				'label'       => esc_html__('Order by', 'coldest'),
				'description' => esc_html__('Select order type. If "Meta value" or "Meta value Number" is chosen then meta key is required.', 'coldest'),
				'type'        => Controls_Manager::SELECT,
				'default'     => '',
				'options'     => array(
					''               => '',
					'date'           => esc_html__('Date', 'coldest'),
					'id'             => esc_html__('ID', 'coldest'),
					'author'         => esc_html__('Author', 'coldest'),
					'title'          => esc_html__('Title', 'coldest'),
					'modified'       => esc_html__('Last modified date', 'coldest'),
					'comment_count'  => esc_html__('Number of comments', 'coldest'),
					'menu_order'     => esc_html__('Menu order', 'coldest'),
					'meta_value'     => esc_html__('Meta value', 'coldest'),
					'meta_value_num' => esc_html__('Meta value number', 'coldest'),
					'rand'           => esc_html__('Random order', 'coldest'),
					'price'          => esc_html__('Price', 'coldest'),
				),
			]
		);
		$this->add_control(
			'query_type',
			[
				'label'   => esc_html__('Query type', 'coldest'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'OR',
				'options' => array(
					'OR'  => esc_html__('OR', 'coldest'),
					'AND' => esc_html__('AND', 'coldest'),
				),
			]
		);

		$this->add_control(
			'order',
			[
				'label'       => esc_html__('Sort order', 'coldest'),
				'description' => 'Designates the ascending or descending order. More at <a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>.',
				'type'        => Controls_Manager::SELECT,
				'default'     => '',
				'options'     => array(
					''     => esc_html__('Inherit', 'coldest'),
					'DESC' => esc_html__('Descending', 'coldest'),
					'ASC'  => esc_html__('Ascending', 'coldest'),
				),
				'condition'   => [
					'post_type!' => 'ids',
				],
			]
		);

        		



		$this->end_controls_section();

		/**
		 * Style tab.
		 */

		/**
		 * Heading settings.
		 */
		$this->start_controls_section(
			'heading_style_section',
			[
				'label' => esc_html__('Heading', 'coldest'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);


		$this->add_control(
			'color',
			[
				'label'     => esc_html__('Color', 'coldest'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tfc-heading' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'text_align',
			[
				'label' => esc_html__('Alignment', 'coldest'),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__('Left', 'coldest'),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__('Center', 'coldest'),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__('Right', 'coldest'),
						'icon' => 'eicon-text-align-right',
					],
				],
				'default' => 'center',
				'toggle' => true,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography',
				'selector' => '{{WRAPPER}} .tfc-heading',
			]
		);


		$this->end_controls_section();

		/**
		 * Layout settings.
		 */
		$this->start_controls_section(
			'layout_style_section',
			[
				'label' => esc_html__('Layout', 'coldest'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'layout',
			[
				'label'   => esc_html__('Products style', 'coldest'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'carousel',
				'options' => array(
					'grid'     => esc_html__('Grid', 'coldest'),
					'carousel' => esc_html__('Carousel', 'coldest'),
				),
			]
		);

		// $this->add_control(
		// 	'columns',
		// 	[
		// 		'label'       => esc_html__('Columns', 'coldest'),
		// 		'description' => esc_html__('Number of columns in the grid.', 'coldest'),
		// 		'type'        => Controls_Manager::SLIDER,
		// 		'default'     => [
		// 			'size' => 4,
		// 		],
		// 		'size_units'  => '',
		// 		'range'       => [
		// 			'px' => [
		// 				'min'  => 1,
		// 				'max'  => 6,
		// 				'step' => 1,
		// 			],
		// 		],
		// 		'condition'   => [
		// 			'layout' => 'grid',
		// 		],
		// 	]
		// );

		// $this->add_control(
		// 	'products_masonry',
		// 	[
		// 		'label'       => esc_html__('Masonry grid', 'coldest'),
		// 		'description' => esc_html__('Products may have different sizes.', 'coldest'),
		// 		'type'        => Controls_Manager::SELECT,
		// 		'default'     => '',
		// 		'options'     => array(
		// 			''        => esc_html__('Inherit', 'coldest'),
		// 			'enable'  => esc_html__('Enable', 'coldest'),
		// 			'disable' => esc_html__('Disable', 'coldest'),
		// 		),
		// 		'condition'   => [
		// 			'layout' => 'grid',
		// 		],
		// 	]
		// );

		// $this->add_control(
		// 	'products_different_sizes',
		// 	[
		// 		'label'       => esc_html__('Products grid with different sizes', 'coldest'),
		// 		'description' => esc_html__('In this situation, some of the products will be twice bigger in width than others. Recommended to use with 6 columns grid only.', 'woodmart'),
		// 		'type'        => Controls_Manager::SELECT,
		// 		'default'     => '',
		// 		'options'     => array(
		// 			''        => esc_html__('Inherit', 'coldest'),
		// 			'enable'  => esc_html__('Enable', 'coldest'),
		// 			'disable' => esc_html__('Disable', 'coldest'),
		// 		),
		// 		'condition'   => [
		// 			'layout' => 'grid',
		// 		],
		// 	]
		// );

		// $this->add_control(
		// 	'spacing',
		// 	[
		// 		'label'     => esc_html__('Space between', 'coldest'),
		// 		'type'      => Controls_Manager::SELECT,
		// 		'options'   => [
		// 			''  => esc_html__('Inherit', 'coldest'),
		// 			0  => esc_html__('0 px', 'coldest'),
		// 			2  => esc_html__('2 px', 'coldest'),
		// 			6  => esc_html__('6 px', 'coldest'),
		// 			10 => esc_html__('10 px', 'coldest'),
		// 			20 => esc_html__('20 px', 'coldest'),
		// 			30 => esc_html__('30 px', 'coldest'),
		// 		],
		// 		'default'   => '',
		// 		'condition' => [
		// 			'layout'                => ['grid', 'carousel'],
		// 			'highlighted_products!' => ['1'],
		// 		],
		// 	]
		// );

		$this->add_control(
			'items_per_page',
			[
				'label'       => esc_html__('Items per page', 'coldest'),
				'description' => esc_html__('Number of items to show per page.', 'coldest'),
				'default'     => 12,
				'type'        => Controls_Manager::NUMBER,
			]
		);

		$this->add_control(
			'pagination',
			[
				'label'     => esc_html__('Pagination', 'coldest'),
				'type'      => Controls_Manager::SELECT,
				'default'   => '',
				'options'   => array(
					''         => esc_html__('Inherit', 'coldest'),
					'more-btn' => esc_html__('Load more button', 'coldest'),
					'infinit'  => esc_html__('Infinit scrolling', 'coldest'),
					'arrows'   => esc_html__('Arrows', 'coldest'),
				),
				'condition' => [
					'layout!' => 'carousel',
				],
			]
		);

		$this->end_controls_section();

		/**
		 * Carousel settings.
		 */
		$this->start_controls_section(
			'carousel_style_section',
			[
				'label'     => esc_html__('Carousel', 'coldest'),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'layout' => 'carousel',
				],
			]
		);

		$this->add_control(
			'slides_per_view',
			[
				'label'       => esc_html__('Slides per view', 'coldest'),
				'description' => esc_html__('Set numbers of slides you want to display at the same time on slider\'s container for carousel mode.', 'coldest'),
				'type'        => Controls_Manager::SLIDER,
				'default'     => [
					'size' => 3,
				],
				'size_units'  => '',
				'range'       => [
					'px' => [
						'min'  => 1,
						'max'  => 8,
						'step' => 1,
					],
				],
			]
		);

		$this->add_control(
			'scroll_per_page',
			[
				'label'        => esc_html__('Scroll per page', 'coldest'),
				'description'  => esc_html__('Scroll per page not per item. This affect next/prev buttons and mouse/touch dragging.', 'coldest'),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'label_on'     => esc_html__('Yes', 'coldest'),
				'label_off'    => esc_html__('No', 'coldest'),
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'hide_pagination_control',
			[
				'label'        => esc_html__('Hide pagination control', 'coldest'),
				'description'  => esc_html__('If "YES" pagination control will be removed.', 'coldest'),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'label_on'     => esc_html__('Yes', 'coldest'),
				'label_off'    => esc_html__('No', 'coldest'),
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'hide_prev_next_buttons',
			[
				'label'        => esc_html__('Hide prev/next buttons', 'coldest'),
				'description'  => esc_html__('If "YES" prev/next control will be removed', 'coldest'),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'no',
				'label_on'     => esc_html__('Yes', 'coldest'),
				'label_off'    => esc_html__('No', 'coldest'),
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'center_mode',
			[
				'label'        => esc_html__('Center mode', 'coldest'),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'no',
				'label_on'     => esc_html__('Yes', 'coldest'),
				'label_off'    => esc_html__('No', 'coldest'),
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'wrap',
			[
				'label'        => esc_html__('Slider loop', 'coldest'),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'no',
				'label_on'     => esc_html__('Yes', 'coldest'),
				'label_off'    => esc_html__('No', 'coldest'),
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label'        => esc_html__('Slider autoplay', 'coldest'),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'label_on'     => esc_html__('Yes', 'coldest'),
				'label_off'    => esc_html__('No', 'coldest'),
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'speed',
			[
				'label'       => esc_html__('Slider speed', 'coldest'),
				'description' => esc_html__('Duration of animation between slides (in ms)', 'coldest'),
				'default'     => '5000',
				'type'        => Controls_Manager::NUMBER,
				'condition' => [
					'autoplay' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		
	}


	protected function render()
	{
		if (is_admin())
		{
		  // solves the width issue
		  // The javascript called after elementor scripts are fully loaded.
		  if ( ! defined( 'ELEMENTOR_VERSION' ) ) {
			  return;
		  }
		  echo "<script>jQuery('.owl-carousel').owlCarousel();</script>";
		}
		coldest_elementor_products_carousel_template($this->get_settings_for_display());
		
	}
}

Plugin::instance()->widgets_manager->register_widget_type(new Products_carousel());
