
<?php
$has_acf = function_exists('get_field');

// ── Options (com fallback para campos legados na página) ──────────────────
$qs_banner_title    = ($has_acf ? get_field('qs_banner_title',    'option') : '') ?: ($has_acf ? get_field('titulo-banner')               : '') ?: '';
$qs_banner_subtitle = ($has_acf ? get_field('qs_banner_subtitle', 'option') : '') ?: ($has_acf ? get_field('subtitulo-banner')             : '') ?: '';
$qs_intro_text      = ($has_acf ? get_field('qs_intro_text',      'option') : '') ?: '';
$qs_mission_title   = ($has_acf ? get_field('qs_mission_title',   'option') : '') ?: ($has_acf ? get_field('titulo-missao')                : '') ?: '';
$qs_mission_text    = ($has_acf ? get_field('qs_mission_text',    'option') : '') ?: ($has_acf ? get_field('texto-missao')                 : '') ?: '';
$qs_mission_image   = ($has_acf ? get_field('qs_mission_image',   'option') : null) ?: ($has_acf ? get_field('foto-missao')               : null) ?: null;
$qs_whatwedo_items  = ($has_acf ? get_field('qs_whatwedo_items',  'option') : []) ?: [];
$qs_timeline_image  = ($has_acf ? get_field('qs_timeline_image',  'option') : null) ?: null;
$qs_mapping_title   = ($has_acf ? get_field('qs_mapping_title',   'option') : '') ?: ($has_acf ? get_field('titulo-mapeamos')              : '') ?: '';
$qs_mapping_text    = ($has_acf ? get_field('qs_mapping_text',    'option') : '') ?: ($has_acf ? get_field('texto-mapeamos')               : '') ?: '';
$qs_mapping_items   = ($has_acf ? get_field('qs_mapping_items',   'option') : []) ?: [];
$qs_char_title      = ($has_acf ? get_field('qs_char_title',      'option') : '') ?: ($has_acf ? get_field('titulo-caracteristicas')       : '') ?: '';
$qs_char_subtitle   = ($has_acf ? get_field('qs_char_subtitle',   'option') : '') ?: ($has_acf ? get_field('subtitulo-caracteristicas')   : '') ?: '';
$qs_char_items      = ($has_acf ? get_field('qs_char_items',      'option') : []) ?: [];
$qs_dna_title       = ($has_acf ? get_field('qs_dna_title',       'option') : '') ?: ($has_acf ? get_field('titulo-dna')                  : '') ?: '';
$qs_dna_subtitle    = ($has_acf ? get_field('qs_dna_subtitle',    'option') : '') ?: ($has_acf ? get_field('subtitulo-dna')               : '') ?: '';
$qs_dna_items       = ($has_acf ? get_field('qs_dna_items',       'option') : []) ?: [];
$qs_timeline_carrossel = ($has_acf ? get_field('timeline_carrossel', 'option') : []) ?: [];
?>

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
                <?php if ($qs_banner_title) : ?>
                    <h1 class="title"><?php echo esc_html($qs_banner_title); ?></h1>
                <?php endif; ?>
                <?php if ($qs_banner_subtitle) : ?>
                    <h2><?php echo esc_html($qs_banner_subtitle); ?></h2>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<section class="mission">
    <div class="container">
        <div class="row  justify-content-center">
            <div class="col-xl-9" data-aos="fade-up">
                <div class="mission__content">
                    <?php if ($qs_intro_text) : ?>
                        <?php echo wp_kses_post($qs_intro_text); ?>
                    <?php else : ?>
                        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                        <p><?php the_content(); ?></p>
                        <?php endwhile; endif; ?>
                    <?php endif; ?>
                </div>
                <div class="mission__content-cards">
                    <div class="mission__cards-text">
                        <?php if ($qs_mission_title) : ?>
                            <h3><?php echo esc_html($qs_mission_title); ?></h3>
                        <?php endif; ?>
                        <?php if ($qs_mission_text) : ?>
                            <blockquote><?php echo esc_html($qs_mission_text); ?></blockquote>
                        <?php endif; ?>
                    </div>
                    <div class="mission__cards-img">
                        <?php if ($qs_mission_image) : ?>
                            <img class="card-icon" src="<?php echo esc_url($qs_mission_image['url']); ?>" alt="<?php echo esc_attr($qs_mission_image['alt'] ?? 'Imagem'); ?>" width="460" height="226" />
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="whatwedo">
    <div class="container">
        <div class="row  justify-content-center">
            <div class="col-xl-9">
                <div class="whatwedo__cards" data-aos="fade-up">
                    <?php if (!empty($qs_whatwedo_items)) : ?>
                        <?php foreach ($qs_whatwedo_items as $item) :
                            $icone  = $item['icone']  ?? null;
                            $titulo = $item['titulo'] ?? '';
                            $texto  = $item['texto']  ?? '';
                        ?>
                            <div class="whatwedo__card">
                                <div class="whatwedo__card-title">
                                    <?php if ($icone) : ?>
                                        <img src="<?php echo esc_url($icone['url']); ?>" alt="<?php echo esc_attr($titulo); ?>" width="72" height="72" />
                                    <?php endif; ?>
                                    <?php if ($titulo) : ?>
                                        <h4><?php echo wp_kses_post($titulo); ?></h4>
                                    <?php endif; ?>
                                </div>
                                <div class="whatwedo__card-content">
                                    <?php if ($texto) : ?>
                                        <p><?php echo wp_kses_post($texto); ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php elseif ($has_acf && have_rows('lista_-_o_que_fazemos')) : ?>
                        <?php while (have_rows('lista_-_o_que_fazemos')) : the_row();
                            $icone  = get_sub_field('icone-lista-fazemos');
                            $titulo = get_sub_field('titulo-lista-fazemos');
                            $texto  = get_sub_field('texto-lista-fazemos');
                        ?>
                            <div class="whatwedo__card">
                                <div class="whatwedo__card-title">
                                    <?php if ($icone) : ?>
                                        <img src="<?php echo esc_url($icone['url']); ?>" alt="<?php echo esc_attr($titulo); ?>" width="72" height="72" />
                                    <?php endif; ?>
                                    <?php if ($titulo) : ?>
                                        <h4><?php echo wp_kses_post($titulo); ?></h4>
                                    <?php endif; ?>
                                </div>
                                <div class="whatwedo__card-content">
                                    <?php if ($texto) : ?>
                                        <p><?php echo wp_kses_post($texto); ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="timeline" data-aos="fade-up">
    <div class="container">
        <div class="row  justify-content-center">
            <div class="col-xl-9">
                <div class="timeline__content-cards">
                    <h4>Nossa História</h4>

                    <?php if ( ! empty( $qs_timeline_carrossel ) ) : ?>
                    <div class="timeline-carousel">
                        <div class="timeline-carousel__wrapper">
                            <?php foreach ( $qs_timeline_carrossel as $item ) : ?>
                                <?php
                                $ano = $item['ano'] ?? '';
                                $linhas = $item['timeline_linhas'] ?? [];
                                ?>
                                <div class="timeline-carousel__item">
                                    <div class="timeline-carousel__year"><?php echo esc_html( $ano ); ?></div>
                                    <div class="timeline-carousel__details">
                                        <?php if ( ! empty( $linhas ) ) : ?>
                                            <?php foreach ( $linhas as $linha ) : ?>
                                                <?php
                                                $linha_icon = $linha['linha_icon'] ?? null;
                                                $linha_texto = $linha['linha_texto'] ?? '';
                                                ?>
                                                <?php if ( $linha_texto ) : ?>
                                                <div class="timeline-carousel__line">
                                                    <?php if ( is_array( $linha_icon ) ) : ?>
                                                    <img src="<?php echo esc_url( $linha_icon['url'] ); ?>" alt="" width="24" height="24">
                                                    <?php endif; ?>
                                                    <span><?php echo esc_html( $linha_texto ); ?></span>
                                                </div>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
