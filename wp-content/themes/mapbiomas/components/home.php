<?php
/*
 * Template Name: Home
*/
?>

<section class="home" data-aos="fade-up">
    <div class="container">
        <div class="home__content">
            <?php the_content(); ?>
        </div>

        <div class="home__stats">
            <?php if (have_rows('caixas_numericas')) : ?>
                <?php while (have_rows('caixas_numericas')) : the_row();

                    $titulo = get_sub_field('titulo_caixas_numericas');
                    $numero = get_sub_field('numero_caixas_numericas');
                    $adicional = get_sub_field('adicional_caixas_numericas');
                    $cor = get_sub_field('cor_caixa'); 

                ?>

                    <div class="stat-item item-<?php echo esc_attr($cor); ?>">
                    
                    <?php if ($titulo) : ?>
                        <p class="stat-title"><?php echo esc_html($titulo); ?></p>
                    <?php endif; ?>

                    <?php if ($numero) : ?>
                        <div class="stat-number" data-target="<?php echo esc_attr($numero); ?>">
                        0<?php echo esc_html($adicional ? '' : ''); ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($adicional) : ?>
                        <span class="stat-unit"><?php echo esc_html($adicional); ?></span>
                    <?php endif; ?>

                    </div>

                <?php endwhile; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<section class="worldmap" data-aos="fade-up">
    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/WorldMap.jpg" alt="World Map" width="100%"/>
</section>

