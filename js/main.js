$(document).ready(function() {
    $('select').formSelect();
  	$(".button-collapse").sidenav();
    $(".dropdown-trigger").dropdown();
    $('.activator').mouseenter(function(){
        $(this).click();
    });
    $('.card-reveal').mouseleave(function(){
        $(this).find('.card-title').click();
    });
    $('.birthdatepicker').datepicker({
        yearRange: [1,100], // Creates a dropdown of 100 years to control year,
        maxDate: new Date(),
        format: 'yyyy-mm-dd',// Set limit to today's date
        autoClose: true,
        firstDay: 1 // First day of week (0: Sunday, 1: Monday etc).        
    });
	$('.startdatepicker').datepicker({
        format: 'yyyy-mm-dd',// Set limit to today's date
        autoClose: true,
		minDate: new Date(),
		defaultDate: new Date(),
		setDefaultDate: true,
        firstDay: 1 // First day of week (0: Sunday, 1: Monday etc).        
    });
	$('.startdatepicker').datepicker({
        format: 'yyyy-mm-dd',// Set limit to today's date
        autoClose: true,
		minDate: new Date(),
        firstDay: 1 // First day of week (0: Sunday, 1: Monday etc).        
    });
	$('.fixed-action-btn').floatingActionButton();
	$('.collapsible').collapsible();
	$('.tooltipped').tooltip();
    $('.character-counter').characterCounter();
    $('.modal').modal();
	$('.tabs').tabs();
	 // show the right sidenav tab as active
	 $('li[data-active-title="'+document.title.split(" | ")[1] +'"]').addClass("active");
	 
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
     
     // reference for enter keypress event: https://stackoverflow.com/a/979686
     $('form.prevent-enter-submit').keypress(function(e) {
        if(e.which == 13) {
            e.preventDefault();
        }
    });
     
     // skill change on profile creation page
     $('#skill-add').on('click',function(){
         var skillVal = $("#skills").val();
         // check not empty
        if(skillVal != ""){
            // check if commas
            if(skillVal.includes(",")){
                var values = skillVal.split(',');
                $(values).each(submitSkill);
            } else {
                submitSkill(skillVal);
            }
        } else {
            M.toast({html:'Whoops, no skill entered!'});
        }
     });
	
	$('.removeSkill').on('click',function(){
		var skill = $(this).parent().attr('data-skill-name');
		var removeDiv = $(this).parent();
		$.ajax({
             url: 'includes/removeSkill.php',
             method: 'post',
             data: {skill: skill}
         }).done(function(data){
            M.toast({html: data});
			if(data == "Skill successfully removed!"){
				$(removeDiv).remove();
			}
         });
	})
     
    $('.save-description').on('click',function(){
        $.ajax({
             url: 'includes/editDescription.php',
             method: 'post',
             data: {description: $('textarea.edit-description').val()}
         }).done(function(data){
            M.toast({html: data});
         });
    });
    
    $('.save-quote').on('click',function(){
        $.ajax({
             url: 'includes/editQuote.php',
             method: 'post',
             data: {quote: $('textarea.profile-quote').val()}
         }).done(function(data){
            M.toast({html: data});
         });
    });
    
    
    
     function submitSkill(skill){
         $.ajax({
             url: 'includes/submitSkill.php',
             method: 'post',
             data: {skill: skill}
         }).done(function(data){
            M.toast({html: data});
			if(data == "Skill successfully added!"){
				$('.skill-chips').append('<div class="chip" data-skill-name="'+skill+'">'+skill+'<i class="material-icons right removeSkill">clear</i></div>');
			}
         });
     }
    
    $('.choose-unplash-pic').on('click',getUnsplash);
    
    function getUnsplash(){        
        $.ajax({
             url: 'https://api.unsplash.com/search/photos/?client_id=d31a456d88de5f6374cf15d300ac5de55c1afa4c5d84d9dfca0f3839b8886299&query=adventure',
             method: 'GET'
         }).done(function(data){
            var results = data.results;
            $.each(results, function(index, image){                
                $('.unsplash-images').append("<li><img class='update-cover-photo' data-url='"+image.urls.regular+"' src='"+image.urls.regular+"' alt='unsplash-image'></li>");
            });
            $('.update-cover-photo').on('click',function(){
                var src = $(this).attr('data-url');
                $.ajax({
                     url: 'includes/updateCoverPhoto.php',
                     method: 'post',
                     data: {src: src}
                 }).done(function(data){
                    M.toast({html: data});
                    if(data == "Cover photo successfully changed!"){
                        $('.cover-photo').css('background-image','url('+src+')');
                    }
                 });
            });
            $('.slider').slider();
         });
    }
    
    $('.save-occupation').on('click',function(){
         $.ajax({
             url: 'includes/editOccupation.php',
             method: 'post',
             data: {occupation: $('#occupation-edit').val()}
         }).done(function(data){
            M.toast({html: data});
         });
    });
    
    $('.save-location').on('click',function(){
         $.ajax({
             url: 'includes/editLocation.php',
             method: 'post',
             data: {location: $('#location-edit').val()}
         }).done(function(data){
            M.toast({html: data});
         });
    });
    
});