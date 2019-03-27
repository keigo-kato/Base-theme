/* = 外部リンクの追加
-------------------------------------------------------------- */
jQuery(document).ready(function($){
	$('a[href^=http]').not('[href*="'+location.hostname+'"]').attr({target:"_blank"}).addClass("ex_link");
});

/* =高さの調節
-------------------------------------------------------------- */
jQuery(document).ready(function($){
	$(window).on('load', function(){
		$('.heightLine').heightLine();
	});
});

/* = PC/SP画像の切り替え
-------------------------------------------------------------- */
jQuery(function($){
	var $setElem = $('.switch');
	var pcName = '_pc';//PC版のファイル名
	var spName = '_sp';//スマホ版のファイル名(htmlにはこちらをつかう)
	
	var matchMedia = '(max-width:768px)';

	$setElem.each(function(){
		var $img = $(this);
		var imgSize = function(){
			var imgSrc = $img.attr('src');
			imgSrc = ( window.matchMedia(matchMedia).matches ) ? imgSrc.replace(pcName,spName) : imgSrc.replace(spName,pcName);
			$img.attr('src', imgSrc).css({visibility:'visible'});
		};
		$(window).on('load resize', imgSize);
	});
});

/* = Smooth Scroll + Header Fixed
-------------------------------------------------------------- */
(function($){
	var $header = $('#header');
	var href;
	$('a.smooth-scroll').on('click', function(){
		href = $(this).attr('href');
		var tgt = $(href === "#" ? 'html' : href);
		var position = $(tgt).offset().top;
		var getHeader = ( $header.hasClass('header-fix') ) ? $header.outerHeight() : 0;
		position = position - getHeader;
		$('body,html').animate({
			scrollTop: position
		}, 800);
		return false;
	});
})(jQuery);

/* = SP用メニュー
-------------------------------------------------------------- */
jQuery(document).ready(function($){
	$('#sp-menu').mmenu({
		"extensions": [
			"multiline",
			"pagedim-black",
		],
		offCanvas: {
			position: 'right',
			// zposition: 'front',
		},
		navbar: {
			title: "Menu",
		}
	});
});