<section class="news-events" data-aos="fade-up">
    <div class="container">
        <div class="home__news-events">
            <div class="home__news-events__title-tabs">
                <h2>Fique por dentro</h2>
                <div class="news-events-tabs">
                    <button class="tab-button active" data-tab="noticias"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/file.svg" alt="Ícone de notícia" width="13" height="16"/> Notícias</button>
                    <button class="tab-button" data-tab="eventos"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/event.svg" alt="Ícone de eventos" width="15" height="16"/> Eventos</button>
                </div>
            </div>

            <div class="news-events-content">
                <div class="tab-content active" id="noticias">
                    <?php
                    $noticias_query = new WP_Query(array(
                        'category_name' => 'noticias',
                        'posts_per_page' => 5,
                        'post_status' => 'publish'
                    ));

                    if ($noticias_query->have_posts()) :
                        $noticias_posts = $noticias_query->posts;
                        $first_noticia = $noticias_posts[0];
                    ?>
                    <div class="news-carousel">
                        <div class="featured-news">
                            <?php
                            $featured_image = get_the_post_thumbnail_url($first_noticia->ID, 'large') ?: get_template_directory_uri() . '/assets/img/news-placeholder.jpg';
                            $featured_title = $first_noticia->post_title;
                            $featured_excerpt = wp_trim_words($first_noticia->post_excerpt ?: $first_noticia->post_content, 20, '...');
                            $featured_link = get_permalink($first_noticia->ID);
                            $tag_destaque = get_post_meta($first_noticia->ID, 'tag_destaque', true) ?: '';
                            ?>
                            <div class="featured-image">
                                <img src="<?php echo esc_url($featured_image); ?>" alt="<?php echo esc_attr($featured_title); ?>" />
                            </div>
                            <div class="featured-content">
                                <div class="featured-meta">
                                    <?php if ($tag_destaque) : ?>
                                        <span class="featured-tag"><?php echo esc_html($tag_destaque); ?></span>
                                    <?php endif; ?>
                                    <div class="featured-location">
                                        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/BR.svg'); ?>" alt="Bandeira do Brasil" width="16" height="16" />
                                        <span>Brasil</span>
                                    </div>
                                    <span class="featured-date"><?php echo get_the_date('d/m/Y', $first_noticia->ID); ?></span>
                                </div>
                                <h3 class="featured-title">
                                    <a href="<?php echo esc_url($featured_link); ?>"><?php echo esc_html($featured_title); ?></a>
                                </h3>
                                <p class="featured-excerpt"><?php echo esc_html($featured_excerpt); ?></p>
                                <a href="<?php echo esc_url($featured_link); ?>" class="read-more-btn">Ler mais</a>
                            </div>
                            <button class="carousel-arrow prev-arrow">
                                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/arrow-next.svg'); ?>" alt="Seta para esquerda" width="13" height="13" />
                            </button>
                            <button class="carousel-arrow next-arrow">
                                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/arrow-next.svg'); ?>" alt="Seta para esquerda" width="13" height="13" />
                            </button>
                            <div class="carousel-dots"></div>
                        </div>

                        <div class="thumbnails-carousel">

                            <div class="thumbnails-wrapper">
                                <?php
                                $index = 0;
                                foreach ($noticias_posts as $noticia) :
                                    $thumb_image = get_the_post_thumbnail_url($noticia->ID, 'thumbnail') ?: get_template_directory_uri() . '/assets/img/news-placeholder.jpg';
                                    $thumb_title = $noticia->post_title;
                                    $thumb_excerpt = wp_trim_words($noticia->post_excerpt ?: $noticia->post_content, 15, '...');
                                    $thumb_link = get_permalink($noticia->ID);
                                    $thumb_tag = get_post_meta($noticia->ID, 'tag_destaque', true) ?: '';
                                    $active_class = ($index === 0) ? 'active' : '';
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
                                            <span class="thumbnail-tag"><?php echo esc_html($thumb_tag); ?></span>
                                        <?php endif; ?>
                                        <h4 class="thumbnail-title"><?php echo esc_html($thumb_title); ?></h4>
                                    </div>
                                </div>
                                <?php $index++; endforeach; ?>
                            </div>
                        </div>
                    </div>
                    <?php else : ?>
                        <p>Nenhuma notícia encontrada.</p>
                    <?php endif; ?>
                </div>

                <div class="tab-content" id="eventos">
                    <?php
                    $eventos_query = new WP_Query(array(
                        'category_name' => 'eventos',
                        'posts_per_page' => 5,
                        'post_status' => 'publish'
                    ));

                    if ($eventos_query->have_posts()) :
                        $eventos_posts = $eventos_query->posts;
                        $first_evento = $eventos_posts[0];
                    ?>
                    <div class="news-carousel">
                        <div class="featured-news">
                            <?php
                            $featured_image = get_the_post_thumbnail_url($first_evento->ID, 'large') ?: get_template_directory_uri() . '/assets/img/event-placeholder.jpg';
                            $featured_title = $first_evento->post_title;
                            $featured_excerpt = wp_trim_words($first_evento->post_excerpt ?: $first_evento->post_content, 20, '...');
                            $featured_link = get_permalink($first_evento->ID);
                            $tag_destaque = get_post_meta($first_evento->ID, 'tag_destaque', true) ?: '';
                            ?>
                            <div class="featured-image">
                                <img src="<?php echo esc_url($featured_image); ?>" alt="<?php echo esc_attr($featured_title); ?>" />
                            </div>
                            <div class="featured-content">
                                <div class="featured-meta">
                                    <?php if ($tag_destaque) : ?>
                                        <span class="featured-tag"><?php echo esc_html($tag_destaque); ?></span>
                                    <?php endif; ?>
                                    <div class="featured-location">
                                        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/BR.svg'); ?>" alt="Bandeira do Brasil" width="16" height="16" />
                                        <span>Brasil</span>
                                    </div>
                                    <span class="featured-date"><?php echo get_the_date('d/m/Y', $first_evento->ID); ?></span>
                                </div>
                                <h3 class="featured-title">
                                    <a href="<?php echo esc_url($featured_link); ?>"><?php echo esc_html($featured_title); ?></a>
                                </h3>
                                <p class="featured-excerpt"><?php echo esc_html($featured_excerpt); ?></p>
                                <a href="<?php echo esc_url($featured_link); ?>" class="read-more-btn">Ler mais</a>
                            </div>
                            <button class="carousel-arrow prev-arrow">
                                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/arrow-next.svg'); ?>" alt="Seta para esquerda" width="13" height="13" />
                            </button>
                            <button class="carousel-arrow next-arrow">
                                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/arrow-next.svg'); ?>" alt="Seta para esquerda" width="13" height="13" />
                            </button>
                        </div>

                        <div class="thumbnails-carousel">
                            <div class="thumbnails-wrapper">
                                <?php
                                $index = 0;
                                foreach ($eventos_posts as $evento) :
                                    $thumb_image = get_the_post_thumbnail_url($evento->ID, 'thumbnail') ?: get_template_directory_uri() . '/assets/img/event-placeholder.jpg';
                                    $thumb_title = $evento->post_title;
                                    $thumb_excerpt = wp_trim_words($evento->post_excerpt ?: $evento->post_content, 15, '...');
                                    $thumb_link = get_permalink($evento->ID);
                                    $thumb_tag = get_post_meta($evento->ID, 'tag_destaque', true) ?: '';
                                    $active_class = ($index === 0) ? 'active' : '';
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
                                            <span class="thumbnail-tag"><?php echo esc_html($thumb_tag); ?></span>
                                        <?php endif; ?>
                                        <h4 class="thumbnail-title"><?php echo esc_html($thumb_title); ?></h4>
                                    </div>
                                </div>
                                <?php $index++; endforeach; ?>
                            </div>
                        </div>
                    </div>
                    <?php else : ?>
                        <p>Nenhum evento encontrado.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>