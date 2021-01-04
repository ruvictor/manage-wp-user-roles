<?php
/**
 * Plugin Name: Vicode Media
 * Description: Add Surf Reports and Surf Reporters
 * Plugin URI: https://vicodemedia.com
 * Author: Victor Rusu
 * Version: 0.0.1
 */

//* Don't access this file directly
defined( 'ABSPATH' ) or die();

//* Add action to init to register custom post type
add_action( 'init', 'create_post_type_reports' );

//* Register activation hook to add Blog Manager role
register_activation_hook( __FILE__ , 'vm_activation' );

//* Register deactivation hook to remove Blog Manager role
register_deactivation_hook( __FILE__ , 'vm_deactivation' );

function vm_activation() {
  $caps = [
    'read'         => true,
    'edit_posts'   => true,
    'upload_files' => true,
  ];

  add_role( 'surf_reporter', 'Surf Reporter', $caps );
}

function vm_deactivation() {
  remove_role( 'surf_reporter' );
}

// Allow 'reporter' User Role to  view the Dashboard
add_filter( 'woocommerce_prevent_admin_access', 'wc_reporter_admin_access', 20, 1 );
function wc_reporter_admin_access( $prevent_access ) {
    if( current_user_can('surf_reporter') )
        $prevent_access = false;

    return $prevent_access;
}


// Create custom post type
function create_post_type_reports() {
    register_post_type( 'surf_reports',
        array(
        'labels'       => array(
            'name'               => esc_html( 'Surf Reports', 'vicodemedia' ),
            'singular_name'      => esc_html( 'Surf Report', 'vicodemedia' ),
            'add_new'            => esc_html( 'Add New', 'vicodemedia' ),
            'add_new_item'       => esc_html( 'Add New Surf Report', 'vicodemedia' ),
            'edit'               => esc_html( 'Edit', 'vicodemedia' ),
            'edit_item'          => esc_html( 'Edit Surf Report', 'vicodemedia' ),
            'new_item'           => esc_html( 'New Surf Report', 'vicodemedia' ),
            'view'               => esc_html( 'View Surf Report', 'vicodemedia' ),
            'view_item'          => esc_html( 'View Surf Report', 'vicodemedia' ),
            'search_items'       => esc_html( 'Search Surf Report', 'vicodemedia' ),
            'not_found'          => esc_html( 'No Surf Reports found', 'vicodemedia' ),
            'not_found_in_trash' => esc_html( 'No Surf Reports found in Trash', 'vicodemedia' ),
        ),
        'public'              => true,
        // pass in the read, edit and delete capabilities
        'capability_type'     => array('surf_report','surf_reports'),
        // overrides the default meta capabilities handling so we can use our own
        'map_meta_cap'        => true,
        'hierarchical'        => true,
        'has_archive'         => true,
        'supports'     => array(
            'title',
            'editor'
        )
    ) );
}

// add role capabilities
add_action('admin_init','vm_add_role_caps',999);
function vm_add_role_caps() {

    // Add the roles you'd like to administer the custom post types
	$roles = array('surf_reporter', 'administrator');

    
    foreach($roles as $the_role) {
        $role = get_role($the_role);
        $role->add_cap( 'read' );
        $role->add_cap( 'read_surf_reports');
        $role->add_cap( 'read_private_surf_reports' );
        $role->add_cap( 'edit_surf_reports' );
        $role->add_cap( 'edit_surf_reports' );
        $role->add_cap( 'edit_others_surf_reports' );
        $role->add_cap( 'edit_published_surf_reports' );
        $role->add_cap( 'publish_surf_reports' );
        $role->add_cap( 'delete_others_surf_reports' );
        $role->add_cap( 'delete_private_surf_reports' );
        $role->add_cap( 'delete_published_surf_reports' );
    }
    
}