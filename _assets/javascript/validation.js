$(document).ready(function(){
	
	$('form input').keydown(function (e) {
	    if (e.keyCode == 13) {
	        e.preventDefault();
	        return true;
	    }
	});

	let validMail = true;
	let error1 = $('<div></div>').addClass('alert').addClass('alert-danger').attr('role','alert');

	$('#formControlEmailInput1').on('blur',function (e){
		let t0 = performance.now();

		const subscribeError = 'Veuillez mettre une adresse mail valide !';
		let email = ($(this).val()).toLowerCase();
		$(this).val(email);
		let voidError = $('#voidEmail');
		let voidLength = voidError.length;
		/*Si la div erreur n'existe pas et que la valeur du champ est vide ou ne respecte pas l'expression reguliere alors je cree la div erreur*/
		if(voidLength==0 && (email=='' || !(/^[a-z0-9._-]+@[a-z0-9._-]+\.[a-z]{2,6}$/.test(email)) ) )
		{
			error1.text(subscribeError).attr('id','voidEmail').insertAfter('#after').show();
			validMail = false;
		/*Si la div erreur existe deja et que la valeur du champ est vide ou ne correspond pas l'expression reguliere alors j'affiche l'erreur*/
		}else if(voidLength==1 && (email=='' || !(/^[a-z0-9._-]+@[a-z0-9._-]+\.[a-z]{2,6}$/.test(email)) ) ){
			voidError.show();
			validMail = false;
		}else if(voidLength==1){
			voidError.hide();
			validMail = true;
		}
		let tres = performance.now()-t0;
		console.log('email perf :'+tres);
	});

	$('#validation-form').on('submit',function (e){
		$(':input').trigger('blur');
		if(!validMail)
		{
			e.preventDefault();
		}
	});
});