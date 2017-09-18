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

// WordPress の例の定数を使うとチェックで怒られるので再定義
define( 'TPATH', get_template_directory() );
define( 'SPATH', get_stylesheet_directory() );
define( 'THEME', get_option( 'stylesheet' ) );
define( 'DSEP' , DIRECTORY_SEPARATOR );
define( 'INC'  , TPATH . DSEP . 'inc' . DSEP );

/*---------------------------------------------------------------------------
 * luxe Theme only works in PHP 5.3 or later.
 * luxe Theme only works in WordPress 4.4 or later.
 *---------------------------------------------------------------------------*/
if(
	version_compare( PHP_VERSION, '5.3', '<' ) === true ||
	version_compare( $GLOBALS['wp_version'], '4.4-alpha', '<' ) === true
) {
	require( INC . 'back-compat.php' );
	switch_theme( 'default' );
}

/*---------------------------------------------------------------------------
 * global
 *---------------------------------------------------------------------------*/
$luxe = get_option( 'theme_mods_' . THEME );
$fchk = false;

// textdomain
if( is_admin() === true && current_user_can( 'edit_posts' ) === true ) {
	load_theme_textdomain( 'luxeritas', TPATH . DSEP . 'languages' . DSEP . 'admin' );
}
else {
	load_theme_textdomain( 'luxeritas', TPATH . DSEP . 'languages' . DSEP . 'site' );
}

require( INC . 'wpfunc.php' );
require( INC . 'widget.php' );
require( INC . 'stinger.php' );
require( INC . 'sns-cache.php' );

if( is_customize_preview() === true ) {
	$fchk = true;
	require( INC . 'custom.php' );
	require( INC . 'custom-css.php' );
	require( INC . 'compress.php' );
}
elseif( is_admin() === true ) {
	if( current_user_can( 'edit_theme_options' ) === true ) {
		$fchk = true;
		require( INC . 'admin-func.php' );
	}
	if( current_user_can( 'edit_posts' ) === true ) {
		require( INC . 'og-img-admin.php' );
		require( INC . 'post-update-level.php');
		require( INC . 'post-amp.php' );
		add_editor_style( array( 'css/bootstrap.min.css', 'editor-style.css' ) );
	}
}

if( is_admin() === false && isset( $luxe['amp_enable'] ) ) {
	$rules = get_option( 'rewrite_rules' );
	if( !isset( $rules['^amp/?'] ) ) {
		require( INC . 'rewrite-rules.php' );
		add_action( 'init', 'thk_add_endpoint', 11 );
	}
	unset( $rules );
}
if( isset( $luxe['amp_enable'] ) ) {
	thk_amp_mu_plugin_copy();
}

/*---------------------------------------------------------------------------
 * initialization
 *---------------------------------------------------------------------------*/
add_action( 'init', function() use( $luxe ) {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'editor-style' );
	add_theme_support( 'html5', array( 'caption', 'gallery', 'search-form' ) );
	register_nav_menus( array('global-nav' => __( 'Header Nav (Global Nav)', 'luxeritas' ) ) );
	register_nav_menus( array('head-band' => __( 'Header Band Menu', 'luxeritas' ) ) );

	// get sns count
	if( stripos( $_SERVER['REQUEST_URI'], 'wp-admin/admin-ajax.php' ) !== false ) {
		if( is_preview() === false && is_customize_preview() === false ) {
			if( isset( $luxe['sns_tops_count'] ) || isset( $luxe['sns_bottoms_count'] ) ) {
				add_action( 'wp_ajax_thk_sns_real', 'thk_sns_real' );
				add_action( 'wp_ajax_nopriv_thk_sns_real', 'thk_sns_real' );
			}
		}
	}

	// set amp endpoint
	if( is_admin() === false && isset( $luxe['amp_enable'] ) ) {
		$q_amp = stripos( $_SERVER['QUERY_STRING'], 'amp=1' );
		if( $q_amp !== false ) {
			if( $q_amp > 0 ) {
				add_rewrite_endpoint( 'amp', EP_PERMALINK | EP_PAGES );
			}
		}
		else {
			add_rewrite_endpoint( 'amp', EP_PERMALINK | EP_PAGES );
		}

		add_filter( 'request', function( $vars ) {
			if( isset( $vars['amp'] ) && ( $vars['amp'] === '' ) ) {
				$vars['amp'] = 1;
			}
			return $vars;
		});
	}
}, 10 );

/*---------------------------------------------------------------------------
 * pre get posts
 *---------------------------------------------------------------------------*/
add_action( 'pre_get_posts', function( $q ) {
	if( is_search() === true ) {
		get_template_part( 'inc/search-func' );
		thk_search_extend();
	}

	// グリッドの通常表示部分は１ページに表示する件数に含めないようにする
	$mods = get_theme_mods();

	if(
		( isset( $mods['grid_home'] ) && $mods['grid_home'] === 'none' ) ||
		( isset( $mods['grid_archive'] ) && $mods['grid_archive'] === 'none' ) ||
		( isset( $mods['grid_category'] ) && $mods['grid_category'] === 'none' )
	) {
		return;
	}

	$query = $q->query;
	if( empty( $query['posts_per_page'] ) && empty( $query['offset'] ) ) {
		$grid_first = 0;

		if( $q->is_home === true && isset( $mods['grid_home_first'] ) ) {
			$grid_first = $mods['grid_home_first'];
		}
		elseif( $q->is_category === true && isset( $mods['grid_category_first'] ) ) {
			$grid_first = $mods['grid_category_first'];
		}
		elseif( $q->is_archive === true && isset( $mods['grid_archive_first'] ) ) {
			$grid_first = $mods['grid_archive_first'];
		}
		unset( $mods );

		if( $grid_first <= 0 ) return;

		$per2 = get_option( 'posts_per_page' );
		$per1 = $per2 + $grid_first;

		$paged = get_query_var( 'paged' ) ? (int)get_query_var( 'paged' ) : 1;
		if( $paged >= 2 ){
			$q->set( 'offset', $per1 + ( $paged - 2 ) * $per2 );
			$q->set( 'posts_per_page', $per2 );
		}
		else {
			$q->set( 'posts_per_page', $per1 );
		}
	}
});

