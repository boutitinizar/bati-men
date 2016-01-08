<?php
/**

 */

global $wpdb, $sc_installed_version, $sc_multi_language_count;
 
$sc_multi_language_count = 1;
global $sitepress;
if ($sitepress) {
	$active_languages = $sitepress->get_active_languages();
	$sitepress_settings = $sitepress->get_settings();
	$hidden_languages = array();
	if (isset($sitepress_settings['hidden_languages'])) 
		$hidden_languages = $sitepress_settings['hidden_languages'];
	$sc_multi_language_count = count($active_languages) + count($hidden_languages);
}

if ( ! defined( 'SOCIALCHEF_VERSION' ) )
	define( 'SOCIALCHEF_VERSION', '1.21' );
	
if ( ! defined( 'SOCIALCHEF_RECIPE_INGREDIENTS_TABLE' ) )
    define( 'SOCIALCHEF_RECIPE_INGREDIENTS_TABLE', $wpdb->prefix . 'sc_recipe_ingredients' );

if ( ! defined( 'SOCIALCHEF_RECIPE_NUTRITIONAL_ELEMENTS_TABLE' ) )
	define( 'SOCIALCHEF_RECIPE_NUTRITIONAL_ELEMENTS_TABLE', $wpdb->prefix . 'sc_recipe_nutritional_elements' );
	
if ( !defined( 'BP_AVATAR_THUMB_WIDTH' ) )	
	define ( 'BP_AVATAR_THUMB_WIDTH', 90 );
if ( !defined( 'BP_AVATAR_THUMB_HEIGHT' ) )
	define ( 'BP_AVATAR_THUMB_HEIGHT', 90 );
if ( !defined( 'BP_AVATAR_FULL_WIDTH' ) )
	define ( 'BP_AVATAR_FULL_WIDTH', 270 );
if ( !defined( 'BP_AVATAR_FULL_HEIGHT' ) )
	define ( 'BP_AVATAR_FULL_HEIGHT', 270 );
	
if ( !defined( 'SOCIALCHEF_FAVORITE_RECIPES' ) )	
	define ( 'SOCIALCHEF_FAVORITE_RECIPES', '_socialchef_favorite_recipes' );
	
require_once dirname( __FILE__ ) . '/includes/theme_utils.php';

$sc_installed_version = get_option('socialchef_version', 0);

if ($sc_installed_version == 0)
	add_option("socialchef_version", SOCIALCHEF_VERSION);
else
	 update_option("socialchef_version", SOCIALCHEF_VERSION);

require_once SocialChef_Theme_Utils::get_file_path('/includes/theme_of_default_fields.php');

if ( !function_exists( 'optionsframework_init' ) ) {
	define( 'OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/includes/framework/' );
	require_once dirname( __FILE__ ) . '/includes/framework/options-framework.php';
}

require_once dirname( __FILE__ ) . '/includes/theme_globals.php';

// /*-----------------------------------------------------------------------------------*/
// /*	Load Options Framework custom fields
// /*-----------------------------------------------------------------------------------*/
require_once dirname( __FILE__ ) . '/includes/theme_of_custom.php';

// /*-----------------------------------------------------------------------------------*/
// /*	Load Actions & Filters
// /*-----------------------------------------------------------------------------------*/
require_once SocialChef_Theme_Utils::get_file_path('/includes/theme_filters.php');
require_once SocialChef_Theme_Utils::get_file_path('/includes/theme_actions.php');
require_once SocialChef_Theme_Utils::get_file_path('/includes/theme_woocommerce.php');
require_once SocialChef_Theme_Utils::get_file_path('/includes/plugins/frontend-submit/frontend-submit.php');

// /*-----------------------------------------------------------------------------------*/
// /*	Load Object Classes
// /*-----------------------------------------------------------------------------------*/
require_once SocialChef_Theme_Utils::get_file_path('/includes/post_types/abstracts/socialchef-entity.php');

