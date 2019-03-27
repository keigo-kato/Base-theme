<?php 
	$post_type = get_post_type();
	$itm_cats = get_terms( 'category' ,array(
		'hide_empty' => true,
	) );
?>
<aside id="sidebar">
	<?php //category ?>
	<section id="side-category" class="side-box">
		<div class="side-ttl-box">
			<h2 class="side-ttl w-f">CATEGORY</h2>
			<p class="side-sub-ttl main-txt-color">カテゴリ</p>
		</div>
		<div class="content-box">
			<ul class="side_cat">
				<?php foreach ( $itm_cats as $itm_category ) : ?>
				<li>
					<a href="<?php echo get_term_link( $itm_category ); ?>"><?php echo $itm_category->name; ?></a>
				</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>


	<section id="side-newly" class="side-box">
		<div class="side-ttl-box">
			<h2 class="side-ttl w-f">NEW ENTRY</h2>
			<p class="side-sub-ttl main-txt-color">新着記事</p>
		</div>
		<div class="content-box">
			<?php
				$args = array(
					"post_type" => $post_type,
					"posts_per_page" => 5
				);
				$posts = get_posts($args);
			?>
			<?php if($posts): ?>
			<ul id="side-list">
				<?php foreach($posts as $post): setup_postdata($post); ?>
					<?php get_template_part( 'loop','sidebar' ); ?>
				<?php endforeach; wp_reset_postdata(); ?>
			</ul>
		<?php endif; ?>
	</section>

</aside>