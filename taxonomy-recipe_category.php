<?php
/* Category recipe archive
 *
 * The template for displaying a page with recipes categorized by recipe category
 * @package WordPress
 * @subpackage SocialChef
 * @since SocialChef 1.0
 */

get_header('buddypress');
SocialChef_Theme_Utils::breadcrumbs();
get_sidebar('under-header');

global $sc_theme_globals, $sc_recipes_post_type;

$colcount = 0;
global $post, $sc_recipe_class, $wp_query;
$found_posts = (int)$wp_query->found_posts;

$id_cat= get_term_by( 'slug', $wp_query->query["recipe_category"] , 'recipe_category' )
	->term_id;



$sort_by = 'title';
if (isset($page_custom_fields['recipe_list_sort_by'])) {
	$sort_by = $page_custom_fields['recipe_list_sort_by'][0];
	$sort_by = empty($sort_by) ? 'title' : $sort_by;
}

$sort_descending = false;
if (isset($page_custom_fields['recipe_list_sort_descending'])) {
	$sort_descending = $page_custom_fields['recipe_list_sort_descending'][0] == '1' ? true : false;
}

$sort_order = $sort_descending ? 'DESC' : 'ASC';


$sort_order = $sort_descending ? 'DESC' : 'ASC';

$show_featured_only = false;
if (isset($page_custom_fields['recipe_list_show_featured'])) {
	$show_featured_only = $page_custom_fields['recipe_list_show_featured'][0] == '1' ? true : false;
}


?>
	<div class="row">
		<header class="s-title">
			<h1 class="archive-title"><?php printf( __( 'Categorie: %s', 'socialchef' ), single_cat_title( '', false ) ); ?></h1>
		</header>
		<section class="content three-fourth">



		<?php

		$recipe_results = $sc_recipes_post_type->list_recipes($paged, $posts_per_page, $sort_by, $sort_order, array(), array(),array($id_cat), array(), array(), $show_featured_only);









$count = 0;
foreach ($recipe_results['results'] as $recipe_result) {
	global $post, $sc_recipe_class;
	$post = $recipe_result;


	if ($colcount > 0 && $colcount % 3 == 0)
		echo '</div>';
	if ($colcount % 3 == 0)
		echo '<div class="entries row">';
	$sc_recipe_class = 'one-third';
	get_template_part('includes/parts/recipe', 'item');
	$colcount++;
}
			if ($found_posts % 3 != 0)
				echo '</div><!--entries-->'; ?>
			<div class="quicklinks">
				<a href="javascript:void(0)" class="button scroll-to-top"><?php _e('Haut', 'socialchef'); ?></a>
			</div>
			<div class="pager">
				<?php SocialChef_Theme_Utils::display_pager($wp_query->max_num_pages); ?>
			</div>

		</section><!--//three-fourth-->
		<?php get_sidebar('right'); ?>
	</div><!--//row-->
<?php
get_footer( 'buddypress' );