import 'owl.carousel';
import 'bootstrap';
import AOS from 'aos';

AOS.init();

var main = {
  init: function () {
    this.main();
    this.carousel1();
    this.carousel2();
  },
  main: function () {
    $("#menuToggle").click(function () {
      if ($(".menu-principal").hasClass("expanded")) {
        $(".menu-principal.expanded").removeClass("expanded");
        $(this).removeClass("active");
      } else {
        $(".menu-principal").addClass("expanded");
        $(this).addClass("active");
      }
    });
    $('#menuToggle').click(function(){
      $(this).toggleClass('open');
    });
  },
  carousel1: function () {
    var owl1 = $('.owl-carousel1');
    $(window).on('load', function(){
      owl1.owlCarousel({
        items: 1,
        margin:0,
        nav: false,
        dots: true,
        loop: false,
        autoplay: false,
        smartSpeed: 400,
        mouseDrag: true,
      });
    });
  },
  carousel2: function () {
    var owl2 = $('.owl-carousel2');
    $(window).on('load', function(){
      owl2.owlCarousel({
        items: 3,
        margin:25,
        nav: false,
        dots: true,
        loop: false,
        autoplay: false,
        smartSpeed: 400,
        mouseDrag: true,
        responsiveClass:true,
        responsive:{
            0:{
                items:1
            },
            767:{
                items:1
            },
            992:{
                items:1,
                margin:0
            },
            1200:{
                items:3
            }
          }
      });
    });
  },
}
main.init();

$('nav a').click(function() {
    $('nav a.active').removeClass('active');
    $(this).addClass('active');
});

 $(window).bind('scroll', function () {
  if ($(window).scrollTop() < 1) {
		$('header').removeClass("fixo");
	} else {
		$('header').addClass("fixo");
	}
});

 
 $(document).ready(function(){
$('.menu-principal a[href^="#"]').on('click', function(e) {
   e.preventDefault();
   var id = $(this).attr('href'),
       targetOffset = $(id).offset().top;
      
   $('html, body').animate({
     scrollTop: targetOffset - 100
   }, 500);
 });
});

//ADD ACTIVE CLASS NO NAV

 
document.addEventListener('DOMContentLoaded', function () {
  const menu = document.querySelector('.menu-principal');
  if (!menu) return;

  const links = [...menu.querySelectorAll('a[href]')];

  const normalizePath = (p) => {
    if (!p) return '';
    // remove query/hash se vierem (só por segurança)
    p = p.split('?')[0].split('#')[0];
    // mantém "/" como "/"
    if (p === '/') return '/';
    // remove barra final
    return p.replace(/\/+$/, '');
  };

  const currentPath = normalizePath(window.location.pathname);

  let best = null; // { link, linkPath, score }

  links.forEach(link => {
    const href = link.getAttribute('href') || '';
    if (!href || href.startsWith('#') || href.startsWith('javascript:')) return;

    let linkPath = '';
    try {
      const u = new URL(link.href, window.location.origin);
      linkPath = normalizePath(u.pathname);
    } catch (e) {
      return;
    }

    if (!linkPath) return;

    const isExact = currentPath === linkPath;
    const isDescendant =
      linkPath !== '/' && currentPath.startsWith(linkPath + '/');

    // Home só deve marcar quando estiver exatamente na home
    const isHomeExact = (linkPath === '/' && currentPath === '/');

    if (isExact || isDescendant || isHomeExact) {
      // score = tamanho do path (quanto mais específico, melhor)
      const score = linkPath.length;
      if (!best || score > best.score) {
        best = { link, linkPath, score };
      }
    }
  });

  if (best) {
    best.link.classList.add('active');
    best.link.closest('li')?.classList.add('active');
  }
});
