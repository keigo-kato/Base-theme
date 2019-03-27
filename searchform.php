<?php $unique_id = esc_attr(uniqid('search-form-')); ?>

<form method="get" class="search-form" action="<?php echo esc_url(home_url()); ?>">
	<input type="text" name="s" value="<?php the_search_query(); ?>" placeholder="サイト内検索" >
	<input type="submit" value="検索" id="<?php echo $unique_id; ?>" class="search-submit">
</form>
