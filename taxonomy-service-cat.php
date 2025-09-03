<?php get_header( '4' ); ?>


<section class="light-grey-bg">
	<div class="container pb-5">
		<div class="row">
			<div class="col pt-3 pb-5">
				<?php if ( function_exists( 'kama_breadcrumbs' ) ) kama_breadcrumbs( ' /' ); ?>
			</div>
		</div>
		<div class="row d-flex justify-content-center px-md-220 px-md-50">
			<?php
				while( have_posts() ) { the_post(); ?>
					<div class="col-12 col-md-6 col-lg-4 p-2 d-flex justify-content-center"> 
						<a href="<?php echo get_permalink(); ?>">
							<div class="inner-serv-wrap">
								<div class="oneimg-wrap">
									<img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="Подъездный домофон" class="oneu-bg-img img-fluid" />
								</div>
								<div class="under-inner-serv-wrap">
									<div class="under-inner-text-wrap p-2">
										<h3 class="title-h3"><?php echo get_the_title(); ?></h3>
										<p class="under-title-h3"><?php echo get_the_excerpt(); ?></p>
									</div>
									<a href="<?php echo get_permalink(); ?>" class="inner-serv-btn">Узнать подробнее</a>
								</div>
							</div>
						</a>
					</div>
				<?php }
			?>
		</div>
	</div>
</section>


<?php get_footer( '2' ); ?>