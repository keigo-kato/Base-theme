<?php get_header(); ?>

<div id="mainvisual">
	<div id="mv-inner" class="content-width">
		<div id="page-ttl-box">
			<p id="page-sub-ttl" class="main-txt-color w-f">NEWS</p>
			<h1 id="page-ttl">新着情報</h1>
		</div>
	</div>
</div>

<?php get_template_part( 'inc/mod', 'breadcrumbs' ); ?>

<div id="container">
	<div id="content" role="main">
		<div class="content-width sec-box">

<?php if ( have_posts() ) : ?>

			<ul id="post-list">
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'loop' ); ?>
			<?php endwhile; ?>
			</ul>
		<?php if ( function_exists( 'wp_pagenavi' ) ) wp_pagenavi(); ?>

<?php else : ?>

		<?php get_template_part( 'inc/content', 'none' ); ?>

<?php endif; ?>
		</div>
	</div><!-- #content -->
</div><!-- #container -->

<?php get_footer(); ?>
