<?php 
/* = setup
-------------------------------------------------------------- */
add_action( 'after_setup_theme', 'setup_theme', 11 );
function setup_theme() {
	add_editor_style( array(
		'./css/admin-editor-style.css', 
	) );

	add_theme_support( 'post-thumbnails' );
	
	add_theme_support( 'title-tag' );
	
	register_nav_menus( array(
		'primary' => __( 'Global Navigation', 'twentyten' ),
		'sidenav' => __( 'Sidebar Navigation', 'twentyten' ),
		'footer' => __( 'Footer Navigation', 'twentyten' ),
		'sitemap' => __( 'Sitemap Navigation', 'twentyten' ),
		'mobile' => __( 'Mobile Navigation', 'twentyten' ),
	) );
}


/* = for timthumb
-------------------------------------------------------------- */
function my_attachment_url_for_timsrc($data) {
	$url = my_get_attachment_url_for_timsrc($data);
	echo $url;
}
function my_get_attachment_url_for_timsrc($data) {
	$url = "";
	if($data){
		if(is_numeric($data)){
			$url = wp_get_attachment_url($data);
		} else {
			$ptn = "/^" . preg_quote(site_url(), "/") . "/u";
			if(preg_match($ptn, $data)){
				$url = $data;
			}
		}
		if($url){
			$ptn = "/(^http[s]{0,1}:\/\/[^\/]+?)\//u";
			if(preg_match($ptn, $url, $mt)){
				$url = str_replace($mt[1], "", $url);
			}
		}
	}
	return $url;
}

function my_get_timthumb_image($attachment_id=0, $thumb_w=480, $thumb_h=320) {
	$img = '<img src="//placehold.jp/'.$thumb_w.'x'.$thumb_h.'.png?text=Noimage">';
	$check = array();
	$check[] = ( function_exists('my_get_attachment_url_for_timsrc') ) ? true : false;
	$check[] = ( 0 !== $attachment_id ) ? true : false;
	if( in_array(false, $check) ) return $img;

	$imgarg = array(
		"src" => my_get_attachment_url_for_timsrc($attachment_id),
		"w" => $thumb_w, "h" => $thumb_h, "q" => "100", "zc" => "1"
	);
	$imgsrc = get_stylesheet_directory_uri() . "/scripts/timthumb.php";
	$imgsrc = add_query_arg($imgarg, $imgsrc);
	
	$img = '<img src="' . $imgsrc . '" alt="">';
	return $img;
}


//post type archive description
//カスタムポストアーカイブのトップにディスクリプションを入れる
add_filter("aioseop_description", "my_description");
function my_description($description) {
	if($description === ""){
		if(is_post_type_archive()){
			$obj = get_post_type_object(get_post_type());
			if($obj->description){
				$description = $obj->description;
			}
		}
	}
	return $description;
}

//モバイル(SPのみ)端末条件分岐
if( !function_exists('is_mobile') ) {
	function is_mobile() {
		$useragents = array(
			'iPhone', // iPhone
			'iPod', // iPod touch
			'Android.*Mobile', // 1.5+ Android *** Only mobile
			'Windows.*Phone', // *** Windows Phone
			'dream', // Pre 1.5 Android
			'CUPCAKE', // 1.5+ Android
			'blackberry9500', // Storm
			'blackberry9530', // Storm
			'blackberry9520', // Storm v2
			'blackberry9550', // Storm v2
			'blackberry9800', // Torch
			'webOS', // Palm Pre Experimental
			'incognito', // Other iPhone browser
			'webmate' // Other iPhone browser
		);
		$pattern = '/'.implode('|', $useragents).'/i';
		return preg_match($pattern, $_SERVER['HTTP_USER_AGENT']);
	}
}

function my_get_stripped_string($string){
	if( !$string && !is_string($string) ) return '';
	
	return str_replace("&nbsp;", "", strip_tags( strip_shortcodes($string) ) );
}

function my_get_substr_with_suffix($string, $length=40, $suffix='...'){
	if( !$string && !is_string($string) ) return '';

	$string = my_get_stripped_string($string);
	if( mb_strlen($string) > $length ){
		$string = mb_substr($string, 0, $length) . $suffix;
	}
	return $string;
}

function my_get_excerpt($length=40, $suffix='...'){
	global $post;
	$content = $post->post_excerpt;
	if( !$content ){
		$content = $post->post_content;
	}
	return my_get_substr_with_suffix($content, $length, $suffix);
}

