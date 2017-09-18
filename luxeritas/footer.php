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

if( $luxe['bootstrap_footer'] !== 'in' ) {
?>
</div><!--/.container-->
<?php
}
?>
<div id="footer" itemscope itemtype="https://schema.org/WPFooter"<?php if( isset( $luxe['add_role_attribute'] ) ) echo ' role="contentinfo"'; ?>>
<footer>
<?php
if( !isset( $luxe['amp'] ) ) {
	$_is_footer_left = false;
	$_is_footer_right = false;
	$_is_footer_center = false;

	if( function_exists('dynamic_sidebar') === true ){
		$_is_footer_left = is_active_sidebar('footer-left');
		$_is_footer_right = is_active_sidebar('footer-right');
		$_is_footer_center = is_active_sidebar('footer-center');
	}
	if( $_is_footer_left === true || $_is_footer_right === true || $_is_footer_center === true ) {
?>
<div id="foot-in">
<?php
	// Footer Widget Area
	if( $luxe['foot_widget'] !== 0 ) {
		$fwl = 'col-4 col-xs-4';
		$fwc = 'col-4 col-xs-4';
		$fwr = 'col-4 col-xs-4';
		if( $luxe['foot_widget'] === 1 ) {
			$fwc = 'col-12 col-xs-12';
		}
		elseif( $luxe['foot_widget'] === 2 ) {
			$fwl = 'col-6 col-xs-6';
			$fwr = 'col-6 col-xs-6';
		}
?>
<aside class="row">
<?php
			if( $luxe['foot_widget'] !== 1 ) {
?><div class="<?php echo $fwl; ?>"><?php
				if( $_is_footer_left === true ) dynamic_sidebar( 'footer-left' );
?></div><?php
			}
			if( $luxe['foot_widget'] !== 2 ) {
?><div class="<?php echo $fwc; ?>"><?php
				if( $_is_footer_center === true ) dynamic_sidebar( 'footer-center' );
?></div><?php
			}
			if( $luxe['foot_widget'] !== 1 ) {
?><div class="<?php echo $fwr; ?>"><?php
				if( $_is_footer_right === true ) dynamic_sidebar( 'footer-right' );
?></div><?php
			}
?>
</aside>
<div class="clearfix"></div>
<?php
		}
?>
</div><!--/#foot-in-->
<?php
	}
}
?>
<div id="copyright">
<?php echo isset( $luxe['copyright'] ) ? $luxe['copyright'] : ''; ?>
<p id="thk" class="copy">WordPress Luxeritas Theme is provided by &quot;<a href="<?php echo THK_COPY; ?>" target="_blank" rel="nofollow">Thought is free</a>&quot;.</p>
</div><!--/#copy-->
</footer>
</div><!--/#footer-->
<?php
if( $luxe['bootstrap_footer'] === 'in' ) {
?>
</div><!--/#container-->
<?php
}
?>
<div id="wp-footer">
<?php
if( !isset( $luxe['amp'] ) ) {
?>
<div id="page-top"><i class="fa <?php echo str_replace( '_', '-', $luxe['page_top_icon'] ); ?>"></i><?php echo isset( $luxe['page_top_text'] ) ? '<span class="ptop"> ' . $luxe['page_top_text'] . '</span>' : ''; ?></div>
<?php
	if( $luxe['global_navi_mobile_type'] === 'luxury' ) {
?>
<aside>
<div id="sform">
<form method="get" class="search-form" action="<?php echo THK_HOME_URL; ?>"><input type="search" class="search-field" name="s" placeholder="Search for &hellip;" /><input type="submit" class="search-submit" value="Search" /></form>
</div>
</aside>
<?php
	}
	if( is_customize_preview() === true ) {
		if( isset( $luxe['jquery_load'] ) ) {
			require_once( INC . 'crete-javascript.php' );
			$jscript = new create_Javascript();
			$luxe['awesome_load'] = 'none';

			$files = array(
				'jquery.sticky-kit.min.js',
				'jquery.smoothScroll.min.js',
				'autosize.min.js',
			);
			foreach( $files as $val ) echo '<script src="', TDEL, '/js/', $val, '"></script>';

			echo	'<script>',
				$jscript->create_luxe_various_script( true ),
				$jscript->create_sns_count_script( true ),
				'</script>';
		}
	}
	// 投稿プレビュー画面で SNS のカウント数を全件 0 表示するスクリプト
	if( is_preview() === true || is_customize_preview() === true ) {
		if( isset( $luxe['jquery_load'] ) ) {
?>
<script src="<?php echo TDEL; ?>/js/preview-sns-count.js" defer></script>
<?php
		}
	}

	// 子 luxech.js もしくは luxech.min.js
	if( !isset( $luxe['child_script'] ) ) {
		if( $luxe['child_js_compress'] === 'none' ) {
			if( file_exists( SPATH . DSEP . 'luxech.js' ) ) {
		?>
<script src="<?php echo SDEL; ?>/luxech.js?v=<?php echo $_SERVER['REQUEST_TIME'] ?>" defer></script>
		<?php
			}
		}
		elseif( $luxe['child_js_compress'] === 'comp' ) {
			if( file_exists( SPATH . DSEP . 'luxech.min.js' ) && filesize( SPATH . DSEP . 'luxech.min.js' ) > 0 ) {
		?>
<script src="<?php echo SDEL; ?>/luxech.min.js?v=<?php echo $_SERVER['REQUEST_TIME'] ?>" defer></script>
		<?php
			}
		}
	}
}

