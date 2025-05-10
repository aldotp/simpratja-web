import Alpine from "alpinejs"
import "./bootstrap";
import "./accordion";
import "./dialog";

window.Alpine = Alpine

Alpine.start()

// Testimonial Carousel dengan Swiper
document.addEventListener('DOMContentLoaded', () => {
    // Cek apakah ada elemen testimonial-carousel
    const testimonialContainer = document.querySelector('.testimonial-carousel');
    if (!testimonialContainer) return;

    // Konversi struktur HTML untuk Swiper
    testimonialContainer.classList.add('swiper');

    // Ambil track dan ubah menjadi swiper-wrapper
    const track = document.querySelector('.testimonial-track');
    if (track) {
        track.classList.add('swiper-wrapper');
        track.classList.remove('testimonial-track');
    }

    // Ubah slide menjadi swiper-slide
    const slides = document.querySelectorAll('.testimonial-slide');
    slides.forEach(slide => {
        slide.classList.add('swiper-slide');
    });

    // Tambahkan navigasi Swiper
    const prevButton = document.querySelector('.testimonial-arrow.prev');
    if (prevButton) {
        prevButton.classList.add('swiper-button-prev');
        prevButton.innerHTML = '';
    }

    const nextButton = document.querySelector('.testimonial-arrow.next');
    if (nextButton) {
        nextButton.classList.add('swiper-button-next');
        nextButton.innerHTML = '';
    }

    // Ubah dots container menjadi swiper-pagination
    const dotsContainer = document.querySelector('.testimonial-dots');
    if (dotsContainer) {
        dotsContainer.classList.add('swiper-pagination');
        dotsContainer.innerHTML = '';
    }

    // Inisialisasi Swiper
    const swiper = new Swiper('.testimonial-carousel', {
        // Parameter opsional
        slidesPerView: 1,
        spaceBetween: 10,
        loop: true,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
            pauseOnMouseEnter: true
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev'
        },
        breakpoints: {
            // ketika lebar window >= 768px
            768: {
                slidesPerView: 2,
                spaceBetween: 20
            },
            // ketika lebar window >= 1024px
            1024: {
                slidesPerView: 3,
                spaceBetween: 30
            }
        }
    });
});

document.addEventListener("DOMContentLoaded", function() {
    const lightSwitches = document.querySelectorAll('.light-switch');
  if (lightSwitches.length > 0) {
    lightSwitches.forEach((lightSwitch, i) => {
      if (localStorage.getItem('dark-mode') === 'true') {
        lightSwitch.checked = true;
      }
      lightSwitch.addEventListener('change', () => {
        const { checked } = lightSwitch;
        lightSwitches.forEach((el, n) => {
          if (n !== i) {
            el.checked = checked;
          }
        });
        document.documentElement.classList.add('**:transition-none!');
        if (lightSwitch.checked) {
          document.documentElement.classList.add('dark');
          document.querySelector('html').style.colorScheme = 'dark';
          localStorage.setItem('dark-mode', true);
          document.dispatchEvent(new CustomEvent('darkMode', { detail: { mode: 'on' } }));
        } else {
          document.documentElement.classList.remove('dark');
          document.querySelector('html').style.colorScheme = 'light';
          localStorage.setItem('dark-mode', false);
          document.dispatchEvent(new CustomEvent('darkMode', { detail: { mode: 'off' } }));
        }
        setTimeout(() => {
          document.documentElement.classList.remove('**:transition-none!');
        }, 1);
      });
    });
  }
});
