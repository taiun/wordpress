<?php
/**
 * Luxeritas WordPress Theme - free/libre wordpress platform
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * @copyright Copyright (C) 2015 Thought is free.
 * @license http://www.gnu.org/licenses/gpl-2.0.html GPL v2 or later
 * @author LunaNuko
 * @link https://thk.kanzae.net/
 * @translators rakeem( http://rakeem.jp/ )
 */

global $luxe;
if( !isset( $content_width ) ) $content_width = 1280;	// これ無いとチェックで怒られる

?>
<!DOCTYPE html>
<html <?php echo isset( $luxe['amp'] ) ? 'amp ' : ''; language_attributes(); ?> itemscope itemtype="http://schema.org/WebPage">
<?php
if( isset( $luxe['facebook_ogp_enable'] ) && !isset( $luxe['amp'] ) ) {
?>
<head prefix="og: http://ogp.me/ns# article: http://ogp.me/ns/article# fb: http://ogp.me/ns/fb#">
<?php
}
else {
?>
<head>
<?php
}
?>
<meta charset="<?php bloginfo('charset'); ?>" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<?php
if( !isset( $luxe['amp'] ) ) {
?>
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=<?php echo $luxe['user_scalable']; ?>" />
<?php
}
else {
?>
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no, minimal-ui" />
<?php
	echo '<', 'title>', wp_get_document_title(), '</', 'title>', "\n";
}

$next_index = false;			// <!--!nextpage--> で分割してる場合の判別
$cpage = (int)get_query_var('cpage');	// コメントをページ分割してる場合の判別

// カスタマイズ画面で設定されている <!--nextpage--> の2ページ目以降のインデクス有無によって分岐
if( is_singular() === true && isset( $luxe['nextpage_index'] ) ) {
	if( stripos( $post->post_content, '<!--nextpage-->' ) !== 0 ) {
		$paged = get_query_var('page');
		if( empty( $paged ) ) $paged = 1;
		if( $paged > 1 ) $next_index = true;
	}
}

if(
	( is_archive() === true && is_category() === false ) ||
	is_search() === true	||
	is_tag()    === true	||
	is_paged()  === true	||
	is_404()    === true	||
	$next_index === true	||
	$cpage > 0		||
	is_page_template( 'pages/sitemap.php' ) === true
) {
?>
<meta name="robots" content="noindex,follow" />
<?php
}

echo apply_filters( 'thk_head', '' );	// load header

if( isset( $luxe['buffering_enable'] ) ) {
	if( ob_get_level() < 1 || ob_get_length() === false ) ob_start();
	if( ob_get_length() !== false ) {
	       	ob_flush();
	       	flush();
		ob_end_flush();
	}
}

if( is_customize_preview() === true ) {
	/* カスタマイズした Lazy Load のオプション (プレビュー用) */
	if( isset( $luxe['lazyload_enable'] ) ) {
		require_once( INC . 'crete-javascript.php' );
		$jscript = new create_Javascript();
		echo	'<script src="', TDEL, '/js/jquery.lazyload.min.js"></script>',
			'<script>', $jscript->create_lazy_load_script(), '</script>';
	}
}

if( !isset( $luxe['amp'] ) ) {
	// Lazy Load の noscript のスタイル挿入
	if( isset( $luxe['lazyload_enable'] ) ) {
?>
<noscript><style>img[data-lazy="1"]{display:none;}</style></noscript>
<?php
	}

	get_template_part('add-header'); // ユーザーヘッダー追加用

	// カスタムヘッダー
	if( is_singular() === true ) {
		$addhead = get_post_meta( $post->ID, 'addhead', true );
		if( !empty( $addhead ) ) echo $addhead, "\n";
	}
}
?>
</head>
<body <?php body_class(); ?>>
<?php
// bootstrap container Inner
if( $luxe['bootstrap_header'] !== 'out' ) {
?>
<div class="container">
<?php
}
?>
<div id="header" itemscope itemtype="https://schema.org/WPHeader">
<header<?php if( isset( $luxe['add_role_attribute'] ) ) echo ' role="banner"'; ?>>
<?php
// Global Navi Upper
if(
	( !isset( $luxe['global_navi_visible'] ) && isset( $luxe['head_band_visible'] ) ) ||
	( isset( $luxe['global_navi_visible'] ) && $luxe['global_navi_position'] === 'upper' )
) {
	get_template_part('navigation');
}

// Structured data of site information.
$site_name_type = '';
if( isset( $luxe['site_name_type'] ) ) {
	if( $luxe['site_name_type'] === 'Organization' ) {
		if( isset( $luxe['organization_type'] ) ) {
			$site_name_type = ' itemscope itemtype="http://schema.org/' . $luxe['organization_type'] . '"';
		}
	}
	else {
		$site_name_type = ' itemscope itemtype="http://schema.org/' . $luxe['site_name_type'] . '"';
	}
}
?>
<div id="head-in">
<div class="head-cover">
<div class="info"<?php echo $site_name_type; ?>>
<?php
$_is_front_page = is_front_page();

