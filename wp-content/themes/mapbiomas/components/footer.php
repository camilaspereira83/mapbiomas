<footer>
    <div class="container">
        <div class="footer-content-nav" data-aos="fade-up">
            <div class="footer-content">
                <div class="footer-logo">
                    <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/logo-MapBiomas-10anos-header.svg'); ?>" alt="MapBiomas Logo" width="273" height="69" />
                    <p>Ciência em cada pixel.</p>
                </div>
                <div class="footer-cc">
                    <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/cc-sticker-2007 1.png'); ?>" alt="Creative Commons" width="67" height="66" />
                    <p>Os dados do MapBiomas são de uso público, aberto e gratuito mediante referência.<br> CC BY 4.0 →</p>
                </div>
            </div>
            <div class="footer-nav">
                <nav class="footer-navigation" aria-label="<?php esc_attr_e('Menu de rodapé Mapa do site', 'mapbiomas'); ?>">
                    <h4>Mapa do site</h4>
                    <?php
                        wp_nav_menu(
                            array(
                                'theme_location' => 'navegacao-rodape-mapa',
                                'container' => false,
                                'menu_class' => 'footer-menu',
                                'fallback_cb' => false,
                            )
                        );
                    ?>
                </nav>
                <nav class="footer-navigation" aria-label="<?php esc_attr_e('Menu de rodapé Contato', 'mapbiomas'); ?>">
                    <h4>Contato</h4>
                    <?php
                        wp_nav_menu(
                            array(
                                'theme_location' => 'navegacao-rodape-contato',
                                'container' => false,
                                'menu_class' => 'footer-menu2',
                                'fallback_cb' => false,
                            )
                        );
                    ?>
                </nav>
            </div>
        </div>
    </div>
</footer>

<section class="footer-info">
    <div class="container">
        <div class="footer-content">
            <p>© 2026 Todos os direitos reservados.</p>
            <div class="social">
                <a href="https://www.youtube.com/@MapBiomasBrasil" class="youtube" target="_blank" rel="noopener"></a>
                <a href="https://www.instagram.com/mapbiomasbrasil/" class="instagram" target="_blank" rel="noopener"></a>
                <a href="https://www.linkedin.com/company/mapbiomas/posts/?feedView=all" class="linkedin" target="_blank" rel="noopener"></a>
                <a href="" class="x" target="_blank" rel="noopener"></a>
                <a href="https://www.facebook.com/mapbiomas/" class="facebook" target="_blank" rel="noopener"></a>
                <a href="" class="git" target="_blank" rel="noopener"></a>
            </div>
        </div>
    </div>
</section>