//attachment_id=ページに404を返す
add_action( 'template_redirect', 'gs_attachment_template_redirect' );
function gs_attachment_template_redirect() {
	if ( is_attachment() ) { // 添付ファイルの個別ページなら
		global $wp_query;
		$wp_query->set_404();
		status_header(404);
	}
}

//カスタムポスト一覧でタクソノミーの絞込をつける。
add_action( 'restrict_manage_posts', 'refineSearchPosts' );
// 投稿で絞り込み項目の表示
function refineSearchPosts() {
	global $typenow;
	$args =array( 'public' => true, '_builtin' => false );
	$post_types = get_post_types($args);
	if ( in_array($typenow, $post_types) ) {
		$filters = get_object_taxonomies($typenow);
		foreach ($filters as $tax_slug) {
			$tax_obj = get_taxonomy($tax_slug);

			// 値が入っているか確認する
			if (isset($_GET[$tax_obj->query_var])){
				$var = $_GET[$tax_obj->query_var];
			}else{
				$var = $tax_obj->query_var;
			}
			wp_dropdown_categories(array(
				'show_option_all' => __('すべての'.$tax_obj->label ),
				'taxonomy' => $tax_slug,
				'name' => $tax_obj->name,
				'orderby' => 'term_order',
				'selected' => $var,
				'hierarchical' => $tax_obj->hierarchical,
				'show_count' => true,	//カテゴリーに属する投稿数の表示
				'hide_empty' => false, //カテゴリー・タグが存在しなくても項目を表示する（何もない場合空のフォームができてしまうため）
			));
		}
	}
}


/* = 絞り込み検索内容の変換処理
-------------------------------------------------------------- */
add_filter('parse_query', 'convertRefineContent');
function convertRefineContent($query) {
	global $pagenow;
	global $typenow;
	if ($pagenow=='edit.php') {
		$filters = get_object_taxonomies($typenow);
		foreach ($filters as $tax_slug) {
			$var =& $query->query_vars[$tax_slug];
			if ( isset($var) && $var>0)	{
				$term = get_term_by('id',$var,$tax_slug);
				$var = $term->slug;
			}
		}
	}
	return $query;
}

/* = 投稿一覧にサムネイル追加
-------------------------------------------------------------- */
add_filter( 'manage_posts_columns', 'add_posts_columns_thumbnail' );
function add_posts_columns_thumbnail($columns) {
	$columns['thumbnail'] = 'サムネイル';
	return $columns;
}
add_action( 'manage_posts_custom_column', 'add_posts_columns_thumbnail_row', 10, 2 );
function add_posts_columns_thumbnail_row($column_name, $post_id) {
	if ( 'thumbnail' == $column_name ) {
		$thumb = get_the_post_thumbnail($post_id, array(100,100), 'thumbnail');
		echo ( $thumb ) ? $thumb : '－';
	}
}

/* = Password Protected でnoindexを出力する
-------------------------------------------------------------- */
add_action('password_protected_login_head', 'my_password_protected_login_head_no_index');
function my_password_protected_login_head_no_index () {
	if ( has_action( 'password_protected_login_head' ) ) wp_no_robots();
}

