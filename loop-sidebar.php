<?php 
	$thumb_w = 80;
	$thumb_h = 80;
	if ( has_post_thumbnail() ) {
		$attachment_id = get_post_thumbnail_id();
		$thumb = my_get_timthumb_image($attachment_id, $thumb_w, $thumb_h);
	} else {
		$thumb = '<img src="' . get_template_directory_uri() . '/images/common/noimage_side.png' . '">' ;
	}
 ?>
<li <?php post_class('entry-list-item '); ?>>
	<div class="clearfix">
		<div class="thumb-box">
			<a href="<?php the_permalink(); ?>" class="img-box"><?php echo $thumb; ?></a>
		</div>
		<div class="item-inner">
			<div class="entry-title-box">
				<h3 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
			</div>
			<div class="entry-meta-box clearfix">
				<span class="entry-meta entry-date w-f"><?php the_time('Y.m.d'); ?></span>
				<div class="entry-meta cat-box">
					<?php echo $cat_items; ?>
				</div>
			</div>
		</div>
	</div>
</li>