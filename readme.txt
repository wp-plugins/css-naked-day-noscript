=== CSS Naked Day ===
Contributors: ajalapus
Tags: css, naked day, stylesheets, formatting, design
Requires at least: 2.1
Tested up to: 2.1.2
Stable tag: trunk

Automatically strips off stylesheets without editing themes during the Annual CSS Naked Day.

== Description ==

> The idea behind CSS Naked Day is to promote Web Standards. Plain and simple.
> This includes proper use of (X)HTML, semantic markup, a good hierarchy structure, and; well, a fun play on words.
> I mean, who doesn't want to get naked? —Dustin Diaz, Founder of CSS Naked Day

This CSS Naked Day plugin automatically strips off the following code from your site
without you having to edit your themes:

* X(HT)ML stylesheet directives: `<?xml-stylesheet … ?>`
* (X)HTML stylesheet references: `<link rel="stylesheet" … />`
* (X)HTML embedded stylesheets: `<style> … </style>`
* (X)HTML inline stylesheets: `style="…"` or `style='…'`

Since version 1.1, you have an option to activate it during the recommended worldwide 48-hour CSS Naked Day period,
or just the local 24-hour period.

For more information, visit: [The Official CSS Naked Day Page](http://naked.dustindiaz.com/).

== Installation ==

1. Upload `css-naked-day.php` to the `/wp-content/plugins/` directory.
1. Activate the plugin through the 'Plugins' menu in WordPress.
1. Select configuration options in the Options » CSS Naked Day page.
1. Wait until the 5th of April for the Plugin to strip your site naked.

*Step 3 is optional.*

= Upgrading =

If you already have installed CSS Naked Day plugin with version prior to 1.1, follow the steps below.

1. Deactivate the outdated plugin.
1. Delete the old plugin file from the `/wp-content/plugins/` directory.
1. Upload the new version of the plugin.
1. Activate the plugin through the 'Plugins' menu in WordPress.
1. Select configuration options in the Options » CSS Naked Day page.
1. Wait until the 5th of April for the Plugin to strip your site naked.

*Steps 1 and 2 ensures the new plugin has been activated with options. Step 5 is optional.*

== Frequently Asked Questions ==

= What differences does this plugin have compared to other CSS Naked Day plugins? =

1. This plugin removes all CSS stylesheets from the page before it sends the data to the viewers' browsers.
1. It doesn't use client-side scripting to remove styles, which may be turned off or unsupported in other browsers,
so everyone would see your page in its natural, naked form.
1. It doesn't require the user to edit his/her theme files.

= How could I display a message only on the 5th of April telling why my site is naked? =

Use the `is_naked_day()` function inside an `if ()` block. `is_naked_day()` returns `true` when it is April 5,
otherwise it returns `false`.

Example:

`<?php if (is_naked_day()) { ?> Message why my site is naked. <?php } ?>`

== Screenshots ==

*No screenshots available for this plugin*