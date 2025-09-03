<?php
/**
 * Dom Of Two functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Dom Of Two 
 */
  

add_action( 'wp_enqueue_scripts', 'domofontwo_scripts' );
function domofontwo_scripts() {
	//wp_enqueue_script( 'bootstrap-js', get_template_directory_uri() . '/bootstrap-5.0.2-dist/js/bootstrap.min.js', array( 'jquery' ), '5.0.2', true );
	wp_enqueue_style( 'bootstrap-css', get_template_directory_uri() . '/bootstrap-5.0.2-dist/css/bootstrap.min.css', array(), '5.0.2', 'all' ); 
	wp_enqueue_script( 'slick-js', get_template_directory_uri() . '/slick/slick.min.js', array( 'jquery' ), '0.8.1', true );
	wp_enqueue_style( 'slick-css', get_template_directory_uri() . '/slick/slick.css', array(), '0.8.1', 'all' ); 
	wp_enqueue_script( 'custom-js', get_template_directory_uri() . '/js/custom.js', array( 'jquery' ), '0.0.1', true );
	wp_enqueue_style( 'domofontwo-style', get_stylesheet_uri(), array(), filemtime( get_template_directory() . '/style.css'), 'all' );
}


// Register a new menu
function domofontwo_config() {
	register_nav_menus(
		array(
		   'domofontwo_main_menu' => 'Главное Меню',
		   'new-main-menu' => 'Новое главное меню',
		   'domofontwo_footer_menu_pages' => 'Меню в Футере слева',
		   'domofontwo_footer_menu_products' => 'Меню в Футере справа'
		)
	);
}


add_action( 'after_setup_theme', 'domofontwo_config', 0 );


//register_nav_menu('main-menu', 'Main menu');


add_theme_support( 'custom-logo', array( 
	// 'height'  => 55,
	// 'width'   => 241,
	'flex_height'   => true,
	'flex_width'    => true
) );


// Woo
function mytheme_add_woocommerce_support() {
	add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'mytheme_add_woocommerce_support' );


remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );

/* Каталог */
function price_new_wrap() {
	global $product;
	$id = $product->get_id();

	$url = get_permalink( $id );
	$price = $product->get_price();
	?>
		<div class="row align-items-center">
			<div class="col-6 col-md-12">
				<p class="product-price mb-0 mb-md-3"><?php echo $price; ?> руб</p>
			</div>
			<div class="col-6 col-md-12">
				<!--a href="<?php echo $url;  ?>" class="buy-btn">Заказать</a-->
				<?php $product = wc_get_product( get_the_ID() ); /* get the WC_Product Object */ ?>
				<object>
					<a href="#" onclick="getName( '<?php echo $product->name; ?>' );" class="buy-btn" data-bs-toggle="modal" data-bs-target="#productModal">Заказать</a>
				</object>
			</div>
		</div>
	<?php
}
add_action( 'woocommerce_after_shop_loop_item_title', 'price_new_wrap', 10 );


remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
   

function woocommerce_template_loop_product_title() {
    ?>
    <p class="product-price-title"><?php echo get_the_title(); ?></p>
    <?php
}

	//remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
	//remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );

   /**
 * Change several of the breadcrumb defaults
 */
add_filter( 'woocommerce_breadcrumb_defaults', 'custom_woocommerce_breadcrumbs' );
function custom_woocommerce_breadcrumbs() {
    return array(
            'delimiter'   => ' &#47; ',
            'wrap_before' => '<div class="pt-3 pb-5">',
            'wrap_after'  => '</div>',
            'before'      => '',
            'after'       => '',
            'home'        => _x( 'Home', 'breadcrumb', 'woocommerce' ),
        );
}

// add_action( 'woocommerce_before_single_product_summary', 'wrap_div_single_image_top', 8 );

// function wrap_div_single_image_top() {
//    echo "<div class='warap-of-wrap'>";
// }

// add_action( 'woocommerce_product_thumbnails', 'wrap_div_single_image_bottom', 18 );

// function wrap_div_single_image_bottom() {
//    echo "</div>";
// }

remove_action( 'woocommerce_simple_add_to_cart', 'woocommerce_simple_add_to_cart', 30 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );

add_action( 'woocommerce_simple_add_to_cart', 'add_action_button_single', 30 );
/* Single product */
function add_action_button_single() {
   $product = wc_get_product( get_the_ID() ); /* get the WC_Product Object */ ?>
   <div class="single-price-bg d-inline-flex d-md-flex align-items-center"><span class="single-product-price pe-3 pe-md-auto"><?php echo $product->get_price(); ?> руб.</span><a href="#" class="single-product-btn" data-bs-toggle="modal" data-bs-target="#productModal" onclick="getName( '<?php echo $product->name; ?>' );">Заказать</a></div>
   <?php
}

remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);  

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );

