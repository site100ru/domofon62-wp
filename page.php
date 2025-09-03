<?php
	
	// Template Name: Single page
	// Template Post Type: page
	
	get_header( '4' );
	
?>


<section class="light-grey-bg">
	<div class="container">
		<div class="row">
			<div class="col pt-3 pb-5">
				<?php if ( function_exists( 'kama_breadcrumbs' ) ) kama_breadcrumbs( ' /' ); ?>
			</div>
		</div>
	</div>
</section>


<?php while( have_posts() ) { the_post() ; ?>
<section class="light-grey-bg pb-5">
	<div class="container">
		<div class="row">
			<div class="col">
				<h1 class="catalog-goods-h1-second"><?php the_title(); ?></h1>
				<?php the_content(); ?>
			</div>
		</div>
	</div>
</section>
<?php } ?>


<?php get_footer( '2' ); ?>