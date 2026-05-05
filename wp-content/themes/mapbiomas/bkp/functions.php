<?php
# Load components
require_once __DIR__ . '/classes/components/Component.php';
require_once __DIR__ . '/classes/components/Home.php';
require_once __DIR__ . '/classes/components/QuemSomos.php';
require_once __DIR__ . '/classes/components/ConhecaRede.php';
require_once __DIR__ . '/classes/components/PerguntasFrequentes.php';
require_once __DIR__ . '/classes/components/Glossario.php';

// Limite Upload
@ini_set( 'upload_max_size' , '64M' );
@ini_set( 'post_max_size', '64M');
@ini_set( 'max_execution_time', '300' );

//Suport to Thumbnails
if (function_exists('add_theme_support')) {
  add_theme_support('post-thumbnails');
  set_post_thumbnail_size( 220, 153 );
}

//Register Sidebar
if (function_exists('register_sidebar')) {
    register_sidebar(
		array(
			'name' => 'Barra Lateral',
			'before_widget' => '<li id="%1$s" class="widget %2$s">',
			'after_widget'  => '</li>',
			'before_title'  => '<h2 class="widgettitle">',
			'after_title'   => '</h2>'
		)
	);
}

//Suporte à Custom Menus
if (function_exists('register_nav_menu')) {
	register_nav_menus( array(
		'navegacao-principal' => __( 'Navegacao Principal', 'menuadd' ),
		'navegacao-rodape-mapa' => __( 'Navegacao Rodape Mapa', 'menuadd' ),
		'navegacao-rodape-contato' => __( 'Navegacao Rodape Contato', 'menuadd' ),

	) );
	// Make theme available for translation
	// Translations can be filed in the /languages/ directory
	load_theme_textdomain( 'menuadd');
}


//Control Excerpt Length using Filters
function new_excerpt_length($length) {
	return 30;
}
add_filter('excerpt_length', 'new_excerpt_length');

// Enqueue Foundation Icons + estilos e scripts do tema
function mapbiomas_enqueue_assets() {
    $theme_dir = get_template_directory();
    $theme_uri = get_template_directory_uri();

    // Foundation Icons
    wp_enqueue_style(
        'foundation-icons',
        'https://cdnjs.cloudflare.com/ajax/libs/foundicons/3.0.0/foundation-icons.css',
        array(),
        '3.0.0'
    );

    // Stylesheet principal do tema (style.css na raiz)
    $style_path = $theme_dir . '/style.css';
    wp_enqueue_style(
        'mapbiomas-style',
        $theme_uri . '/style.css',
        array(),
        file_exists( $style_path ) ? filemtime( $style_path ) : '1.0.0'
    );

    // Script principal do tema
    $script_path = $theme_dir . '/script.js';
    if ( file_exists( $script_path ) ) {
        wp_enqueue_script(
            'mapbiomas-script',
            $theme_uri . '/script.js',
            array(),
            filemtime( $script_path ),
            true
        );
    }
}
add_action( 'wp_enqueue_scripts', 'mapbiomas_enqueue_assets' );


