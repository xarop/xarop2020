<?php
// This file handles the admin area and functions - You can use this file to make changes to the dashboard.

/************* DASHBOARD WIDGETS *****************/
// Disable default dashboard widgets
function disable_default_dashboard_widgets() {
	Remove_meta_box('dashboard_right_now', 'dashboard', 'core');    // Right Now Widget
	remove_meta_box('dashboard_recent_comments', 'dashboard', 'core'); // Comments Widget
	remove_meta_box('dashboard_incoming_links', 'dashboard', 'core');  // Incoming Links Widget
	remove_meta_box('dashboard_plugins', 'dashboard', 'core');         // Plugins Widget

	Remove_meta_box('dashboard_quick_press', 'dashboard', 'core');  // Quick Press Widget
	remove_meta_box('dashboard_recent_drafts', 'dashboard', 'core');   // Recent Drafts Widget
	remove_meta_box('dashboard_primary', 'dashboard', 'core');         //
	remove_meta_box('dashboard_secondary', 'dashboard', 'core');       //

	// Removing plugin dashboard boxes
	remove_meta_box('yoast_db_widget', 'dashboard', 'normal');         // Yoast's SEO Plugin Widget

}

/*
For more information on creating Dashboard Widgets, view:
http://digwp.com/2010/10/customize-wordpress-dashboard/
*/

// RSS Dashboard Widget
function xarop_rss_dashboard_widget() {
	if(function_exists('fetch_feed')) {
		include_once(ABSPATH . WPINC . '/feed.php');               // include the required file
		$feed = fetch_feed('http://xarop.com/feed/rss/');        // specify the source feed
		$limit = $feed->get_item_quantity(5);                      // specify number of items
		$items = $feed->get_items(0, $limit);                      // create an array of items
	}
	if ($limit == 0) echo '<div>' . __( 'The RSS Feed is either empty or unavailable.', 'xarop' ) . '</div>';   // fallback message
	else foreach ($items as $item) { ?>

	<h4 style="margin-bottom: 0;">
		<a href="<?php echo $item->get_permalink(); ?>" title="<?php echo mysql2date(__('j F Y @ g:i a', 'xarop'), $item->get_date('Y-m-d H:i:s')); ?>" target="_blank">
			<?php echo $item->get_title(); ?>
		</a>
	</h4>
	<p style="margin-top: 0.5em;">
		<?php echo substr($item->get_description(), 0, 200); ?>
	</p>
	<?php }
}

// Calling all custom dashboard widgets
function xarop_xarop_support_dashboard_widgets() {
	wp_add_dashboard_widget('xarop_rss_dashboard_widget', __('Xarop News', 'xarop'), 'xarop_rss_dashboard_widget');
	/*
	Be sure to drop any other created Dashboard Widgets
	in this function and they will all load.
	*/
}
// removing the dashboard widgets
add_action('admin_menu', 'disable_default_dashboard_widgets');
// adding any custom widgets
add_action('wp_dashboard_setup', 'xarop_xarop_support_dashboard_widgets');

/************* CUSTOMIZE ADMIN *******************/
// Custom Backend Footer
function xarop_custom_admin_footer() {
	_e('<span id="footer-thankyou">Developed by <a href="http://xarop.com" target="_blank">xarop.com</a></span>.', 'xarop');
}

// adding it to the admin area
add_filter('admin_footer_text', 'xarop_custom_admin_footer');


// Support dashboard widget
function xarop_support_dashboard_widget() {
	// _e('Xarop Support', 'xarop');
	$theme = wp_get_theme();
    $theme_name = $theme->get( 'Name' );
	$theme_template = $theme->get( 'Template' );
	// echo 'template: '.$theme_template.' | theme: '.$theme_name.'';
	// echo '<a href="mailto:ajl@xarop.com">'.__('OPEN SUPPORT TICKET', 'xarop').'</a>';
    // echo ' <iframe frameborder="0" src="http://sites.xarop.com/?site='.get_site_url().'&template='.$theme_template.'&theme='.$theme_name.'" frameborder="0" style="width: 100%; height:400px;"></iframe>';
?>

<a href="http://xarop.com">
	<img src="http://www.xarop.com/logo.png" alt="xarop.com">
</a>

<?php
}
function add_xarop_support_dashboard_widget() {
	wp_add_dashboard_widget('xarop_support_dashboard_widget', __('Xarop', 'xarop'), 'xarop_support_dashboard_widget');
}
add_action('wp_dashboard_setup', 'add_xarop_support_dashboard_widget');