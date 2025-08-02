/**
 * ACF Accordion for Elementor - Frontend JavaScript
 * 
 * Script untuk menangani interaktivitas accordion
 */

(function($) {
    'use strict';
    
    // Animation configuration
    var accordionConfig = {
        animationDuration: 250,
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
            var $items = $wrapper.find('.acf-accordion-item');
            
            // Initialize icon states and content visibility
            $items.each(function() {
                var $item = $(this);
                var $title = $item.find('.acf-accordion-title');
                var $content = $item.find('.acf-accordion-content');
                var $collapseIcon = $title.find('.acf-accordion-icon-collapse');
                var $expandIcon = $title.find('.acf-accordion-icon-expand');
                
                // Store original padding for later restoration
                if (!$content.data('original-padding')) {
                    var originalPadding = $content.css('padding');
                    $content.data('original-padding', originalPadding);
                }
                
                if ($collapseIcon.length && $expandIcon.length) {
                    if ($item.hasClass('active')) {
                        // If item is active (open), show expand icon and hide collapse icon
                        $collapseIcon.hide();
                        $expandIcon.show();
                        // Ensure content is visible with normal properties
                        $content.css({
                            'display': 'block',
                            'height': 'auto',
                            'overflow': 'visible'
                        });
                    } else {
                        // If item is inactive (closed), show collapse icon and hide expand icon
                        $collapseIcon.show();
                        $expandIcon.hide();
                        // Set collapsed state properties
                        $content.css({
                            'display': 'none',
                            'height': '0',
                            'padding': '0',
                            'overflow': 'hidden'
                        });
                    }
                }
            });
            
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
        var $collapseIcon = $title.find('.acf-accordion-icon-collapse');
        var $expandIcon = $title.find('.acf-accordion-icon-expand');
        
        $item.addClass('active');
        $title.attr('aria-expanded', 'true');
        
        // Handle icon visibility for new icon system
        if ($collapseIcon.length && $expandIcon.length) {
            // Hide collapse icon and show expand icon when opened
            $collapseIcon.hide();
            $expandIcon.show();
        } else if ($icon.hasClass('acf-accordion-icon-left') || $icon.hasClass('acf-accordion-icon-right')) {
            // New icon system - CSS handles the transition
            // No additional JavaScript needed
        } else {
            // Legacy icon rotation
            $icon.css({
                'transition': 'transform ' + accordionConfig.iconRotationDuration + 'ms ease-in-out',
                'transform': 'rotate(180deg)'
            });
        }

        // Store original padding and height for restoration
        var originalPadding = $content.data('original-padding') || $content.css('padding');
        var originalHeight = $content.data('original-height') || 'auto';
        
        if (!$content.data('original-padding')) {
            $content.data('original-padding', originalPadding);
        }

        // Set up the content for animation
        $content.css({
            'display': 'block',
            'height': '0',
            'padding': '0',
            'overflow': 'hidden',
            'transition': 'height ' + accordionConfig.animationDuration + 'ms ease-in-out, padding ' + accordionConfig.animationDuration + 'ms ease-in-out'
        });

        // Get the natural height of the content
        var scrollHeight = $content[0].scrollHeight;

        // Add opening class for additional CSS animations
        $item.addClass('acf-accordion-opening');

        // Animate to full height and restore padding
        setTimeout(function() {
            $content.css({
                'height': scrollHeight + 'px',
                'padding': originalPadding
            });
        }, 10);

        // Clean up after animation
        setTimeout(function() {
            $content.css({
                'height': 'auto',
                'overflow': 'visible',
                'transition': ''
            });
            $item.removeClass('acf-accordion-opening');
            // Trigger custom event after animation completes
            $item.trigger('acf-accordion:opened');
        }, accordionConfig.animationDuration + 50);
    }    /**
     * Close accordion item with smooth animation
     * @param {jQuery} $item - The accordion item to close
     */
    function closeAccordionItem($item) {
        var $title = $item.find('.acf-accordion-title');
        var $content = $item.find('.acf-accordion-content');
        var $icon = $title.find('.acf-accordion-icon');
        var $collapseIcon = $title.find('.acf-accordion-icon-collapse');
        var $expandIcon = $title.find('.acf-accordion-icon-expand');
        
        $title.attr('aria-expanded', 'false');
        
        // Handle icon visibility for new icon system
        if ($collapseIcon.length && $expandIcon.length) {
            // Show collapse icon and hide expand icon when closed
            $collapseIcon.show();
            $expandIcon.hide();
        } else if ($icon.hasClass('acf-accordion-icon-left') || $icon.hasClass('acf-accordion-icon-right')) {
            // New icon system - CSS handles the transition
            // No additional JavaScript needed
        } else {
            // Legacy icon rotation back to original position
            $icon.css({
                'transition': 'transform ' + accordionConfig.iconRotationDuration + 'ms ease-in-out',
                'transform': 'rotate(0deg)'
            });
        }

        // Add closing class for additional CSS animations
        $item.addClass('acf-accordion-closing');

        // Get current height for smooth animation
        var currentHeight = $content[0].scrollHeight;

        // Set up transition
        $content.css({
            'height': currentHeight + 'px',
            'overflow': 'hidden',
            'transition': 'height ' + accordionConfig.animationDuration + 'ms ease-in-out, padding ' + accordionConfig.animationDuration + 'ms ease-in-out'
        });

        // Force reflow
        $content[0].offsetHeight;

        // Animate to collapsed state
        $content.css({
            'height': '0',
            'padding': '0'
        });

        // Clean up after animation
        setTimeout(function() {
            $item.removeClass('active acf-accordion-closing');
            $content.css({
                'display': 'none',
                'height': '',
                'padding': '',
                'overflow': '',
                'transition': ''
            });
            // Trigger custom event after animation completes
            $item.trigger('acf-accordion:closed');
        }, accordionConfig.animationDuration + 50);
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
