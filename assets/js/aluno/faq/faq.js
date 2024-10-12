// abrir e fechar lista
document.addEventListener("DOMContentLoaded", function() {
    var questions = document.querySelectorAll(".faq-question");
    questions.forEach(function(question) {
        question.addEventListener("click", function() {
            var answer = this.nextElementSibling;
            if (answer.style.display === "none" || answer.style.display === "") {
                answer.style.display = "block";
            } else {
                answer.style.display = "none";
            }
        });
    });
});