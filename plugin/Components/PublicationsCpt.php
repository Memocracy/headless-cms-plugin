<?php

declare(strict_types=1);

namespace RealHero\Memocracy\Components;

use RealHero\Memocracy\Core\Component;
use RealHero\Memocracy\Core\Hook;

/**
 * Component for adding custom post type (publications).
 *
 * @package     wp-modern-plugin-boilerplate
 * @subpackage  core
 * @version     1.0.3
 * @author      Konrad Fedorczyk <contact@realhe.ro>
 */
class PublicationsCpt extends Component
{
    const CPT_HANDLE = "publications";

    private $labels = [
        'name'               => 'Publications',
        'singular_name'      => 'Publication',
        'add_new'            => 'Add New Publication',
        'add_new_item'       => 'Add New Publication',
        'edit_item'          => 'Edit Publication',
        'new_item'           => 'New Publication',
        'all_items'          => 'All Publications',
        'view_item'          => 'View Publication',
        'search_items'       => 'Search Publications',
        'featured_image'     => 'Cover',
        'set_featured_image' => 'Add cover'
    ];

    private $args = [
        'description'           => 'Holds our Publications',
        'public'                => true,
        'menu_position'         => 5,
        'supports'              => ['title', 'editor', 'thumbnail', 'excerpt', 'comments', 'custom-fields', 'page-attributes'],
        'has_archive'           => true,
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'show_in_rest'          => true,
        'query_var'             => 'publication',
        'show_in_graphql'       => true,
        'hierarchical'          => false,
        'graphql_single_name'   => 'publication',
        'graphql_plural_name'   => 'publications',
        'menu_icon'             => 'dashicons-admin-site-alt'
    ];

    private $taxonomy = [
        'hierarchical'          => true,
        'label'                 => 'Publication categories', // display name
        'query_var'             => true,
        'show_in_rest'          => true,
        'show_in_graphql'       => true,
        'graphql_single_name'   => 'publicationCategory',
        'graphql_plural_name'   => 'publicationCategories',
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
            register_graphql_field('Publication', 'publicationUrl', [
                'type'          => 'String',
                'description'   => 'Publication link',
                'resolve'       => function ($post) {
                    $handle = get_post_meta($post->ID, 'publication_url', true);
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
     * Register taxonomy for team members.
     */
    private function registerTaxonomy()
    {
        register_taxonomy(
            'publications_categories',
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

        $this->hooks->addAction($initHook);
        $this->hooks->addAction($registerGraphQlTypesHook);
    }
}
