<?php
get_header('buddypress');
SocialChef_Theme_Utils::breadcrumbs();
get_sidebar('under-header');

if ( have_posts() ) while ( have_posts() ) :

	the_post();
	global $post, $sc_recipes_post_type, $sc_nutritional_element_results;
	global $sc_theme_globals;
	global $current_user;

?>
<script>
	window.recipeId = <?php echo $post->ID; ?>;
	window.addToFavoritesText = '<i class="ico eldorado_heart"></i><span><?php _e('Add to favorites', 'socialchef') ?></span>';
	window.removeFromFavoritesText = '<i class="ico eldorado_heart"></i><span><?php _e('Remove from favorites', 'socialchef') ?></span>';
</script>
<?php

	$recipe_obj = new sc_recipe($post);
	$recipe_id = $recipe_obj->get_id();

	$expirationdatets = $recipe_obj->get_post_meta('_expiration-date');
	$recipe_Prix = $recipe_obj->get_post_meta('recipe_Prix');
	$recipe_Remise = $recipe_obj->get_post_meta('recipe_Remise');

	$recipe_difficulty = $recipe_obj->get_difficulty();
	if(!empty($recipe_difficulty)){
		$recipe_difficulty = $recipe_difficulty->name;
	}else{
		$recipe_difficulty = false;
	}





	// Generate microformat time values for Schema.org compatibility
	//$mf_recipe_cooking_time = SocialChef_Theme_Utils::time_to_iso8601_duration(strtotime($recipe_cooking_time . " minutes", 0));
	//$mf_recipe_preparation_time = SocialChef_Theme_Utils::time_to_iso8601_duration(strtotime($recipe_preparation_time . " minutes", 0));

	$ingredient_results = $sc_recipes_post_type->list_recipe_ingredients($post->ID);

	if ($sc_theme_globals->enable_nutritional_elements())
		$sc_nutritional_element_results = $sc_recipes_post_type->list_recipe_nutritional_elements($post->ID);

	$author_nice_name = get_the_author_meta('user_nicename', $post->post_author);

	$author_uri = '';
	if (defined('BP_VERSION')) {
		$author_uri = bp_core_get_userlink($post->post_author, false, true);
	} else {
		$author_uri = get_author_posts_url($post->post_author);
	}
