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
 * @version     1.0.0
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
        'featured_image'     => 'Portrait',
        'set_featured_image' => 'Add portrait'
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
        'query_var'             => 'team',
        'show_in_graphql'       => true,
        'hierarchical'          => false,
        'graphql_single_name' => 'publication',
        'graphql_plural_name' => 'publications',
    ];


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
     * @inheritdoc
     */
    protected function init()
    {
        $initHook = new Hook(
            'init',
            $this,
            'hook'
        );

        $this->hooks->addAction($initHook);
    }
}