/* = Scripts && Style
-------------------------------------------------------------- */
add_action('wp_enqueue_scripts', 'my_wp_enqueue_scripts', 11);
function my_wp_enqueue_scripts() {
	$dir_path = get_stylesheet_directory_uri();

	$args = array(
		'handle' => 'theme-normalize', 
		'src'    => $dir_path . '/css/normalize.css', 
		'deps'   => array(), 
		'ver'    => false, 
		'media'  => 'all' 
	);
	extract($args);
	wp_enqueue_style( $handle, $src, $deps, $ver, $media );

	$args = array(
		'handle' => 'theme-common', 
		'src'    => $dir_path . '/css/common.css', 
		'deps'   => array(), 
		'ver'    => false, 
		'media'  => 'all' 
	);
	extract($args);
	wp_enqueue_style( $handle, $src, $deps, $ver, $media );

	$args = array(
		'handle' => 'theme', 
		'src'    => get_stylesheet_uri(), 
		'deps'   => array(), 
		'ver'    => false, 
		'media'  => 'all' 
	);
	extract($args);
	wp_enqueue_style( $handle, $src, $deps, $ver, $media );

	if( is_home() || is_front_page() ) {
		$args = array(
			'handle' => 'home', 
			'src'    => $dir_path . '/css/home.css', 
			'deps'   => array(), 
			'ver'    => false, 
			'media'  => 'all', 
		);
		extract($args);
		wp_enqueue_style( $handle, $src, $deps, $ver, $media );
	}

	if( is_page() && !is_front_page() ) {
		$args = array(
			'handle' => 'page-style', 
			'src'    => $dir_path . '/css/page.css', 
			'deps'   => array(), 
			'ver'    => false, 
			'media'  => 'all' 
		);
		extract($args);
		wp_enqueue_style( $handle, $src, $deps, $ver, $media );
	}

	if( is_single() || is_singular() && !is_front_page() ) {
		$args = array(
			'handle' => 'entry-style', 
			'src'    => $dir_path . '/css/entry.css', 
			'deps'   => array(), 
			'ver'    => false, 
			'media'  => 'all' 
		);
		extract($args);
		wp_enqueue_style( $handle, $src, $deps, $ver, $media );
	}

	$mmenu_path = '/scripts/mmenu';
	$args = array(
		'handle' => 'jquery.mmenu.all', 
		'src'    => $dir_path . $mmenu_path . '/jquery.mmenu.all.css', 
		'deps'   => array(), 
		'ver'    => false, 
		'media'  => 'screen' 
	);
	extract($args);
	wp_enqueue_style( $handle, $src, $deps, $ver, $media );

	$args = array(
		'handle' => 'for-jquery.mmenu', 
		'src'    => $dir_path . $mmenu_path . '/for-jquery.mmenu.css', 
		'deps'   => array('jquery.mmenu.all'), 
		'ver'    => false, 
		'media'  => 'screen' 
	);
	extract($args);
	wp_enqueue_style( $handle, $src, $deps, $ver, $media );

	$args = array(
		'handle' => 'jquery.mmenu.all.js', 
		'src'    => $dir_path . $mmenu_path . '/jquery.mmenu.all.js', 
		'deps'   => array('jquery'), 
		'ver'    => false, 
		'in_footer' => true, 
	);
	extract($args);
	wp_enqueue_script( $handle, $src, $deps, $ver, $in_footer );

	$args = array(
		'handle' => 'jquery.heightLine.js', 
		'src'    => $dir_path . '/scripts/jquery.heightLine.js', 
		'deps'   => array('jquery'), 
		'ver'    => false, 
		'in_footer' => true, 
	);
	extract($args);
	wp_enqueue_script( $handle, $src, $deps, $ver, $in_footer );

	$args = array(
		'handle' => 'myscripts.js', 
		'src'    => $dir_path . '/scripts/myscripts.js', 
		'deps'   => array('jquery'), 
		'ver'    => false, 
		'in_footer' => true, 
	);
	extract($args);
	wp_enqueue_script( $handle, $src, $deps, $ver, $in_footer );
}


/* = フロントエンド関連
-------------------------------------------------------------- */
//タイトル属性を出力
function attribute_add_nav_menu($item_output, $item){
	return preg_replace('/(<a.*?>[^<]*?)</', '$1' . "<br><span>{$item->attr_title}</span><", $item_output);
}
add_filter('walker_nav_menu_start_el', 'attribute_add_nav_menu', 10, 4);

//ページャーの下に件数表示
function my_result_count() {
	global $wp_query;
	if( is_mobile() ) {
		$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
		$max_page = $wp_query->max_num_pages;
		echo '<p class="result_count">' . $paged . '/' . $max_page . '</p>' ;
	} else {
		$paged = get_query_var('paged') - 1;
		$ppp = get_query_var('posts_per_page');
		$count = $total = $wp_query->post_count;
		$from = 0;
		if( 0 < $ppp ){
			$total = $wp_query->found_posts;
			if( 0 < $paged ) $from = $paged * $ppp;
		}
		printf(
			'<p class="result_count">%1$s件中 %2$s%3$s件を表示</p>',
			$total,
			( 1 < $count ? ( $from + 1 . '-' ) : '' ),
			( $from + $count )
		);
	}
}

