# quick-and-easy-faqs
The PHP code defines a custom post type and taxonomy for managing FAQs (Frequently Asked Questions) in WordPress and a shortcode to display FAQs on pages or posts using flexible parameters.

Detailed Documentation
1. Custom Post Type faq
Labels and Settings:

Defined using register_post_type() function with custom labels and settings.
Supports standard post features (title, editor, author).

Hierarchical structure enabled (hierarchical => true) for organizing FAQs.
User Interface:

Shown in WordPress admin menu (show_in_menu => true) with a custom icon (menu_icon => 'dashicons-format-chat`).
Accessible in navigation menus and admin bar.

REST API Integration:
Enabled (show_in_rest => true, rest_base => 'faq') for RESTful API interaction.
2. Custom Taxonomy faq-group
Labels and Settings:

Created using register_taxonomy() function with custom labels.
Hierarchical structure enabled (hierarchical => true) for categorizing FAQ entries.
Visibility and Integration:

Displayed in WordPress admin interface (show_ui => true) under the FAQ custom post type menu (show_in_menu => 'edit.php?post_type=faq').
Visible in admin columns (show_admin_column => true) and navigation menus.
REST API Integration:

Enabled (show_in_rest => true, rest_base => 'faq-group') for RESTful API integration.
3. Documentation Page
Admin Menu Integration:

Added as a submenu page (add_submenu_page()) under the FAQ post type.
Accessible to users with edit_posts capability.
Content:

Provides documentation for using the [faqs] shortcode with various parameters.
Lists available shortcode attributes and their functionalities.
4. Shortcode [faqs]
Functionality:

Renders FAQs using a shortcode.
Supports attributes (orderby, order, category, limit) to customize FAQ display.
Queries FAQs using WP_Query based on shortcode attributes.
Usage Examples:

[faqs]: Displays all FAQs in a simple list style.
[faqs limit="10"]: Limits FAQs displayed to 10 (default), with -1 displaying all FAQs.
[faqs order="ASC" orderby="title"]: Orders FAQs by ascending title.
[faqs order="DESC" orderby="title"]: Orders FAQs by descending title.
[faqs category="category_name"]: Filters FAQs by specified category.
