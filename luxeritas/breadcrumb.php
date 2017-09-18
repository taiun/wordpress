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
$_is_single = is_single();

?>
<div itemprop="breadcrumb">
<ol id="breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList">
<?php
	if( is_front_page() === true ) {
?>
<li itemscope itemtype="http://schema.org/ListItem" itemprop="itemListElement"><i class="fa fa-home fa-fw"></i><span itemprop="name"><?php echo $luxe['home_text']; ?></span><meta itemprop="position" content="1" /><i class="arrow">&gt;</i></li>
<?php
	}
	elseif( is_page() === true ) {
		$i = 2;
		$parents = array_reverse( get_post_ancestors( $post->ID ) );
?>
<li itemscope itemtype="http://schema.org/ListItem" itemprop="itemListElement"><i class="fa fa-home fa-fw"></i><a itemprop="item" href="<?php echo THK_HOME_URL; ?>"><span itemprop="name"><?php echo $luxe['home_text']; ?></span></a><meta itemprop="position" content="1" /><i class="arrow">&gt;</i></li><?php
		if( empty( $parents ) ) {
?>
<li itemscope itemtype="http://schema.org/ListItem" itemprop="itemListElement"><i class="fa fa-file-o fa-fw"></i><span itemprop="name"><?php the_title(); ?><meta itemprop="position" content="2" /></span></li>
<?php
		}
		else {
			foreach ( $parents as $p_id ){
?>
<li itemscope itemtype="http://schema.org/ListItem" itemprop="itemListElement"><i class="fa fa-folder fa-fw"></i><a itemprop="item" href="<?php echo get_page_link( $p_id );?>"><span itemprop="name"><?php echo get_page( $p_id )->post_title; ?></span></a><meta itemprop="position" content="<?php echo $i; ?>" /><i class="arrow">&gt;</i></li>
<?php
				++$i;
			}
?>
<li itemscope itemtype="http://schema.org/ListItem" itemprop="itemListElement"><i class="fa fa-file-o fa-fw"></i><span itemprop="name"><?php the_title(); ?><meta itemprop="position" content="<?php echo $i; ?>" /></span></li>
<?php
		}
	}
	elseif( is_attachment() === true ) {
?>
<li itemscope itemtype="http://schema.org/ListItem" itemprop="itemListElement"><i class="fa fa-home fa-fw"></i><a itemprop="item" href="<?php echo THK_HOME_URL; ?>"><span itemprop="name"><?php echo $luxe['home_text']; ?></span></a><meta itemprop="position" content="1" /><i class="arrow">&gt;</i></li><?php
?><li itemscope itemtype="http://schema.org/ListItem" itemprop="itemListElement"><i class="fa fa-file-o fa-fw"></i><span itemprop="name"><?php the_title(); ?><meta itemprop="position" content="2" /></span></li>
<?php
	}
	elseif( $_is_single === true || is_category() === true ) {
		$cat = $_is_single === true ? get_the_category() : array( get_category( $cat ) );
		if( !empty( $cat ) && is_wp_error( $cat ) === false ) {
			$i = 2;
			$html = null;
			$html_array = array();
			$pars = get_category( $cat[0]->parent );
?>
<li itemscope itemtype="http://schema.org/ListItem" itemprop="itemListElement"><i class="fa fa-home fa-fw"></i><a itemprop="item" href="<?php echo THK_HOME_URL; ?>"><span itemprop="name"><?php echo $luxe['home_text']; ?></span></a><meta itemprop="position" content="1" /><i class="arrow">&gt;</i></li><?php

			while( $pars && !is_wp_error( $pars ) && $pars->cat_ID != 0 ) {
				$html_array[] = '<li itemscope itemtype="http://schema.org/ListItem" itemprop="itemListElement"><i class="fa fa-folder fa-fw"></i><a itemprop="item" href="' . get_category_link($pars->cat_ID) . '"><span itemprop="name">' . $pars->name . '</span></a><meta itemprop="position" content="<!--content-->" /><i class="arrow">&gt;</i></li>';
				$pars = get_category( $pars->parent );
			}
			if( !empty( $html_array ) ) $html_array = array_reverse( $html_array );

			foreach( (array)$html_array as $val ) {
				$html .= str_replace( '<!--content-->', $i, $val );
				++$i;
			}

			$title = '<span itemprop="name">' . $cat[0]->name . '</span>';
			if( is_category() === true ) {
				$title = '<h1 itemprop="name">' . $cat[0]->name . '</h1>';
			}
			echo $html,
				'<li itemscope itemtype="http://schema.org/ListItem" itemprop="itemListElement"><i class="fa fa-folder-open"></i><a itemprop="item" href="',
				get_category_link($cat[0]->cat_ID), '">', $title, '</a><meta itemprop="position" content="' . $i . '" /></li>';
		}
		else {
?>
<li itemscope itemtype="http://schema.org/ListItem" itemprop="itemListElement"><i class="fa fa-home fa-fw"></i><a itemprop="item" href="<?php echo THK_HOME_URL; ?>"><span itemprop="name"><?php echo $luxe['home_text']; ?></span></a><i class="arrow">&gt;</i></li><?php

		}
	}
	elseif(
		is_tag() === true	||
		is_tax() === true	||
		is_day() === true	||
		is_month() === true	||
		is_year() === true	||
		is_author() === true	||
		is_search() === true	||
		is_post_type_archive() === true
	) {
?>
<li itemscope itemtype="http://schema.org/ListItem" itemprop="itemListElement"><i class="fa fa-home fa-fw"></i><a itemprop="item" href="<?php echo THK_HOME_URL; ?>"><span itemprop="name"><?php echo $luxe['home_text']; ?></span></a><meta itemprop="position" content="1" /><i class="arrow">&gt;</i></li><?php
?><li itemscope itemtype="http://schema.org/ListItem" itemprop="itemListElement" content="2"><i class="fa fa-folder fa-fw"></i><h1 itemprop="name"><?php
		if( is_tag() === true ) {
			single_tag_title();
		}
		elseif( is_tax() === true ) {
			single_term_title();
		}
		elseif( is_day() === true ) {
			 echo get_the_date( __( 'F j, Y', 'luxeritas' ) );
		}
		elseif( is_month() === true ) {
			echo get_the_date( __( 'F Y', 'luxeritas' ) );
		}
		elseif( is_year() === true ) {
			echo get_the_date( __( 'Y', 'luxeritas' ) );
		}
		elseif( is_author() === true ) {
			echo esc_html(get_queried_object()->display_name);
		}
		elseif( is_search() === true ) {
			echo sprintf( __( 'Search results of [%s]', 'luxeritas' ), esc_html( $s ) );
		}
		elseif( is_post_type_archive() === true ) {
			echo post_type_archive_title( '', false );
		}
?></h1></li>
<?php
	}
	else {
?><li itemscope itemtype="http://schema.org/ListItem" itemprop="itemListElement"><i class="fa fa-home fa-fw"></i><a itemprop="item" href="<?php echo THK_HOME_URL; ?>"><span itemprop="name"><?php echo $luxe['home_text']; ?></span></a><meta itemprop="position" content="1" /><i class="arrow">&gt;</i></li>
<?php
		if( is_404() === true ) {
?><li itemscope itemtype="http://schema.org/ListItem" itemprop="itemListElement"><i class="fa fa-file-o fa-fw"></i><span itemprop="name"><?php echo __( 'Page not found', 'luxeritas' ); ?><meta itemprop="position" content="2" /></span></li>
<?php
		}
	}
?>
</ol><!--/breadcrumb-->
</div>
