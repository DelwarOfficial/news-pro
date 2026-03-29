<?php $daily_news_title = get_theme_mod( 'news_record_daily_news_title', __( 'Daily News', 'news-record' ) ); ?>
<div class="daily-news">
	<?php if ( ! empty( $daily_news_title ) ) { ?>
		<div class="header-title">
			<h3 class="section-title"><?php echo esc_html( $daily_news_title ); ?></h3>
		</div>
	<?php } ?>
	<div class="daily-news-wrapper">
	<?php
	$daily_news_query = new WP_Query( $daily_news_args );
	if ( $daily_news_query->have_posts() ) {
		$i = 1;
		while ( $daily_news_query->have_posts() ) :
			$daily_news_query->the_post();
			?>
			<div class="single-card-container grid-card">
				<div class="single-card-image">
					<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
				</div>
				<div class="single-card-detail-wrap">
					<span class="post-counter"><?php echo absint( $i ) . '.'; ?></span>
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
			</div>
			<?php
			$i++;
		endwhile;
		wp_reset_postdata();
	} 
	?>
	</div>
</div>