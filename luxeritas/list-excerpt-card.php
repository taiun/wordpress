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
get_template_part('meta');
?>
<figure class="term">
<?php
if( isset( $luxe['thumbnail_visible'] ) ) {
	$post_thumbnail = has_post_thumbnail();
	if( !empty( $post_thumbnail ) ) {	// サムネイル
		$thumb  = 'thumb100';
		$swidth = '100px';

		if( $luxe['thumbnail_is_size_card'] !== 'generate' ) {
			$thumb = $luxe['thumbnail_is_size_card'];

			// カード型のみ style で max-width 指定する (レスポンシブの崩れ防止)
			switch( $thumb ) {
				case 'thumb75':   $swidth = '75px';  break;
				case 'thumbnail': $swidth = '150px'; break;
				case 'medium':    $swidth = '300px'; break;
				default; break;
			}
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
			$swidth = $luxe['thumbnail_width'] . 'px';
		}
?>
<a href="<?php the_permalink() ?>"><?php the_post_thumbnail( $thumb, array( 'itemprop' => 'image', 'class' => 'thumbnail', 'style' => 'max-width:' . $swidth ) ); ?></a>
<?php
	}
	elseif( isset( $luxe['noimage_visible'] ) ) {
		$no_img_png = 'no-img-100x100.png';
		$no_img_wid = 100;
		$no_img_hgt = 100;

		switch( $luxe['thumbnail_is_size_card'] ) {
			case 'thumb75':
				$no_img_png = 'no-img-75x75.png';
				$no_img_wid = 75;
				$no_img_hgt = 75;
				break;
			case 'thumbnail':
				$no_img_png = 'no-img.png';
				$no_img_wid = 150;
				$no_img_hgt = 150;
				break;
			case 'medium':
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
<h2 class="entry-title" itemprop="headline name"><a href="<?php the_permalink(); ?>" class="entry-link" itemprop="url"><?php the_title(); ?></a></h2>
<?php
if( isset( $luxe['excerpt_length_card'] ) && (int)$luxe['excerpt_length_card'] > 0 ) {
?>
<div class="excerpt" itemprop="description"><div class="exsp">
<?php
	if( !isset( $luxe['break_excerpt_card'] ) ) {
		echo apply_filters( 'thk_excerpt', $luxe['excerpt_length_card'], '' );
	}
	else {
		echo apply_filters( 'thk_excerpt_no_break', $luxe['excerpt_length_card'], '' );
	}
?>
</div></div>
<?php
}
// 記事を読むリンク
if( !empty( $luxe['read_more_text_card'] ) ) {
	$length = isset( $luxe['short_title_length_card'] ) ? $luxe['short_title_length_card'] : 8;
?>
<p class="read-more"><a href="<?php the_permalink(); ?>" class="read-more-link" itemprop="url"><?php echo ( isset( $luxe['read_more_short_title_card'] ) ) ? read_more_title_add( $luxe['read_more_text_card'], $length ) : $luxe['read_more_text_card']; ?></a></p>
<?php
}