/* = WordPress管理画面関連
-------------------------------------------------------------- */
// エディタ関連
add_filter( 'tiny_mce_before_init', 'custom_editor_settings' );
function custom_editor_settings( $initArray ){
	$initArray['block_formats'] = "段落=p; 見出し2=h2; 見出し3=h3; 見出し4=h4;"; //管理画面の「見出し１」等を削除する
	$initArray['body_class'] = 'entry-content'; //エディタの親要素を .entry-content とする
	return $initArray;
}
// pタグの自動整形
add_filter('the_content', 'wpautop_filter', 9);
function wpautop_filter($content) {
	global $post;
	$remove_filter = false;

	$arr_types = array('page'); //自動整形を解除・無効にする投稿タイプを記述
	$post_type = get_post_type( $post->ID );
	if ( in_array($post_type, $arr_types) ) $remove_filter = true;
	
	if ( $remove_filter ) {
		// remove_filter('the_content', 'wpautop');
		// remove_filter('the_excerpt', 'wpautop');
	}
	return $content;
}

// カテゴリの階層維持
add_filter('wp_terms_checklist_args', 'my_category_checklist_args', 10, 2);
function my_category_checklist_args($args, $post_id) {
	if( isset($args['taxonomy']) && $args['taxonomy'] === 'category' ) {
		$args['checked_ontop'] = false;
	}
	return $args;
}

// メディアアップローダー不要項目の非表示
add_action('admin_print_styles', 'admin_css_custom');
function admin_css_custom() {
	echo '<style>.attachment-details label[data-setting="description"], .attachment-details label[data-setting="title"], div.attachment-display-settings { display: none; }</style>';
}

//管理画面 ツールバー設定
add_action( 'admin_bar_menu', 'remove_wp_nodes', 999 );
function remove_wp_nodes() {
	global $wp_admin_bar;
	//全ユーザー
	$wp_admin_bar->remove_node( 'wp-logo' ); //WordPressロゴ
	$wp_admin_bar->remove_node( 'notes' ); //Jetpack通知
	//管理者以外
	if( !current_user_can('level_10') ) {
		$wp_admin_bar->remove_node( 'new-page' ); //新規固定ページ
		$wp_admin_bar->remove_node( 'comments' ); //コメント
		$wp_admin_bar->remove_node( 'updates' ); //更新通知アイコン
		$wp_admin_bar->remove_node( 'wpseo-menu' ); //Yoast
	}
}
// ContacForm7
add_action('admin_menu', 'remove_admin_menus');
function remove_admin_menus() { 
  if (!current_user_can('level_8')) { 
      remove_menu_page('wpcf7'); 
  }
}

//管理画面 ユーザー毎表示項目制御系
//制御クラス //
class MyAdminPanelPerUserRole {
	public function __construct(){
		return false;
	}
	
	static public function get_self_name(){
		return get_class();
	}
	
	static public function activate_actions(){
		if( 'admin_init' === current_filter() ){
			self::admin_actions_if_not_administrator();
		}
	}
	
	static protected function admin_actions_if_not_administrator(){
		if( current_user_can('administrator') ) return;
		
		self::remove_any_from_admin_notices();
		self::remove_any_from_admin_footer();
		
		$cls = self::get_self_name();
		
		add_filter('manage_pages_columns', array($cls, 'hook_manage_columns'), 20, 1);
		add_filter('manage_posts_columns', array($cls, 'hook_manage_columns'), 20, 2);
		
		add_action('add_meta_boxes', array($cls, 'hook_add_meta_boxes'), 20);
		add_filter('aioseop_add_post_metabox', array($cls, 'hook_aioseop_add_post_metabox'), 20, 1);
		
		self::remove_ps_taxonomy_expander_action();
	}
	
	static protected function remove_any_from_admin_notices(){
		remove_action('admin_notices', 'update_nag', 3); //更新通知
	}
	
	static protected function remove_any_from_admin_footer(){
		add_filter('admin_footer_text', '__return_empty_string'); //WordPressのご利用～
		add_filter('update_footer', '__return_empty_string'); //バージョン～
	}
	
	static public function hook_manage_columns($posts_columns, $post_type='page'){
		//do nothing to 1st arg but pass the next action
		$next_hook_name = 'manage_' . $post_type . '_posts_columns';
		$cls = self::get_self_name();
		add_action($next_hook_name, array($cls, 'hook_manage_any_post_columns'), 20, 1);
		
		return $posts_columns;
	}
	
	static public function hook_manage_any_post_columns($posts_columns){
		$post_type = preg_match("/^manage_([^_]+)_/u", current_filter(), $mt) ? $mt[1] : '';
		$posts_columns = self::remove_any_from_post_columns($posts_columns, $post_type);
		return $posts_columns;
	}
	
