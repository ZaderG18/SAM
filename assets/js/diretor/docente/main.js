document.addEventListener("DOMContentLoaded", function() {
  const cardWrapper = document.querySelector('.card-wrapper');
  const numberOfCards = cardWrapper.querySelectorAll('.card').length;

  function applyCustomStyles() {
    const cards = document.querySelectorAll('.card');

    if (numberOfCards === 1) {
      cards.forEach(card => {
        card.style.maxWidth = '300px';
        card.style.margin = '10px auto';
      });
      cardWrapper.style.display = 'flex';
      cardWrapper.style.justifyContent = 'center';
      cardWrapper.style.alignItems = 'center'; // Centraliza verticalmente
      cardWrapper.style.flexDirection = 'column';
    } else if (numberOfCards === 2) {
      cards.forEach(card => {
        card.style.width = '45%';
        card.style.margin = '10px';
      });
      cardWrapper.style.display = 'flex';
      cardWrapper.style.justifyContent = 'center';
    } else {
      cards.forEach(card => {
        card.style.width = '30%';
        card.style.margin = '10px';
      });
      cardWrapper.style.display = 'flex';
      cardWrapper.style.justifyContent = 'space-between';
    }

    window.addEventListener('resize', function() {
      if (window.innerWidth <= 768) {
        cards.forEach(card => {
          card.style.width = '100%';
          card.style.margin = '10px 0';
        });
        cardWrapper.style.flexDirection = 'column';
        cardWrapper.style.justifyContent = 'center';
        cardWrapper.style.alignItems = 'center';
      } else {
        cardWrapper.style.flexDirection = 'row';

        if (numberOfCards === 1) {
          cards.forEach(card => {
            card.style.width = '100%';
            card.style.margin = '10px 0';
          });
          cardWrapper.style.justifyContent = 'center';
        } else if (numberOfCards === 2) {
          cards.forEach(card => {
            card.style.width = '45%';
            card.style.margin = '10px';
          });
        } else {
          cards.forEach(card => {
            card.style.width = '30%';
            card.style.margin = '10px';
          });
        }
      }
    });

    if (window.innerWidth <= 768) {
      cards.forEach(card => {
        card.style.width = '100%';
        card.style.margin = '10px 0';
      });
      cardWrapper.style.flexDirection = 'column';
      cardWrapper.style.justifyContent = 'center';
      cardWrapper.style.alignItems = 'center';
    }
  }

  function removeCustomStyles() {
    const cards = document.querySelectorAll('.card');
    cards.forEach(card => {
      card.style.width = '';
      card.style.margin = '';
    });
    cardWrapper.style.display = '';
    cardWrapper.style.justifyContent = '';
    cardWrapper.style.flexWrap = '';
    cardWrapper.style.flexDirection = '';
    cardWrapper.style.alignItems = '';
  }

  if (numberOfCards > 3) {
    removeCustomStyles();
    var swiper = new Swiper(".slider-content", {
      slidesPerView: 3,
      spaceBetween: 25,
      loop: true,
      centerSlide: true,
      fade: true,
      grabCursor: true,
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
        dynamicBullets: true,
      },
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
      breakpoints: {
        0: {
          slidesPerView: 1,
        },
        520: {
          slidesPerView: 2,
        },
        950: {
          slidesPerView: 3,
        },
      },
    });
  } else {
    applyCustomStyles();
    document.querySelector('.swiper-button-next').style.display = 'none';
    document.querySelector('.swiper-button-prev').style.display = 'none';
    document.querySelector('.swiper-pagination').style.display = 'none';
  }
});
