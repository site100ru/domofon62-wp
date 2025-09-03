<?php
	
	/**
	 * The main template file
	 *
	 * This is the most generic template file in a WordPress theme
	 * and one of the two required files for a theme (the other being style.css).
	 * It is used to display a page when nothing more specific matches a query.
	 * E.g., it puts together the home page when no home.php file exists.
	 *
	 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
	 *
	 * @package Dom Of Two
	 */

	get_header( '4' );
	
?>


<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<h3><?php the_title(); ?></h3>

<?php the_content(); ?>
<?php wp_link_pages(); ?>
<?php edit_post_link(); ?>

<?php endwhile; ?>

<?php
if ( get_next_posts_link() ) {
next_posts_link();
}
?>
<?php
if ( get_previous_posts_link() ) {
previous_posts_link();
}
?>

<?php else: ?>

<section class="light-grey-bg"> 
	<div class="container">
		<div class="py-5 d-flex justify-content-center align-items-center">
			<div class="d-flex flex-column justify-content-center">
				<h1 class="page404-num text-center">404</h1>
				<h2 class="page404-text mt-3">Страница не найдена</h2>
			</div>
		</div>
	</div>
</section>

<?php endif; ?>

<?php

get_footer( '2' );