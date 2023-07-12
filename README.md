=== Recently Purchased Products For Woo ===

Author:            worldweb
Contributors:      worldweb
Plugin Name:       Recently Purchased Products For Woo
Plugin URI:        https://wordpress.org/plugins/recently-purchased-products-for-woo/
Tags:              recent purchases, purchases, last purchases, recent orders, woocommerce
Author URI:        https://worldwebtechnology.com
Requires at least: 5.0
Requires PHP:      5.6
Tested up to:      6.2.2
Stable tag:        1.0.4
License:           GPLv2 or later
License URI:       https://www.gnu.org/licenses/gpl-2.0.html
Version:           1.0.4

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
* img_size: Specify image size 50 if you want 50x50 image.
* img_type: Image type like product image / customer avatar image.
* date: Show or hide product date. Default is Show.
* price: Show or hide the product price. Default is Show.
* category: Show or hide the product category. Default is Show.
* cart: Show or hide the Add to cart button. Default is Hide.
* rating: Show or hide the Product rating. Default is Hide.
* view: Define the view layout. Option are grid and list. Default is list.  
* grid_cols: Number of grid columns will show.
* customer_info: Show customer information with the recent product. 

Here’s an example of how you can show the recently purchased 6 products with Slider view:

`[recently_purchased_products_slider limit="6" slidestoshow="3"]`

Below are the shortcode supported options:

* title: Display the title on top of listing. Default is empty.
* limit: Used to limit the number of products. Default is 5.
* category: Show or hide the product category. Default is Show.
* cart: Show or hide the Add to cart button. Default is Hide.
* rating: Show or hide the Product rating. Default is Hide.
* order: Order of listing either ASC or DESC. Default is DESC.
* img: Show or hide the product image in listing. Default is Show.
* img_size: Specify image size 50 if you want 50x50 image.
* img_type: Image type like product image / customer avatar image.
* customer_info: Show customer information with the recent product.  Default is "show".
* date: Show or hide product date. Default is Show.
* price: Show or hide the product price. Default is Show.
* slidestoshow: Show number of slide visible. Default is 1.
* slidestoscroll: Number of slide scroll on next/prev slide. Default is 1.
* autoplay: Autoplay slider. Default is true.
* dots: Show dots for the slider. Default is true.
* arrow: Show arrow for the next and previous slide. Default is true. 
* infinite: Scroll infinite loop for the slider. Default is true. 

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

= 1.0.3 =
* Added new shortcode for slider.
* Added slider option in widget.
* Resolved Responsive issue and Layout Misalignment.
* Show product category on top of the product title.
* Added customer info, category, image type (product image / customer image), rating, grid columns, display cart.

= 1.0.2 =
* Check WordPress Version 6.1 compatibility.

= 1.0.1 =
* Tested with WordPress 5.8
* Tested with WooCommerce 5.5.2

= 1.0 =
* Initial release.