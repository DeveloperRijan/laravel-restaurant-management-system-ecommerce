var ticketID = null;
var ticketStatus = null;

$(document).ready(function(){
	//get messages
	liveGetChatContacts()

	//if click on any contact then init msg
	$("#my__chat__box #chatContactList").on("click", "li.single-contact", function(){
		if (ticketID == $(this).attr("ticket_id")) {
			//its currenty active, so no need of sending new request...
			return
		}

		ticketID = $(this).attr("ticket_id")
		ticketStatus = $(this).attr("ticket_status")
		ticketSubject = $(this).attr("ticket_subject")
		userName = $(this).attr("user_name")

		$("#my__chat__box #chatContactList li.single-contact").removeClass('active')
		$(this).addClass("active")

		$("#my__chat__box #setActiveChatUserName").html(userName)
		$("#my__chat__box #setActiveChatSubject").html(ticketSubject)
		liveGetMessages()

		//set calling for every 5 seconds
		if (ticketStatus === "Open") {
			setInterval(function() {
	          liveGetMessages()
	        }, 5000);
		}
	})

	//liveGetMessages()

	//if click on send
	$("#my__chat__box span.send_btn").on("click", function(){
		sendMsg();
	})
})


var isSending = false
function sendMsg(){
	if (ticketID == '') {
		alert("Please select a contact")
		return
	}
	if (ticketStatus !== "Open") {
		alert("The ticket is "+ticketStatus+", so you can't sent any message more....")
	}

	let msg = $("#my__chat__box textarea[name='composer']").val()

	let token = $('meta[name="csrf-token"]').attr('content')

	//check messsage
	if (msg === '') {
		return;
	}


	//if server busy then
	if (isSending === true) {
		return;
	}


	$.ajax({
			url: "/kitchen-staff/sendMsg",
			data: {msg:msg, _token:token, ticket_id:ticketID},
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



//update messages
isGettingMsg = false
function liveGetMessages(){
	if (isGettingMsg === true) {
		//gettting current request messages... so server is busy
		return
	}

	$.ajax({
		url: "/kitchen-staff/getMessages",
		data: {ticket_id:ticketID},
		method: "GET",
		dataType: 'HTML',
		cache: false,
		beforeSend:function(){
			isGettingMsg = true
		},
		success: function(response){
			isGettingMsg = false
			$("#my__chat__box #my-messages-box").html(response)

			$('#my__chat__box .msg_card_body').stop ().animate ({
		   	  scrollTop: $('#my__chat__box .msg_card_body')[0].scrollHeight
		   	});
		},
		error: function (jqXHR, textStatus, errorThrown) {
			isGettingMsg = false

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
        	isGettingMsg = false
        }
    });
}




//get chat contacts
function liveGetChatContacts(){
	//let ticket_id = $("#my__chat__box input[name='ticket_id']").val()

	$.ajax({
		url: "/kitchen-staff/getChatContacts",
		method: "GET",
		dataType: 'HTML',
		cache: false,
		success: function(response){
			$("#my__chat__box ul#chatContactList").html(response)
		},
		error: function (jqXHR, textStatus, errorThrown) {

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

        }
    });
}