// ACF — Options Page + Field Groups — Conheça a Rede
add_action('acf/init', function () {
    if (!function_exists('acf_add_local_field_group')) return;

    if (function_exists('acf_add_options_page')) {
        acf_add_options_page([
            'page_title' => 'Conheça a Rede',
            'menu_title' => 'Conheça a Rede',
            'menu_slug'  => 'acf-conheca-rede',
            'capability' => 'edit_posts',
            'redirect'   => false,
            'icon_url'   => 'dashicons-networking',
            'position'   => 30,
        ]);
    }

    acf_add_local_field_group([
        'key'      => 'group_conheca_rede',
        'title'    => 'Conheça a Rede',
        'fields'   => [

            // ── Cabeçalho da página ─────────────────────────────────────────
            [
                'key'   => 'field_page_title',
                'label' => 'Título da Página',
                'name'  => 'page_title',
                'type'  => 'text',
                'instructions' => 'Título principal que será exibido no banner da página',
            ],
            [
                'key'   => 'field_page_subtitle',
                'label' => 'Subtítulo da Página',
                'name'  => 'page_subtitle',
                'type'  => 'text',
                'instructions' => 'Subtítulo que será exibido abaixo do título no banner',
            ],

            // ── Abrangência geográfica (mapa) ──────────────────────────────
            [
                'key'   => 'field_geo_title',
                'label' => 'Mapa — Título',
                'name'  => 'geo_title',
                'type'  => 'text',
            ],
            [
                'key'   => 'field_geo_desc',
                'label' => 'Mapa — Descrição',
                'name'  => 'geo_desc',
                'type'  => 'textarea',
                'rows'  => 2,
            ],
            [
                'key'          => 'field_geo_countries',
                'label'        => 'Mapa — Países',
                'name'         => 'geo_countries',
                'type'         => 'repeater',
                'button_label' => 'Adicionar país',
                'layout'       => 'table',
                'sub_fields'   => [
                    ['key'=>'field_geo_c_name',   'label'=>'Nome',   'name'=>'name',   'type'=>'text'],
                    ['key'=>'field_geo_c_iso2',   'label'=>'ISO2',   'name'=>'iso2',   'type'=>'text', 'instructions'=>'Ex: br, ar, co (minúsculo)'],
                    ['key'=>'field_geo_c_status', 'label'=>'Status', 'name'=>'status', 'type'=>'select',
                     'choices'=>['active'=>'Ativo','implementing'=>'Em implantação'], 'default_value'=>'active'],
                ],
            ],

            // ── Quem somos ─────────────────────────────────────────────────
            [
                'key'   => 'field_qs_title',
                'label' => 'Quem Somos — Título',
                'name'  => 'qs_title',
                'type'  => 'text',
            ],
            [
                'key'   => 'field_qs_desc',
                'label' => 'Quem Somos — Descrição',
                'name'  => 'qs_desc',
                'type'  => 'textarea',
                'rows'  => 3,
            ],
            [
                'key'          => 'field_qs_stats',
                'label'        => 'Quem Somos — Números',
                'name'         => 'qs_stats',
                'type'         => 'repeater',
                'button_label' => 'Adicionar número',
                'max'          => 4,
                'layout'       => 'table',
                'sub_fields'   => [
                    ['key'=>'field_qs_number', 'label'=>'Número', 'name'=>'number', 'type'=>'number'],
                    ['key'=>'field_qs_suffix', 'label'=>'Sufixo', 'name'=>'suffix', 'type'=>'text', 'instructions'=>'Ex: + ou deixe vazio'],
                    ['key'=>'field_qs_label',  'label'=>'Rótulo', 'name'=>'label',  'type'=>'text'],
                    ['key'=>'field_qs_card',   'label'=>'Cor',    'name'=>'card',   'type'=>'select',
                     'choices'=>['green'=>'Verde','blue'=>'Azul','orange'=>'Laranja','olive'=>'Verde-oliva']],
                    ['key'=>'field_qs_icon',   'label'=>'Ícone',  'name'=>'icon',   'type'=>'image',
                     'return_format' => 'array', 'preview_size' => 'thumbnail', 'library' => 'all'],
                ],
            ],

            // ── Comitê de coordenação ──────────────────────────────────────
            [
                'key'   => 'field_committee_title',
                'label' => 'Comitê — Título',
                'name'  => 'committee_title',
                'type'  => 'text',
            ],
            [
                'key'   => 'field_committee_desc',
                'label' => 'Comitê — Descrição',
                'name'  => 'committee_desc',
                'type'  => 'textarea',
                'rows'  => 3,
            ],
            [
                'key'          => 'field_committee_members',
                'label'        => 'Comitê — Membros',
                'name'         => 'committee_members',
                'type'         => 'repeater',
                'button_label' => 'Adicionar membro',
                'sub_fields'   => [
                    ['key'=>'field_comm_name',    'label'=>'Nome',              'name'=>'name',          'type'=>'text'],
                    ['key'=>'field_comm_role',    'label'=>'Cargo / Inst.',     'name'=>'role',          'type'=>'text'],
                    ['key'=>'field_comm_iso2',    'label'=>'País (ISO2)',        'name'=>'country_iso2',  'type'=>'text', 'instructions'=>'Ex: br, us, co (minúsculo)'],
                    ['key'=>'field_comm_clabel',  'label'=>'País (nome exibido)','name'=>'country_label','type'=>'text', 'instructions'=>'Ex: Brasil, EUA'],
                    ['key'=>'field_comm_photo',   'label'=>'Foto',              'name'=>'photo',         'type'=>'image', 'return_format'=>'array', 'preview_size'=>'thumbnail'],
                ],
            ],

            // ── Secretariado e apoio global ───────────────────────────────
            [
                'key'   => 'field_secretariat_title',
                'label' => 'Secretariado — Título',
                'name'  => 'secretariat_title',
                'type'  => 'text',
            ],
            [
                'key'   => 'field_secretariat_desc',
                'label' => 'Secretariado — Descrição',
                'name'  => 'secretariat_desc',
                'type'  => 'textarea',
                'rows'  => 3,
            ],
            [
                'key'          => 'field_secretariat_members',
                'label'        => 'Secretariado — Membros',
                'name'         => 'secretariat_members',
                'type'         => 'repeater',
                'button_label' => 'Adicionar membro',
                'sub_fields'   => [
                    ['key'=>'field_sec_name',   'label'=>'Nome',               'name'=>'name',          'type'=>'text'],
                    ['key'=>'field_sec_role',   'label'=>'Cargo / Inst.',      'name'=>'role',          'type'=>'text'],
                    ['key'=>'field_sec_iso2',   'label'=>'País (ISO2)',         'name'=>'country_iso2',  'type'=>'text', 'instructions'=>'Ex: br, us, co (minúsculo)'],
                    ['key'=>'field_sec_clabel', 'label'=>'País (nome exibido)','name'=>'country_label', 'type'=>'text', 'instructions'=>'Ex: Brasil, EUA'],
                    ['key'=>'field_sec_photo',  'label'=>'Foto',               'name'=>'photo',         'type'=>'image', 'return_format'=>'array', 'preview_size'=>'thumbnail'],
                ],
            ],

            // ── Comitê Científico (SAC) ───────────────────────────────────
            [
                'key'   => 'field_sac_title',
                'label' => 'SAC — Título',
                'name'  => 'sac_title',
                'type'  => 'text',
            ],
            [
                'key'   => 'field_sac_desc',
                'label' => 'SAC — Descrição',
                'name'  => 'sac_desc',
                'type'  => 'textarea',
                'rows'  => 3,
            ],
            [
                'key'          => 'field_sac_members',
                'label'        => 'SAC — Membros',
                'name'         => 'sac_members',
                'type'         => 'repeater',
                'button_label' => 'Adicionar membro',
                'sub_fields'   => [
                    ['key'=>'field_sac_name',   'label'=>'Nome',               'name'=>'name',          'type'=>'text'],
                    ['key'=>'field_sac_role',   'label'=>'Cargo / Inst.',      'name'=>'role',          'type'=>'text'],
                    ['key'=>'field_sac_iso2',   'label'=>'País (ISO2)',         'name'=>'country_iso2',  'type'=>'text', 'instructions'=>'Ex: br, us, co (minúsculo)'],
                    ['key'=>'field_sac_clabel', 'label'=>'País (nome exibido)','name'=>'country_label', 'type'=>'text', 'instructions'=>'Ex: Brasil, EUA'],
                    ['key'=>'field_sac_photo',  'label'=>'Foto',               'name'=>'photo',         'type'=>'image', 'return_format'=>'array', 'preview_size'=>'thumbnail'],
                ],
            ],

            // ── Apoio Tecnológico ─────────────────────────────────────────
            [
                'key'   => 'field_tech_title',
                'label' => 'Tecnologia — Título',
                'name'  => 'tech_title',
                'type'  => 'text',
            ],
            [
                'key'   => 'field_tech_desc',
                'label' => 'Tecnologia — Descrição',
                'name'  => 'tech_desc',
                'type'  => 'wysiwyg',
                'tabs'  => 'all',
                'toolbar' => 'basic',
                'media_upload' => 0,
            ],
            [
                'key'           => 'field_tech_image',
                'label'         => 'Tecnologia — Imagem',
                'name'          => 'tech_image',
                'type'          => 'image',
                'return_format' => 'array',
                'preview_size'  => 'medium',
            ],

            // ── Financiadores Globais ─────────────────────────────────────
            [
                'key'   => 'field_funders_title',
                'label' => 'Financiadores — Título',
                'name'  => 'funders_title',
                'type'  => 'text',
            ],
            [
                'key'   => 'field_funders_desc',
                'label' => 'Financiadores — Descrição',
                'name'  => 'funders_desc',
                'type'  => 'textarea',
                'rows'  => 3,
            ],
            [
                'key'          => 'field_funders_list',
                'label'        => 'Financiadores — Lista',
                'name'         => 'funders_list',
                'type'         => 'repeater',
                'button_label' => 'Adicionar financiador',
                'layout'       => 'table',
                'sub_fields'   => [
                    ['key'=>'field_funder_name', 'label'=>'Nome', 'name'=>'name', 'type'=>'text'],
                ],
            ],
        ],

        'location' => [[
            [
                'param'    => 'options_page',
                'operator' => '==',
                'value'    => 'acf-conheca-rede',
            ],
        ]],

        'menu_order'            => 0,
        'position'              => 'normal',
        'style'                 => 'default',
        'label_placement'       => 'top',
        'instruction_placement' => 'label',
        'active'                => true,
    ]);
});

