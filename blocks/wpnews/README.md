# WordPress News Block for Moodle 4.5

A Moodle block plugin that displays news posts from a WordPress site using the WordPress REST API v2.

## Features

- 🔌 Connect to any WordPress site via REST API
- 📰 Display latest posts with customizable options
- 🖼️ Show featured images in multiple sizes
- 📱 Responsive design (list or grid layout)
- 🎨 **Specially optimized for RemUI theme** with automatic style detection
- 💾 Built-in caching system for performance
- 🔐 Support for authentication (private WordPress sites)
- 🌍 Multilingual support (English & Spanish)
- ⚙️ Per-instance configuration
- 🎯 Multiple instances support
- 🎭 Mustache templates for flexible rendering
- 🌙 Dark mode support (RemUI compatible)

## Requirements

- Moodle 4.5 or higher
- PHP 8.0 or higher
- WordPress site with REST API v2 enabled
- cURL extension enabled in PHP

## Installation

### Method 1: Manual Installation

1. Download the plugin or clone this repository
2. Extract/copy the `wpnews` folder to `[moodle-root]/blocks/`
3. Log in to your Moodle site as an administrator
4. Navigate to **Site administration > Notifications**
5. Click "Upgrade Moodle database now"
6. The plugin will be installed automatically

### Method 2: Via Moodle Plugin Installer

1. Go to **Site administration > Plugins > Install plugins**
2. Upload the plugin ZIP file
3. Follow the on-screen instructions

## Configuration

### WordPress Site Setup

1. Ensure your WordPress REST API is enabled (enabled by default in WordPress 4.7+)
2. Test your API by visiting: `https://your-wordpress-site.com/wp-json/wp/v2/posts`
3. If your WordPress site is private, create an Application Password:
   - In WordPress admin, go to **Users > Your Profile**
   - Scroll to **Application Passwords**
   - Create a new application password for Moodle

### Global Plugin Settings

1. Go to **Site administration > Plugins > Blocks > WordPress News**
2. Configure default settings:
   - Default cache time (minutes)
   - Default number of posts
   - Default layout
   - Connection timeout
   - Debug mode (for troubleshooting)

### Block Instance Configuration

1. Turn editing on in your Moodle page
2. Add the **WordPress News** block
3. Click the configuration icon (gear) on the block
4. Configure the following options:

#### Basic Settings
- **Block title**: Custom title for the block
- **WordPress URL**: Full URL of your WordPress site (required)
- **Number of posts**: How many posts to display (1-20)

#### Display Options
- **Layout**: List or Grid view
- **Show featured image**: Toggle image display
- **Image size**: Thumbnail, Medium, Large, or Full
- **Show excerpt**: Display post excerpt
- **Show date**: Display publication date
- **Date format**: PHP date format string (e.g., "F j, Y")
- **Show categories**: Display post categories as badges

#### Authentication (Optional)
- **Username**: WordPress username
- **Password**: WordPress application password

#### Cache Options
- **Cache duration**: How long to cache posts (in minutes)

## Usage Examples

### Example 1: News Feed on Homepage

1. Go to your Moodle site homepage
2. Turn editing on
3. Add the **WordPress News** block
4. Configure with your WordPress URL
5. Set to show 5 posts in list layout

### Example 2: Multiple WordPress Sources

You can add multiple instances of the block to display posts from different WordPress sites:

1. Add first block for main news site
2. Add second block for announcements blog
3. Configure each with different URLs and display settings

### Example 3: Private WordPress Site

If your WordPress site requires authentication:

1. Create an Application Password in WordPress
2. In block settings, enter your WordPress username
3. Enter the application password
4. Test the connection

## Troubleshooting

### "WordPress REST API endpoint not found"

**Solution:**
- Verify the WordPress URL is correct
- Check if REST API is enabled: visit `https://your-site.com/wp-json/wp/v2/posts`
- Some security plugins may disable REST API - check your WordPress plugins

### "Authentication failed"

**Solution:**
- Use Application Passwords, not your regular WordPress password
- Verify username is correct
- Check if your WordPress site allows API authentication

### "Connection timeout"

**Solution:**
- Increase timeout in global settings
- Check if your Moodle server can reach the WordPress site
- Verify firewall rules

### "cURL error"

**Solution:**
- Ensure PHP cURL extension is installed and enabled
- Check SSL certificate validity
- Try accessing the WordPress site from your server using cURL command line

### No posts displayed

**Solution:**
- Verify WordPress has published posts
- Check cache settings - try clearing cache
- Enable debug mode in global settings and check logs
- Verify you have permission to view content

## Cache Management

The block uses Moodle's cache system for performance:

- **Automatic caching**: Posts are cached based on the configured duration
- **Clear specific cache**: Re-configure the block to refresh its cache
- **Clear all caches**: Go to **Site administration > Development > Purge caches**

## Permissions

The plugin defines three capabilities:

- `block/wpnews:addinstance` - Add block to course pages (teachers, managers)
- `block/wpnews:myaddinstance` - Add block to My Moodle (users)
- `block/wpnews:viewcontent` - View block content (all users)

## 🎨 RemUI Theme Integration

This block is **specially optimized for Edwiser RemUI theme** with:

