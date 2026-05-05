<?php
/**
 * Conheça Rede Template
 *
 * Template Name: Conheça Rede
 *
 * @package Theme
 */

$has_acf = function_exists( 'get_field' );

$geo_title = ( $has_acf ? get_field( 'geo_title', 'option' ) : '' ) ?: 'Nossa abrangência geográfica';
$geo_desc  = ( $has_acf ? get_field( 'geo_desc',  'option' ) : '' ) ?: 'O MapBiomas atua no monitoramento contínuo das transformações territoriais em 17 países, abrangendo integralmente a América do Sul e a Indonésia.';

$default_countries = [
    [ 'name' => 'Brasil',                         'iso2' => 'br', 'status' => 'active' ],
    [ 'name' => 'Argentina',                      'iso2' => 'ar', 'status' => 'active' ],
    [ 'name' => 'Bolivia',                        'iso2' => 'bo', 'status' => 'active' ],
    [ 'name' => 'Chile',                          'iso2' => 'cl', 'status' => 'active' ],
    [ 'name' => 'Colômbia',                       'iso2' => 'co', 'status' => 'active' ],
    [ 'name' => 'Equador',                        'iso2' => 'ec', 'status' => 'active' ],
    [ 'name' => 'Paraguai',                       'iso2' => 'py', 'status' => 'active' ],
    [ 'name' => 'Peru',                           'iso2' => 'pe', 'status' => 'active' ],
    [ 'name' => 'Venezuela',                      'iso2' => 've', 'status' => 'active' ],
    [ 'name' => 'Uruguai',                        'iso2' => 'uy', 'status' => 'active' ],
    [ 'name' => 'Guiana',                         'iso2' => 'gy', 'status' => 'active' ],
    [ 'name' => 'Guiana Francesa',                'iso2' => 'gf', 'status' => 'active' ],
    [ 'name' => 'Suriname',                       'iso2' => 'sr', 'status' => 'active' ],
    [ 'name' => 'México',                         'iso2' => 'mx', 'status' => 'implementing' ],
    [ 'name' => 'República Democrática do Congo', 'iso2' => 'cd', 'status' => 'implementing' ],
    [ 'name' => 'Índia',                          'iso2' => 'in', 'status' => 'implementing' ],
    [ 'name' => 'Indonésia',                      'iso2' => 'id', 'status' => 'active' ],
];
$cov_countries = ( $has_acf ? get_field( 'geo_countries', 'option' ) : [] ) ?: $default_countries;

$cov_iso_map = [
    '032' => 'ar', '068' => 'bo', '076' => 'br', '152' => 'cl',
    '170' => 'co', '218' => 'ec', '254' => 'gf', '328' => 'gy',
    '356' => 'in', '360' => 'id', '484' => 'mx', '600' => 'py',
    '604' => 'pe', '740' => 'sr', '858' => 'uy', '862' => 've',
    '180' => 'cd',
];

$cov_cfg_json = wp_json_encode( [
    'countries'    => $cov_countries,
    'isoMap'       => $cov_iso_map,
    'colorActive'  => '#4CAF7B',
    'colorImpl'    => '#F4874B',
    'colorNeutral' => '#f8f8f8',
] );

$qs_title = ( $has_acf ? get_field( 'qs_title', 'option' ) : '' ) ?: 'Quem somos: A comunidade MapBiomas';
$qs_desc  = ( $has_acf ? get_field( 'qs_desc',  'option' ) : '' ) ?: 'A Rede MapBiomas é formada por mais de 700 pesquisadores, cientistas e especialistas atuando de forma colaborativa. Nossa governança é estruturada em comitês para garantir o rigor científico, a transparência e a eficiência metodológica em todos os territórios onde atuamos.';

$default_qs_stats = [
    [ 'number' => 700, 'suffix' => '+', 'label' => 'pessoas na rede',        'card' => 'green'  ],
    [ 'number' => 100, 'suffix' => '+', 'label' => 'instituições parceiras', 'card' => 'blue'   ],
    [ 'number' => 17,  'suffix' => '',  'label' => 'países',                 'card' => 'orange' ],
    [ 'number' => 38,  'suffix' => '+', 'label' => 'anos de dados',          'card' => 'olive'  ],
];
$qs_stats_raw = ( $has_acf ? get_field( 'qs_stats', 'option' ) : [] ) ?: $default_qs_stats;
$qs_stats = $qs_stats_raw;

