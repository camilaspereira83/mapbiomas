import 'owl.carousel';
import 'bootstrap';
import AOS from 'aos';

AOS.init({
  duration: 1200,
});

var main = {
  init: function () {
    this.main();
    this.carousel1();
    this.carousel2();
    this.animateNumbers();
    this.newsEventsTabs();
    this.languageSelector();
    this.faqAccordion();
  },
  main: function () {
    $("#menuToggle").click(function () {
      if ($(".main-navigation").hasClass("expanded")) {
        $(".main-navigation.expanded").removeClass("expanded");
        $(this).removeClass("active");
      } else {
        $(".main-navigation").addClass("expanded");
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
  animateNumbers: function () {
    const statNumbers = document.querySelectorAll('.stat-number');

    const animateNumber = (element) => {
      const target = parseInt(element.getAttribute('data-target').replace(/[^0-9]/g, ''));
      const duration = 2000; // 2 seconds
      const step = target / (duration / 16); // 60fps
      let current = 0;

      const timer = setInterval(() => {
        current += step;
        if (current >= target) {
          element.textContent = target.toLocaleString();
          clearInterval(timer);
        } else {
          element.textContent = Math.floor(current).toLocaleString();
        }
      }, 16);
    };

    const observerOptions = {
      threshold: 0.5,
      rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          animateNumber(entry.target);
          observer.unobserve(entry.target);
        }
      });
    }, observerOptions);

    statNumbers.forEach(number => {
      observer.observe(number);
    });
  },
  newsEventsTabs: function () {
    const tabButtons = document.querySelectorAll('.tab-button');
    const tabContents = document.querySelectorAll('.tab-content');

    tabButtons.forEach(button => {
      button.addEventListener('click', () => {
        // Remove active class from all buttons
        tabButtons.forEach(btn => btn.classList.remove('active'));
        // Add active class to clicked button
        button.classList.add('active');

        // Hide all tab contents
        tabContents.forEach(content => content.classList.remove('active'));

        // Show the corresponding tab content
        const tabId = button.getAttribute('data-tab');
        const targetContent = document.getElementById(tabId);
        if (targetContent) {
          targetContent.classList.add('active');
        }
      });
    });

    // Initialize thumbnail carousels for each tab
    this.initThumbnailCarousels();
  },
  initThumbnailCarousels: function () {
    const carousels = document.querySelectorAll('.news-carousel');

    carousels.forEach(carousel => {
      const wrapper = carousel.querySelector('.thumbnails-wrapper');
      const thumbnails = carousel.querySelectorAll('.thumbnail-item');
      const prevArrow = carousel.querySelector('.prev-arrow');
      const nextArrow = carousel.querySelector('.next-arrow');
      const featuredImage = carousel.querySelector('.featured-image img');
      const featuredTitle = carousel.querySelector('.featured-title a');
      const featuredExcerpt = carousel.querySelector('.featured-excerpt');
      const readMoreBtn = carousel.querySelector('.read-more-btn');
      const dotsContainer = carousel.querySelector('.carousel-dots');
      
      let dots = [];

      let currentIndex = 0;

      const updateFeatured = (index) => {
        const selectedThumbnail = thumbnails[index];

        if (selectedThumbnail) {
            const image = selectedThumbnail.dataset.image;
            const title = selectedThumbnail.dataset.title;
            const excerpt = selectedThumbnail.dataset.excerpt;
            const link = selectedThumbnail.dataset.link;
            const tag = selectedThumbnail.dataset.tag;

            featuredImage.src = image;
            featuredImage.alt = title;
            featuredTitle.textContent = title;
            featuredTitle.href = link;
            featuredExcerpt.textContent = excerpt;
            readMoreBtn.href = link;

            const featuredTag = carousel.querySelector('.featured-tag');
            if (featuredTag) {
            if (tag) {
                featuredTag.textContent = tag;
                featuredTag.style.display = 'inline-block';
            } else {
                featuredTag.style.display = 'none';
            }
            }

            const countryLabel = selectedThumbnail.dataset.countryLabel;
            const countryIso   = selectedThumbnail.dataset.countryIso;
            const flagsBase    = selectedThumbnail.dataset.flagsBase;
            const locationDiv  = carousel.querySelector('.featured-location');
            if (locationDiv && countryLabel) {
                const flagImg   = locationDiv.querySelector('img');
                const labelSpan = locationDiv.querySelector('span');
                if (flagImg && flagsBase) flagImg.src = flagsBase + countryIso + '.svg';
                if (labelSpan) labelSpan.textContent = countryLabel;
            }

            thumbnails.forEach((thumb, i) => {
            thumb.classList.toggle('active', i === index);
            });

            if (dots.length) {
                dots.forEach((dot, i) => {
                    dot.classList.toggle('active', i === index);
                });
            }
            currentIndex = index;
        }
        };

      thumbnails.forEach((thumbnail, index) => {
        thumbnail.addEventListener('click', () => {
          updateFeatured(index);
        });
      });

      if (prevArrow) {
        prevArrow.addEventListener('click', () => {
          const newIndex = currentIndex > 0 ? currentIndex - 1 : thumbnails.length - 1;
          updateFeatured(newIndex);
          scrollToThumbnail(newIndex);
        });
      }

      if (nextArrow) {
        nextArrow.addEventListener('click', () => {
          const newIndex = currentIndex < thumbnails.length - 1 ? currentIndex + 1 : 0;
          updateFeatured(newIndex);
          scrollToThumbnail(newIndex);
        });
      }

      const scrollToThumbnail = (index) => {
        if (wrapper && thumbnails[index]) {
          const thumbnail = thumbnails[index];
          const container = wrapper;
          const thumbnailLeft = thumbnail.offsetLeft;
          const containerWidth = container.offsetWidth;
          const thumbnailWidth = thumbnail.offsetWidth;

          container.scrollLeft = thumbnailLeft - (containerWidth / 2) + (thumbnailWidth / 2);
        }
      };

      if (dotsContainer) {
        thumbnails.forEach((_, index) => {
            const dot = document.createElement('span');
            dot.classList.add('carousel-dot');

            if (index === 0) dot.classList.add('active');

            dot.addEventListener('click', () => {
            updateFeatured(index);
            scrollToThumbnail(index);
            });

            dotsContainer.appendChild(dot);
            dots.push(dot);
        });
        }

      updateFeatured(0);
    });
  },
  languageSelector: function () {
    const languageCurrent = document.querySelector('.language-current');
    const headerLanguage = document.querySelector('.header__language');

    if (languageCurrent && headerLanguage) {
      languageCurrent.addEventListener('click', function() {
        headerLanguage.classList.toggle('is-open');
        this.setAttribute('aria-expanded', headerLanguage.classList.contains('is-open'));
      });

      // Close when clicking outside
      document.addEventListener('click', function(e) {
        if (!headerLanguage.contains(e.target)) {
          headerLanguage.classList.remove('is-open');
          languageCurrent.setAttribute('aria-expanded', 'false');
        }
      });
    }
  },
  faqAccordion: function () {
    const faqItems = document.querySelectorAll('.faq__item');

    faqItems.forEach(item => {
      const question = item.querySelector('.faq__question');
      const answer = item.querySelector('.faq__answer');
      const icon = item.querySelector('.faq__icon');

      if (question && answer) {
        question.addEventListener('click', function() {
          const isExpanded = this.getAttribute('aria-expanded') === 'true';

          // Close all other items
          faqItems.forEach(otherItem => {
            const otherQuestion = otherItem.querySelector('.faq__question');
            const otherAnswer = otherItem.querySelector('.faq__answer');
            const otherIcon = otherItem.querySelector('.faq__icon');

            if (otherItem !== item && otherAnswer) {
              otherQuestion.setAttribute('aria-expanded', 'false');
              otherAnswer.classList.remove('active');
              otherAnswer.style.maxHeight = null;
              if (otherIcon) {
                otherIcon.src = otherIcon.dataset.plus;
                otherIcon.alt = 'Abrir';
              }
            }
          });

          // Toggle current item
          if (isExpanded) {
            this.setAttribute('aria-expanded', 'false');
            answer.classList.remove('active');
            answer.style.maxHeight = null;
            if (icon) {
              icon.src = icon.dataset.plus;
              icon.alt = 'Abrir';
            }
          } else {
            this.setAttribute('aria-expanded', 'true');
            answer.classList.add('active');
            answer.style.maxHeight = answer.scrollHeight + 'px';
            if (icon) {
              icon.src = icon.dataset.minus;
              icon.alt = 'Fechar';
            }
          }
        });
      }
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

//ADD ACTIVE CLASS NO NAV
document.addEventListener('DOMContentLoaded', function () {
  const menu = document.querySelector('.main-navigation');
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

// SEARCH GLOSSARIO
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('glossary-search');
    const groups = document.querySelectorAll('.glossary__group');
    const letterButtons = document.querySelectorAll('.glossary__letter-filter');
    const emptyMsg = document.querySelector('.glossary__empty');

    function showGroup(group) {
    group.style.display = 'block';
    }

    function hideGroup(group) {
    group.style.display = 'none';
    }

    searchInput.addEventListener('input', function () {
    const value = this.value.toLowerCase();

    letterButtons.forEach(b => b.classList.remove('active'));

    let foundAny = false;

    groups.forEach(group => {
        const cards = group.querySelectorAll('.glossary__card');
        let hasVisible = false;

        cards.forEach(card => {
        const termo = card.dataset.termo;

        if (termo.includes(value)) {
            card.style.display = 'block';
            hasVisible = true;
        } else {
            card.style.display = 'none';
        }
        });

        if (hasVisible) {
        showGroup(group);
        foundAny = true;
        } else {
        hideGroup(group);
        }
    });

    if (emptyMsg) {
        emptyMsg.style.display = foundAny ? 'none' : 'block';
    }
    });

    letterButtons.forEach(btn => {
    btn.addEventListener('click', () => {
        const selectedLetter = btn.dataset.letter;

        letterButtons.forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        searchInput.value = '';

        let firstVisibleGroup = null;

        if (selectedLetter === 'all') {
        groups.forEach(group => {
            showGroup(group);
            if (!firstVisibleGroup) firstVisibleGroup = group;
        });
        } else {
        groups.forEach(group => {
            const letter = group.querySelector('.glossary__letter').textContent.trim();

            if (letter === selectedLetter) {
            showGroup(group);
            if (!firstVisibleGroup) firstVisibleGroup = group;
            } else {
            hideGroup(group);
            }
        });
        }
        if (emptyMsg) emptyMsg.style.display = 'none';
    });
    });
});
