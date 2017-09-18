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
get_header();

?>
<article>
<div id="core" class="grid">
<?php
if( $luxe['breadcrumb_view'] === 'inner' ) get_template_part( 'breadcrumb' );
?>
<div itemprop="mainEntityOfPage" id="post-<?php the_ID(); ?>" <?php post_class('post'); ?>>
<?php
if( function_exists('dynamic_sidebar') === true ) {
	if( isset( $luxe['amp'] ) ) {
		if( is_active_sidebar('post-title-upper-amp') === true ) {
			$amp_widget = thk_amp_dynamic_sidebar( 'post-title-upper-amp' );
			if( !empty( $amp_widget ) ) echo $amp_widget;
		}
	}
	else {
		if( is_active_sidebar('post-title-upper') === true ) {
			dynamic_sidebar( 'post-title-upper' );
		}
	}
}

if( have_posts() === true ) {
	while( have_posts() === true ) {
		the_post();
?>
<h1 class="entry-title" itemprop="headline name"><?php the_title(); //タイトル ?></h1>
<div class="clearfix">
<?php
		get_template_part('meta');
		if( isset( $luxe['sns_tops_enable'] ) ) {
			// SNS 記事上
			$luxe['sns_layout'] = 'tops';
			if( isset( $luxe['amp'] ) ) {
				ob_start();
				get_template_part( 'sns' );
				$sns_top = ob_get_clean();
				echo thk_amp_not_allowed_tag_replace( $sns_top );
			}
			else {
				get_template_part( 'sns' );
			}
		}

		if( function_exists('dynamic_sidebar') === true ) {
			if( isset( $luxe['amp'] ) ) {
				if( is_active_sidebar('post-title-under-amp') === true ) {
					$amp_widget = thk_amp_dynamic_sidebar( 'post-title-under-amp' );
					if( !empty( $amp_widget ) ) echo $amp_widget;
				}
			}
			else {
				if( is_active_sidebar('post-title-under') === true ) {
					dynamic_sidebar( 'post-title-under' );
				}
			}
		}

		//the_content();
		echo apply_filters( 'thk_content', '' ); // 本文

		if( function_exists('dynamic_sidebar') === true ) {
			if( isset( $luxe['amp'] ) ) {
				if( is_active_sidebar('post-under-1-amp') === true ) {
					$amp_widget = thk_amp_dynamic_sidebar( 'post-under-1-amp' );
					if( !empty( $amp_widget ) ) echo $amp_widget;
				}
			}
			else {
				if( is_active_sidebar('post-under-1') === true ) {
					dynamic_sidebar( 'post-under-1' );
				}
			}
		}
?>
</div>
<?php
		echo apply_filters( 'thk_link_pages', '' );
?>
<div class="meta-box">
<?php
		$luxe['meta_under'] = true;
		get_template_part('meta');

		$author = get_the_author();

		if( isset( $luxe['author_visible'] ) && !empty( $author ) ) {
			if( $luxe['author_page_type'] === 'auth' ) {
?>
<p class="vcard author"><i class="fa fa-pencil"></i><?php echo __( 'Posted by', 'luxeritas' ); ?> <span class="fn" itemprop="editor author creator copyrightHolder"><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php echo $author; ?></a></span><?php
			}
			else {
?>
<p class="vcard author"><i class="fa fa-pencil"></i><?php echo __( 'Posted by', 'luxeritas' ); ?> <span class="fn" itemprop="editor author creator copyrightHolder"><a href="<?php echo isset( $luxe['thk_author_url'] ) ? $luxe['thk_author_url'] : THK_HOME_URL; ?>"><?php echo $author; ?></a></span><?php
			}
			if( current_user_can( 'edit_posts' ) === true && is_customize_preview() === false ) {
				echo ' [ <i class="fa fa fa-file-text"></i>';
				edit_post_link( __( 'Edit This', 'luxeritas' ) );
				if( isset( $luxe['amp_enable'] ) ) {
					$amp_permalink = thk_get_amp_permalink( get_queried_object_id() );
					if( isset( $luxe['amp'] ) ) {
						echo	' &#x26A1; <a href="', wp_get_canonical_url(), '">Origin</a>'
						,	' &#x26A1; <a href="https://validator.ampproject.org/#url=', $amp_permalink, '" target="_blank">Validate</a>'
						,	' &#x26A1; <a href="https://cdn.ampproject.org/c/', ( stripos( $amp_permalink, 'https:' ) !== false ) ? 's/' : '', str_replace( array( 'http://', 'https://'), '', $amp_permalink ), '" target="_blank">Cache</a>';
					}
					else {
						echo	' &#x26A1; <a href="', $amp_permalink, '#development=1">AMP</a>';
					}
				}
				echo ' ]';
			}
		}
?></p>
</div><!--/.meta-box-->
<?php
		if( isset( $luxe['sns_bottoms_enable'] ) || ( function_exists('dynamic_sidebar') === true && is_active_sidebar('post-under-1') === true ) ) {
			echo '<hr />';
		}
?>
</div><!--/.post-->
<aside>
<?php
		if( function_exists('dynamic_sidebar') === true ) {
			if( isset( $luxe['amp'] ) ) {
				if( is_active_sidebar('post-under-2-amp') === true ) {
					$amp_widget = thk_amp_dynamic_sidebar( 'post-under-2-amp' );
					if( !empty( $amp_widget ) ) echo $amp_widget;
				}
			}
			else {
				if( is_active_sidebar('post-under-2') === true ) {
					dynamic_sidebar( 'post-under-2' );
				}
			}
		}

		if( isset( $luxe['sns_bottoms_enable'] ) ) {
			if( isset( $luxe['sns_bottoms_msg'] ) ) {
?>
<div class="sns-msg" ><h2><?php echo $luxe['sns_bottoms_msg']; ?></h2></div>
<?php
			}
			// SNS 記事下
			$luxe['sns_layout'] = null;
			if( isset( $luxe['amp'] ) ) {
				ob_start();
				get_template_part( 'sns' );
				$sns_bottom = ob_get_clean();
				echo thk_amp_not_allowed_tag_replace( $sns_bottom );
			}
			else {
				get_template_part( 'sns' );
			}
		}
	}
}
else {
?>
<p><?php echo __( 'No posts yet', 'luxeritas' ); ?></p>
<?php
}
?>
</aside>
</div><!--/#core-->
<aside>
<?php
if( isset( $luxe['next_prev_nav_visible'] ) ) {
?>
<div id="pnavi" class="grid">
<?php 
	//$next_post = get_next_post();
	$next_post = get_adjacent_post( false, '', false );
	if( $next_post ) {
		$next_thumb = get_the_post_thumbnail($next_post->ID, 'thumb100');
		if( empty( $next_thumb ) ) $next_thumb = '<div class="no-img-next"><i class="fa fa fa-file-text"></i></div>';
?>
<div class="next"><?php next_post_link( '%link', $next_thumb . '<div class="ntitle">' . $next_post->post_title . '</div><div class="next-arrow"><i class="fa fa-arrow-right pull-right"></i>' . __( 'Next', 'luxeritas' ) . '</div>' ); ?></div>
<?php
	}
	else {
?>
<div class="next"><a href="<?php echo THK_HOME_URL; ?>"><i class="fa fa-home navi-home"></i><div class="next-arrow"><i class="fa fa-arrow-right pull-right"></i><?php echo __( 'Home ', 'luxeritas' ); ?></div></a></div>
<?php
	}
	//$prev_post = get_previous_post();
	$prev_post = get_adjacent_post( false, '', true );
	if( $prev_post ) {
		$prev_thumb = get_the_post_thumbnail($prev_post->ID, 'thumb100');
		if( empty( $prev_thumb ) ) $prev_thumb = '<div class="no-img-prev"><i class="fa fa fa-file-text fa-rotate-180"></i></div>';
?>
<div class="prev"><?php previous_post_link( '%link', $prev_thumb . '<div class="ptitle">' . $prev_post->post_title . '</div><div class="prev-arrow"><i class="fa fa-arrow-left pull-left"></i>' . __( 'Prev', 'luxeritas' ) . '</div>' ); ?></div>
<?php
	}
	else {
?>
<div class="prev"><a href="<?php echo THK_HOME_URL; ?>"><i class="fa fa-home navi-home"></i><div class="prev-arrow"><i class="fa fa-arrow-left pull-right"></i><?php echo __( 'Home ', 'luxeritas' ); ?></div></a></div>
<?php
	}
?>
</div><!--/.pnavi-->
<?php
}

