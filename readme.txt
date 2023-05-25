=== Recently Purchased Products For Woo ===

Author:            worldweb
Contributors:      worldweb
Plugin Name:       Recently Purchased Products For Woo
Plugin URI:        https://wordpress.org/plugins/recently-purchased-products-for-woo/
Tags:              recent purchases, purchases, last purchases, recent orders, woocommerce
Author URI:        https://worldwebtechnology.com
Requires at least: 5.0
Requires PHP:      5.6
Tested up to:      6.1.1
Stable tag:        1.0.2
License:           GPLv2 or later
License URI:       https://www.gnu.org/licenses/gpl-2.0.html
Version:           1.0.2

Display Recently Purchased Products For Woocommerce using Widget and Shortcode

== Description ==

Display Recently Purchased Products for [Woocommerce](https://wordpress.org/plugins/woocommerce/). Plugin supports Widget and Shortcodes to display recently purchased products.

**Main Features**
* Shortcode with list and grid view options.
* Widget to display lists in sidebar.
* Define how many products you want to display.

**How to use The Shortcode**

You can use the shortcode to dispaly list of recently purchased products. Here’s an example of how you can show the recently purchased 6 products with grid view:

`[recently_purchased_products limit="6" view="grid"]`

Below are the shortcode supported options:

* title: Display the title on top of listing. Default is empty.
* limit: Used to limit the number of products. Default is 5.
* order: Order of listing either ASC or DESC. Default is DESC.
* img: Show or hide the product image in listing. Default is Show.
* img_size: Spcify image size 50 if you want 50x50 image.
* date: Show or hide product date. Default is Show.
* price: Show or hide the product price. Default is Show.
* view: Define the view layout. Option are grid and list. Default is list.  

== Installation ==

1. Unzip the downloaded zip file
2. Upload the included folder to '/wp-content/plugins' directory of your WordPress installation
3. Activate the plugin via the WordPress Plugins page
4. Now, You will see settings link on plugin page. Click on it then you wil redirect to the settings page of plugin.

== Screenshots ==

1. List of Recently Purchased Products with Grid View
2. List of Recently Purchased Products with List View
3. Widget Output

== Frequently Asked Questions ==

= How to display grid view instead of list? =

Put <code>view="grid"</code> in the shortcode.

= How it's getting products from orders? =

Plugin will get only first products from each orders and display it.

== Changelog ==

= 1.0.2 =
* Check WordPress Version 6.1 compatibility.

= 1.0.1 =
* Tested with WordPress 5.8
* Tested with WooCommerce 5.5.2

= 1.0 =
* Initial release.