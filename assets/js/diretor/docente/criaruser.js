document.addEventListener("DOMContentLoaded", function () {
    const steps = document.querySelectorAll(".step");
    let currentStep = 0;

    function showStep(step) {
        steps.forEach((s, index) => {
            s.classList.toggle("active", index === step);
        });
    }

    const nextButtons = document.querySelectorAll(".next");
    nextButtons.forEach(button => {
        button.addEventListener("click", function () {
            if (currentStep < steps.length - 1) {
                currentStep++;
                showStep(currentStep);
            }
        });
    });

    const prevButtons = document.querySelectorAll(".prev");
    prevButtons.forEach(button => {
        button.addEventListener("click", function () {
            if (currentStep > 0) {
                currentStep--;
                showStep(currentStep);
            }
        });
    });

    const concludeButton = document.getElementById("concluir");
    concludeButton.addEventListener("click", function () {
        currentStep = 0;
        showStep(currentStep);
    });

    // Mostra o primeiro step
    showStep(currentStep);
});