add_action( 'wp_head', function () { ?>

<?php }, 99 );

add_action( 'wp_footer', function () use ( $cov_cfg_json ) { ?>
<script>
(function () {
    var cfg = <?php echo $cov_cfg_json; ?>;

    function initCoverageMap() {
        var el = document.getElementById('mbmap-coverage-map');
        if (!el || !window.L || !window.topojson) return;

        var map = L.map('mbmap-coverage-map', {
            center: [5, -10],
            zoom: 2,
            minZoom: 1,
            maxZoom: 4,
            zoomControl: false,
            scrollWheelZoom: false,
            dragging: false,
            doubleClickZoom: false,
            boxZoom: false,
            keyboard: false,
            touchZoom: false,
            attributionControl: false
        });

        var statusMap = {};
        cfg.countries.forEach(function (c) {
            statusMap[c.iso2.toUpperCase()] = c.status;
        });

        fetch('https://cdn.jsdelivr.net/npm/world-atlas@2/countries-110m.json')
            .then(function (r) { return r.json(); })
            .then(function (world) {
                var gj = topojson.feature(world, world.objects.countries);
                L.geoJSON(gj, {
                    style: function (f) {
                        var id   = String(f.id).padStart(3, '0');
                        var iso  = (cfg.isoMap[id] || '').toUpperCase();
                        var st   = statusMap[iso];
                        var fill = st === 'active'       ? cfg.colorActive :
                                   st === 'implementing' ? cfg.colorImpl   :
                                   cfg.colorNeutral;
                        var isNeutral = !st;
                        return {
                            fillColor: fill,
                            fillOpacity: 1,
                            color: isNeutral ? '#c8d8e4' : '#ffffff',
                            weight: isNeutral ? 0.5 : 0.9
                        };
                    }
                }).addTo(map);
            });
    }

    function loadScript(src, cb) {
        var s = document.createElement('script');
        s.src = src; s.onload = cb;
        document.head.appendChild(s);
    }

    function ensureLibs(cb) {
        if (window.L && window.topojson) { cb(); return; }
        if (!window.L) {
            loadScript('https://unpkg.com/leaflet@1.9.4/dist/leaflet.js', function () {
                if (!window.topojson) {
                    loadScript('https://cdn.jsdelivr.net/npm/topojson-client@3/dist/topojson-client.min.js', cb);
                } else { cb(); }
            });
        } else {
            loadScript('https://cdn.jsdelivr.net/npm/topojson-client@3/dist/topojson-client.min.js', cb);
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function () { ensureLibs(initCoverageMap); });
    } else {
        ensureLibs(initCoverageMap);
    }
})();
</script>
<?php }, 200 );

add_action( 'wp_footer', function () { ?>
<script>
(function () {
    function animateCounter(el) {
        var target   = parseInt(el.getAttribute('data-target'), 10);
        var suffix   = el.getAttribute('data-suffix') || '';
        var duration = 1800;
        var start    = null;
        function step(ts) {
            if (!start) start = ts;
            var p      = Math.min((ts - start) / duration, 1);
            var eased  = 1 - Math.pow(1 - p, 3);
            el.textContent = Math.floor(eased * target) + suffix;
            if (p < 1) { requestAnimationFrame(step); }
            else        { el.textContent = target + suffix; }
        }
        requestAnimationFrame(step);
    }

    var counters = document.querySelectorAll('.qs-number[data-target]');
    if (!counters.length) return;

    if ('IntersectionObserver' in window) {
        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (e) {
                if (e.isIntersecting) { animateCounter(e.target); io.unobserve(e.target); }
            });
        }, { threshold: 0.4 });
        counters.forEach(function (el) { io.observe(el); });
    } else {
        counters.forEach(animateCounter);
    }
})();
</script>
<?php }, 201 );

get_header();

echo new ConhecaRede();
?>

