$(document).ready(function(){
	//handle qty numbers
	$("tbody#checkout-render").on('click', ".btnIncreaseQTY", function(){
		let cartID = $(this).attr('cartid')

		//lets update the qty
		updateQtyToServer(cartID, 'Increase');
	})

	$("tbody#checkout-render").on('click', ".btnDecreaseQTY", function(){
		let cartID = $(this).attr('cartid')
		updateQtyToServer(cartID, 'Decrease');
	})


	//update qty to server
	function updateQtyToServer(cartID, type){
		$.ajax({
			url: "/cart/update-qty",
			data: {cart_id:cartID, type:type},
			method: 'GET',
			dataType: 'HTML',
			cache: false,
			beforeSend:function(){
				$("#form__processing__gif").show()
			},
			success: function(response){
				$("#form__processing__gif").hide()
				$("tbody#checkout-render").html(response)
			},
			error: function (jqXHR, textStatus, errorThrown) {
			  $("#form__processing__gif").hide()
              	if (jqXHR.status === 422) {
                	console.log("Quantity can't be less than 1")
                  	
                }else{                  	
                  	alert('something went wrong...')
                }
            },
            complete:function(){
            	$("#form__processing__gif").hide()
            }
		});
	}


	//remove product from cart
	$(".removeFromCart_btn").on("click", function(){
		let cartID = $(this).attr('cartid')
		let productID = $(this).attr('productid')
		remove_from_cart(cartID, productID)
	})

	


	//remove_from_cart
	function remove_from_cart(cartID, productID){
		$.ajax({
			url: "/remove-product-from-cart/"+cartID+"/"+productID,
			method: "GET",
			dataType: 'JSON',
			cache: false,
			success: function(response){
				$("#custom_toast_noti_success .setText").html(response)
				$("#custom_toast_noti_success").show()
				
				setTimeout(function(){ 
					$("#custom_toast_noti_success").hide()
					window.location.reload(true)
				 }, 1500);
			},
			error: function (jqXHR, textStatus, errorThrown) {
                if (jqXHR.status === 422) {
                	console.log('getting 422 code in product removing from the cart')
                  	
                }else{                  	
                  	alert('something went wrong...')
                  	window.location.reload(true)
                }

            }
        });
	}



	//coupon code apply
	$("tbody#checkout-render").on('click', "button#apply_coupon_code_btn", function(e){
		e.preventDefault();
		let coupon_code = $("input[name='coupon_code']").val()
		
		if (coupon_code === '') {
			return;
		}

		$.ajax({
			url: "/checkout?coupon_code="+coupon_code,
			method: "GET",
			dataType: 'HTML',
			cache: false,
			beforeSend:function(){
				$("#form__processing__gif").show()
			},
			success: function(response){
				$("#form__processing__gif").hide()
				$("tbody#checkout-render").html(response)
				console.log("coupon_applied")
			},
			error: function (jqXHR, textStatus, errorThrown) {
				$("#form__processing__gif").hide()
              	alert("Something wrong")
            },
            complete:function(){
            	$("#form__processing__gif").hide()
            }
		});

	});
})



$("body").on("click", ".removeCartItem", function(){
	let cartID = $(this).attr("cartid")
	if (cartID === '') {
		alert("Invalid Data Attribute")
		window.location.reload(true)
		return;
	}

	//delete the item
	$.ajax({
		url: "/checkout?removeItem="+cartID,
		method: "GET",
		dataType: 'HTML',
		cache: false,
		beforeSend:function(){
			$("#form__processing__gif").show()
		},
		success: function(response){
			$("#form__processing__gif").hide()
			$("tbody#checkout-render").html(response)
			console.log("coupon_applied")
		},
		error: function (jqXHR, textStatus, errorThrown) {
			$("#form__processing__gif").hide()
          	alert("Something wrong")
        },
        complete:function(){
        	$("#form__processing__gif").hide()
        }
	});
})





