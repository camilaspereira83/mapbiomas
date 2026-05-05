<?php
/*
 * Template Name: Home
*/

$has_acf = function_exists('get_field');

$home_hero_title        = ($has_acf ? get_field('home_hero_title',       'option') : '') ?: '';
$home_hero_text         = ($has_acf ? get_field('home_hero_text',        'option') : '') ?: '';
$home_stats             = ($has_acf ? get_field('home_stats',             'option') : []) ?: [];
$home_news_title        = ($has_acf ? get_field('home_news_title',        'option') : '') ?: 'Fique por dentro';
$home_tab_news          = ($has_acf ? get_field('home_tab_news',          'option') : '') ?: 'Notícias';
$home_tab_events        = ($has_acf ? get_field('home_tab_events',        'option') : '') ?: 'Eventos';
$home_read_more         = ($has_acf ? get_field('home_read_more',         'option') : '') ?: 'Ler mais';
$home_country_label     = ($has_acf ? get_field('home_news_country_label','option') : '') ?: 'Brasil';
$home_country_iso2      = strtolower(($has_acf ? get_field('home_news_country_iso2', 'option') : '') ?: 'br');
$home_posts_count       = intval(($has_acf ? get_field('home_posts_count', 'option') : 0) ?: 5);
$home_empty_news        = ($has_acf ? get_field('home_empty_news',        'option') : '') ?: 'Nenhuma notícia encontrada.';
$home_empty_events      = ($has_acf ? get_field('home_empty_events',      'option') : '') ?: 'Nenhum evento encontrado.';
?>

<section class="home" data-aos="fade-up">
    <div class="container">
        <div class="home__content">
            <?php if ($home_hero_title || $home_hero_text) : ?>
                <?php if ($home_hero_title) : ?>
                    <h1><?php echo esc_html($home_hero_title); ?></h1>
                <?php endif; ?>
                <?php if ($home_hero_text) : ?>
                    <?php echo wp_kses_post($home_hero_text); ?>
                <?php endif; ?>
            <?php else : ?>
                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <?php the_content(); ?>
                <?php endwhile; endif; ?>
            <?php endif; ?>
        </div>

        <div class="home__stats">
            <?php if (!empty($home_stats)) : ?>
                <?php foreach ($home_stats as $stat) : ?>
                    <div class="stat-item item-<?php echo esc_attr($stat['cor']); ?>">
                        <?php if ($stat['titulo']) : ?>
                            <p class="stat-title"><?php echo esc_html($stat['titulo']); ?></p>
                        <?php endif; ?>
                        <?php if ($stat['numero']) : ?>
                            <div class="stat-number" data-target="<?php echo esc_attr($stat['numero']); ?>">0</div>
                        <?php endif; ?>
                        <?php if ($stat['adicional']) : ?>
                            <span class="stat-unit"><?php echo esc_html($stat['adicional']); ?></span>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php elseif ($has_acf && have_rows('caixas_numericas')) : ?>
                <?php while (have_rows('caixas_numericas')) : the_row();
                    $titulo   = get_sub_field('titulo_caixas_numericas');
                    $numero   = get_sub_field('numero_caixas_numericas');
                    $adicional = get_sub_field('adicional_caixas_numericas');
                    $cor      = get_sub_field('cor_caixa');
                ?>
                    <div class="stat-item item-<?php echo esc_attr($cor); ?>">
                        <?php if ($titulo)   : ?><p class="stat-title"><?php echo esc_html($titulo); ?></p><?php endif; ?>
                        <?php if ($numero)   : ?><div class="stat-number" data-target="<?php echo esc_attr($numero); ?>">0</div><?php endif; ?>
                        <?php if ($adicional): ?><span class="stat-unit"><?php echo esc_html($adicional); ?></span><?php endif; ?>
                    </div>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<section class="worldmap" data-aos="fade-up">
    <?php echo do_shortcode('[mapbiomas_network_map]'); ?>
</section>

