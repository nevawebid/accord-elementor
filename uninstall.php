<?php
/**
 * Plugin uninstall script
 * 
 * This file is executed when the plugin is uninstalled (deleted).
 * It cleans up any data the plugin may have stored.
 *
 * @package ACF_SCF_Accordion_Elementor
 * @since 1.0.0
 */

// If uninstall not called from WordPress, then exit
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

// Security check
if (!defined('ABSPATH')) {
    exit('WordPress environment required.');
}

/**
 * Clean up plugin data on uninstall
 */
function acf_accordion_elementor_uninstall() {
    // Remove plugin options if any (currently none)
    // delete_option('acf_accordion_elementor_settings');
    
    // Remove any transients if any (currently none)
    // delete_transient('acf_accordion_elementor_cache');
    
    // Remove any user meta if any (currently none)
    // delete_metadata('user', 0, 'acf_accordion_elementor_preference', '', true);
    
    // Remove any custom database tables if any (currently none)
    // global $wpdb;
    // $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}acf_accordion_elementor_data");
    
    // Clear any cached data
    wp_cache_flush();
}

// Run uninstall function
acf_accordion_elementor_uninstall();
