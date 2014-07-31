<?php
   /*
   Plugin Name: Media Links Custom Post Type
   Plugin URI: http://stephen-chapman.com
   Description: A plugin to add a custom post type for media links
   Version: 0.2
   Author: Stephen Chapman
   Author URI: http://stephen-chapman.com
   License: GPL2
   */


   add_action( 'init', 'create_media_link' ); // Execute the custom function named create_movie_review during the initialization phase every time a page is generated.

   function create_media_link() {
    register_post_type( 'media_links',
        array(
            'labels' => array(
                'name' => 'Media Links',
                'singular_name' => 'Media Link',
                'add_new' => 'Add New',
                'add_new_item' => 'Add New Media Link',
                'edit' => 'Edit',
                'edit_item' => 'Edit Media Link',
                'new_item' => 'New Media Link',
                'view' => 'View',
                'view_item' => 'View Media Link',
                'search_items' => 'Search Media Links',
                'not_found' => 'No Media Links found',
                'not_found_in_trash' => 'No Media Links found in Trash',
                'parent' => 'Parent Media Link'
            ),
 
            'public' => true,
            'menu_position' => 15,
            'supports' => array( 'title', 'editor', 'thumbnail'),
            'taxonomies' => array( '' ),
            'menu_icon' => 'dashicons-media-document', // 16x16 pixel image
            'has_archive' => true,
            'rewrite' => array('slug' => 'glimmer')
        )
    );
}

	add_action( 'admin_init', 'my_admin' ); // Registers a function to be called when the WordPress admin interface is visited

	function my_admin() {
    add_meta_box( 'media_link_meta_box', // Registers a meta box and associates it with the movie_reviews custom post type
        'Media Link Details',
        'display_media_link_meta_box',
        'media_links', 'side', 'core'
    );
}
 	// Render the contents of the meta box
	function display_media_link_meta_box( $media_link ) {
	    // Retrieve current name of the Director and Movie Rating based on review ID
	    $media_source = esc_html( get_post_meta( $media_link->ID, 'media_source', true ) );
	    $media_url = esc_html( get_post_meta( $media_link->ID, 'media_url', true ) );
	    ?>
	    <table>
	        <tr>
	            <td style="width: 100%">Source</td>
	            <td><input type="text" name="media_link_source" value="<?php echo $media_source; ?>" /></td>
	        </tr>
	        <tr>
	            <td style="width: 150px">URL</td>
	            <td><input type="text" name="media_link_url" value="<?php echo $media_url; ?>" /></td>
	        </tr>
	    </table>
	    <?php
	}

// This function is executed when posts are saved or deleted from the admin panel
function add_media_links_fields( $media_links_id, $media_link ) {
    // Check post type for movie reviews
    if ( $media_link->post_type == 'media_links' ) {
        // Store data in post meta table if present in post data
        if ( isset( $_POST['media_link_source'] ) && $_POST['media_link_source'] != '' ) {
            update_post_meta( $media_links_id, 'media_source', $_POST['media_link_source'] );
        }
        if ( isset( $_POST['media_link_url'] ) && $_POST['media_link_url'] != '' ) {
            update_post_meta( $media_links_id, 'media_url', $_POST['media_link_url'] );
        }
    }
}

add_action( 'save_post', 'add_media_links_fields', 10, 2 ); // This function is called when posts get saved in the database.

?>