$("#loadDynamicProductDetailsHTML").on("click", ".product-options-block input[type=checkbox]", function(){
	let option_type = $(this).attr('option_type')
	let getClassName = $(this).attr('class')
	let extraCharge = $(this).attr('ec')

	

	let selectedID = ''
	if ($(this).prop('checked') === true) {
		$(this).prop('checked', true)
		//add charge amount
		if (extraCharge !== '') {
			let currentSum = $("#loadDynamicProductDetailsHTML span.inner-selling-price").html()
			total = parseFloat(currentSum) + parseFloat(extraCharge)
			total = parseFloat(total).toFixed(2)
			$("#loadDynamicProductDetailsHTML .inner-selling-price").html(total)
		}
		selectedID = $(this).attr('id')
	}else{
		$("#loadDynamicProductDetailsHTML .product-options-block input."+getClassName).attr('checked', false)
		//check if has extra charge then
		if ($(this).attr('ec') !== '') {
			let currentSum = $("#loadDynamicProductDetailsHTML span.inner-selling-price").html()
			currentSum = parseFloat(currentSum) - parseFloat($(this).attr('ec'))
			total = parseFloat(currentSum).toFixed(2)
			$("#loadDynamicProductDetailsHTML .inner-selling-price").html(total)
		}
		
	}


	if (option_type === "Single") {
		//dselect all except selected one
		$(".product-options-block input."+getClassName).each(function(){
			if ($(this).attr('id') !== selectedID) {
				if($(this).prop('checked') === true){
					//already checked, so check if charge added, then remove
					if ($(this).attr('ec') !== '') {
						let currentSum = $("#loadDynamicProductDetailsHTML span.inner-selling-price").html()
						currentSum = parseFloat(currentSum) - parseFloat($(this).attr('ec'))
						total = parseFloat(currentSum).toFixed(2)
						$("#loadDynamicProductDetailsHTML .inner-selling-price").html(total)
					}
				}
				$(this).prop('checked', false)
			}
		})
	}

})