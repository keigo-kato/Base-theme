<?php
	$catlist = array();
	$cat_items = '';
	foreach( ( get_the_category() ) as $cat ) {
		$catlist[] = '<a href="' . get_category_link($cat->term_id) . '" class="cat-item cat-item-' . $cat->cat_ID . '">' . $cat->cat_name . '</a>';
	}
	if( $catlist ) {
		$cat_items = implode("\n", $catlist);
	}
 ?>

<li <?php post_class('entry-list-item'); ?>>
	<div class="item-inner clearfix">
		<div class="entry-meta-box">
			<span class="entry-meta entry-date w-f"><?php the_time('Y.m.d'); ?></span>
			<div class="entry-meta cat-box">
				<?php echo $cat_items; ?>
			</div>
		</div>
		<div class="entry-title-box">
			<h3 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
		</div>
	</div>
</li>