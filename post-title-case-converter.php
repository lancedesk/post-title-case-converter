<?php

/*
 * Plugin Name: Post Title Case Converter
 * Plugin URI: https://lancedesk.com/post-title-case-converter
 * Description: A plugin to convert post titles to different cases.
 * Version: 1.1.0
 * Author: Robert June
 * Author URI: https://lancedesk.com
 * Text Domain: ptc-converter
 * Domain Path: /languages
 * Requires at least: 4.7
 * Tested up to: 6.5
 * Requires PHP: 7.0
 * Stable tag: 1.1.0
 * Beta tag: 1.1.1
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 * @package Post Title Case Converter
*/

defined( 'ABSPATH' ) || exit;

require_once plugin_dir_path(__FILE__) . 'includes/ptc-converter-functions.php';
require_once plugin_dir_path(__FILE__) . 'includes/ptc-converter-admin.php';
require_once plugin_dir_path(__FILE__) . 'includes/ptc-converter-ajax.php';
