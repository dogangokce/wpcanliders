<?php
/**
 * Registration of necessary components for the plugin.
 *
 * @link       https://dogangokce.com
 * @since      3.0.0
 *
 * @package    Canliders1
 * @subpackage Canliders1/admin
 */

/**
 * Registration of necessary components for the plugin.
 *
 * Registers rooms, room categories, and metaboxes for the rooms.
 *
 * @package    Canliders1
 * @subpackage Canliders1/admin
 * @author     Doğan GÖGCE <contact@dogangokce.com>
 */
class Canliders1_Register_Custom_Types {

	/**
	 * Register room as custom post.
	 *
	 * @since   3.0.0
	 */
	public function bbb_room_as_post_type() {
		register_post_type(
			'bbb-room',
			array(
				'public'          => true,
				'show_ui'         => true,
				'labels'          => array(
					'name'                     => __( 'Rooms', 'canliders1' ),
					'add_new'                  => __( 'Add New', 'canliders1' ),
					'add_new_item'             => __( 'Add New Room', 'canliders1' ),
					'edit_item'                => __( 'Edit Room', 'canliders1' ),
					'new_item'                 => __( 'New Room', 'canliders1' ),
					'view_item'                => __( 'View Room', 'canliders1' ),
					'view_items'               => __( 'View Rooms', 'canliders1' ),
					'search_items'             => __( 'Search Rooms', 'canliders1' ),
					'not_found'                => __( 'No rooms found', 'canliders1' ),
					'not_found_in_trash'       => __( 'No rooms found in trash', 'canliders1' ),
					'all_items'                => __( 'All Rooms', 'canliders1' ),
					'archives'                 => __( 'Room Archives', 'canliders1' ),
					'attributes'               => __( 'Room Attributes', 'canliders1' ),
					'insert_into_item'         => __( 'Insert into room', 'canliders1' ),
					'uploaded_to_this_item'    => __( 'Uploaded to this room', 'canliders1' ),
					'filter_items_list'        => __( 'Filter rooms list', 'canliders1' ),
					'items_list_navigation'    => __( 'Rooms list navigation', 'canliders1' ),
					'items_list'               => __( 'Rooms list', 'canliders1' ),
					'item_published'           => __( 'Room published', 'canliders1' ),
					'item_published_privately' => __( 'Room published privately', 'canliders1' ),
					'item_reverted_to_draft'   => __( 'Room reverted to draft', 'canliders1' ),
					'item_scheduled'           => __( 'Room scheduled', 'canliders1' ),
					'item_updated'             => __( 'Room updated', 'canliders1' ),
				),
				'taxonomies'      => array( 'bbb-room-category' ),
				'capability_type' => 'bbb_room',
				'has_archive'     => true,
				'supports'        => array( 'title', 'editor' ),
				'rewrite'         => array( 'slug' => 'bbb-room' ),
				'show_in_menu'    => 'bbb_room',
				'map_meta_cap'    => true,
				// Enables block editing in the rooms editor.
				'show_in_rest'    => true,
				'supports'        => array( 'title', 'editor', 'author', 'thumbnail', 'permalink' ),
			)
		);
	}

	/**
	 * Register category as custom taxonomy.
	 *
	 * @since   3.0.0
	 */
	public function bbb_room_category_as_taxonomy_type() {
		register_taxonomy(
			'bbb-room-category',
			array( 'bbb-room' ),
			array(
				'labels'       => array(
					'name'          => __( 'Categories' ),
					'singular_name' => __( 'Category' ),
				),
				'hierarchical' => true,
				'query_var'    => true,
				'show_in_ui'   => true,
				'show_in_menu' => 'bbb_room',
				'show_in_rest' => true,
			)
		);
	}

	/**
	 * Create moderator and viewer code metaboxes on room creation and edit.
	 *
	 * @since   3.0.0
	 */
	public function register_room_code_metaboxes() {
		add_meta_box( 'bbb-moderator-code', __( 'Moderator Code', 'canliders1' ), array( $this, 'display_moderator_code_metabox' ), 'bbb-room' );
		add_meta_box( 'bbb-viewer-code', __( 'Viewer Code', 'canliders1' ), array( $this, 'display_viewer_code_metabox' ), 'bbb-room' );
	}

	/**
	 * Show recordable option in room creation to users who have the corresponding capability.
	 *
	 * @since   3.0.0
	 */
	public function register_record_room_metabox() {
		if ( current_user_can( 'create_recordable_bbb_room' ) ) {
			add_meta_box( 'bbb-room-recordable', __( 'Recordable', 'canliders1' ), array( $this, 'display_allow_record_metabox' ), 'bbb-room' );
		}
	}

	/**
	 * Show wait for moderator option in room creation.
	 *
	 * @since   3.0.0
	 */
	public function register_wait_for_moderator_metabox() {
		add_meta_box( 'bbb-room-wait-for-moderator', __( 'Wait for Moderator', 'canliders1' ), array( $this, 'display_wait_for_mod_metabox' ), 'bbb-room' );
	}

	/**
	 * Display moderator code metabox.
	 *
	 * @since   3.0.0
	 *
	 * @param   Object $object     The object that has the room ID.
	 */
	public function display_moderator_code_metabox( $object ) {
		$entry_code       = Canliders1_Admin_Helper::generate_random_code();
		$entry_code_label = __( 'Moderator Code', 'canliders1' );
		$entry_code_name  = 'bbb-moderator-code';
		$existing_value   = get_post_meta( $object->ID, 'bbb-room-moderator-code', true );
		wp_nonce_field( 'bbb-room-moderator-code-nonce', 'bbb-room-moderator-code-nonce' );
		require 'partials/canliders1-room-code-metabox-display.php';
	}

	/**
	 * Display viewer code metabox.
	 *
	 * @since   3.0.0
	 *
	 * @param   Object $object     The object that has the room ID.
	 */
	public function display_viewer_code_metabox( $object ) {
		$entry_code       = Canliders1_Admin_Helper::generate_random_code();
		$entry_code_label = __( 'Viewer Code', 'canliders1' );
		$entry_code_name  = 'bbb-viewer-code';
		$existing_value   = get_post_meta( $object->ID, 'bbb-room-viewer-code', true );
		wp_nonce_field( 'bbb-room-viewer-code-nonce', 'bbb-room-viewer-code-nonce' );
		require 'partials/canliders1-room-code-metabox-display.php';
	}

	/**
	 * Display wait for moderator metabox.
	 *
	 * @since   3.0.0
	 *
	 * @param   Object $object     The object that has the room ID.
	 */
	public function display_wait_for_mod_metabox( $object ) {
		$existing_value = get_post_meta( $object->ID, 'bbb-room-wait-for-moderator', true );
		wp_nonce_field( 'bbb-room-wait-for-moderator-nonce', 'bbb-room-wait-for-moderator-nonce' );
		require 'partials/canliders1-wait-for-mod-metabox-display.php';
	}

	/**
	 * Display recordable metabox.
	 *
	 * @since   3.0.0
	 *
	 * @param   Object $object     The object that has the room ID.
	 */
	public function display_allow_record_metabox( $object ) {
		$existing_value = get_post_meta( $object->ID, 'bbb-room-recordable', true );

		wp_nonce_field( 'bbb-room-recordable-nonce', 'bbb-room-recordable-nonce' );
		require 'partials/canliders1-recordable-metabox-display.php';
	}
}
