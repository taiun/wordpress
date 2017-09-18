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

// HEAD BAND MENU
$band_type = '';
if( !isset( $luxe['head_band_wide'] ) && $luxe['bootstrap_header'] === 'in' ) {
	$band_type = '-in';
}

?>
<div class="band">
<div id="head-band<?php echo $band_type; ?>">
<div class="band-menu">
<?php
// Search Box
if( isset( $luxe['head_band_search'] ) && !isset( $luxe['amp'] ) ) {
?>
<div id="head-search">
<form method="get" class="head-search-form" action="<?php echo THK_HOME_URL; ?>"<?php if( isset( $luxe['add_role_attribute'] ) ) echo ' role="search"'; ?>>
<input type="text" class="head-search-field" placeholder="Search &hellip;" value="<?php echo get_search_query() ?>" name="s" title="<?php echo esc_attr( __( 'Search for', 'luxeritas' ) ); ?>" />
<button type="submit" class="head-search-submit" value="<?php echo esc_attr( __( 'Search', 'luxeritas' ) ); ?>"></button>
</form>
</div>
<?php
}
// User Custom Menu
$wp_nav_menu = wp_nav_menu( array ( 'theme_location' => 'head-band', 'echo' => false, 'container' => false, 'fallback_cb' => false, 'items_wrap' => '<ul>%3$s' ) );
echo empty( $wp_nav_menu ) ? '<ul>' : str_replace( ' href', ' itemprop="url" href', str_replace( '<li', '<li itemprop="name"', $wp_nav_menu ) );

// SNS Follow Button
?>
<?php
	if( isset( $luxe['head_band_twitter'] ) ) {
		$follow_twitter_id = isset( $luxe['follow_twitter_id'] ) ? rawurlencode( rawurldecode( $luxe['follow_twitter_id'] ) ) : '';
?><li><span class="snsf twitter"><a href="//twitter.com/<?php echo $follow_twitter_id; ?>" target="_blank" title="Twitter" rel="nofollow" itemprop="sameAs url">&nbsp;<i class="fa fa-twitter"></i>&nbsp;<?php if( $luxe['head_band_follow_icon'] === 'icon_name' ) echo '<span class="fname">Twitter</span>&nbsp;'; ?></a></span></li>
<?php
	}
	if( isset( $luxe['head_band_facebook'] ) ) {
		$follow_facebook_id = isset( $luxe['follow_facebook_id'] ) ? rawurlencode( rawurldecode( $luxe['follow_facebook_id'] ) ) : '';
?><li><span class="snsf facebook"><a href="//www.facebook.com/<?php echo $follow_facebook_id; ?>" target="_blank" title="Facebook" rel="nofollow" itemprop="sameAs url">&nbsp;<i class="fa fa-facebook"></i>&nbsp;<?php if( $luxe['head_band_follow_icon'] === 'icon_name' ) echo '<span class="fname">Facebook</span>&nbsp;'; ?></a></span></li>
<?php
	}
	if( isset( $luxe['head_band_hatena'] ) ) {
		$follow_hatena_id = isset( $luxe['follow_hatena_id'] ) ? rawurlencode( rawurldecode( $luxe['follow_hatena_id'] ) ) : '';
?><li><span class="snsf hatena"><a href="//b.hatena.ne.jp/<?php echo $follow_hatena_id; ?>" target="_blank" title="<?php echo __( 'Hatena Bookmark', 'luxeritas' ); ?>" rel="nofollow" itemprop="sameAs url">&nbsp;B!&nbsp;<?php if( $luxe['head_band_follow_icon'] === 'icon_name' ) echo '<span class="fname">Hatena</span>&nbsp;'; ?></a></span></li>
<?php
	}
	if( isset( $luxe['head_band_google'] ) ) {
		$follow_google_id = isset( $luxe['follow_google_id'] ) ? rawurlencode( rawurldecode( $luxe['follow_google_id'] ) ) : '';
?><li><span class="snsf google"><a href="//plus.google.com/<?php echo $follow_google_id; ?>" target="_blank" title="Google+" rel="nofollow" itemprop="sameAs url">&nbsp;<i class="fa fa-google-plus"></i>&nbsp;<?php if( $luxe['head_band_follow_icon'] === 'icon_name' ) echo '<span class="fname">Google+</span>&nbsp;'; ?></a></span></li>
<?php
	}
	if( isset( $luxe['head_band_youtube'] ) ) {
		$follow_youtube_id = '';
		$youtube_type = 'channel/';
		if( isset( $luxe['follow_youtube_channel_id'] ) ) {
			$follow_youtube_id = rawurlencode( rawurldecode( $luxe['follow_youtube_channel_id'] ) );
		}
		elseif( isset( $luxe['follow_youtube_id'] ) ) {
			$follow_youtube_id = rawurlencode( rawurldecode( $luxe['follow_youtube_id'] ) );
			$youtube_type = 'user/';
		}
?><li><span class="snsf youtube"><a href="//www.youtube.com/<?php echo $youtube_type, $follow_youtube_id; ?>" target="_blank" title="YouTube" rel="nofollow" itemprop="sameAs url">&nbsp;<i class="fa fa-youtube"></i>&nbsp;<?php if( $luxe['head_band_follow_icon'] === 'icon_name' ) echo '<span class="fname">YouTube</span>&nbsp;'; ?></a></span></li>
<?php
	}
	if( isset( $luxe['head_band_line'] ) ) {
		$follow_line_id = isset( $luxe['follow_line_id'] ) ? rawurlencode( rawurldecode( $luxe['follow_line_id'] ) ) : '';
?><li><span class="snsf line"><a href="//line.naver.jp/ti/p/<?php echo $follow_line_id; ?>" target="_blank" title="LINE" rel="nofollow" itemprop="sameAs url">&nbsp;<i class="fa ico-line"></i>&nbsp;<?php if( $luxe['head_band_follow_icon'] === 'icon_name' ) echo '<span class="fname">LINE</span>&nbsp;'; ?></a></span></li>
<?php
	}
	if( isset( $luxe['head_band_rss'] ) ) {
?><li><span class="snsf rss"><a href="<?php echo get_bloginfo('rss2_url'); ?>" target="_blank" title="RSS" rel="nofollow" itemprop="sameAs url">&nbsp;<i class="fa fa-rss"></i>&nbsp;<?php if( $luxe['head_band_follow_icon'] === 'icon_name' ) echo '<span class="fname">RSS</span>&nbsp;'; ?></a></span></li>
<?php
	}
	if( isset( $luxe['head_band_feedly'] ) ) {
?><li><span class="snsf feedly"><a href="//feedly.com/index.html#subscription/feed/<?php echo rawurlencode( get_bloginfo('rss2_url') ); ?>" target="_blank" title="Feedly" rel="nofollow" itemprop="sameAs url">&nbsp;<i class="ico-feedly"></i>&nbsp;<?php if( $luxe['head_band_follow_icon'] === 'icon_name' ) echo '<span class="fname">Feedly</span>&nbsp;'; ?></a></span></li>
<?php
	}
?></ul>
</div>
</div><!--/#head-band-->
</div><!--/.band-->
