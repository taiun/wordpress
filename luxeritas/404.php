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
<div itemprop="mainEntityOfPage" id="post">
<h1 class="entry-title">404 Not Found</h1>
<p><?php echo __('Sorry, but you are looking for something that isn&#8217;t here.', 'luxeritas'); ?></p>
</div><!--/post-->
</div><!--/#core-->
</article>
</main>
</div><!--/#main-->
<?php thk_call_sidebar(); ?>
</div><!--/#primary-->
<?php echo apply_filters( 'thk_footer', '' ); ?>
