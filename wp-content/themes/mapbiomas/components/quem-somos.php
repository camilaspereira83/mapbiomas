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
                <h1 class="title">Conheça o MapBiomas</h1>
                <h2>MapBiomas: inovação e ciência para o monitoramento do uso da terra</h2>
            </div>
        </div>
    </div>
</section>

<section class="mission">
    <div class="container">
        <div class="row  justify-content-center">
            <div class="col-xl-9" data-aos="fade-up">
                <div class="mission__content">
                    <p>O MapBiomas é uma rede multi-institucional composta por ONGs, universidades e empresas de tecnologia. Produzimos e promovemos dados qualificados sobre a cobertura e o uso da terra. Nossa atuação abrange 17 países, que incluem a América do Sul e outras regiões tropicais. Utilizamos imagens de satélite, computação em nuvem e inteligência artificial para monitorar transformações territoriais desde 1985. Oferecemos uma base de dados pública, gratuita e atualizada para fundamentar decisões sobre conservação e manejo sustentável.</p>
                </div>
                <div class="mission__content-cards">
                    <div class="mission__cards-text">
                        <h3>Nossa Missão</h3>
                        <blockquote>"Irevelar as transformações do território através da ciência, com precisão, agilidade e qualidade, tornando acessível o conhecimento sobre a cobertura e o uso da terra.."</blockquote>
                    </div>
                    <div class="mission__cards-img">
                        <img class="card-icon" src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/img-nossa-missao.jpg'); ?>" alt="Imagem" width="460" height="226" />
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
                    <div class="whatwedo__card">
                        <div class="whatwedo__card-title">
                            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/icon-1.svg'); ?>" alt="Ícone de " width="72" height="72" />
                            <h4>O que<br> fazemos</h4>
                        </div>
                        <div class="whatwedo__card-content">
                            <p>Produzimos mapas anuais de cobertura e uso da terra com detalhamento pixel a pixel. Desenvolvemos algoritmos para processar séries históricas de imagens de satélite. Disponibilizamos códigos, métodos e dados brutos de forma transparente. Monitoramos biomas e temas transversais, como fogo, água e áreas urbanas. Fornecemos infraestrutura de dados para cientistas, gestores públicos e empresas.</p>
                        </div>
                    </div>
                    <div class="whatwedo__card">
                        <div class="whatwedo__card-title">
                            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/icon-2.svg'); ?>" alt="Ícone de " width="72" height="72" />
                            <h4>O que<br> <span>não</span> fazemos</h4>
                        </div>
                        <div class="whatwedo__card-content">
                            <p>Não produzimos análises políticas, interpretações ou juízos de valor sobre os dados. Não realizamos ações diretas de advocacy. O MapBiomas não emite opiniões sobre políticas públicas ou projetos específicos. Nossas instituições parceiras podem realizar essas atividades isoladamente, mas não em nome da rede.</p>
                        </div>
                    </div>
                    <div class="whatwedo__card">
                        <div class="whatwedo__card-title">
                            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/icon-3.svg'); ?>" alt="Ícone de " width="72" height="72" />
                            <h4>Como funciona<br> nossa tecnologia</h4>
                        </div>
                        <div class="whatwedo__card-content">
                            <p>Processamos dados de forma distribuída e automatizada no Google Earth Engine. Utilizamos aprendizado de máquina (Machine Learning) para classificar cada pixel da imagem. Geramos matrizes de transição que revelam como a terra mudou ao longo das décadas. Publicamos o Documento de Base Teórica do Algoritmo (ATBD) para cada coleção. Esse procedimento transparente e de rigor técnico permite que o modelo seja replicado e possa ser aprimorado.</p>
                        </div>
                    </div>
                    <div class="whatwedo__card">
                        <div class="whatwedo__card-title">
                            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/icon-4.svg'); ?>" alt="Ícone de " width="72" height="72" />
                            <h4>Quem utiliza<br> nossos dados</h4>
                        </div>
                        <div class="whatwedo__card-content">
                            <p>Tomadores de decisão utilizam nossos mapas para planejar políticas de conservação. Órgãos de fiscalização aplicam dados do MapBiomas Alerta para identificar desmatamentos ilegais. Pesquisadores utilizam nossas séries históricas em estudos sobre mudanças climáticas. Empresas privadas consultam os dados para garantir conformidade ambiental em suas cadeias produtivas. O setor financeiro utiliza as informações para avaliar riscos de crédito.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="timeline" data-aos="fade-up">
    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/linha-tempo.jpg" alt="Linha do tempo" width="100%"/>
