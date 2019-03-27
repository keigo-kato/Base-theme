<?php get_header(); ?>

<div id="mainvisual">
	<div id="mv-inner" class="content-width">
		<div id="page-ttl-box">
			<p id="page-sub-ttl" class="main-txt-color w-f">404 Not Found</p>
			<h1 id="page-ttl">404エラー</h1>
		</div>
	</div>
</div>

<div id="container">
	<div id="content" role="main">
		<div class="content-width sec-box">
		<?php get_template_part( 'inc/content', 'none' ); ?>
		</div>
	</div><!-- #content -->
</div><!-- #container -->
<script>
// focus on search field after it has loaded
document.getElementById('s') && document.getElementById('s').focus();
</script>

<?php get_footer(); ?>
