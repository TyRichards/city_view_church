# Hanna Changelog

2015-03-04 **v1.5** Nic Oliver <nic@themezilla.com>
- */js/jquery.custom.js*: Fixed bug with homepage featured portfolio thumbs.

2015-01-14 **v1.4** Nic Oliver <nic@themezilla.com>
- */content-gallery.php*, */content-video.php*, */functions.php*, */includes/template-tags.php*, */includes/theme-customize.php*,  */index.php*, */js/jquery.custom.js*, */js/modernizr.custom-2.8.3.js*, */scss/style.scss (compiled to: /style.css)*: Added a standard one-column blog layout and adjusted the behaviour of the JetPack infinite scroll.

2014-11-27 **v1.3** Nic Oliver <nic@themezilla.com>

- */functions.php* (filter: wpautop): Moved wpautop filter to AFTER shortcode is processed, to prevent invalid html in shortcodes. 
- */includes/widgets/widget-tweets.php* (function: screen_icon): Removed due to deprecation.
- */scss/style.scss* (compiled to: /style.css): updated .sticky and .bypostauthor classes.

2014-11-26 **v1.2** Nic Oliver <nic@themezilla.com>

- */footer.php, /functions.php, /header.php, /includes/theme-customize.php, /searchform.php, /template-about.php* (data validation / sanitization): Updated code to adhere to recommended WP data validation / sanitization techniques.
- */scss/style.scss* (compiled to: /style.css): Fixed the alignment of the contact thank you message.

2014-11-24  **v1.1**  Jesse Campbell <jesse@themezilla.com>

- */functions.php* (function: zilla_theme_setup): Added `wrapper => false` to infinite-scroll variables to stop Jetpack from adding to the URL in the blog when loading new posts.
- */js/jquery.custom.js* (code block: Isotope): Without the wrapper, isotope was unable to reinitialize and insert the new articles into the masonry grid. Had to overhaul much of the `if($().isotope){…}` statement and `$(document.body).on('post-load',function(){…})` to get Isotope to insert the posts properly.
- */js/jquery.custom.js* (function: initSlideshows): Had to wrap this statement in a function so that it could be called again when new posts are loaded with Infinite Scroll.
- */js/isotope.pkgd.min.js*: Updated Isotope.js to latest version.
- */scss/style.scss* (compiled to: /style.css): Fixed a header margin issue that was causing the top of the page to be cut off intermittently when users scrolled down then back up.
- */js/jquery.custom.js* (function: positionHeader): Revised the breakpoint to comply with new CSS breakpoints, and removed the changing `margin-top` property, as it was not needed.
- */scss/style.scss* (compiled to: /style.css): Revised media queries to px instead of ems, main reason for this was to simplify the media queries and tend to some overall rendering issues.
- */scss/style.scss* (compiled to: /style.css): Fixed a media query issue that caused the menu to render improperly between 768px and 783px wide.
- */includes/init.php* (function: zilla_register_required_plugins): Fixed the download URL for the Zilla Shortcodes recommended plugin.

2014-11-03  **v1.0**  Jesse Campbell <jesse@themezilla.com>

- First Release