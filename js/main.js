$(document).ready(function() {
    // initialise materializeCSS components
    $('select').formSelect();
  	$(".sidenav").sidenav();
    $(".dropdown-trigger").dropdown();
	$(".dropdown-trigger-n").dropdown({
		constrainWidth: false,
		alignment: 'center',
		coverTrigger: false	
	});
	if(window.innerWidth > 992){
		$('.activator').mouseenter(function(){
			$(this).click();
		});
		$('.card-reveal').mouseleave(function(){
			$(this).find('.card-title').click();
		});		
	}
	else {		
		$('.activator .material-icons').on('click',function(){
			$(this).closest('.activator').click();
		});
	}
    $('.fixed-action-btn').floatingActionButton();
	$('.collapsible').collapsible();
	$('.tooltipped').tooltip();
    $('.character-counter').characterCounter();
    $('.modal').modal();
	$('.tabs').tabs();
	$('.collapsible.expandable').collapsible({accordion:false});
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
	$('.enddatepicker').datepicker({
        format: 'yyyy-mm-dd',// Set limit to today's date
        autoClose: true,
		minDate: new Date(),
        firstDay: 1 // First day of week (0: Sunday, 1: Monday etc).        
    });
	
    // show the right sidenav tab as active by getting the end of the page title and comparing it to a data attribute on the nav item
    $('li[data-active-title="'+document.title.split(" | ")[1] +'"]').addClass("active");
	 
    // hide the notifications badge on click of the notification dropdown
	 $('#notificationDrop').on('click',function(){
		$('#notificationBadge').css('display','none');
	 });
    // if a notification is clicked, mark it as read
	 $('.n').on('click',function(){
		 var n = $(this);
		 $.ajax({
			url : "includes/notificationsRead.php",
			method : "post",
            data : {nid : n.attr('data-nid')}
		}).done(function(data){
			n.addClass('read');
			 console.log(data);
		});
	 });
	 
    // provide feedback to a registering user if the username they want is already taken
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
    
    $('.choose-unplash-pic').on('click',getUnsplashCover);
    function getUnsplashCover(){       
        $.ajax({
             url: 'https://api.unsplash.com/search/photos/?client_id=d31a456d88de5f6374cf15d300ac5de55c1afa4c5d84d9dfca0f3839b8886299&query=adventure',
             method: 'GET'
         }).done(function(data){
            var results = data.results;
            $.each(results, function(index, image){                
                $($('.unsplash-images')).append("<li><img class='update-cover-photo' data-url='"+image.urls.regular+"' src='"+image.urls.regular+"' alt='unsplash-image'></li>");
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
	
	$('.choose-unplash-pic-project').on('click',getUnsplashCoverProject);
    function getUnsplashCoverProject(){       
        $.ajax({
             url: 'https://api.unsplash.com/search/photos/?client_id=d31a456d88de5f6374cf15d300ac5de55c1afa4c5d84d9dfca0f3839b8886299&query=planning',
             method: 'GET'
         }).done(function(data){
            var results = data.results;
            $.each(results, function(index, image){                
                $($('.unsplash-images')).append("<li><img class='update-cover-photo' data-url='"+image.urls.regular+"' src='"+image.urls.regular+"' alt='unsplash-image'></li>");
            });
            $('.update-cover-photo').on('click',function(){
                var src = $(this).attr('data-url');
                $.ajax({
                     url: 'includes/editProjectCover.php',
                     method: 'post',
                     data: {src: src, projectid: $('.unsplash-images').attr('data-project')}
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
    
	$('.switch label').on('click',function(){
		if($(this).children(':checkbox').is(':checked')){
			$(this).children(':checkbox').val(1);
		} else {
			$(this).children(':checkbox').val(0);
		}
	});
	
	$('.save-short').on('click',function(){
         $.ajax({
             url: 'includes/editProjectShort.php',
             method: 'post',
             data: {short: $('.edit-short').val(), projectid: $('.save-short').attr('data-project')}
         }).done(function(data){
            M.toast({html: data});
         });
    });
	
	$('.save-long').on('click',function(){
         $.ajax({
             url: 'includes/editProjectLong.php',
             method: 'post',
             data: {long: $('.edit-long').val(), projectid: $('.save-long').attr('data-project')}
         }).done(function(data){
            M.toast({html: data});
         });
    });
	
	$('.save-lookingFor').on('click',function(){
         $.ajax({
             url: 'includes/editLookingFor.php',
             method: 'post',
             data: {lookingFor: $('.edit-lookingFor').val(), projectid: $('.save-lookingFor').attr('data-project')}
         }).done(function(data){
            M.toast({html: data});
         });
    });
	
	
	$('.save-endDate').on('click',function(){
         $.ajax({
             url: 'includes/editEndDate.php',
             method: 'post',
             data: {endDate: $('#endDate-edit').val(), projectid: $('.save-endDate').attr('data-project')}
         }).done(function(data){
            M.toast({html: data});
         });
    });
	
	// send an invite through ajax
	$('.invite-button').on('click',function(){
		var id = $(this).attr('data-id');
		$.ajax({
			url: 'includes/inviteToApply.php',
			method: 'post',
			data: {id: id}
		}).done(function(data){			
			M.toast({html:"Invitation sent!"});
		});
	});
	
	// send an invite through ajax
	$('.apply-button').on('click',function(){
		var id = $(this).attr('data-id');
		$.ajax({
			url: 'includes/applyToProject.php',
			method: 'post',
			data: {id: id}
		}).done(function(data){
			console.log(data);
			M.toast({html:data});
		});
	});
	
	$('.application .material-icons').on('click', function(){
		var e = $(this);
		var value = $(this).attr('data-value');
		var userid = $(this).attr('data-user-id');
		var projectid = $(this).attr('data-project-id');
		$.ajax({
			url: 'includes/respondApplication.php',
			method: 'post',
			data: {userid: userid, projectid:projectid,value:value}
		}).done(function(data){
			if(data == "success"){
				$(e).closest('.application').css('display','none');
			} else {
				console.log(data);
				M.toast({html:"Unable to respond to application."});
			}
		});
	});
	
});