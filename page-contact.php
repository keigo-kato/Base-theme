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
				<section id="contact-tel" class="sec-box sec-contact">
					<div class="content-width">
						<div class="sec-ttl-box">
							<h2 class="sec-ttl w-f">CONTACT</h2>
							<p class="sec-sub-ttl main-txt-color">お問い合わせ先</p>
						</div>
						<div class="content-box">
							<div class="sec-text-box">
									<?php the_field('contact-content'); ?>
							</div>
							<div class="sec-contact-inner-box sec-tel-box">
								<h3 class="sub-ttl">電話でのお問い合わせ</h3>
								<div class="tel-box">
									<a href="tel:<?php the_field('tel-number',2); ?>" class="w-f">TEL.<?php the_field('tel-number',2); ?></a>
								</div>
								<div class="text-box">
									<p>受付時間 9:00～18:00（土日祝を除く）</p>
								</div>
							</div>
						</div>
					</div>
				</section>
				<section id="contact-form" class="sec-box">
					<div class="content-width">
						<div class="sec-ttl-box">
							<h2 class="sec-ttl w-f">MAIL FORM</h2>
							<p class="sec-sub-ttl main-txt-color">メールフォーム</p>
						</div>
						<div class="content-box">
							<?php the_content(); ?>
						</div>
						<script>
							document.addEventListener( 'wpcf7mailsent', function( event ) {
								location = '<?php echo the_permalink(); ;?>thanks/';
							}, false );
						</script>
					</div>
				</section>
			</article>

		<?php endwhile; ?>

	</div><!-- #content -->
</div><!-- #container -->

<?php get_footer(); ?>