<section class="breadcrumb__title bg-color-green">
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
                <?php
                    $page_title    = ( $has_acf ? get_field( 'page_title',    'option' ) : '' ) ?: 'Conheça a Rede';
                    $page_subtitle = ( $has_acf ? get_field( 'page_subtitle', 'option' ) : '' ) ?: 'A rede global de monitoramento do uso da terra';
                ?>
                <h1 class="title"><?php echo esc_html( $page_title ); ?></h1>
                <h2><?php echo esc_html( $page_subtitle ); ?></h2>
            </div>
        </div>
    </div>
</section>

<section class="geographic__content">
    <div class="container">
        <div class="row  justify-content-center">
            <div class="col-xl-9">
                <div class="mbmap-cov-wrap" data-aos="fade-up">
                    <div class="container">
                        <h2 class="mbmap-cov-title"><?php echo esc_html( $geo_title ); ?></h2>
                        <p class="mbmap-cov-desc"><?php echo esc_html( $geo_desc ); ?></p>
                        <div class="mbmap-cov-countries">
                            <?php foreach ( $cov_countries as $c ) :
                                $pill = $c['status'] === 'implementing' ? ' implementing' : ' active';
                            ?>
                            <div class="mbmap-cov-country<?php echo $pill; ?>">
                                <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/flags/' . strtolower($c['iso2']) . '.svg' ); ?>"
                                    width="20" height="20"
                                    alt="<?php echo esc_attr( $c['name'] ); ?>"
                                    loading="lazy">
                                <span><?php echo esc_html( $c['name'] ); ?></span>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="geographic-map" data-aos="fade-up">
    <div class="mbmap-cov-map-wrap">
        <div id="mbmap-coverage-map"></div>
        <div class="mbmap-cov-legend">
            <span class="mbmap-cov-legend-item">
                <span class="mbmap-cov-dot" style="background:#4CAF7B;"></span>
                Rede MapBiomas ativa
            </span>
            <span class="mbmap-cov-legend-item">
                <span class="mbmap-cov-dot" style="background:#F4874B;"></span>
                Em implantação
            </span>
        </div>
    </div>
</section>

<section class="qs">
    <div class="container">
        <div class="row  justify-content-center">
            <div class="col-xl-9">
                <div class="qs-inner">

                    <div class="qs-left">
                        <h2 class="qs-title"><?php echo esc_html( $qs_title ); ?></h2>
                        <p class="qs-desc"><?php echo esc_html( $qs_desc ); ?></p>
                    </div>

                    <div class="qs-right">
                        <div class="qs-grid">

                            <?php foreach ( $qs_stats as $stat ) : ?>
                            <?php $card_class = isset( $stat['card'] ) ? 'qs-card--' . esc_attr( $stat['card'] ) : ''; ?>
                            <div class="qs-card <?php echo $card_class; ?>">
                                <?php
                                $icon_url = is_array( $stat['icon'] ) ? ( $stat['icon']['url'] ?? '' ) : '';
                                if ( $icon_url ) :
                                ?>
                                <div class="qs-icon">
                                    <img src="<?php echo esc_url( $icon_url ); ?>" alt="<?php echo esc_attr( $stat['label'] ); ?>">
                                </div>
                                <?php endif; ?>
                                <div class="qs-number"
                                    data-target="<?php echo intval( $stat['number'] ); ?>"
                                    data-suffix="<?php echo esc_attr( $stat['suffix'] ); ?>">
                                    0<?php echo esc_html( $stat['suffix'] ); ?>
                                </div>
                                <div class="qs-label"><?php echo esc_html( $stat['label'] ); ?></div>
                            </div>
                            <?php endforeach; ?>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

