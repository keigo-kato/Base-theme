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
				<section id="business-content" class="sec-box common-sec-business">
					<div class="content-width">
						<div class="sec-ttl-box">
							<h2 class="sec-ttl w-f">OUR BUSINESS</h2>
							<p class="sec-sub-ttl main-txt-color">事業紹介</p>
						</div>
						<div class="content-box">
							<div class="sec-text-box">
								<?php the_content(); ?>
							</div>
							<?php if(have_rows('business-item' , 36)): ?>
							<?php while(have_rows('business-item' , 36)): the_row(); ?>
							<div class="text-img-content-box clearfix">
								<div class="img-container img-box">
									<img src="https://placehold.jp/500x300.png" alt="">
									<?php /*
									<img src="<?php the_sub_field('business-image'); ?>" alt="<?php the_sub_field('business-name'); ?>">
									*/ ?>
								</div>
								<div class="text-container">
									<div class="business-ttl-box">
										<h3 class="business-ttl"><?php the_sub_field('business-name'); ?></h3>
										<p class="business-sub-ttl main-txt-color w-f"><?php the_sub_field('business-sub-name'); ?></p>
									</div>
									<div class="business-text-box">
										<h4 class="business-inner-ttl"><?php the_sub_field('business-title'); ?></h4>
										<p><?php the_sub_field('business-top-content'); ?></p>
									</div>
								</div>
							</div>
							<?php endwhile; ?>
							<?php endif; ?>
						</div>
					</div>
				</section>

			</article>

		<?php endwhile; ?>

	</div><!-- #content -->
</div><!-- #container -->

<?php get_footer(); ?>
