# ACF/SCF Accordion for Elementor

A WordPress plugin that allows you to display data from ACF (Advanced Custom Fields) or SCF (Secure Custom Fields) Repeater in accordion format using an Elementor widget.

## Description

This plugin provides a custom Elementor widget that can retrieve data from ACF or SCF Repeater fields and display it in a responsive and customizable accordion format.

## Features

- ✅ Full integration with ACF and SCF Repeater fields
- ✅ Easy-to-use Elementor widget
- ✅ Customizable styling through Elementor
- ✅ Option to open the first item by default
- ✅ Option to allow multiple items to be open simultaneously
- ✅ Responsive and mobile-friendly
- ✅ Accessibility support (keyboard navigation, ARIA attributes)
- ✅ Smooth and modern animations with jQuery
- ✅ Custom easing functions for smooth animations
- ✅ Customizable icons (different collapse/expand icons)
- ✅ Icon positioning (left/right)
- ✅ Customizable border radius for titles
- ✅ Smooth icon transitions and hover effects
- ✅ Customizable icon color states (normal, hover, active)
- ✅ Support for specific post IDs
- ✅ JavaScript API for programmatic control
- ✅ Support for ACF and SCF (Secure Custom Fields)
- ✅ Customizable animation configuration

## System Requirements

- WordPress 5.0 or newer
- PHP 7.4 or newer
- Elementor 3.0.0 or newer
- Advanced Custom Fields (ACF) plugin OR Secure Custom Fields (SCF) plugin

## Installation

1. Upload the plugin folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress admin
3. Make sure Elementor and ACF/SCF are installed and active

## How to Use

### 1. Setup Repeater Field (ACF or SCF)

**For ACF:**
Create an ACF Field Group with a Repeater field containing:
- Sub field for title (text field)
- Sub field for content (textarea/wysiwyg field)

**For SCF:**
Create an SCF Field Group with a Repeater field containing:
- Sub field for title (text field)  
- Sub field for content (textarea/wysiwyg field)

Example structure:
```
Field Group: FAQ
- Field Type: Repeater
- Field Name: accordion_items
  Sub Fields:
  - title (Text)
  - content (Textarea/WYSIWYG)
```

### 2. Using the Widget in Elementor

1. Edit a page with Elementor
2. Search for the "ACF/SCF Accordion" widget in the widgets panel
3. Drag the widget to the desired area
4. Configure settings:
   - **Repeater Field Name**: Name of the ACF/SCF repeater field (example: `accordion_items`)
   - **Title Sub Field Name**: Name of the sub field for the title (example: `title`)
   - **Content Sub Field Name**: Name of the sub field for the content (example: `content`)
   - **Post ID**: Leave empty for the current post, or enter a specific post ID
   - **Open First Item**: Enable to open the first item by default
   - **Allow Multiple Open**: Enable to allow multiple items to be open simultaneously
   
5. Configure Icons:
   - **Collapse Icon**: Choose an icon for the closed state (default: chevron-down)
   - **Expand Icon**: Choose an icon for the open state (default: chevron-up)  
   - **Icon Position**: Choose the icon position (left or right)

### 3. Styling

The widget provides various styling options through Elementor:

#### Accordion Settings
- Spacing between items
- Borders and border radius
- Box shadow

#### Title Settings
- Typography
- Colors (normal, hover, active)
- Background color
- Padding
- Border radius

#### Content Settings
- Typography
- Text and background colors
- Padding
- Border

#### Icon Settings
- **Collapse Icon**: Icon displayed when accordion is closed
- **Expand Icon**: Icon displayed when accordion is open
- **Icon Position**: Icon position (left or right of the title)
- Icon size
- Icon colors with different states:
  - **Normal**: Icon color in default condition
  - **Hover**: Icon color on hover
  - **Active**: Icon color when accordion is open
- Distance from text

## JavaScript API

The plugin provides a JavaScript API for programmatic control:

```javascript
// Configure animations
ACFAccordion.configure({
    animationDuration: 500,        // Duration of slide animation (ms)
    animationEasing: 'easeInOutQuart',  // Type of easing
    iconRotationDuration: 300      // Duration of icon rotation (ms)
});

// Get current configuration
var config = ACFAccordion.getConfig();

// Open a specific accordion item
ACFAccordion.open('.acf-accordion-item:first');

// Close a specific accordion item
ACFAccordion.close('.acf-accordion-item:first');

// Toggle accordion item
ACFAccordion.toggle('.acf-accordion-item:first');

// Open all items (only if multiple is enabled)
ACFAccordion.openAll('.acf-accordion-wrapper');

// Close all items
ACFAccordion.closeAll('.acf-accordion-wrapper');
```

### Animation Customization

The plugin uses smooth jQuery animations with custom easing. You can customize:

```javascript
// Example of faster animation configuration
ACFAccordion.configure({
    animationDuration: 250,
    iconRotationDuration: 200
});

// Example of slower and smoother animation configuration
ACFAccordion.configure({
    animationDuration: 600,
    animationEasing: 'easeInOutQuart',
    iconRotationDuration: 400
});
```

## Events

The widget triggers custom events that can be listened to:

```javascript
$('.acf-accordion-item').on('acf-accordion:opened', function() {
    console.log('Accordion item opened');
});

$('.acf-accordion-item').on('acf-accordion:closed', function() {
    console.log('Accordion item closed');
});
```

## Troubleshooting

### Widget doesn't appear in Elementor
- Make sure the plugin is active
- Make sure Elementor and ACF are installed and active
- Check the required minimum versions

### Data doesn't appear
- Make sure the ACF field name is correct
- Make sure ACF data has been saved for the intended post/page
- Check if the Post ID is correct (leave empty for current post)

### Styling issues
- Use custom CSS if needed
- Check if the theme doesn't override styling
- Use browser inspector for CSS debugging

## Hooks and Filters

The plugin provides several hooks for developers:

```php
// Filter to modify accordion data before display
add_filter('acf_accordion_items', function($items, $settings) {
    // Modify $items as needed
    return $items;
}, 10, 2);

// Action after accordion is rendered
add_action('acf_accordion_after_render', function($settings) {
    // Additional code after rendering
});
```

## Changelog

### 1.1.5
- Fixed translation issues
- Improved internationalization support
- Enhanced compatibility with latest WordPress version
- Minor code optimizations
- Performance improvements

### 1.1.0
- Added customizable border options for accordion title
- Added customizable border options for accordion content
- Enhanced border radius controls for content section
- Added box shadow controls for content section
- Improved animations to respect border settings during transitions
- Fixed CSS display issues during accordion open/close transitions

### 1.0.0
- Initial release
- Basic ACF Accordion widget
- Elementor styling and controls
- JavaScript API
- Accessibility support

## Support

For questions or assistance, please:
1. Create an issue in the GitHub repository
2. Contact the developer via email
3. Check the WordPress.org documentation

## Contribution

Contributions are very welcome! Please:
1. Fork the repository
2. Create a branch for new features
3. Submit a pull request

## License

GPL v2 or later. See [LICENSE](LICENSE) for full details.

## Credits

Developed with ❤️ using:
- [WordPress](https://wordpress.org/)
- [Elementor](https://elementor.com/)
- [Advanced Custom Fields](https://www.advancedcustomfields.com/)