// Seed inicial dos campos ACF — roda uma única vez no WP Admin
add_action('admin_init', function () {
    if (!function_exists('update_field') || !function_exists('get_field')) return;
    if (get_option('mbmap_conheca_rede_seeded')) return;

    // ── Abrangência geográfica ─────────────────────────────────────────────
    update_field('geo_title', 'Nossa abrangência geográfica', 'option');
    update_field('geo_desc',  'O MapBiomas atua no monitoramento contínuo das transformações territoriais em 17 países, abrangendo integralmente a América do Sul e a Indonésia.', 'option');
    update_field('geo_countries', [
        ['name'=>'Brasil',                         'iso2'=>'br','status'=>'active'],
        ['name'=>'Argentina',                      'iso2'=>'ar','status'=>'active'],
        ['name'=>'Bolivia',                        'iso2'=>'bo','status'=>'active'],
        ['name'=>'Chile',                          'iso2'=>'cl','status'=>'active'],
        ['name'=>'Colômbia',                       'iso2'=>'co','status'=>'active'],
        ['name'=>'Equador',                        'iso2'=>'ec','status'=>'active'],
        ['name'=>'Paraguai',                       'iso2'=>'py','status'=>'active'],
        ['name'=>'Peru',                           'iso2'=>'pe','status'=>'active'],
        ['name'=>'Venezuela',                      'iso2'=>'ve','status'=>'active'],
        ['name'=>'Uruguai',                        'iso2'=>'uy','status'=>'active'],
        ['name'=>'Guiana',                         'iso2'=>'gy','status'=>'active'],
        ['name'=>'Guiana Francesa',                'iso2'=>'gf','status'=>'active'],
        ['name'=>'Suriname',                       'iso2'=>'sr','status'=>'active'],
        ['name'=>'México',                         'iso2'=>'mx','status'=>'implementing'],
        ['name'=>'República Democrática do Congo', 'iso2'=>'cd','status'=>'implementing'],
        ['name'=>'Índia',                          'iso2'=>'in','status'=>'implementing'],
        ['name'=>'Indonésia',                      'iso2'=>'id','status'=>'active'],
    ], 'option');

    // ── Quem somos ─────────────────────────────────────────────────────────
    update_field('qs_title', 'Quem somos: A comunidade MapBiomas', 'option');
    update_field('qs_desc',  'A Rede MapBiomas é formada por mais de 700 pesquisadores, cientistas e especialistas atuando de forma colaborativa. Nossa governança é estruturada em comitês para garantir o rigor científico, a transparência e a eficiência metodológica em todos os territórios onde atuamos.', 'option');
    update_field('qs_stats', [
        ['number'=>700,'suffix'=>'+','label'=>'pessoas na rede',       'card'=>'green'],
        ['number'=>100,'suffix'=>'+','label'=>'instituições parceiras','card'=>'blue'],
        ['number'=>17, 'suffix'=>'', 'label'=>'países',               'card'=>'orange'],
        ['number'=>38, 'suffix'=>'+','label'=>'anos de dados',         'card'=>'olive'],
    ], 'option');

    // ── Comitê de coordenação ──────────────────────────────────────────────
    update_field('committee_title', 'Comitê de coordenação da rede global', 'option');
    update_field('committee_desc',  'Este comitê é responsável pelo direcionamento estratégico, pela expansão internacional e por garantir a consistência metodológica entre todas as iniciativas locais do MapBiomas.', 'option');
    update_field('committee_members', [
        ['name'=>'Tasso Azevedo',             'role'=>'Coordenador Geral',              'country_iso2'=>'br','country_label'=>'Brasil',       'photo'=>''],
        ['name'=>'Julia Shimbo',              'role'=>'Coordenação Científica',         'country_iso2'=>'br','country_label'=>'Brasil',       'photo'=>''],
        ['name'=>'Marcos Rosa',               'role'=>'Coordenação Técnica',            'country_iso2'=>'br','country_label'=>'Brasil',       'photo'=>''],
        ['name'=>'Carlos Souza Jr.',          'role'=>'Coordenação Técnico-Científica', 'country_iso2'=>'br','country_label'=>'Brasil',       'photo'=>''],
        ['name'=>'Alexandre Camargo Coutinho','role'=>'Comitê Científico — Embrapa',   'country_iso2'=>'br','country_label'=>'Brasil',       'photo'=>''],
        ['name'=>'Edson Eygi Sano',           'role'=>'Comitê Científico — IBAMA',     'country_iso2'=>'br','country_label'=>'Brasil',       'photo'=>''],
        ['name'=>'Leila M. G. Fonseca',       'role'=>'Comitê Científico — INPE',      'country_iso2'=>'br','country_label'=>'Brasil',       'photo'=>''],
        ['name'=>'Marina Hirota',             'role'=>'Comitê Científico — UFSC',      'country_iso2'=>'br','country_label'=>'Brasil',       'photo'=>''],
    ], 'option');

    // ── Secretariado ───────────────────────────────────────────────────────
    update_field('secretariat_title', 'Secretariado e apoio global', 'option');
    update_field('secretariat_desc',  'A gestão operacional, a comunicação e a articulação diária da rede global são exercidas atualmente pelo secretariado sediado no Brasil, contando com o apoio institucional da Fundación Avina.', 'option');
    update_field('secretariat_members', [
        ['name'=>'Tasso Azevedo',      'role'=>'Coordenador geral',                           'country_iso2'=>'br','country_label'=>'Brasil','photo'=>''],
        ['name'=>'Julia Shimbo',       'role'=>'Coordenadora científica',                     'country_iso2'=>'br','country_label'=>'Brasil','photo'=>''],
        ['name'=>'Marcos Rosa',        'role'=>'Coordenador técnico',                         'country_iso2'=>'br','country_label'=>'Brasil','photo'=>''],
        ['name'=>'Sérgio Oliveira',    'role'=>'Coordenador de Desenvolvimento & Tecnologia', 'country_iso2'=>'br','country_label'=>'Brasil','photo'=>''],
        ['name'=>'Mayra Milkovic',     'role'=>'Secretária-executiva da Rede Global',         'country_iso2'=>'br','country_label'=>'Brasil','photo'=>''],
        ['name'=>'Pamela Rios',        'role'=>'Diretora de programas da Fundação Avina',     'country_iso2'=>'br','country_label'=>'Brasil','photo'=>''],
        ['name'=>'Jade Menezes',       'role'=>'Suporte à Rede — Gerência e comunicação',     'country_iso2'=>'br','country_label'=>'Brasil','photo'=>''],
        ['name'=>'Mariana Guerra Lara','role'=>'Suporte à Rede — Técnico',                    'country_iso2'=>'br','country_label'=>'Brasil','photo'=>''],
    ], 'option');

    // ── SAC ────────────────────────────────────────────────────────────────
    update_field('sac_title', 'Comitê científico (SAC - Scientific Advisory Committee)', 'option');
    update_field('sac_desc',  'O Comitê Científico é um painel independente formado por especialistas globais renomados. Sua função é orientar, revisar e validar as inovações tecnológicas e metodológicas desenvolvidas pela rede MapBiomas.', 'option');
    update_field('sac_members', [
        ['name'=>'Timothy Murray Boucher',   'role'=>'The Nature Conservancy','country_iso2'=>'us','country_label'=>'EUA',           'photo'=>''],
        ['name'=>'Matthew Christian Hansen', 'role'=>'GFW',                   'country_iso2'=>'us','country_label'=>'EUA',           'photo'=>''],
        ['name'=>'Robert Gilmore Pontius JR','role'=>'Clark University',      'country_iso2'=>'us','country_label'=>'EUA',           'photo'=>''],
        ['name'=>'Aurelie Camille Shapiro',  'role'=>'FAO',                   'country_iso2'=>'fr','country_label'=>'Internacional', 'photo'=>''],
    ], 'option');

    // ── Apoio tecnológico ──────────────────────────────────────────────────
    update_field('tech_title', 'Apoio tecnológico', 'option');
    update_field('tech_desc',  'O processamento de petabytes (1 quatrilhão de bytes) de imagens de satélite em escala continental e em tempo recorde é viabilizado por meio da nossa parceria tecnológica com o Google Earth Engine.', 'option');

    // ── Financiadores ──────────────────────────────────────────────────────
    update_field('funders_title', 'Financiadores globais', 'option');
    update_field('funders_desc',  'A manutenção, gratuidade dos dados e expansão da infraestrutura do MapBiomas são viabilizadas pelo apoio essencial de nossos financiadores globais.', 'option');
    update_field('funders_note',  'Histórico de financiadores que apoiaram o Projeto MapBiomas em um ou mais anos desde 2015.', 'option');
    update_field('funders_list', array_map(fn($n) => ['name' => $n], [
        'Skoll Foundation', 'Woods & Wayside International', 'Fundo Amazônia', 'Mulago Foundation',
        'Climate and Land Use Alliance (CLUA)', 'Instituto Alana', 'Yield Giving', 'Ballmer Group',
        'Valhalla Foundation', 'Sea Grape Foundation', 'Waverley Street Foundation',
        'The Overbrook Foundation', 'The Patchwork Collective', 'Instituto Beja',
        'Centro Internacional de Agricultura Tropical (CIAT)', 'Instituto Imbuzeiro',
        'Iniciativa Internacional de Clima e Florestas da Noruega (NICFI)',
        'Instituto Clima e Sociedade (ICS)', 'Quadrature Climate Foundation (QCF)', 'Montpellier Foundation',
        'Walmart Foundation (USA)', 'Sequoia Climate Foundation', 'Good Energies Foundation',
        'Gordon & Betty Moore Foundation', 'Global Wildlife Conservation (GWC)',
        'Wellspring Philanthropic Fund', 'OAK Foundation', 'Instituto Humanize',
        'Instituto Arapyaú', 'Children\'s Investment Fund Foundation (CIFF)', 'Fundação SOS Mata Atlântica',
    ]), 'option');

    update_option('mbmap_conheca_rede_seeded', 1);
});

