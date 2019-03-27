<?php get_header(); ?>

<div id="mainvisual">
	<div id="mv-inner" class="content-width">
		<div id="page-ttl-box">
			<p id="page-sub-ttl" class="main-txt-color w-f"><?php if (get_field('page-sub-ttl')) {the_field('page-sub-ttl');} ?></p>
			<h1 id="page-ttl"><?php the_title(); ?></h1>
		</div>
	</div>
</div>

<?php get_template_part( 'inc/mod', 'breadcrumbs' ); ?>

<div id="container">
	<div id="content" role="main">

		<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

				<div class="entry-content content-width sec-box">
					<?php the_content(); ?>
					<?php wp_link_pages( array( 'before' => '<div class="page-link">Pages:', 'after' => '</div>' ) ); ?>
				</div>

			</article>

		<?php endwhile; ?>

	</div><!-- #content -->
</div><!-- #container -->

<?php get_footer(); ?>
