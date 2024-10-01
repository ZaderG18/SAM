// Slider para Feedback Professor
let currentSlideFeedback = 0;

function moveFeedbackSlide(direction) {
    const slides = document.querySelector('.card-slide');
    const cards = document.querySelectorAll('.card');
    const totalSlides = cards.length;
    const cardWidth = cards[0].offsetWidth + 20; // 10px de margem em cada lado (20px no total)
    const maxSlides = Math.floor(document.querySelector('.card-slider').offsetWidth / cardWidth);

    // Limitar a quantidade de slides
    currentSlideFeedback = Math.min(Math.max(currentSlideFeedback + direction, 0), totalSlides - maxSlides);

    // Mover o slide
    slides.style.transform = `translateX(-${currentSlideFeedback * cardWidth}px)`;
}

// Slider para Atividades Novas
let currentSlideActivity = 0;

function moveActivitySlide(direction) {
    const slides = document.querySelector('.activity-slide');
    const cards = document.querySelectorAll('.activity-card');
    const totalSlides = cards.length;
    const cardWidth = cards[0].offsetWidth + 20; // 10px de margem em cada lado (20px no total)
    const maxSlides = Math.floor(document.querySelector('.activity-slider').offsetWidth / cardWidth);

    // Limitar a quantidade de slides
    currentSlideActivity = Math.min(Math.max(currentSlideActivity + direction, 0), totalSlides - maxSlides);

    // Mover o slide
    slides.style.transform = `translateX(-${currentSlideActivity * cardWidth}px)`;
}

// Inicializa os sliders mostrando o primeiro slide
document.addEventListener('DOMContentLoaded', () => {
    // Feedback Professor
    const prevFeedbackButton = document.querySelector('.prev');
    const nextFeedbackButton = document.querySelector('.next');

    prevFeedbackButton.addEventListener('click', () => moveFeedbackSlide(-1));
    nextFeedbackButton.addEventListener('click', () => moveFeedbackSlide(1));
    moveFeedbackSlide(0); // Mostra o slide inicial

    // Atividades Novas
    const prevActivityButton = document.querySelector('.prevslide');
    const nextActivityButton = document.querySelector('.nextslide');

    prevActivityButton.addEventListener('click', () => moveActivitySlide(-1));
    nextActivityButton.addEventListener('click', () => moveActivitySlide(1));
    moveActivitySlide(0); // Mostra o slide inicial para atividades novas
});