// ACF — Options Page + Field Groups — Home
add_action('acf/init', function () {
    if (!function_exists('acf_add_local_field_group')) return;

    if (function_exists('acf_add_options_page')) {
        acf_add_options_page([
            'page_title' => 'Home',
            'menu_title' => 'Home',
            'menu_slug'  => 'acf-home',
            'capability' => 'edit_posts',
            'redirect'   => false,
            'icon_url'   => 'dashicons-home',
            'position'   => 29,
        ]);
    }

    acf_add_local_field_group([
        'key'   => 'group_home',
        'title' => 'Home',
        'fields' => [

            // ── Hero — título e texto ─────────────────────────────────────
            ['key'=>'field_home_hero_title', 'label'=>'Hero — Título',               'name'=>'home_hero_title', 'type'=>'text'],
            ['key'=>'field_home_hero_text',  'label'=>'Hero — Texto de apresentação', 'name'=>'home_hero_text',  'type'=>'wysiwyg',
             'tabs'=>'all', 'toolbar'=>'basic', 'media_upload'=>0],

            // ── Caixas numéricas ───────────────────────────────────────────
            [
                'key'          => 'field_home_stats',
                'label'        => 'Caixas numéricas',
                'name'         => 'home_stats',
                'type'         => 'repeater',
                'button_label' => 'Adicionar caixa',
                'layout'       => 'table',
                'sub_fields'   => [
                    ['key'=>'field_home_stat_titulo',    'label'=>'Título',  'name'=>'titulo',    'type'=>'text'],
                    ['key'=>'field_home_stat_numero',    'label'=>'Número',  'name'=>'numero',    'type'=>'text'],
                    ['key'=>'field_home_stat_adicional', 'label'=>'Sufixo',  'name'=>'adicional', 'type'=>'text', 'instructions'=>'Ex: anos, países, +'],
                    ['key'=>'field_home_stat_cor',       'label'=>'Cor',     'name'=>'cor',       'type'=>'select',
                     'choices'=>['green'=>'Verde','blue'=>'Azul','orange'=>'Laranja','olive'=>'Verde-oliva']],
                ],
            ],

            // ── Seção Notícias & Eventos ───────────────────────────────────
            ['key'=>'field_home_news_title',        'label'=>'Notícias — Título da seção',       'name'=>'home_news_title',         'type'=>'text'],
            ['key'=>'field_home_news_tab_news',     'label'=>'Notícias — Label aba Notícias',    'name'=>'home_tab_news',           'type'=>'text'],
            ['key'=>'field_home_news_tab_events',   'label'=>'Notícias — Label aba Eventos',     'name'=>'home_tab_events',         'type'=>'text'],
            ['key'=>'field_home_read_more',         'label'=>'Notícias — Texto botão "Ler mais"','name'=>'home_read_more',          'type'=>'text'],
            ['key'=>'field_home_news_country_label','label'=>'Notícias — País (nome exibido)',   'name'=>'home_news_country_label', 'type'=>'text', 'instructions'=>'Ex: Brasil, Global'],
            ['key'=>'field_home_news_country_iso2', 'label'=>'Notícias — País (ISO2 bandeira)',  'name'=>'home_news_country_iso2',  'type'=>'text', 'instructions'=>'Ex: br, us, co (minúsculo)'],
            ['key'=>'field_home_posts_count',       'label'=>'Notícias — Quantidade de posts',   'name'=>'home_posts_count',        'type'=>'number', 'default_value'=>5, 'min'=>1, 'max'=>20],
            ['key'=>'field_home_empty_news',        'label'=>'Notícias — Mensagem sem notícias', 'name'=>'home_empty_news',         'type'=>'text'],
            ['key'=>'field_home_empty_events',      'label'=>'Notícias — Mensagem sem eventos',  'name'=>'home_empty_events',       'type'=>'text'],
        ],

        'location' => [[
            ['param'=>'options_page','operator'=>'==','value'=>'acf-home'],
        ]],
        'menu_order'=>0,'position'=>'normal','style'=>'default',
        'label_placement'=>'top','instruction_placement'=>'label','active'=>true,
    ]);
});

// Seed inicial — Home
add_action('admin_init', function () {
    if (!function_exists('update_field')) return;
    if (get_option('mbmap_home_seeded_v1')) return;

    update_field('home_hero_title', 'Rede MapBiomas', 'option');
    update_field('home_hero_text',  '<p>O MapBiomas Global (Network) é uma rede transnacional de organizações que adapta a metodologia brasileira de mapeamento para monitorar biomas e países em diversas regiões tropicais e subtropicais. A rede integra instituições em 17 países e promove a transparência e a infraestrutura de dados geoespaciais para o enfrentamento das mudanças climáticas em escala continental.</p>', 'option');

    update_field('home_stats', [
        ['titulo'=>'anos de dados',          'numero'=>38,  'adicional'=>'+', 'cor'=>'green'],
        ['titulo'=>'países monitorados',     'numero'=>17,  'adicional'=>'',  'cor'=>'blue'],
        ['titulo'=>'pessoas na rede',        'numero'=>700, 'adicional'=>'+', 'cor'=>'orange'],
        ['titulo'=>'instituições parceiras', 'numero'=>100, 'adicional'=>'+', 'cor'=>'olive'],
    ], 'option');

    update_field('home_news_title',         'Fique por dentro',                'option');
    update_field('home_tab_news',           'Notícias',                        'option');
    update_field('home_tab_events',         'Eventos',                         'option');
    update_field('home_read_more',          'Ler mais',                        'option');
    update_field('home_news_country_label', 'Brasil',                          'option');
    update_field('home_news_country_iso2',  'br',                              'option');
    update_field('home_posts_count',        5,                                 'option');
    update_field('home_empty_news',         'Nenhuma notícia encontrada.',     'option');
    update_field('home_empty_events',       'Nenhum evento encontrado.',       'option');

    update_option('mbmap_home_seeded_v1', 1);
});

