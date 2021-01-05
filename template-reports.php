<?php
/**
 * Template name: Surf Reports
 *
 * @package storefront
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php
			$loop = new WP_Query( array( 'post_type' => 'surf_reports', 'posts_per_page' => 10 ) ); 

			while ( $loop->have_posts() ) : $loop->the_post();
			
			the_title( '<h2 class="entry-title"><a href="' . get_permalink() . '" title="' . the_title_attribute( 'echo=0' ) . '" rel="bookmark">', '</a></h2>' ); 
			?>
			
				<div class="entry-content">
					<?php the_content(); ?>
				</div>
			
			<?php endwhile; ?>
			

		</main><!-- #main -->
	</div><!-- #primary -->
<?php
get_footer();
