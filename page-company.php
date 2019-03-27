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
				<section id="company-about" class="sec-box">
					<div class="content-width">
						<div class="sec-ttl-box">
							<h2 class="sec-ttl w-f">ABOUT</h2>
							<p class="sec-sub-ttl main-txt-color">株式会社Heisenbergについて</p>
						</div>
						<div class="content-box">
							<?php the_content(); ?>
						</div>
					</div>
				</section>
				<?php //message ?>
				<section id="company-message" class="sec-box">
					<div class="content-width">
						<div class="sec-ttl-box">
							<h2 class="sec-ttl w-f">MESSAGE</h2>
							<p class="sec-sub-ttl main-txt-color">代表メッセージ</p>
						</div>
						<div class="content-box">
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
							tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
							quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
							consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
							cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
							proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
						</div>
					</div>
				</section>
				<?php //outline
				if(have_rows('company-outline')): ?>
				<section id="company-outline" class="sec-box">
					<div class="content-width">
						<div class="sec-ttl-box">
							<h2 class="sec-ttl w-f">OUTLINE</h2>
							<p class="sec-sub-ttl main-txt-color">会社概要</p>
						</div>
						<div class="content-box">
							<div id="outline-list" class="table-dl-box">
								<?php while(have_rows('company-outline')): the_row(); ?>
								<dl>
									<dt><?php the_sub_field('company-outline-term'); ?></dt>
									<dd><?php the_sub_field('company-outline-data'); ?></dd>
								</dl>
								<?php endwhile; ?>
							</div>
						</div>
					</div>
				</section>
				<?php endif; ?>
				<?php //history
				if(have_rows('company-history')): ?>
				<section id="company-history" class="sec-box">
					<div class="content-width">
						<div class="sec-ttl-box">
							<h2 class="sec-ttl w-f">HISTORY</h2>
							<p class="sec-sub-ttl main-txt-color">会社沿革</p>
						</div>
						<div class="content-box">
							<div id="history-list" class="table-dl-box">
								<?php while(have_rows('company-history')): the_row(); ?>
								<dl>
									<dt><?php the_sub_field('company-history-term'); ?></dt>
									<dd><?php the_sub_field('company-history-data'); ?></dd>
								</dl>
								<?php endwhile; ?>
							</div>
						</div>
					</div>
				</section>
				<?php endif; ?>
			</article>

		<?php endwhile; ?>

	</div><!-- #content -->
</div><!-- #container -->

<?php get_footer(); ?>
