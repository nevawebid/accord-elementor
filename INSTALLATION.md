# Installation and Setup of ACF/SCF Accordion for Elementor Plugin

## Installation Guide

### 1. Upload Plugin

1. Download or clone this repository
2. Upload the `accordion-acf-elementor` folder to the `/wp-content/plugins/` directory
3. Or zip the folder and upload through WordPress admin: **Plugins** → **Add New** → **Upload Plugin**

### 2. Activate Plugin

1. Log in to WordPress Admin
2. Go to **Plugins** → **Installed Plugins**
3. Find "ACF/SCF Accordion for Elementor"
4. Click **Activate**

### 3. Verify Dependencies

The plugin will automatically check required dependencies:

- ✅ **Elementor** (version 3.0.0+)
- ✅ **Advanced Custom Fields (ACF)** OR **Secure Custom Fields (SCF)**

If any dependency is missing, a notice will appear in the admin.

## Setup Custom Fields

### Option 1: ACF Field Setup

#### 1. Create New Field Group

1. Go to **Custom Fields** → **Field Groups**
2. Click **Add New**
3. Name it: "Accordion FAQ" (or as needed)

#### 2. Add Repeater Field

1. Click **Add Field**
2. **Field Label**: Accordion Items
3. **Field Name**: `accordion_items` 
4. **Field Type**: Repeater

#### 3. Add Sub Fields

Inside the Repeater, add 2 sub fields:

**Sub Field 1 - Title:**
- **Field Label**: Title
- **Field Name**: `title`
- **Field Type**: Text

**Sub Field 2 - Content:**
- **Field Label**: Content  
- **Field Name**: `content`
- **Field Type**: Textarea or WYSIWYG Editor

### Option 2: SCF Field Setup

#### 1. Install SCF Plugin

1. Go to **Plugins** → **Add New**
2. Search for "Secure Custom Fields"
3. Install and activate the plugin

#### 2. Create New Field Group

1. Go to **SCF** → **Field Groups**
2. Click **Add New**
3. Name it: "Accordion FAQ"

#### 3. Add Repeater Field

1. Click **Add Field**
2. **Field Label**: Accordion Items
3. **Field Name**: `accordion_items`
4. **Field Type**: Repeater

#### 4. Add Sub Fields

Inside the Repeater, add 2 sub fields:

**Sub Field 1 - Title:**
- **Field Label**: Title
- **Field Name**: `title`
- **Field Type**: Text

**Sub Field 2 - Content:**
- **Field Label**: Content
- **Field Name**: `content`
- **Field Type**: Textarea

### 4. Set Location Rules (ACF & SCF)

Choose where this field will appear:
- **Post Type** is equal to **Page**
- Or **Post Type** is equal to **Post**
- Or as needed

### 5. Save Field Group

Click **Publish** to save.

## Using the Widget in Elementor

### 1. Edit Page with Elementor

1. Create or edit a page/post
2. Click **Edit with Elementor**

### 2. Add Widget

1. In the left panel, search for the **"ACF/SCF Accordion"** widget
2. Drag it to the desired area

### 3. Configure Widget

**Content Tab:**
- **Repeater Field Name**: `accordion_items`
- **Title Sub Field Name**: `title`  
- **Content Sub Field Name**: `content`
- **Post ID**: Leave empty (for current post)
- **Open First Item**: Toggle as needed
- **Allow Multiple Open**: Toggle as needed

**Style Tab:**
- Adjust styling for accordion, title, content, and icon
- Everything can be customized through Elementor

### 4. Preview and Publish

1. Click **Preview** to see the result
2. If it looks good, click **Publish**

## Example Data

For testing, fill the field data like this:

**Item 1:**
- Title: "What is WordPress?"
- Content: "WordPress is a popular content management system (CMS) for creating websites."

**Item 2:**  
- Title: "How to install plugins?"
- Content: "You can install plugins through the WordPress admin in the Plugins > Add New menu."

**Item 3:**
- Title: "What are the benefits of using Elementor?"
- Content: "Elementor allows you to create pages with drag & drop without coding."

## Usage Tips

### Plugin Compatibility
- This plugin is compatible with ACF Free, ACF Pro, and SCF
- Automatically detects which plugin is active
- Uses appropriate functions to retrieve data

### Multiple Accordions on One Page

You can add multiple accordion widgets on a single page with different fields.

### Custom Post Types

The widget can be used for custom post types, make sure the ACF field is assigned to that post type.

### Advanced Styling

Use **Additional CSS** in Customizer or child theme for more specific styling:

```css
/* Custom styling for accordion */
.my-custom-accordion .acf-accordion-title {
    background: #your-color;
}
```

### Using with PHP

You can also display accordions programmatically:

```php
// In template file
if (function_exists('get_field')) {
    $accordion_items = get_field('accordion_items');
    // Manual render or use shortcode
}
```

## Troubleshooting

### Widget doesn't appear
- Make sure Elementor and ACF are active
- Clear Elementor cache
- Refresh the editor page

### Data doesn't display
- Check if field names are correct (ACF/SCF)
- Ensure data has been saved in the post/page
- Check Post ID if using a specific ID
- Make sure the custom fields plugin (ACF/SCF) is active

### Styling issues
- Check if the theme is not overriding CSS
- Use browser inspector for debugging
- Add `!important` if necessary

## Support

If you experience issues:
1. Check versions of WordPress, Elementor, and ACF/SCF
2. Test with default theme (Twenty Twenty-Three)
3. Disable other plugins to test for conflicts
4. Make sure only one custom fields plugin is active (ACF or SCF)
5. Contact the developer if issues persist