// /*-----------------------------------------------------------------------------------*/
// /*	Load Widgets, Shortcodes, Metaboxes & Plugins
// /*-----------------------------------------------------------------------------------*/
require_once SocialChef_Theme_Utils::get_file_path('/includes/plugins/metaboxes/meta_box.php');
require_once SocialChef_Theme_Utils::get_file_path('/includes/plugins/class-tgm-plugin-activation.php');
require_once SocialChef_Theme_Utils::get_file_path('/includes/plugins/widgets/widget-contact.php');
require_once SocialChef_Theme_Utils::get_file_path('/includes/plugins/widgets/widget-social.php');
require_once SocialChef_Theme_Utils::get_file_path('/includes/plugins/widgets/widget-about.php');
require_once SocialChef_Theme_Utils::get_file_path('/includes/plugins/widgets/widget-search.php');
require_once SocialChef_Theme_Utils::get_file_path('/includes/plugins/widgets/widget-home-intro.php');
require_once SocialChef_Theme_Utils::get_file_path('/includes/plugins/widgets/widget-recipe-categories.php');
require_once SocialChef_Theme_Utils::get_file_path('/includes/plugins/widgets/widget-post-list.php');
require_once SocialChef_Theme_Utils::get_file_path('/includes/plugins/widgets/widget-recipe-list.php');
require_once SocialChef_Theme_Utils::get_file_path('/includes/plugins/widgets/widget-featured-recipe.php');
require_once SocialChef_Theme_Utils::get_file_path('/includes/plugins/widgets/widget-featured-member.php');
require_once SocialChef_Theme_Utils::get_file_path('/includes/plugins/widgets/widget-share.php');
require_once SocialChef_Theme_Utils::get_file_path('/includes/plugins/widgets/widget_mnb_banner.php');

 

  


// /*-----------------------------------------------------------------------------------*/
// /*	Load Utilities & Ajax & Custom Post Types & metaboxes
// /*-----------------------------------------------------------------------------------*/
require_once SocialChef_Theme_Utils::get_file_path('/includes/theme_ajax.php');
require_once SocialChef_Theme_Utils::get_file_path('/includes/theme_post_types.php');
require_once SocialChef_Theme_Utils::get_file_path('/includes/theme_meta_boxes.php');
require_once SocialChef_Theme_Utils::get_file_path('/includes/post_types/recipe.class.php');
require_once SocialChef_Theme_Utils::get_file_path('/includes/post_types/post.class.php');




if ( function_exists('register_sidebar') ) {
	register_sidebar(array(
		'name' => 'offre Sidebar',
		'id' => 'offre-sidebar',
		'description' => 'Appears as the sidebar on the custom offre',
		'before_widget' => '<div ></div><li id="%1$s" class="widget %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h2 class="widgettitle">',
		'after_title' => '</h2>',
	));
}



//gsm Comment
add_action('comment_post','save_comment_meta');
function save_comment_meta($comment_id){
	add_comment_meta($comment_id,'gsm',$_POST['gsm'],true);
}


//user extra filds
function modify_contact_methods($profile_fields) {

	// Add new fields
	$profile_fields['Raison_Social'] = 'Raison Social';
	$profile_fields['Adresse'] = 'Adresse';
	$profile_fields['Tel'] = 'Tél';

	return $profile_fields;
}
add_filter('user_contactmethods', 'modify_contact_methods');


function revcon_change_post_label() {
	global $menu;
	global $submenu;
	$menu[5][0] = 'Recrutement';
	$submenu['edit.php'][5][0] = 'Recrutement';
	$submenu['edit.php'][10][0] = 'Add Recrutement';
	$submenu['edit.php'][16][0] = 'Recrutement Tags';
	echo '';
}
function revcon_change_post_object() {
	global $wp_post_types;
	$labels = &$wp_post_types['post']->labels;
	$labels->name = 'Recrutement';
	$labels->singular_name = 'Recrutement';
	$labels->add_new = 'Ajouter Recrutement';
	$labels->add_new_item = 'Ajouter Recrutement';
	$labels->edit_item = 'Modifier Recrutement';
	$labels->new_item = 'Recrutement';
	$labels->view_item = 'Voir Recrutement';
	$labels->search_items = 'Search Recrutement';
	$labels->not_found = 'No Recrutement found';
	$labels->not_found_in_trash = 'No Recrutement found in Trash';
	$labels->all_items = 'tous Recrutements';
	$labels->menu_name = 'Recrutements';
	$labels->name_admin_bar = 'Recrutements';
}

