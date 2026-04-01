<?php
/**
 * Frontpage Videos Section.
 * Displays a modern videos block with poster image / play overlay.
 *
 * @package News Record
 */

// Check if the section is enabled via Customizer.
$videos_section = get_theme_mod( 'news_record_videos_section_enable', false );

if ( false === $videos_section ) {
	return;
}

$section_title = get_theme_mod( 'news_record_videos_title', __( 'Videos', 'news-record' ) );
$content_type  = get_theme_mod( 'news_record_videos_content_type', 'recent' );
$post_count    = get_theme_mod( 'news_record_videos_post_count', 6 );
$content_ids   = array();

if ( 'post' === $content_type ) {
	for ( $i = 1; $i <= 6; $i++ ) {
		$post_id = get_theme_mod( 'news_record_videos_post_' . $i );
		if ( ! empty( $post_id ) ) {
			$content_ids[] = absint( $post_id );
		}
	}

	$args = array(
		'post_type'           => 'post',
		'posts_per_page'      => absint( $post_count ),
		'ignore_sticky_posts' => true,
		'orderby'             => 'date',
		'order'               => 'DESC',
	);

	if ( ! empty( $content_ids ) ) {
		$args['post__in'] = $content_ids;
		$args['orderby']  = 'post__in';
	} else {
		$args['orderby'] = 'date';
	}
} elseif ( 'category' === $content_type ) {
	$cat_id = get_theme_mod( 'news_record_videos_category' );
	$args   = array(
		'cat'            => absint( $cat_id ),
		'posts_per_page' => absint( $post_count ),
		'orderby'        => 'date',
		'order'          => 'DESC',
	);
} else {
	$args = array(
		'post_type'           => 'post',
		'posts_per_page'      => absint( $post_count ),
		'ignore_sticky_posts' => true,
		'orderby'             => 'date',
		'order'               => 'DESC',
	);
}

$query = new WP_Query( $args );

if ( ! $query->have_posts() ) {
	return;
}
?>

<section id="news_record_videos_section" class="videos-section section-divider">
	<div class="site-container-width">

		<?php if ( ! empty( $section_title ) ) : ?>
			<div class="header-title">
				<h3 class="section-title"><?php echo esc_html( $section_title ); ?></h3>
			</div>
		<?php endif; ?>

		<div class="videos-nav" aria-hidden="true">
			<button class="videos-nav-btn prev" type="button" aria-label="Previous videos">&#10094;</button>
			<button class="videos-nav-btn next" type="button" aria-label="Next videos">&#10095;</button>
		</div>
		<div class="videos-scroller" dir="rtl">
			<div class="videos-track">
				<?php while ( $query->have_posts() ) : $query->the_post(); ?>
					<div class="video-card" dir="ltr">
						<a href="<?php the_permalink(); ?>" class="video-card-link">
							<div class="video-card-thumb">
								<?php if ( has_post_thumbnail() ) : ?>
									<?php the_post_thumbnail( 'medium_large' ); ?>
								<?php else : ?>
									<div class="video-thumb-placeholder"></div>
								<?php endif; ?>
								<span class="video-duration">03:45</span>
								<div class="video-gradient"></div>
								<div class="video-play-button">
									<i class="fas fa-play"></i>
								</div>
							</div>
							<div class="video-card-detail">
								<h4 class="video-card-title"><?php the_title(); ?></h4>
							</div>
						</a>
					</div>
				<?php endwhile; ?>
				<?php wp_reset_postdata(); ?>
			</div>
		</div>

	</div>
</section>

