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
 