add_action( 'admin_menu', 'revcon_change_post_label' );
add_action( 'init', 'revcon_change_post_object' );


//bannières publicitaires custom post



	$labels = array (
		'name' => __('Bannières publicitaires ', 'kiwi_logo_carousel' ),
		'singular_name' => __('Bannières publicitaires', 'kiwi_logo_carousel' ),
		'add_new' => __( 'Add New Bannière publicitaire', 'kiwi_logo_carousel' ),
		'add_new_item' => __( 'Add New Bannières publicitaires', 'kiwi_logo_carousel' ),
		'edit_item' => __( 'Edit Bannière  publicitaire', 'kiwi_logo_carousel' ),
		'new_item' => __( 'New Bannière publicitaire', 'kiwi_logo_carousel' ),

		'menu_name' => __('Bannières publicitaires', 'kiwi_logo_carousel' ),
	);
	$args = array(
		'labels' => $labels,
		'hierarchical' => false,
		'supports' => array(
			'title',
			'thumbnail',
			'page-attributes'
		),
		'public' => false,
		'show_ui' => true,
		'show_in_menu' => true,
		'show_in_nav_menus' => false,
		'publicly_queryable' => true,
		'exclude_from_search' => true,
		'has_archive' => true,
		'query_var' => true,
		'can_export' => true,
		'rewrite' => true,
		'capability_type' => 'post',
		'menu_icon' =>'dashicons-welcome-write-blog' ,
	);
	register_post_type( 'mnb_bannieres', $args );




add_action( 'add_meta_boxes', 'add_events_metaboxes' );
function add_events_metaboxes() {
    add_meta_box('wpt_events_location', 'Url banniere', 'wpt_events_location', 'mnb_bannieres', 'side', 'default');
 }



function wpt_events_location() {
	global $post;

	// Noncename needed to verify where the data originated
	echo '<input type="hidden" name="eventmeta_noncename" id="eventmeta_noncename" value="' .
		wp_create_nonce( plugin_basename(__FILE__) ) . '" />';

	// Get the location data if its already been entered
	$location = get_post_meta($post->ID, '_location', true);

	// Echo out the field
	echo '<input type="text" name="_location" value="' . $location  . '" class="widefat" />';

}

// Meta Box Link Contents
function metabox_link_contents() {
	echo '<p>';
	_e('Add an URL to make this logo clickable');
	echo '</p>';
	$value = get_post_meta( get_the_ID(), '_kwlogos_link', true );
}

// Save the Metabox Data

function wpt_save_events_meta($post_id, $post) {

	// verify this came from the our screen and with proper authorization,
	// because save_post can be triggered at other times
	if ( !wp_verify_nonce( $_POST['eventmeta_noncename'], plugin_basename(__FILE__) )) {
		return $post->ID;
	}

	// Is the user allowed to edit the post or page?
	if ( !current_user_can( 'edit_post', $post->ID ))
		return $post->ID;

	// OK, we're authenticated: we need to find and save the data
	// We'll put it into an array to make it easier to loop though.

	$events_meta['_location'] = $_POST['_location'];

	// Add values of $events_meta as custom fields

	foreach ($events_meta as $key => $value) { // Cycle through the $events_meta array!
		if( $post->post_type == 'revision' ) return; // Don't store custom data twice
		$value = implode(',', (array)$value); // If $value is an array, make it a CSV (unlikely)
		if(get_post_meta($post->ID, $key, FALSE)) { // If the custom field already has a value
			update_post_meta($post->ID, $key, $value);
		} else { // If the custom field doesn't have a value
			add_post_meta($post->ID, $key, $value);
		}
		if(!$value) delete_post_meta($post->ID, $key); // Delete if blank
	}

}

add_action('save_post', 'wpt_save_events_meta', 1, 2);