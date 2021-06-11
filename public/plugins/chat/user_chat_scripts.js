$(document).ready(function(){
	//if click on send
	$("#my__chat__box span.send_btn").on("click", function(){
		sendMsg();
	})
})


var isSending = false
function sendMsg(){
	let msg = $("#my__chat__box textarea[name='composer']").val()
	let ticket_id = $("#my__chat__box input[name='ticket_id']").val()
	let token = $('meta[name="csrf-token"]').attr('content')

	//check messsage
	if (msg === '') {
		return;
	}

	//check ticket id
	if (ticket_id == '') {
		alert("Invalid Request | Missing Ticket ID")
		return
	}

	//if server busy then
	if (isSending === true) {
		return;
	}


	$.ajax({
			url: "/customer/sendMsg",
			data: {msg:msg, _token:token, ticket_id:ticket_id},
			method: "POST",
			dataType: 'HTML',
			cache: false,
			beforeSend:function(){
				isSending = true
			},
			success: function(response){
				isSending = false
				$("#my__chat__box textarea[name='composer']").val('')
				$("#my__chat__box #my-messages-box").html(response)
				
				$('#my__chat__box .msg_card_body').stop ().animate ({
			   	  scrollTop: $('#my__chat__box .msg_card_body')[0].scrollHeight
			   	});
			},
			error: function (jqXHR, textStatus, errorThrown) {
				isSending = false

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
					  text: "Something went wrong, please refresh the page and try again...",
					  footer: ''
					})
                }

            },
            complete:function(){
            	isSending = false
            }
        });
}