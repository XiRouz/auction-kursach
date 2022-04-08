$('document').ready(function(){
	var way = '/';
	//регистрация
	$('#ConfirmRegistration').click(function(){
		var formData = $("#formRegistration").serialize();
	    $.ajax({
	        type: "POST",
	        url: way+"_registration.php",
	        data: formData,
	        success: function(data) {
	            var error = jQuery.parseJSON(data);

	            //вывод ошибки логина
	            if(error.login != '' && error.loginOk == false){
					$('#infoLogin').html(error.login).css({'display':'list-item'});
	            }else{
	            	$('#infoLogin').css({'display':'none'});
	            }

	            //вывод ошибки пароля
	            if(error.password != '' && error.passwordOk == false){
					$('#infoPassword').html(error.password).css({'display':'list-item'});
	            }else{
	            	$('#infoPassword').css({'display':'none'});
	            }

	            //вывод ошибки повторения пароля
	            if(error.repeatPassword != '' && error.repeatPasswordOk == false){
					$('#infoRepeatPassword').html(error.repeatPassword).css({'display':'list-item'});
	            }else{
	            	$('#infoRepeatPassword').css({'display':'none'});
	            }

	            //вывод ошибки почты
	            if(error.login != '' && error.emailOk == false){
					$('#infoEmail').html(error.email).css({'display':'list-item'});
	            }else{
	            	$('#infoEmail').css({'display':'none'});
	            }

	            //вывод ошибки соглашения с правилами
	            if(error.checkbox != '' && error.checkboxOk == false){
					$('#infoCheck').html(error.checkbox).css({'display':'list-item'});
	            }else{
	            	$('#infoCheck').css({'display':'none'});
	            }

	            if(error.confirmRegistration){
	            	$('#regInfo').html('Вы успешно зарегистрировались').css({'color':'green', 'font-size':'20px', 'background-color':'white'});
	            	$('#inputLogin').val('');
	            	$('#inputPassword').val('');
	            	$('#inputRepeatPassword').val('');
	            	$('#inputEmail').val('');
	            	$("#rulesAgree").prop('checked',false);
	            	setTimeout(function(){
						$("#closeModal").click()
					}, 5000);
	            }
	        }
	    });
	});



	/*
	* авторизация
	*/
	$('#authorization').click(function(){
		var formData = $("#formAuthorization").serialize();
	    $.ajax({
	        type: "POST",
	        url: way+"_authorization.php",
	        data: formData,
	        success: function(data) {
	            //вывод ошибок
	            if(data != ''){
					$('#loginInfo').html(data).css({'display':'block'});
	            }else{
	            	$('#loginInfo').css({'display':'none'});
	            }
	        }
	    });
	});



	/*
	* СОЗДАНИЕ ЛОТА
	*/
	$('#createLot').click(function(){
		//var formData = $("#formCreateLot").serialize();
		// var image = $("#inputImage");
	 //    var dataimage = new FormData;
	    
	 //    dataimage.append('lot-image', image.prop('files')[0]);

	 //    $.ajax({
	 //        url: way+"_createlotsaveimg.php",
	 //        data: dataimage,
	 //        processData: false,
	 //        contentType: false,
	 //        type: "POST",
	 //        success: function (data) {	
	 //            $('#errorImage').html(data);
	 //        }
	 //    });
		
		var formData = new FormData(document.getElementById("formCreateLot"));
		formData.append('lot-image', $("#inputImage").prop('files')[0]);
		formData.append('inputLotName', $('#inputLotName').val());
		formData.append('inputStartPrice', $('#inputStartPrice').val());
    	formData.append('inputPrice', $('#inputPrice').val());
    	formData.append('inputDescription', $('#inputDescription').val());
    	formData.append('inputLocation', $('#inputLocation').val());
    	formData.append('inputDelivery', $('#inputDelivery').val());
    	formData.append('inputDateEnd', $('#inputDateEnd').val());
    	formData.append('select-subcategory', $('#select-subcategory').val());


		/*for (var pair of formData.entries())
		{
			console.log(pair); 
		}*/
		
	    $.ajax({
	        /*type: "POST",
	        url: way+"_createlot.php",
	        data: formData,
	        processData: false,
	        contentType: false,*/
	        url: way+'_createlot.php',
		    data: formData,
		    cache: false,
		    contentType: false,
		    processData: false,
		    type: 'POST',
	        success: function(data) {
	        	var error = jQuery.parseJSON(data);

	            //вывод ошибки название лота
	            if(error.lot_name != '' && error.lot_nameOk == false){
					$('#errorLotName').html(error.lot_name);
	            }else{
	            	$('#errorLotName').html('');
	            }

	            //вывод ошибки описания
	            if(error.description != '' && error.descriptionOk == false){
					$('#errorDescription').html(error.description);
	            }else{
	            	$('#errorDescription').html('');
	            }

	            //вывод ошибки мастонахождения
	            if(error.location != '' && error.locationOk == false){
					$('#errorLocation').html(error.location);
	            }else{
	            	$('#errorLocation').html('');
	            }

	            //вывод ошибки доставки
	            if(error.delivery != '' && error.deliveryOk == false){
					$('#errorDelivery').html(error.delivery);
	            }else{
	            	$('#errorDelivery').html('');
	            }

	            //вывод ошибки даты окончания
	            if(error.date_end != '' && error.date_endOk == false){
					$('#errorDateEnd').html(error.date_end);
	            }else{
	            	$('#errorDateEnd').html('');
	            }

	            //вывод ошибки категории
	            if(error.subcategory != '' && error.subcategoryOk == false){
					$('#errorSubcategory').html(error.subcategory);
	            }else{
	            	$('#errorSubcategory').html('');
	            }

	            //вывод ошибки цен
	            if(error.need_another_price != '' && error.need_another_priceOk == false){
	            	$('#errorStartPrice').html(error.need_another_price);
	            	$('#errorPrice').html(error.need_another_price);
	            }else{
	            	$('#errorStartPrice').html('');
	            	$('#errorPrice').html('');	           
	            }

				//вывод ошибки отрицательной начальной цены
				if(error.neg_start_price != '' && error.neg_start_priceOk == false){
					$('#errorStartPrice').html(error.neg_start_price);
				}

				//вывод ошибки отрицательной цены выкупа
				if(error.neg_price != '' && error.neg_priceOk == false){
					$('#errorPrice').html(error.neg_price);
				}

	            /* ошибка изображения */
	            if(error.image != '' && error.imageOk == false){
	            	$('#errorImage').html(error.image);
	            }else{
	            	$('#errorImage').html('');
	            }

	            if(error.createLot){
	            	$('#inputLotName').val('');
	            	$('#inputStartPrice').val('');
	            	$('#inputPrice').val('');
	            	$('#inputDescription').val('');
	            	$('#inputLocation').val('');
	            	$('#inputDelivery').val('');
	            	$('#inputDateEnd').val('');
	            	$('#select-category option:eq(0)').prop('selected',true);
	            	$('#select-subcategory option:eq(0)').prop('selected',true);
	            	$('.createLotInfo').removeClass('hide').html('Лот был успешно создан. Его можно просмотреть по данной <a href="../lot/index.php?id=' + error.id_now_create_lot + '">ссылке</a> или в личном кабинете.').css({'color':'lime'});
	            }
	        }
	    });
	});



	/*
	* сделать ставку
	*/
	$('#placeBet').click(function(){
		var formData = $("#formBet").serialize();
	    $.ajax({
	        type: "POST",
	        url: way+"_placebet.php",
	        data: formData,
	        success: function(data) {
	            //вывод ошибок
	            if(data == 'Ставка сделана'){
	            	$('#betInfo').html(data).css({'color':'green'});
	            	setTimeout(function(){
						location.reload();
					}, 1000);
	            }else{
	            	$('#betInfo').html(data).css({'color':'red'});
	            }
				
	        }
	    });
	});



	/*
	* добавление комментария
	*/
	$('#addComment').click(function(){
		var formData = $("#formComment").serialize();
	    $.ajax({
	        type: "POST",
	        url: way+"_addcomment.php",
	        data: formData,
	        success: function(data) {
	            //вывод ошибок
	            if(data == ''){
					location.reload();
	            }else{
	            	$('#infoComment').html(data).css({'color':'red'});
	            }
				
	        }
	    });
	});



	/*
	* покупка лота
	*/
	$('#buyLot').click(function(){
		var formData = $("#formBet").serialize();
	    $.ajax({
	        type: "POST",
	        url: way+"_buylot.php",
	        data: formData,
	        success: function(data) {
	            //вывод ошибок
	            if(data == ''){
					location.reload();
	            }else{
	            	$('#betInfo').html(data).css({'color':'red'});
	            }
				
	        }
	    });
	});



	/*
	* изменение пароля
	*/
	$('#GoChangePassword').click(function(){
		//var formData = $("#formChangePassword").serialize();
		var oldPassword = $('#inputOldPassword').val();
		var newPassword1 = $('#inputNewPassword1').val();
		var newPassword2 = $('#inputNewPassword2').val();

	    $.ajax({
	        type: "POST",
	        url: way+"cabinet/_changepassword.php",
	        data: {
	        	'oldPassword':oldPassword,
	        	'newPassword1':newPassword1,
	        	'newPassword2':newPassword2
	        },
	        success: function(data) {
				//console.log(data);
	        	var error = jQuery.parseJSON(data);
				
	            // ошибки старого пароля
	            if(error.oldpass != ''){
					$('#errorOldPassword').html(error.oldpass);
	            }else{
	            	$('#errorOldPassword').html('');
	            }

	            // ошибки нового пароля
	            if(error.newpass1 != ''){
	            	$('#errorNewPassword1').html(error.newpass1);
	            }else{
	            	$('#errorNewPassword1').html('');
	            }

	            // ошибки повторения пароля
	            if(error.newpass2 != ''){
	            	$('#errorNewPassword2').html(error.newpass2);
	            }else{
	            	$('#errorNewPassword2').html('');
	            }

	            // если все ок
	            if(error.change_ok){
	            	$('#infoChangePassword').html('Пароль успешно изменен').css({'color':'lime', 'font-weight':'bold'}).addClass('h5');
	            	$('#inputOldPassword').val('');
	            	$('#inputNewPassword1').val('');
	            	$('#inputNewPassword2').val('');
	            }
	        }
	    });
	});



	/*
	* сохранение настроек
	*/
	$('#changeSettings').click(function(){
		var formData = new FormData(document.getElementById("formMainSettings"));
		formData.append('user-image', $("#inputAvatar").prop('files')[0]);
		formData.append('country', $('#inputCountry').val());
		formData.append('city', $('#inputCity').val());
		formData.append('moreInfo', $('#inputMoreInfo').val());

		/*for (var pair of formData.entries())
		{
			console.log(pair); 
		}*/

	    $.ajax({
	        url: way+'cabinet/_changesettings.php',
		    data: formData,
		    cache: false,
		    contentType: false,
		    processData: false,
		    type: 'POST',
	        success: function(data) {
	        	//var ddata = jQuery.parseJSON(data);
	        	if(data == 'true'){
	        		$('#infoChangeMainSettings').show().html('Настройки сохранены').css({'color':'lime', 'font-weight':'bold'}).addClass('h4').fadeOut(3000);
	        		setTimeout(function() { location.reload(true); }, 3000);
	        	}else{
	        		$('#infoChangeMainSettings').show().html('Нечего сохранять').css({'color':'red', 'font-weight':'bold'}).addClass('h4').fadeOut(3000);
	        	}
	        }
	    });
	});



	$('#goSearch').click(function(){
		window.location.href = way+"lot/index.php?search=" + $('#inputSearch').val() + "&category=" + $('#selectCategory').val();
	});

	document.getElementById('inputSearch').addEventListener('keypress', function(event) {
        if (event.key === 'Enter') {
			event.preventDefault();
			$('#goSearch').click();
			return false;
        }
    });

	$(".category-ul").hide();

	$(".category-head").click(function(){
		var ch = $(this);
		ch.next().slideToggle();
		if(ch.find(".triangleRotate").hasClass("triangleClose")){
			ch.find(".triangleRotate").removeClass("triangleClose").addClass("triangleOpen");
		}else{
			ch.find(".triangleRotate").removeClass("triangleOpen").addClass("triangleClose");
		}
	});	

	var result=$('#rulesAgree').prop('checked');

	function checkboxValidate(){
		if($('#rulesAgree').prop('checked')){
			$('#registration').prop('disabled', false);
		}else{
			$('#registration').prop('disabled', true);
		};
	};

	$('#rulesAgree').click(function(){
		checkboxValidate();
	});	


	//help li, help content
	/*var help_li = ['', , '#how_buy', '#how_sell', '#about_reg'];
	var help_content = ['', '#content_how_buy', '#content_how_sell', '#content_reg'];

	function hideHelpContent($first){
		for(var i = 1; i < help_content.length; i++){
			if($first == true){
				if(i != 1){ $(help_content[i]).hide(); }	
			}else{
				$(help_content[i]).hide();
			}
			
		}	
	};

	$('.menu_help li').click(function(){
		$('.menu_help li').removeClass('active_li');
		$(this).addClass('active_li');
		

		switch($('.menu_help li').index($(this))){
			case $('.menu_help li').index($(this)):
				hideHelpContent();
				$(help_content[$('.menu_help li').index($(this))]).show();
				break;
		}
	});*/

	/* переключение в помощи */
	$('#content_how_sell, #content_reg').hide();
	$('#how_buy').click(function(){
		$('#content_how_sell, #content_reg').hide();
		$('#how_sell, #about_reg').removeClass('active_li');
		$('#content_how_buy').show();
		$(this).addClass('active_li');
	});
	$('#how_sell').click(function(){
		$('#content_how_buy, #content_reg').hide();
		$('#how_buy, #about_reg').removeClass('active_li');
		$('#content_how_sell').show();
		$(this).addClass('active_li');
	});
	$('#about_reg').click(function(){
		$('#content_how_buy, #content_how_sell').hide();
		$('#how_buy, #how_sell').removeClass('active_li');
		$('#content_reg').show();
		$(this).addClass('active_li');
	});


	$('#select-category').change(function(){
		var i=0;
    	$('#select-subcategory option').each(function(){
			$(this).removeClass('hide');
			var explode = $('#select-subcategory option:eq(' + i + ')').val().split('-');
			if(explode[0] != $('#select-category').val()){
				$(this).addClass('hide');
			}
			//console.log(i + ', ' + $(this).val() + ', ' + explode[0] + ', ' + $('#select-category').val());
			i++;	 
    	});
	});

	$('#nav-bets').click(function(){
		$(this).addClass('active');
		$('#nav-comments').removeClass('active');
		$('.bets-content').removeClass('hide');
		$('.comment-content').addClass('hide');
	});

	$('#nav-comments').click(function(){
		$(this).addClass('active');
		$('#nav-bets').removeClass('active');
		$('.comment-content').removeClass('hide');
		$('.bets-content').addClass('hide');
	});

	/* переход на диалог с определенным пользователем */
	$('.dialog').each(function() { 
		$(this).on('click', function() { 
			/*var formData = $("#formSetReadMsg"+$(this).attr('id')).serialize();
		    $.ajax({
		        type: "POST",
		        url: way+"cabinet/_setreadmsg.php",
		        data: formData,
		        success: function(data) {
		        	window.location.replace("index.php?nav=msg&id="+data);
		        }
		    });*/
		    window.location.replace("index.php?nav=msg&id="+$(this).attr('id'));
		});
	});

	/*
	* отправка личного сообщения
	*/
	$('#submitMessage').click(function(){
		var formData = $("#formMessage").serialize();
	    $.ajax({
	        type: "POST",
	        url: way+"cabinet/_addmessage.php",
	        data: formData,
	        success: function(data) {
	        	if(data == '')
	        	{
	        		location.reload();
	        	}else{
					$('.errorMessage').html(data).css({'color':'red'});
	        	}
	            
	        }
	    });
	});

	/* переход со ставки на лот */
	$('.activebet').each(function(){
		$(this).on('click', function(){
			window.location.replace("../lot/index.php?id="+$(this).attr('id'));
		});
	});

	/* переход с моих активных лотов на нужный лот */
	$('.activelot').each(function(){
		$(this).on('click', function(){
			window.location.replace("../lot/index.php?id="+$(this).attr('id'));
		});
	});

	/* переход с проданных лотов (победитель) на сообщения */
	$('.soldlot_user').each(function(){
		$(this).on('click', function(){
			window.location.replace("../cabinet/index.php?nav=msg&id="+$(this).attr('id'));
		});
	});

	/* переход с проданных лотов (лот) на сообщения */
	$('.soldlot_name').each(function(){
		$(this).on('click', function(){
			window.location.replace("../lot/index.php?id="+$(this).attr('id'));
		});
	});

	/* переход с непроданных лотов на лот */
	$('.unsoldlot').each(function(){
		$(this).on('click', function(){
			window.location.replace("../lot/index.php?id="+$(this).attr('id'));
		});
	});

	/* переключение в тех. поддержке */
	$('#startQuestion').click(function(){
		$('.content_myQuestion').hide();
		$('#myQuestion').css({"background": "none", "color": "black"});
		$('.content_startQuestion').show();
		$(this).css({"background": "#17a2b8", "color": "white"});
	});
	$('#myQuestion').click(function(){
		$('.content_startQuestion').hide();
		$('#startQuestion').css({"background": "none", "color": "black"});
		$('.content_myQuestion').show();
		$(this).css({"background": "#17a2b8", "color": "white"});
	});

	/*
	* добавление вопроса
	*/
	$('#sendQuestion').click(function(){
		var formData = new FormData(document.getElementById("formQuestion"));
		//formData.append('questionImage', $("#inputFile").prop('files')[0]);
		formData.append('question_head', $('#question_head').val());
		formData.append('priority', $('#priority').val());
    	formData.append('question', $('#question').val());

	    $.ajax({
	        url: way+"support/_addquestion.php",
		    data: formData,
		    cache: false,
		    contentType: false,
		    processData: false,
		    type: 'POST',
	        success: function(data) {
				
	        	var error = jQuery.parseJSON(data);

	        	/* вывод ошибки темы */
	            if(error.title != '' && error.titleOk == false){
					$('#errorQuestion_head').html(error.title);
	            }else{
	            	$('#errorQuestion_head').html('');
	            }

	            /* вывод ошибки вопроса */
	            if(error.question != '' && error.questionOk == false){
	            	$('#errorQuestion').html(error.question);
	            }else{
	            	$('#errorQuestion').html('');
	            }

	            /*if(error.questionImage != '' && error.questionImageOk == false){
	            	$('#errorQuestionFile').html(error.questionImage);
	            }else{
	            	$('#errorQuestionFile').html('');
	            }*/

	            if(error.auth != ''){
	        		$('#infoQuestion').html(error.auth).css({'color':'red', 'font-weight':'bold'});
	        	}

	            if(error.createQuestion){
	            	$('#question_head').val('');
	            	$('#question').val('');
	            	$('#prority option:eq(0)').prop('selected',true);
	            	$('#infoQuestion').html('Вопрос отправлен').css({'color':'green', 'font-weight':'bold'});
	            	setTimeout(function(){
						location.reload();
					}, 2000);
	            }
	        }
	    });
	});

	/* переход со всех сообщений к контретному */
	$('.table-question tbody tr').each(function(){
		$(this).on('click', function(){
			window.location.replace("../support/?question="+$(this).attr('id'));
		});
	});

	/* переход с выигранных ставок к лоту */
	$('.winbet_lotname').each(function(){
		$(this).on('click', function(){
			window.location.replace("../lot/index.php?id="+$(this).attr('id'));
		});
	});

	/* переход с выигранной ставки к диалогу с пользователем */
	$('.winbet_user').each(function(){
		$(this).on('click', function(){
			window.location.replace("../cabinet/index.php?nav=msg&id="+$(this).attr('id'));
		});
	});
});