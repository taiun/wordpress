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

?>
<ul>
<li>
<p class="checkbox">
<input type="checkbox" value="" name="css_to_style"<?php thk_value_check( 'css_to_style', 'checkbox' ); ?> />
<?php echo __( 'Include theme&apos;s CSS in HTML', 'luxeritas' ); ?><?php echo ' ( ', __( 'Accelerate', 'luxeritas' ), ' ? )'; ?>
</p>
<p class="f09em"><?php echo __( '* It will include the style.css code directly in the HTML file. You can reduce HTTP requests.', 'luxeritas' ); ?></p>
<p class="f09em"><?php echo __( '* Since the CSS will not be cached in the browser, if you have many visitors circulating within your site, it may end up counterproductive.', 'luxeritas' ); ?></p>
</li>
</ul>
