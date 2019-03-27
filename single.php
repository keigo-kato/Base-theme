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

<div id="container" class="content-width sec-box clearfix">
	<div id="content" class="sidebar-exist" role="main">

		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<h1 class="post-title"><?php the_title(); ?></h1>
				<span class="post-date w-f"><?php the_time('Y.m.d'); ?></span>
				<div class="entry-meta">

					<div class="catlist">
						<?php 
							foreach ( ( get_the_category() ) as $cat) {
								echo '<a href="' . get_category_link( $cat->term_id ) . '" class="cat-item-' . $cat->cat_ID . '">' . $cat->cat_name . '</a>';
							}
						 ?>
					</div>

					<div class="taglist">
						<?php the_tags( '<ul class="floatlist"><li>', '</li><li>', '</li></ul>' ); ?>
					</div>

				</div><!-- .entry-meta -->

				<div class="entry-content">
					<?php the_content(); ?>
					<?php wp_link_pages( array( 'before' => '<div class="page-link">Pages:', 'after' => '</div>' ) ); ?>
					<?php edit_post_link( 'Edit', '<span class="edit-link">', '</span>' ); ?>
				</div>

				<?php get_template_part('inc/mod', 'sns_bottom'); ?>

			</article>

			<div id="nav-below" class="navigation clearfix">
				<div class="nav-previous w-f"><?php previous_post_link( '%link', 'PREVIOUS' ); ?></div>
				<div class="nav-next w-f"><?php next_post_link( '%link', 'NEXT' ); ?></div>
			</div><!-- #nav-below -->

		<?php endwhile; endif; ?>
	</div><!-- #content -->
	<?php get_sidebar(); ?>
</div><!-- #container -->
<?php get_footer(); ?>