/*---------------------------------------------------------------------------
 * pre comment on post
 *---------------------------------------------------------------------------*/
add_action( 'pre_comment_on_post', function() use( $luxe ) {
	if( isset( $luxe['captcha_enable'] ) ) {
		if( $luxe['captcha_enable'] === 'recaptcha' ) {
			if( isset( $_POST['g-recaptcha-response'] ) ) {
				$verify = 'https://www.google.com/recaptcha/api/siteverify?secret=' . $luxe['recaptcha_secret_key'] . '&response=' . $_POST['g-recaptcha-response'];
				$json = (object)array( 'success' => false );

				$ret = thk_remote_request( $verify );

				if( $ret !== false && is_array( $ret ) === false ) {
					$json = @json_decode( $ret );
				}

				if( $json->success !== true ) {
					wp_die( __( 'Authentication is not valid.', 'luxeritas' ), '', array( 'response' => 418, 'back_link' => true ) );
				}
		        }
		}
		elseif( $luxe['captcha_enable'] === 'securimage' ) {
			if( !isset( $_SESSION ) ) session_start();

			if( isset( $_POST['captcha_code'] ) && empty( $_POST['captcha_code'] ) ) {
				wp_die( __( 'Please enter image authentication.', 'luxeritas' ), '', array( 'response' => 418, 'back_link' => true ) );
		        }
			elseif( isset( $_POST['captcha_code'] ) &&
				isset( $_SESSION['securimage_code_disp']['default'] ) &&
				$_POST['captcha_code'] !== $_SESSION['securimage_code_disp']['default']
			) {
				wp_die( __( 'Image authentication is incorrect.', 'luxeritas' ), '', array( 'response' => 418, 'back_link' => true ) );
		        }
		}
	}
	return;
});

/*---------------------------------------------------------------------------
 * wp
 *---------------------------------------------------------------------------*/
add_action( 'wp', function() {
	global $luxe;

	if( is_admin() === false ) require_once( INC . 'const.php' );
	if( is_singular() === true ) wp_enqueue_script( 'comment-reply' );

	if( isset( $luxe['sns_count_cache_enable'] ) && is_preview() === false && is_customize_preview() === false ) {
		if(
			( is_singular() === true &&
				( isset( $luxe['sns_count_cache_force'] ) || (
				( isset( $luxe['sns_tops_enable'] ) && isset( $luxe['sns_tops_count'] ) ) ||
				( isset( $luxe['sns_bottoms_enable'] ) && isset( $luxe['sns_bottoms_count'] ) ) ) ) ) ||
			( is_home() === true &&
				( isset( $luxe['sns_count_cache_force'] ) || (
				( isset( $luxe['sns_toppage_view'] ) && isset( $luxe['sns_bottoms_count'] ) ) ) ) )
		) {
			add_filter( 'template_redirect', 'touch_sns_count_cache', 10 );
			add_filter( 'shutdown', 'set_transient_sns_count_cache', 90 );
			add_filter( 'shutdown', 'set_transient_sns_count_cache_weekly_cleanup', 95 );
			if(
				isset( $luxe['sns_count_cache_force'] ) ||
				isset( $luxe['feedly_share_tops_button'] ) || isset( $luxe['feedly_share_bottoms_button'] )
			) {
				add_filter( 'template_redirect', 'touch_feedly_cache', 10 );
				add_filter( 'shutdown', 'transient_register_feedly_cache', 90 );
			}
		}
	}

	if( isset( $luxe['amp'] ) ) {
		// AMP for front_page
		$url = '//' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		$uri = trim( str_replace( pdel( THK_HOME_URL ), '',  $url ), '/' );
		if( $uri === 'amp' ) {
			set_fake_root_endpoint_for_amp();
		}
	}
});

/*---------------------------------------------------------------------------
 * template redirect
 *---------------------------------------------------------------------------*/
add_action( 'template_redirect', function() {
	if( is_feed() === true ) return;

	global $luxe;
	if( isset( $luxe['amp'] ) ) {
		$page_on_front = wp_cache_get( 'page_on_front', 'luxe' );
		if( $page_on_front !== false ) {
			remove_fake_root_endpoint_for_amp( $page_on_front );
		}
	}

	if(
		is_home()	=== true ||
		is_singular()	=== true ||
		is_archive()	=== true ||
		is_search()	=== true ||
		is_404()	=== true
	) {
		require( INC . 'filters.php' );
		require( INC . 'load-styles.php' );
		require( INC . 'description.php' );
		require( INC . 'load-header.php' );
		if( isset( $luxe['blogcard_enable'] ) && is_singular() === true ) {
			require( INC . 'blogcard-func.php' );
		}
		if( isset( $luxe['amp'] ) ) {
			require( INC . 'amp-extensions.php' );
		}
	}
}, 99 );