<style>
.videos-section .site-container-width { max-width: 1320px; width: 100%; margin: 0 auto; padding: 0 16px; }
.videos-section .videos-nav { display: flex; justify-content: flex-end; gap: 8px; margin-bottom: 8px; }
.videos-section .videos-nav-btn { width: 40px; height: 40px; border-radius: 50%; border: 1px solid rgba(0,0,0,0.12); background: #fff; box-shadow: 0 6px 16px rgba(0,0,0,0.08); cursor: pointer; transition: transform 120ms ease, box-shadow 120ms ease, background 120ms ease; }
.videos-section .videos-nav-btn:hover { transform: translateY(-1px); box-shadow: 0 10px 24px rgba(0,0,0,0.12); background: #f7f7f7; }

.videos-section .videos-scroller { overflow: auto; scrollbar-width: thin; padding-bottom: 8px; scroll-behavior: smooth; }
.videos-section .videos-track { display: grid; gap: 20px; grid-auto-flow: column; grid-auto-columns: minmax(200px, 1fr); align-items: stretch; }

@media (min-width: 1200px) { .videos-section .videos-track { grid-auto-columns: calc((100% - 4 * 20px) / 5); } }
@media (min-width: 768px) and (max-width: 1199px) { .videos-section .videos-track { grid-auto-columns: calc((100% - 2 * 20px) / 3); } }
@media (max-width: 767px) { .videos-section .videos-track { grid-auto-columns: calc((100% - 20px) / 2); } }

.videos-section .video-card { background: #fff; border-radius: 14px; box-shadow: 0 10px 24px rgba(0,0,0,0.08); overflow: hidden; transition: transform 150ms ease, box-shadow 150ms ease; height: 100%; display: flex; flex-direction: column; }
.videos-section .video-card:hover { transform: translateY(-3px); box-shadow: 0 14px 32px rgba(0,0,0,0.12); }

.videos-section .video-card-link { display: flex; flex-direction: column; height: 100%; color: inherit; text-decoration: none; }

.videos-section .video-card-thumb { position: relative; aspect-ratio: 16 / 9; overflow: hidden; }
.videos-section .video-card-thumb img { width: 100%; height: 100%; object-fit: cover; display: block; }
.videos-section .video-gradient { position: absolute; inset: 0; background: linear-gradient(180deg, rgba(0,0,0,0.1) 0%, rgba(0,0,0,0.45) 100%); }
.videos-section .video-play-button { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 64px; height: 64px; border-radius: 50%; background: rgba(255,255,255,0.9); display: grid; place-items: center; color: #d60000; box-shadow: 0 8px 24px rgba(0,0,0,0.12), 0 0 0 8px rgba(255,255,255,0.35); transition: transform 150ms ease, background 150ms ease, box-shadow 150ms ease; backdrop-filter: blur(6px); }
.videos-section .video-play-button i { font-size: 22px; margin-left: 2px; }
.videos-section .video-card:hover .video-play-button { transform: translate(-50%, -50%) scale(1.08); background: #fff; box-shadow: 0 10px 30px rgba(0,0,0,0.18), 0 0 0 10px rgba(255,255,255,0.4); }

.videos-section .video-duration { position: absolute; right: 10px; bottom: 10px; padding: 6px 10px; background: rgba(0,0,0,0.65); color: #fff; border-radius: 10px; font-size: 0.85rem; font-weight: 600; }

.videos-section .video-card-detail { padding: 12px 14px 14px; display: flex; flex-direction: column; gap: 4px; }
.videos-section .video-card-title { margin: 0; font-size: 1rem; line-height: 1.4; font-weight: 700; }

.videos-section .videos-scroller { scroll-snap-type: x mandatory; }
.videos-section .video-card { scroll-snap-align: end; }

.videos-section .videos-scroller::-webkit-scrollbar { height: 8px; }
.videos-section .videos-scroller::-webkit-scrollbar-thumb { background: rgba(0,0,0,0.2); border-radius: 999px; }
.videos-section .videos-scroller::-webkit-scrollbar-track { background: rgba(0,0,0,0.05); }

@media (max-width: 480px) { .videos-section .video-card-title { font-size: 0.95rem; } }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
	const scroller = document.querySelector('#news_record_videos_section .videos-scroller');
	const track = document.querySelector('#news_record_videos_section .videos-track');
	const btnPrev = document.querySelector('#news_record_videos_section .videos-nav-btn.prev');
	const btnNext = document.querySelector('#news_record_videos_section .videos-nav-btn.next');
	if (!scroller || !track || !btnPrev || !btnNext) return;

	const scrollStep = () => Math.max(scroller.clientWidth * 0.8, 200);
	const isRTL = scroller.getAttribute('dir') === 'rtl';

	btnPrev.addEventListener('click', () => {
		scroller.scrollBy({ left: isRTL ? scrollStep() : -scrollStep(), behavior: 'smooth' });
	});
	btnNext.addEventListener('click', () => {
		scroller.scrollBy({ left: isRTL ? -scrollStep() : scrollStep(), behavior: 'smooth' });
	});
});
</script>
