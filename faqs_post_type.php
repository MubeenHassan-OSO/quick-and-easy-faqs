<?php

function register_faq_post_type()
{
    $lable = array(
        'name'               => _x('FAQs', 'Post Type General Name', 'hello-elementor-child'),
        'singular_name'      => _x('FAQ', 'Post Type Singular Name', 'hello-elementor-child'),
        'menu_name'          => __('FAQs', 'hello-elementor-child'),
        'name_admin_bar'     => __('FAQ', 'hello-elementor-child'),
        'parent_item_colon'  => __('Parent FAQ:', 'hello-elementor-child'),
        'all_items'          => __('FAQs', 'hello-elementor-child'),
        'add_new_item'       => __('Add New FAQ', 'hello-elementor-child'),
        'add_new'            => __('Add New', 'hello-elementor-child'),
        'new_item'           => __('New FAQ', 'hello-elementor-child'),
        'edit_item'          => __('Edit FAQ', 'hello-elementor-child'),
        'update_item'        => __('Update FAQ', 'hello-elementor-child'),
        'view_item'          => __('View FAQ', 'hello-elementor-child'),
        'search_items'       => __('Search FAQ', 'hello-elementor-child'),
        'not_found'          => __('Not found', 'hello-elementor-child'),
        'not_found_in_trash' => __('Not found in Trash', 'hello-elementor-child'),
    );

    $args = array(
        'label'               => __('faq', 'hello-elementor-child'),
        'description'         => __('Frequently Asked Questions', 'hello-elementor-child'),
        'labels'              => $lable,
        'supports'            => array('title', 'editor', 'author'),
        'hierarchical'        => true,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_position'       => 10,
        'menu_icon'           => 'dashicons-format-chat',
        'show_in_admin_bar'   => true,
        'show_in_nav_menus'   => true,
        'can_export'          => true,
        'has_archive'         => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'post',
        'show_in_rest'        => true,
        'rest_base'           => 'faq',
    );

    register_post_type('faq', $args, 0);
}

add_action('init', 'register_faq_post_type');

function register_faq_group_taxonomy()
{

    $labels = array(
        'name'                       => _x('FAQ Groups', 'Taxonomy General Name', 'hello-elementor-child'),
        'singular_name'              => _x('FAQ Group', 'Taxonomy Singular Name', 'hello-elementor-child'),
        'menu_name'                  => __('Groups', 'hello-elementor-child'),
        'all_items'                  => __('All FAQ Groups', 'hello-elementor-child'),
        'parent_item'                => __('Parent FAQ Group', 'hello-elementor-child'),
        'parent_item_colon'          => __('Parent FAQ Group:', 'hello-elementor-child'),
        'new_item_name'              => __('New FAQ Group Name', 'hello-elementor-child'),
        'add_new_item'               => __('Add New FAQ Group', 'hello-elementor-child'),
        'edit_item'                  => __('Edit FAQ Group', 'hello-elementor-child'),
        'update_item'                => __('Update FAQ Group', 'hello-elementor-child'),
        'view_item'                  => __('View FAQ Group', 'hello-elementor-child'),
        'separate_items_with_commas' => __('Separate FAQ Groups with commas', 'hello-elementor-child'),
        'add_or_remove_items'        => __('Add or remove FAQ Groups', 'hello-elementor-child'),
        'choose_from_most_used'      => __('Choose from the most used', 'hello-elementor-child'),
        'popular_items'              => __('Popular FAQs Groups', 'hello-elementor-child'),
        'search_items'               => __('Search FAQs Groups', 'hello-elementor-child'),
        'not_found'                  => __('Not Found', 'hello-elementor-child'),
    );

    $args = array(
        'labels'              => $labels,
        'hierarchical'        => true,
        'public'              => true,
        'exclude_from_search' => true,
        'rewrite'             => false,
        'show_ui'             => true,
        'show_in_menu'        => 'edit.php?post_type=faqs',
        'show_admin_column'   => true,
        'show_in_nav_menus'   => true,
        'show_tagcloud'       => false,
        'show_in_rest'        => true,
        'rest_base'           => 'faq-group',
    );
    register_taxonomy('faq-group', array('faq'), $args);
}

add_action('init', 'register_faq_group_taxonomy');

// ! Adding Documentation page for FAQs post type
function faqs_page_settings()
{
    add_submenu_page('edit.php?post_type=faq', 'Documentation For FAQs',   'Documentation', 'edit_posts', basename(__FILE__),  'docs_for_faqs_shortcode_func');
}

add_action('admin_menu', 'faqs_page_settings');

function docs_for_faqs_shortcode_func()
{
?>
    <h1>Documentation For FAQs Shortcode</h1>
    <div>
        <p>Here is the documentation for FAQs Shortcode:</p>
        <ul>
            <li>
                <code>[faqs]</code> Display all FAQs in simple list style.
            </li>
            <li>
                <code>[faqs limit="10"]</code> Change limit of FAQs in simple list style. By default, 10 FAQs will be displayed. Add -1 to display all FAQs.
            </li>
            <li>
                <code>[faqs order="ASC" orderby="title"]</code> Display all FAQs in simple list style and order by ascending title.
            </li>
            <li>
                <code>[faqs order="DESC" orderby="title"]</code> Display all FAQs in simple list style and order by descending title.
            </li>
            <li>
                <code>[faqs catetory="category_name"]</code> Display all FAQs in simple list style and filter by category.
            </li>
        </ul>
    </div>
    <?php
}


// ! Faqs Shortcode

function faqs_shortcodes_func($atts)
{
    ob_start();

    $atts = shortcode_atts(
        array(
            'orderby' => 'menu_order',
            'order' => 'ASC',
            'category' => '',
            'limit' => '10',
        ),
        $atts
    );

    // Prepare arguments for WP_Query
    $args = array(
        'post_type' => 'faq',
        'post_status' => 'publish',
        'posts_per_page' => $atts['limit'],
        'orderby' => $atts['orderby'],
        'order' => $atts['order'],
    );

    // Add tax_query if category is specified
    if (!empty($atts['category'])) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'faq-group',
                'field' => 'slug',
                'terms' => $atts['category'],
            ),
        );
    }

    $query = new WP_Query($args);

    // Check if there are posts
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
    ?>
            <h2><?= get_the_title(); ?></h2>
            <div><?= get_the_content(); ?></div>
<?php
        }
    }

    // Restore original Post Data
    wp_reset_postdata();

    $output = ob_get_clean();
    return $output;
}

add_shortcode('faqs', 'faqs_shortcodes_func');
