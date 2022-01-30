<?php

declare(strict_types=1);

namespace RealHero\Memocracy\Components;

use RealHero\Memocracy\Core\Component;
use RealHero\Memocracy\Core\Hook;

/**
 * Component for adding custom post type (Policy briefs).
 *
 * @package     wp-modern-plugin-boilerplate
 * @subpackage  core
 * @version     1.0.2
 * @author      Konrad Fedorczyk <contact@realhe.ro>
 */
class PolicyBriefsCpt extends Component
{
    const CPT_HANDLE = "policy_briefs";

    private $labels = [
        'name'               => 'Policy briefs',
        'singular_name'      => 'Policy brief',
        'add_new'            => 'Add New Policy brief',
        'add_new_item'       => 'Add New Policy brief',
        'edit_item'          => 'Edit Policy brief',
        'new_item'           => 'New Policy brief',
        'all_items'          => 'All Policy briefs',
        'view_item'          => 'View Policy brief',
        'search_items'       => 'Search Policy briefs',
        'featured_image'     => 'Cover',
        'set_featured_image' => 'Add cover'
    ];

    private $args = [
        'description'           => 'Holds our policy briefs',
        'public'                => true,
        'menu_position'         => 5,
        'supports'              => ['title', 'editor', 'thumbnail', 'excerpt', 'comments', 'custom-fields', 'page-attributes'],
        'has_archive'           => true,
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'show_in_rest'          => true,
        'query_var'             => 'policy-brief',
        'show_in_graphql'       => true,
        'hierarchical'          => false,
        'graphql_single_name'   => 'policyBrief',
        'graphql_plural_name'   => 'policyBriefs',
        'menu_icon'             => 'dashicons-format-aside'
    ];

    /**
     * Register meta in WPGraphQL
     */
    private function exposeMeta()
    {
        if (function_exists("register_graphql_field")) {
            register_graphql_field('Policy brief', 'attachmentFile', [
                'type'          => 'String',
                'description'   => 'Policy brief attachment',
                'resolve'       => function ($post) {
                    $handle = get_post_meta($post->ID, 'attachment_file', true);
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
