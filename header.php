<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> and <header> sections 
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Dom Of Two
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>

	<?php if ( 'uslugi' == get_post_type() ): ?>
		<title>Наши услуги | <?php bloginfo('name'); ?></title>
	<?php elseif ( 'objekty' == get_post_type() ): ?>
		<title>Наши объекты | <?php bloginfo('name'); ?></title>
	<?php else: ?>
		<title><?php wp_title(' | ', true, 'right'); ?></title>
	<?php endif; ?>
    
  
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
	<!-- Новые стили только для новых страниц -->
	<link rel="stylesheet" href='<?php echo get_template_directory_uri(); ?>/css/theme.css'>

</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>


<header> 
    <nav>
		<div class="container-fluid-md">
			<label class="menu-button" aria-hidden="true">
				<span class="bread bread-top">
					<span class="ham ham-top"></span>
				</span>
				<span class="bread bread-bottom">
					<span class="ham ham-bottom"></span>
				</span>
			</label>
		  
			<a href="#" data-bs-toggle="modal" data-bs-target="#dostupModal" class="top-btn">
				<div class="action-btn d-md-none">Получить доступ</div>
			</a> 
		  
			<?php
				wp_nav_menu( array(
					'theme_location'  => 'domofontwo_main_menu',
					'depth'           => 2 // 1 = no dropdowns, 2 = with dropdowns.
				) );
			?>
		</div>
    </nav>
</header>


<div class="container d-flex align-items-center justify-content-between">
	<div class="d-flex align-items-center py-3">
		<a href="<?php echo home_url( '/' ); ?>">
			<?php if(has_custom_logo() ): ?>
			<?php the_custom_logo(); ?>
			<?php else: ?>
				<p class="site-title"><?php bloginfo( 'title' ); ?></p>
				<span><?php bloginfo( 'description' ); ?></span>
			<?php endif; ?>
		</a>
		<p class="string-ryazan"><?php $header_desc = get_field('header_desc', 5); 
		echo $header_desc; ?></p>
	</div>
	<div class="d-flex align-items-center">
		<div class="me-lg-3 d-none d-md-block">
			<p class="chasy"><?php $header_hours = get_field('header_hours', 5); echo $header_hours; ?></p>
			<p class="tel-header"><a href="tel:+<?php $header_phone = get_field('header_phone', 5); $phone = preg_replace('/\D+/', '', $header_phone); echo $phone; ?>"><?php echo $header_phone; ?></a></p>
		</div>
		<a href="#" class="d-lg-none" data-bs-toggle="modal" data-bs-target="#dostupModal">
			<div class="action-btn d-lg-none"> <!-- d-none d-lg-block -->
				<?php $header_btn_text = get_field('header_btn_text', 5); echo $header_btn_text; ?>
			</div>
		</a>
	</div>
</div>
      

<!-- Modal 2 -->
<div class="modal fade" id="dostupModal" tabindex="-1" aria-labelledby="dostupModalLabel" aria-hidden="true">
	<div class="popups modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<h2 class="product-modal-title" id="dostupModalLabel">Для получения доступа к услугам заполните форму:</h2>
			<div class="modal-body">
				<div class="text-center"><?php echo do_shortcode('[contact-form-7 id="373" title="Форма получить доступ"]'); ?></div>  
			</div>
		</div>
	</div>
</div>