// 関連記事
$_is_active_related_upper = false;
$_is_active_related_under = false;

if( isset( $luxe['amp'] ) ) {
	$_is_active_related_upper = is_active_sidebar('related-upper');
	$_is_active_related_under = is_active_sidebar('related-under');
}
else {
	$_is_active_related_upper = is_active_sidebar('related-upper-amp');
	$_is_active_related_under = is_active_sidebar('related-under-amp');
}

if( isset( $luxe['related_visible'] ) || $_is_active_related_upper === true || $_is_active_related_under === true ) {
?>
<div id="related-box" class="grid">
<?php
	// 関連記事上ウィジェット
	if( function_exists('dynamic_sidebar') === true && $_is_active_related_upper === true ) {
		if( isset( $luxe['amp'] ) ) {
			$amp_widget = thk_amp_dynamic_sidebar( 'related-upper-amp' );
			if( !empty( $amp_widget ) ) echo $amp_widget;
		}
		else {
			dynamic_sidebar( 'related-upper' );
		}
	}

	if( isset( $luxe['related_visible'] ) ) {
?>
<h2 class="related"><i class="fa fa-th-list"></i><?php echo __( 'Related Posts', 'luxeritas' ); ?></h2>
<?php
		if( isset( $luxe['amp'] ) ) {
			ob_start();
			get_template_part( 'related' );
			$sns_bottom = ob_get_clean();
			echo thk_amp_not_allowed_tag_replace( $sns_bottom );
		}
		else {
			get_template_part( 'related' );
		}
	}

	// 関連記事下ウィジェット
	if( function_exists('dynamic_sidebar') === true && $_is_active_related_under === true ) {
		if( isset( $luxe['amp'] ) ) {
			$amp_widget = thk_amp_dynamic_sidebar( 'related-under-amp' );
			if( !empty( $amp_widget ) ) echo $amp_widget;
		}
		else {
			dynamic_sidebar( 'related-under' );
		}
	}
?>
</div><!--/#related-box-->
<?php
}

// コメント欄
if( isset( $luxe['comment_visible'] ) ) {
	if( comments_open() === true || get_comments_number() > 0 ){
		echo apply_filters('thk_comments', '');
	}
}

// トラックバックURL
if( isset( $luxe['trackback_visible'] ) && pings_open() === true ) {
?>
<div id="trackback" class="grid">
<h3 class="tb"><i class="fa fa-reply-all"></i><?php echo __( 'TrackBack URL', 'luxeritas' ); ?></h3>
<input type="text" name="trackback_url" size="60" value="<?php trackback_url() ?>" readonly="readonly" class="trackback-url" tabindex="0" accesskey="t" />
</div>
<?php
}
?>
</aside>
</article>
</main>
</div><!--/#main-->
<?php thk_call_sidebar(); ?>
</div><!--/#primary-->
<?php echo apply_filters( 'thk_footer', '' ); ?>
