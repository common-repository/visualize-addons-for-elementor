<?php
namespace Visualize\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Scheme_Color;
use Elementor\Controls_Stack;
use Elementor\Group_Control_Background;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * visualizecarousel
 *
 * Elementor widget for visualizecarousel
 *
 * @since 1.0.0
 */
class VisualizeCarousel extends Widget_Base {

	/**
	 * Retrieve the widget name.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'Visualize-Carousel';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Visualize Carousel', 'visualize' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-posts-ticker';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * Note that currently Elementor supports only one category.
	 * When multiple categories passed, Elementor uses the first one.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'visualize-widgets' ];
	}

	/**
	 * Retrieve the list of scripts the widget depended on.
	 *
	 * Used to set scripts dependencies required to run the widget.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return array Widget scripts dependencies.
	 */
	public function get_script_depends() {
		return [ 'owl-carousel', 'visualize-scripts' ];
	}

	/**
	 * Retrieve the list of styles the widget depended on.
	 *
	 * Used to set styles dependencies required to run the widget.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return array Widget styles dependencies.
	 */
	public function get_style_depends(){
		return [ 'owl-carousel', 'visualize-stylesheets' ];
	}

	/**
	* Controls Data Element
	*
	* add controls field for data element
	*
	* @since 1.0.0 
	*
	*/
	public function controls_element_data(){
		$this->start_controls_section(
			'section_content',
			[
				'label' => __( 'Carousel Settings', 'visualize' ),
			]
		);

		$this->add_control(
			'data_source',
			[
				'label' => esc_html__( 'Data Source', 'visualize' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'post',
				'options' =>  get_post_types(array('public' => true)),
			]
		);

		$this->add_control(
			'carousel_active_items',
			[
				'label' => __( 'Active Items', 'visualize' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( '2', 'visualize' ),
				'placeholder' => __( 'Type Carousel Active Items', 'visualize' ),
			]
		);

		$this->add_control(
			'order',
			[
				'label' => esc_html__( 'Order', 'visualize' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'DESC',
				'options' => [
					'DESC' => 'DESC',
					'ASC'  => 'ASC'
				],
			]
		);	

		$this->add_control(
			'custom_field',
			[
				'label' => __( 'Custom Field ID', 'visualize' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => __( 'Type your Custom Field Name', 'visualize' ),
			]
		);
		$this->add_control(
			'carousel_item_distance',
			[
				'label' => __( 'Space between carousel item', 'visualize' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 100,
				'step' => 5,
				'default' => 30,
			]
		);

		$this->end_controls_section();
	}


	
	/**
	* Controls Element Setting
	*
	* add controls field for element settings
	*
	* @since 1.0.0 
	*
	*/
	public function controls_element_order(){
		$this->start_controls_section(
			'element_order',
			[
				'label' => __( 'Element Settings', 'visualize' ),
			]
		);


		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'element_order_and_visibility', [
				'label' => __( 'Title', 'visualize' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'label_block' => true,
				'options' => [
					'post_thumbnail'  	=> __( 'Post Thumbnail', 'visualize' ),
					'post_title' 		=> __( 'Post Title', 'visualize' ),
					'post_content' 		=> __( 'Post Content', 'visualize' ),
					'post_readmore' 	=> __( 'Post ReadMore', 'visualize' ),
				],
			]
		);
		// thumbnail related field
			$repeater->add_control(
				'show_thumb',
				[
					'label' => __( 'Show Thumbnail', 'visualize' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => __( 'Show', 'your-plugin' ),
					'label_off' => __( 'Hide', 'your-plugin' ),
					'return_value' => 'yes',
					'default' => 'yes',
					'condition' => [
	                    'element_order_and_visibility' => 'post_thumbnail',
	                ],
				]
			);
			$repeater->add_control(
				'show_title',
				[
					'label' => __( 'Show Title', 'visualize' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => __( 'Show', 'your-plugin' ),
					'label_off' => __( 'Hide', 'your-plugin' ),
					'return_value' => 'yes',
					'default' => 'yes',
					'condition' => [
	                    'element_order_and_visibility' => 'post_thumbnail',
	                ],
				]
			);
			$repeater->add_control(
				'show_custom_field',
				[
					'label' => __( 'Show Custom Field Data', 'visualize' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => __( 'Show', 'your-plugin' ),
					'label_off' => __( 'Hide', 'your-plugin' ),
					'return_value' => 'yes',
					'default' => 'yes',
					'condition' => [
	                    'element_order_and_visibility' => 'post_thumbnail',
	                ],
				]
			);
		// end thumbnail related field

		// start content realted field
			$repeater->add_control(
				'content_limit',
				[
					'label' => __( 'Content Limit', 'visualize' ),
					'description' => __('if you want to showing full content, please set -1', 'visualize'),
					'type' => \Elementor\Controls_Manager::NUMBER,
					'min' => -1,
					'max' => 500,
					'step' => 5,
					'default' => 30,
					'condition' => [
	                    'element_order_and_visibility' => 'post_content',
	                ],
				]
			);
		// end content realted field

		$this->add_control(
			'element_order_and_visibility_list',
			[
				'label' => __( 'Element Sorting, add and remove', 'visualize' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'element_order_and_visibility' => 'post_thumbnail',
					],
					[
						'element_order_and_visibility' => 'post_content',
					],
					[
						'element_order_and_visibility' => 'post_readmore',
					],
				],
				'title_field' => '{{{ element_order_and_visibility }}}',
			]
		);



		$this->end_controls_section();
	}

	/**
	* Carousel Item Style
	*/

	public function controls_element_carousel_item_style(){

		$this->start_controls_section(
			'carousel_item_section',
			[
				'label' => __( 'Carousel Item Style', 'plugin-name' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'carousel_item_padding',
			[
				'label' => __( 'Padding', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .visualize-carousel-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'carousel_item_margin',
			[
				'label' => __( 'Margin', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .visualize-carousel-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		// border radius
		$this->add_control(
			'carousel_item_border_radius',
			[
				'label' => __( 'Border Radius', 'visualize' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .visualize-carousel .visualize-carousel-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		// box shadow
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'carousel_item_box_shadow',
				'label' => __( 'Box Shadow', 'visualize' ),
				'selector' => '{{WRAPPER}} .visualize-carousel .visualize-carousel-item',
			]
		);
		// border
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'carousel_item_border',
				'label' => __( 'Border', 'visualize' ),
				'selector' => '{{WRAPPER}} .visualize-carousel .visualize-carousel-item',
			]
		);

		// background
		$this->add_control(
			'carousel_item_important_note',
			[
				'label' => __( 'Background Settings', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::RAW_HTML,
			]
		);
		$this->start_controls_tabs( 'carousel_item_tabs_background' );

		$this->start_controls_tab(
			'carousel_item_tab_background_normal',
			[
				'label' => __( 'Normal', 'visualize' ),
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'carousel_item_background',
				'selector' => '{{WRAPPER}} .visualize-carousel .visualize-carousel-item',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'carousel_item_tab_background_hover',
			[
				'label' => __( 'Hover', 'visualize' ),
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'carousel_item_background_hover',
				'selector' => '{{WRAPPER}} .visualize-carousel .visualize-carousel-item:hover',
			]
		);

		$this->add_control(
			'carousel_item_background_hover_transition',
			[
				'label' => __( 'Transition Duration', 'visualize' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 3,
						'step' => 0.1,
					],
				],
				'render_type' => 'ui',
				'separator' => 'before',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		


		$this->end_controls_section();
	}

	
	/**
	* Controls Thumbnail Style
	*
	* add controls field for Thumbnail Style
	*
	* @since 1.0.0 
	*
	*/
	public function controls_element_thumbnail_style(){
		$this->start_controls_section(
			'section_style',
			[
				'label' => __( 'Element -- Thumbnail', 'visualize' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'thumbnail_margin',
			[
				'label' => __( 'Margin', 'visualize' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .visualize-carousel-wrap .visualize-meta-thumb' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'thumbnail_padding',
			[
				'label' => __( 'Padding', 'visualize' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .visualize-carousel-wrap .visualize-meta-thumb' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'thumbnail_border_radius',
			[
				'label' => __( 'Thumbnail Border Radius', 'visualize' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .visualize-carousel-wrap .visualize-meta-thumb img, {{WRAPPER}} .visualize-carousel-wrap .visualize-meta-thumb img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);


		$this->add_responsive_control(
			'thumbnail_width',
			[
				'label' => __( 'Width', 'visualize' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => '%',
				],
				'tablet_default' => [
					'unit' => '%',
				],
				'mobile_default' => [
					'unit' => '%',
				],
				'size_units' => [ '%', 'px', 'vw' ],
				'range' => [
					'%' => [
						'min' => 1,
						'max' => 100,
					],
					'px' => [
						'min' => 1,
						'max' => 1000,
					],
					'vw' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .visualize-carousel-wrap .visualize-meta-thumb img' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);


		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'thubnail_box_shadow',
				'label' => __( 'Box Shadow', 'visualize' ),
				'selector' => '{{WRAPPER}} .visualize-carousel-wrap .visualize-meta-thumb img',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'thumbnail_border',
				'label' => __( 'Border', 'visualize' ),
				'selector' => '{{WRAPPER}} .visualize-carousel-wrap .visualize-meta-thumb img',
			]
		);



		$this->end_controls_section();
	}

	/**
	* Controls Title Style
	*
	* add controls field for Thumbnail Style
	*
	* @since 1.0.0 
	*/
	public function controls_element_title_style(){
		$this->start_controls_section(
			'title_style',
			[
				'label' => __( 'Element -- Title', 'visualize' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => __( 'Typography', 'visualize' ),
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .visualize-carousel .visualize-carousel-item .entry-title a',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => __( 'Title Color', 'visualize' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'scheme' => [
					'type' => \Elementor\Scheme_Color::get_type(),
					'value' => \Elementor\Scheme_Color::COLOR_1,
				],
				'default'	=> '#000',
				'selectors' => [
					'{{WRAPPER}} .visualize-carousel .visualize-carousel-item .entry-title a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'title_margin',
			[
				'label' => __( 'Margin', 'visualize' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .visualize-carousel .visualize-carousel-item .entry-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'title_padding',
			[
				'label' => __( 'Padding', 'visualize' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .visualize-carousel .visualize-carousel-item .entry-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);


		$this->end_controls_section();
	}

	/**
	* Controls Custom Field style
	*
	* add controls Custom Field style
	*
	* @since 1.0.0 
	*/
	public function controls_element_custom_field_style(){
		$this->start_controls_section(
			'sub_title',
			[
				'label' => __( 'Element -- Custom Field', 'visualize' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'sub_title_typography',
				'label' => __( 'Typography', 'visualize' ),
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .visualize-carousel-wrap .visualize-meta-content .sub-title',
			]
		);

		$this->add_control(
			'sub_title_color',
			[
				'label' => __( 'Color', 'visualize' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'scheme' => [
					'type' => \Elementor\Scheme_Color::get_type(),
					'value' => \Elementor\Scheme_Color::COLOR_1,
				],
				'default'	=> '#444',
				'selectors' => [
					'{{WRAPPER}} .visualize-carousel-wrap .visualize-meta-content .sub-title' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'sub_title_margin',
			[
				'label' => __( 'Margin', 'visualize' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .visualize-carousel-wrap .visualize-meta-content .sub-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'sub_title_padding',
			[
				'label' => __( 'Padding', 'visualize' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .visualize-carousel-wrap .visualize-meta-content .sub-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);


		$this->end_controls_section();
	}

	
	/**
	* Controls Thumbnail & meta flex position
	*
	* add controls Thumbnail & meta flex position
	*
	* @since 1.0.0 
	*/
	public function controls_element_thumbnail_and_meta_field_style(){
		$this->start_controls_section(
			'thumbnail_meta_control',
			[
				'label' => __( 'Element -- Thumbnail & Meta Flex Position', 'visualize' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
		$repeater = new \Elementor\Repeater();
		$repeater->add_control(
			'visualize_meta_positon', [
				'label' => __( 'Select CSS Properties', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'label_block' => true,
				'options' => [
					'display:flex;'  					=> __( 'display:flex', 'visualize' ),
					'justify-content:flex-start;'  		=> __( 'justify-content:flex-start', 'visualize' ),
					'justify-content:flex-end;'  		=> __( 'justify-content:flex-end', 'visualize' ),
					'justify-content:center;'  			=> __( 'justify-content:center', 'visualize' ),
					'justify-content:space-between;'  	=> __( 'justify-content:space-between', 'visualize' ),
					'justify-content:space-around;'  	=> __( 'justify-content:space-around', 'visualize' ),
					'justify-content:initial;'  		=> __( 'justify-content:initial', 'visualize' ),
					'justify-content:inherit;'  		=> __( 'justify-content:inherit', 'visualize' ),
					'align-items:baseline;' 			=> __( 'align-items:baseline', 'visualize' ),
					'align-items:center;' 				=> __( 'align-items:center', 'visualize' ),
					'align-items:flex-start;' 			=> __( 'align-items:flex-start', 'visualize' ),
					'align-items:flex-end;' 			=> __( 'align-items:flex-end', 'visualize' ),
					'align-items:stretch;' 				=> __( 'align-items:stretch', 'visualize' ),
					'align-items:initial;' 				=> __( 'align-items:initial', 'visualize' ),
					'align-items:inherit;' 				=> __( 'align-items:inherit', 'visualize' ),
				],
				'selectors' => [
					'{{WRAPPER}} .visualize-carousel-wrap .visualize-meta' => '{{VALUE}}',
				],
			]
		);

		

		

		$this->add_control(
			'visualize-meta-style',
			[
				'label' => __( 'Add Style', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'title_field' => '{{{ visualize_meta_positon }}}',
			]
		);

		
		

		
		


		$this->end_controls_section();
	}

	
	/**
	* Controls paragraph style
	*
	* add controls paragraph style
	*
	* @since 1.0.0 
	*/
	public function controls_element_paragraph_style(){
		$this->start_controls_section(
			'paragraph',
			[
				'label' => __( 'Element -- Paragraph', 'visualize' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'paragraph_typography',
				'label' => __( 'Typography', 'visualize' ),
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .visualize-carousel-wrap .visualize-carousel-item p',
			]
		);

		$this->add_control(
			'paragraph_color',
			[
				'label' => __( 'Color', 'visualize' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'scheme' => [
					'type' => \Elementor\Scheme_Color::get_type(),
					'value' => \Elementor\Scheme_Color::COLOR_1,
				],
				'default'	=> '#444',
				'selectors' => [
					'{{WRAPPER}} .visualize-carousel-wrap .visualize-carousel-item p' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'paragraph_margin',
			[
				'label' => __( 'Margin', 'visualize' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .visualize-carousel-wrap .visualize-carousel-item p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'paragraph_padding',
			[
				'label' => __( 'Padding', 'visualize' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .visualize-carousel-wrap .visualize-carousel-item p' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);


		$this->end_controls_section();
	}


	/**
	* Controls Read More style
	*
	* add controls Read More style
	*
	* @since 1.0.0 
	*/
	public function controls_element_read_more_style(){
		$this->start_controls_section(
			'readmore',
			[
				'label' => __( 'Element -- Read More', 'visualize' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'readmore_margin',
			[
				'label' => __( 'Margin', 'visualize' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .visualize-carousel-read-more' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'readmore_padding',
			[
				'label' => __( 'Padding', 'visualize' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .visualize-carousel-read-more' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'readmore_typography',
				'label' => __( 'Typography', 'visualize' ),
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .visualize-carousel-read-more',
			]
		);

		// tab normal mode
		$this->start_controls_tabs( 'tabs_button_style' );

			$this->start_controls_tab(
				'tab_button_normal',
				[
					'label' => __( 'Normal', 'visualize' ),
				]
			);

				$this->add_control(
					'button_text_color',
					[
						'label' => __( 'Text Color', 'visualize' ),
						'type' => Controls_Manager::COLOR,
						'default' => '',
						'selectors' => [
							'{{WRAPPER}} a.visualize-carousel-read-more, {{WRAPPER}} .visualize-carousel-read-more' => 'fill: {{VALUE}}; color: {{VALUE}};',
						],
					]
				);

				$this->add_control(
					'background_color',
					[
						'label' => __( 'Background Color', 'visualize' ),
						'type' => Controls_Manager::COLOR,
						'scheme' => [
							'type' => Scheme_Color::get_type(),
							'value' => Scheme_Color::COLOR_4,
						],
						'default' => 'transparent',
						'selectors' => [
							'{{WRAPPER}} a.visualize-carousel-read-more, {{WRAPPER}} .visualize-carousel-read-more' => 'background-color: {{VALUE}};',
						],
					]
				);
				$this->add_group_control(
					Group_Control_Border::get_type(),
					[
						'name' => 'readmore_border',
						'label' => __( 'Border', 'visualize' ),
						'selector' => '{{WRAPPER}} .visualize-carousel-read-more',
					]
				);
				$this->add_control(
					'button_border_color',
					[
						'label' => __( 'Border Color', 'visualize' ),
						'type' => Controls_Manager::COLOR,
						'condition' => [
							'readmore_border!' => '',
						],
						'selectors' => [
							'{{WRAPPER}} a.visualize-carousel-read-more, {{WRAPPER}} .visualize-carousel-read-more' => 'border-color: {{VALUE}};',
						],
						'default' => '',
					]
				);

				$this->add_group_control(
					Group_Control_Box_Shadow::get_type(),
					[
						'name' => 'readmore_box_shadow',
						'label' => __( 'Box Shadow', 'visualize' ),
						'selector' => '{{WRAPPER}} a.visualize-carousel-read-more, {{WRAPPER}} .visualize-carousel-read-more',
					]
				);

			$this->end_controls_tab();
		// hover mode
			$this->start_controls_tab(
				'tab_button_hover',
				[
					'label' => __( 'Hover', 'visualize' ),
				]
			);

				$this->add_control(
					'hover_color',
					[
						'label' => __( 'Text Color', 'visualize' ),
						'type' => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} a.visualize-carousel-read-more:hover, {{WRAPPER}} .visualize-carousel-read-more:hover, {{WRAPPER}} a.visualize-carousel-read-more:focus, {{WRAPPER}} .visualize-carousel-read-more:focus' => 'color: {{VALUE}};',
						],
						'default' => '',
					]
				);

				$this->add_control(
					'button_background_hover_color',
					[
						'label' => __( 'Background Color', 'visualize' ),
						'type' => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} a.visualize-carousel-read-more:hover, {{WRAPPER}} .visualize-carousel-read-more:hover, {{WRAPPER}} a.visualize-carousel-read-more:focus, {{WRAPPER}} .visualize-carousel-read-more:focus' => 'background-color: {{VALUE}};',
						],
						'default' => '',
					]
				);
				$this->add_group_control(
					Group_Control_Border::get_type(),
					[
						'name' => 'readmore_hover_border',
						'label' => __( 'Border', 'visualize' ),
						'selector' => '{{WRAPPER}} a.visualize-carousel-read-more:hover, {{WRAPPER}} .visualize-carousel-read-more:hover, {{WRAPPER}} a.visualize-carousel-read-more:focus, {{WRAPPER}} .visualize-carousel-read-more:focus',
					]
				);
				$this->add_control(
					'button_hover_border_color',
					[
						'label' => __( 'Border Color', 'visualize' ),
						'type' => Controls_Manager::COLOR,
						'condition' => [
							'readmore_border!' => '',
						],
						'selectors' => [
							'{{WRAPPER}} a.visualize-carousel-read-more:hover, {{WRAPPER}} .visualize-carousel-read-more:hover, {{WRAPPER}} a.visualize-carousel-read-more:focus, {{WRAPPER}} .visualize-carousel-read-more:focus' => 'border-color: {{VALUE}};',
						],
						'default' => '',
					]
				);

				$this->add_control(
					'hover_animation',
					[
						'label' => __( 'Hover Animation', 'visualize' ),
						'type' => Controls_Manager::HOVER_ANIMATION,
					]
				);

				$this->add_group_control(
					Group_Control_Box_Shadow::get_type(),
					[
						'name' => 'readmore_hover_box_shadow',
						'label' => __( 'Box Shadow', 'visualize' ),
						'selector' => '{{WRAPPER}} a.visualize-carousel-read-more:hover, {{WRAPPER}} .visualize-carousel-read-more:hover, {{WRAPPER}} a.visualize-carousel-read-more:focus, {{WRAPPER}} .visualize-carousel-read-more:focus',
					]
				);

			$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}


	
	/**
	* Controls Arrow Button Style
	*
	* add controls Arrow Button Style
	*
	* @since 1.0.0 
	*/
	public function controls_element_arrow_button_style(){
		$this->start_controls_section(
			'arrowbutton',
			[
				'label' => __( 'Element -- Arrow Button', 'visualize' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'arrowbutton_margin',
			[
				'label' => __( 'Margin', 'visualize' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .visualize-carousel .owl-nav button.owl-next, {{WRAPPER}} .visualize-carousel .owl-nav button.owl-prev' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'arrowbutton_padding',
			[
				'label' => __( 'Padding', 'visualize' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .visualize-carousel .owl-nav button.owl-next, {{WRAPPER}} .visualize-carousel .owl-nav button.owl-prev' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			]
		);

		

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'arrowbutton_typography',
				'label' => __( 'Typography', 'visualize' ),
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .visualize-carousel .owl-nav button.owl-next, {{WRAPPER}} .visualize-carousel .owl-nav button.owl-prev',
			]
		);

		// tab normal mode
		$this->start_controls_tabs( 'tabs_button_arrow_style' );

			$this->start_controls_tab(
				'tab_button_arrow_normal',
				[
					'label' => __( 'Normal', 'visualize' ),
				]
			);

				$this->add_control(
					'show_arrowbutton',
					[
						'label' => __( 'Show / Hide Arrow Nav Control', 'plugin-domain' ),
						'type' => \Elementor\Controls_Manager::SWITCHER,
						'label_on' => __( 'Show', 'your-plugin' ),
						'label_off' => __( 'Hide', 'your-plugin' ),
						'return_value' => 'none',
						'default' => 'block',
						'selectors' => [
							'{{WRAPPER}} .visualize-carousel .owl-nav' => 'display: {{VALUE}}',
						]
					]
				);

				$this->add_control(
					'arrowbutton_text_color',
					[
						'label' => __( 'Text Color', 'visualize' ),
						'type' => Controls_Manager::COLOR,
						'default' => '',
						'selectors' => [
							'{{WRAPPER}} .visualize-carousel .owl-nav button.owl-next, {{WRAPPER}} .visualize-carousel .owl-nav button.owl-prev' => 'fill: {{VALUE}}; color: {{VALUE}};',
						],
					]
				);

				$this->add_control(
					'arrowbutton_background_color',
					[
						'label' => __( 'Background Color', 'visualize' ),
						'type' => Controls_Manager::COLOR,
						'scheme' => [
							'type' => Scheme_Color::get_type(),
							'value' => Scheme_Color::COLOR_4,
						],
						'default' => 'transparent',
						'selectors' => [
							'{{WRAPPER}} .visualize-carousel .owl-nav button.owl-next, {{WRAPPER}} .visualize-carousel .owl-nav button.owl-prev' => 'background-color: {{VALUE}};',
						],
					]
				);
				$this->add_group_control(
					Group_Control_Border::get_type(),
					[
						'name' => 'arrowbutton_border',
						'label' => __( 'Border', 'visualize' ),
						'selector' => '{{WRAPPER}} .visualize-carousel .owl-nav button.owl-next, {{WRAPPER}} .visualize-carousel .owl-nav button.owl-prev',
					]
				);
				$this->add_control(
					'arrow_button_border_color',
					[
						'label' => __( 'Border Color', 'visualize' ),
						'type' => Controls_Manager::COLOR,
						'condition' => [
							'arrowbutton_border!' => '',
						],
						'selectors' => [
							'{{WRAPPER}} .visualize-carousel .owl-nav button.owl-next, {{WRAPPER}} .visualize-carousel .owl-nav button.owl-prev' => 'border-color: {{VALUE}};',
						],
						'default' => '',
					]
				);
				$this->add_control(
					'arrowbutton_border_radius',
					[
						'label' => __( 'Border Radius', 'visualize' ),
						'type' => Controls_Manager::DIMENSIONS,
						'size_units' => [ 'px', '%' ],
						'selectors' => [
							'{{WRAPPER}} .visualize-carousel .owl-nav button.owl-next, {{WRAPPER}} .visualize-carousel .owl-nav button.owl-prev' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
					]
				);

				$this->add_group_control(
					Group_Control_Box_Shadow::get_type(),
					[
						'name' => 'arrowbutton_box_shadow',
						'label' => __( 'Box Shadow', 'visualize' ),
						'selector' => '{{WRAPPER}} .visualize-carousel .owl-nav button.owl-next, {{WRAPPER}} .visualize-carousel .owl-nav button.owl-prev',
					]
				);

			$this->end_controls_tab();
		// hover mode
			$this->start_controls_tab(
				'tab_button_arrow_hover',
				[
					'label' => __( 'Hover', 'visualize' ),
				]
			);
				$this->add_control(
					'show_arrowbutton_hover',
					[
						'label' => __( 'Show / Hide Arrow Nav Control', 'plugin-domain' ),
						'type' => \Elementor\Controls_Manager::SWITCHER,
						'label_on' => __( 'Show', 'your-plugin' ),
						'label_off' => __( 'Hide', 'your-plugin' ),
						'return_value' => 'block',
						'default' => 'block',
						'selectors' => [
							'{{WRAPPER}} .visualize-carousel:hover .owl-nav' => 'display: {{VALUE}}',
						]
					]
				);

				$this->add_control(
					'arrow_button_hover_color',
					[
						'label' => __( 'Text Color', 'visualize' ),
						'type' => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .visualize-carousel .owl-nav button.owl-next:hover, {{WRAPPER}} .visualize-carousel .owl-nav button.owl-next:focus, {{WRAPPER}} .visualize-carousel .owl-nav button.owl-prev:hover, {{WRAPPER}} .visualize-carousel .owl-nav button.owl-prev:focus' => 'color: {{VALUE}};',
						],
						'default' => '',
					]
				);

				$this->add_control(
					'arrowbutton_background_hover_color',
					[
						'label' => __( 'Background Color', 'visualize' ),
						'type' => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .visualize-carousel .owl-nav button.owl-next:hover, {{WRAPPER}} .visualize-carousel .owl-nav button.owl-next:focus, {{WRAPPER}} .visualize-carousel .owl-nav button.owl-prev:hover, {{WRAPPER}} .visualize-carousel .owl-nav button.owl-prev:focus' => 'background-color: {{VALUE}};',
						],
						'default' => '',
					]
				);
				$this->add_group_control(
					Group_Control_Border::get_type(),
					[
						'name' => 'arrowbutton_hover_border',
						'label' => __( 'Border', 'visualize' ),
						'selector' => '{{WRAPPER}} .visualize-carousel .owl-nav button.owl-next:hover, {{WRAPPER}} .visualize-carousel .owl-nav button.owl-next:focus, {{WRAPPER}} .visualize-carousel .owl-nav button.owl-prev:hover, {{WRAPPER}} .visualize-carousel .owl-nav button.owl-prev:focus',
					]
				);
				$this->add_control(
					'arrow_button_hover_border_color',
					[
						'label' => __( 'Border Color', 'visualize' ),
						'type' => Controls_Manager::COLOR,
						'condition' => [
							'arrowbutton_border!' => '',
						],
						'selectors' => [
							'{{WRAPPER}} .visualize-carousel .owl-nav button.owl-next:hover, {{WRAPPER}} .visualize-carousel .owl-nav button.owl-next:focus, {{WRAPPER}} .visualize-carousel .owl-nav button.owl-prev:hover, {{WRAPPER}} .visualize-carousel .owl-nav button.owl-prev:focus' => 'border-color: {{VALUE}};',
						],
						'default' => '',
					]
				);

				$this->add_control(
					'arrowbutton_hover_animation',
					[
						'label' => __( 'Hover Animation', 'visualize' ),
						'type' => Controls_Manager::HOVER_ANIMATION,
					]
				);

				$this->add_control(
					'arrowbutton_hover_border_radius',
					[
						'label' => __( 'Border Radius', 'visualize' ),
						'type' => Controls_Manager::DIMENSIONS,
						'size_units' => [ 'px', '%' ],
						'selectors' => [
							'{{WRAPPER}} .visualize-carousel .owl-nav button.owl-next:hover, {{WRAPPER}} .visualize-carousel .owl-nav button.owl-next:focus, {{WRAPPER}} .visualize-carousel .owl-nav button.owl-prev:hover, {{WRAPPER}} .visualize-carousel .owl-nav button.owl-prev:focus' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
					]
				);

				$this->add_group_control(
					Group_Control_Box_Shadow::get_type(),
					[
						'name' => 'arrowbutton_hover_box_shadow',
						'label' => __( 'Box Shadow', 'visualize' ),
						'selector' => '{{WRAPPER}} .visualize-carousel .owl-nav button.owl-next:hover, {{WRAPPER}} .visualize-carousel .owl-nav button.owl-next:focus, {{WRAPPER}} .visualize-carousel .owl-nav button.owl-prev:hover, {{WRAPPER}} .visualize-carousel .owl-nav button.owl-prev:focus',
					]
				);

			$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}


	/**
	* Controls Arrow Button Position
	*
	* add controls Arrow Button Position
	*
	* @since 1.0.0 
	*/
	public function controls_element_arrow_button_position(){
		$this->start_controls_section(
			'arrowbutton_position',
			[
				'label' => __( 'Element -- Arrow Button Position', 'visualize' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control(
			'arrow_button_element_custom_width',
			[
				'label' => __( 'Custom Width', 'visualize' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 1000,
						'step' => 1,
					],
					'%' => [
						'max' => 100,
						'step' => 1,
					],
				],
				'device_args' => [
					Controls_Stack::RESPONSIVE_TABLET => [
						'condition' => [
							'arrow_button_element_custom_width_tablet' => [ 'initial' ],
						],
					],
					Controls_Stack::RESPONSIVE_MOBILE => [
						'condition' => [
							'arrow_button_element_custom_width_mobile' => [ 'initial' ],
						],
					],
				],
				'size_units' => [ 'px', '%', 'vw' ],
				'selectors' => [
					'{{WRAPPER}} .visualize-carousel .owl-nav' => 'width: {{SIZE}}{{UNIT}}; max-width: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'arrow_button_element_vertical_align',
			[
				'label' => __( 'Vertical Align', 'visualize' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options' => [
					'flex-start' => [
						'title' => __( 'Start', 'visualize' ),
						'icon' => 'eicon-v-align-top',
					],
					'center' => [
						'title' => __( 'Center', 'visualize' ),
						'icon' => 'eicon-v-align-middle',
					],
					'flex-end' => [
						'title' => __( 'End', 'visualize' ),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'condition' => [
					'arrow_button_element_custom_width!' => '',
					'arrow_button_position' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .visualize-carousel .owl-nav' => 'align-self: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'arrow_button_position',
			[
				'label' => __( 'Position', 'visualize' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'Default', 'visualize' ),
					'absolute' => __( 'Absolute', 'visualize' ),
					'fixed' => __( 'Fixed', 'visualize' ),
				],
				'selectors' => [
					'{{WRAPPER}} .visualize-carousel .owl-nav' => 'position: {{VALUE}}',
				]
			]
		);

		

		$start = is_rtl() ? __( 'Right', 'visualize' ) : __( 'Left', 'visualize' );
		$end = ! is_rtl() ? __( 'Right', 'visualize' ) : __( 'Left', 'visualize' );

		$this->add_control(
			'arrow_button_offset_orientation_h',
			[
				'label' => __( 'Horizontal Orientation', 'visualize' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'toggle' => false,
				'default' => 'start',
				'options' => [
					'start' => [
						'title' => $start,
						'icon' => 'eicon-h-align-left',
					],
					'end' => [
						'title' => $end,
						'icon' => 'eicon-h-align-right',
					],
				],
				'classes' => 'elementor-control-start-end',
				'render_type' => 'ui',
				'condition' => [
					'arrow_button_position!' => '',
				],
			]
		);

		$this->add_responsive_control(
			'arrow_button_offset_x',
			[
				'label' => __( 'Offset', 'visualize' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => -1000,
						'max' => 1000,
						'step' => 1,
					],
					'%' => [
						'min' => -200,
						'max' => 200,
					],
					'vw' => [
						'min' => -200,
						'max' => 200,
					],
					'vh' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'default' => [
					'size' => '0',
				],
				'size_units' => [ 'px', '%', 'vw', 'vh' ],
				'selectors' => [
					'body:not(.rtl) {{WRAPPER}} .visualize-carousel .owl-nav' => 'left: {{SIZE}}{{UNIT}}',
					'body.rtl {{WRAPPER}} .visualize-carousel .owl-nav' => 'right: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'arrow_button_offset_orientation_h!' => 'end',
					'arrow_button_position!' => '',
				],
			]
		);

		$this->add_responsive_control(
			'arrow_button_offset_x_end',
			[
				'label' => __( 'Offset', 'visualize' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => -1000,
						'max' => 1000,
						'step' => 0.1,
					],
					'%' => [
						'min' => -200,
						'max' => 200,
					],
					'vw' => [
						'min' => -200,
						'max' => 200,
					],
					'vh' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'default' => [
					'size' => '0',
				],
				'size_units' => [ 'px', '%', 'vw', 'vh' ],
				'selectors' => [
					'body:not(.rtl) {{WRAPPER}} .visualize-carousel .owl-nav' => 'right: {{SIZE}}{{UNIT}}',
					'body.rtl {{WRAPPER}} .visualize-carousel .owl-nav' => 'left: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'_offset_orientation_h' => 'end',
					'arrow_button_position!' => '',
				],
			]
		);

		$this->add_control(
			'arrow_button_offset_orientation_v',
			[
				'label' => __( 'Vertical Orientation', 'visualize' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'toggle' => false,
				'default' => 'start',
				'options' => [
					'start' => [
						'title' => __( 'Top', 'visualize' ),
						'icon' => 'eicon-v-align-top',
					],
					'end' => [
						'title' => __( 'Bottom', 'visualize' ),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'render_type' => 'ui',
				'condition' => [
					'arrow_button_position!' => '',
				],
			]
		);

		$this->add_responsive_control(
			'arrow_button_offset_y',
			[
				'label' => __( 'Offset', 'visualize' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => -1000,
						'max' => 1000,
						'step' => 1,
					],
					'%' => [
						'min' => -200,
						'max' => 200,
					],
					'vh' => [
						'min' => -200,
						'max' => 200,
					],
					'vw' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'size_units' => [ 'px', '%', 'vh', 'vw' ],
				'default' => [
					'size' => '0',
				],
				'selectors' => [
					'{{WRAPPER}} .visualize-carousel .owl-nav' => 'top: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'arrow_button_offset_orientation_v!' => 'end',
					'arrow_button_position!' => '',
				],
			]
		);

		$this->add_responsive_control(
			'arrow_button_offset_y_end',
			[
				'label' => __( 'Offset', 'visualize' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => -1000,
						'max' => 1000,
						'step' => 1,
					],
					'%' => [
						'min' => -200,
						'max' => 200,
					],
					'vh' => [
						'min' => -200,
						'max' => 200,
					],
					'vw' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'size_units' => [ 'px', '%', 'vh', 'vw' ],
				'default' => [
					'size' => '0',
				],
				'selectors' => [
					'{{WRAPPER}} .visualize-carousel .owl-nav' => 'bottom: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'arrow_button_offset_orientation_v' => 'end',
					'arrow_button_position!' => '',
				],
			]
		);

		$this->end_controls_section();
	}
	


	/**
	 * Register the widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function _register_controls() {
		$this->controls_element_data();
		$this->controls_element_order();
		$this->controls_element_carousel_item_style();
		$this->controls_element_thumbnail_style();
		$this->controls_element_title_style();
		$this->controls_element_custom_field_style();
		$this->controls_element_thumbnail_and_meta_field_style();
		$this->controls_element_paragraph_style();
		$this->controls_element_read_more_style();
		$this->controls_element_arrow_button_style();
		$this->controls_element_arrow_button_position();
	}

	/**
	 * Render the widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function render() {
		?>

		<?php
	}

	/**
	 * Render the widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function _content_template() {
	}
}
