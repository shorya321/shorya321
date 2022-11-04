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

class Review_slider extends Widget_Base
{


	public function __construct($data = [], $args = null)
	{
		parent::__construct($data, $args);

		require_once(__DIR__ . '/review-slider.php');
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
		return 'wd_top_bar';
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
		return esc_html__('Review Slider', 'coldest');
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
		wp_register_style('coldest_dynamic_ticker_style', get_stylesheet_directory_uri() . '/elementor/top-bar/assets/css/dynamic-ticker.css', array('elementor-frontend'), '1.0.0');
		return ['coldest_dynamic_ticker_style'];
	}

	/**
	 * Enqueue script
	 */
	public function get_script_depends()
	{
		wp_register_script('coldest_dynamic_ticker_js', get_stylesheet_directory_uri() . '/elementor/top-bar/assets/js/dynamic-ticker.js', array('elementor-frontend'), '1.0.0', true);
		return ['coldest_dynamic_ticker_js'];
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
		 * Tabs settings.
		 */

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

		$repeater->add_control(
			'title',
			[
				'label'   => esc_html__('Text', 'coldest'),
				'type'    => Controls_Manager::TEXT,
				'default' => 'Tab title',
			]
		);

		$repeater->add_control(
			'button_title',
			[
				'label'   => esc_html__('URL Name', 'coldest'),
				'type'    => Controls_Manager::TEXT,
				'default' => 'Name',
			]
		);

		$repeater->add_control(
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
		/**
         * Style tab.
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
                    '{{WRAPPER}} .tfc-topbar-Slides a ' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'tab_content_typography',
                'selector' => '{{WRAPPER}} .tfc-topbar-content',
            ]
        );

        $this->end_controls_section();

	}


	protected function render()
	{

		coldest_dynamic_ticker_elementor_products_tabs_template($this->get_settings_for_display());
	}
}

Plugin::instance()->widgets_manager->register_widget_type(new Top_bar());