?>
	<!--row-->
	<div class="row">
		<div itemscope itemtype="http://schema.org/Recipe" <?php post_class( ); ?>>
			<header class="s-title">
				<h1 itemprop="name" class="entry-title"><?php the_title(); ?></h1>
			</header>
			<!--content-->
			<section class="content three-fourth">
				<!--recipe-->
				<article id="recipe-<?php the_ID(); ?>" class="recipe">
					<div class="row">
						<!--one-third-->
						<div class="one-third entry-header">
							<dl class="basic">



								<?php if($recipe_Prix){ ?>
									<dt><?php _e('Prix', 'socialchef'); ?></dt>
									<dd itemprop="prepTime" content="<?php echo $recipe_Prix;  ?>"><?php echo $recipe_Prix;  ?> DT</dd>
								<?php } ?>

								<?php if($recipe_Remise){ ?>
									<dt><?php _e('Remise', 'socialchef'); ?></dt>
									<dd itemprop="prepTime" content="<?php echo $recipe_Remise;  ?>"><?php echo $recipe_Remise;  ?> %</dd>
								<?php } ?>



							</dl>

							<dl class="user">

								<dt><?php _e('Posté par', 'socialchef'); ?></dt>
								<dd itemprop="author" class="vcard author post-author"><span class="fn"><a href="<?php echo esc_url( $author_uri ); ?>"><?php echo $author_nice_name; ?></a></span></dd>

								<dt><?php _e('Posté le', 'socialchef'); ?></dt>
								<dd  itemprop="datePublished" content="<?php echo get_the_date(); ?>"  class="post-date updated"><?php echo get_the_date(); ?></dd>

                                <?php if($recipe_difficulty): ?>

									<dt><?php _e('Gouvernorat', 'socialchef'); ?></dt>
									<dd  itemprop="datePublished" content="<?php echo $recipe_difficulty; ?>"  class="post-date updated"><?php echo $recipe_difficulty; ?></dd>

                                <?php  endif; ?>


								<?php


								if($expirationdatets){
								?>
								<dt><?php _e('Expire le ', 'socialchef'); ?></dt>
								<dd  itemprop="datePublished" content="<?php echo  date('j M Y', $expirationdatets); ?>"  class="post-date updated"><?php echo  date_i18n(get_option('date_format'), $expirationdatets); ?></dd>
     <?php } ?>
							</dl>

							<?php
							if (count($ingredient_results) > 0) { ?>
							<dl class="ingredients">
								<?php
								foreach ($ingredient_results as $ingredient_result) {
									$ingredient_unit = get_term_by('term_id', $ingredient_result->ingredient_unit_term_id, 'ingredient_unit');
									$term_id = $ingredient_result->ingredient_unit_term_id;
									$term_meta = get_option( "taxonomy_$term_id" );
									$unit_abbreviation = $term_meta['ingredient_unit_abbreviation'];
									$unit_name = empty($unit_abbreviation) ? $ingredient_unit->name : $unit_abbreviation;

									$ingredient = get_term_by('term_id', $ingredient_result->ingredient_term_id, 'ingredient');
									$ingredient_link = get_term_link( (int)$ingredient_result->ingredient_term_id, 'ingredient' );

									echo "<dt>" . SocialChef_Theme_Utils::convert_decimal_to_fraction($ingredient_result->amount) . " $unit_name</dt>";
									echo "<dd itemprop='ingredients'><a href='" . esc_url( $ingredient_link ) . "'>" . $ingredient->name . "</a></dd>";
								}
								?>
							</dl>
							<?php } ?>

							<div class="favorite2">
								 <a class="" href="<?php get_template_directory_uri() ?>/pre_prod/contact-2/?a=<?php the_title(); ?> "><i class="ico eldorado_heart"></i> <span><?php _e('Je m’intéresse', 'socialchef'); ?></span></a>
							</div>
							<div class="print">
								<a class="" onclick="window.print();" href="#"><i class="ico eldorado_print"></i> <span><?php _e('Imprimer l\'offre', 'socialchef'); ?></span></a>
							</div>
						</div><!--// one-third -->
						<!--two-third-->
						<div class="two-third">
							<?php
							$main_image = $recipe_obj->get_main_image('content-image');
							if ( !empty( $main_image ) ) { ?>
							<div class="image"><img itemprop="image" src="<?php echo esc_url( $main_image ) ?>" alt="<?php the_title(); ?>" /></div>
							<?php } ?>
							<?php if (strlen($post->post_content) > 0) { ?>
							<div class="intro" itemprop="description">
								<?php the_content(); ?>
							</div>
							<?php } ?>
							<?php
							if (isset($recipe_instructions)){
							if (count($recipe_instructions) > 0) { ?>
							<div class="instructions" itemprop="recipeInstructions">
								<ol>
								<?php
								$instructions_array = unserialize($recipe_instructions);
								for ( $i = 0; $i < count($instructions_array); $i++ ) {
									$instruction = $instructions_array[$i]['instruction'];
									echo '<li>';
									echo $instruction;
									echo '</li>';
								}?>
								</ol>
							</div>
							<?php }} ?>
						</div>
						<!--//two-third-->
					</div><!--//row-->
				</article><!--//recipe-->
				<?php comments_template( '', true ); ?>
				<!--//recipe entry-->
			</section>
			<?php get_sidebar('right-recipe'); ?>
		</div><!--//hentry-->
	</div><!--//row-->
<?php
endwhile;
get_footer( 'buddypress' );