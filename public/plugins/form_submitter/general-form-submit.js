/*
@author			: DeveloperRijan
@DevelopedBy	: DeveloperRijan
@contact		: DeveloperRijan@gmail.com
@web			: gooRgoo.com
*/

function formSubmitWithFile(formID, url, type){
		$.ajax({
			url: url,
			data: new FormData(document.getElementById(formID)),
			method: type,
			dataType: 'JSON',
			contentType: false,
			cache: false,
			processData:false,
			beforeSend:function(){
				$("#"+formID +" button[type=submit]").attr('disabled', true)
				$("#form__processing__gif").show()
			},
			success: function(response){
				$("#"+formID +" button[type=submit]").attr('disabled', false)
				$("#form__processing__gif").hide()
				//console.log(response.data.html_content)
				if (response.success === true) {
					if (response.data.html_content === false) {
						Swal.fire({
						  icon: 'success',
						  title: 'Success',
						  text: response.msg,
						  footer: ''
						}).then(response=>{
							window.location.reload(true)
						})

					}else{
						Swal.fire({
						  icon: 'success',
						  title: 'Success',
						  text: response.msg,
						  footer: response.data.html_content
						}).then(response=>{
							window.location.reload(true)
						})
					}

				}else{
					Swal.fire({
					  icon: 'info',
					  title: 'Something went wrong',
					  text: response.msg,
					  footer: ''
					}).then(response=>{
						//window.location.reload(true)
					})
				}
									
			},
			error: function (jqXHR, textStatus, errorThrown) {
				$("#"+formID +" button[type=submit]").attr('disabled', false)
				$("#form__processing__gif").hide()
				let string_to_obj = JSON.parse(jqXHR.responseText)

				if (jqXHR.status === 422) {
                  	
                  	Swal.fire({
					  icon: 'info',
					  title: 'SORRY',
					  text: string_to_obj.msg,
					  footer: ''
					})

                }else if (jqXHR.status === 500) {					
					Swal.fire({
					  icon: 'info',
					  title: 'SORRY',
					  text: string_to_obj.msg,
					  footer: ''
					})
					.then(response=>{
						//window.location.reload(true)
					})
                }else if (jqXHR.status === 404) {
                  	Swal.fire({
					  icon: 'info',
					  title: 'SORRY',
					  text: string_to_obj.msg,
					  footer: ''
					})
                }else{
                  	Swal.fire({
					  icon: 'info',
					  title: 'SORRY',
					  text: "Something went wrong.",
					  footer: ''
					})
                }

            },
            complete:function(){
            	$("#"+formID +" button[type=submit]").attr('disabled', false)
            	$("#form__processing__gif").hide()
            }
        });
}



function formSubmitWithoutFile(formID, url, type, formData){
		$.ajax({
			url: url,
			data: formData,
			method: type,
			dataType: 'JSON',
			cache: false,
			beforeSend:function(){
				$("#"+formID +" button[type=submit]").attr('disabled', true)
				$("#form__processing__gif").show()
			},
			success: function(response){
				$("#"+formID +" button[type=submit]").attr('disabled', false)
				$("#form__processing__gif").hide()

				if (response.success === true) {
					if (response.data.html_content === false) {
						Swal.fire({
						  icon: 'success',
						  title: 'Success',
						  text: response.msg,
						  footer: ''
						}).then(response=>{
							window.location.reload(true)
						})

					}else{
						Swal.fire({
						  icon: 'success',
						  title: 'Success',
						  text: response.msg,
						  footer: response.data.html_content
						}).then(response=>{
							window.location.reload(true)
						})
					}

				}else{
					Swal.fire({
					  icon: 'info',
					  title: 'Something went wrong',
					  text: response.msg,
					  footer: ''
					}).then(response=>{
						//window.location.reload(true)
					})
				}
									
			},
			error: function (jqXHR, textStatus, errorThrown) {
				$("#"+formID +" button[type=submit]").attr('disabled', false)
				$("#form__processing__gif").hide()
				let string_to_obj = JSON.parse(jqXHR.responseText)

				if (jqXHR.status === 422) {
                  	Swal.fire({
					  icon: 'info',
					  title: 'SORRY',
					  text: string_to_obj.msg,
					  footer: ''
					})

                }else if (jqXHR.status === 500) {					
					Swal.fire({
					  icon: 'info',
					  title: 'SORRY',
					  text: string_to_obj.msg,
					  footer: ''
					})
					.then(response=>{
						//window.location.reload(true)
					})
                }else if (jqXHR.status === 404) {
                  	Swal.fire({
					  icon: 'info',
					  title: 'SORRY',
					  text: string_to_obj.msg,
					  footer: ''
					})
                }else{
                  	Swal.fire({
					  icon: 'info',
					  title: 'SORRY',
					  text: "Something went wrong.",
					  footer: ''
					})
                }

            },
            complete:function(){
            	$("#"+formID +" button[type=submit]").attr('disabled', false)
            	$("#form__processing__gif").hide()
            }
        });
}



