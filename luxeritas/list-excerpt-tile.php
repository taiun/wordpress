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

unset( $luxe['meta_under'] );

if( $luxe['grid_tile_order'] !== 'ThumbTM' ) get_template_part('meta');
if( $luxe['grid_tile_order'] === 'MTThumb' ) {
?>
<h2 class="entry-title" itemprop="headline name"><a href="<?php the_permalink(); ?>" class="entry-link" itemprop="url"><?php the_title(); ?></a></h2>
<?php
}
?>
<figure class="term">
<?php
if( isset( $luxe['thumbnail_visible'] ) ) {
	$post_thumbnail = has_post_thumbnail();
	if( !empty( $post_thumbnail ) ) {	// サムネイル
		$thumb = 'thumb320';

		if( $luxe['thumbnail_is_size_tile'] !== 'generate' ) {
			$thumb = $luxe['thumbnail_is_size_tile'];
		}
		elseif( $luxe['thumbnail_width'] > 0 ) {
			switch( $luxe['thumbnail_width'] ) {
				case '150': $thumb = 'thumbnail'; break;
				case '300': $thumb = 'medium'; break;
				case '640': $thumb = 'large'; break;
				default:
					$thumb = 'thumb' . $luxe['thumbnail_width'] . 'x' . $luxe['thumbnail_height'];
					break;
			}
		}
?>
<a href="<?php the_permalink() ?>"><?php the_post_thumbnail( $thumb, array( 'itemprop' => 'image', 'class' => 'thumbnail' ) ); ?></a>
<?php
	}
	elseif( isset( $luxe['noimage_visible'] ) ) {
		$no_img_png = 'no-img-320x180.png';
		$no_img_wid = 320;
		$no_img_hgt = 180;

		switch( $luxe['thumbnail_is_size_tile'] ) {
			case 'thumbnail':
				$no_img_png = 'no-img.png';
				$no_img_wid = 150;
				$no_img_hgt = 150;
				break;
			case 'medium':
			case 'large':
			case 'full':
				$no_img_png = 'no-img-300x300.png';
				$no_img_wid = 300;
				$no_img_hgt = 300;
				break;
			case 'generate':
				if( $luxe['thumbnail_width'] >= 150 ) {
					$no_img_png = 'no-img-300x300.png';
					$no_img_wid = $luxe['thumbnail_width'];
					$no_img_hgt = $luxe['thumbnail_height'];
				}
				break;
			default:
				break;
		}
?>
<a href="<?php the_permalink() ?>"><img src="<?php echo TURI; ?>/images/<?php echo $no_img_png; ?>" itemprop="image" class="thumbnail" alt="No Image" title="No Image" width="<?php echo $no_img_wid; ?>" height="<?php echo $no_img_hgt; ?>" /></a>
<?php
	}
}
?>
</figure><!--/.term-->
<?php
if( $luxe['grid_tile_order'] !== 'MTThumb' ) {
?>
<h2 class="entry-title" itemprop="headline name"><a href="<?php the_permalink(); ?>" class="entry-link" itemprop="url"><?php the_title(); ?></a></h2>
<?php
}

if( $luxe['grid_tile_order'] === 'ThumbTM' ) get_template_part('meta');

if( isset( $luxe['excerpt_length_tile'] ) && (int)$luxe['excerpt_length_tile'] > 0 ) {
?>
<div class="excerpt" itemprop="description"><div class="exsp">
<?php
	if( !isset( $luxe['break_excerpt_tile'] ) ) {
		echo apply_filters( 'thk_excerpt', $luxe['excerpt_length_tile'], '' );
	}
	else {
		echo apply_filters( 'thk_excerpt_no_break', $luxe['excerpt_length_tile'], '' );
	}
?>
</div></div>
<?php
}
// 記事を読むリンク
if( !empty( $luxe['read_more_text_tile'] ) ) {
	$length = isset( $luxe['short_title_length_tile'] ) ? $luxe['short_title_length_tile'] : 8;
?>
<p class="read-more"><a href="<?php the_permalink(); ?>" class="read-more-link" itemprop="url"><?php echo ( isset( $luxe['read_more_short_title_tile'] ) ) ? read_more_title_add( $luxe['read_more_text_tile'], $length ) : $luxe['read_more_text_tile']; ?></a></p>
<?php
}
