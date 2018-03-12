

 $(document).ready(function() {
    $('select').material_select();
  	$(".button-collapse").sideNav();
     $('.activator').mouseenter(function(){
        $(this).click();
    });
    $('.card-reveal').mouseleave(function(){
        $(this).find('.card-title').click();
    });
     
     
  });