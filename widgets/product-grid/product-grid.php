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

class WPNP_Elementor_Product_Grid_Widget_Free extends \Elementor\Widget_Base {

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
		return 'wpnp-product-grid';
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
		return __( 'Product Grid', 'wooproduct-showcase' );
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
		return 'nicewoo--icon rt-grid-2-plus';
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
		return [ 'product', 'list', 'category', 'grid' ];
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
            'wpnp_product_grid_column',
            [
                'label' => esc_html__('Columns', 'wooproduct-showcase'),
                'type' => Controls_Manager::SELECT,
                'default' => '3',
                'options' => [
                	'12' => esc_html__( '1 Column', 'wooproduct-showcase' ),
                    '6' => esc_html__( '2 Column', 'wooproduct-showcase' ),
					'4' => esc_html__( '3 Column', 'wooproduct-showcase' ),
					'3' => esc_html__( '4 Column', 'wooproduct-showcase' ),
					'20p' => esc_html__( '5 Column', 'wooproduct-showcase' ),
					'2' => esc_html__( '6 Column', 'wooproduct-showcase' ),					
                ],
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
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => esc_html__('Show', 'wooproduct-showcase'),
                'label_off'    => esc_html__('Hide', 'wooproduct-showcase'),
                'description' => esc_html__('Pro Only', 'wooproduct-showcase'),
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











    }

    protected function render(){
        $settings = $this->get_settings_for_display();
        
        $show_cat      = $settings['show__category'] == 'yes' ?  true : false ;
        $show_rating   = $settings['show__rating'] == 'yes' ? true : false;
        $quick_wish    = $settings['show__quick_wish'] == 'yes' ? true : false;
        $shorts    = $settings['show__shorts'] == 'yes' ? true : false;
        $basket_icon   = $settings['show__cart_icon'] == 'yes' ? ' cart-icon-instedof-text' : '';
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
        <div class="wpnp--grid row rt-product--grid wpnp-grid-<?php echo esc_attr($style)?><?php echo esc_attr($repeat_style)?>">
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
                
                if($style){
                    require plugin_dir_path(__FILE__)."/style".$style.".php";
                }else{
                    require plugin_dir_path(__FILE__)."/style1.php";
                }
            endwhile;  wp_reset_query();

        ?>
    	</div><?php 
    	
    }   

}