<?php
$default_members = [
    [ 'name' => 'Tasso Azevedo',      'role' => 'Coordenador Geral',              'country_iso2' => 'br', 'country_label' => 'Brasil',
      'photo' => 'https://ui-avatars.com/api/?name=Tasso+Azevedo&background=4CAF7B&color=fff&size=200&rounded=true' ],
    [ 'name' => 'Julia Shimbo',       'role' => 'Coordenação Científica',         'country_iso2' => 'br', 'country_label' => 'Brasil',
      'photo' => 'https://ui-avatars.com/api/?name=Julia+Shimbo&background=4A90D9&color=fff&size=200&rounded=true' ],
    [ 'name' => 'Marcos Rosa',        'role' => 'Coordenação Técnica',            'country_iso2' => 'br', 'country_label' => 'Brasil',
      'photo' => 'https://ui-avatars.com/api/?name=Marcos+Rosa&background=F4874B&color=fff&size=200&rounded=true' ],
    [ 'name' => 'Carlos Souza Jr.',   'role' => 'Coordenação Técnico-Científica', 'country_iso2' => 'br', 'country_label' => 'Brasil',
      'photo' => 'https://ui-avatars.com/api/?name=Carlos+Souza&background=8fb020&color=fff&size=200&rounded=true' ],
    [ 'name' => 'Alexandre Camargo Coutinho', 'role' => 'Comitê Científico — Embrapa', 'country_iso2' => 'br', 'country_label' => 'Brasil',
      'photo' => 'https://ui-avatars.com/api/?name=Alexandre+Coutinho&background=4CAF7B&color=fff&size=200&rounded=true' ],
    [ 'name' => 'Edson Eygi Sano',    'role' => 'Comitê Científico — IBAMA',      'country_iso2' => 'br', 'country_label' => 'Brasil',
      'photo' => 'https://ui-avatars.com/api/?name=Edson+Sano&background=4A90D9&color=fff&size=200&rounded=true' ],
    [ 'name' => 'Leila M. G. Fonseca','role' => 'Comitê Científico — INPE',       'country_iso2' => 'br', 'country_label' => 'Brasil',
      'photo' => 'https://ui-avatars.com/api/?name=Leila+Fonseca&background=F4874B&color=fff&size=200&rounded=true' ],
    [ 'name' => 'Marina Hirota',      'role' => 'Comitê Científico — UFSC',       'country_iso2' => 'br', 'country_label' => 'Brasil',
      'photo' => 'https://ui-avatars.com/api/?name=Marina+Hirota&background=8fb020&color=fff&size=200&rounded=true' ],
];

$comm_title   = ( $has_acf ? get_field( 'committee_title',   'option' ) : '' ) ?: 'Comitê de coordenação da rede global';
$comm_desc    = ( $has_acf ? get_field( 'committee_desc',    'option' ) : '' ) ?: 'Este comitê é responsável pelo direcionamento estratégico, pela expansão internacional e por garantir a consistência metodológica entre todas as iniciativas locais do MapBiomas.';
$comm_members = ( $has_acf ? get_field( 'committee_members', 'option' ) : [] ) ?: $default_members;
$sec_title    = ( $has_acf ? get_field( 'secretariat_title', 'option' ) : '' ) ?: 'Secretariado e apoio global';
$sec_desc     = ( $has_acf ? get_field( 'secretariat_desc',  'option' ) : '' ) ?: 'A gestão operacional, a comunicação e a articulação diária da rede global são exercidas atualmente pelo secretariado sediado no Brasil, contando com o apoio institucional da Fundación Avina.';

