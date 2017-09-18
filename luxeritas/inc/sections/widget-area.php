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

//global $wp_registered_sidebars;
$widgets = thk_widget_areas();
?>
<p class="f09em m10-b"><?php echo __( '* When checked, hide the widget area.', 'luxeritas' ); ?></p>
<ul>
<li>
<table id="amp-plugins">
<thead>
<tr><th class="amp-cbox"><?php echo __( 'Hide', 'luxeritas' ); ?></th><th><?php echo __( 'Widget Area', 'luxeritas' ); ?></th></tr>
</thead>
<tbody>
<?php
foreach( $widgets as $key => $val ) {
?>
<tr>
<td class="amp-cbox"><input type="checkbox" value="" name="widget_area_<?php echo $val['id']; ?>"<?php thk_value_check( 'widget_area_' . $val['id'], 'checkbox' ); ?> /></td>
<td><?php echo $val['name']; ?></td>
</tr>
<?php
}
unset( $widgets );
?>
</tbody>
</table>
</li>
</ul>
