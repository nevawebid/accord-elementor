/**
 * ACF Accordion for Elementor - Frontend JavaScript
 * 
 * Script untuk menangani interaktivitas accordion
 */

(function($) {
    'use strict';
    
    // Animation configuration
    var accordionConfig = {
        animationDuration: 450,
        animationEasing: 'easeInOutQuart',
        iconRotationDuration: 300
    };
    
    // Custom easing function for smoother animations
    $.easing.easeInOutQuart = function (x, t, b, c, d) {
        if ((t/=d/2) < 1) return c/2*t*t*t*t + b;
        return -c/2 * ((t-=2)*t*t*t - 2) + b;
    };
    
    // Initialize accordion when document is ready
    $(document).ready(function() {
        initAccordions();
    });
    
    // Re-initialize on Elementor frontend
    $(window).on('elementor/frontend/init', function() {
        elementorFrontend.hooks.addAction('frontend/element_ready/widget', function($scope) {
            initAccordions($scope);
        });
    });
    
    /**
     * Initialize accordion functionality
     * @param {jQuery} $scope - The scope to search for accordions
     */
    function initAccordions($scope) {
        var $accordionWrappers = $scope ? $scope.find('.acf-accordion-wrapper') : $('.acf-accordion-wrapper');
        
        if ($accordionWrappers.length === 0) {
            return;
        }
        
        $accordionWrappers.each(function() {
            var $wrapper = $(this);
            
            // Skip if already initialized
            if ($wrapper.hasClass('acf-accordion-initialized')) {
                return;
            }
            
            var allowMultiple = $wrapper.data('multiple') === true || $wrapper.data('multiple') === 'true';
            var $titles = $wrapper.find('.acf-accordion-title');
            
            // Bind click events
            $titles.off('click.acf-accordion').on('click.acf-accordion', function(e) {
                e.preventDefault();
                handleAccordionClick($(this), $wrapper, allowMultiple);
            });
            
            // Bind keyboard events for accessibility
            $titles.off('keydown.acf-accordion').on('keydown.acf-accordion', function(e) {
                if (e.key === 'Enter' || e.key === ' ' || e.keyCode === 13 || e.keyCode === 32) {
                    e.preventDefault();
                    handleAccordionClick($(this), $wrapper, allowMultiple);
                }
            });
            
            // Mark as initialized
            $wrapper.addClass('acf-accordion-initialized');
        });
    }
    
    /**
     * Handle accordion click/keyboard interaction with smooth animations
     * @param {jQuery} $title - The clicked title element
     * @param {jQuery} $wrapper - The accordion wrapper
     * @param {boolean} allowMultiple - Whether multiple items can be open
     */
    function handleAccordionClick($title, $wrapper, allowMultiple) {
        var $item = $title.closest('.acf-accordion-item');
        var isActive = $item.hasClass('active');
        
        // Close all items if multiple is not allowed
        if (!allowMultiple && !isActive) {
            $wrapper.find('.acf-accordion-item.active').each(function() {
                var $otherItem = $(this);
                if ($otherItem[0] !== $item[0]) {
                    closeAccordionItem($otherItem);
                }
            });
        }
        
        // Toggle current item with smooth animations
        if (isActive) {
            closeAccordionItem($item);
        } else {
            openAccordionItem($item);
        }
    }
    
    /**
     * Open accordion item with smooth animation
     * @param {jQuery} $item - The accordion item to open
     */
    function openAccordionItem($item) {
        var $title = $item.find('.acf-accordion-title');
        var $content = $item.find('.acf-accordion-content');
        var $icon = $title.find('.acf-accordion-icon');
        
        $item.addClass('active');
        $title.attr('aria-expanded', 'true');
        
        // Handle icon animation based on type
        if ($icon.hasClass('acf-accordion-icon-left') || $icon.hasClass('acf-accordion-icon-right')) {
            // New icon system - CSS handles the transition
            // No additional JavaScript needed
        } else {
            // Legacy icon rotation
            $icon.css({
                'transition': 'transform ' + accordionConfig.iconRotationDuration + 'ms ease-in-out',
                'transform': 'rotate(180deg)'
            });
        }
        
        // Smooth slide down animation with custom easing
        $content.stop(true, true).slideDown({
            duration: accordionConfig.animationDuration,
            easing: accordionConfig.animationEasing,
            start: function() {
                // Add opening class for additional CSS animations
                $item.addClass('acf-accordion-opening');
            },
            complete: function() {
                $item.removeClass('acf-accordion-opening');
                // Trigger custom event after animation completes
                $item.trigger('acf-accordion:opened');
            }
        });
    }
    
    /**
     * Close accordion item with smooth animation
     * @param {jQuery} $item - The accordion item to close
     */
    function closeAccordionItem($item) {
        var $title = $item.find('.acf-accordion-title');
        var $content = $item.find('.acf-accordion-content');
        var $icon = $title.find('.acf-accordion-icon');
        
        $title.attr('aria-expanded', 'false');
        
        // Handle icon animation based on type
        if ($icon.hasClass('acf-accordion-icon-left') || $icon.hasClass('acf-accordion-icon-right')) {
            // New icon system - CSS handles the transition
            // No additional JavaScript needed
        } else {
            // Legacy icon rotation back to original position
            $icon.css({
                'transition': 'transform ' + accordionConfig.iconRotationDuration + 'ms ease-in-out',
                'transform': 'rotate(0deg)'
            });
        }
        
        // Smooth slide up animation with custom easing
        $content.stop(true, true).slideUp({
            duration: accordionConfig.animationDuration,
            easing: accordionConfig.animationEasing,
            start: function() {
                // Add closing class for additional CSS animations
                $item.addClass('acf-accordion-closing');
            },
            complete: function() {
                $item.removeClass('active acf-accordion-closing');
                // Trigger custom event after animation completes
                $item.trigger('acf-accordion:closed');
            }
        });
    }
    
    /**
     * Public API methods
     */
    window.ACFAccordion = {
        /**
         * Configure animation settings
         * @param {Object} config - Animation configuration
         */
        configure: function(config) {
            if (config.animationDuration) {
                accordionConfig.animationDuration = config.animationDuration;
            }
            if (config.animationEasing) {
                accordionConfig.animationEasing = config.animationEasing;
            }
            if (config.iconRotationDuration) {
                accordionConfig.iconRotationDuration = config.iconRotationDuration;
            }
        },
        
        /**
         * Get current configuration
         * @return {Object} Current animation configuration
         */
        getConfig: function() {
            return accordionConfig;
        },
        
        /**
         * Open specific accordion item
         * @param {string|jQuery} target - Selector or jQuery object
         */
        open: function(target) {
            var $item = $(target).closest('.acf-accordion-item');
            if ($item.length && !$item.hasClass('active')) {
                openAccordionItem($item);
            }
        },
        
        /**
         * Close specific accordion item
         * @param {string|jQuery} target - Selector or jQuery object
         */
        close: function(target) {
            var $item = $(target).closest('.acf-accordion-item');
            if ($item.length && $item.hasClass('active')) {
                closeAccordionItem($item);
            }
        },
        
        /**
         * Toggle specific accordion item
         * @param {string|jQuery} target - Selector or jQuery object
         */
        toggle: function(target) {
            var $item = $(target).closest('.acf-accordion-item');
            if ($item.length) {
                var $title = $item.find('.acf-accordion-title');
                var $wrapper = $item.closest('.acf-accordion-wrapper');
                var allowMultiple = $wrapper.data('multiple') === true || $wrapper.data('multiple') === 'true';
                handleAccordionClick($title, $wrapper, allowMultiple);
            }
        },
        
        /**
         * Open all accordion items (only works if multiple is allowed)
         * @param {string|jQuery} wrapper - Wrapper selector or jQuery object
         */
        openAll: function(wrapper) {
            var $wrapper = $(wrapper);
            var allowMultiple = $wrapper.data('multiple') === true || $wrapper.data('multiple') === 'true';
            
            if (allowMultiple) {
                $wrapper.find('.acf-accordion-item').each(function() {
                    var $item = $(this);
                    if (!$item.hasClass('active')) {
                        openAccordionItem($item);
                    }
                });
            }
        },
        
        /**
         * Close all accordion items
         * @param {string|jQuery} wrapper - Wrapper selector or jQuery object
         */
        closeAll: function(wrapper) {
            var $wrapper = $(wrapper);
            $wrapper.find('.acf-accordion-item.active').each(function() {
                closeAccordionItem($(this));
            });
        }
    };
    
})(jQuery);