$default_sec_members = [
    [ 'name' => 'Tasso Azevedo',       'role' => 'Coordenador geral',                           'country_iso2' => 'br', 'country_label' => 'Brasil',
      'photo' => 'https://ui-avatars.com/api/?name=Tasso+Azevedo&background=4CAF7B&color=fff&size=200&rounded=true' ],
    [ 'name' => 'Julia Shimbo',        'role' => 'Coordenadora científica',                     'country_iso2' => 'br', 'country_label' => 'Brasil',
      'photo' => 'https://ui-avatars.com/api/?name=Julia+Shimbo&background=4A90D9&color=fff&size=200&rounded=true' ],
    [ 'name' => 'Marcos Rosa',         'role' => 'Coordenador técnico',                         'country_iso2' => 'br', 'country_label' => 'Brasil',
      'photo' => 'https://ui-avatars.com/api/?name=Marcos+Rosa&background=F4874B&color=fff&size=200&rounded=true' ],
    [ 'name' => 'Sérgio Oliveira',     'role' => 'Coordenador de Desenvolvimento & Tecnologia', 'country_iso2' => 'br', 'country_label' => 'Brasil',
      'photo' => 'https://ui-avatars.com/api/?name=Sergio+Oliveira&background=8fb020&color=fff&size=200&rounded=true' ],
    [ 'name' => 'Mayra Milkovic',      'role' => 'Secretária-executiva da Rede Global',         'country_iso2' => 'br', 'country_label' => 'Brasil',
      'photo' => 'https://ui-avatars.com/api/?name=Mayra+Milkovic&background=4CAF7B&color=fff&size=200&rounded=true' ],
    [ 'name' => 'Pamela Rios',         'role' => 'Diretora de programas da Fundação Avina',     'country_iso2' => 'br', 'country_label' => 'Brasil',
      'photo' => 'https://ui-avatars.com/api/?name=Pamela+Rios&background=4A90D9&color=fff&size=200&rounded=true' ],
    [ 'name' => 'Jade Menezes',        'role' => 'Suporte à Rede — Gerência e comunicação',     'country_iso2' => 'br', 'country_label' => 'Brasil',
      'photo' => 'https://ui-avatars.com/api/?name=Jade+Menezes&background=F4874B&color=fff&size=200&rounded=true' ],
    [ 'name' => 'Mariana Guerra Lara', 'role' => 'Suporte à Rede — Técnico',                    'country_iso2' => 'br', 'country_label' => 'Brasil',
      'photo' => 'https://ui-avatars.com/api/?name=Mariana+Guerra&background=8fb020&color=fff&size=200&rounded=true' ],
];
$sec_members = ( $has_acf ? get_field( 'secretariat_members', 'option' ) : [] ) ?: $default_sec_members;

$default_sac_members = [
    [ 'name' => 'Timothy Murray Boucher',    'role' => 'The Nature Conservancy', 'country_iso2' => 'us', 'country_label' => 'EUA',
      'photo' => 'https://ui-avatars.com/api/?name=Timothy+Boucher&background=4CAF7B&color=fff&size=200&rounded=true' ],
    [ 'name' => 'Matthew Christian Hansen',  'role' => 'GFW',                    'country_iso2' => 'us', 'country_label' => 'EUA',
      'photo' => 'https://ui-avatars.com/api/?name=Matthew+Hansen&background=4A90D9&color=fff&size=200&rounded=true' ],
    [ 'name' => 'Robert Gilmore Pontius JR', 'role' => 'Clark University',        'country_iso2' => 'us', 'country_label' => 'EUA',
      'photo' => 'https://ui-avatars.com/api/?name=Robert+Pontius&background=F4874B&color=fff&size=200&rounded=true' ],
    [ 'name' => 'Aurelie Camille Shapiro',   'role' => 'FAO',                     'country_iso2' => 'fr', 'country_label' => 'Internacional',
      'photo' => 'https://ui-avatars.com/api/?name=Aurelie+Shapiro&background=8fb020&color=fff&size=200&rounded=true' ],
];
$sac_title   = ( $has_acf ? get_field( 'sac_title',   'option' ) : '' ) ?: 'Comitê científico (SAC - Scientific Advisory Committee)';
$sac_desc    = ( $has_acf ? get_field( 'sac_desc',    'option' ) : '' ) ?: 'O Comitê Científico é um painel independente formado por especialistas globais renomados. Sua função é orientar, revisar e validar as inovações tecnológicas e metodológicas desenvolvidas pela rede MapBiomas.';
$sac_members = ( $has_acf ? get_field( 'sac_members', 'option' ) : [] ) ?: $default_sac_members;

$tech_title = ( $has_acf ? get_field( 'tech_title', 'option' ) : '' ) ?: 'Apoio tecnológico';
$tech_desc  = ( $has_acf ? get_field( 'tech_desc',  'option' ) : '' ) ?: 'O processamento de petabytes (1 quatrilhão de bytes) de imagens de satélite em escala continental e em tempo recorde é viabilizado por meio da nossa parceria tecnológica com o Google Earth Engine.';
$tech_image_raw = $has_acf ? get_field( 'tech_image', 'option' ) : '';
$tech_image = is_array( $tech_image_raw ) ? ( $tech_image_raw['url'] ?? '' ) : ( $tech_image_raw ?: '' );

