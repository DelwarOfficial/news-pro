<?php $banner_posts_title = get_theme_mod( 'news_record_banner_posts_title', __( 'Main News', 'news-record' ) ); ?>
<div class="banner-posts">
	<?php if ( ! empty( $banner_posts_title ) ) { ?>
		<div class="header-title">
			<h3 class="section-title"><?php echo esc_html( $banner_posts_title ); ?></h3>
		</div>
	<?php } ?>
	<div class="banner-posts-wrapper">
		<?php
		$banner_posts_query = new WP_Query( $banner_posts_args );
		if ( $banner_posts_query->have_posts() ) {
			while ( $banner_posts_query->have_posts() ) :
				$banner_posts_query->the_post();
				?>
				<div class="single-card-container grid-card">
					<div class="single-card-image">
						<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
					</div>
					<div class="single-card-detail">
						<?php news_record_categories_list(); ?>
						<h3 class="card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
						<div class="card-meta">
							<?php
								news_record_posted_by();
								news_record_posted_on();
							?>
						</div>
					</div>
				</div>
				<?php
			endwhile;
			wp_reset_postdata();
		}
		?>
	</div>
</div>