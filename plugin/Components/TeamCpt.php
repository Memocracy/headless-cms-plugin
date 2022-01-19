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
 * @version     1.0.0
 * @author      Konrad Fedorczyk <contact@realhe.ro>
 */
class TeamCpt extends Component
{
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
        'supports'              => ['title', 'editor', 'thumbnail', 'excerpt', 'comments', 'custom-fields'],
        'has_archive'           => true,
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'has_archive'           => true,
        'query_var'             => 'team',
        'show_in_graphql'       => true,
        'hierarchical'          => true,
        'graphql_single_name' => 'teamMember',
        'graphql_plural_name' => 'teamMembers',
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
        register_post_type('team-member', $args);
    }

    /**
     * Grouping hook.
     *
     * This must be public.
     */
    public function hook()
    {
        $this->registerPostType();
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