get_template_part( 'analytics' ); 	// アクセス解析追加用

if( !isset( $luxe['amp'] ) ) {
	get_template_part( 'add-footer' ); // ユーザーフッター追加用
	wp_footer();

	/* html5shiv.min.js & respond.min.js */
	if( isset( $luxe['html5shiv_load_type'] ) || isset( $luxe['respondjs_load_type'] ) ) {
?>
<!--[if lt IE 9]>
<?php
	if( isset( $luxe['html5shiv_load_type'] ) ):
?>
<script src="<?php echo TDEL, '/js' ?>/html5shiv.min.js"></script>
<?php
	endif;
	if( isset( $luxe['respondjs_load_type'] ) ):
?>
<script src="<?php echo TDEL, '/js' ?>/respond.min.js"></script>
<?php
	endif;
?>
<![endif]-->
<?php
	}

	if( is_singular() === true || is_home() === true ) {
		if( $luxe['sns_tops_type'] === 'normal' || $luxe['sns_bottoms_type'] === 'normal' ) {
			// Facebook normal button
			if( isset( $luxe['facebook_share_tops_button'] ) || isset( $luxe['facebook_share_bottoms_button'] )  ) {
?>
<div id="fb-root"></div>
<script>(function(d, s, id) {
var js, fjs = d.getElementsByTagName(s)[0];
if (d.getElementById(id)) return;
js = d.createElement(s); js.id = id;
js.src = "//connect.facebook.net/ja_JP/sdk.js#xfbml=1&version=v2.9";
fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<?php
			}
			// LinkedIn normal button
			if( isset( $luxe['linkedin_share_tops_button'] ) || isset( $luxe['linkedin_share_bottoms_button'] ) ) {
?>
<script src="//platform.linkedin.com/in.js" type="text/javascript"></script>
<?php
			}
		}
	}
}

/* ブログカードのキャッシュ作成（最初の一回だけ） */
if( !isset( $luxe['amp'] ) && isset( $luxe['bc_url'] ) && isset( $luxe['bc_md5'] ) && isset( $luxe['bc_lnk'] ) ) {
	$blogcard = new THK_Blogcard();

	$wp_upload_dir = wp_upload_dir();
	$cache_dir = $wp_upload_dir['basedir'] . DSEP . 'luxe-blogcard' . DSEP;
	foreach( $luxe['bc_url'] as $i => $val ) {
		$url_md5 = $luxe['bc_md5'][$i];
		$cache_file = $cache_dir . $url_md5[0] . DSEP . $url_md5;
		if( ob_get_level() < 1 || ob_get_length() === false ) ob_start();
		if( ob_get_length() !== false ) {
		       	ob_flush();
		       	flush();
			ob_end_flush();
		}
		do_action( 'thk_create_blogcard', $val, $url_md5 );
		$caches = $blogcard->thk_get_blogcard_cache( $cache_file, $luxe['bc_lnk'][$i], $url_md5 );
		if( isset( $caches[1] ) ) {
?>
<script>
var html_<?php echo $url_md5; ?> = '<?php echo $caches[1]; ?>';
document.getElementById('bc_<?php echo $url_md5; ?>').innerHTML=html_<?php echo $url_md5; ?>;
</script>
<?php
		}
		unset( $luxe['bc_url'][$i] );
	}
}

/* WordPress の管理バーが見えてる場合のヘッダー上部の帯メニュー位置調整用スクリプト */
if( is_admin_bar_showing() === true ) {
?>
<script src="<?php echo TDEL . '/js/wp-adminbar-position.js'; ?>" defer></script>
<?php
}
?>
</div><!--/#wp-footer-->
</body>
</html>
