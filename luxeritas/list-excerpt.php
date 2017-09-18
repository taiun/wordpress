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
?>
<figure class="term">
<?php
if( isset( $luxe['thumbnail_visible'] ) ) {
	$post_thumbnail = has_post_thumbnail();
	if( !empty( $post_thumbnail ) ) {	// サムネイル
		$thumb = 'thumbnail';

		if( $luxe['thumbnail_is_size'] !== 'generate' ) {
			$thumb = $luxe['thumbnail_is_size'];
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
		$no_img_png = 'no-img.png';
		$no_img_wid = 150;
		$no_img_hgt = 150;

		switch( $luxe['thumbnail_is_size'] ) {
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
$luxe['meta_under'] = true;
get_template_part('meta');
?>
<div class="excerpt" itemprop="description"><div class="exsp">
<?php
if( is_search() === true && isset( $luxe['search_extract'] ) && $luxe['search_extract'] === 'word' ) {
	echo thk_search_excerpt();
}
elseif( !isset( $luxe['break_excerpt'] ) ) {
	echo apply_filters( 'thk_excerpt', $luxe['excerpt_length'], '' );
}
else {
	echo apply_filters( 'thk_excerpt_no_break', $luxe['excerpt_length'], '' );
}
// 記事を読むリンク
?>
</div></div>
<p class="read-more"><?php
	if( !empty( $luxe['read_more_text'] ) ) {
		$length = isset( $luxe['short_title_length'] ) ? $luxe['short_title_length'] : 0;
?><a href="<?php the_permalink(); ?>" class="read-more-link" itemprop="url"><?php echo ( isset( $luxe['read_more_short_title'] ) ) ? read_more_title_add( $luxe['read_more_text'], $length ) : $luxe['read_more_text']; // 記事を読むリンク ?></a><?php
	}
?></p>
