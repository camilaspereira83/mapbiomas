<header class="header" data-aos="fade-down">
    <div class="container">
        <div class="header__inner">
            <div class="branding">
                <a class="logo-link" href="<?php echo esc_url(home_url('/')); ?>">
                    <img class="logo" src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/logo-MapBiomas-10anos-header.svg'); ?>" alt="Logo MapBiomas 10 anos" width="186" height="47" />
                </a>
            </div>
            <nav class="main-navigation" aria-label="<?php esc_attr_e('Menu principal', 'mapbiomas'); ?>">
                <?php
                    wp_nav_menu(
                        array(
                            'theme_location' => 'navegacao-principal',
                            'container' => false,
                            'menu_class' => 'menu',
                            'fallback_cb' => false,
                        )
                    );
                ?>
            </nav>
            <div id="menuToggle">
                <span></span>
                <span></span>
                <span></span>
                <span></span>
            </div>
            <div class="header__language">
                <button type="button" class="language-current active" aria-expanded="false">
                    <img class="language-icon" src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/globe.svg'); ?>" alt="Ícone de globo terrestre" width="14" height="14" />
                    <span class="country-name">PT</span>
                    <img class="language-flag" src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/flags/br.svg'); ?>" alt="Ícone da bandeira do Brasil" width="12" height="12" />
                    <img class="language-arrow" src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/arrow-down.svg'); ?>" alt="Ícone de seta para baixo" width="12" height="12" />
                </button>

                <ul class="language-list">
                    <li class="language-item">
                        <button type="button" class="language-option">
                            <span class="language-label">AR</span>
                            <img class="language-flag" src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/flags/ar.svg'); ?>" alt="Ícone da bandeira do Argentina" width="12" height="12" />
                        </button>
                    </li>
                    <li class="language-item">
                        <button type="button" class="language-option">
                            <span class="language-label">BO</span>
                            <img class="language-flag" src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/flags/bo.svg'); ?>" alt="Ícone da bandeira do Bolivia" width="12" height="12" />
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>