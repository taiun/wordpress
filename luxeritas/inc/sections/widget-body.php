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

global $wp_widget_factory;
$thk_widget = array();
foreach( $wp_widget_factory->widgets as $key => $val ) {
	$id_base = $val->id_base;
	if( !isset( $thk_widget[$id_base] ) ) {
		$thk_widget[$id_base] = $val->name;
	}
}
asort( $thk_widget );
?>
<p class="f09em m10-b"><?php echo __( '* When checked, hides the widget.', 'luxeritas' ); ?></p>
<ul>
<li>
<table id="amp-plugins">
<thead>
<tr><th class="amp-cbox"><?php echo __( 'Hide', 'luxeritas' ); ?></th><th><?php echo __( 'Widget', 'luxeritas' ); ?></th></tr>
</thead>
<tbody>
<?php
foreach( (array)$thk_widget as $key => $val ) {
?>
<tr>
<td class="amp-cbox"><input type="checkbox" value="" name="widget_body_<?php echo $key; ?>"<?php thk_value_check( 'widget_body_' . $key, 'checkbox' ); ?> /></td>
<td><?php echo $val; ?></td>
</tr>
<?php
}
?>
</tbody>
</table>
</li>
</ul>