$funders_title = ( $has_acf ? get_field( 'funders_title', 'option' ) : '' ) ?: 'Financiadores globais';
$funders_desc  = ( $has_acf ? get_field( 'funders_desc',  'option' ) : '' ) ?: 'A manutenção, gratuidade dos dados e expansão da infraestrutura do MapBiomas são viabilizadas pelo apoio essencial de nossos financiadores globais. Para conhecer os apoiadores específicos que viabilizam o monitoramento em cada país, acesse as plataformas locais de cada iniciativa.';
$funders_note  = ( $has_acf ? get_field( 'funders_note',  'option' ) : '' ) ?: 'Histórico de financiadores que apoiaram o Projeto MapBiomas em um ou mais anos desde 2015.';
$funders_raw   = $has_acf ? get_field( 'funders_list', 'option' ) : [];
$funders = $funders_raw ?: [
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
];
?>

<section class="comm" data-aos="fade-up">
    <div class="container">
        <div class="row  justify-content-center">
            <div class="col-xl-9">
                <h2 class="comm-heading-title"><?php echo esc_html( $comm_title ); ?></h2>
                <p class="comm-heading-desc"><?php echo esc_html( $comm_desc ); ?></p>

                <?php if ( $comm_members ) : ?>
                <div class="comm-grid">
                    <?php foreach ( $comm_members as $m ) :
                        $photo = is_array( $m['photo'] ) ? ( $m['photo']['url'] ?? '' ) : ( $m['photo'] ?? '' );
                        $iso2  = strtolower( trim( $m['country_iso2'] ?? '' ) );
                        $label = trim( $m['country_label'] ?? ( strtoupper( $iso2 ) ) );
                    ?>
                    <div class="comm-member">
                        <div class="comm-photo-wrap">
                            <?php if ( $photo ) : ?>
                            <img class="comm-photo"
                                src="<?php echo esc_url( $photo ); ?>"
                                alt="<?php echo esc_attr( $m['name'] ); ?>"
                                loading="lazy">
                            <?php endif; ?>
                        </div>
                        <?php if ( $iso2 ) : ?>
                        <div class="comm-badge">
                            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/flags/' . esc_attr( $iso2 ) . '.svg' ); ?>"
                                width="16" height="16" alt="">
                            <span><?php echo esc_html( $label ); ?></span>
                        </div>
                        <?php endif; ?>
                        <div class="comm-name" translate="no"><?php echo esc_html( $m['name'] ); ?></div>
                        <div class="comm-role"><?php echo esc_html( $m['role'] ); ?></div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
                <hr class="comm-sep">
            </div>
        </div>
    </div>
</section>

<section class="comm comm-section--secretariat" data-aos="fade-up">
    <div class="container">
        <div class="row  justify-content-center">
            <div class="col-xl-9">
                <h2 class="comm-heading-title"><?php echo esc_html( $sec_title ); ?></h2>
                <p class="comm-heading-desc"><?php echo esc_html( $sec_desc ); ?></p>

                <?php if ( $sec_members ) : ?>
                <div class="comm-grid">
                    <?php foreach ( $sec_members as $m ) :
                        $photo = is_array( $m['photo'] ) ? ( $m['photo']['url'] ?? '' ) : ( $m['photo'] ?? '' );
                        $iso2  = strtolower( trim( $m['country_iso2'] ?? '' ) );
                        $label = trim( $m['country_label'] ?? strtoupper( $iso2 ) );
                    ?>
                    <div class="comm-member">
                        <div class="comm-photo-wrap">
                            <?php if ( $photo ) : ?>
                            <img class="comm-photo" src="<?php echo esc_url( $photo ); ?>" alt="<?php echo esc_attr( $m['name'] ); ?>" loading="lazy">
                            <?php endif; ?>
                        </div>
                        <?php if ( $iso2 ) : ?>
                        <div class="comm-badge">
                            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/flags/' . esc_attr( $iso2 ) . '.svg' ); ?>" width="16" height="16" alt="">
                            <span><?php echo esc_html( $label ); ?></span>
                        </div>
                        <?php endif; ?>
                        <div class="comm-name" translate="no"><?php echo esc_html( $m['name'] ); ?></div>
                        <div class="comm-role"><?php echo esc_html( $m['role'] ); ?></div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
                <hr class="comm-sep">
            </div>
        </div>
    </div>
