<?php
/*
Plugin Name: CSS Naked Day
Plugin URI: http://www.ajalapus.com/downloads/css-naked-day/
Version: 1.0
Description: Automatically strips out XML/HTML stylesheet references, embedded and inline stylesheets, and provides a function to determine whether it is the 5th of April on the recommended worldwide 48-hour CSS Naked Day period.
Author: Aja Lorenzo Lapus
Author URI: http://www.ajalapus.com/

	Copyright 2007 Aja Lorenzo Lapus

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
v1.0 28-Mar-2007:
	- First release of the CSS Naked Day plugin.
*/

function is_naked_day() {
//	if (48 == get_option('css_naked')) {
		$aja_stime = gmmktime(-12, 0, 0, 4, 5); // Start of April 5 on GMT+12
		$aja_etime = gmmktime(36, 0, 0, 4, 5); // End of April 5 on GMT-12
/*	} else {
		$aja_offset = get_option('gmt_offset') * 3600;
		$aja_stime = gmmktime(0, 0, 0, 4, 5) + $aja_offset;
		$aja_etime = gmmktime(24, 0, 0, 4, 5) + $aja_offset;
	}
*/
	$aja_ntime = time();

	if ($aja_ntime >= $aja_stime && $aja_ntime <= $aja_etime)
		return true;
	else
		return false;
}

function aja_callback($aja_buffer) {
	$aja_pattern = array(
		'/<\?xml-stylesheet.*\?>/sU',                // x(ht)ml stylesheet directive
		'/<link.*rel\s*=\s*["\'].*stylesheet.*>/sU', // (x)html stylesheet reference
		'/<style.*</style>/sU',                      // (x)html embedded stylesheet
		'/style\s*=\s*".*"/U',                       // (x)html inline stylesheet "
		'/style\s*=\s*\'.*\'/U'                      // (x)html inline stylesheet '
	);
	return preg_replace($aja_pattern, '', $aja_buffer);
}

if (is_naked_day()) {
	add_action('template_redirect', create_function('', 'ob_start("aja_callback");'));
}