$(document).ready(function(){
	
	$('form input').keydown(function (e) {
	    if (e.keyCode == 13) {
	        e.preventDefault();
	        return true;
	    }
	});

	let validPassword = true;
	let error2 = $('<div></div>').addClass('alert').addClass('alert-danger').attr('role','alert');

	$('#inputPassword1').on('blur',function (e){
		let t0 = performance.now();

		const subscribeError = 'Le mot de passe doit contenir au moins 8 caracteres, une majuscule, une minuscule, un chiffre et un special parmis les suivants "@$!%*?&"';
		let password = $(this).val();
		let voidError = $('#voidPassword');
		let voidLength = voidError.length;
		/*Si la div erreur n'existe pas et que la valeur du champ est vide ou ne respecte pas l'expression reguliere alors je cree la div erreur*/
		if(voidLength==0 && (password=='' || !(/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}/.test(password)) ) )
		{
			error2.text(subscribeError).attr('id','voidPassword').insertAfter('#passwordGroup').show();
			validPassword = false;
		/*Si la div erreur existe deja et que la valeur du champ est vide ou ne correspond pas l'expression reguliere alors j'affiche l'erreur*/
		}else if(voidLength==1 && (password=='' || !(/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}/.test(password)) ) ){
			voidError.show();
			validPassword = false;
		}else if(voidLength==1){
			voidError.hide();
			validPassword = true;
		}
		let tres = performance.now()-t0;
		console.log('password perf :'+tres);
	});

	$('#inputPassword2').on('blur',function (e){
			let t0 = performance.now();

			const subscribeError = 'Le mot de passe de confirmation n\'est pas identique !';
			let passwordConf = $(this).val();
			let password = $('#inputPassword1').val();
			let confError = $('#notConfPassword');
			let confLength = confError.length;
			let voidError = $('#voidPassword');
			let voidLength  = voidError.length;
			let voidDisplay = voidError.css('display');

			/*Si la div (erreurConf n'existe pas) ET que (l'erreur VOID n'existe pas OU (si elle existe ET est inactive 'none') ) et que le mot de passe de confirmation n'est pas egale a l'original alors je cree et j'affiche l'erreurConf*/
			if(confLength==0 && (voidLength==0 || voidDisplay=='none') && passwordConf!=password) {
				error2.text(subscribeError).attr('id','notConfPassword').insertAfter('#passwordGroup').show();
				if(validPassword!=null){
					validPassword = false;
				}else{
					validPassword = true;
				}

			/*Si la div (erreurConf existe deja) ET que (l'erreur VOID n'existe pas OU (si elle existe ET est inactive 'none') ) ET que le mot de passe de confirmation n'est pas egale a l'original alors j'affiche l'erreur*/
			}else if(confLength==1 && (voidLength==0 || voidDisplay=='none') && passwordConf!=password){
				confError.show();
				validPassword = false;
			/*Sinon je cache l'erreur*/
			}else if(confLength==1){
				confError.hide();
				validPassword = true;
			}
		let tres = performance.now()-t0;
		console.log('passwordConf perf :'+tres);
	});

	$('#reset-form').on('submit',function (e){
		$(':input').trigger('blur');
		console.log(' valid password:'+validPassword);
		if(!validPassword)
		{
			e.preventDefault();
		}
	});
});