</section>

<section class="comm comm-section--sac" data-aos="fade-up">
    <div class="container">
        <div class="row  justify-content-center">
            <div class="col-xl-9">
                <h2 class="comm-heading-title"><?php echo esc_html( $sac_title ); ?></h2>
                <p class="comm-heading-desc"><?php echo esc_html( $sac_desc ); ?></p>

                <?php if ( $sac_members ) : ?>
                <div class="comm-grid">
                    <?php foreach ( $sac_members as $m ) :
                        $photo = is_array( $m['photo'] ) ? ( $m['photo']['url'] ?? '' ) : ( $m['photo'] ?? '' );
                        $iso2  = strtolower( trim( $m['country_iso2'] ?? '' ) );
                        $label = trim( $m['country_label'] ?? strtoupper( $iso2 ) );
                    ?>
                    <div class="comm-member">
                        <div class="comm-photo-wrap">
                            <?php if ( $photo ) : ?>
                            <img class="comm-photo" src="<?php echo esc_url( $photo ); ?>" alt="<?php echo esc_attr( $m['name'] ); ?>" loading="lazy">
                            <?php endif; ?>
                        </div>
                        <?php if ( $iso2 ) : ?>
                        <?php endif; ?>
                        <div class="comm-name" translate="no"><?php echo esc_html( $m['name'] ); ?></div>
                        <div class="comm-role"><?php echo esc_html( $m['role'] ); ?></div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<section class="tech" data-aos="fade-up">
    <div class="container">
        <div class="row  justify-content-center">
            <div class="col-xl-9">
                <div class="tech-inner">
                    <div class="tech-left">
                        <h2 class="tech-title"><?php echo esc_html( $tech_title ); ?></h2>
                        <p class="tech-desc"><?php echo wp_kses_post( $tech_desc ); ?></p>
                    </div>
                    <div class="tech-right">
                        <div class="tech-img-wrap">
                            <?php if ( $tech_image ) : ?>
                            <img src="<?php echo esc_url( $tech_image ); ?>" alt="<?php echo esc_attr( $tech_title ); ?>" loading="lazy">
                            <?php else : ?>
                            <div class="tech-img-placeholder">
                                <svg viewBox="0 0 96 96" fill="none" width="96" height="96" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="48" cy="48" r="36" fill="#1a6b9a" opacity=".9"/>
                                    <ellipse cx="48" cy="48" rx="14" ry="36" stroke="rgba(255,255,255,.35)" stroke-width="1.5"/>
                                    <line x1="12" y1="48" x2="84" y2="48" stroke="rgba(255,255,255,.35)" stroke-width="1.5"/>
                                    <line x1="18" y1="30" x2="78" y2="30" stroke="rgba(255,255,255,.2)" stroke-width="1"/>
                                    <line x1="18" y1="66" x2="78" y2="66" stroke="rgba(255,255,255,.2)" stroke-width="1"/>
                                    <path d="M48 18 C30 24 18 35 18 48 C18 61 30 72 48 78 C66 72 78 61 78 48 C78 35 66 24 48 18Z" fill="#2c9e6e" opacity=".4"/>
                                    <circle cx="48" cy="48" r="36" stroke="rgba(255,255,255,.15)" stroke-width="1.5"/>
                                </svg>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="funders" data-aos="fade-up">
    <div class="container">
        <div class="row  justify-content-center">
            <div class="col-12">
                <h2 class="funders-title"><?php echo esc_html( $funders_title ); ?></h2>
                <p class="funders-desc"><?php echo esc_html( $funders_desc ); ?></p>
                <div class="funders-pills">
                    <?php foreach ( $funders as $f ) :
                        $name = is_array( $f ) ? ( $f['name'] ?? '' ) : $f;
                        if ( ! $name ) continue;
                    ?>
                    <span class="funders-pill" translate="no"><?php echo esc_html( $name ); ?></span>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>