<section class="news-events" data-aos="fade-up">
    <div class="container">
        <div class="home__news-events">
            <div class="home__news-events__title-tabs">
                <h2><?php echo esc_html($home_news_title); ?></h2>
                <div class="news-events-tabs">
                    <button class="tab-button active" data-tab="noticias">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/file.svg" alt="Ícone de notícia" width="13" height="16"/>
                        <?php echo esc_html($home_tab_news); ?>
                    </button>
                    <button class="tab-button" data-tab="eventos">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/event.svg" alt="Ícone de eventos" width="15" height="16"/>
                        <?php echo esc_html($home_tab_events); ?>
                    </button>
                </div>
            </div>

            <div class="news-events-content">
                <div class="tab-content active" id="noticias">
                    <?php
                    $noticias_query = new WP_Query([
                        'category_name'  => 'noticias',
                        'posts_per_page' => $home_posts_count,
                        'post_status'    => 'publish',
                    ]);

                    if ($noticias_query->have_posts()) :
                        $noticias_posts = $noticias_query->posts;
                        $first_noticia  = $noticias_posts[0];
                        $featured_image = get_the_post_thumbnail_url($first_noticia->ID, 'large') ?: get_template_directory_uri() . '/assets/img/news-placeholder.jpg';
                        $featured_title   = $first_noticia->post_title;
                        $featured_excerpt = wp_trim_words($first_noticia->post_excerpt ?: $first_noticia->post_content, 20, '...');
                        $featured_link    = get_permalink($first_noticia->ID);
                        $tag_destaque     = get_post_meta($first_noticia->ID, 'tag_destaque', true) ?: '';
                    ?>
                    <div class="news-carousel">
                        <div class="featured-news">
                            <div class="featured-image">
                                <img src="<?php echo esc_url($featured_image); ?>" alt="<?php echo esc_attr($featured_title); ?>" />
                            </div>
                            <div class="featured-content">
                                <div class="featured-meta">
                                    <?php if ($tag_destaque) : ?>
                                        <span class="featured-tag"><?php echo esc_html($tag_destaque); ?></span>
                                    <?php endif; ?>
                                    <div class="featured-location">
                                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/flags/<?php echo esc_html($home_country_iso2); ?>.svg" alt="<?php echo esc_attr($home_country_label); ?>" width="16" height="16" />
                                        <span><?php echo esc_html($home_country_label); ?></span>
                                    </div>
                                    <span class="featured-date"><?php echo get_the_date('d/m/Y', $first_noticia->ID); ?></span>
                                </div>
                                <h3 class="featured-title">
                                    <a href="<?php echo esc_url($featured_link); ?>"><?php echo esc_html($featured_title); ?></a>
                                </h3>
                                <p class="featured-excerpt"><?php echo esc_html($featured_excerpt); ?></p>
                                <a href="<?php echo esc_url($featured_link); ?>" class="read-more-btn"><?php echo esc_html($home_read_more); ?></a>
                            </div>
                            <button class="carousel-arrow prev-arrow">
                                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/arrow-next.svg'); ?>" alt="Anterior" width="13" height="13" />
                            </button>
                            <button class="carousel-arrow next-arrow">
                                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/arrow-next.svg'); ?>" alt="Próximo" width="13" height="13" />
                            </button>
                            <div class="carousel-dots"></div>
                        </div>

                        <div class="thumbnails-carousel">
                            <div class="thumbnails-wrapper">
                                <?php $index = 0; foreach ($noticias_posts as $noticia) :
                                    $thumb_image   = get_the_post_thumbnail_url($noticia->ID, 'thumbnail') ?: get_template_directory_uri() . '/assets/img/news-placeholder.jpg';
                                    $thumb_title   = $noticia->post_title;
                                    $thumb_excerpt = wp_trim_words($noticia->post_excerpt ?: $noticia->post_content, 15, '...');
                                    $thumb_link    = get_permalink($noticia->ID);
                                    $thumb_tag     = get_post_meta($noticia->ID, 'tag_destaque', true) ?: '';
                                    $active_class  = ($index === 0) ? 'active' : '';
                                    $tag_color = sanitize_title($thumb_tag);
                                ?>
                                <div class="thumbnail-item <?php echo esc_attr($active_class); ?>"
                                     data-index="<?php echo $index; ?>"
                                     data-image="<?php echo esc_url($thumb_image); ?>"
                                     data-title="<?php echo esc_attr($thumb_title); ?>"
                                     data-excerpt="<?php echo esc_attr($thumb_excerpt); ?>"
                                     data-link="<?php echo esc_url($thumb_link); ?>"
                                     data-tag="<?php echo esc_attr($thumb_tag); ?>">
                                    <div class="thumbnail-item-img">
                                        <img src="<?php echo esc_url($thumb_image); ?>" alt="<?php echo esc_attr($thumb_title); ?>" />
                                    </div>
                                    <div class="thumbnail-item-content">
                                        <?php if ($thumb_tag) : ?>
                                            <span class="thumbnail-tag color-<?php echo esc_attr($tag_color); ?>"><?php echo esc_html($thumb_tag); ?></span>
                                        <?php endif; ?>
                                        <h4 class="thumbnail-title"><?php echo esc_html($thumb_title); ?></h4>
                                    </div>
                                </div>
                                <?php $index++; endforeach; ?>
                            </div>
                        </div>
                    </div>
                    <?php else : ?>
                        <p><?php echo esc_html($home_empty_news); ?></p>
                    <?php endif; ?>
                </div>

                <div class="tab-content" id="eventos">
                    <?php
                    $eventos_query = new WP_Query([
                        'category_name'  => 'eventos',
                        'posts_per_page' => 5,
                        'post_status'    => 'publish',
                    ]);

                    if ($eventos_query->have_posts()) :
                        $eventos_posts = $eventos_query->posts;
                        $first_evento  = $eventos_posts[0];
                        $featured_image = get_the_post_thumbnail_url($first_evento->ID, 'large') ?: get_template_directory_uri() . '/assets/img/event-placeholder.jpg';
                        $featured_title   = $first_evento->post_title;
                        $featured_excerpt = wp_trim_words($first_evento->post_excerpt ?: $first_evento->post_content, 20, '...');
                        $featured_link    = get_permalink($first_evento->ID);
                        $tag_destaque     = get_post_meta($first_evento->ID, 'tag_destaque', true) ?: '';
                    ?>
                    <div class="news-carousel">
                        <div class="featured-news">
                            <div class="featured-image">
                                <img src="<?php echo esc_url($featured_image); ?>" alt="<?php echo esc_attr($featured_title); ?>" />
                            </div>
                            <div class="featured-content">
                                <div class="featured-meta">
                                    <?php if ($tag_destaque) : ?>
                                        <span class="featured-tag"><?php echo esc_html($tag_destaque); ?></span>
                                    <?php endif; ?>
                                    <div class="featured-location">
                                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/flags/<?php echo esc_html($home_country_iso2); ?>.svg" alt="<?php echo esc_attr($home_country_label); ?>" width="16" height="16" />
                                        <span><?php echo esc_html($home_country_label); ?></span>
                                    </div>
                                    <span class="featured-date"><?php echo get_the_date('d/m/Y', $first_evento->ID); ?></span>
                                </div>
                                <h3 class="featured-title">
                                    <a href="<?php echo esc_url($featured_link); ?>"><?php echo esc_html($featured_title); ?></a>
                                </h3>
                                <p class="featured-excerpt"><?php echo esc_html($featured_excerpt); ?></p>
                                <a href="<?php echo esc_url($featured_link); ?>" class="read-more-btn"><?php echo esc_html($home_read_more); ?></a>
                            </div>
                            <button class="carousel-arrow prev-arrow">
                                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/arrow-next.svg'); ?>" alt="Anterior" width="13" height="13" />
                            </button>
                            <button class="carousel-arrow next-arrow">
                                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/arrow-next.svg'); ?>" alt="Próximo" width="13" height="13" />
                            </button>
                        </div>

                        <div class="thumbnails-carousel">
                            <div class="thumbnails-wrapper">
                                <?php $index = 0; foreach ($eventos_posts as $evento) :
                                    $thumb_image   = get_the_post_thumbnail_url($evento->ID, 'thumbnail') ?: get_template_directory_uri() . '/assets/img/event-placeholder.jpg';
                                    $thumb_title   = $evento->post_title;
                                    $thumb_excerpt = wp_trim_words($evento->post_excerpt ?: $evento->post_content, 15, '...');
                                    $thumb_link    = get_permalink($evento->ID);
                                    $thumb_tag     = get_post_meta($evento->ID, 'tag_destaque', true) ?: '';
                                    $active_class  = ($index === 0) ? 'active' : '';
                                    $tag_color = sanitize_title($thumb_tag);
                                ?>
                                <div class="thumbnail-item <?php echo esc_attr($active_class); ?>"
                                     data-index="<?php echo $index; ?>"
                                     data-image="<?php echo esc_url($thumb_image); ?>"
                                     data-title="<?php echo esc_attr($thumb_title); ?>"
                                     data-excerpt="<?php echo esc_attr($thumb_excerpt); ?>"
                                     data-link="<?php echo esc_url($thumb_link); ?>"
                                     data-tag="<?php echo esc_attr($thumb_tag); ?>">
                                    <div class="thumbnail-item-img">
                                        <img src="<?php echo esc_url($thumb_image); ?>" alt="<?php echo esc_attr($thumb_title); ?>" />
                                    </div>
                                    <div class="thumbnail-item-content">
                                        <?php if ($thumb_tag) : ?>
                                            <span class="thumbnail-tag color-<?php echo esc_attr($tag_color); ?>"><?php echo esc_html($thumb_tag); ?></span>
                                        <?php endif; ?>
                                        <h4 class="thumbnail-title"><?php echo esc_html($thumb_title); ?></h4>
                                    </div>
                                </div>
                                <?php $index++; endforeach; ?>
                            </div>
                        </div>
                    </div>
                    <?php else : ?>
                        <p><?php echo esc_html($home_empty_events); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>