$('.activator').mouseenter(function(){
	$(this).click();
	// https://api.jquery.com/closest/
});
$('.card-reveal').mouseleave(function(){
	$(this).find('.card-title').click();
	// https://api.jquery.com/closest/
});

 $(document).ready(function() {
    $('select').material_select();
  });