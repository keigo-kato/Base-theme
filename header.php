<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<?php wp_head(); ?>
<script>
(function($){

var pcView = 1000,
		spView = 500,
		view	 = (navigator.userAgent.indexOf('iPhone') > 0 || navigator.userAgent.indexOf('iPod') > 0 || (navigator.userAgent.indexOf('Android') > 0 && navigator.userAgent.indexOf('Mobile') > 0)) ? spView : pcView;

$('meta[name="viewport"]').remove();
$('head')
	.prepend('<meta name="viewport" content="width=' + view + '">')
	.append('<style>@-ms-viewport { width: device-width; } /* windows pc (IE) - DO NOT FIX */@media screen and (max-width: ' + pcView + 'px) {@-ms-viewport { width: ' + pcView + 'px; } /* for windows tablet */}@media screen and (max-width: ' + spView + 'px) {@-ms-viewport { width: ' + pcView + 'px; } /* for windows phone */}</style>');

})(jQuery);
</script>
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

<?php //google fonts ?>
<link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet">

</head>

<body <?php body_class(); if( is_page() ) : ?> id="<?php echo esc_attr( $post->post_name ); ?>"<?php endif; ?>>

<div id="wrapper">

<div id="sp-menu" class="w-f">
	<ul>
		<?php
			$args = array(
				'container' => false,
				'theme_location' => 'primary',
				'items_wrap' => '%3$s',
			);
			wp_nav_menu( $args );
			?>
		<li class="sp-cv-box">
			<a href="/contact/" class="w-f">お問い合わせ<br><span>CONTACT</span></a>
		</li>
		<li class="sp-tel-box"><a href="tel:<?php the_field('tel-number',2); ?>" class="tel"><i class="fa fa-mobile"></i><?php the_field('tel-number',2); ?></a></li>
	</ul>
</div>

<header id="header" class="header-fix">
	<!-- #header-inner -->
	<div id="header-inner">
		<!-- #site-description -->
		<div id="site-description">
			<div class="content-width">
				<?php bloginfo('description'); ?>
			</div>
		</div>
		<!-- #site-description -->
		<!-- #header-content -->
		<div id="header-content" class="content-width clearfix">
			<?php $heading_tag = ( is_home() || is_front_page() ) ? 'h1' : 'div'; ?>
			<<?php echo $heading_tag; ?> id="site-title" class="left">
				<a href="<?php echo home_url(); ?>" rel="home">
					<img src="<?php echo get_stylesheet_directory_uri() ;?>/images/common/h_logo_01.png" alt="<?php bloginfo('name'); ?>">
				</a>
			</<?php echo $heading_tag; ?>>
			<div class="right h-cv-box link-box btn-box">
				<a href="/contact/" class="btn common-btn main-bg-color w-f">CONTACT</a>
			</div>
			<!-- #header-content -->
			<a href="#sp-menu" class="hamburger"><span class="hamburger__icon"></span></a>
		</div>
	</div>
	<!-- #header-inner -->
	<nav id="global-nav">
		<div class="content-width w-f">
			<?php
			$args = array(
				'container' => false,
				'menu_class' => 'floatlist',
				'theme_location' => 'primary',
			);
			wp_nav_menu( $args );
			?>
		</div>
	</nav><!-- #gnav -->
</header>

<div id="main">