if( $_is_front_page === true ) {
	// フロントページは H1
?><h1 class="sitename"><a href="<?php echo THK_HOME_URL; ?>" itemprop="url"><?php
}
else {
?><p class="sitename"><a href="<?php echo THK_HOME_URL; ?>" itemprop="url"><?php
}

// One point logo Image
if( isset( $luxe['one_point_img'] ) ) {
	if( isset( $luxe['organization_logo'] ) && $luxe['organization_logo'] === 'onepoint' ) {
		echo thk_create_srcset_img_tag( $luxe['one_point_img'], '', 'onepoint', false, true );
	}
	else {
		echo thk_create_srcset_img_tag( $luxe['one_point_img'], '', 'onepoint', true, false );
	}
}

// Title Image
if( isset( $luxe['title_img'] ) ) {
	if( isset( $luxe['organization_logo'] ) && $luxe['organization_logo'] === 'titleimg' ) {
		echo thk_create_srcset_img_tag( $luxe['title_img'], THK_SITENAME, null, false, true );
	}
	else {
		echo thk_create_srcset_img_tag( $luxe['title_img'], THK_SITENAME, null, true, false );
	}
}
else {
	echo '<span itemprop="name'
	,    $luxe['site_name_type'] !== 'Organization' ? ' about' : ' brand'
	,    '">', THK_SITENAME, '</span>';
}
?></a><?php
if( $_is_front_page === true ) {
	// フロントページは H1 (閉じタグ)
?></h1>
<?php
}
else {
?></p>
<?php
}
if( isset( $luxe['title_img'] ) ) {
	echo '<meta itemprop="name'
	,    $luxe['site_name_type'] !== 'Organization' ? ' about' : ' brand'
	,    '" content="' . THK_SITENAME . '" />';
}

// Catchphrase
if( isset( $luxe['header_catchphrase_visible'] ) ) {
?>
<p class="desc" itemprop="<?php echo $luxe['site_name_type'] !== 'Organization' ? 'alternativeHeadline' : 'description'; ?>"><?php echo isset( $luxe['header_catchphrase_change'] ) ? $luxe['header_catchphrase_change'] : THK_DESCRIPTION; ?></p>
<?php
}
?>
</div><!--/.info-->
<?php
// Logo Image
if( isset( $luxe['logo_img_up'] ) && isset( $luxe['logo_img'] ) ) {
	?><div class="logo<?php if( isset( $luxe['logo_img_up'] ) ) echo '-up'; ?>"><?php echo thk_create_srcset_img_tag( $luxe['logo_img'] ); ?></div>
<?php
}
?>
</div><!--/.head-cover-->
<?php
// Global Navi Under
if( isset( $luxe['global_navi_visible'] ) && $luxe['global_navi_position'] === 'under' ) {
	get_template_part('navigation');
}
?>
</div><!--/#head-in-->
<?php
// Logo Image
if( !isset( $luxe['logo_img_up'] ) && isset( $luxe['logo_img'] ) ) {
	?><div class="logo<?php if( isset( $luxe['logo_img_up'] ) ) echo '-up'; ?>"><?php echo thk_create_srcset_img_tag( $luxe['logo_img'] ); ?></div>
<?php
}
?>
</header>
</div><!--/#header-->
<?php
// bootstrap container Outer
if( $luxe['bootstrap_header'] === 'out' ) {
?>
<div class="container">
<?php
}

if( $luxe['breadcrumb_view'] === 'outer' ) get_template_part( 'breadcrumb' );

if( function_exists('dynamic_sidebar') === true ) {
	if( isset( $luxe['amp'] ) && is_active_sidebar('head-under-amp') === true ) {
		$amp_widget = thk_amp_dynamic_sidebar( 'head-under-amp' );
		if( !empty( $amp_widget ) ) echo $amp_widget;
	}
	elseif( !isset( $luxe['amp'] ) && is_active_sidebar('head-under') === true ) {
		dynamic_sidebar( 'head-under' );
	}
}

if( isset( $luxe['buffering_enable'] ) ) {
	if( ob_get_level() < 1 || ob_get_length() === false ) ob_start();
	if( ob_get_length() !== false ) {
	       	ob_flush();
	       	flush();
		ob_end_flush();
	}
}

?>
<div id="primary" class="clearfix">
<?php
// 3 Column
if( $luxe['column_style'] === '3column' && !isset( $luxe['amp'] ) ) echo '<div id="field">', "\n";
?>
<div id="main">
<main<?php if( isset( $luxe['add_role_attribute'] ) ) echo ' role="main"'; ?>>
