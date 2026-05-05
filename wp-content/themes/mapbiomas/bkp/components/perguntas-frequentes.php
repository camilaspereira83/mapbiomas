<section class="breadcrumb__title bg-color-orange">
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
                <h1 class="title">Perguntas frequentes</h1>
            </div>
        </div>
    </div>
</section>

<section class="faq">
    <div class="container">
        <div class="row  justify-content-center">
            <div class="col-xl-9">
                <div class="faq__content" data-aos="fade-up">
                    <?php if (have_rows('perguntas_e_respostas')) : ?>

                        <?php 
                            $index = 1;
                            while (have_rows('perguntas_e_respostas')) : the_row(); 
                                
                                $pergunta = get_sub_field('pergunta_faq');
                                $resposta = get_sub_field('resposta_faq');
                            ?>

                                <div class="faq__item">
                                    <button class="faq__question" aria-expanded="false">
                                        
                                        <span>
                                            <?php echo $index . '. ' . esc_html($pergunta); ?>
                                        </span>

                                        <img 
                                            class="faq__icon"
                                            src="<?php echo get_template_directory_uri(); ?>/assets/img/plus.svg"
                                            data-plus="<?php echo get_template_directory_uri(); ?>/assets/img/plus.svg"
                                            data-minus="<?php echo get_template_directory_uri(); ?>/assets/img/minus.svg"
                                            alt="Abrir"
                                        >
                                    </button>

                                    <div class="faq__answer">
                                        <?php echo wp_kses_post($resposta); ?>
                                    </div>
                                </div>

                            <?php 
                            $index++;
                            endwhile; 
                        ?>

                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="formfaq">
    <div class="container">
        <div class="row  justify-content-center">
            <div class="col-xl-9">
                <div class="formfaq__content" data-aos="fade-up">
                    <h3>Não encontrou sua resposta?</h3>
                    <p>Entre em contato com a equipe MapBiomas</p>
                    <form>
                        <textarea type="text" name="duvida" placeholder="Descreva sua dúvida..." required></textarea>
                        <button type="submit">Enviar pergunta</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>