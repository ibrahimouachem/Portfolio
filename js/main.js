$(function(){
	$(".navbar a, footer a").on("click", function(event){
		event.preventDefault();
		var hash = this.hash;

		$("body").animate({scrollTop: $(hash).offset().top} , 900 , function(){window.location.hash = hash;})
	});
	
	$('#contact-form').submit(function(e){
		
//e = evenement et preventDefault permet de suprime le comportement par default quand on soumi le formulaire
		e.preventDefault();
		
//prendre tout les commentaire et les vider
		$('.comment').empty();
		
//permetre de chercher toutes les info qui sont dans le formulair et les metre dans la var postdata
		var postdata = $('#contact-form').serialize();
		
//on start ajax
		$.ajax({
			type: 'POST',
			url: 'php/contact.php',
			data: postdata,
			dataType: 'json',
			success: function(json){
				
				if(json.isSuccess){
		//si c'est un succes on envoi le message thank-you.
					$('#contact-form').append("<p class='thank-you'>votre message a ete envoye</p>");
		//si c'est un succes on remet tout a 0.
					$('#contact-form')[0].reset();
				}
			
		//si ce n'est pas un succes on envoi le message d'erreur
				
				else{
					$('#firstname + .comments').html(json.firstnameError);
					$('#name + .comments').html(json.nameError);
					$('#email + .comments').html(json.emailError);
					$('#phone + .comments').html(json.phoneError);
					$('#message + .comments').html(json.messageError);
				}
			}
		})
	})
})