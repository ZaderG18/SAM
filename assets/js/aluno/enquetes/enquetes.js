
document.addEventListener('DOMContentLoaded', function() {
 const forms = document.querySelectorAll('.poll-form');
 forms.forEach(form => {
 form.addEventListener('submit', function(event) {
   event.preventDefault();
   const pollData = new FormData(form);
   const pollName = form.getAttribute('data-poll');
   const pollResult = {};
   pollData.forEach((value, key) => {
       pollResult[key] = value;
   });
   console.log(`Poll ${pollName} submitted:`, pollResult);
   alert(`Obrigado por votar na enquete sobre ${pollName}!`);
   form.reset();
     });
   });
});

             

