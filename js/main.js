 $(document).ready(function() {
    $('select').material_select();
  	$(".button-collapse").sideNav();
	 $(".dropdown-button").dropdown();
     $('.activator').mouseenter(function(){
        $(this).click();
    });
    $('.card-reveal').mouseleave(function(){
        $(this).find('.card-title').click();
    });
     $('.datepicker').pickadate({
        selectMonths: true, // Creates a dropdown to control month
        selectYears: 100, // Creates a dropdown of 15 years to control year,
         max: new Date(),
         format: 'yyyy-mm-dd',// Set limit to today's date
        today: 'Today',
        clear: 'Clear',
        close: 'Ok',
        closeOnSelect: true // Close upon selecting a date, 
     });
     
  });