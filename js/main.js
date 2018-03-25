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
     
	 
	 
	 $('#notificationDrop').on('click',function(){
		$('#notificationBadge').css('display','none');
	 });
	 $('.n').on('click',function(){
		 var n = $(this);
		 $.ajax({
			url : "includes/notificationsRead.php",
			method : "post",
			 data : {nid : n.data('nid')}
		}).done(function(data){
			 console.log(data);
			n.addClass('read');
		});
	 });
	 
	 $('#uName').on('change',function(){
		 var username = $(this).val();
		 $(this).parent('.input-field').find('.input-alert').remove();
		 $.ajax({
			url : "includes/checkUsername.php",
			 method : 'post',
			 data : {username : username}			 
		 }).done(function(data){
			 if(data != ""){
				 $('#uName').parent('.input-field').append("<span class='input-alert'>"+data+"</span>");
				 $('#uName').removeClass('valid').addClass('invalid');
			 }
		 });
	 });
  });