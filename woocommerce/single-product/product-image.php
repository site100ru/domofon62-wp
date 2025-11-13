<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * @package WooCommerce\Templates
 * @version 7.8.0
 */

defined( 'ABSPATH' ) || exit;

// Note: `wc_get_gallery_image_html` was added in WC 3.3.2 and did not exist prior. This check protects against theme overrides being used on older versions of WC.
if ( ! function_exists( 'wc_get_gallery_image_html' ) ) {
	return;
}

global $product;

$columns           = apply_filters( 'woocommerce_product_thumbnails_columns', 4 );
$post_thumbnail_id = $product->get_image_id();
$wrapper_classes   = apply_filters(
	'woocommerce_single_product_image_gallery_classes',
	array(
		'woocommerce-product-gallery',
		'woocommerce-product-gallery--' . ( $post_thumbnail_id ? 'with-images' : 'without-images' ),
		'woocommerce-product-gallery--columns-' . absint( $columns ),
		'images',
	)
);
?>
<div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', $wrapper_classes ) ) ); ?>" data-columns="<?php echo esc_attr( $columns ); ?>" style="opacity: 0; transition: opacity .25s ease-in-out;">
	<figure class="woocommerce-product-gallery__wrapper">
		<?php
		if ( $post_thumbnail_id ) {
			$html = wc_get_gallery_image_html( $post_thumbnail_id, true );
		} else {
			$html  = '<div class="woocommerce-product-gallery__image--placeholder">';
			$html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src( 'woocommerce_single' ) ), esc_html__( 'Awaiting product image', 'woocommerce' ) );
			$html .= '</div>';
		}

		echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $post_thumbnail_id ); // phpcs:disable WordPress.XSS.EscapeOutput.OutputNotEscaped

		do_action( 'woocommerce_product_thumbnails' );
		?>
	</figure>
</div>

<!-- Modal Gallery for Product Images -->
<div class="modal fade" id="imageGalleryModal" tabindex="-1" aria-labelledby="imageGalleryModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="imageGalleryModalLabel">Галерея изображений</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
			</div>
			<div class="modal-body p-0">
				<div id="productGalleryCarousel" class="carousel slide" data-bs-ride="false">
					<div class="carousel-inner" id="carouselImages">
						<!-- Images will be inserted here dynamically -->
					</div>
					<button class="carousel-control-prev" type="button" data-bs-target="#productGalleryCarousel" data-bs-slide="prev">
						<span class="carousel-control-prev-icon" aria-hidden="true"></span>
						<span class="visually-hidden">Предыдущий</span>
					</button>
					<button class="carousel-control-next" type="button" data-bs-target="#productGalleryCarousel" data-bs-slide="next">
						<span class="carousel-control-next-icon" aria-hidden="true"></span>
						<span class="visually-hidden">Следующий</span>
					</button>
				</div>
				<!-- Thumbnails Navigation (Optional) -->
				<div class="carousel-indicators-wrapper mt-3 px-3 pb-3">
					<div class="d-flex justify-content-center flex-wrap gap-2" id="carouselThumbnails">
						<!-- Thumbnail images will be inserted here -->
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
jQuery(document).ready(function($) {
	// Собираем все изображения из галереи WooCommerce
	var galleryImages = [];
	
	$('.woocommerce-product-gallery__wrapper .woocommerce-product-gallery__image').each(function(index) {
		var $link = $(this).find('a');
		var imgSrc = $link.attr('href');
		var imgAlt = $(this).find('img').attr('alt') || 'Изображение товара';
		var thumbSrc = $(this).find('img').attr('src');
		
		if (imgSrc) {
			galleryImages.push({
				src: imgSrc,
				alt: imgAlt,
				thumb: thumbSrc,
				index: index
			});
		}
	});
	
	// Функция для создания слайдов
	function createCarouselSlides(startIndex) {
		$('#carouselImages').empty();
		$('#carouselThumbnails').empty();
		
		galleryImages.forEach(function(img, index) {
			var activeClass = index === startIndex ? 'active' : '';
			
			// Создаем слайд
			var carouselItem = `
				<div class="carousel-item ${activeClass}">
					<img src="${img.src}" class="d-block w-100" alt="${img.alt}">
				</div>
			`;
			$('#carouselImages').append(carouselItem);
			
			// Создаем миниатюру
			var thumbActiveClass = index === startIndex ? 'active' : '';
			var thumbnail = `
				<div class="carousel-thumbnail ${thumbActiveClass}" data-bs-target="#productGalleryCarousel" data-bs-slide-to="${index}">
					<img src="${img.thumb}" alt="${img.alt}" class="img-thumbnail" style="width: 80px; height: 80px; object-fit: cover; cursor: pointer;">
				</div>
			`;
			$('#carouselThumbnails').append(thumbnail);
		});
		
		// Обработчик клика по миниатюрам
		$('.carousel-thumbnail').on('click', function() {
			var slideIndex = $(this).data('bs-slide-to');
			var carousel = bootstrap.Carousel.getInstance(document.getElementById('productGalleryCarousel'));
			carousel.to(slideIndex);
		});
		
		// Обновляем активную миниатюру при переключении слайдов
		$('#productGalleryCarousel').on('slide.bs.carousel', function (e) {
			$('.carousel-thumbnail').removeClass('active');
			$('.carousel-thumbnail').eq(e.to).addClass('active');
		});
	}
	
	// Клик по изображению в галерее товара
	$('.woocommerce-product-gallery__image a').on('click', function(e) {
		e.preventDefault();
		
		var clickedIndex = $(this).closest('.woocommerce-product-gallery__image').index();
		
		// Создаем слайды начиная с кликнутого изображения
		createCarouselSlides(clickedIndex);
		
		// Показываем модальное окно
		var modal = new bootstrap.Modal(document.getElementById('imageGalleryModal'));
		modal.show();
	});
	
	// Навигация клавиатурой в модальном окне
	$('#imageGalleryModal').on('shown.bs.modal', function () {
		$(document).on('keydown.gallery', function(e) {
			var carousel = bootstrap.Carousel.getInstance(document.getElementById('productGalleryCarousel'));
			if (e.key === 'ArrowLeft') {
				carousel.prev();
			} else if (e.key === 'ArrowRight') {
				carousel.next();
			} else if (e.key === 'Escape') {
				bootstrap.Modal.getInstance(document.getElementById('imageGalleryModal')).hide();
			}
		});
	});
	
	// Отключаем навигацию клавиатурой при закрытии модального окна
	$('#imageGalleryModal').on('hidden.bs.modal', function () {
		$(document).off('keydown.gallery');
	});
});
</script>