</section>

<section class="mapping">
    <div class="container">
        <div class="row  justify-content-center">
            <div class="col-xl-9">
                <div class="mapping__content-cards" data-aos="fade-up">
                    <?php if ($qs_mapping_title) : ?>
                        <h5><?php echo esc_html($qs_mapping_title); ?></h5>
                    <?php endif; ?>
                    <?php if ($qs_mapping_text) : ?>
                        <p><?php echo esc_html($qs_mapping_text); ?></p>
                    <?php endif; ?>
                    <div class="mapping__cards">
                        <?php if (!empty($qs_mapping_items)) : ?>
                            <?php foreach ($qs_mapping_items as $item) :
                                $imagem = $item['imagem'] ?? null;
                                $titulo = $item['titulo'] ?? '';
                                $texto  = $item['texto']  ?? '';
                            ?>
                                <div class="mapping__card">
                                    <div class="mapping__img">
                                        <?php if ($imagem) : ?>
                                            <img src="<?php echo esc_url($imagem['url']); ?>" alt="<?php echo esc_attr($titulo); ?>" width="293" height="240" />
                                        <?php endif; ?>
                                    </div>
                                    <div class="mapping__content">
                                        <?php if ($titulo) : ?>
                                            <h6><?php echo esc_html($titulo); ?></h6>
                                        <?php endif; ?>
                                        <?php if ($texto) : ?>
                                            <p><?php echo esc_html($texto); ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php elseif ($has_acf && have_rows('lista_-_mapeamos')) : ?>
                            <?php while (have_rows('lista_-_mapeamos')) : the_row();
                                $imagem = get_sub_field('imagem-mapeamos');
                                $titulo = get_sub_field('titulo-mapeamos-lista');
                                $texto  = get_sub_field('texto-mapeamos-lista');
                            ?>
                                <div class="mapping__card">
                                    <div class="mapping__img">
                                        <?php if ($imagem) : ?>
                                            <img src="<?php echo esc_url($imagem['url']); ?>" alt="<?php echo esc_attr($titulo); ?>" width="293" height="240" />
                                        <?php endif; ?>
                                    </div>
                                    <div class="mapping__content">
                                        <?php if ($titulo) : ?>
                                            <h6><?php echo esc_html($titulo); ?></h6>
                                        <?php endif; ?>
                                        <?php if ($texto) : ?>
                                            <p><?php echo esc_html($texto); ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="dna">
    <div class="container">
        <div class="row  justify-content-center">
            <div class="col-xl-9">
                <div class="dna__content" data-aos="fade-up">
                    <?php if ($qs_char_title) : ?>
                        <h5><?php echo esc_html($qs_char_title); ?></h5>
                    <?php endif; ?>
                    <?php if ($qs_char_subtitle) : ?>
                        <p><?php echo esc_html($qs_char_subtitle); ?></p>
                    <?php endif; ?>
                    <div class="dna__cards">
                        <?php if (!empty($qs_char_items)) : ?>
                            <?php foreach ($qs_char_items as $item) :
                                $icone  = $item['icone']  ?? null;
                                $titulo = $item['titulo'] ?? '';
                                $texto  = $item['texto']  ?? '';
                            ?>
                                <div class="dna__card">
                                    <?php if ($icone) : ?>
                                        <img src="<?php echo esc_url($icone['url']); ?>" alt="<?php echo esc_attr($titulo ?: 'Ícone'); ?>" width="48" height="48" />
                                    <?php endif; ?>
                                    <?php if ($titulo) : ?>
                                        <h6><?php echo esc_html($titulo); ?></h6>
                                    <?php endif; ?>
                                    <?php if ($texto) : ?>
                                        <p><?php echo esc_html($texto); ?></p>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        <?php elseif ($has_acf && have_rows('lista_caracteristicas')) : ?>
                            <?php while (have_rows('lista_caracteristicas')) : the_row();
                                $icone  = get_sub_field('icone-caracteristicas-lista');
                                $titulo = get_sub_field('titulo-caracteristicas-lista');
                                $texto  = get_sub_field('texto-caracteristicas-lista');
                            ?>
                                <div class="dna__card">
                                    <?php if ($icone) : ?>
                                        <img src="<?php echo esc_url($icone['url']); ?>" alt="<?php echo esc_attr($titulo ?: 'Ícone'); ?>" width="48" height="48" />
                                    <?php endif; ?>
                                    <?php if ($titulo) : ?>
                                        <h6><?php echo esc_html($titulo); ?></h6>
                                    <?php endif; ?>
                                    <?php if ($texto) : ?>
                                        <p><?php echo esc_html($texto); ?></p>
                                    <?php endif; ?>
                                </div>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </div>

                    <?php if ($qs_dna_title) : ?>
                        <h5><?php echo esc_html($qs_dna_title); ?></h5>
                    <?php endif; ?>
                    <?php if ($qs_dna_subtitle) : ?>
                        <p><?php echo esc_html($qs_dna_subtitle); ?></p>
                    <?php endif; ?>
                    <div class="dna__cards">
                        <?php if (!empty($qs_dna_items)) : ?>
                            <?php foreach ($qs_dna_items as $item) :
                                $icone  = $item['icone']  ?? null;
                                $titulo = $item['titulo'] ?? '';
                                $texto  = $item['texto']  ?? '';
                            ?>
                                <div class="dna__card">
                                    <?php if ($icone) : ?>
                                        <img src="<?php echo esc_url($icone['url']); ?>" alt="<?php echo esc_attr($titulo ?: 'Ícone'); ?>" width="48" height="48" />
                                    <?php endif; ?>
                                    <?php if ($titulo) : ?>
                                        <h6><?php echo esc_html($titulo); ?></h6>
                                    <?php endif; ?>
                                    <?php if ($texto) : ?>
                                        <p><?php echo esc_html($texto); ?></p>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        <?php elseif ($has_acf && have_rows('lista_dna')) : ?>
                            <?php while (have_rows('lista_dna')) : the_row();
                                $icone  = get_sub_field('icone-dna-lista');
                                $titulo = get_sub_field('titulo-dna-lista');
                                $texto  = get_sub_field('texto-dna-lista');
                            ?>
                                <div class="dna__card">
                                    <?php if ($icone) : ?>
                                        <img src="<?php echo esc_url($icone['url']); ?>" alt="<?php echo esc_attr($titulo ?: 'Ícone'); ?>" width="48" height="48" />
                                    <?php endif; ?>
                                    <?php if ($titulo) : ?>
                                        <h6><?php echo esc_html($titulo); ?></h6>
                                    <?php endif; ?>
                                    <?php if ($texto) : ?>
                                        <p><?php echo esc_html($texto); ?></p>
                                    <?php endif; ?>
                                </div>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>