// ACF — Options Page + Field Groups — Quem Somos
add_action('acf/init', function () {
    if (!function_exists('acf_add_local_field_group')) return;

    if (function_exists('acf_add_options_page')) {
        acf_add_options_page([
            'page_title' => 'Quem Somos',
            'menu_title' => 'Quem Somos',
            'menu_slug'  => 'acf-quem-somos',
            'capability' => 'edit_posts',
            'redirect'   => false,
            'icon_url'   => 'dashicons-groups',
            'position'   => 31,
        ]);
    }

    acf_add_local_field_group([
        'key'   => 'group_quem_somos',
        'title' => 'Quem Somos',
        'fields' => [

            // ── Banner ────────────────────────────────────────────────────
            ['key'=>'field_qs_banner_title',    'label'=>'Banner — Título',    'name'=>'qs_banner_title',    'type'=>'text'],
            ['key'=>'field_qs_banner_subtitle', 'label'=>'Banner — Subtítulo', 'name'=>'qs_banner_subtitle', 'type'=>'text'],

            // ── Introdução / Missão ───────────────────────────────────────
            ['key'=>'field_qs_intro_text',    'label'=>'Introdução — Texto principal',  'name'=>'qs_intro_text',    'type'=>'wysiwyg', 'tabs'=>'all', 'toolbar'=>'full', 'media_upload'=>0],
            ['key'=>'field_qs_mission_title', 'label'=>'Missão — Título',               'name'=>'qs_mission_title', 'type'=>'text'],
            ['key'=>'field_qs_mission_text',  'label'=>'Missão — Texto destaque',       'name'=>'qs_mission_text',  'type'=>'textarea', 'rows'=>4],
            ['key'=>'field_qs_mission_image', 'label'=>'Missão — Imagem',               'name'=>'qs_mission_image', 'type'=>'image', 'return_format'=>'array', 'preview_size'=>'medium'],

            // ── O que fazemos ─────────────────────────────────────────────
            [
                'key'          => 'field_qs_whatwedo_items',
                'label'        => 'O que fazemos — Itens',
                'name'         => 'qs_whatwedo_items',
                'type'         => 'repeater',
                'button_label' => 'Adicionar item',
                'sub_fields'   => [
                    ['key'=>'field_qs_wwd_icon',  'label'=>'Ícone',  'name'=>'icone',  'type'=>'image',    'return_format'=>'array', 'preview_size'=>'thumbnail'],
                    ['key'=>'field_qs_wwd_title', 'label'=>'Título', 'name'=>'titulo', 'type'=>'text'],
                    ['key'=>'field_qs_wwd_text',  'label'=>'Texto',  'name'=>'texto',  'type'=>'textarea', 'rows'=>3],
                ],
            ],

            // ── Linha do tempo ────────────────────────────────────────────
            [
                'key'          => 'field_timeline_carrossel',
                'label'        => 'Timeline — Carrossel',
                'name'         => 'timeline_carrossel',
                'type'         => 'repeater',
                'button_label' => 'Adicionar ano',
                'layout'       => 'table',
                'sub_fields'   => [
                    ['key'=>'field_timeline_ano', 'label'=>'Ano', 'name'=>'ano', 'type'=>'text'],
                    [
                        'key'          => 'field_timeline_linhas',
                        'label'        => 'Linhas',
                        'name'         => 'timeline_linhas',
                        'type'         => 'repeater',
                        'button_label' => 'Adicionar linha',
                        'layout'       => 'row',
                        'sub_fields'   => [
                            ['key'=>'field_timeline_linha_icon',  'label'=>'Ícone',  'name'=>'linha_icon',  'type'=>'image', 'return_format'=>'array', 'preview_size'=>'thumbnail'],
                            ['key'=>'field_timeline_linha_texto', 'label'=>'Texto', 'name'=>'linha_texto',  'type'=>'text'],
                        ],
                    ],
                ],
            ],

            // ── O que mapeamos ────────────────────────────────────────────
            ['key'=>'field_qs_mapping_title', 'label'=>'O que mapeamos — Título', 'name'=>'qs_mapping_title', 'type'=>'text'],
            ['key'=>'field_qs_mapping_text',  'label'=>'O que mapeamos — Texto',  'name'=>'qs_mapping_text',  'type'=>'textarea', 'rows'=>3],
            [
                'key'          => 'field_qs_mapping_items',
                'label'        => 'O que mapeamos — Itens',
                'name'         => 'qs_mapping_items',
                'type'         => 'repeater',
                'button_label' => 'Adicionar item',
                'sub_fields'   => [
                    ['key'=>'field_qs_map_img',   'label'=>'Imagem', 'name'=>'imagem', 'type'=>'image',    'return_format'=>'array', 'preview_size'=>'thumbnail'],
                    ['key'=>'field_qs_map_title', 'label'=>'Título', 'name'=>'titulo', 'type'=>'text'],
                    ['key'=>'field_qs_map_text',  'label'=>'Texto',  'name'=>'texto',  'type'=>'textarea', 'rows'=>3],
                ],
            ],

            // ── Características ───────────────────────────────────────────
            ['key'=>'field_qs_char_title',    'label'=>'Características — Título',    'name'=>'qs_char_title',    'type'=>'text'],
            ['key'=>'field_qs_char_subtitle', 'label'=>'Características — Subtítulo', 'name'=>'qs_char_subtitle', 'type'=>'textarea', 'rows'=>2],
            [
                'key'          => 'field_qs_char_items',
                'label'        => 'Características — Itens',
                'name'         => 'qs_char_items',
                'type'         => 'repeater',
                'button_label' => 'Adicionar característica',
                'sub_fields'   => [
                    ['key'=>'field_qs_char_icon',   'label'=>'Ícone',  'name'=>'icone',  'type'=>'image',    'return_format'=>'array', 'preview_size'=>'thumbnail'],
                    ['key'=>'field_qs_char_title2', 'label'=>'Título', 'name'=>'titulo', 'type'=>'text'],
                    ['key'=>'field_qs_char_text',   'label'=>'Texto',  'name'=>'texto',  'type'=>'textarea', 'rows'=>2],
                ],
            ],

            // ── DNA ────────────────────────────────────────────────────────
            ['key'=>'field_qs_dna_title',    'label'=>'DNA — Título',    'name'=>'qs_dna_title',    'type'=>'text'],
            ['key'=>'field_qs_dna_subtitle', 'label'=>'DNA — Subtítulo', 'name'=>'qs_dna_subtitle', 'type'=>'textarea', 'rows'=>2],
            [
                'key'          => 'field_qs_dna_items',
                'label'        => 'DNA — Itens',
                'name'         => 'qs_dna_items',
                'type'         => 'repeater',
                'button_label' => 'Adicionar item',
                'sub_fields'   => [
                    ['key'=>'field_qs_dna_icon',       'label'=>'Ícone',  'name'=>'icone',  'type'=>'image',    'return_format'=>'array', 'preview_size'=>'thumbnail'],
                    ['key'=>'field_qs_dna_item_title', 'label'=>'Título', 'name'=>'titulo', 'type'=>'text'],
                    ['key'=>'field_qs_dna_item_text',  'label'=>'Texto',  'name'=>'texto',  'type'=>'textarea', 'rows'=>2],
                ],
            ],
        ],

        'location' => [[
            ['param'=>'options_page','operator'=>'==','value'=>'acf-quem-somos'],
        ]],
        'menu_order'=>0,'position'=>'normal','style'=>'default',
        'label_placement'=>'top','instruction_placement'=>'label','active'=>true,
    ]);
});