</section>

<section class="mapping">
    <div class="container">
        <div class="row  justify-content-center">
            <div class="col-xl-9">
                <div class="mapping__content-cards" data-aos="fade-up">
                    <h5>O que mapeamos</h5>
                    <p>Revelamos as dinâmicas espaciais e temporais do território por meio de três eixos principais:</p>
                    <div class="mapping__cards">
                        <div class="mapping__card">
                            <div class="mapping__img">
                                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/Rating.jpg'); ?>" alt="Imagem" width="293" height="240" />
                            </div>
                            <div class="mapping__content">
                                <h6>Cobertura da terra</h6>
                                <p>Classificamos tipologias naturais, como formações florestais, savânicas, campestres e áreas alagadas.</p>
                            </div>
                        </div>
                        <div class="mapping__card">
                            <div class="mapping__img">
                                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/Rating.jpg'); ?>" alt="Imagem" width="293" height="240" />
                            </div>
                            <div class="mapping__content">
                                <h6>Uso da terra</h6>
                                <p>Identificamos áreas transformadas pela ação humana, incluindo pastagens, agricultura, mineração e áreas urbanas.</p>
                            </div>
                        </div>
                        <div class="mapping__card">
                            <div class="mapping__img">
                                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/Rating.jpg'); ?>" alt="Imagem" width="293" height="240" />
                            </div>
                            <div class="mapping__content">
                                <h6>Transições e mudanças</h6>
                                <p>Geramos mapas que detalham a conversão entre diferentes classes de uso ao longo dos anos.</p>
                            </div>
                        </div>
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
                    <h5>Características e princípios</h5>
                    <p>Os valores que guiam o trabalho da rede MapBiomas</p>
                    <div class="dna__cards">
                        <div class="dna__card">
                            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/icon1.svg'); ?>" alt="Icone" width="48" height="48" />
                            <h6>Dados Abertos</h6>
                            <p>Todos os dados são públicos e de acesso gratuito, sem barreiras.</p>
                        </div>
                        <div class="dna__card">
                            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/icon2.svg'); ?>" alt="Icone" width="48" height="48" />
                            <h6>Ciência Colaborativa</h6>
                            <p>Rede de especialistas de múltiplas instituições trabalhando juntos.</p>
                        </div>
                        <div class="dna__card">
                            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/icon3.svg'); ?>" alt="Icone" width="48" height="48" />
                            <h6>Tecnologia de Ponta</h6>
                            <p>Uso do Google Earth Engine para processamento em escala global.</p>
                        </div>
                        <div class="dna__card">
                            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/icon4.svg'); ?>" alt="Icone" width="48" height="48" />
                            <h6>Séries Históricas</h6>
                            <p>Dados anuais desde 1985, permitindo análise de longo prazo.</p>
                        </div>
                        <div class="dna__card">
                            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/icon5.svg'); ?>" alt="Icone" width="48" height="48" />
                            <h6>Transparência</h6>
                            <p>Código aberto e metodologia totalmente documentada e publicada.</p>
                        </div>
                        <div class="dna__card">
                            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/icon6.svg'); ?>" alt="Icone" width="48" height="48" />
                            <h6>Impacto Global</h6>
                            <p>Dados usados em políticas públicas, pesquisas e jornalismo.</p>
                        </div>
                    </div>
                    <h5>DNA da Rede MapBiomas</h5>
                    <p>O que define a essência da nossa rede</p>
                    <div class="dna__cards">
                        <div class="dna__card">
                            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/icon7.svg'); ?>" alt="Icone" width="48" height="48" />
                            <h6>Multi-institucional</h6>
                            <p>Reúne mais de 100 instituições de diferentes setores e países.</p>
                        </div>
                        <div class="dna__card">
                            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/icon8.svg'); ?>" alt="Icone" width="48" height="48" />
                            <h6>Interdisciplinar</h6>
                            <p>Integra ecologia, computação, sensoriamento remoto e políticas públicas.</p>
                        </div>
                        <div class="dna__card">
                            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/icon9.svg'); ?>" alt="Icone" width="48" height="48" />
                            <h6>Escalável</h6>
                            <p>Metodologia replicável para qualquer país ou ecossistema do planeta.</p>
                        </div>
                        <div class="dna__card">
                            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/icon10.svg'); ?>" alt="Icone" width="48" height="48" />
                            <h6>Orientada por dados</h6>
                            <p>Todas as decisões baseadas em evidências científicas robustas.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>