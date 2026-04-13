<header>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="header__logo__nav">
                    <div class="header__logo">
                        <a href="<?php echo esc_url(home_url('/')); ?>">
                            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/logo-MapBiomas_10anos.png'); ?>" alt="Logo MapBiomas 10 anos" width="117" height="65"/>
                        </a>
                    </div>
                    <div class="header__nav">
                        <nav>
                            <?php
                                wp_nav_menu (
                                    array (
                                    'menu' => 'navegacao-principal',
                                    'container' => 'false',
                                    'menu_class' => 'menu'
                                    )
                                );
                            ?>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>