//form submit without file and then reload false
function formSubmitWithoutFile_noReload(formID, url, type, formData){
		$.ajax({
			url: url,
			data: formData,
			method: type,
			dataType: 'JSON',
			cache: false,
			beforeSend:function(){
				$("#"+formID +" button[type=submit]").attr('disabled', true)
				$("#form__processing__gif").show()
			},
			success: function(response){
				$("#"+formID +" button[type=submit]").attr('disabled', false)
				$("#form__processing__gif").hide()

				if (response.success === true) {
					if (response.data.html_content === false) {
						Swal.fire({
						  icon: 'success',
						  title: 'Success',
						  text: response.msg,
						  footer: ''
						})

					}else{
						Swal.fire({
						  icon: 'success',
						  title: 'Success',
						  text: response.msg,
						  footer: response.data.html_content
						})
					}

				}else{
					Swal.fire({
					  icon: 'info',
					  title: 'Something went wrong',
					  text: response.msg,
					  footer: ''
					})
				}
									
			},
			error: function (jqXHR, textStatus, errorThrown) {
				$("#"+formID +" button[type=submit]").attr('disabled', false)
				$("#form__processing__gif").hide()
				let string_to_obj = JSON.parse(jqXHR.responseText)

				if (jqXHR.status === 422) {
                  	Swal.fire({
					  icon: 'info',
					  title: 'SORRY',
					  text: string_to_obj.msg,
					  footer: ''
					})

                }else if (jqXHR.status === 500) {					
					Swal.fire({
					  icon: 'info',
					  title: 'SORRY',
					  text: string_to_obj.msg,
					  footer: ''
					})
                }else if (jqXHR.status === 404) {
                  	Swal.fire({
					  icon: 'info',
					  title: 'SORRY',
					  text: string_to_obj.msg,
					  footer: ''
					})
                }else{
                  	Swal.fire({
					  icon: 'info',
					  title: 'SORRY',
					  text: "Something went wrong.",
					  footer: ''
					})
                }

            },
            complete:function(){
            	$("#"+formID +" button[type=submit]").attr('disabled', false)
            	$("#form__processing__gif").hide()
            }
        });
}



function formClientSideValidation(event, formID, needScrolling){
	let formPass = true;
	let scrollUpToFieldName = "";

	if ($("#"+formID+" [is-required]").length) {
			$("#"+formID+" [is-required]").each(function(){
				if (!$(this).val()) {
					event.preventDefault()
					formPass = false;					
					scrollUpToFieldName = $(this).attr('name')
						          		
	          		$(this).addClass('border-danger-alert');
	          		$(this).siblings('.place-error--msg').html("This field is required.");
				}
		})

		if (formPass === false) {
			if (needScrolling === "yes") {
				if ($("textarea[name="+scrollUpToFieldName+"]").length) {
					$('html, body').animate({
		                    scrollTop: $("textarea[name="+scrollUpToFieldName+"]").offset().top
		             }, 1000);
				}

				if ($("input[name="+scrollUpToFieldName+"]").length) {
					$('html, body').animate({
		                    scrollTop: $("input[name="+scrollUpToFieldName+"]").offset().top
		             }, 1000);
				}

				if ($("select[name="+scrollUpToFieldName+"]").length) {
					$('html, body').animate({
		                    scrollTop: $("select[name="+scrollUpToFieldName+"]").offset().top
		             }, 1000);
				}
	  			
	  		}
	  		return;
		}
	}
	

	//finally submit the form
	$("#"+formID).submit()
}


//remove form validation error
function removeErrorLevels(getThis, type){
	if (type === "input") {
		getThis.removeClass('border-danger-alert')
		getThis.siblings('.place-error--msg').html('')
		return;
	}

	if (type === "id__") {
		getThis.removeClass('border-danger-alert')
		getThis.siblings('.place-error--msg').html('')
		return;
	}
	console.log('yes outside')
	
}