// Seed inicial — Quem Somos
add_action('admin_init', function () {
    if (!function_exists('update_field')) return;
    if (get_option('mbmap_quem_somos_seeded_v1')) return;

    update_field('qs_banner_title',    'Quem Somos',                                        'option');
    update_field('qs_banner_subtitle', 'Conheça a missão e a estrutura do MapBiomas',       'option');
    update_field('qs_intro_text',      '<p>O MapBiomas é uma iniciativa multi-institucional que envolve universidades, ONGs, empresas de tecnologia e institutos de pesquisa, unidos pelo compromisso de mapear e monitorar as mudanças no uso e cobertura da terra em escala continental.</p>', 'option');
    update_field('qs_mission_title',   'Nossa missão',                                      'option');
    update_field('qs_mission_text',    'Gerar, disponibilizar e disseminar dados e informações de alta qualidade e resolução sobre a dinâmica de uso e cobertura da terra em escala local, nacional e internacional.', 'option');
    update_field('qs_mapping_title',   'O que mapeamos',                                    'option');
    update_field('qs_mapping_text',    'O MapBiomas cobre os principais biomas e regiões do Brasil e dos países parceiros, produzindo mapas anuais de uso e cobertura da terra com resolução de 30 metros.', 'option');
    update_field('qs_char_title',      'Nossas características',                            'option');
    update_field('qs_char_subtitle',   'Conheça os pilares que definem a forma como trabalhamos.', 'option');
    update_field('qs_dna_title',       'Nosso DNA',                                         'option');
    update_field('qs_dna_subtitle',    'Os valores e princípios que guiam cada decisão e inovação da rede MapBiomas.', 'option');

    update_option('mbmap_quem_somos_seeded_v1', 1);
});

// Seed v2 — Quem Somos (repeaters)
add_action('admin_init', function () {
    if (!function_exists('update_field')) return;
    if (get_option('mbmap_quem_somos_seeded_v2')) return;

    update_field('qs_whatwedo_items', [
        ['icone'=>null,'titulo'=>'Mapeamento anual',         'texto'=>'Produzimos mapas anuais de uso e cobertura da terra com resolução de 30 metros para biomas e países.'],
        ['icone'=>null,'titulo'=>'Dados abertos',            'texto'=>'Todos os dados são disponibilizados gratuitamente para pesquisadores, governos e sociedade civil.'],
        ['icone'=>null,'titulo'=>'Metodologia colaborativa', 'texto'=>'Desenvolvemos metodologias em colaboração com mais de 700 especialistas em 17 países.'],
    ], 'option');

    update_field('qs_mapping_items', [
        ['imagem'=>null,'titulo'=>'Uso e cobertura da terra',   'texto'=>'Mapeamento anual de 16 classes de uso e cobertura da terra desde 1985.'],
        ['imagem'=>null,'titulo'=>'Desmatamento e degradação',  'texto'=>'Monitoramento contínuo de alertas de desmatamento e degradação florestal.'],
        ['imagem'=>null,'titulo'=>'Qualidade da água',          'texto'=>'Análise de superfícies d\'água e qualidade hídrica em bacias hidrográficas.'],
    ], 'option');

    update_field('qs_char_items', [
        ['icone'=>null,'titulo'=>'Científico',    'texto'=>'Metodologias revisadas por pares e validadas por comitê científico independente.'],
        ['icone'=>null,'titulo'=>'Transparente',  'texto'=>'Código aberto, dados públicos e processos auditáveis por qualquer pessoa.'],
        ['icone'=>null,'titulo'=>'Colaborativo',  'texto'=>'Rede de instituições parceiras atuando de forma conjunta e sinérgica.'],
        ['icone'=>null,'titulo'=>'Escalável',     'texto'=>'Metodologia replicável para diferentes biomas, países e escalas territoriais.'],
    ], 'option');

    update_field('qs_dna_items', [
        ['icone'=>null,'titulo'=>'Inovação',          'texto'=>'Uso de tecnologias de ponta como Google Earth Engine para processamento em escala continental.'],
        ['icone'=>null,'titulo'=>'Rigor científico',  'texto'=>'Dados produzidos com alto padrão de qualidade e validados por especialistas.'],
        ['icone'=>null,'titulo'=>'Impacto',           'texto'=>'Informações utilizadas por governos, empresas e sociedade civil para decisões ambientais.'],
        ['icone'=>null,'titulo'=>'Gratuidade',        'texto'=>'Acesso livre e gratuito a todos os dados e ferramentas produzidos pela rede.'],
    ], 'option');

    update_option('mbmap_quem_somos_seeded_v2', 1);
});

// Seed v3 — Quem Somos (timeline)
add_action('admin_init', function () {
    if (!function_exists('update_field')) return;
    if (get_option('mbmap_quem_somos_seeded_v3')) return;

    update_field('timeline_carrossel', [
        [
            'ano' => '2015',
            'timeline_linhas' => [
                ['linha_icon' => null, 'linha_texto' => 'Fundação do MapBiomas com 8 instituições parceiras'],
                ['linha_icon' => null, 'linha_texto' => 'Início do mapeamento anual de uso e cobertura da terra no Brasil'],
            ],
        ],
        [
            'ano' => '2016',
            'timeline_linhas' => [
                ['linha_icon' => null, 'linha_texto' => 'Lançamento da Coleção 1 — primeiro mapa completo dos biomas brasileiros'],
                ['linha_icon' => null, 'linha_texto' => '30 anos de dados históricos disponibilizados gratuitamente'],
            ],
        ],
        [
            'ano' => '2017',
            'timeline_linhas' => [
                ['linha_icon' => null, 'linha_texto' => 'Lançamento da Coleção 2 com melhorias metodológicas'],
                ['linha_icon' => null, 'linha_texto' => 'Expansão para monitoramento de recursos hídricos'],
            ],
        ],
        [
            'ano' => '2018',
            'timeline_linhas' => [
                ['linha_icon' => null, 'linha_texto' => 'Lançamento do MapBiomas Alerta — sistema de alertas de desmatamento'],
                ['linha_icon' => null, 'linha_texto' => 'Coleção 3 com resolução e precisão aprimoradas'],
            ],
        ],
        [
            'ano' => '2019',
            'timeline_linhas' => [
                ['linha_icon' => null, 'linha_texto' => 'Início da expansão internacional — primeiros países parceiros'],
                ['linha_icon' => null, 'linha_texto' => 'Lançamento da Coleção 4'],
            ],
        ],
        [
            'ano' => '2020',
            'timeline_linhas' => [
                ['linha_icon' => null, 'linha_texto' => 'Lançamento da Plataforma de Água — mapeamento de superfícies hídricas'],
                ['linha_icon' => null, 'linha_texto' => 'Coleção 5 — cobertura ampliada e novas classes de mapeamento'],
            ],
        ],
        [
            'ano' => '2021',
            'timeline_linhas' => [
                ['linha_icon' => null, 'linha_texto' => 'Expansão para o Chaco e novos biomas sul-americanos'],
                ['linha_icon' => null, 'linha_texto' => 'Coleção 6 — integração com dados de degradação florestal'],
            ],
        ],
        [
            'ano' => '2022',
            'timeline_linhas' => [
                ['linha_icon' => null, 'linha_texto' => 'Lançamento do MapBiomas Global — rede ativa em múltiplos continentes'],
                ['linha_icon' => null, 'linha_texto' => 'Coleção 7 — mais de 700 pesquisadores na rede'],
            ],
        ],
        [
            'ano' => '2023',
            'timeline_linhas' => [
                ['linha_icon' => null, 'linha_texto' => 'Presença em 17 países da América do Sul, África e Ásia'],
                ['linha_icon' => null, 'linha_texto' => 'Coleção 8 — nova geração de mapas com inteligência artificial'],
            ],
        ],
        [
            'ano' => '2024',
            'timeline_linhas' => [
                ['linha_icon' => null, 'linha_texto' => '10 anos de MapBiomas — uma década de ciência a serviço do território'],
                ['linha_icon' => null, 'linha_texto' => 'Coleção 9 — expansão de classes e países monitorados'],
            ],
        ],
    ], 'option');

    update_option('mbmap_quem_somos_seeded_v3', 1);
});