	static protected function remove_any_from_post_columns($posts_columns, $post_type){
		$rmv_keys = array(
		//All in one SEO
		'seotitle', 'seodesc', 'seokeywords', 
		);
		if( class_exists('WPSEO_Meta_Columns') ){
			$rmv_keys = array_merge( $rmv_keys, array(
			//Yoast SEO - meta
			'wpseo-score', 'wpseo-score-readability', 
			'wpseo-title', 'wpseo-metadesc', 
			'wpseo-focuskw', 
			) );
		}
		if( class_exists('WPSEO_Link_Columns') ){
			$rmv_keys = array_merge( $rmv_keys, array(
			//Yoast SEO - link
			'wpseo-' . WPSEO_Link_Columns::COLUMN_LINKED, 
			'wpseo-' . WPSEO_Link_Columns::COLUMN_LINKS, 
			) );
		}
		foreach( $rmv_keys as $rk ){ unset($posts_columns[$rk]); }
		return $posts_columns;
	}
	
	// 投稿編集画面 特定メタボックス非表示 //
	static public function hook_add_meta_boxes(){
		$crrnt_scrn = get_current_screen();
		$crrnt_post_type = ( $crrnt_scrn ) ? $crrnt_scrn->post_type : '';
		if( $crrnt_post_type ){
			remove_meta_box('wpseo_meta', $crrnt_post_type, 'normal'); //Yoast SEO
		}
	}
	
	// 投稿編集画面 「All in one SEO」メタボックス非表示 //
	static public function hook_aioseop_add_post_metabox($metaboxes){
		$metaboxes = array();
		return $metaboxes;
	}
	
	// ユーザー編集画面「現在の状況にタクソノミーを追加」非表示 //
	static protected function remove_ps_taxonomy_expander_action(){
		global $ps_taxonomy_expander;
		if( is_object($ps_taxonomy_expander) ){
			$rmv_func = array($ps_taxonomy_expander, 'add_taxonomy_count_dashboard_right_now_field');
			remove_action('personal_options', $rmv_func);
		}
	}
}
// 呼び出し大元 //
add_action('admin_init', 'my_activate_admin_panel_per_user');
function my_activate_admin_panel_per_user(){
	MyAdminPanelPerUserRole::activate_actions();
}

/* = プラグイン関連
-------------------------------------------------------------- */
// カスタム投稿タイプにもパブリサイズ共有を対応
add_action('init', 'add_jetpack_custom_post_publicize');
function add_jetpack_custom_post_publicize(){
	add_post_type_support('blog', 'publicize');
}
// 管理者以外はjetpack非表示にする
add_action('jetpack_admin_menu', 'hide_jetpack');
function hide_jetpack() {
	if( !current_user_can('administrator') ){
		remove_menu_page('jetpack');
		remove_menu_page('edit-comments.php'); //追記
		remove_menu_page('wpcf7'); //追記
		remove_menu_page('tools.php'); //追記
		remove_menu_page('ps-taxonomy-expander.php'); //追記
	}
}

// WPCF7, ユーザーエージェント
add_filter('wpcf7_special_mail_tags', 'my_special_mail_tags', 10, 2);
function my_special_mail_tags($output, $name){
	$name_kinds = array(
		'_your_ua_device' => array('device'), 
		'_your_ua_os' => array('os'), 
		'_your_ua_browser' => array('browser'), 
	);
	if( isset($name_kinds[$name]) ){
		$output = my_make_user_agent_detail_str($name_kinds[$name]);
	}
	return $output;
}

function my_make_user_agent_detail_str($detail_keys=array()){
	$dtl_str = '';
	$agnt_details = my_get_user_agent_details();
	if( $detail_keys ){
		$agnt_details = array_intersect_key( $agnt_details, array_flip($detail_keys) );
	}
	if( !$agnt_details ) return $dtl_str;
	
	foreach( $agnt_details as $dtl_key => $dtl_arr ){
		$agnt_details[$dtl_key] = implode( ' ', array_filter($dtl_arr, 'strlen') );
	}
	return implode(' / ', $agnt_details);
}

