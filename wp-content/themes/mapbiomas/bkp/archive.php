<?php get_header(); ?>

<section class="breadcrumb__title bg-color-blue">
    <div class="container">
        <div class="row  justify-content-center">
            <div class="col-xl-9" data-aos="fade-left">
                <ul class="breadcrumb">
                    <li><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
                    <?php
                    if (is_category()) {
                        $category = get_queried_object();
                        echo '<li><span>' . esc_html($category->name) . '</span></li>';
                    } elseif (is_tag()) {
                        $tag = get_queried_object();
                        echo '<li><span>' . esc_html($tag->name) . '</span></li>';
                    } elseif (is_single()) {
                        $categories = get_the_category();
                        if (!empty($categories)) {
                            echo '<li><a href="' . esc_url(get_category_link($categories[0]->term_id)) . '">' . esc_html($categories[0]->name) . '</a></li>';
                        }
                        echo '<li><span>' . esc_html(get_the_title()) . '</span></li>';
                    } elseif (is_page()) {
                        echo '<li><span>' . esc_html(get_the_title()) . '</span></li>';
                    } elseif (is_search()) {
                        echo '<li><span>Resultado da busca: ' . esc_html(get_search_query()) . '</span></li>';
                    } elseif (is_404()) {
                        echo '<li><span>Página não encontrada</span></li>';
                    } elseif (is_home()) {
                        echo '<li><span>Blog</span></li>';
                    } else {
                        echo '<li><span>' . esc_html(get_the_title()) . '</span></li>';
                    }
                    ?>
                </ul>
                <h1 class="title">Notícias</h1>
            </div>
        </div>
    </div>
</section>

<?php
    $pais = $_GET['pais'] ?? '';
    $tema = $_GET['tema'] ?? '';
    $paged = max(1, get_query_var('paged'), get_query_var('page'));

    $args = [
    'post_type' => 'post',
    'posts_per_page' => get_option('posts_per_page'),
    'paged' => $paged,
    'category_name' => 'noticias',
    ];

    $meta_query = [];

    if ($pais) {
    $meta_query[] = [
        'key' => 'pais',
        'value' => sanitize_text_field($pais),
    ];
    }

    if ($tema) {
    $meta_query[] = [
        'key' => 'tag_destaque',
        'value' => sanitize_text_field($tema),
    ];
    }

    if ($meta_query) {
    $args['meta_query'] = $meta_query;
    }

    $query = new WP_Query($args);

    $all_posts = get_posts([
    'post_type' => 'post',
    'posts_per_page' => -1,
    'category_name' => 'noticias',
    'fields' => 'ids'
    ]);

    $paises = [];
    $temas = [];

    foreach ($all_posts as $post_id) {
    $pais_val = get_field('pais', $post_id);
    $tema_val = get_field('tag_destaque', $post_id);

    if ($pais_val) {
        $paises[] = $pais_val;
    }

    if ($tema_val) {
        $temas[] = $tema_val;
    }
    }

    // remove duplicados + ordena
    $paises = array_unique($paises);
    $temas = array_unique($temas);

    sort($paises);
    sort($temas);
?>

<?php
    $map_paises = [
    'Brasil' => 'BR',
    'Argentina' => 'AR',
    'Chile' => 'CL',
    'Peru' => 'PE',
    ];
?>

