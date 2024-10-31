<?php
/**
 * Elementor Product List.
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.0
 */
use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Utils;

defined( 'ABSPATH' ) || die();

class WPNP_Elementor_Product_Slider_Widget_Free extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve counter widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'wpnp-product-slider';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve counter widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Product Slider', 'wooproduct-showcase' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve counter widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'nicewoo--icon rt-sliders-simple';
	}

	/**
	 * Retrieve the list of scripts the counter widget depended on.
	 *
	 * Used to set scripts dependencies required to run the widget.
	 *
	 * @since 1.3.0
	 * @access public
	 *
	 * @return array Widget scripts dependencies.
	 */
	public function get_categories() {
        return [ 'wpnp_wooproduct_category' ];
    }

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @since 2.1.0
	 * @access public
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'product', 'list', 'category', 'grid', 'slider' ];
	}

	/**
	 * Register counter widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls()
    {
    	// Content Controls
        $this->start_controls_section(
            'wpnp_section_product_grid_settings',
            [
                'label' => esc_html__('Product Settings', 'wooproduct-showcase'),
            ]
        );
        $this->add_control(
            'wpnp_product_grid_product_filter',
            [
                'label' => esc_html__('Filter By', 'wooproduct-showcase'),
                'type' => Controls_Manager::SELECT,
                'default' => 'recent-products',
                'options' => [
					'recent-products'       => esc_html__('Recent Products', 'wooproduct-showcase'),
					'selected-products'     => esc_html__('Selected Products', 'wooproduct-showcase'),
					'featured-products'     => esc_html__('Featured Products', 'wooproduct-showcase'),
					'best-selling-products' => esc_html__('Best Selling Products', 'wooproduct-showcase'),
					'sale-products'         => esc_html__('Sale Products', 'wooproduct-showcase'),
					'top-products'          => esc_html__('Top Rated Products', 'wooproduct-showcase'),
                ],
            ]
        );

        $this->add_control(
            'rt_selected_products',
            [
				'label'       => esc_html__('Select Products', 'wooproduct-showcase'),
				'type'        => Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple'    => true,
				'options'     =>wpnp_get_all_products_id_name(),
				'condition'   => [ 'wpnp_product_grid_product_filter' => 'selected-products'  ],

            ]
        );

         $this->add_control(
            'wpnp_product_grid_products_count',
            [
				'label'   => __('Products Count', 'wooproduct-showcase'),
				'type'    => Controls_Manager::NUMBER,
				'default' => 4,
				'min'     => 1,
				'max'     => 1000,
				'step'    => 1,
            ]
        );

        $this->add_control(
            'wpnp_product_grid_categories',
            [
				'label'       => esc_html__('Product Categories', 'wooproduct-showcase'),
				'type'        => Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple'    => true,
				'options'     =>wpnp_woocommerce_product_categories_lite(),
            ]
        );

        $this->add_control(
            'wpnp_product_grid_style_preset',
            [
                'label' => esc_html__('Style Preset', 'wooproduct-showcase'),
                'type' => Controls_Manager::SELECT,
                'default' => '1',
                'options' => [
					'1' => esc_html__('Style 1', 'wooproduct-showcase'),
					'2' => esc_html__('Style 2', 'wooproduct-showcase'),
					'3' => esc_html__('Style 3', 'wooproduct-showcase'),
					'4' => esc_html__('Style 4', 'wooproduct-showcase'),
					'5' => esc_html__('Style 5', 'wooproduct-showcase'),
                ],
            ]
        );
		$this->add_control(
			'hot_text',
			[
				'label' => esc_html__( 'Hot Text', 'wooproduct-showcase' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Hot', 'wooproduct-showcase' ),
				'placeholder' => esc_html__( 'Type your title here', 'wooproduct-showcase' ),
			]
		);
        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'      => 'thumbnail',
                'default'   => 'large',
                'separator' => 'before',
                'exclude'   => [
                    'custom',
                ],
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'show__category',
            [
                'label'        => esc_html__('Show Category', 'wooproduct-showcase'),
                'description' => esc_html__('Pro Only', 'wooproduct-showcase'),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => esc_html__('Show', 'wooproduct-showcase'),
                'label_off'    => esc_html__('Hide', 'wooproduct-showcase'),
                'return_value' => 'yes',
                'default'      => 'no',
                'classes'      => 'wpnp-pro-only'
            ]
        );
        $this->add_control(
            'show__rating',
            [
                'label'        => esc_html__('Show Ratings', 'wooproduct-showcase'),
                'description' => esc_html__('Pro Only', 'wooproduct-showcase'),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => esc_html__('Show', 'wooproduct-showcase'),
                'label_off'    => esc_html__('Hide', 'wooproduct-showcase'),
                'return_value' => 'yes',
                'default'      => 'no',
                'classes'      => 'wpnp-pro-only'
            ]
        );

        $this->add_control(
            'show__cart_icon',
            [
                'label'        => esc_html__('Show Cart Icon Insted of Text', 'wooproduct-showcase'),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => esc_html__('Show', 'wooproduct-showcase'),
                'label_off'    => esc_html__('Hide', 'wooproduct-showcase'),
                'return_value' => 'yes',
                'default'      => 'yes',
                'condition'    => [ 'wpnp_product_grid_style_preset!'=> ['4','5'], ],
            ]
        );
        $this->add_control(
            'show__shorts',
            [
                'label'        => esc_html__('Show Short Description', 'wooproduct-showcase'),
                'description' => esc_html__('Pro Only', 'wooproduct-showcase'),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => esc_html__('Show', 'wooproduct-showcase'),
                'label_off'    => esc_html__('Hide', 'wooproduct-showcase'),
                'return_value' => 'yes',
                'default'      => 'no',
                'classes'      => 'wpnp-pro-only'

            ]
        );
        $this->add_control(
            'show__quick_wish',
            [
                'label'        => esc_html__('Show Quickview and Wishlist Icon', 'wooproduct-showcase'),
                'description' => esc_html__('Pro Only', 'wooproduct-showcase'),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => esc_html__('Show', 'wooproduct-showcase'),
                'label_off'    => esc_html__('Hide', 'wooproduct-showcase'),
                'return_value' => 'yes',
                'default'      => 'no',
                'classes'      => 'wpnp-pro-only'
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'content_slider',
            [
                'label' => esc_html__( 'Slider Settings', 'nice-addons' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'col_xl',
            [
                'label'   => esc_html__( 'Wide Screen > 1399px', 'nice-addons' ),
                'type'    => Controls_Manager::SELECT,  
                'default' => 3,
                'options' => [
                    '1' => esc_html__( '1 Column', 'nice-addons' ), 
                    '2' => esc_html__( '2 Column', 'nice-addons' ),
                    '3' => esc_html__( '3 Column', 'nice-addons' ),
                    '4' => esc_html__( '4 Column', 'nice-addons' ),
                    '4.5' => esc_html__( '4.5 Column', 'nice-addons' ),
                    '5' => esc_html__( '5 Column', 'nice-addons' ),
                    '5.5' => esc_html__( '5.5 Column', 'nice-addons' ),
                    '6' => esc_html__( '6 Column', 'nice-addons' ),                 
                ],
                'separator' => 'before',
            ]
            
        );
    
        $this->add_control(
            'col_lg',
            [
                'label'   => esc_html__( 'Desktops > 1199px', 'nice-addons' ),
                'type'    => Controls_Manager::SELECT,  
                'default' => 3,
                'options' => [
                    '1' => esc_html__( '1 Column', 'nice-addons' ), 
                    '2' => esc_html__( '2 Column', 'nice-addons' ),
                    '3' => esc_html__( '3 Column', 'nice-addons' ),
                    '4' => esc_html__( '4 Column', 'nice-addons' ),
                    '6' => esc_html__( '6 Column', 'nice-addons' ),                 
                ],
                'separator' => 'before',
                            
            ]
            
        );

        $this->add_control(
            'col_md',
            [
                'label'   => esc_html__( 'Desktops > 991px', 'nice-addons' ),
                'type'    => Controls_Manager::SELECT,  
                'default' => 3,         
                'options' => [
                    '1' => esc_html__( '1 Column', 'nice-addons' ), 
                    '2' => esc_html__( '2 Column', 'nice-addons' ),
                    '3' => esc_html__( '3 Column', 'nice-addons' ),
                    '4' => esc_html__( '4 Column', 'nice-addons' ),
                    '6' => esc_html__( '6 Column', 'nice-addons' ),                     
                ],
                'separator' => 'before',
                            
            ]
            
        );

        $this->add_control(
            'col_sm',
            [
                'label'   => esc_html__( 'Tablets > 767px', 'nice-addons' ),
                'type'    => Controls_Manager::SELECT,  
                'default' => 2,         
                'options' => [
                    '1' => esc_html__( '1 Column', 'nice-addons' ), 
                    '2' => esc_html__( '2 Column', 'nice-addons' ),
                    '3' => esc_html__( '3 Column', 'nice-addons' ),
                    '4' => esc_html__( '4 Column', 'nice-addons' ),
                    '6' => esc_html__( '6 Column', 'nice-addons' ),                 
                ],
                'separator' => 'before',
                            
            ]
            
        );

        $this->add_control(
            'col_xs',
            [
                'label'   => esc_html__( 'Tablets < 768px', 'nice-addons' ),
                'type'    => Controls_Manager::SELECT,  
                'default' => 1,         
                'options' => [
                    '1' => esc_html__( '1 Column', 'nice-addons' ), 
                    '2' => esc_html__( '2 Column', 'nice-addons' ),
                    '3' => esc_html__( '3 Column', 'nice-addons' ),
                    '4' => esc_html__( '4 Column', 'nice-addons' ),
                    '6' => esc_html__( '6 Column', 'nice-addons' ),                 
                ],
                'separator' => 'before',
                            
            ]
            
        );
        $this->add_control(
            'rt_pslider_effect',
            [
                'label' => esc_html__('Slider Effect', 'nice-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'default',
                'options' => [
					'default' => esc_html__('Default', 'nice-addons'),					
					'fade' => esc_html__('Fade', 'nice-addons'),
					'flip' => esc_html__('Flip', 'nice-addons'),
					'cube' => esc_html__('Cube', 'nice-addons'),
					'coverflow' => esc_html__('Coverflow', 'nice-addons'),
					'creative' => esc_html__('Creative', 'nice-addons'),
					'cards' => esc_html__('Cards', 'nice-addons'),
                ],
            ]
        );

        $this->add_control(
            'slides_ToScroll',
            [
                'label'   => esc_html__( 'Slide To Scroll', 'nice-addons' ),
                'type'    => Controls_Manager::SELECT,  
                'default' => 2,         
                'options' => [
                    '1' => esc_html__( '1 Item', 'nice-addons' ),
                    '2' => esc_html__( '2 Item', 'nice-addons' ),
                    '3' => esc_html__( '3 Item', 'nice-addons' ),
                    '4' => esc_html__( '4 Item', 'nice-addons' ),                   
                ],
                'separator' => 'before',
                            
            ]
            
        );      

        $this->add_control(
            'slider_dots',
            [
                'label'   => esc_html__( 'Navigation Dots', 'nice-addons' ),
                'type'    => Controls_Manager::SELECT,  
                'default' => 'false',
                'options' => [
                    'true' => esc_html__( 'Enable', 'nice-addons' ),
                    'false' => esc_html__( 'Disable', 'nice-addons' ),              
                ],
                'separator' => 'before',
                            
            ]
            
        );

        $this->add_control(
            'slider_nav',
            [
                'label'   => esc_html__( 'Navigation Nav', 'nice-addons' ),
                'type'    => Controls_Manager::SELECT,  
                'default' => 'false',           
                'options' => [
                    'true' => esc_html__( 'Enable', 'nice-addons' ),
                    'false' => esc_html__( 'Disable', 'nice-addons' ),              
                ],
                'separator' => 'before',
                            
            ]
            
        );

        $this->add_control(
            'pcat_prev_text',
            [
                'label' => esc_html__( 'Previous Text', 'nice-addons' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __( '<i class="rt-arrow-left-long"></i>', 'nice-addons' ),
                'placeholder' => esc_html__( 'Type your title here', 'nice-addons' ),
                'condition' => [
                    'slider_nav' => 'true',
                ],
            ]
        );

        $this->add_control(
            'pcat_next_text',
            [
                'label' => esc_html__( 'Next Text', 'nice-addons' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __( '<div class="rt-arrow-right-long"></div>', 'nice-addons' ),
                'placeholder' => esc_html__( 'Type your title here', 'nice-addons' ),
                'condition' => [
                    'slider_nav' => 'true',
                ],

            ]
        );
        $this->add_control(
            'slider_autoplay',
            [
                'label'   => esc_html__( 'Autoplay', 'nice-addons' ),
                'type'    => Controls_Manager::SELECT,  
                'default' => 'false',           
                'options' => [
                    'true' => esc_html__( 'Enable', 'nice-addons' ),
                    'false' => esc_html__( 'Disable', 'nice-addons' ),              
                ],
                'separator' => 'before',
                            
            ]
            
        );

        $this->add_control(
            'slider_autoplay_speed',
            [
                'label'   => esc_html__( 'Autoplay Slide Speed', 'nice-addons' ),
                'type'    => Controls_Manager::SELECT,  
                'default' => 3000,          
                'options' => [
                    '1000' => esc_html__( '1 Seconds', 'nice-addons' ),
                    '2000' => esc_html__( '2 Seconds', 'nice-addons' ), 
                    '3000' => esc_html__( '3 Seconds', 'nice-addons' ), 
                    '4000' => esc_html__( '4 Seconds', 'nice-addons' ), 
                    '5000' => esc_html__( '5 Seconds', 'nice-addons' ), 
                ],
                'separator' => 'before',
                'condition' => [
                    'slider_autoplay' => 'true',
                ],                          
            ]
            
        );

        $this->add_control(
            'slider_interval',
            [
                'label'   => esc_html__( 'Autoplay Interval', 'nice-addons' ),
                'type'    => Controls_Manager::SELECT,  
                'default' => 3000,          
                'options' => [
                    '5000' => esc_html__( '5 Seconds', 'nice-addons' ), 
                    '4000' => esc_html__( '4 Seconds', 'nice-addons' ), 
                    '3000' => esc_html__( '3 Seconds', 'nice-addons' ), 
                    '2000' => esc_html__( '2 Seconds', 'nice-addons' ), 
                    '1000' => esc_html__( '1 Seconds', 'nice-addons' ),     
                ],
                'separator' => 'before',
                'condition' => [
                    'slider_autoplay' => 'true',
                ],                                                      
            ]
            
        );

        $this->add_control(
            'slider_stop_on_interaction',
            [
                'label'   => esc_html__( 'Stop On Interaction', 'nice-addons' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'false',               
                'options' => [
                    'true' => esc_html__( 'Enable', 'nice-addons' ),
                    'false' => esc_html__( 'Disable', 'nice-addons' ),              
                ],
                'separator' => 'before',
                'condition' => [
                    'slider_autoplay' => 'true',
                ],                                                      
            ]
            
        );

        $this->add_control(
            'slider_stop_on_hover',
            [
                'label'   => esc_html__( 'Stop on Hover', 'nice-addons' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'false',               
                'options' => [
                    'true' => esc_html__( 'Enable', 'nice-addons' ),
                    'false' => esc_html__( 'Disable', 'nice-addons' ),              
                ],
                'separator' => 'before',
                'condition' => [
                    'slider_autoplay' => 'true',
                ],                                                      
            ]
            
        );

        $this->add_control(
            'slider_loop',
            [
                'label'   => esc_html__( 'Loop', 'nice-addons' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'false',
                'options' => [
                    'true' => esc_html__( 'Enable', 'nice-addons' ),
                    'false' => esc_html__( 'Disable', 'nice-addons' ),
                ],
                'separator' => 'before',
                            
            ]
            
        );

        $this->add_control(
            'slider_centerMode',
            [
                'label'   => esc_html__( 'Center Mode', 'nice-addons' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'false',
                'options' => [
                    'true' => esc_html__( 'Enable', 'nice-addons' ),
                    'false' => esc_html__( 'Disable', 'nice-addons' ),
                ],
                'separator' => 'before',
                            
            ]
            
        );

        $this->add_control(
            'item_gap_custom',
            [
                'label' => esc_html__( 'Item Gap', 'nice-addons' ),
                'type' => Controls_Manager::SLIDER,
                'show_label' => true,               
                'range' => [
                    'px' => [
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'size' => 15,
                ],          

                'selectors' => [
                    '{{WRAPPER}} .rs-addon-slider .product-item' => 'padding:0 {{SIZE}}{{UNIT}};',                    
                ],
            ]
        ); 
                
        $this->end_controls_section();












        $this->start_controls_section(
            'wpnp_product_grid_styles',
            [
                'label' => esc_html__('Products Styles', 'wooproduct-showcase'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'wpnp_product_grid_background_color',
            [
                'label' => esc_html__('Content Background Color', 'wooproduct-showcase'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpnp-product-list' => 'background-color: {{VALUE}};',
                ],
                
            ]
        );

        $this->add_control(
            'wpnp_pgrid_rating_star_color',
            [
                'label' => esc_html__('Rating Star Color', 'wooproduct-showcase'),
                'type' => Controls_Manager::COLOR,
                'condition' => ['show__rating' => 'yes'],
                'selectors' => [
                    '{{WRAPPER}} .wpnp--grid .star-rating .star:before' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'wpnp_pgrid_rating_bg_color',
            [
                'label' => esc_html__('Rating Area Background Color', 'wooproduct-showcase'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpnp-grid-4 .rating-stock' => 'background-color: {{VALUE}};',
                ],
                'condition'   => [ 'wpnp_product_grid_style_preset' => '4'  ],
            ]
        );
        $this->add_control(
            'wpnp_pgrid_cart_bg_color',
            [
                'label' => esc_html__('Cart Area Background Color', 'wooproduct-showcase'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpnp-grid-4 .cart-view' => 'background-color: {{VALUE}};',
                ],
                'condition'   => [ 'wpnp_product_grid_style_preset' => '4'  ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'wpnp_peoduct_grid_border',
                'fields_options' => [
                    'border' => [
                        'default' => 'solid',
                    ],
                    'width' => [
                        'default' => [
                            'top' => '1',
                            'right' => '1',
                            'bottom' => '1',
                            'left' => '1',
                            'isLinked' => false,
                        ],
                    ],
                    'color' => [
                        'default' => '#eee',
                    ],
                ],
                'selector' => '{{WRAPPER}} .wpnp-product-list',                
            ]
        );        

        $this->end_controls_section();

        $this->start_controls_section(
            'wpnp_section_product_grid_typography',
            [
                'label' => esc_html__('Color &amp; Typography', 'wooproduct-showcase'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'wpnp_product_grid_product_title_heading',
            [
                'label' => __('Product Title', 'wooproduct-showcase'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'wpnp_product_grid_product_title_hover_color',
            [
                'label' => esc_html__('Product Title Color', 'wooproduct-showcase'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpnp--grid h4 a' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'wpnp_product_grid_product_title_color',
            [
                'label' => esc_html__('Product Hover Title Color', 'wooproduct-showcase'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpnp--grid h4 a:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .product-content .p-title a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'wpnp_product_grid_product_title_typography',
                'selector' => '{{WRAPPER}} .wpnp--grid h4 a',
            ]
        );

        $this->add_control(
            'wpnp_product_grid_product_price_heading',
            [
                'label' => __('Product Price', 'wooproduct-showcase'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'wpnp_product_grid_product_price_color',
            [
                'label' => esc_html__('Product Price Color', 'wooproduct-showcase'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpnp--grid .product-price' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'wpnp_product_grid_product_price_typography',
                'selector' => '{{WRAPPER}} .wpnp--grid .product-price',
            ]
        );

       
        $this->add_control(
            'wpnp_product_grid_sale_badge_heading',
            [
                'label' => __('Sale Products', 'wooproduct-showcase'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'wpnp_product_grid_sale_badge_color',
            [
                'label' => esc_html__('Sale Badge Color', 'wooproduct-showcase'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .product-img span.sale-rs' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'wpnp_product_grid_sale_badge_background',
            [
                'label' => esc_html__('Sale Badge Background', 'wooproduct-showcase'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .product-img span.sale-rs' => 'background-color: {{VALUE}};', 
                ],
            ]
        );
        $this->add_control(
            'wpnp_product_grid_sale_price_color',
            [
                'label' => esc_html__('Sale Price Color', 'wooproduct-showcase'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpnp-product-list span ins' => 'color: {{VALUE}};',

                ],
            ]
        );

        $this->add_control(
            'wpnp_product_grid_sale_price_background',
            [
                'label' => esc_html__('Sale Price Background', 'wooproduct-showcase'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpnp-product-list span ins' => 'background-color: {{VALUE}};',                  
                ],
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__( 'Sale Badge Typography', 'wooproduct-showcase' ),
                'name' => 'wpnp_product_grid_sale_badge_typography',
                'selector' => '{{WRAPPER}} .product-img span.sale-rs',
            ]
        );
        $this->add_control(
            'wpnp_product_grid_category',
            [
                'label' => __('Category', 'wooproduct-showcase'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => ['show__category' => 'yes'],
            ]
        );

        $this->add_control(
            'wpnp_product_grid_cat_color',
            [
                'label' => esc_html__('Category Color', 'wooproduct-showcase'),
                'type' => Controls_Manager::COLOR,
                'condition' => ['show__category' => 'yes'],
                'selectors' => [
                    '{{WRAPPER}} .wpnp--grid .product_cats a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'wpnp_product_grid_cat_hover_color',
            [
                'label' => esc_html__('Category Hover Color', 'wooproduct-showcase'),
                'type' => Controls_Manager::COLOR,
                'condition' => ['show__category' => 'yes'],
                'selectors' => [
                    '{{WRAPPER}} .wpnp--grid .product_cats a:hover' => 'color: {{VALUE}};',                  
                ],
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__( 'Category Typography', 'plugin-name' ),
                'name' => 'wpnp_product_grid_cat_hover_typo',
                'selector' => '{{WRAPPER}} .wpnp--grid .product_cats a',
                'condition' => ['show__category' => 'yes'],
            ]
        );

        $this->add_control(
            'wpnp_product_grid_shorts',
            [
                'label' => __('Short Description', 'wooproduct-showcase'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => ['show__shorts' => 'yes'],
            ]
        );

        $this->add_control(
            'wpnp_product_grid_shorts_color',
            [
                'label' => esc_html__('Short Description Color', 'wooproduct-showcase'),
                'type' => Controls_Manager::COLOR,
                'condition' => ['show__shorts' => 'yes'],
                'selectors' => [
                    '{{WRAPPER}} .wpnp--grid .product-shorts' => 'color: {{VALUE}};',

                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'wpnp_product_grid_shorts_hover_typo',
                'selector' => '{{WRAPPER}} .wpnp--grid .product-shorts',
                'condition' => ['show__shorts' => 'yes'],
                'label' => esc_html__( 'Short Description Typography', 'wooproduct-showcase' ),

            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'wpnp_section_product_grid_add_to_cart_styles',
            [
                'label' => esc_html__('Cart Button Styles', 'wooproduct-showcase'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs('wpnp_product_grid_add_to_cart_style_tabs');

        $this->start_controls_tab('normal', ['label' => esc_html__('Normal', 'wooproduct-showcase')]);

        $this->add_control(
            'wpnp_product_grid_add_to_cart_color',
            [
                'label' => esc_html__('Button Color', 'wooproduct-showcase'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpnp--grid .product-btn a' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .wpnp--grid .product-btn i' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'wpnp_product_grid_add_to_cart_background',
            [
                'label' => esc_html__('Button Background Color', 'wooproduct-showcase'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpnp--grid .product-btn a' => 'background-color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab('wpnp_product_grid_add_to_cart_hover_styles', ['label' => esc_html__('Hover', 'wooproduct-showcase')]);


        $this->add_control(
            'wpnp_product_grid_add_to_cart_hover_color',
            [
                'label' => esc_html__('Button Color', 'wooproduct-showcase'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpnp--grid .product-btn:hover a' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .wpnp--grid .product-btn:hover i' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'wpnp_product_grid_add_to_cart_hover_background',
            [
                'label' => esc_html__('Button Background Color', 'wooproduct-showcase'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpnp--grid .product-btn:hover a' => 'background-color: {{VALUE}} !important;',
                ],
            ]
        );


        $this->end_controls_tabs();

        $this->end_controls_section();



        $this->start_controls_section(
            'wpnp_section_product_grid_quick_wish_styles',
            [
                'label' => esc_html__('Quick View and Wishlist', 'wooproduct-showcase'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['show__quick_wish' => 'yes'],
            ]
        );

        $this->start_controls_tabs('wpnp_product_grid_quick_wish_tabs');

        $this->start_controls_tab('normal_quick_wish', ['label' => esc_html__('Normal', 'wooproduct-showcase')]);

        $this->add_control(
            'wpnp_product_grid_quick_wish_color',
            [
                'label' => esc_html__('Button Color', 'wooproduct-showcase'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpnp--grid .nimart-quick i:before' => 'color: {{VALUE}} !important;',
                    '{{WRAPPER}} .wpnp--grid .nimart-wishlist i:before' => 'color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_control(
            'wpnp_product_grid_quick_wish_background',
            [
                'label' => esc_html__('Button Background Color', 'wooproduct-showcase'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpnp--grid .nimart-quick' => 'background-color: {{VALUE}} !important;',
                    '{{WRAPPER}} .wpnp--grid .nimart-wishlist' => 'background-color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab('wpnp_product_grid_quick_wish_hover_styles', ['label' => esc_html__('Hover', 'wooproduct-showcase')]);

        $this->add_control(
            'wpnp_product_grid_quick_wish_hover_color',
            [
                'label' => esc_html__('Button Color', 'wooproduct-showcase'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpnp--grid .nimart-quick:hover i:before' => 'color: {{VALUE}} !important;',
                    '{{WRAPPER}} .wpnp--grid .nimart-wishlist:hover i:before' => 'color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_control(
            'wpnp_product_grid_quick_wish_hover_background',
            [
                'label' => esc_html__('Button Background Color', 'wooproduct-showcase'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpnp--grid .nimart-quick:hover' => 'background-color: {{VALUE}} !important;',
                    '{{WRAPPER}} .wpnp--grid .nimart-wishlist:hover' => 'background-color: {{VALUE}} !important;',
                ],
            ]
        );


        $this->end_controls_tabs();

        $this->end_controls_section();




        $this->start_controls_section(
            'wpnp_section_product_grid_navigation_nav_styles',
            [
                'label' => esc_html__('Slider Navigation Nav', 'wooproduct-showcase'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs('wpnp_product_grid_navigation_nav_style_tabs');

        $this->start_controls_tab('normal_navigation_nav', ['label' => esc_html__('Normal', 'wooproduct-showcase')]);

        $this->add_control(
            'wpnp_product_grid_navigation_nav_color',
            [
                'label' => esc_html__('Color', 'wooproduct-showcase'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpnp--slider .rt-slider-navigation .rt-nav-item' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .wpnp--slider .rt-slider-navigation .rt-nav-item i:before' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'wpnp_product_grid_navigation_nav_background',
            [
                'label' => esc_html__('Background Color', 'wooproduct-showcase'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpnp--slider .rt-slider-navigation .rt-nav-item' => 'background-color: {{VALUE}} !important;',
                ],
            ]
        );

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'wpnp_product_grid_navigation_nav_border',
				'label' => esc_html__( 'Border', 'wooproduct-showcase' ),
				'selector' => '{{WRAPPER}} .wpnp--slider .rt-slider-navigation .rt-nav-item',
			]
		);

        $this->end_controls_tab();

        $this->start_controls_tab('wpnp_product_grid_navigation_nav_hover_styles', ['label' => esc_html__('Hover', 'wooproduct-showcase')]);


        $this->add_control(
            'wpnp_product_grid_navigation_nav_hover_color',
            [
                'label' => esc_html__('Color', 'wooproduct-showcase'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpnp--slider .rt-slider-navigation .rt-nav-item:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .wpnp--slider .rt-slider-navigation .rt-nav-item:hover i:before' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'wpnp_product_grid_navigation_nav_hover_background',
            [
                'label' => esc_html__('Background Color', 'wooproduct-showcase'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpnp--slider .rt-slider-navigation .rt-nav-item:hover' => 'background-color: {{VALUE}} !important;',
                ],
            ]
        );
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'wpnp_product_grid_navigation_nav_hover_border',
				'label' => esc_html__( 'Border', 'wooproduct-showcase' ),
				'selector' => '{{WRAPPER}} .wpnp--slider .rt-slider-navigation .rt-nav-item:hover',
			]
		);

        $this->end_controls_tabs();

        $this->end_controls_section();


        $this->start_controls_section(
            'wpnp_section_product_grid_navigation_dots_styles',
            [
                'label' => esc_html__('Slider Navigation Dots', 'wooproduct-showcase'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

		$this->add_control(
			'wpnp_product_grid_navigation_dots_width',
			[
				'label' => esc_html__( 'Width', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wpnp--slider .swiper-pagination .swiper-pagination-bullet' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);        

		$this->add_control(
			'wpnp_product_grid_navigation_dots_height',
			[
				'label' => esc_html__( 'Height', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wpnp--slider .swiper-pagination .swiper-pagination-bullet' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);        

		$this->add_control(
			'wpnp_product_grid_navigation_dots_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .wpnp--slider .swiper-pagination .swiper-pagination-bullet' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->start_controls_tabs('wpnp_product_grid_navigation_dots_style_tabs');
        $this->start_controls_tab('normal_navigation_dots', ['label' => esc_html__('Normal', 'wooproduct-showcase')]);
        $this->add_control(
            'wpnp_product_grid_navigation_dots_background',
            [
                'label' => esc_html__('Color', 'wooproduct-showcase'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpnp--slider .swiper-pagination .swiper-pagination-bullet' => 'background-color: {{VALUE}} !important;',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab('wpnp_product_grid_navigation_dots_hover_styles', ['label' => esc_html__('Active', 'wooproduct-showcase')]);
        $this->add_control(
            'wpnp_product_grid_navigation_dots_hover_background',
            [
                'label' => esc_html__('Color', 'wooproduct-showcase'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpnp--slider .swiper-pagination .swiper-pagination-bullet-active' => 'background-color: {{VALUE}} !important;',
                ],
            ]
        );
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    protected function render(){
        $settings = $this->get_settings_for_display();
        
        $show_cat      = $settings['show__category'] == 'yes' ?  true : false ;
        $show_rating   = $settings['show__rating'] == 'yes' ? true : false;
        $quick_wish    = $settings['show__quick_wish'] == 'yes' ? true : false;
        $shorts    = $settings['show__shorts'] == 'yes' ? true : false;
        $basket_icon   = $settings['show__cart_icon'] == 'yes' ? ' cart-icon-instedof-text' : '';

        $col_xl          = $settings['col_xl'];
        $col_xl          = !empty($col_xl) ? $col_xl : 3;
        $slidesToShow    = $col_xl;
        $autoplaySpeed   = $settings['slider_autoplay_speed'];
        $autoplaySpeed   = !empty($autoplaySpeed) ? $autoplaySpeed : '1000';
        $interval        = $settings['slider_interval'];
        $interval        = !empty($interval) ? $interval : '3000';
        $slidesToScroll  = $settings['slides_ToScroll'];
        $slider_autoplay = $settings['slider_autoplay'] === 'true' ? 'true' : 'false';
        $pauseOnHover    = $settings['slider_stop_on_hover'] === 'true' ? 'true' : 'false';
        $pauseOnInter    = $settings['slider_stop_on_interaction'] === 'true' ? 'true' : 'false';
        $sliderDots      = $settings['slider_dots'] == 'true' ? 'true' : 'false';
        $sliderNav       = $settings['slider_nav'] == 'true' ? 'true' : 'false';        
        $infinite        = $settings['slider_loop'] === 'true' ? 'true' : 'false';
        $centerMode      = $settings['slider_centerMode'] === 'true' ? 'true' : 'false';
        $col_lg          = $settings['col_lg'];
        $col_md          = $settings['col_md'];
        $col_sm          = $settings['col_sm'];
        $col_xs          = $settings['col_xs']; 
        $item_gap = $settings['item_gap_custom']['size'];
        $item_gap = !empty($item_gap) ? $item_gap : '30';
        $prev_text = $settings['pcat_prev_text'];
        $prev_text = !empty($prev_text) ? $prev_text : '';
        $next_text = $settings['pcat_next_text'];
        $next_text = !empty($next_text) ? $next_text : '';
        $unique = rand(2012,35120);

        $all_pcat = wpnp_woocommerce_product_categories_lite();
        $pcats = $settings['wpnp_product_grid_categories'];

        if( $slider_autoplay =='true' ){
            $slider_autoplay = 'autoplay: { ' ;
            $slider_autoplay .= 'delay: '.$interval;
            if(  $pauseOnHover =='true'  ){
                $slider_autoplay .= ', pauseOnMouseEnter: true';
            }else{
                $slider_autoplay .= ', pauseOnMouseEnter: false';
            }
            if(  $pauseOnInter =='true'  ){
                $slider_autoplay .= ', disableOnInteraction: true';
            }else{
                $slider_autoplay .= ', disableOnInteraction: false';
            }
            $slider_autoplay .= ' }';
        }else{
            $slider_autoplay = 'autoplay: false' ;
        }

        $effect = $settings['rt_pslider_effect'];

        if($effect== 'fade'){
            $seffect = "effect: 'fade', fadeEffect: { crossFade: true, },";
        }elseif($effect== 'cube'){
            $seffect = "effect: 'cube',";
        }elseif($effect== 'flip'){
            $seffect = "effect: 'flip',";
        }elseif($effect== 'coverflow'){
            $seffect = "effect: 'coverflow',";
        }elseif($effect== 'creative'){
            $seffect = "effect: 'creative', creativeEffect: { prev: { translate: [0, 0, -400], }, next: { translate: ['100%', 0, 0], }, },";
        }elseif($effect== 'cards'){
            $seffect = "effect: 'cards',";
        }else{
            $seffect = '';
        }


        $args = [
            'post_type' => 'product',
            'posts_per_page' => $settings['wpnp_product_grid_products_count'] ?: 4,
            'order' => 'DESC',
        ];


        if (!empty($settings['wpnp_product_grid_categories'])) {
            $args['tax_query'] = [
                [
                    'taxonomy' => 'product_cat',
                    'field' => 'slug',
                    'terms' => $settings['wpnp_product_grid_categories'],
                    'operator' => 'IN',
                ],
            ];
        }

        if ($settings['wpnp_product_grid_product_filter'] == 'featured-products') {
            $args['tax_query'] = [
                [
					'taxonomy' => 'product_visibility',
                    'field' => 'name',
					'terms' => 'featured'
				]
            ];
        } else if ($settings['wpnp_product_grid_product_filter'] == 'best-selling-products') {
            $args['meta_key'] = 'total_sales';
            $args['orderby'] = 'meta_value_num';
            $args['order'] = 'DESC';
        } else if ($settings['wpnp_product_grid_product_filter'] == 'sale-products') {
            $args['meta_query'] = [
                'relation' => 'OR',
                [
                    'key' => '_sale_price',
                    'value' => 0,
                    'compare' => '>',
                    'type' => 'numeric',
                ], [
                    'key' => '_min_variation_sale_price',
                    'value' => 0,
                    'compare' => '>',
                    'type' => 'numeric',
                ],
            ];
        } else if ($settings['wpnp_product_grid_product_filter'] == 'top-products') {
            $args['meta_key'] = '_wc_average_rating';
            $args['orderby'] = 'meta_value_num';
            $args['order'] = 'DESC';
        } else if ($settings['wpnp_product_grid_product_filter'] == 'selected-products') {
            $selected_products = $settings['rt_selected_products'];
            $args['post__in'] = $selected_products;
            $args['order'] = 'DESC';
        }

        $style = $settings['wpnp_product_grid_style_preset'];
        $the_query = new WP_Query( $args );
        $style5to4 = $style == '4' ? ' wpnp-grid-5' : '';  
        $repeat_style  = '';

        if( $style == '3' ) $repeat_style = ' wpnp-grid-5';
        if( $style == '4' ) $repeat_style = ' wpnp-grid-5';
        if( $style == '6' ) $repeat_style = ' wpnp-grid-2';
        if( $style == '7' ) $repeat_style = ' wpnp-grid-2 wpnp-grid-6';
        if( $style == '8' ) $repeat_style = ' wpnp-grid-2';
        if( $style == '9' ) $repeat_style = ' wpnp-grid-1';
        if( $style == '10' ) $repeat_style = ' wpnp-grid-2';
        ?>
        <div class="rt_slider-<?php echo esc_attr($unique); ?> swiper wpnp--grid wpnp--slider row rt-product--grid wpnp-grid-<?php echo esc_attr($style)?><?php echo esc_attr($repeat_style)?>">

            <?php
                if( $sliderNav == 'true' ){
                    echo '<div class="rt-slider-navigation"><div class="rt-slider-prev rt-nav-item">'. $prev_text .'</div><div class="rt-slider-next rt-nav-item">'. $next_text .'</div></div>';
                }
            ?>
            <?php
                if( $sliderDots == 'true' ) echo '<div class="swiper-pagination"></div>';
            ?>

            <div class="swiper-wrapper">
                <?php         	

                while ( $the_query->have_posts() ) : $the_query->the_post();
                    global $product;
                    $shortd = $product->get_short_description();
                    $gallery = $product->get_gallery_image_ids();
                    $galCount = count($gallery);
                    if($gallery){
                        $p2ndImg = $gallery[0];
                        array_unshift($gallery, get_post_thumbnail_id());
                    }else{
                        $p2ndImg = false;
                    }
                    $post_id     = get_the_ID();
                    $is_feat     = $product->is_featured();
                    $rcount      = $product->get_rating_count();
                    $arating     = $product->get_average_rating();
                    echo '<div class="swiper-slide">';
                        if($style){
                            require plugin_dir_path(__FILE__)."/style".$style.".php";
                        }else{
                            require plugin_dir_path(__FILE__)."/style1.php";
                        }
                    echo '</div>';
                endwhile;  wp_reset_query();
            ?>
            </div>
    	</div>

        <script type="text/javascript">
            jQuery(document).ready(function(){
                var swiper<?php echo esc_attr($unique); ?> = new Swiper(".rt_slider-<?php echo esc_attr($unique); ?>", {				
                    slidesPerView: 1,
                    <?php echo esc_html($seffect); ?>
                    speed: <?php echo esc_attr($autoplaySpeed); ?>,
                    loop:  <?php echo esc_attr($infinite ); ?>,
                    <?php echo esc_attr($slider_autoplay); ?>,
                    centeredSlides: <?php echo esc_attr($centerMode); ?>,

                    spaceBetween:  <?php echo esc_attr($item_gap); ?>,
                    pagination: {
                    el: ".swiper-pagination",
                    clickable: true,
                    },
                    navigation: {
                        nextEl: ".rt-slider-next",
                        prevEl: ".rt-slider-prev",
                    },
                    breakpoints: {
                            <?php
                            echo (!empty($col_xs)) ?  '575: { slidesPerView: '.esc_html($col_xs) .' },' : '';
                            echo (!empty($col_sm)) ?  '767: { slidesPerView: '. esc_html($col_sm) .' },' : '';
                            echo (!empty($col_md)) ?  '991: { slidesPerView: '. esc_html($col_md) .' },' : '';
                            echo (!empty($col_lg)) ?  '1199: { slidesPerView: '. esc_html($col_lg) .' },' : '';
                            ?>
                            1399: {
                                slidesPerView: <?php echo esc_html($col_xl); ?>,
                                spaceBetween:  <?php echo esc_html($item_gap); ?>
                            }
                        }                    
                });
            });
        </script>        
        
        
        <?php 
    	
    }   

}