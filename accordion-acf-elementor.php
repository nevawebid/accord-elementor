<?php
/**
 * Plugin Name: ACF/SCF Accordion for Elementor
 * Plugin URI: https://github.com/nevawebid/accord-elementor
 * Description: A WordPress plugin that displays ACF (Advanced Custom Fields) or SCF (Secure Custom Fields) Repeater data as responsive accordion using Elementor widget. Fully customizable with smooth animations and accessibility support.
 * Version: 1.1.0
 * Author: Nevaweb
 * Author URI: https://nevaweb.id
 * Text Domain: acf-accordion-elementor
 * Domain Path: /languages
 * Requires at least: 5.0
 * Tested up to: 6.6
 * Requires PHP: 7.4
 * Network: false
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * 
 * @package ACF_SCF_Accordion_Elementor
 * @author Nevaweb
 * @copyright 2025 Nevaweb
 * @license GPL-2.0-or-later
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit('Direct access forbidden.');
}

// Security check
if (!function_exists('add_action')) {
    exit('WordPress environment required.');
}

// Define plugin constants
define('ACF_ACCORDION_ELEMENTOR_VERSION', '1.1.0');
define('ACF_ACCORDION_ELEMENTOR_PLUGIN_URL', plugin_dir_url(__FILE__));
define('ACF_ACCORDION_ELEMENTOR_PLUGIN_PATH', plugin_dir_path(__FILE__));

/**
 * Main Plugin Class
 */
class ACF_Accordion_Elementor_Plugin {

    /**
     * Plugin instance
     */
    private static $_instance = null;

    /**
     * Get plugin instance
     */
    public static function instance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Constructor
     */
    public function __construct() {
        add_action('plugins_loaded', [$this, 'init']);
    }

    /**
     * Initialize the plugin
     */
    public function init() {
        // Load text domain for internationalization
        add_action('init', [$this, 'load_textdomain']);
        
        // Check if Elementor is installed and activated
        if (!did_action('elementor/loaded')) {
            add_action('admin_notices', [$this, 'admin_notice_missing_elementor']);
            return;
        }

        // Check for minimum Elementor version
        $elementor_version = get_option('elementor_version');
        if ($elementor_version && !version_compare($elementor_version, '3.0.0', '>=')) {
            add_action('admin_notices', [$this, 'admin_notice_minimum_elementor_version']);
            return;
        }

        // Check if ACF or SCF is installed and activated
        if (!class_exists('ACF') && !function_exists('scf_get')) {
            add_action('admin_notices', [$this, 'admin_notice_missing_custom_fields']);
            return;
        }

        // Add plugin actions
        add_action('elementor/widgets/register', [$this, 'register_widgets']);
        add_action('elementor/frontend/after_enqueue_styles', [$this, 'enqueue_frontend_styles']);
        add_action('elementor/frontend/after_register_scripts', [$this, 'enqueue_frontend_scripts']);
    }

    /**
     * Load plugin textdomain for internationalization
     */
    public function load_textdomain() {
        load_plugin_textdomain(
            'acf-accordion-elementor',
            false,
            dirname(plugin_basename(__FILE__)) . '/languages/'
        );
    }

    /**
     * Register widgets
     */
    public function register_widgets($widgets_manager) {
        // Include widget file
        require_once ACF_ACCORDION_ELEMENTOR_PLUGIN_PATH . 'acf-accordion-widget.php';

        // Register widget
        $widgets_manager->register(new \ACF_Accordion_Widget());
    }

    /**
     * Enqueue frontend styles
     */
    public function enqueue_frontend_styles() {
        wp_enqueue_style(
            'acf-accordion-elementor-frontend',
            ACF_ACCORDION_ELEMENTOR_PLUGIN_URL . 'assets/css/frontend.css',
            [],
            ACF_ACCORDION_ELEMENTOR_VERSION
        );
    }

