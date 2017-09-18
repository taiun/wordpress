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

if( function_exists('thk_swiper') === false ):
function thk_swiper( $args, $title, $item_types, $ids = null, $item_max, $show_max, $thumb = 'medium', $height = 'auto', $heightpx = 0, $width = 'auto', $slide_bg = 'transparent', $navigation, $next_prev, $nav_color, $titleview = null, $efect = 'none', $darkness = null, $center = 'post', $autoplay = 0, $coverflow = 'slide' ) {
	$cargs = array();

	if( $item_types === 'cat_list' && ( is_single() === true || is_category() === true ) ) {
		$cat = null;
		if( is_category() === false ) {
			$category = get_the_category();
			if( empty( $category ) ) return;
			$cat = $category[0]->cat_ID;
		}
		else {
			$cat = get_queried_object_id();
		}
		$cargs = array( 'posts_per_page' => $item_max, 'post_status' => 'publish', 'cat' => $cat );
	}
	elseif( $item_types === 'tag_list' && ( is_single() === true || is_tag() === true ) ) {
		$tag_id = null;
		if( is_tag() === false ) {
			$tags = get_tags();
			if( empty( $tags ) ) return;
			$tag_id = $tags[0]->term_taxonomy_id;
		}
		else {
			$tag_id = get_queried_object_id();
		}
		$cargs = array( 'posts_per_page' => $item_max, 'post_status' => 'publish', 'tag_id' => $tag_id );
	}
	elseif( ( $item_types === 'cat_list' || $item_types === 'tag_list' ) && ( is_year() === true || is_month() === true || is_date() === true ) ) {
		$year  = get_query_var('year');
		$month = get_query_var('monthnum');
		$day   = get_query_var('day');

		if( is_year() === true ) {
			$cargs = array( 'posts_per_archive_page' => $item_max, 'post_status' => 'publish', 'date_query' => array( 'year' => $year ) );
		}
		elseif( is_month() === true ) {
			$cargs = array( 'posts_per_archive_page' => $item_max, 'post_status' => 'publish', 'date_query' => array( 'year' => $year, 'month' => $month ) );
		}
		else {
			$cargs = array( 'posts_per_archive_page' => $item_max, 'post_status' => 'publish', 'date_query' => array( 'year' => $year, 'month' => $month, 'day' => $day ) );
		}
	}
	elseif( $item_types === 'page_list' ) {
		$cargs = array( 'posts_per_page' => $item_max, 'post_status' => 'publish', 'post_type' => 'page' );
	}
	elseif( $item_types === 'specified' && !empty( $ids ) ) {
		$specifieds = null;
		if( $item_types === 'specified' && !empty( $ids ) ) {
			$specifieds = array();
			$arr = explode( ',', $ids );

			foreach( (array)$arr as $value ) {
				$specifieds = array_merge( $specifieds, explode( "\n", $value ) );
			}

			if( count( $specifieds ) < $item_max ) {
				$item_max = count( $specifieds );
			}
			$cargs = array( 'posts_per_page' => $item_max, 'post_status' => 'publish', 'post__in' => $specifieds );
		}
	}
	elseif( $item_types === 'all_list' || is_home() === true || is_front_page() === true ) {
		$found_posts = wp_count_posts( 'post' );
		if( (int)$found_posts->publish < $item_max ) $item_max = (int)$found_posts->publish;
		$cargs = array( 'posts_per_page' => $item_max, 'post_status' => 'publish', 'post_type' => 'post' );
	}
	else {
		return;
	}

	$cquery = new WP_Query( $cargs );

	if( $cquery->found_posts < $item_max ) $item_max = $cquery->found_posts;
	if( $show_max > $item_max ) $show_max = $item_max - 1;
	if( $show_max <= 0 ) $show_max = 1;

	echo "<!--[if (gte IE 10)|!(IE)]><!-->\n";
	echo $args['before_widget'];
	if( !empty( $title ) ) echo $args['before_title'], $title, $args['after_title'];

	$max_height = '';
	if( $height !== 'auto' ) {
		$max_height = $heightpx . 'px';
	}
	else {
		$max_height = $thumb === 'thumbnail' ? '150px' : '300px';
	}
?>
<div class="swiper-container" style="display:none">
<div class="swiper-wrapper">
<?php
	$_is_singular = is_singular();
	$post_id = null;
	$idx = 0;
	$i = 0;
	if( $_is_singular === true) $post_id = get_the_ID();

	if( $cquery->have_posts() === true ) {
		while( $cquery->have_posts() === true ) {
			$cquery->the_post();
			$post_thumbnail = has_post_thumbnail();
			if( !empty( $post_thumbnail ) ) {
?>
<a href="<?php the_permalink() ?>" class="swiper-slide"><?php the_post_thumbnail( $thumb ); ?><?php if( isset( $titleview ) ) { ?><p class="swiper-title"><?php the_title(); ?></p><?php } ?></a>
<?php
			}
			else {
				$no_img_png = 'no-img-300x300.png';
				$no_img_wid = 300;
				$no_img_hgt = 300;

				if( $thumb === 'thumbnail' ) {
					$no_img_png = 'no-img.png';
					$no_img_wid = 150;
					$no_img_hgt = 150;
				}
?>
<a href="<?php the_permalink() ?>" class="swiper-slide"><img src="<?php echo TURI; ?>/images/<?php echo $no_img_png; ?>" itemprop="image" class="thumbnail" alt="No Image" title="No Image" width="<?php echo $no_img_wid; ?>" height="<?php echo $no_img_hgt; ?>" /><?php if( isset( $titleview ) ) { ?><p class="swiper-title"><?php the_title(); ?></p><?php } ?></a>
<?php
			}

			if( $cquery->post->ID === $post_id ) $idx = $i;
			++$i;
		}
	}
	wp_reset_postdata();

	if( $center !== 'post' ) $idx = 0;
?>
</div>
<?php
	if( $next_prev !== 'none' ) {
?>
<div class="swiper-button-prev"></div>
<div class="swiper-button-next"></div>
<?php
	}
	if( $navigation !== 'none' ) {
?>
<div class="swiper-pagination"></div>
<?php
	}
?>
</div>
<script>(function() {
var elm = document.querySelector('#<?php echo $args['widget_id']; ?> .swiper-container'),
c = elm.style;
c.maxHeight='<?php echo $max_height?>';
c.display='block';
c.visibility='hidden';
})();</script>
<script src="<?php echo TDEL ?>/js/thk-swiper.min.js?v=<?php echo $_SERVER['REQUEST_TIME']; ?>"></script>
<script>thk_swiper( '<?php echo TDEL ?>/js/swiper.min.js?v=<?php echo $_SERVER['REQUEST_TIME']; ?>', '<?php echo TDEL ?>/styles/thk-swiper.min.css?v=<?php echo $_SERVER['REQUEST_TIME']; ?>',<?php
echo
	"'", $args['widget_id'], "'", ',',
	$idx, ',',
	$item_max, ',',
	$show_max, ',',
	"'", $height, "'", ',',
	$heightpx, ',',
	"'", $width, "'", ',',
	"'", $slide_bg, "'", ',',
	"'", $navigation, "'", ',',
	"'", $next_prev, "'", ',',
	"'", $nav_color, "'", ',',
	"'", $efect, "'", ',',
	"'", $darkness, "'", ',',
	"'", $center, "'", ',',
	$autoplay
; ?> );</script>
<?php
	echo $args['after_widget'];
	echo "<!--<![endif]-->\n";
}
endif;
