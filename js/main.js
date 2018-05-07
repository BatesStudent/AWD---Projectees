<<<<<<< HEAD
$(document).ready(function() {
    $('select').formSelect();
  	$(".button-collapse").sidenav();
    $(".dropdown-trigger").dropdown();
=======
 $(document).ready(function() {
    $('select').material_select();
  	$(".button-collapse").sideNav();
    $(".dropdown-button").dropdown();
>>>>>>> 2517351fcc9d4fcbe9e67390baae894662ee8972
    $('.activator').mouseenter(function(){
        $(this).click();
    });
    $('.card-reveal').mouseleave(function(){
        $(this).find('.card-title').click();
    });
     $('.datepicker').datepicker({
        yearRange: [1,100], // Creates a dropdown of 100 years to control year,
         maxDate: new Date(),
         format: 'yyyy-mm-dd',// Set limit to today's date
        autoClose: true,
        firstDay: 1 // First day of week (0: Sunday, 1: Monday etc).        
     });
	$('.fixed-action-btn').floatingActionButton();
	$('.collapsible').collapsible();
	$('.tooltipped').tooltip();
	
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
<<<<<<< HEAD
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
=======
            Materialize.toast('Whoops, no skill entered!');
        }
     });
>>>>>>> 2517351fcc9d4fcbe9e67390baae894662ee8972
     
     function submitSkill(skill){
         $.ajax({
             url: 'includes/submitSkill.php',
             method: 'post',
             data: {skill: skill}
         }).done(function(data){
<<<<<<< HEAD
            M.toast({html: data});
			if(data == "Skill successfully added!"){
				$('.skill-chips').append('<div class="chip" data-skill-name="'+skill+'">'+skill+'<i class="material-icons right removeSkill">clear</i></div>');
			}
=======
            Materialize.toast(data, 4000);
>>>>>>> 2517351fcc9d4fcbe9e67390baae894662ee8972
         });
     }
});