function my_get_user_agent_details(){
	$agnt_details = array(
		'os' => array(
			'name' => 'その他', 
			'version' => '', 
		),
		'browser' => array(
			'name' => 'その他', 
			'version' => '', 
		),
		'device' => array(
			'name' => 'その他', 
		),
	);
	$agnt_candidates = array(
		'os' => array(
			'Windows NT 10.0'            => 'Windows 10', 
			'Windows NT 6.3'             => 'Windows 8.1', 
			'Windows NT 6.2'             => 'Windows 8', 
			'Windows NT 6.1'             => 'Windows 7', 
			'Windows NT 6.0'             => 'Windows Vista', 
			'Windows NT 5.2'             => 'Windows Server 2003 / Windows XP x64 Edition', 
			'Windows NT 5.1'             => 'Windows XP', 
			'Windows NT 5.0'             => 'Windows 2000', 
			'Windows NT 4.0'             => 'Microsoft Windows NT 4.0', 
			'Windows'                    => 'Windows', 
			'Mac OS X(?:.| ([0-9\._]+))' => 'Macintosh', 
			'Android ([a-z0-9\.]+)'      => 'Android', 
			'iPhone OS ([a-z0-9_]+)'     => 'iOS', 
			'Linux ([a-z0-9_]+)'         => 'Linux', 
		),
		'browser' => array(
			'(?:MSIE\s|Trident.*rv:)([0-9\.]+)'        => 'Internet Explorer', 
			'Edge'                                     => 'Microsoft Edge', 
			'Chrome\/([0-9\.]+)'                       => 'Chrome', 
			'([0-9\.]+\sMobile\/[A-Z0-9]{6})?\sSafari' => 'Safari', 
			'Firefox\/([0-9\.]+)'                      => 'Firefox', 
			'(?:^Opera|OPR).*\/([0-9\.]+)'             => 'Opera', 
			'Nintendo (3DS|WiiU)'                      => 'Nintendo',
			'PLAYSTATION (4|3|Vita)'                   => 'PLAYSTATION',
		),
		'device' => array(
			'iPhone'                   => 'iPhone', 
			'iPod'                     => 'iPod', 
			'iPad'                     => 'iPad', 
			'Android'                  => 'Android', 
			'Windows Phone'            => 'Windows Phone', 
			'(?:BlackBerry|BB)'        => 'BlackBerry', 
			'Nintendo 3DS'             => 'Nintendo 3DS', 
			'Nintendo Wii'             => 'Nintendo Wii', 
			'Nintendo WiiU'            => 'Nintendo WiiU', 
			'(?:PlayStation 2|PS2)'    => 'PlayStation 2', 
			'PlayStation 3'            => 'PlayStation 3', 
			'PlayStation 4'            => 'PlayStation 4', 
			'PlayStation Vita'         => 'PlayStation Vita', 
			'PlayStation Portable'     => 'PlayStation Portable', 
			'(?:Windows|Mac OS|Linux)' => 'PC',
		),
	);
	$ua_str = isset($_SERVER['HTTP_USER_AGENT']) ? (string)$_SERVER['HTTP_USER_AGENT'] : '';
	foreach( $agnt_details as $dtl_key => $dtl_arr ){
		$agnt_arr = isset($agnt_candidates[$dtl_key]) ? $agnt_candidates[$dtl_key] : array();
		if( !$agnt_arr ) continue;
		
		foreach( $agnt_arr as $ptn => $v ){
			if( !preg_match('/'.$ptn.'/i', $ua_str, $mt) ) continue;
			
			$dtl_arr['name'] = $v;
			if( isset($mt[1]) && isset($dtl_arr['version']) ){
				$dtl_arr['version'] = $mt[1]; //only 1st pattern match, ignore ge 2nd
			}
			break;
		}
		$agnt_details[$dtl_key] = $dtl_arr;
	}
	return $agnt_details;
}

/* = 調整関連
-------------------------------------------------------------- */
// 動画埋め込み等の際のデフォルトサイズ
add_filter('embed_defaults', 'custom_embed_size');
function custom_embed_size() {
	return array( 'width' => 660, 'height' => 371 );
}
// 画像挿入時の添付ファイルのページの選択肢を消す
add_action('post-upload-ui', 'media_script_buffer_start');
add_action('print_media_templates', 'media_script_buffer_get');
function media_script_buffer_start() {
	ob_start();
}
function media_script_buffer_get() {
	$scripts = ob_get_clean();
	$scripts = preg_replace( '#<option value="post">.*?</option>#s', '', $scripts );
	echo $scripts;
}