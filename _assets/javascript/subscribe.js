$(document).ready(function(){
	
	$('form input').keydown(function (e) {
	    if (e.keyCode == 13) {
	        e.preventDefault();
	        return true;
	    }
	});

	let validMail = true;
	let validPassword = true;
	let validName = true;
	let error1 = $('<div></div>').addClass('alert').addClass('alert-danger').attr('role','alert');
	let error2 = $('<div></div>').addClass('alert').addClass('alert-danger').attr('role','alert');
	let error3 = $('<div></div>').addClass('alert').addClass('alert-danger').attr('role','alert');

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
			error1.text(subscribeError).attr('id','voidEmail').insertAfter('#emailGroup').show();
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

	$('#formControlEmailInput2').on('blur',function (e){
			let t0 = performance.now();

			const subscribeError = 'L\'adresse mail de confirmation n\'est pas identique !';
			let emailConf = ($(this).val()).toLowerCase();
			$(this).val(emailConf);
			let email = $('#formControlEmailInput1').val();
			let confError = $('#notConfEmail');
			let confLength = confError.length;
			let voidError = $('#voidEmail');
			let voidLength  = voidError.length;
			let voidDisplay = voidError.css('display');

			/*Si la div (erreurConf n'existe pas) ET que (l'erreur VOID n'existe pas OU (si elle existe ET est inactive 'none') ) et que l'email de confirmation n'est pas egale a l'original alors je cree et j'affiche l'erreurConf*/
			if(confLength==0 && (voidLength==0 || voidDisplay=='none') && emailConf!=email) {
				error1.text(subscribeError).attr('id','notConfEmail').insertAfter('#emailGroup').show();
				validMail = false;
			/*Si la div (erreurConf existe deja) ET que (l'erreur VOID n'existe pas OU (si elle existe ET est inactive 'none') ) et que l'email de confirmation n'est pas egale a l'original alors j'affiche l'erreurConf*/
			}else if(confLength==1 && (voidLength==0 || voidDisplay=='none') && emailConf!=email){
				confError.show();
				validMail = false;
			/*Sinon je cache l'erreur*/
			}else if(confLength==1){
				confError.hide();
				validMail = true;
			}
		let tres = performance.now()-t0;
		console.log('emailConf perf :'+tres);
	});

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

	$('#firstName').on('blur',function (e){
		const subscribeError = 'Les champs Nom et Prenom sont necessaires pour la validation de l\'inscription !';
		if($('#firstName').val()=='')
		{
			if($('#voidName').length==0){
				error3.text(subscribeError).attr('id','voidName').insertAfter('#nameGroup').show();
				validName = false;
			}else{
				$('#voidName').text(subscribeError).show();
				validName = false;
			}
		}else{
			$('#voidName').hide();
			validName = true;
		}
	});

	$('#lastName').on('blur',function (e){
		const subscribeError = 'Les champs Nom et Prenom sont necessaires pour la validation de l\'inscription !';
		if($('#lastName').val()=='')
		{
			if($('#voidName').length==0){
				error3.text(subscribeError).attr('id','voidName').insertAfter('#nameGroup').show();
				validName = false;
			}else{
				$('#voidName').text(subscribeError).show();
				validName = false;
			}
		}else{
			$('#voidName').hide();
			validName = true;
		}
	});

	$('#subscribe-form').on('submit',function (e){
		$(':input').trigger('blur');
		console.log('valid mail:'+validMail+' valid password:'+validPassword+' valid name:'+validName);
		if(!validMail || !validPassword || !validName)
		{
			e.preventDefault();
		}
	});
});