    /**
     * Enqueue frontend scripts
     */
    public function enqueue_frontend_scripts() {
        wp_enqueue_script(
            'acf-accordion-elementor-frontend',
            ACF_ACCORDION_ELEMENTOR_PLUGIN_URL . 'assets/js/frontend.js',
            ['jquery'],
            ACF_ACCORDION_ELEMENTOR_VERSION,
            true
        );
    }

    /**
     * Admin notice for missing Elementor
     */
    public function admin_notice_missing_elementor() {
        if (isset($_GET['activate'])) {
            unset($_GET['activate']);
        }

        $message = sprintf(
            /* translators: 1: Plugin name 2: Elementor */
            esc_html__('"%1$s" requires "%2$s" to be installed and activated.', 'acf-accordion-elementor'),
            '<strong>' . esc_html__('ACF/SCF Accordion for Elementor', 'acf-accordion-elementor') . '</strong>',
            '<strong>' . esc_html__('Elementor', 'acf-accordion-elementor') . '</strong>'
        );

        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
    }

    /**
     * Admin notice for minimum Elementor version
     */
    public function admin_notice_minimum_elementor_version() {
        if (isset($_GET['activate'])) {
            unset($_GET['activate']);
        }

        $message = sprintf(
            /* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
            esc_html__('"%1$s" requires "%2$s" version %3$s or greater.', 'acf-accordion-elementor'),
            '<strong>' . esc_html__('ACF/SCF Accordion for Elementor', 'acf-accordion-elementor') . '</strong>',
            '<strong>' . esc_html__('Elementor', 'acf-accordion-elementor') . '</strong>',
            '3.0.0'
        );

        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
    }

    /**
     * Admin notice for missing Custom Fields plugins
     */
    public function admin_notice_missing_custom_fields() {
        if (isset($_GET['activate'])) {
            unset($_GET['activate']);
        }

        $message = sprintf(
            /* translators: 1: Plugin name 2: Custom Fields plugins */
            esc_html__('"%1$s" requires "%2$s" or "%3$s" to be installed and activated.', 'acf-accordion-elementor'),
            '<strong>' . esc_html__('ACF/SCF Accordion for Elementor', 'acf-accordion-elementor') . '</strong>',
            '<strong>' . esc_html__('Advanced Custom Fields (ACF)', 'acf-accordion-elementor') . '</strong>',
            '<strong>' . esc_html__('Secure Custom Fields (SCF)', 'acf-accordion-elementor') . '</strong>'
        );

        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
    }
}

/**
 * Initialize the plugin
 */
function acf_accordion_elementor_plugin() {
    return ACF_Accordion_Elementor_Plugin::instance();
}

// Start the plugin
acf_accordion_elementor_plugin();

/**
 * Plugin activation hook
 */
register_activation_hook(__FILE__, function() {
    // Check for required plugins
    if (!is_plugin_active('elementor/elementor.php')) {
        wp_die(
            esc_html__('This plugin requires Elementor to be installed and activated.', 'acf-accordion-elementor'),
            esc_html__('Plugin Activation Error', 'acf-accordion-elementor'),
            ['back_link' => true]
        );
    }

    // Check for ACF or SCF
    $has_acf = is_plugin_active('advanced-custom-fields/acf.php') || is_plugin_active('advanced-custom-fields-pro/acf.php');
    $has_scf = is_plugin_active('secure-custom-fields/secure-custom-fields.php');
    
    if (!$has_acf && !$has_scf) {
        wp_die(
            esc_html__('This plugin requires Advanced Custom Fields (ACF) or Secure Custom Fields (SCF) to be installed and activated.', 'acf-accordion-elementor'),
            esc_html__('Plugin Activation Error', 'acf-accordion-elementor'),
            ['back_link' => true]
        );
    }
});

/**
 * Plugin deactivation hook
 */
register_deactivation_hook(__FILE__, function() {
    // Clear any cached data if needed
    wp_cache_flush();
});