// Migração: corrige chaves duplicadas do repeater qs_dna_items
add_action('admin_init', function () {
    if (get_option('mbmap_dna_keys_fixed_v1')) return;
    global $wpdb;
    $count = (int) get_option('options_qs_dna_items', 0);
    for ($i = 0; $i < max($count, 20); $i++) {
        $opt_titulo = '_options_qs_dna_items_' . $i . '_titulo';
        $opt_texto  = '_options_qs_dna_items_' . $i . '_texto';
        if (get_option($opt_titulo) === 'field_qs_dna_title') {
            update_option($opt_titulo, 'field_qs_dna_item_title');
        }
        if (get_option($opt_texto) === 'field_qs_dna_text') {
            update_option($opt_texto, 'field_qs_dna_item_text');
        }
    }
    update_option('mbmap_dna_keys_fixed_v1', 1);
});

// ACF — Options Page + Field Groups — FAQ
add_action('acf/init', function () {
    if (!function_exists('acf_add_local_field_group')) return;

    if (function_exists('acf_add_options_page')) {
        acf_add_options_page([
            'page_title' => 'Perguntas Frequentes',
            'menu_title' => 'FAQ',
            'menu_slug'  => 'acf-faq',
            'capability' => 'edit_posts',
            'redirect'   => false,
            'icon_url'   => 'dashicons-editor-help',
            'position'   => 32,
        ]);
    }

    acf_add_local_field_group([
        'key'   => 'group_faq',
        'title' => 'Perguntas Frequentes',
        'fields' => [

            // ── Banner ────────────────────────────────────────────────────
            ['key'=>'field_faq_banner_title', 'label'=>'Banner — Título', 'name'=>'faq_banner_title', 'type'=>'text'],

            // ── Perguntas e Respostas ─────────────────────────────────────
            [
                'key'          => 'field_faq_items',
                'label'        => 'Perguntas e Respostas',
                'name'         => 'faq_items',
                'type'         => 'repeater',
                'button_label' => 'Adicionar pergunta',
                'sub_fields'   => [
                    ['key'=>'field_faq_pergunta', 'label'=>'Pergunta', 'name'=>'pergunta', 'type'=>'text'],
                    ['key'=>'field_faq_resposta', 'label'=>'Resposta', 'name'=>'resposta', 'type'=>'wysiwyg',
                     'tabs'=>'all', 'toolbar'=>'basic', 'media_upload'=>0],
                ],
            ],

            // ── Formulário de contato ─────────────────────────────────────
            ['key'=>'field_faq_form_title',      'label'=>'Formulário — Título',         'name'=>'faq_form_title',       'type'=>'text'],
            ['key'=>'field_faq_form_subtitle',   'label'=>'Formulário — Subtítulo',      'name'=>'faq_form_subtitle',    'type'=>'text'],
            ['key'=>'field_faq_form_placeholder','label'=>'Formulário — Placeholder',    'name'=>'faq_form_placeholder', 'type'=>'text'],
            ['key'=>'field_faq_form_button',     'label'=>'Formulário — Texto do botão', 'name'=>'faq_form_button',      'type'=>'text'],
        ],

        'location' => [[
            ['param'=>'options_page','operator'=>'==','value'=>'acf-faq'],
        ]],
        'menu_order'=>0,'position'=>'normal','style'=>'default',
        'label_placement'=>'top','instruction_placement'=>'label','active'=>true,
    ]);
});

// Seed inicial — FAQ
add_action('admin_init', function () {
    if (!function_exists('update_field')) return;
    if (get_option('mbmap_faq_seeded_v1')) return;

    update_field('faq_banner_title',     'Perguntas frequentes',                    'option');
    update_field('faq_form_title',       'Não encontrou sua resposta?',             'option');
    update_field('faq_form_subtitle',    'Entre em contato com a equipe MapBiomas', 'option');
    update_field('faq_form_placeholder', 'Descreva sua dúvida...',                  'option');
    update_field('faq_form_button',      'Enviar pergunta',                         'option');

    update_field('faq_items', [
        ['pergunta'=>'O que é o MapBiomas?',
         'resposta'=>'<p>O MapBiomas é uma iniciativa multi-institucional que produz mapas anuais de uso e cobertura da terra para o Brasil e países parceiros, com resolução de 30 metros, utilizando imagens de satélite e algoritmos de machine learning.</p>'],
        ['pergunta'=>'Os dados do MapBiomas são gratuitos?',
         'resposta'=>'<p>Sim, todos os dados produzidos pelo MapBiomas são disponibilizados gratuitamente para download e uso pela comunidade científica, governos e sociedade civil.</p>'],
        ['pergunta'=>'Com que frequência os mapas são atualizados?',
         'resposta'=>'<p>Os mapas de cobertura e uso da terra são atualizados anualmente. Além disso, o MapBiomas oferece alertas de desmatamento com frequência quinzenal ou mensal, dependendo do bioma.</p>'],
        ['pergunta'=>'Quais países fazem parte da rede MapBiomas?',
         'resposta'=>'<p>A rede MapBiomas atua em 17 países, incluindo todos os países da América do Sul e a Indonésia, com iniciativas em diferentes estágios de implantação.</p>'],
        ['pergunta'=>'Como posso contribuir com o MapBiomas?',
         'resposta'=>'<p>Você pode contribuir participando de capacitações, utilizando e divulgando os dados, ou entrando em contato com nossa equipe para explorar possibilidades de parceria institucional.</p>'],
    ], 'option');

    update_option('mbmap_faq_seeded_v1', 1);
});

