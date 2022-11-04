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

class Products_tabs extends Widget_Base
{


	public function __construct($data = [], $args = null)
	{
		parent::__construct($data, $args);
		require_once(__DIR__ . '/products-tabs.php');
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
		return 'wd_products_tabs';
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
		return esc_html__('Products tabs', 'coldest');
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
	 * Get widget categories.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories()
	{
		return ['wd-elements'];
	}

	/**
	 * Enqueue style
	 */
	public function get_style_depends()
	{
		wp_register_style('coldest_products_tabs_style', get_stylesheet_directory_uri() . '/elementor/products-tabs/assets/css/coldest-tabs.css', array(), '1.0.0');
		return ['coldest_products_tabs_style'];
	}

	/**
	 * Enqueue script
	 */
	public function get_script_depends()
	{
		wp_register_script('coldest_products_tabs_js', get_stylesheet_directory_uri() . '/elementor/products-tabs/assets/js/coldest-tabs.js', array(), '1.0.0', true);
		return ['coldest_products_tabs_js'];
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
				'label'   => esc_html__('Tabs title', 'coldest'),
				'type'    => Controls_Manager::TEXT,
				'default' => 'Title text example',
			]
		);

		$this->end_controls_section();


		/**
		 * Image settings.
		 */
		$this->start_controls_section(
			'image_content_section',
			[
				'label' => esc_html__('Image', 'coldest'),
			]
		);

		$this->add_control(
			'image',
			[
				'label' => esc_html__('Choose image', 'coldest'),
				'type'  => Controls_Manager::MEDIA,
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'image',
				'default'   => 'thumbnail',
				'separator' => 'none',
			]
		);

		$this->end_controls_section();


		/**
		 * Tabs settings.
		 */
		$this->start_controls_section(
			'tabs_content_section',
			[
				'label' => esc_html__('Tabs', 'coldest'),
			]
		);

		$repeater = new Repeater();

		$repeater->start_controls_tabs('content_tabs');

		$repeater->start_controls_tab(
			'query_tab',
			[
				'label' => esc_html__('Query', 'coldest'),
			]
		);

		$repeater->add_control(
			'tfc_category_name',
			[
				'label' => esc_html__('Select Category', 'coldest'),
				'type' => Controls_Manager::SELECT2,
				'multiple' => false,
				'options' => coldest_wc_get_taxonomies_by_query(),
				'default' => '',
			]
		);

		$repeater->end_controls_tab();

		$repeater->start_controls_tab(
			'text_tab',
			[
				'label' => esc_html__('Text', 'coldest'),
			]
		);

		$repeater->add_control(
			'title',
			[
				'label'   => esc_html__('Tabs title', 'coldest'),
				'type'    => Controls_Manager::TEXT,
				'default' => 'Tab title',
			]
		);

		$repeater->end_controls_tab();


		$this->add_control(
			'tabs_items',
			[
				'type'        => Controls_Manager::REPEATER,
				'title_field' => '{{{ title }}}',
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[
						'title' => 'Tab title 1',
					],
					[
						'title' => 'Tab title 2',
					],
					[
						'title' => 'Tab title 3',
					],
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__('Button', 'coldest'),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'button_title',
			[
				'label'   => esc_html__('Name', 'coldest'),
				'type'    => Controls_Manager::TEXT,
				'default' => 'Shop All',
			]
		);

		$this->add_control(
			'website_link',
			[
				'label' => esc_html__('Link', 'coldest'),
				'type' => Controls_Manager::URL,
				'placeholder' => esc_html__('https://your-link.com', 'coldest'),
				'options' => ['url', 'is_external', 'nofollow'],
				'default' => [
					'url' => '',
					'is_external' => true,
					'nofollow' => true,
					// 'custom_attributes' => '',
				],
				'label_block' => true,
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
			'design',
			[
				'label'   => esc_html__('Design', 'coldest'),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'default' => esc_html__('Default', 'coldest'),
					'simple'  => esc_html__('Simple', 'coldest'),
					'alt'     => esc_html__('Alternative', 'coldest'),
				],
				'default' => 'default',
			]
		);

		$this->add_control(
			'color',
			[
				'label'     => esc_html__('Color', 'coldest'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tfc-tab-wrap .tabs-name.title .tfc-seller-heading' => 'color: {{VALUE}}',
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
				'selector' => '{{WRAPPER}} .tfc-seller-heading',
			]
		);


		$this->end_controls_section();

		/**
		 * Tab settings.
		 */

		$this->start_controls_section(
			'tab_style_sections',
			[
				'label' => esc_html__('Tab', 'coldest'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'tab_color',
			[
				'label'     => esc_html__('Color', 'coldest'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tfc-tab-wrap .tab-menu .products-tabs-title .tab-a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'tab_content_typography',
				'selector' => '{{WRAPPER}} .tfc-tab-wrap .tab-menu .products-tabs-title .tab-a',
			]
		);

		$this->end_controls_section();

		/**
		 * Button settings.
		 */

		$this->start_controls_section(
			'tab_button_style_sections',
			[
				'label' => esc_html__('Button', 'coldest'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'tab_button_color',
			[
				'label'     => esc_html__('Color', 'coldest'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tfc-tab-wrap .tfc_button a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'tab_button_bgcolor',
			[
				'label'     => esc_html__('Background color', 'coldest'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tfc-tab-wrap .tfc_button' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'tab_button_content_typography',
				'selector' => '{{WRAPPER}} .tfc-tab-wrap .tfc_button a',
			]
		);

		$this->end_controls_section();
	}


	protected function render()
	{

		coldest_elementor_products_tabs_template($this->get_settings_for_display());
	}
}

Plugin::instance()->widgets_manager->register_widget_type(new Products_tabs());