<section class="news">
    <div class="container">
        <div class="row  justify-content-center">
            <div class="col-xl-9" data-aos="fade-up">
                <div class="news__filter">
                    <form method="GET" class="filters">
                        <a href="<?php echo remove_query_arg(['pais', 'tema']); ?>" class="filter-btn">Todas</a>
                        <p>Filtrar por:</p>
                        <div class="filter-select">
                            <select name="pais" onchange="this.form.submit()">
                                <option value="">País</option>

                                <?php foreach ($paises as $p): ?>
                                    <option value="<?php echo esc_attr($p); ?>" <?php selected($pais, $p); ?>>
                                    <?php echo esc_html($p); ?>
                                    </option>
                                <?php endforeach; ?>

                            </select>
                        </div>
                        <div class="filter-select">
                            <select name="tema" onchange="this.form.submit()">
                                <option value="">Tema</option>

                                <?php foreach ($temas as $t): ?>
                                    <option value="<?php echo esc_attr($t); ?>" <?php selected($tema, $t); ?>>
                                    <?php echo esc_html($t); ?>
                                    </option>
                                <?php endforeach; ?>

                            </select>
                        </div>
                    </form>
                </div>
                <div class="news-list">

                    <?php $index = 0; ?>

                    <?php if ($query->have_posts()) : ?>
                        <?php while ($query->have_posts()) : $query->the_post();

                            $pais = get_field('pais');
                            $codigo = $map_paises[$pais] ?? '';
                            $tag = get_field('tag_destaque');
                            $tag_slug = sanitize_title($tag);
                        ?>

                        <article class="news-card <?php echo $index === 0 ? 'is-featured' : ''; ?>">

                            <div class="news-card__image">
                                <?php the_post_thumbnail('large'); ?>
                            </div>

                            <div class="news-card__content">

                                <div class="news-card__meta">
                                    
                                    <?php if ($tag): ?>
                                    <span class="badge badge-<?php echo esc_attr($tag_slug); ?>">
                                        <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M4.82685 0.660854C4.67061 0.504563 4.45868 0.416734 4.23768 0.416687H1.24935C1.02834 0.416687 0.816374 0.504484 0.660093 0.660765C0.503813 0.817045 0.416016 1.02901 0.416016 1.25002V4.23835C0.416063 4.45935 0.503891 4.67128 0.660182 4.82752L4.28685 8.45419C4.47623 8.64237 4.73237 8.74799 4.99935 8.74799C5.26633 8.74799 5.52247 8.64237 5.71185 8.45419L8.45352 5.71252C8.6417 5.52314 8.74732 5.267 8.74732 5.00002C8.74732 4.73304 8.6417 4.4769 8.45352 4.28752L4.82685 0.660854Z" stroke="#84CAA0" stroke-width="0.833333" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        <?php echo esc_html($tag); ?>
                                    </span>
                                    <?php endif; ?>

                                    <?php if ($pais): ?>
                                        <?php 
                                            $codigo = $map_paises[$pais] ?? '';
                                        ?>
                                        <span class="country">
                                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/flags/<?php echo strtolower($codigo); ?>.svg">
                                            <?php echo esc_html($pais); ?>
                                        </span>
                                    <?php endif; ?>

                                    <span class="date"><?php echo get_the_date(); ?></span>

                                </div>

                                <h3><?php the_title(); ?></h3>
                                <p><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>

                            </div>

                        </article>

                        <?php $index++; ?>

                        <?php endwhile; ?>
                    <?php endif; ?>

                    </div>
                    <div class="pagination">
                        <div class="pagination__list">
                            <?php
                                echo paginate_links([
                                'total' => $query->max_num_pages,
                                'current' => $paged,
                                'mid_size' => 2,
                                'prev_text' => 'Anterior',
                                'next_text' => 'Próximo',
                                ]);
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
$eventos = new WP_Query([
  'post_type' => 'post',
  'category_name' => 'eventos',
  'posts_per_page' => 3
]);
?>

<section class="events">
    <div class="container">
        <div class="row  justify-content-center">
            <div class="col-xl-9" data-aos="fade-up">
                <h4>Próximos Eventos</h4>
                <div class="events__list__cards">
                    <?php while ($eventos->have_posts()) : $eventos->the_post();
                        $data = get_field('data_evento');
                        $local = get_field('local-city');
                        $presencial = get_field('presencial');
                    ?>
                    <div class="event-card">
                        <div class="event-card__image">
                            <?php the_post_thumbnail('medium'); ?>
                            
                            <div class="event-date">
                                <?php echo date('M', strtotime($data)); ?><br>
                                <span class="day"><?php echo date('d', strtotime($data)); ?></span>
                            </div>

                            <div class="event-content-date-tipo">
                                <div class="event-date-tipo">
                                    <?php $tipo_local = get_field('tipo-local'); ?>
                                    <div class="event-date-tipo">
                                        <?php if ($tipo_local): ?>
                                            <span class="badge badge-<?php echo esc_attr($tipo_local); ?>">
                                            <?php echo esc_html(ucfirst($tipo_local)); ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                    <span class="date-full"><?php echo get_the_date('j \d\e M. \d\e Y'); ?></span>
                                </div>
                                <h3><?php the_title(); ?></h3>
                                <div class="event-local">
                                    <p><?php echo esc_html($local); ?></p>
                                </div>
                            </div>
                        </div>

                        <div class="event-card__content">
                            <p><?php echo get_the_excerpt(); ?></p>
                        </div>
                    </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>