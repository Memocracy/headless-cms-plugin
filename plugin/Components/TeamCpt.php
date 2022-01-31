<?php

declare(strict_types=1);

namespace RealHero\Memocracy\Components;

use RealHero\Memocracy\Core\Component;
use RealHero\Memocracy\Core\Hook;

/**
 * Component for adding custom post type (Team members).
 *
 * @package     wp-modern-plugin-boilerplate
 * @subpackage  core
 * @version     1.0.1
 * @author      Konrad Fedorczyk <contact@realhe.ro>
 */
class TeamCpt extends Component
{
    const CPT_HANDLE = "team_members";

    private $labels = [
        'name'               => 'Team Members',
        'singular_name'      => 'Team Member',
        'add_new'            => 'Add New Team Member',
        'add_new_item'       => 'Add New Team Member',
        'edit_item'          => 'Edit Team Member',
        'new_item'           => 'New Team Member',
        'all_items'          => 'All Team Members',
        'view_item'          => 'View Team Member',
        'search_items'       => 'Search Team Members',
        'featured_image'     => 'Portrait',
        'set_featured_image' => 'Add portrait'
    ];

    private $args = [
        'description'           => 'Holds our Team Members',
        'public'                => true,
        'menu_position'         => 5,
        'supports'              => ['title', 'editor', 'thumbnail', 'excerpt', 'comments', 'custom-fields', 'page-attributes'],
        'has_archive'           => true,
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'show_in_rest'          => true,
        'query_var'             => 'team',
        'show_in_graphql'       => true,
        'hierarchical'          => false,
        'graphql_single_name'   => 'teamMember',
        'graphql_plural_name'   => 'teamMembers',
        'menu_icon'             => 'dashicons-admin-users'
    ];

    private $taxonomy = [
        'hierarchical'          => true,
        'label'                 => 'Member categories', // display name
        'query_var'             => true,
        'show_in_rest'          => true,
        'show_in_graphql'       => true,
        'graphql_single_name'   => 'memberCategory',
        'graphql_plural_name'   => 'memberCategories',
        'rewrite' => [
            'slug'          => 'categories',
            'with_front'    => false
        ]
    ];

    /**
     * Register meta in WPGraphQL
     */
    private function exposeMeta()
    {
        if (function_exists("register_graphql_field")) {
            register_graphql_field('TeamMember', 'twitterHandle', [
                'type'          => 'String',
                'description'   => 'Twitter handle',
                'resolve'       => function ($post) {
                    $handle = get_post_meta($post->ID, 'twitter_handle', true);
                    return !empty($handle) ? $handle : '';
                }
            ]);
        } else {
            throw new \Exception("There's no register_graphql_field function");
        }
    }

    /**
     * Register custom post type.
     */
    private function registerPostType()
    {
        $args = array_merge($this->args, ['labels' => $this->labels]);
        register_post_type(self::CPT_HANDLE, $args);
    }

    /**
     * Add menu order to rest.
     */
    private function addMenuOrder()
    {
        register_rest_field(
            get_post_types(), // add to these post types
            'menu_order', // name of field
            array(
                'get_callback' => function ($post) {
                    if (isset($post->ID)) {
                        return get_post_field('menu_order', $post->ID);
                    }
                }
            )
        );
    }

    /**
     * Register taxonomy for team members.
     */
    private function registerTaxonomy()
    {
        register_taxonomy(
            'members_categories',
            self::CPT_HANDLE,
            $this->taxonomy
        );
    }


    /**
     * Grouping hook.
     *
     * This must be public.
     */
    public function hook()
    {
        // Add theme support to bypass empty theme limitation
        add_theme_support('post-thumbnails');
        add_theme_support('html5');
        add_theme_support('menus');

        $this->registerPostType();
        $this->registerTaxonomy();
    }

    /**
     * Grouping hook.
     *
     * This must be public.
     */
    public function graphQlHook()
    {
        $this->exposeMeta();
    }

    /**
     * Grouping hook.
     *
     * This must be public.
     */
    public function restApiHook()
    {
        $this->addMenuOrder();
    }

    /**
     * @inheritdoc
     */
    protected function init()
    {
        $initHook = new Hook(
            'init',
            $this,
            'hook'
        );

        $registerGraphQlTypesHook = new Hook(
            'graphql_register_types',
            $this,
            'graphQlHook'
        );

        $restApiHook = new Hook(
            'rest_api_init',
            $this,
            'restApiHook'
        );

        $this->hooks->addAction($initHook);
        $this->hooks->addAction($registerGraphQlTypesHook);
        $this->hooks->addAction($restApiHook);
    }
}
