<?php get_header(); ?>

<div id="container">
	<div id="content" role="main">

<?php if ( have_posts() ) : ?>

		<h1 class="archive-title">「<?php the_search_query(); ?>」の検索結果</h1>

		<?php while ( have_posts() ) : the_post(); ?>
			<?php get_template_part('loop'); ?>
		<?php endwhile; ?>

		<?php if ( function_exists( 'wp_pagenavi' ) ) wp_pagenavi(); ?>

<?php else : ?>

		<?php get_template_part( 'inc/content', 'none' ); ?>

<?php endif; ?>

	</div><!-- #content -->
</div><!-- #container -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
