<?php
    $product = wc_get_product( get_the_ID() ); //set the global product object ?>
    <div class="product-item product-style-two col-xxl-<?php echo esc_html($settings['wpnp_product_grid_column']);?> col-md-6 col-xs-1">
        <div class="product-img">
            <div class="sale--box">
                <?php if ( $product->is_on_sale() ) {
                    echo '<span class="sale-rs">'.esc_html__('Sale','nice-addons').'</span>';
                } ?>
            </div>
            <a href="<?php the_permalink() ?>" class="feature--image">
                <?php if ( has_post_thumbnail( get_the_ID() ) ) {
                    echo get_the_post_thumbnail( get_the_ID(), 'shop_single' );
                } else {
                    echo '<img src="' . wc_placeholder_img_src() . '" alt="Placeholder" />';
                } ?>
            </a>
            <?php
				if( $p2ndImg ){
					$img2_link = wp_get_attachment_image_src( $p2ndImg, $settings['thumbnail_size'])[0];
					?>
				 	<a href="<?php the_permalink();?>" class="p-2nd--image">
				 		<img src="<?php echo esc_url($img2_link);?>" alt="Product 2nd Image">
				 	</a>						
				 	<?php
				 }
                ?>
        </div>
        <div class="wpnp-product-list">
            <?php
                if( $show_rating ){
                ?>
                <div class="ratings">
                    <?php wpnp_star_rating(['rating' => $arating]); ?>
                </div>
            <?php
			}
			?>
            <?php if($show_cat):?>
                <div class="product_cats">
                    <?php echo get_the_term_list( get_the_ID(), 'product_cat', '', ', ' ); ?>
                </div>
            <?php endif;?>
            <h4 class="product-title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4>
                <?php if($shorts):?>
                    <div class="product-shorts">
                        <?php echo wp_trim_words( $shortd, 10, '...' ); ?>
                    </div>
                <?php endif;?>

            <div class="price-n-cart">
                <span class="product-price"><?php echo  wp_kses_post($product->get_price_html()); ?></span>

            <div class="cart-quick-wish">
                    <?php if( $quick_wish ){
                        ?>
                        <div class="nimart-quick">
                            <?php wpnp_get_quickview_template_cta(); ?>
                        </div>
                    <?php
                    }?>
                    <div class="product-btn<?php echo esc_attr( $basket_icon );?>">
                        <?php woocommerce_template_loop_add_to_cart();?>
                    </div>
                    <?php if ( $quick_wish ): ?>
                        <div class="nimart-wishlist">
                            <?php wpnp_get_wishlist_template();?>
                        </div>
                    <?php endif; ?>
            </div>
            </div>
        </div>
    </div>
