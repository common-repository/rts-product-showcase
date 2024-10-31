<div class="element-item grid-item">
	<div class="product-item content-overlay">
		<?php if(has_post_thumbnail()): ?>
			<div class="product-img">
			
				<a href="<?php the_permalink();?>" class="feature--image">
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
				<div class="sale--box">
					<?php

					if ( $product->is_on_sale() )  {    
						woocommerce_show_product_loop_sale_flash();
					}
					if( $is_feat ){
						?> <span class="hot">
							<?php if($settings['hot_text']){
							echo esc_html($settings['hot_text']);
						}else{
							esc_html_e( 'HOT!', 'rtelemenets' );
						}?>
						</span>  <?php
					}
					?>
				</div>
				<div class="quick-wish">
					<?php if( $quick_wish ){ ?>
                        <div class="nimart-quick">
                            <?php wpnp_get_quickview_template_cta(); ?>
                        </div>
                    <?php }?>
                    <?php if ( $quick_wish ): ?>
                        <div class="nimart-wishlist">
                            <?php wpnp_get_wishlist_template();?>
                        </div>
                    <?php endif; ?>				
				</div>	 
			</div>
		<?php endif;?>
		<div class="product-content">
			<div class="vertical-middle">
				<div class="vertical-middle-cell">
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
					<?php if(get_the_title()):?>
						<h4 class="p-title"><a href="<?php the_permalink();?>"><?php the_title();?></a></h4>
					<?php endif;?>

					<?php if($shorts):?>
						<div class="product-shorts">
							<?php echo wp_trim_words( $shortd, 10, '...' ); ?>
						</div>
					<?php endif;?>

					<div class="price--cart">
						<p class="price-html product-price"><?php echo wp_kses_post($product->get_price_html()); ?></p>
						<div class="product-btn">
							<?php woocommerce_template_loop_add_to_cart();?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>