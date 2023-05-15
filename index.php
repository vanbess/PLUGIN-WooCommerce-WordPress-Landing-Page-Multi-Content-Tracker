<?php

/**
 * Plugin Name:       Landing Page Multi Content Tracker
 * Description:       Landing page CPT multi content creator/rotator with tracking link. Advanced Custom Fields required.
 * Version:           1.0.1
 * Requires at least: 5.0
 * Requires PHP:      7.4
 * Author:            WC Bessinger
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       lp-tracker
 */

defined('ABSPATH') || exit();

add_action('plugins_loaded', function () {

    // define constants
    define('LP_Tracker_Path', plugin_dir_path(__FILE__));
    define('LP_Tracker_URL', plugin_dir_url(__FILE__));

    if (class_exists('ACF')) {

        // admin main class
        require_once LP_Tracker_Path . 'includes/admin/class_lpt_admin.php';
    
        // front main class
        require_once LP_Tracker_Path . 'includes/front/class_lpt_front.php';

    } else {
        add_action('admin_notices', function() {
            echo '<div class="error">';
            echo '<p>' . __('<b>Important!</b> Landing Page Multi Content Tracker requires the Advanced Custom Fields (ACF) plugin to be installed and activated.') . '</p>';
            echo '</div>';
        });
    }

});
