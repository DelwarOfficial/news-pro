<?php $top_stories_title = get_theme_mod( 'news_record_banner_top_stories_title', __( 'Top Stories', 'news-record' ) ); ?>
<div class="top-stories">
	<?php if ( ! empty( $top_stories_title ) ) { ?>
		<div class="header-title">
			<h3 class="section-title"><?php echo esc_html( $top_stories_title ); ?></h3>
		</div>
	<?php } ?>
	<div class="top-stories-wrapper">
		<?php
		$top_stories_query = new WP_Query( $top_stories_args );
		if ( $top_stories_query->have_posts() ) {
			$i = 1;
			while ( $top_stories_query->have_posts() ) :
				$top_stories_query->the_post();
				$class = $i === 1 ? 'tile-card' : 'list-card';
				?>
				<div class="single-card-container <?php echo esc_attr( $class ); ?>">
					<div class="single-card-image">
						<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
					</div>
					<div class="single-card-detail">
						<?php news_record_categories_list(); ?>
						<h3 class="card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
						<div class="card-meta">
						<?php
							news_record_posted_on();
						?>
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