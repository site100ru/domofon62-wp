<?php
	
	// Template Name: Single uslugi
	// Template Post Type: uslugi
	
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


<?php
	
	while( have_posts() ) { the_post();
		the_content();
	}
	
	get_footer( '2' );
	
?>