<?php
/*
Plugin Name: CSS Naked Day
Plugin URI: http://www.ajalapus.com/downloads/css-naked-day/
Version: 1.2
Description: Automatically strips off stylesheets without editing themes during the Annual CSS Naked Day.
Author: Aja Lorenzo Lapus
Author URI: http://www.ajalapus.com/

	Copyright 2007-2008 Aja Lorenzo Lapus

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation; either version 2 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

Change Log:
v1.2 4-Apr-2008:
	- Changed CSS Naked Day date to reflect event move from April 5 to 9.
v1.1.2 6-Apr-2007:
	- Fixed regex for patterns to avoid possible conflicts.
	- Fixed known issue about escaped quotation marks in inline styles.
v1.1.1 5-Apr-2007:
	- Fixed stylesheet reference regex/consuming all <link> elements before targetted one.
v1.1 31-Mar-2007:
	- Added option to activate only during the 24-hour local time.
	- Added configuration page.
v1.0.1 30-Mar-2007:
	- Fixed embedded stylesheet regex/conflict with delimiter.
v1.0 28-Mar-2007:
	- First release of the CSS Naked Day plugin.
*/

function is_naked_day() {
	if (get_option('aja_naked_day_rechrs')) {
		$aja_stime = gmmktime(-12, 0, 0, 4, 9); // Start of April 9 on GMT+12
		$aja_etime = gmmktime(36, 0, 0, 4, 9);  // End of April 9 on GMT-12
	} else {
		$aja_offset = get_option('gmt_offset') * 3600;
		$aja_stime = gmmktime(0, 0, 0, 4, 9) - $aja_offset;  // Start of local April 9
		$aja_etime = gmmktime(24, 0, 0, 4, 9) - $aja_offset; // End of local April 9
	}

	$aja_ntime = time(); // Time now

	if ($aja_ntime >= $aja_stime && $aja_ntime <= $aja_etime)
		return true;
	else
		return false;
}

/* Configuration Panel Function */

function aja_naked_day_subpanel() {
	if (isset($_POST['aja_update'])) {
		$aja_setting = ($_POST['aja_rechours'] == 'true') ? true : false;
		update_option('aja_naked_day_rechrs', $aja_setting);
?><div id="message" class="updated fade"><p><strong>Options saved.</strong></p></div>
<?php
	}
?><div class="wrap">
	<form method="post">
		<h2><acronym title="Cascading Style Sheets">CSS</acronym> Naked Day</h2>
		<fieldset class="options">
			<legend>Activation Time Span</legend>
			<p>CSS Naked Day plugin should strip stylesheets off your site for
			<select name="aja_rechours">
				<option value="false"<?php if (!get_option('aja_naked_day_rechrs')) { ?> selected="selected"<?php } ?>>24 (local WP time)</option>
				<option value="true"<?php if (get_option('aja_naked_day_rechrs')) { ?> selected="selected"<?php } ?>>48 (recommended)</option>
			</select>
			hours.</p>
		</fieldset>
		<p class="submit"><input type="submit" name="aja_update" value="Update Options &#187;" /></p>
	</form>
</div>
<?php
}

/* Callback Funtions */

function aja_options_page() {
	add_options_page('CSS Naked Day', 'CSS Naked Day', 8, 'css-naked-day', 'aja_naked_day_subpanel');
}

function aja_activate() {
	add_option('aja_naked_day_rechrs', true, 'Strip CSS off the site for the 48-hour recommended period.');
}

function aja_deactivate() {
	delete_option('aja_naked_day_rechrs');
}

function aja_replace($aja_buffer) {
	$aja_pattern = array(
		'@<\?xml-stylesheet.*\?>@sU',                               // x(ht)ml reference
		'@<link[^<]+rel\s*=\s*"[a-z ]*stylesheet[a-z ]*".*>@isU',   // (x)html reference "
		'@<link[^<]+rel\s*=\s*\'[a-z ]*stylesheet[a-z ]*\'.*>@isU', // (x)html reference '
		'@<style.*</style>@isU',                                    // (x)html embedded
		'@style\s*=\s*".*(?:(?:\x5C").*)*?"@iU',                    // (x)html inline "
		'@style\s*=\s*\'.*(?:(?:\x5C\').*)*?\'@iU'                  // (x)html inline '
	);
	return preg_replace($aja_pattern, '', $aja_buffer);
}

function aja_buffer() {
	if (is_naked_day())
		ob_start('aja_replace');
}

/* WordPress Hooks */

add_action('admin_menu', 'aja_options_page');
add_action('activate_css-naked-day.php', 'aja_activate');
add_action('deactivate_css-naked-day.php', 'aja_deactivate');
add_action('template_redirect', 'aja_buffer');
