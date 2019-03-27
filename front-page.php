<?php get_header(); ?>

<div id="top-mainvisual">
	<div id="mv-inner" class="content-width">
		<div id="mv-ttl-box">
			<h2 id="mv-ttl" class="w-f">Heisenberg<br>Theme</h2>
			<p id="mv-sub-ttl">New Directors Theme<br>base on site alfa</p>
		</div>
	</div>
</div>

<div id="container">
	<div id="content" role="main">
		<?php //ABOUT ?>
		<section id="top-about" class="sec-box">
			<div class="content-width">
				<div class="sec-ttl-box">
					<h2 class="sec-ttl w-f">ABOUT</h2>
					<p class="sec-sub-ttl main-txt-color">Heisenbergについて</p>
				</div>
				<div class="content-box">
					<div class="text-box">
						<?php the_field('about-content'); ?>
					</div>
				</div>
			</div>
		</section>
		<?php //BUSINESS ?>
		<section id="top-business" class="sec-box common-sec-business sec-bg-color">
			<div class="content-width">
				<div class="sec-ttl-box">
					<h2 class="sec-ttl w-f">BUSINESS</h2>
					<p class="sec-sub-ttl main-txt-color">事業内容</p>
				</div>
				<div class="content-box">
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
				<div class="link-box btn-box">
					<a href="/business/" class="btn common-btn main-bg-color btn-arrow w-f">MORE</a>
				</div>
			</div>
		</section>
		<?php //BLOG
			$args = array(
				"post_type" => 'post',
				"posts_per_page" => 3,
			);
			$blog_posts = get_posts( $args );
		?>
		<section id="top-blog" class="sec-box">
			<div class="content-width">
				<div class="sec-ttl-box">
					<h2 class="sec-ttl w-f">BLOG</h2>
					<p class="sec-sub-ttl main-txt-color">ブログ</p>
				</div>
				<div class="content-box">
					<ul id="blog-list" class="floatlist">
					<?php if( $blog_posts ): ?>
						<?php foreach( $blog_posts as $post ): setup_postdata($post); ?>
							<?php get_template_part( "loop" , "blog" ); ?>
						<?php endforeach; wp_reset_postdata(); ?>
					<?php endif; ?>
					</ul>
				</div>
				<div class="link-box btn-box">
					<a href="/blog/" class="btn common-btn main-bg-color btn-arrow w-f">MORE</a>
				</div>
			</div>
		</section>
		<?php //NEWS
			$args = array(
				"post_type" => 'post',
				// "category_name" => 'news',
				"posts_per_page" => 5,
			);
			$news_posts = get_posts( $args );
		?>
		<section id="top-news" class="sec-box sec-bg-color">
			<div class="content-width">
				<div class="sec-ttl-box">
					<h2 class="sec-ttl w-f">NEWS</h2>
					<p class="sec-sub-ttl main-txt-color">新着情報</p>
				</div>
				<div class="content-box">
					<ul id="post-list">
					<?php if( $news_posts ): ?>
						<?php foreach( $news_posts as $post ): setup_postdata($post); ?>
							<?php get_template_part( "loop" ); ?>
						<?php endforeach; wp_reset_postdata(); ?>
					<?php endif; ?>
					</ul>
				</div>
				<div class="link-box btn-box">
					<a href="/news/" class="btn common-btn main-bg-color btn-arrow w-f">MORE</a>
				</div>
			</div>
		</section>
		<section id="top-contact" class="sec-box common-sec-contact sec-contact">
			<div class="content-width">
				<div class="sec-ttl-box">
					<h2 class="sec-ttl w-f">CONTACT</h2>
					<p class="sec-sub-ttl main-txt-color">お問い合わせ</p>
				</div>
				<div class="content-box clearfix">
					<div id="top-tel-box" class="sec-contact-inner-box sec-tel-box">
						<h3 class="sub-ttl">電話でのお問い合わせ</h3>
						<div class="tel-box">
							<a href="tel:<?php the_field('tel-number'); ?>" class="w-f">TEL.<?php the_field('tel-number'); ?></a>
						</div>
						<div class="text-box">
							<p>受付時間 9:00～18:00（土日祝を除く）</p>
						</div>
					</div>
					<div id="top-mail-box" class="sec-contact-inner-box sec-mail-box">
						<h3 class="sub-ttl">メールでのお問い合わせ</h3>
						<div class="link-box btn-box">
							<a href="/contact/" class="btn common-btn main-bg-color btn-arrow w-f">MAIL FORM</a>
						</div>
					</div>
				</div>
			</div>
		</section>

	</div><!-- #content -->
</div><!-- #container -->
<?php get_footer(); ?>