/* Меняем места сортировку и отображение количества выведеных товаров */
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
add_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 10 );







	// Create taxonomy
	add_action( 'init', 'create_taxonomy' );
	function create_taxonomy(){
		
		register_taxonomy( 'service-cat', [ 'service' ], [
			'label'                 => '', // определяется параметром $labels->name
			'labels'                => [
				'name'              => 'Категории услуг',
				'singular_name'     => 'Категория услуги',
				'search_items'      => 'Искать категорию услуги',
				'all_items'         => 'Все категории услуг',
				'view_item '        => 'Смотреть категорию услуг',
				'parent_item'       => 'Родительская категория услуги',
				'parent_item_colon' => 'Parent Genre:',
				'edit_item'         => 'Редактировать категорию услуг',
				'update_item'       => 'Обновить категорию услуг',
				'add_new_item'      => 'Добавить новую категорию услуг',
				'new_item_name'     => 'Новая категория услуги',
				'menu_name'         => 'Категории услуг',
				'back_to_items'     => '← Вернуться к категориям услуг',
			],
			'description'           => '', // описание таксономии
			'public'                => true,
			// 'publicly_queryable'    => null, // равен аргументу public
			// 'show_in_nav_menus'     => true, // равен аргументу public
			// 'show_ui'               => true, // равен аргументу public
			// 'show_in_menu'          => true, // равен аргументу show_ui
			// 'show_tagcloud'         => true, // равен аргументу show_ui
			// 'show_in_quick_edit'    => null, // равен аргументу show_ui
			'hierarchical'          => true,

			'rewrite'               => true,
			//'query_var'             => $taxonomy, // название параметра запроса
			'capabilities'          => array(),
			'meta_box_cb'           => null, // html метабокса. callback: `post_categories_meta_box` или `post_tags_meta_box`. false — метабокс отключен.
			'show_admin_column'     => false, // авто-создание колонки таксы в таблице ассоциированного типа записи. (с версии 3.5)
			'show_in_rest'          => null, // добавить в REST API
			'rest_base'             => null, // $taxonomy
			// '_builtin'              => false,
			//'update_count_callback' => '_update_post_term_count',
		] );
		
		/* Категории услуг (новых) */
		register_taxonomy('uslugi-cat', 'uslugi', array(
			'labels' => array(
				'name' => 'Категории услуг',
				'singular_name' => 'Категория',
			),
			'public' => true,
			'hierarchical' => true, // true — как категории, false — как метки
			'rewrite' => array(
				'slug' => 'uslugi', // URL будет /uslugi/категория/
				'with_front' => false,
			),
		));

	}
	
	
	// Register post type
	add_action( 'init', 'register_post_types' );
	function register_post_types(){
		
		register_post_type( 'service', [
			'label'  => null,
			'labels' => [
				'name'               => 'Услуги', // основное название для типа записи
				'all_items'			 => 'Все услуги', // основное название для типа записи
				'singular_name'      => 'Услуга', // название для одной записи этого типа
				'add_new'            => 'Добавить услугу', // для добавления новой записи
				'add_new_item'       => 'Добавление', // заголовка у вновь создаваемой записи в админ-панели.
				'edit_item'          => 'Редактировать', // для редактирования типа записи
				'new_item'           => 'Новая услуга', // текст новой записи
				'view_item'          => 'Смотреть', // для просмотра записи этого типа.
				'search_items'       => 'Искать', // для поиска по этим типам записи
				'not_found'          => 'Не найдено', // если в результате поиска ничего не было найдено
				'not_found_in_trash' => 'Не найдено в корзине', // если не было найдено в корзине
				'parent_item_colon'  => '', // для родителей (у древовидных типов)
				'menu_name'          => 'Услуги', // название меню
			],
			'description'            => '',
			'public'                 => true,
			// 'publicly_queryable'  => null, // зависит от public
			// 'exclude_from_search' => null, // зависит от public
			// 'show_ui'             => null, // зависит от public
			// 'show_in_nav_menus'   => null, // зависит от public
			'show_in_menu'           => null, // показывать ли в меню админки
			// 'show_in_admin_bar'   => null, // зависит от show_in_menu
			'show_in_rest'        => null, // добавить в REST API. C WP 4.7
			'rest_base'           => null, // $post_type. C WP 4.7
			'menu_position'       => null,
			'menu_icon'           => null,
			//'capability_type'   => 'post',
			//'capabilities'      => 'post', // массив дополнительных прав для этого типа записи
			//'map_meta_cap'      => null, // Ставим true чтобы включить дефолтный обработчик специальных прав
			'hierarchical'        => false,
			'supports'            => [ 'title', 'editor', 'excerpt', 'thumbnail' ], // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
			'taxonomies'          => [ 'service-cat' ],
			'has_archive'         => true,
			'rewrite'             => true,
			'query_var'           => true,
		] );
		
		
		/* Новый тип записи Услуги */
		register_post_type('uslugi', array(
			'labels' => array(
				'name' => 'Услуги',
				'singular_name' => 'Услуга',
			),
			'public' => true,
			'has_archive' => 'uslugi', // Архив по адресу /uslugi/
			'rewrite'      => array(
			      	'slug' => 'uslugi/%uslugi-cat%', // Базовый URL для записей (/uslugi/%категория%/%запись%/)
			  'with_front' => false, // Убрать префикс (например, /blog/)
			),
			'hierarchical' => false,
			'supports'     => array('title', 'editor', 'thumbnail', 'excerpt'),
			'taxonomies'   => [ 'uslugi-cat' ],
			
		));

	}
	
	//Чтобы WordPress включал категорию в URL (/uslugi/категория/запись/), добавьте фильтр:
	function custom_post_type_permalink($permalink, $post, $leavename) {
		if ($post->post_type == 'uslugi') {
			$terms = get_the_terms($post->ID, 'uslugi-cat');
			if ($terms && !is_wp_error($terms)) {
				$term_slug = current($terms)->slug;
				$permalink = str_replace('%uslugi-cat%', $term_slug, $permalink);
			}
		}
		return $permalink;
	}
	add_filter('post_type_link', 'custom_post_type_permalink', 10, 3);
	

	function custom_breadcrumbs() {
		$sep = ' » ';
		echo '<div class="breadcrumbs">';
		echo '<a href="' . home_url() . '">Главная</a>' . $sep;

		// Архив записей "uslugi"
		if (is_post_type_archive('uslugi')) {
			echo '<span>Услуги</span>';
		}
		// Таксономия "uslugi_cat"
		elseif (is_tax('uslugi_cat')) {
			echo '<a href="' . get_post_type_archive_link('uslugi') . '">Услуги</a>' . $sep;
			$term = get_queried_object();
			echo '<span>' . $term->name . '</span>';
		}
		// Одиночная запись "uslugi"
		elseif (is_singular('uslugi')) {
			$terms = get_the_terms(get_the_ID(), 'uslugi_cat');
			echo '<a href="' . get_post_type_archive_link('uslugi') . '">Услуги</a>' . $sep;
			if ($terms) {
				$term = array_shift($terms);
				echo '<a href="' . get_term_link($term) . '">' . $term->name . '</a>' . $sep;
			}
			echo '<span>' . get_the_title() . '</span>';
		}
		echo '</div>';
	}

	
	/**
	 * Хлебные крошки для WordPress (breadcrumbs)
	 *
	 * @param string $sep  Разделитель. По умолчанию ' » '.
	 * @param array  $l10n Для локализации. См. переменную `$default_l10n`.
	 * @param array  $args Опции. Смотрите переменную `$def_args`.
	 *
	 * @return void Выводит на экран HTML код
	 *
	 * version 3.3.3
	 */
	function kama_breadcrumbs( $sep = ' » ', $l10n = array(), $args = array() ){
		$kb = new Kama_Breadcrumbs;
		echo $kb->get_crumbs( $sep, $l10n, $args );
	}

	class Kama_Breadcrumbs {

		public $arg;

		// Локализация
		static $l10n = [
			'home'       => 'Главная',
			'paged'      => 'Страница %d',
			'_404'       => 'Ошибка 404',
			'search'     => 'Результаты поиска по запросу - <b>%s</b>',
			'author'     => 'Архив автора: <b>%s</b>',
			'year'       => 'Архив за <b>%d</b> год',
			'month'      => 'Архив за: <b>%s</b>',
			'day'        => '',
			'attachment' => 'Медиа: %s',
			'tag'        => 'Записи по метке: <b>%s</b>',
			'tax_tag'    => '%1$s из "%2$s" по тегу: <b>%3$s</b>',
			// tax_tag выведет: 'тип_записи из "название_таксы" по тегу: имя_термина'.
			// Если нужны отдельные холдеры, например только имя термина, пишем так: 'записи по тегу: %3$s'
		];

		// Параметры по умолчанию
		static $args = [
			// выводить крошки на главной странице
			'on_front_page'   => true,
			// показывать ли название записи в конце (последний элемент). Для записей, страниц, вложений
			'show_post_title' => true,
			// показывать ли название элемента таксономии в конце (последний элемент). Для меток, рубрик и других такс
			'show_term_title' => true,
			// шаблон для последнего заголовка. Если включено: show_post_title или show_term_title
			'title_patt'      => '<span class="kb_title">%s</span>',
			// показывать последний разделитель, когда заголовок в конце не отображается
			'last_sep'        => true,
			// 'markup' - микроразметка. Может быть: 'rdf.data-vocabulary.org', 'schema.org', '' - без микроразметки
			// или можно указать свой массив разметки:
			// array( 'wrappatt'=>'<div class="kama_breadcrumbs">%s</div>', 'linkpatt'=>'<a href="%s">%s</a>', 'sep_after'=>'', )
			'markup'          => 'schema.org',
			// приоритетные таксономии, нужно когда запись в нескольких таксах
			'priority_tax'    => [ 'category' ],
			// 'priority_terms' - приоритетные элементы таксономий, когда запись находится в нескольких элементах одной таксы одновременно.
			// Например: array( 'category'=>array(45,'term_name'), 'tax_name'=>array(1,2,'name') )
			// 'category' - такса для которой указываются приор. элементы: 45 - ID термина и 'term_name' - ярлык.
			// порядок 45 и 'term_name' имеет значение: чем раньше тем важнее. Все указанные термины важнее неуказанных...
			'priority_terms'  => [],
			// добавлять rel=nofollow к ссылкам?
			'nofollow'        => false,

			// служебные
			'sep'             => '',
			'linkpatt'        => '',
			'pg_end'          => '',
		];

		function get_crumbs( $sep, $l10n, $args ){
			global $post, $wp_post_types;

			self::$args['sep'] = $sep;

			// Фильтрует дефолты и сливает
			$loc = (object) array_merge( apply_filters( 'kama_breadcrumbs_default_loc', self::$l10n ), $l10n );
			$arg = (object) array_merge( apply_filters( 'kama_breadcrumbs_default_args', self::$args ), $args );

			$arg->sep = '<span class="kb_sep">' . $arg->sep . '</span>'; // дополним

			// упростим
			$sep = & $arg->sep;
			$this->arg = & $arg;

			// микроразметка ---
			if(1){
				$mark = & $arg->markup;

				// Разметка по умолчанию
				if( ! $mark ){
					$mark = [
						'wrappatt'  => '<div class="kama_breadcrumbs">%s</div>',
						'linkpatt'  => '<a href="%s">%s</a>',
						'sep_after' => '',
					];
				}
				// rdf
				elseif( $mark === 'rdf.data-vocabulary.org' ){
					$mark = [
						'wrappatt'  => '<div class="kama_breadcrumbs" prefix="v: http://rdf.data-vocabulary.org/#">%s</div>',
						'linkpatt'  => '<span typeof="v:Breadcrumb"><a href="%s" rel="v:url" property="v:title">%s</a>',
						'sep_after' => '</span>', // закрываем span после разделителя!
					];
				}
				// schema.org
				elseif( $mark === 'schema.org' ){
					$mark = [
						'wrappatt'  => '<div class="kama_breadcrumbs" itemscope itemtype="http://schema.org/BreadcrumbList">%s</div>',
						'linkpatt'  => '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="%s" itemprop="item"><span itemprop="name">%s</span></a></span>',
						'sep_after' => '',
					];
				}

				elseif( ! is_array( $mark ) ){
					die( __CLASS__ . ': "markup" parameter must be array...' );
				}

				$wrappatt = $mark['wrappatt'];
				$arg->linkpatt = $arg->nofollow ? str_replace( '<a ', '<a rel="nofollow"', $mark['linkpatt'] ) : $mark['linkpatt'];
				$arg->sep .= $mark['sep_after'] . "\n";
			}

			$linkpatt = $arg->linkpatt; // упростим

			$q_obj = get_queried_object();

			// может это архив пустой таксы
			$ptype = null;
			if( ! $post ){
				if( isset( $q_obj->taxonomy ) ){
					$ptype = $wp_post_types[ get_taxonomy( $q_obj->taxonomy )->object_type[0] ];
				}
			}
			else{
				$ptype = $wp_post_types[ $post->post_type ];
			}

			// paged
			$arg->pg_end = '';
			$paged_num = get_query_var( 'paged' ) ?: get_query_var( 'page' );
			if( $paged_num ){
				$arg->pg_end = $sep . sprintf( $loc->paged, (int) $paged_num );
			}

			$pg_end = $arg->pg_end; // упростим

			$out = '';

			if( is_front_page() ){
				return $arg->on_front_page ? sprintf( $wrappatt, ( $paged_num ? sprintf( $linkpatt, get_home_url(), $loc->home ) . $pg_end : $loc->home ) ) : '';
			}
			// страница записей, когда для главной установлена отдельная страница.
			elseif( is_home() ){
				$out = $paged_num ? ( sprintf( $linkpatt, get_permalink( $q_obj ), esc_html( $q_obj->post_title ) ) . $pg_end ) : esc_html( $q_obj->post_title );
			}
			elseif( is_404() ){
				$out = $loc->_404;
			}
			elseif( is_search() ){
				$out = sprintf( $loc->search, esc_html( $GLOBALS['s'] ) );
			}
			elseif( is_author() ){
				$tit = sprintf( $loc->author, esc_html( $q_obj->display_name ) );
				$out = ( $paged_num ? sprintf( $linkpatt, get_author_posts_url( $q_obj->ID, $q_obj->user_nicename ) . $pg_end, $tit ) : $tit );
			}
			elseif( is_year() || is_month() || is_day() ){
				$y_url = get_year_link( $year = get_the_time( 'Y' ) );

				if( is_year() ){
					$tit = sprintf( $loc->year, $year );
					$out = ( $paged_num ? sprintf( $linkpatt, $y_url, $tit ) . $pg_end : $tit );
				}
				// month day
				else{
					$y_link = sprintf( $linkpatt, $y_url, $year );
					$m_url = get_month_link( $year, get_the_time( 'm' ) );

					if( is_month() ){
						$tit = sprintf( $loc->month, get_the_time( 'F' ) );
						$out = $y_link . $sep . ( $paged_num ? sprintf( $linkpatt, $m_url, $tit ) . $pg_end : $tit );
					}
					elseif( is_day() ){
						$m_link = sprintf( $linkpatt, $m_url, get_the_time( 'F' ) );
						$out = $y_link . $sep . $m_link . $sep . get_the_time( 'l' );
					}
				}
			}
			// Древовидные записи
			elseif( is_singular() && $ptype->hierarchical ){
				$out = $this->_add_title( $this->_page_crumbs( $post ), $post );
			}
			// Таксы, плоские записи и вложения
			else {
				$term = $q_obj; // таксономии

				// определяем термин для записей (включая вложения attachments)
				if( is_singular() ){
					// изменим $post, чтобы определить термин родителя вложения
					if( is_attachment() && $post->post_parent ){
						$save_post = $post; // сохраним
						$post = get_post( $post->post_parent );
					}

					// учитывает если вложения прикрепляются к таксам древовидным - все бывает :)
					$taxonomies = get_object_taxonomies( $post->post_type );
					// оставим только древовидные и публичные, мало ли...
					$taxonomies = array_intersect( $taxonomies, get_taxonomies( [
						'hierarchical' => true,
						'public'       => true,
					] ) );

					if( $taxonomies ){
						// сортируем по приоритету
						if( ! empty( $arg->priority_tax ) ){

							usort( $taxonomies, static function( $a, $b ) use ( $arg ) {
								$a_index = array_search( $a, $arg->priority_tax );
								if( $a_index === false ){
									$a_index = 9999999;
								}

								$b_index = array_search( $b, $arg->priority_tax );
								if( $b_index === false ){
									$b_index = 9999999;
								}

								return ( $b_index === $a_index ) ? 0 : ( $b_index < $a_index ? 1 : -1 ); // меньше индекс - выше
							} );
						}

						// пробуем получить термины, в порядке приоритета такс
						foreach( $taxonomies as $taxname ){

							if( $terms = get_the_terms( $post->ID, $taxname ) ){
								// проверим приоритетные термины для таксы
								$prior_terms = &$arg->priority_terms[ $taxname ];

								if( $prior_terms && count( $terms ) > 2 ){

									foreach( (array) $prior_terms as $term_id ){
										$filter_field = is_numeric( $term_id ) ? 'term_id' : 'slug';
										$_terms = wp_list_filter( $terms, [ $filter_field => $term_id ] );

										if( $_terms ){
											$term = array_shift( $_terms );
											break;
										}
									}
								}
								else{
									$term = array_shift( $terms );
								}

								break;
							}
						}
					}

					// вернем обратно (для вложений)
					if( isset( $save_post ) ){
						$post = $save_post;
					}
				}

				// вывод

				// все виды записей с терминами или термины
				if( $term && isset( $term->term_id ) ){
					$term = apply_filters( 'kama_breadcrumbs_term', $term );

					// attachment
					if( is_attachment() ){
						if( ! $post->post_parent ){
							$out = sprintf( $loc->attachment, esc_html( $post->post_title ) );
						}
						else{
							if( ! $out = apply_filters( 'attachment_tax_crumbs', '', $term, $this ) ){
								$_crumbs = $this->_tax_crumbs( $term, 'self' );
								$parent_tit = sprintf( $linkpatt, get_permalink( $post->post_parent ), get_the_title( $post->post_parent ) );
								$_out = implode( $sep, [ $_crumbs, $parent_tit ] );
								$out = $this->_add_title( $_out, $post );
							}
						}
					}
					// single
					elseif( is_single() ){
						if( ! $out = apply_filters( 'post_tax_crumbs', '', $term, $this ) ){
							$_crumbs = $this->_tax_crumbs( $term, 'self' );
							$out = $this->_add_title( $_crumbs, $post );
						}
					}
					// не древовидная такса (метки)
					elseif( ! is_taxonomy_hierarchical( $term->taxonomy ) ){
						// метка
						if( is_tag() ){
							$out = $this->_add_title( '', $term, sprintf( $loc->tag, esc_html( $term->name ) ) );
						}
						// такса
						elseif( is_tax() ){
							$post_label = $ptype->labels->name;
							$tax_label = $GLOBALS['wp_taxonomies'][ $term->taxonomy ]->labels->name;
							$out = $this->_add_title( '', $term, sprintf( $loc->tax_tag, $post_label, $tax_label, esc_html( $term->name ) ) );
						}
					}
					// древовидная такса (рибрики)
					elseif( ! $out = apply_filters( 'term_tax_crumbs', '', $term, $this ) ){
						$_crumbs = $this->_tax_crumbs( $term, 'parent' );
						$out = $this->_add_title( $_crumbs, $term, esc_html( $term->name ) );
					}
				}
				// влоежния от записи без терминов
				elseif( is_attachment() ){
					$parent = get_post( $post->post_parent );
					$parent_link = sprintf( $linkpatt, get_permalink( $parent ), esc_html( $parent->post_title ) );
					$_out = $parent_link;

					// вложение от записи древовидного типа записи
					if( is_post_type_hierarchical( $parent->post_type ) ){
						$parent_crumbs = $this->_page_crumbs( $parent );
						$_out = implode( $sep, [ $parent_crumbs, $parent_link ] );
					}

					$out = $this->_add_title( $_out, $post );
				}
				// записи без терминов
				elseif( is_singular() ){
					$out = $this->_add_title( '', $post );
				}
			}

			// замена ссылки на архивную страницу для типа записи
			$home_after = apply_filters( 'kama_breadcrumbs_home_after', '', $linkpatt, $sep, $ptype );

			if( '' === $home_after ){
				// Ссылка на архивную страницу типа записи для: отдельных страниц этого типа; архивов этого типа; таксономий связанных с этим типом.
				if( $ptype && $ptype->has_archive && ! in_array( $ptype->name, [ 'post', 'page', 'attachment' ] )
					&& ( is_post_type_archive() || is_singular() || ( is_tax() && in_array( $term->taxonomy, $ptype->taxonomies ) ) )
				){
					$pt_title = $ptype->labels->name;

					// первая страница архива типа записи
					if( is_post_type_archive() && ! $paged_num ){
						$home_after = sprintf( $this->arg->title_patt, $pt_title );
					}
					// singular, paged post_type_archive, tax
					else{
						$home_after = sprintf( $linkpatt, get_post_type_archive_link( $ptype->name ), $pt_title );

						$home_after .= ( ( $paged_num && ! is_tax() ) ? $pg_end : $sep ); // пагинация
					}
				}
			}

			$before_out = sprintf( $linkpatt, home_url(), $loc->home ) . ( $home_after ? $sep . $home_after : ( $out ? $sep : '' ) );

			$out = apply_filters( 'kama_breadcrumbs_pre_out', $out, $sep, $loc, $arg );

			$out = sprintf( $wrappatt, $before_out . $out );

			return apply_filters( 'kama_breadcrumbs', $out, $sep, $loc, $arg );
		}

		function _page_crumbs( $post ) {
			$parent = $post->post_parent;

			$crumbs = [];
			while( $parent ){
				$page = get_post( $parent );
				$crumbs[] = sprintf( $this->arg->linkpatt, get_permalink( $page ), esc_html( $page->post_title ) );
				$parent = $page->post_parent;
			}

			return implode( $this->arg->sep, array_reverse( $crumbs ) );
		}

		function _tax_crumbs( $term, $start_from = 'self' ) {
			$termlinks = [];
			$term_id = ( $start_from === 'parent' ) ? $term->parent : $term->term_id;
			while( $term_id ){
				$term = get_term( $term_id, $term->taxonomy );
				$termlinks[] = sprintf( $this->arg->linkpatt, get_term_link( $term ), esc_html( $term->name ) );
				$term_id = $term->parent;
			}

			if( $termlinks ){
				return implode( $this->arg->sep, array_reverse( $termlinks ) );
			}

			return '';
		}

		// добалвяет заголовок к переданному тексту, с учетом всех опций. Добавляет разделитель в начало, если надо.
		function _add_title( $add_to, $obj, $term_title = '' ) {

			// упростим...
			$arg = &$this->arg;
			// $term_title чиститься отдельно, теги моугт быть...
			$title = $term_title ?: esc_html( $obj->post_title );
			$show_title = $term_title ? $arg->show_term_title : $arg->show_post_title;

			// пагинация
			if( $arg->pg_end ){
				$link = $term_title ? get_term_link( $obj ) : get_permalink( $obj );
				$add_to .= ( $add_to ? $arg->sep : '' ) . sprintf( $arg->linkpatt, $link, $title ) . $arg->pg_end;
			}
			// дополняем - ставим sep
			elseif( $add_to ){
				if( $show_title ){
					$add_to .= $arg->sep . sprintf( $arg->title_patt, $title );
				}
				elseif( $arg->last_sep ){
					$add_to .= $arg->sep;
				}
			}
			// sep будет потом...
			elseif( $show_title ){
				$add_to = sprintf( $arg->title_patt, $title );
			}

			return $add_to;
		}

	}

	/**
	 * Изменения:
	 * 3.3 - новые хуки: attachment_tax_crumbs, post_tax_crumbs, term_tax_crumbs. Позволяют дополнить крошки таксономий.
	 * 3.2 - баг с разделителем, с отключенным 'show_term_title'. Стабилизировал логику.
	 * 3.1 - баг с esc_html() для заголовка терминов - с тегами получалось криво...
	 * 3.0 - Обернул в класс. Добавил опции: 'title_patt', 'last_sep'. Доработал код. Добавил пагинацию для постов.
	 * 2.5 - ADD: Опция 'show_term_title'
	 * 2.4 - Мелкие правки кода
	 * 2.3 - ADD: Страница записей, когда для главной установлена отделенная страница.
	 * 2.2 - ADD: Link to post type archive on taxonomies page
	 * 2.1 - ADD: $sep, $loc, $args params to hooks
	 * 2.0 - ADD: в фильтр 'kama_breadcrumbs_home_after' добавлен четвертый аргумент $ptype
	 * 1.9 - ADD: фильтр 'kama_breadcrumbs_default_loc' для изменения локализации по умолчанию
	 * 1.8 - FIX: заметки, когда в рубрике нет записей
	 * 1.7 - Улучшена работа с приоритетными таксономиями.
	 */
	
	remove_filter( 'the_content', 'wpautop' );
	remove_filter( 'the_excerpt', 'wpautop' );
	
	
	/* bootstrap 5 wp_nav_menu walker
	class bootstrap_5_wp_nav_menu_walker extends Walker_Nav_menu {
		private $current_item;
		private $dropdown_menu_alignment_values = [
			'dropdown-menu-start',
			'dropdown-menu-end',
			'dropdown-menu-sm-start',
			'dropdown-menu-sm-end',
			'dropdown-menu-md-start',
			'dropdown-menu-md-end',
			'dropdown-menu-lg-start',
			'dropdown-menu-lg-end',
			'dropdown-menu-xl-start',
			'dropdown-menu-xl-end',
			'dropdown-menu-xxl-start',
			'dropdown-menu-xxl-end'
		];

		function start_lvl(&$output, $depth = 0, $args = null) {
			$dropdown_menu_class[] = '';
			foreach($this->current_item->classes as $class) {
				if(in_array($class, $this->dropdown_menu_alignment_values)) {
					$dropdown_menu_class[] = $class;
				}
			}
			$indent = str_repeat("\t", $depth);
			$submenu = ($depth > 0) ? ' sub-menu' : '';
			$output .= "\n$indent<ul class=\"dropdown-menu$submenu " . esc_attr(implode(" ",$dropdown_menu_class)) . " depth_$depth\">\n";
		}

		function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
			$this->current_item = $item;

			$indent = ($depth) ? str_repeat("\t", $depth) : '';

			$li_attributes = '';
			$class_names = $value = '';

			$classes = empty($item->classes) ? array() : (array) $item->classes;

			$classes[] = ($args->walker->has_children) ? 'dropdown' : '';
			$classes[] = 'nav-item';
			$classes[] = 'nav-item-' . $item->ID;
			if ($depth && $args->walker->has_children) {
			  $classes[] = 'dropdown-menu dropdown-menu-end';
			}

			$class_names =  join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
			$class_names = ' class="' . esc_attr($class_names) . '"';

			$id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args);
			$id = strlen($id) ? ' id="' . esc_attr($id) . '"' : '';

			$output .= $indent . '<li ' . $id . $value . $class_names . $li_attributes . '>';

			$attributes = !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
			$attributes .= !empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';
			$attributes .= !empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
			$attributes .= !empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';

			$active_class = ($item->current || $item->current_item_ancestor || in_array("current_page_parent", $item->classes, true) || in_array("current-post-ancestor", $item->classes, true)) ? 'active' : '';
			$nav_link_class = ( $depth > 0 ) ? 'dropdown-item ' : 'nav-link ';
			$attributes .= ( $args->walker->has_children ) ? ' class="'. $nav_link_class . $active_class . ' dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"' : ' class="'. $nav_link_class . $active_class . '"';

			$item_output = $args->before;
			$item_output .= '<a' . $attributes . '>';
			$item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
			$item_output .= '</a>';
			$item_output .= $args->after;

			$output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
		}
	}*/
	
	
	class My_Walker_Nav_Menu extends Walker_Nav_Menu {
		/**
		 * What the class handles.
		 *
		 * @since 3.0.0
		 * @var string
		 *
		 * @see Walker::$tree_type
		 */
		public $tree_type = array( 'post_type', 'taxonomy', 'custom' );

		/**
		 * Database fields to use.
		 *
		 * @since 3.0.0
		 * @todo Decouple this.
		 * @var string[]
		 *
		 * @see Walker::$db_fields
		 */
		public $db_fields = array(
			'parent' => 'menu_item_parent',
			'id'     => 'db_id',
		);

		/**
		 * Starts the list before the elements are added.
		 *
		 * @since 3.0.0
		 *
		 * @see Walker::start_lvl()
		 *
		 * @param string   $output Used to append additional content (passed by reference).
		 * @param int      $depth  Depth of menu item. Used for padding.
		 * @param stdClass $args   An object of wp_nav_menu() arguments.
		 */
		public function start_lvl( &$output, $depth = 0, $args = null ) {
			if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
				$t = '';
				$n = '';
			} else {
				$t = "\t";
				$n = "\n";
			}
			$indent = str_repeat( $t, $depth );

			// Default class.
			//$classes = array( 'sub-menu' );
			// Меняем класс sub-menu на класс dropdown-menu как в Bootstrap 5
			$classes = array( 'dropdown-menu' );

			/**
			 * Filters the CSS class(es) applied to a menu list element.
			 *
			 * @since 4.8.0
			 *
			 * @param string[] $classes Array of the CSS classes that are applied to the menu `<ul>` element.
			 * @param stdClass $args    An object of `wp_nav_menu()` arguments.
			 * @param int      $depth   Depth of menu item. Used for padding.
			 */
			$class_names = implode( ' ', apply_filters( 'nav_menu_submenu_css_class', $classes, $args, $depth ) );

			$atts          = array();
			$atts['class'] = ! empty( $class_names ) ? $class_names : '';

			/**
			 * Filters the HTML attributes applied to a menu list element.
			 *
			 * @since 6.3.0
			 *
			 * @param array $atts {
			 *     The HTML attributes applied to the `<ul>` element, empty strings are ignored.
			 *
			 *     @type string $class    HTML CSS class attribute.
			 * }
			 * @param stdClass $args      An object of `wp_nav_menu()` arguments.
			 * @param int      $depth     Depth of menu item. Used for padding.
			 */
			$atts       = apply_filters( 'nav_menu_submenu_attributes', $atts, $args, $depth );
			$attributes = $this->build_atts( $atts );

			$output .= "{$n}{$indent}<ul{$attributes}>{$n}";
		}

		/**
		 * Ends the list of after the elements are added.
		 *
		 * @since 3.0.0
		 *
		 * @see Walker::end_lvl()
		 *
		 * @param string   $output Used to append additional content (passed by reference).
		 * @param int      $depth  Depth of menu item. Used for padding.
		 * @param stdClass $args   An object of wp_nav_menu() arguments.
		 */
		public function end_lvl( &$output, $depth = 0, $args = null ) {
			if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
				$t = '';
				$n = '';
			} else {
				$t = "\t";
				$n = "\n";
			}
			$indent  = str_repeat( $t, $depth );
			$output .= "$indent</ul>{$n}";
		}

		/**
		 * Starts the element output.
		 *
		 * @since 3.0.0
		 * @since 4.4.0 The {@see 'nav_menu_item_args'} filter was added.
		 * @since 5.9.0 Renamed `$item` to `$data_object` and `$id` to `$current_object_id`
		 *              to match parent class for PHP 8 named parameter support.
		 *
		 * @see Walker::start_el()
		 *
		 * @param string   $output            Used to append additional content (passed by reference).
		 * @param WP_Post  $data_object       Menu item data object.
		 * @param int      $depth             Depth of menu item. Used for padding.
		 * @param stdClass $args              An object of wp_nav_menu() arguments.
		 * @param int      $current_object_id Optional. ID of the current menu item. Default 0.
		 */
		public function start_el( &$output, $data_object, $depth = 0, $args = null, $current_object_id = 0 ) {
			// Restores the more descriptive, specific name for use within this method.
			$menu_item = $data_object;

			if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
				$t = '';
				$n = '';
			} else {
				$t = "\t";
				$n = "\n";
			}
			$indent = ( $depth ) ? str_repeat( $t, $depth ) : '';

			$classes   = empty( $menu_item->classes ) ? array() : (array) $menu_item->classes;
			$classes[] = 'menu-item-' . $menu_item->ID;
			
			
			// ADD CLASSES FOR BOOTSTRAP
			$classes[] = 'nav-item';
			// Если есть потомки и уровень вложенности 0,то добавляем класс dropdown
			if ( $this->has_children && $depth == 0 ) {
				$classes[] = 'dropdown';
			} elseif ( $this->has_children ) {
				$classes[] = 'dropend';
			} else {
				
			}
			// END ADD CLASSES FOR BOOTSTRAP
			

			/**
			 * Filters the arguments for a single nav menu item.
			 *
			 * @since 4.4.0
			 *
			 * @param stdClass $args      An object of wp_nav_menu() arguments.
			 * @param WP_Post  $menu_item Menu item data object.
			 * @param int      $depth     Depth of menu item. Used for padding.
			 */
			$args = apply_filters( 'nav_menu_item_args', $args, $menu_item, $depth );

			/**
			 * Filters the CSS classes applied to a menu item's list item element.
			 *
			 * @since 3.0.0
			 * @since 4.1.0 The `$depth` parameter was added.
			 *
			 * @param string[] $classes   Array of the CSS classes that are applied to the menu item's `<li>` element.
			 * @param WP_Post  $menu_item The current menu item object.
			 * @param stdClass $args      An object of wp_nav_menu() arguments.
			 * @param int      $depth     Depth of menu item. Used for padding.
			 */
			$class_names = implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $menu_item, $args, $depth ) );

			/**
			 * Filters the ID attribute applied to a menu item's list item element.
			 *
			 * @since 3.0.1
			 * @since 4.1.0 The `$depth` parameter was added.
			 *
			 * @param string   $menu_item_id The ID attribute applied to the menu item's `<li>` element.
			 * @param WP_Post  $menu_item    The current menu item.
			 * @param stdClass $args         An object of wp_nav_menu() arguments.
			 * @param int      $depth        Depth of menu item. Used for padding.
			 */
			$id = apply_filters( 'nav_menu_item_id', 'menu-item-' . $menu_item->ID, $menu_item, $args, $depth );

			$li_atts          = array();
			$li_atts['id']    = ! empty( $id ) ? $id : '';
			$li_atts['class'] = ! empty( $class_names ) ? $class_names : '';

			/**
			 * Filters the HTML attributes applied to a menu's list item element.
			 *
			 * @since 6.3.0
			 *
			 * @param array $li_atts {
			 *     The HTML attributes applied to the menu item's `<li>` element, empty strings are ignored.
			 *
			 *     @type string $class        HTML CSS class attribute.
			 *     @type string $id           HTML id attribute.
			 * }
			 * @param WP_Post  $menu_item The current menu item object.
			 * @param stdClass $args      An object of wp_nav_menu() arguments.
			 * @param int      $depth     Depth of menu item. Used for padding.
			 */
			$li_atts       = apply_filters( 'nav_menu_item_attributes', $li_atts, $menu_item, $args, $depth );
			$li_attributes = $this->build_atts( $li_atts );

			$output .= $indent . '<li' . $li_attributes . '>';

			$atts           = array();
			
			
			// ADD CLASSES FOR BOOTSTRAP
			$active_class = $menu_item->current ? ' active' : '';
			if ( $this->has_children && $depth == 0 ) {
				$atts[ 'class' ] = 'nav-link dropdown-toggle' . $active_class;
				$atts[ 'role' ] = 'button';
				$atts[ 'data-bs-toggle' ] = 'dropdown';
				$atts[ 'data-bs-auto-close' ] = 'outside';
				$atts[ 'aria-expanded' ] = 'false';
			} elseif ( $this->has_children ) {
				$atts[ 'class' ] = 'dropdown-item dropdown-toggle' . $active_class;
				$atts[ 'data-bs-toggle' ] = 'dropdown';
				$atts[ 'data-bs-auto-close' ] = 'outside';
				$atts[ 'aria-expanded' ] = 'false';
			} else {
				if ( $depth > 0 ) {
					$atts['class'] = 'dropdown-item ' . $active_class;
				} else {
					$atts['class'] = 'nav-link ' . $active_class;
				}
			}
			// END ADD CLASSES FOR BOOTSTRAP
			
			
			$atts['title']  = ! empty( $menu_item->attr_title ) ? $menu_item->attr_title : '';
			$atts['target'] = ! empty( $menu_item->target ) ? $menu_item->target : '';
			if ( '_blank' === $menu_item->target && empty( $menu_item->xfn ) ) {
				$atts['rel'] = 'noopener';
			} else {
				$atts['rel'] = $menu_item->xfn;
			}

			if ( ! empty( $menu_item->url ) ) {
				if ( get_privacy_policy_url() === $menu_item->url ) {
					$atts['rel'] = empty( $atts['rel'] ) ? 'privacy-policy' : $atts['rel'] . ' privacy-policy';
				}

				$atts['href'] = $menu_item->url;
			} else {
				$atts['href'] = '';
			}

			$atts['aria-current'] = $menu_item->current ? 'page' : '';

			/**
			 * Filters the HTML attributes applied to a menu item's anchor element.
			 *
			 * @since 3.6.0
			 * @since 4.1.0 The `$depth` parameter was added.
			 *
			 * @param array $atts {
			 *     The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
			 *
			 *     @type string $title        Title attribute.
			 *     @type string $target       Target attribute.
			 *     @type string $rel          The rel attribute.
			 *     @type string $href         The href attribute.
			 *     @type string $aria-current The aria-current attribute.
			 * }
			 * @param WP_Post  $menu_item The current menu item object.
			 * @param stdClass $args      An object of wp_nav_menu() arguments.
			 * @param int      $depth     Depth of menu item. Used for padding.
			 */
			$atts       = apply_filters( 'nav_menu_link_attributes', $atts, $menu_item, $args, $depth );
			$attributes = $this->build_atts( $atts );

			/** This filter is documented in wp-includes/post-template.php */
			$title = apply_filters( 'the_title', $menu_item->title, $menu_item->ID );

			/**
			 * Filters a menu item's title.
			 *
			 * @since 4.4.0
			 *
			 * @param string   $title     The menu item's title.
			 * @param WP_Post  $menu_item The current menu item object.
			 * @param stdClass $args      An object of wp_nav_menu() arguments.
			 * @param int      $depth     Depth of menu item. Used for padding.
			 */
			$title = apply_filters( 'nav_menu_item_title', $title, $menu_item, $args, $depth );

			$item_output  = $args->before;
			$item_output .= '<a' . $attributes . '>';
			$item_output .= $args->link_before . $title . $args->link_after;
			$item_output .= '</a>';
			$item_output .= $args->after;

			/**
			 * Filters a menu item's starting output.
			 *
			 * The menu item's starting output only includes `$args->before`, the opening `<a>`,
			 * the menu item's title, the closing `</a>`, and `$args->after`. Currently, there is
			 * no filter for modifying the opening and closing `<li>` for a menu item.
			 *
			 * @since 3.0.0
			 *
			 * @param string   $item_output The menu item's starting HTML output.
			 * @param WP_Post  $menu_item   Menu item data object.
			 * @param int      $depth       Depth of menu item. Used for padding.
			 * @param stdClass $args        An object of wp_nav_menu() arguments.
			 */
			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $menu_item, $depth, $args );
		}
	}


	
	// Собираем контакты из формы для получения доступов в xls файл
	// Для этого записываем контакты из формы в БД, а после выгружаем в xls файл
	// Передача данных из контактной формы 7 в еще один обработчик
	function your_wpcf7_mail_sent_function($contact_form){
		$title = $contact_form->title;
		$posted_data = $contact_form->posted_data;
		if ( 'Форма получить доступ' == $title ) { // Название вашей формы из которой необходимо перехватить данные
			$submission = WPCF7_Submission::get_instance();
			$posted_data = $submission->get_posted_data();

			//Событие наступило! Делаем то, что нам нужно!
			// Например, перехватываем введенные данные в полях Contact Form 7:
			$f7City  = $posted_data['text-700'];
			$f7Street = $posted_data['text-701'];
			$f7House = $posted_data['text-702'];
			$f7Apartment = $posted_data['text-703'];
			$f7Phone = $posted_data['text-690'];
			$f7Email = $posted_data['email-988'];
			
			// Настройки БД
			$db_host = 'localhost';
			$db_name = 'orion6sa_newd';
			$db_user = 'orion6sa_newd';
			$db_password = 'Dvh453#89jg';
			
			// Подключение к БД
			$connection = mysqli_connect($db_host, $db_user, $db_password, $db_name);
			
			$result = mysqli_query( $connection, "INSERT INTO `clients` (`id`, `city`, `street`, `house`, `apartment`, `phone`, `email`) VALUES (NULL, '$f7City', '$f7Street', '$f7House', '$f7Apartment', '$f7Phone', '$f7Email');");
		}
	}
	add_action('wpcf7_mail_sent', 'your_wpcf7_mail_sent_function');
	
	
	
	/*** ОТПРАВКА ДАННЫХ В BITRIX
	// Для этого используем функцию, которая ловит данные после успешной отправки и отправляет на вебхук.
	add_action('wpcf7_mail_sent', 'send_cf7_data_to_webhook', 10, 1);
	function send_cf7_data_to_webhook($contact_form) {
		// Получаем данные формы
		$submission = WPCF7_Submission::get_instance();

		if ( $submission ) {
			$posted_data = $submission->get_posted_data(); // Все данные формы

			// Перехватываем данные введенные в полях Contact Form 7:
			$phone = isset( $posted_data['text-690'] ) ? $posted_data['text-690'] : '';
			$email = isset( $posted_data['email-988'] ) ? $posted_data['email-988'] : '';
			
			// Получаем значение выбранного радиобаттона и записываем в переменную.
			$service = $posted_data['radio-678'][0];
			
			$comments  = 'Город '.$posted_data['text-700'].', ';
			$comments .= 'ул. '.$posted_data['text-701'].', ';
			$comments .= 'д. '.$posted_data['text-702'].', ';
			$comments .= 'кв. '.$posted_data['text-703'].'.<br>';
			$comments .= 'ФИО собственнника: '.$posted_data['text-710'].'.<br>';
			$comments .= 'Комментарий: '.$posted_data['textarea-737'].'.';
			
			/* Подготовка данных для вебхука в старом варианте
			$webhook_data = array(
				'title' => 'Заявка с формы на сайте',
				'email' => isset($posted_data['email-988']) ? $posted_data['email-988'] : '',
				'comments' => 'Комментарий',
				'phone' => isset($posted_data['text-690']) ? $posted_data['text-690'] : '',
				
			); */
			
			/* Подготовка данных для вебхука в новом варианте *
			$webhook_data = array(
				 'FIELDS' => [
					'TITLE' => 'Заявка с формы на сайте',
					'EMAIL' => [ '0' => [ 'VALUE' => $email ] ],
					'COMMENTS' => $comments,
					'PHONE' => [ '0' => [ 'VALUE' => $phone ] ],
					'UF_CRM_1739355766' => $service,
				]
			);

			// URL вебхука (замените на ваш)
			$webhook_url = 'https://rdk62.ru/rest/1/ajolq13mb2uzh8av/crm.lead.add.json';

			// Отправка данных на вебхук
			$response = wp_remote_post($webhook_url, array(
				'body' => json_encode($webhook_data), // Данные в формате JSON
				'headers' => array('Content-Type' => 'application/json'),
			));

			// Проверка результата отправки
			if (is_wp_error($response)) {
				$error_message = $response->get_error_message();
				error_log('Ошибка отправки вебхука: ' . $error_message);
				
				// Получаем лог ответа на себе почту
				//error_log('Ошибка отправки вебхука: ' . $error_message, 1, "vasilyev-r@mail.ru");
			} else {
				error_log('Данные успешно отправлены на вебхук.');
				
				// Получаем лог ответа на себе почту
				//error_log('Данные успешно отправлены на вебхук.', 1, "vasilyev-r@mail.ru");
			}
		}
		
		/* Проверяем доставку *
		//$name  = $posted_data['text-710'];
		//$message = $name;
		//$message = $webhook_url;
		//mail( 'vasilyev-r@mail.ru', 'Тест', $message );
	} ***/
	
	
	
	/*** ОТПРАВКА ДАННЫХ С ИЗОБРАЖЕНИЕМ В BITRIX ***/
	// Для этого используем функцию, которая ловит данные после успешной отправки и отправляет на вебхук.
	add_action('wpcf7_before_send_mail', 'send_cf7_data_to_webhook', 10, 3);
	function send_cf7_data_to_webhook( $contact_form ) {
		
		// Получаем название формы
		$form_title = $contact_form->title;
		
		// Получаем данные формы
		$submission = WPCF7_Submission::get_instance();
		
		// Если данные успешно отправленны, то...
		if ( $submission ) {
			
			// Делаем отправку в Битрикс для разных форм
			switch ( $form_title ) {
				case 'Форма заказ товара':
					$lid_title = 'Лид из формы заказа товара';
					// Получаем все данные формы
					$posted_data = $submission->get_posted_data();
					
					// Получаем данные из необходимых полей Contact Form 7:
					$phone = isset( $posted_data['tel-208'] ) ? $posted_data['tel-208'] : '';
					
					// Получаем остальные данные
					$comments  = 'Имя лида: '.$posted_data['text-306'].'.<br>';
					$comments .= 'Наименование товара: '.$posted_data['text-547'];
					
					/* Подготовка данных для отправки в Битрикс с помощью вебхука */
					$webhook_data = array(
						 'FIELDS' => [
							'TITLE' => $lid_title,
							'COMMENTS' => $comments,
							'PHONE' => [ '0' => [ 'VALUE' => $phone ] ]
						]
					);
					
					// URL вебхука
					$webhook_url = 'https://rdk62.ru/rest/1/ajolq13mb2uzh8av/crm.lead.add.json';
					
					// Отправка данных на вебхук
					$response = wp_remote_post($webhook_url, array(
						'body' => json_encode($webhook_data), // Данные в формате JSON
						'headers' => array('Content-Type' => 'application/json'),
					));
					
					// Проверка результата отправки
					if ( is_wp_error( $response ) ) {
						//$error_message = $response->get_error_message();
						//error_log('Ошибка отправки вебхука: ' . $error_message);
						// Получаем лог ответа на себе почту
						//error_log('Ошибка отправки вебхука: ' . $error_message, 1, "vasilyev-r@mail.ru");
					} else {
						//error_log('Данные успешно отправлены на вебхук.');
						
						/* Получаем лог ответа на себе почту
						$response_body = wp_remote_retrieve_body($response);
						$response_data = json_decode($response_body, true);
						$lead_id = $response_data['result']; // ID созданного лида
						$file_base_name = basename( $file_path );
						error_log('Данные успешно отправлены на вебхук. ID созданного лида: '.$lead_id.'. Прикрепленный файл: '.$file_base_name, 1, "vasilyev-r@mail.ru");*/
					}
					break;
				
				case 'Форма заказа услуги':
					$lid_title = 'Лид из формы заказа услуги';
					// Получаем все данные формы
					$posted_data = $submission->get_posted_data();
					
					// Получаем данные из необходимых полей Contact Form 7:
					$phone = isset( $posted_data['tel-208'] ) ? $posted_data['tel-208'] : '';
					
					// Получаем остальные данные
					$comments  = 'Имя лида: '.$posted_data['text-306'].'.<br>';
					$comments .= 'Наименование услуги: '.$posted_data['dynamichidden-580'];
					
					/* Подготовка данных для отправки в Битрикс с помощью вебхука */
					$webhook_data = array(
						 'FIELDS' => [
							'TITLE' => $lid_title,
							'COMMENTS' => $comments,
							'PHONE' => [ '0' => [ 'VALUE' => $phone ] ]
						]
					);
					
					// URL вебхука
					$webhook_url = 'https://rdk62.ru/rest/1/ajolq13mb2uzh8av/crm.lead.add.json';
					
					// Отправка данных на вебхук
					$response = wp_remote_post($webhook_url, array(
						'body' => json_encode($webhook_data), // Данные в формате JSON
						'headers' => array('Content-Type' => 'application/json'),
					));
					
					// Проверка результата отправки
					if ( is_wp_error( $response ) ) {
						//$error_message = $response->get_error_message();
						//error_log('Ошибка отправки вебхука: ' . $error_message);
						// Получаем лог ответа на себе почту
						//error_log('Ошибка отправки вебхука: ' . $error_message, 1, "vasilyev-r@mail.ru");
					} else {
						//error_log('Данные успешно отправлены на вебхук.');
						
						/* Получаем лог ответа на себе почту
						$response_body = wp_remote_retrieve_body($response);
						$response_data = json_decode($response_body, true);
						$lead_id = $response_data['result']; // ID созданного лида
						$file_base_name = basename( $file_path );
						error_log('Данные успешно отправлены на вебхук. ID созданного лида: '.$lead_id.'. Прикрепленный файл: '.$file_base_name, 1, "vasilyev-r@mail.ru");*/
					}
					break;
				
				case 'Форма получить доступ':
					$lid_title = 'Заявка из формы получить доступ';
					// Получаем все данные формы
					$posted_data = $submission->get_posted_data(); 

					// Получаем данные из необходимых полей Contact Form 7:
					$phone = isset( $posted_data['text-690'] ) ? $posted_data['text-690'] : '';
					$email = isset( $posted_data['email-988'] ) ? $posted_data['email-988'] : '';
					
					// Получаем данные выбранного радиобаттона и записываем в переменную.
					$service = $posted_data['radio-678'][0];
					
					// Получаем остальные данные
					$comments  = 'Город '.$posted_data['text-700'].', ';
					$comments .= 'ул. '.$posted_data['text-701'].', ';
					$comments .= 'д. '.$posted_data['text-702'].', ';
					$comments .= 'кв. '.$posted_data['text-703'].'.<br>';
					$comments .= 'ФИО собственнника: '.$posted_data['text-710'].'.<br>';
					$comments .= 'Комментарий: '.$posted_data['textarea-737'].'.';
					
					// Получаем файл
					$uploaded_files = $submission->uploaded_files();
					$file_path = $uploaded_files['file-706'][0]; // Путь к файлу
					
					/* Подготовка данных для отправки в Битрикс с помощью вебхука */
					$webhook_data = array(
						 'FIELDS' => [
							'TITLE' => $lid_title,
							'EMAIL' => [ '0' => [ 'VALUE' => $email ] ],
							'COMMENTS' => $comments,
							'PHONE' => [ '0' => [ 'VALUE' => $phone ] ], 
							'UF_CRM_1739355766' => $service,
						]
					);

					// URL вебхука
					$webhook_url = 'https://rdk62.ru/rest/1/ajolq13mb2uzh8av/crm.lead.add.json';
					// URL вебхука для передачи файла
					$webhook_url_2 = 'https://rdk62.ru/rest/1/56tj1wf6qoz1wfdg/crm.lead.update.json';
					// URL моего (из моей учетной записи в Битрикс) вебхука для передачи файла
					$webhook_url_3 = 'https://rdk62.ru/rest/2234/fqyyvcgc0yn4akai/crm.lead.update.json';

					// Отправка данных на вебхук
					$response = wp_remote_post($webhook_url, array(
						'body' => json_encode($webhook_data), // Данные в формате JSON
						'headers' => array('Content-Type' => 'application/json'),
					));
					
					/* Обработка ответа
					if ( is_wp_error( $response ) ) {
						error_log('Ошибка при отправке данных в Битрикс: ' . $response->get_error_message());
						return;
					} else {
						error_log('Все ОК!: ' . $response->get_error_message(), 1, "vasilyev-r@mail.ru");
					}*/
					
					// Проверка результата отправки
					if (is_wp_error($response)) {
						//$error_message = $response->get_error_message();
						//error_log('Ошибка отправки вебхука: ' . $error_message);
						
						// Получаем лог ответа на себе почту
						//error_log('Ошибка отправки вебхука: ' . $error_message, 1, "vasilyev-r@mail.ru");
					} else {
						//error_log('Данные успешно отправлены на вебхук.');
						
						/* Получаем лог ответа на себе почту
						$response_body = wp_remote_retrieve_body($response);
						$response_data = json_decode($response_body, true);
						$lead_id = $response_data['result']; // ID созданного лида
						$file_base_name = basename( $file_path );
						error_log('Данные успешно отправлены на вебхук. ID созданного лида: '.$lead_id.'. Прикрепленный файл: '.$file_base_name, 1, "vasilyev-r@mail.ru");*/
					}
					
					
					$response_body = wp_remote_retrieve_body($response);
					$response_data = json_decode($response_body, true);
					
					
					 if ( isset( $response_data['result'] ) ) {
						$lead_id = $response_data['result']; // ID созданного лида

						// Если есть файл, прикрепляем его к лиду
						if ($file_path) {
							$file_data = file_get_contents($file_path); // Чтение файла
							$file_base64 = base64_encode($file_data); // Кодирование в base64
							
							$file_upload_data = array(
								'ID' => $lead_id,
								'FIELDS' => [
									'UF_CRM_1739355991637' => [
										'fileData' => [ basename($file_path), $file_base64 ]
									]
								]
							);

							/* Отправка данных на вебхук
							$file_response = wp_remote_post($webhook_url_3 . 'crm.lead.userfield.add.json', array(
								'body' => $file_upload_data,
							));*/
							
							/* Отправка данных на вебхук второй вариант */
							$file_response = wp_remote_post($webhook_url_3, array(
								'body' => json_encode($file_upload_data), // Данные в формате JSON
								'headers' => array('Content-Type' => 'application/json'),
							));

							/* Проверяем ошибки при отправке файла
							if ( is_wp_error( $file_response ) ) {
								//error_log('Ошибка при отправке файла в Битрикс: ' . $file_response->get_error_message());
								error_log('Ошибка при отправке файла в Битрикс: ' . $file_response->get_error_message(), 1, "vasilyev-r@mail.ru");
							} else {
								error_log( 'Данные отправленны на вебхук 2', 1, "vasilyev-r@mail.ru" );
							} */
						}
					
					} else {
						// Логирование ошибки
						// error_log('Ошибка при создании лида: ' . print_r($response_data, true));
						// error_log('Ошибка при создании лида: ' . print_r($response_data, true), 1, "vasilyev-r@mail.ru");
					}
				break;
			}
		}
		
		// Отменяем стандартную отправку письма, если нужно
		$abort = true;
	}
	
	
	
	
	/*** ДОБАВЛЯЕМ ВОЗМОЖНОСТЬ В НАСТРОЙКАХ ТЕМЫ ДОБАВИТЬ КОНТАКТЫ И КОД СЧЕТЧИКА ***/
	function mytheme_customize_register( $wp_customize ) {
		
		/** ИСПОЛЬЗУЕМ ВЛОЖЕННЫЕ КОНТЕЙНЕРЫ **/
		/* КОНТАКТЫ */
		// Создаем панель (родительский контейнер)
		$wp_customize->add_panel( 'contact_panel', array(
			'title'       => 'Контакты',
			'description' => 'Описание контактов',
			'priority'    => 205, // Чем меньше, тем выше в списке
		) );
				
			// Добавляем вложенную секцию для Telegram
			$wp_customize->add_section( 'mytheme_contacts_telegram', array( 
				'title'    => 'Telegram',
				'panel'    => 'contact_panel', // Указываем родительскую панель
				'priority' => 5
			));
		
				// Добавляем поле для ввода Telegram
				$wp_customize->add_setting( 'mytheme_telegram', array(
					'default'   => '',
					'transport' => 'postMessage',
				));
				
				$wp_customize->add_control( 'mytheme_telegram', array(
					'label'       => 'Telegram',
					'description' => 'Укажите ссылку на Telegram',
					'section'     => 'mytheme_contacts_telegram',
					'type'        => 'input',
					'input_attrs' => array(
						'placeholder' => '',
						//'style'      => 'width: 60px; display: inline-block;', // Уменьшаем ширину и делаем в одну строку
					)
				));
		/** ИСПОЛЬЗУЕМ ВЛОЖЕННЫЕ КОНТЕЙНЕРЫ **/
	}
	add_action( 'customize_register', 'mytheme_customize_register' );
	/*** END ДОБАВЛЯЕМ ВОЗМОЖНОСТЬ В НАСТРОЙКАХ ТЕМЫ ДОБАВИТЬ КОНТАКТЫ И КОД СЧЕТЧИКА ***/

?>