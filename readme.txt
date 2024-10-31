=== Precise Columns ===
Contributors: simonpedge
Tags: column shortcodes, responsive columns, custom columns, column layouts
Requires at least: 4.0
Tested up to: 4.5.1
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Shortcodes for more precise control of your column layouts. Set column responsive behaviour, define your column gaps and content alignment.

== Description ==

Shortcodes for more precise control of your column layouts. A developers tool to set column responsive behaviour, define column gaps as well as control horizontal/vertical content alignment.

The [Screenshots Page](https://wordpress.org/plugins/precise-columns/screenshots/) will give you a good idea on how this plugin works.

Please view the [FAQ Page](https://wordpress.org/plugins/precise-columns/faq/) for more detailed information on how to use this plugin and the `Precise Columns` shortcode parameters.

== Installation ==

1. Upload the entire `precise-columns` folder to the `/wp-content/plugins/` directory.
1. Activate the plugin through the 'Plugins' menu within the WordPress Dashboard.

When editing pages, posts or other custom post types, you will now see the green `Precise Columns` icon within the Visual Editor. Click this icon to create and insert `Precise Columns` shortcodes.

== Frequently Asked Questions ==

= What are the `precise-columns` shortcode paramters =

* `break` - this defines the responsive breakpoints for your column layout. `break='959,479'` used with the `col4` shortcode means your 4-column layout will switch to two rows of two columns when your window resolution is 959 pixels or lower. And your 4-column layout will switch to fours rows of one column each when your window resolution is 479 pixels or lower.
* `gap` - this defines the gap/space between each column in your column layout. `gap='3,5,8'` means that in 4-column mode the gap between each column is 3% of your page/container width. In 2-column mode the gap between each column is 5% of your container width, and in 1-column mode the gap between each column is 8% of your container width.
* `wrap_padd` - this defines padding space around your entire column layout. `wrap_padd='4,2'` means that above and below your column layout there will be a padding of 5% of your container/page width. There will also be padding left and right of your column layout of 2%.
* `align` - defines how the content within each column is aligned horizontally. `align='center'` means content is center-aligned horizontally. Other options are 'left' and 'right'.
* `valign` - defines how the content within each column is aligned vertically. `align='middle'` means content is aligned vertically in the middle of each column. Other options are 'top' and 'bottom'.
* `wrap_id` - can be used to define a custom CSS #ID for your column layout wrapper. This is useful if you want to add your own custom CSS style to your column layout
* `strip_tags` - use this to remove any 'paragraph' and 'break' tags defined within your column layout. This feature will allow you to layout your shortcode content within the WordPress Visual Editor to be visibly more readable by other users.

== Screenshots ==

1. The green `Precise Columns` icon within the WordPress Visual Editor, and the column layouts presented when clicked.
2. The `Precise Columns` column options dialog box for a selected column layout.

== Changelog ==

= 1.0 =
* Initial release of this plugin.

== Upgrade Notice ==

= 1.0 =
* Initial release of this plugin.
