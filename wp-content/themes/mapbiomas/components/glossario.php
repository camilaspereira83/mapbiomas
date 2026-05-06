<section class="breadcrumb__title bg-color-yellow">
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
                <h1 class="title">Glossário MapBiomas</h1>
            </div>
        </div>
    </div>
</section>

<section class="glossary">
    <div class="container">
        <div class="row  justify-content-center">
            <div class="col-xl-9">
                <div class="glossary__content" data-aos="fade-up">
                    <?php 
                        $glossario = get_field('glossario');
                        if ($glossario) {
                            $agrupado = [];
                            foreach ($glossario as $item) {
                                $letra = strtoupper(mb_substr($item['termo'], 0, 1));
                                $agrupado[$letra][] = $item;
                            }
                            ksort($agrupado);
                        ?>

                        <div class="glossary__search">
                            <input type="text" id="glossary-search" placeholder="Procurar palavra">
                        </div>
                        <p class="glossary__empty" style="display:none;">
                            Nenhum resultado encontrado.
                        </p>

                        <div class="glossary__letters">
                            <button class="glossary__letter-filter active" data-letter="all">
                                Todas
                            </button>

                            <?php foreach ($agrupado as $letra => $itens) : ?>
                                <button class="glossary__letter-filter" data-letter="<?php echo $letra; ?>">
                                    <?php echo $letra; ?>
                                </button>
                            <?php endforeach; ?>
                        </div>

                        <?php foreach ($agrupado as $letra => $itens) : ?>
                            <div class="glossary__group">
                                <div class="glossary__letter"><?php echo $letra; ?></div>
                                <div class="glossary__items">
                                    <?php foreach ($itens as $item) : ?>
                                        <div class="glossary__card" data-termo="<?php echo esc_attr(strtolower($item['termo'])); ?>">
                                            <div class="glossary__header">
                                                <h3><?php echo esc_html($item['termo']); ?></h3>
                                                <?php if ($item['tipo']) : ?>
                                                   <?php
                                                    $tipo = $item['tipo'];
                                                    $tipo_slug = sanitize_title($tipo);
                                                    ?>
                                                    <span class="badge badge-<?php echo esc_attr($tipo_slug); ?>">
                                                        <?php echo esc_html($tipo); ?>
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                            <p><?php echo wp_kses_post($item['descricao']); ?></p>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>