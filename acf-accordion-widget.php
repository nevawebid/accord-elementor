<?php
/**
 * ACF/SCF Accordion Widget untuk Elementor
 * Widget ini mengambil data dari ACF atau SCF Repeater field dan menampilkannya dalam format accordion
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class ACF_Accordion_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'acf_accordion';
    }

    public function get_title() {
        return esc_html__('ACF/SCF Accordion', 'textdomain');
    }

    public function get_icon() {
        return 'eicon-accordion';
    }

    public function get_categories() {
        return ['general'];
    }

    public function get_keywords() {
        return ['accordion', 'acf', 'scf', 'repeater', 'faq', 'toggle', 'secure custom fields'];
    }

    protected function register_controls() {

        // Content Section
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Content', 'textdomain'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'acf_repeater_field',
            [
                'label' => esc_html__('Repeater Field Name', 'textdomain'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'accordion_items',
                'placeholder' => esc_html__('Enter repeater field name', 'textdomain'),
                'description' => esc_html__('Masukkan nama field Repeater dari ACF atau SCF yang berisi data accordion', 'textdomain'),
            ]
        );

        $this->add_control(
            'title_field',
            [
                'label' => esc_html__('Title Sub Field Name', 'textdomain'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'title',
                'placeholder' => esc_html__('Enter title sub field name', 'textdomain'),
                'description' => esc_html__('Nama sub field untuk judul accordion', 'textdomain'),
            ]
        );

        $this->add_control(
            'content_field',
            [
                'label' => esc_html__('Content Sub Field Name', 'textdomain'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'content',
                'placeholder' => esc_html__('Enter content sub field name', 'textdomain'),
                'description' => esc_html__('Nama sub field untuk konten accordion', 'textdomain'),
            ]
        );

        $this->add_control(
            'post_id',
            [
                'label' => esc_html__('Post ID (Optional)', 'textdomain'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__('Leave empty for current post', 'textdomain'),
                'description' => esc_html__('Kosongkan untuk menggunakan post saat ini, atau masukkan ID post tertentu', 'textdomain'),
            ]
        );

        $this->add_control(
            'first_item_open',
            [
                'label' => esc_html__('Open First Item', 'textdomain'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'textdomain'),
                'label_off' => esc_html__('No', 'textdomain'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $this->add_control(
            'multiple_open',
            [
                'label' => esc_html__('Allow Multiple Open', 'textdomain'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'textdomain'),
                'label_off' => esc_html__('No', 'textdomain'),
                'return_value' => 'yes',
                'default' => 'no',
                'description' => esc_html__('Izinkan beberapa item accordion terbuka bersamaan', 'textdomain'),
            ]
        );

        $this->end_controls_section();

        // Icon Section
        $this->start_controls_section(
            'icon_section',
            [
                'label' => esc_html__('Icons', 'textdomain'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'collapse_icon',
            [
                'label' => esc_html__('Collapse Icon', 'textdomain'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'eicon-chevron-down',
                    'library' => 'eicons',
                ],
                'description' => esc_html__('Icon yang ditampilkan saat accordion tertutup', 'textdomain'),
            ]
        );

        $this->add_control(
            'expand_icon',
            [
                'label' => esc_html__('Expand Icon', 'textdomain'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'eicon-chevron-up',
                    'library' => 'eicons',
                ],
                'description' => esc_html__('Icon yang ditampilkan saat accordion terbuka', 'textdomain'),
            ]
        );

        $this->add_control(
            'icon_position',
            [
                'label' => esc_html__('Icon Position', 'textdomain'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'right',
                'options' => [
                    'left' => esc_html__('Left', 'textdomain'),
                    'right' => esc_html__('Right', 'textdomain'),
                ],
            ]
        );

        $this->end_controls_section();

        // Style Section - Accordion
        $this->start_controls_section(
            'accordion_style',
            [
                'label' => esc_html__('Accordion', 'textdomain'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'accordion_spacing',
            [
                'label' => esc_html__('Spacing Between Items', 'textdomain'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .acf-accordion-item + .acf-accordion-item' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'accordion_border',
                'selector' => '{{WRAPPER}} .acf-accordion-item',
            ]
        );

        $this->add_responsive_control(
            'accordion_border_radius',
            [
                'label' => esc_html__('Border Radius', 'textdomain'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .acf-accordion-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'accordion_box_shadow',
                'selector' => '{{WRAPPER}} .acf-accordion-item',
            ]
        );

        $this->end_controls_section();

        // Style Section - Title
        $this->start_controls_section(
            'title_style',
            [
                'label' => esc_html__('Title', 'textdomain'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .acf-accordion-title',
            ]
        );

        $this->start_controls_tabs('title_style_tabs');

        $this->start_controls_tab(
            'title_normal_tab',
            [
                'label' => esc_html__('Normal', 'textdomain'),
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Color', 'textdomain'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .acf-accordion-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'title_background_color',
            [
                'label' => esc_html__('Background Color', 'textdomain'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .acf-accordion-title' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'title_hover_tab',
            [
                'label' => esc_html__('Hover', 'textdomain'),
            ]
        );

        $this->add_control(
            'title_hover_color',
            [
                'label' => esc_html__('Color', 'textdomain'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .acf-accordion-title:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'title_hover_background_color',
            [
                'label' => esc_html__('Background Color', 'textdomain'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .acf-accordion-title:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'title_active_tab',
            [
                'label' => esc_html__('Active', 'textdomain'),
            ]
        );

        $this->add_control(
            'title_active_color',
            [
                'label' => esc_html__('Color', 'textdomain'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .acf-accordion-item.active .acf-accordion-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'title_active_background_color',
            [
                'label' => esc_html__('Background Color', 'textdomain'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .acf-accordion-item.active .acf-accordion-title' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'title_padding',
            [
                'label' => esc_html__('Padding', 'textdomain'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .acf-accordion-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'title_border_radius',
            [
                'label' => esc_html__('Border Radius', 'textdomain'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .acf-accordion-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Style Section - Content
        $this->start_controls_section(
            'content_style',
            [
                'label' => esc_html__('Content', 'textdomain'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'content_typography',
                'selector' => '{{WRAPPER}} .acf-accordion-content',
            ]
        );

        $this->add_control(
            'content_color',
            [
                'label' => esc_html__('Color', 'textdomain'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .acf-accordion-content' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'content_background_color',
            [
                'label' => esc_html__('Background Color', 'textdomain'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .acf-accordion-content' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'content_padding',
            [
                'label' => esc_html__('Padding', 'textdomain'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .acf-accordion-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'content_border',
                'selector' => '{{WRAPPER}} .acf-accordion-content',
            ]
        );

        $this->end_controls_section();

        // Style Section - Icon
        $this->start_controls_section(
            'icon_style',
            [
                'label' => esc_html__('Icon', 'textdomain'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'icon_size',
            [
                'label' => esc_html__('Size', 'textdomain'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 50,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 16,
                ],
                'selectors' => [
                    '{{WRAPPER}} .acf-accordion-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label' => esc_html__('Color', 'textdomain'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .acf-accordion-icon' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_spacing',
            [
                'label' => esc_html__('Spacing', 'textdomain'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 30,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .acf-accordion-icon' => 'margin-left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Get field value based on available plugin (ACF or SCF)
     * 
     * @param string $field_name
     * @param int $post_id
     * @return mixed
     */
    private function get_field_value($field_name, $post_id = null) {
        if (function_exists('get_field')) {
            // ACF method
            return get_field($field_name, $post_id);
        } elseif (function_exists('scf_get')) {
            // SCF method
            return scf_get($field_name, $post_id);
        }
        return false;
    }

    /**
     * Get available custom fields plugin name
     * 
     * @return string
     */
    private function get_active_cf_plugin() {
        if (function_exists('get_field')) {
            return 'ACF';
        } elseif (function_exists('scf_get')) {
            return 'SCF';
        }
        return 'Unknown';
    }

    /**
     * Render icon HTML
     * 
     * @param array $icon
     * @param string $class
     * @return string
     */
    private function render_icon($icon, $class = '') {
        if (empty($icon['value'])) {
            return '';
        }

        $icon_html = '';
        if ($icon['library'] === 'svg') {
            $icon_html = $icon['value']['url'] ? '<img src="' . esc_url($icon['value']['url']) . '" alt="" class="' . esc_attr($class) . '">' : '';
        } else {
            $icon_html = '<i class="' . esc_attr($icon['value']) . ' ' . esc_attr($class) . '" aria-hidden="true"></i>';
        }
        
        return $icon_html;
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        
        // Get ACF data
        $post_id = !empty($settings['post_id']) ? intval($settings['post_id']) : get_the_ID();
        $repeater_field = $settings['acf_repeater_field'];
        $title_field = $settings['title_field'];
        $content_field = $settings['content_field'];

        // Get icon settings
        $collapse_icon = $settings['collapse_icon'];
        $expand_icon = $settings['expand_icon'];
        $icon_position = $settings['icon_position'];

        // Check if ACF or SCF is active
        if (!function_exists('get_field') && !function_exists('scf_get')) {
            echo '<div class="acf-accordion-error">';
            echo esc_html__('Advanced Custom Fields (ACF) or Secure Custom Fields (SCF) plugin is required for this widget.', 'textdomain');
            echo '</div>';
            return;
        }

        // Get repeater data using helper function
        $accordion_items = $this->get_field_value($repeater_field, $post_id);

        if (!$accordion_items || !is_array($accordion_items)) {
            echo '<div class="acf-accordion-error">';
            echo esc_html__('No accordion items found or field name is incorrect. Make sure your repeater field contains data.', 'textdomain');
            echo '</div>';
            return;
        }

        $multiple_open = $settings['multiple_open'] === 'yes' ? 'true' : 'false';
        $first_item_open = $settings['first_item_open'] === 'yes';

        ?>
        <div class="acf-accordion-wrapper" data-multiple="<?php echo esc_attr($multiple_open); ?>" data-icon-position="<?php echo esc_attr($icon_position); ?>">
            <?php foreach ($accordion_items as $index => $item) : 
            // Handle different data structures for ACF vs SCF
            if (function_exists('get_field')) {
                // ACF format
                $title = isset($item[$title_field]) ? $item[$title_field] : '';
                $content = isset($item[$content_field]) ? $item[$content_field] : '';
            } else {
                // SCF format - may need adjustment based on SCF structure
                $title = isset($item[$title_field]) ? $item[$title_field] : '';
                $content = isset($item[$content_field]) ? $item[$content_field] : '';
            }
            
            if (empty($title) && empty($content)) continue;
            
            $is_active = ($first_item_open && $index === 0) ? 'active' : '';
        ?>
                <div class="acf-accordion-item <?php echo esc_attr($is_active); ?>">
                    <div class="acf-accordion-title" role="button" tabindex="0" aria-expanded="<?php echo $is_active ? 'true' : 'false'; ?>">
                        <?php if ($icon_position === 'left') : ?>
                            <span class="acf-accordion-icon acf-accordion-icon-left">
                                <span class="acf-accordion-icon-collapse"><?php echo $this->render_icon($collapse_icon, 'collapse-icon'); ?></span>
                                <span class="acf-accordion-icon-expand"><?php echo $this->render_icon($expand_icon, 'expand-icon'); ?></span>
                            </span>
                        <?php endif; ?>
                        
                        <span class="acf-accordion-title-text">
                            <?php echo wp_kses_post($title); ?>
                        </span>
                        
                        <?php if ($icon_position === 'right') : ?>
                            <span class="acf-accordion-icon acf-accordion-icon-right">
                                <span class="acf-accordion-icon-collapse"><?php echo $this->render_icon($collapse_icon, 'collapse-icon'); ?></span>
                                <span class="acf-accordion-icon-expand"><?php echo $this->render_icon($expand_icon, 'expand-icon'); ?></span>
                            </span>
                        <?php endif; ?>
                    </div>
                    <div class="acf-accordion-content" style="<?php echo !$is_active ? 'display: none;' : ''; ?>">
                        <?php echo wp_kses_post($content); ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php
    }

    protected function content_template() {
        ?>
        <#
        var multipleOpen = settings.multiple_open === 'yes' ? 'true' : 'false';
        var firstItemOpen = settings.first_item_open === 'yes';
        var iconPosition = settings.icon_position || 'right';
        var collapseIcon = settings.collapse_icon || {value: 'eicon-chevron-down', library: 'eicons'};
        var expandIcon = settings.expand_icon || {value: 'eicon-chevron-up', library: 'eicons'};
        #>
        <div class="acf-accordion-wrapper" data-multiple="{{{ multipleOpen }}}" data-icon-position="{{{ iconPosition }}}">
            <div class="acf-accordion-item <# if (firstItemOpen) { #>active<# } #>">
                <div class="acf-accordion-title" role="button" tabindex="0">
                    <# if (iconPosition === 'left') { #>
                        <span class="acf-accordion-icon acf-accordion-icon-left">
                            <span class="acf-accordion-icon-collapse"><i class="{{{ collapseIcon.value }}}" aria-hidden="true"></i></span>
                            <span class="acf-accordion-icon-expand"><i class="{{{ expandIcon.value }}}" aria-hidden="true"></i></span>
                        </span>
                    <# } #>
                    
                    <span class="acf-accordion-title-text">
                        Sample Accordion Title
                    </span>
                    
                    <# if (iconPosition === 'right') { #>
                        <span class="acf-accordion-icon acf-accordion-icon-right">
                            <span class="acf-accordion-icon-collapse"><i class="{{{ collapseIcon.value }}}" aria-hidden="true"></i></span>
                            <span class="acf-accordion-icon-expand"><i class="{{{ expandIcon.value }}}" aria-hidden="true"></i></span>
                        </span>
                    <# } #>
                </div>
                <div class="acf-accordion-content" <# if (!firstItemOpen) { #>style="display: none;"<# } #>>
                    Sample accordion content. This will be replaced with your ACF/SCF repeater data.
                </div>
            </div>
            <div class="acf-accordion-item">
                <div class="acf-accordion-title" role="button" tabindex="0">
                    <# if (iconPosition === 'left') { #>
                        <span class="acf-accordion-icon acf-accordion-icon-left">
                            <span class="acf-accordion-icon-collapse"><i class="{{{ collapseIcon.value }}}" aria-hidden="true"></i></span>
                            <span class="acf-accordion-icon-expand"><i class="{{{ expandIcon.value }}}" aria-hidden="true"></i></span>
                        </span>
                    <# } #>
                    
                    <span class="acf-accordion-title-text">
                        Another Accordion Item
                    </span>
                    
                    <# if (iconPosition === 'right') { #>
                        <span class="acf-accordion-icon acf-accordion-icon-right">
                            <span class="acf-accordion-icon-collapse"><i class="{{{ collapseIcon.value }}}" aria-hidden="true"></i></span>
                            <span class="acf-accordion-icon-expand"><i class="{{{ expandIcon.value }}}" aria-hidden="true"></i></span>
                        </span>
                    <# } #>
                </div>
                <div class="acf-accordion-content" style="display: none;">
                    Another sample content for demonstration.
                </div>
            </div>
        </div>
        <?php
    }
}

// Register the widget
function register_acf_accordion_widget( $widgets_manager ) {
    $widgets_manager->register( new \ACF_Accordion_Widget() );
}
add_action( 'elementor/widgets/register', 'register_acf_accordion_widget' );
?>