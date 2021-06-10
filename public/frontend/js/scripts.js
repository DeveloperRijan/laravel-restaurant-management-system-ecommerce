$(document).ready(function(){
	getCartTotalItems();


	//show login/register form
	$("body").on("click", "a.topSignInSignUpLink", function(e){
		e.preventDefault()
		$("div#loginRegisterModal").modal("show")
	})

	$("body").on("click", "._showLoginModal", function(e){
		e.preventDefault()
		$("div#loginRegisterModal").modal("show")
		Swal.fire({
		  icon: 'info',
		  title: 'SORRY',
		  text: "Please signin or singup to perform the action",
		  footer: ""
		});
	})

	$("body").on("click", "button.loginModalCloseBTN", function(e){
		e.preventDefault()
		$("div#loginRegisterModal").modal("hide")
	})



	//if click on order now then
	$("body").on("click", ".order_now_btn", function(){
		let item_id = $(this).attr('item_id')
		let item_pic = $(this).attr('item_pic')
		let item_title = $(this).attr('item_title')
		let item_price = $(this).attr('item_price')

		$("#orderNowModal form input[name='itemID']").val(item_id);
		$("#orderNowModal img.setItemImage").attr('src', item_pic);
		$("#orderNowModal form td.setTitleVal").html(item_title);
		$("#orderNowModal form td.setPriceVal span").html(item_price);

		$("#orderNowModal").modal("show")
	});



	//if clicked on add to cart then
	$("body").on("click", ".addToCart", function(e){
		e.preventDefault();
		let productID = $(this).attr("item_id");

		if (!productID || productID == '') {
			Swal.fire({
			  icon: 'info',
			  title: 'SORRY',
			  text: "Invalid item value ! please refresh the page and try again.",
			  footer: ""
			});
			return;
		}

		//send to server
		let csrf = $('meta[name="csrf-token"]').attr('content')
		$.ajax({
			url: "/cart/add",
			data: {"_token":csrf, "productID":productID},
			method: "POST",
			dataType: 'JSON',
			cache: false,
			beforeSend:function(){
				$(this).attr('disabled', true)
			},
			success: function(response){
				$(this).attr('disabled', false)

				Swal.fire({
				  icon: 'success',
				  title: 'Success',
				  text: response,
				  footer: ''
				})
				getCartTotalItems();
									
			},
			error: function (jqXHR, textStatus, errorThrown) {
				$(this).attr('disabled', false)

				let string_to_obj = JSON.parse(jqXHR.responseText)

				if (jqXHR.status === 422) {
                  	
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
            	$(this).attr('disabled', false)
            }
        });
	})

	//if clicked on heart then like the item
	$("body").on("click", ".loveThisItem", function(e){
		e.preventDefault();
		let productID = $(this).attr("item_id");

		if (!productID || productID == '') {
			Swal.fire({
			  icon: 'info',
			  title: 'SORRY',
			  text: "Invalid item value ! please refresh the page and try again.",
			  footer: ""
			});
			getCartTotalItems();
			return;
		}

		//send to server
		let csrf = $('meta[name="csrf-token"]').attr('content')
		$.ajax({
			url: "/feedback",
			data: {"_token":csrf, "productID":productID},
			method: "POST",
			dataType: 'JSON',
			cache: false,
			beforeSend:function(){
				$(this).attr('disabled', true)
			},
			success: function(response){
				$(this).attr('disabled', false)

				Swal.fire({
				  icon: 'success',
				  title: 'You Liked',
				  text: response,
				  footer: ''
				})
									
			},
			error: function (jqXHR, textStatus, errorThrown) {
				$(this).attr('disabled', false)

				let string_to_obj = JSON.parse(jqXHR.responseText)

				if (jqXHR.status === 422) {
                  	
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
            	$(this).attr('disabled', false)
            }
        });

	})



	//load product deatils - init modal
	$("body").on("click", "div.food_box", function(){
		let productID = $(this).attr('item_id')
		let type = $(this).attr('type')
		loadProductDetails(productID, type)
	})

});

//load item details
var loadingDataState = false
function loadProductDetails(productID, type){
	//console.log(productID)
	//console.log(type)
	
	if (loadingDataState === true) {
		return
	}

	if (productID === '' || type === '') {
		Swal.fire({
		  icon: 'info',
		  title: 'SORRY',
		  text: "Invalid request - please refresh the page and try again!",
		  footer: ""
		});
		return
	}

	$.ajax({
		url: "/load_product_details?product_id="+productID+"&type="+type,
		method: "GET",
		dataType: 'HTML',
		cache: false,
		beforeSend:function(){
			loadingDataState = true
		},
		success: function(response){
			loadingDataState = false
			$("div#loadDynamicProductDetailsHTML").html(response)
			$("div#productDetailsModal__").modal("show")
		},
		error: function (jqXHR, textStatus, errorThrown) {
			$(this).attr('disabled', false)
			loadingDataState = false

			let string_to_obj = JSON.parse(jqXHR.responseText)

			if (jqXHR.status === 422) {
              	
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
        	loadingDataState = false
        }
    });
}




//control signin/signup sections
function showSignInForm(e){
	e.preventDefault()
	$("#loginRegisterModal section.signup").hide()
	$("#loginRegisterModal section.sign-in").show()
}
function showSignUpForm(e){
	e.preventDefault()
	$("#loginRegisterModal section.signup").show()
	$("#loginRegisterModal section.sign-in").hide()
}



//get cart items
function getCartTotalItems(){
	$.ajax({
		url: "/cart-items?type=totalItems",
		method: "GET",
		dataType: 'JSON',
		cache: false,
		success: function(response){
			$(".cart_item_count").html(response.data)		
		},
		error: function (jqXHR, textStatus, errorThrown) {

			let string_to_obj = JSON.parse(jqXHR.responseText)

			if (jqXHR.status === 422) {
				console.log(string_to_obj.msg)
	        }else{
	        	console.log("Something went wrong")
	        }

	    }
	});
}



//control qty in modal
$("#loadDynamicProductDetailsHTML").on("click", "button.increase", function(){
	let sellingPrice = $("#loadDynamicProductDetailsHTML input[name='selling_price']").val()
	let qty = $("#loadDynamicProductDetailsHTML input[name='qty']").val()
	qty = parseInt(qty) + 1

	$("#loadDynamicProductDetailsHTML .qty-control input[name='qty']").val(qty)
	$("#loadDynamicProductDetailsHTML .qty-val").html(qty)

	sellingPrice = (parseFloat(sellingPrice).toFixed(2)) * qty
	sellingPrice = (parseFloat(sellingPrice).toFixed(2))
	$("#loadDynamicProductDetailsHTML .inner-selling-price").html(sellingPrice)
})

$("#loadDynamicProductDetailsHTML").on("click", "button.decrease", function(){
	let sellingPrice = $("#loadDynamicProductDetailsHTML input[name='selling_price']").val()
	let qty = $("#loadDynamicProductDetailsHTML input[name='qty']").val()
	qty = parseInt(qty)

	if (qty === 1) {
		return;
	}

	qty = qty - 1

	$("#loadDynamicProductDetailsHTML .qty-control input[name='qty']").val(qty)
	$("#loadDynamicProductDetailsHTML .qty-val").html(qty)

	sellingPrice = (parseFloat(sellingPrice).toFixed(2)) * qty
	sellingPrice = (parseFloat(sellingPrice).toFixed(2))
	$("#loadDynamicProductDetailsHTML .inner-selling-price").html(sellingPrice)
})