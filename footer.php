</div><!-- #main -->

<div id="to-top">
	<a href="#" class="smooth-scroll"><i class="fa fa-chevron-up" aria-hidden="true"></i><span>TOPへ</span></a>
</div>


<footer id="footer">
	<div id="footer-content">
		<div class="content-width clearfix">
			<div id="footer-title" class="left">
				<a href="<?php echo home_url(); ?>" rel="home">
					<img src="<?php echo get_stylesheet_directory_uri() ;?>/images/common/f_logo_01.png" alt="<?php bloginfo('name'); ?>">
				</a>
			</div>
		</div>
	</div>
	<div id="footer-menu-box">
		<div class="content-width clearfix">
			<nav id="footer-menu" class=" left w-f">
				<?php 
				$args = array(
					'container' => 'none',
					'menu_class' => 'floatlist',
					'theme_location' => 'footer',
				);
				wp_nav_menu( $args );
				?>
			</nav>
			<div class="right f-cv-box link-box btn-box">
				<a href="/contact/" class="btn common-btn main-bg-color w-f">CONTACT</a>
			</div>
		</div>
	</div>
	<div id="copyright">
		<div class="content-width w-f">
			<p class="w-f">&copy; 2019 <?php bloginfo('name'); ?></p>
		</div>
	</div>
</footer>

</div><!-- #wrapper -->

<?php wp_footer(); ?>

</body>
</html>