// ACF — Options Page + Field Groups — Glossário
add_action('acf/init', function () {
    if (!function_exists('acf_add_local_field_group')) return;

    if (function_exists('acf_add_options_page')) {
        acf_add_options_page([
            'page_title' => 'Glossário',
            'menu_title' => 'Glossário',
            'menu_slug'  => 'acf-glossario',
            'capability' => 'edit_posts',
            'redirect'   => false,
            'icon_url'   => 'dashicons-book',
            'position'   => 33,
        ]);
    }

    acf_add_local_field_group([
        'key'   => 'group_glossario',
        'title' => 'Glossário',
        'fields' => [

            // ── Banner ────────────────────────────────────────────────────
            ['key'=>'field_glos_banner_title',       'label'=>'Banner — Título',              'name'=>'glos_banner_title',       'type'=>'text'],
            ['key'=>'field_glos_search_placeholder', 'label'=>'Campo de busca — Placeholder', 'name'=>'glos_search_placeholder', 'type'=>'text'],
            ['key'=>'field_glos_empty_msg',          'label'=>'Mensagem sem resultados',      'name'=>'glos_empty_msg',          'type'=>'text'],

            // ── Termos ────────────────────────────────────────────────────
            [
                'key'          => 'field_glos_items',
                'label'        => 'Termos do Glossário',
                'name'         => 'glos_items',
                'type'         => 'repeater',
                'button_label' => 'Adicionar termo',
                'sub_fields'   => [
                    ['key'=>'field_glos_termo',    'label'=>'Termo',      'name'=>'termo',    'type'=>'text'],
                    ['key'=>'field_glos_tipo',     'label'=>'Tipo/Badge', 'name'=>'tipo',     'type'=>'text',
                     'instructions'=>'Ex: Conceito, Metodologia, Sigla — aparece como etiqueta colorida'],
                    ['key'=>'field_glos_descricao','label'=>'Descrição',  'name'=>'descricao','type'=>'wysiwyg',
                     'tabs'=>'all', 'toolbar'=>'basic', 'media_upload'=>0],
                ],
            ],
        ],

        'location' => [[
            ['param'=>'options_page','operator'=>'==','value'=>'acf-glossario'],
        ]],
        'menu_order'=>0,'position'=>'normal','style'=>'default',
        'label_placement'=>'top','instruction_placement'=>'label','active'=>true,
    ]);
});

// Seed inicial — Glossário
add_action('admin_init', function () {
    if (!function_exists('update_field')) return;
    if (get_option('mbmap_glossario_seeded_v1')) return;

    update_field('glos_banner_title',       'Glossário MapBiomas',          'option');
    update_field('glos_search_placeholder', 'Procurar palavra',             'option');
    update_field('glos_empty_msg',          'Nenhum resultado encontrado.', 'option');

    update_field('glos_items', [
        ['termo'=>'Bioma',                'tipo'=>'Conceito',    'descricao'=>'<p>Grande região geográfica com características climáticas, de vegetação e fauna semelhantes. O Brasil possui seis biomas: Amazônia, Cerrado, Mata Atlântica, Caatinga, Pampa e Pantanal.</p>'],
        ['termo'=>'Cobertura da terra',   'tipo'=>'Conceito',    'descricao'=>'<p>Descrição física da superfície terrestre observada, incluindo vegetação natural, culturas agrícolas, corpos d\'água e áreas urbanas.</p>'],
        ['termo'=>'Desmatamento',         'tipo'=>'Conceito',    'descricao'=>'<p>Remoção da cobertura vegetal nativa de uma área, podendo ser total ou parcial, causada por atividade humana.</p>'],
        ['termo'=>'Google Earth Engine',  'tipo'=>'Tecnologia',  'descricao'=>'<p>Plataforma de computação em nuvem do Google utilizada para processamento de imagens de satélite em larga escala, adotada pelo MapBiomas para processar petabytes de dados.</p>'],
        ['termo'=>'LULC',                 'tipo'=>'Sigla',       'descricao'=>'<p>Land Use and Land Cover — Uso e Cobertura da Terra. Classificação que descreve tanto o tipo de cobertura física do solo quanto o modo como ele é utilizado pelos seres humanos.</p>'],
        ['termo'=>'Mapeamento',           'tipo'=>'Metodologia', 'descricao'=>'<p>Processo de identificação, classificação e representação espacial de feições do território, realizado por meio de algoritmos de machine learning aplicados a imagens de satélite.</p>'],
        ['termo'=>'Sensoriamento Remoto', 'tipo'=>'Metodologia', 'descricao'=>'<p>Conjunto de técnicas para obter informações sobre a superfície terrestre a partir de satélites ou plataformas aéreas, sem contato direto com o objeto de estudo.</p>'],
        ['termo'=>'Uso da terra',         'tipo'=>'Conceito',    'descricao'=>'<p>Forma como os seres humanos utilizam a superfície terrestre, como agropecuária, urbanização, mineração, entre outras atividades.</p>'],
    ], 'option');

    update_option('mbmap_glossario_seeded_v1', 1);
});

// ACF — Options Page + Field Groups — Notícias
add_action('acf/init', function () {
    if (!function_exists('acf_add_local_field_group')) return;

    if (function_exists('acf_add_options_page')) {
        acf_add_options_page([
            'page_title' => 'Notícias',
            'menu_title' => 'Notícias',
            'menu_slug'  => 'acf-noticias',
            'capability' => 'edit_posts',
            'redirect'   => false,
            'icon_url'   => 'dashicons-megaphone',
            'position'   => 34,
        ]);
    }

    acf_add_local_field_group([
        'key'    => 'group_noticias',
        'title'  => 'Notícias',
        'fields' => [
            // ── Banner ────────────────────────────────────────────────────
            ['key'=>'field_news_banner_title',   'label'=>'Banner — Título',            'name'=>'news_banner_title',   'type'=>'text'],

            // ── Filtros ───────────────────────────────────────────────────
            ['key'=>'field_news_filter_label',   'label'=>'Filtro — Label "Filtrar por"','name'=>'news_filter_label',  'type'=>'text'],
            ['key'=>'field_news_filter_all',     'label'=>'Filtro — Botão "Todas"',      'name'=>'news_filter_all',    'type'=>'text'],
            ['key'=>'field_news_filter_country', 'label'=>'Filtro — Placeholder País',   'name'=>'news_filter_country','type'=>'text'],
            ['key'=>'field_news_filter_theme',   'label'=>'Filtro — Placeholder Tema',   'name'=>'news_filter_theme',  'type'=>'text'],

            // ── Eventos ───────────────────────────────────────────────────
            ['key'=>'field_news_events_title',   'label'=>'Eventos — Título da seção',   'name'=>'news_events_title',  'type'=>'text'],
        ],

        'location' => [[
            ['param'=>'options_page','operator'=>'==','value'=>'acf-noticias'],
        ]],
        'menu_order'=>0,'position'=>'normal','style'=>'default',
        'label_placement'=>'top','instruction_placement'=>'label','active'=>true,
    ]);
});

// Seed inicial — Notícias
add_action('admin_init', function () {
    if (!function_exists('update_field')) return;
    if (get_option('mbmap_noticias_seeded_v1')) return;

    update_field('news_banner_title',   'Notícias',        'option');
    update_field('news_filter_label',   'Filtrar por:',    'option');
    update_field('news_filter_all',     'Todas',           'option');
    update_field('news_filter_country', 'País',            'option');
    update_field('news_filter_theme',   'Tema',            'option');
    update_field('news_events_title',   'Próximos Eventos','option');

    update_option('mbmap_noticias_seeded_v1', 1);
});