- ✅ Automatic detection and loading of RemUI-specific styles
- ✅ Uses RemUI color variables (`--primary`, `--primary-dark`)
- ✅ Dark mode support compatible with RemUI
- ✅ Modern card designs with RemUI aesthetics
- ✅ Responsive layouts optimized for RemUI regions
- ✅ Mustache templates for better rendering

### How to Use with RemUI

1. **Add the block** to your page (Turn editing on → Add block → WordPress News)
2. **Configure** with your WordPress URL
3. **Enjoy** automatic RemUI styling - no additional configuration needed!

**📖 For detailed RemUI integration guide, see [REMUI_INTEGRATION.md](REMUI_INTEGRATION.md)**

### Does it appear in Edwiser Page Builder?

**No**, this is a standard Moodle block, not a Page Builder widget. However:
- ✅ It works perfectly in all RemUI regions
- ✅ Has beautiful RemUI-optimized styling
- ✅ Can be added to home page, dashboard, courses, etc.
- 📖 See [REMUI_INTEGRATION.md](REMUI_INTEGRATION.md) for creating a custom widget (advanced)

## Styling and Customization

### Custom CSS

Add custom CSS in **Site administration > Appearance > Additional HTML** (or RemUI Custom CSS):

```css
/* Example: Change card background */
.wpnews-item {
    background: #f0f0f0;
}

/* Example: Larger titles */
.wpnews-item .card-title {
    font-size: 1.3rem;
}

/* Example: Use your brand colors */
.block_wpnews .wpnews-readmore {
    background: linear-gradient(135deg, #your-color 0%, #your-color-dark 100%);
}
```

### RemUI-Specific Customization

The plugin automatically loads `styles_remui.css` when RemUI theme is detected. This includes:
- Modern card designs
- Smooth animations
- Glassmorphism effects
- Dark mode support
- RemUI color integration

## File Structure

```
blocks/wpnews/
├── version.php              # Plugin version and metadata
├── block_wpnews.php         # Main block class
├── edit_form.php           # Instance configuration form
├── settings.php            # Global settings
├── styles.css              # Standard block styles
├── styles_remui.css        # RemUI-optimized styles (auto-loaded)
├── README.md               # Main documentation
├── REMUI_INTEGRATION.md    # RemUI integration guide
├── lang/
│   ├── en/
│   │   └── block_wpnews.php # English strings
│   └── es/
│       └── block_wpnews.php # Spanish strings
├── templates/              # Mustache templates
│   ├── news_item.mustache       # Single news item template
│   └── news_container.mustache  # Container template
├── classes/
│   ├── api/
│   │   └── wordpress_client.php  # WordPress API client
│   ├── cache/
│   │   └── cache_handler.php     # Cache management
│   ├── output/
│   │   ├── renderer.php          # Renderer class
│   │   └── news_item.php         # News item renderable
│   └── privacy/
│       └── provider.php          # Privacy API implementation
├── db/
│   ├── access.php          # Capability definitions
│   └── caches.php          # Cache definitions
├── amd/src/                # JavaScript (future use)
└── pix/
    └── icon.svg            # Block icon
```

## API Reference

### WordPress REST API Endpoints Used

- `GET /wp-json/wp/v2/posts` - Fetch posts
- Parameter `_embed=true` - Include featured images and categories
- Parameter `per_page` - Number of posts to fetch

### Expected WordPress Post Structure

```json
{
  "id": 123,
  "title": { "rendered": "Post Title" },
  "link": "https://example.com/post",
  "date": "2024-01-15T10:30:00",
  "excerpt": { "rendered": "<p>Post excerpt...</p>" },
  "_embedded": {
    "wp:featuredmedia": [...],
    "wp:term": [...]
  }
}
```

## Future Enhancements

The plugin architecture supports future extensions:

- Abstract base class for external content sources
- Ready to add calendar integration when API is available
- AJAX refresh without page reload
- Advanced filtering (by category, tag, author)
- Custom templates via Mustache

## Development

### Coding Standards

This plugin follows:
- Moodle Coding Style
- PHPDoc documentation standards
- Moodle plugin guidelines

### Testing

Test the plugin with:
- Different WordPress versions (5.0+)
- Various post types and formats
- Multiple concurrent instances
- Cache functionality
- Authentication scenarios

## Support

For issues, questions, or contributions:

1. Check the troubleshooting section
2. Enable debug mode and check Moodle logs
3. Verify WordPress REST API is accessible
4. Test with different cache settings

## License

This plugin is licensed under the GNU General Public License v3.0 or later.

## Credits

- **Author**: Your Name
- **Copyright**: 2024
- **Moodle Version**: 4.5+
- **Compatible Themes**: RemUI, Boost, and most standard themes

## Changelog

### Version 1.1.0 (2024-11-17)
- ✨ Enhanced RemUI theme integration
- ✨ Added Mustache templates for better rendering
- ✨ RemUI-specific CSS with auto-detection
- ✨ Dark mode support for RemUI
- ✨ Modern card designs with animations
- ✨ Comprehensive RemUI integration documentation
- 🎨 Improved responsive layouts
- 🎨 Better typography and spacing
- 📖 Added REMUI_INTEGRATION.md guide

### Version 1.0.0 (2024-11-17)
- Initial release
- WordPress REST API v2 integration
- Configurable display options
- Caching system
- Authentication support
- Basic RemUI theme compatibility
- English and Spanish translations

---

**Note**: This plugin only displays data from WordPress and does not store any personal information. See privacy documentation for details.
