<div class="option-single-row form-group">
  <div class="row">

    <div class="col-lg-12 col-md-12">
      <table class="table">
        <tbody id="append_options_data">

        	
        </tbody>
      </table>
    </div>

  </div>
</div>


@push("scripts")
<script type="text/javascript">
	var option_row_counter = 0;
	var option_field_counter = 0;

	//if click on button then
	$("button#add_options_btn").on("click", function(){
		//add new option
		let html = 
				"<tr id='options_row_id_"+option_row_counter+"'>"+
					"<td>"+
						"<table class='table' id='options_tbl_id_"+option_row_counter+"' style='background:#efefef'>"+
	        				"<tr class='text-right'>"+
				        		"<td colspan='2'>"+
				        			"<div class='d-flex justify-content-between'>"+
				        				"<div>("+ (option_row_counter+1) +")</div>"+
				        				"<button type='button' get_option_row_id='options_row_id_"+option_row_counter+"' class='btn btn-danger btn-sm remove_option'><i class='fa fa-times'></i></button>"+
				        			"</div>"+
				        		"</td>"+
				        	"</tr>"+
	        				"<tr>"+
				        		"<th>* Label</th>"+
				        		"<td><input type='text' name='options["+option_row_counter+"][label]' placeholder='Enter label name' class='form-control'></td>"+
				        	"</tr>"+
				        	"<tr>"+
				        		"<th>* Option Type</th>"+
				        		"<td>"+
				        			"<select class='form-control' name='options["+option_row_counter+"][option_type]'>"+
				        				"<option value='Single'>Single Selection</option>"+
				        				"<option value='Multi'>Multi Selection</option>"+
				        			"</select>"+
				        		"</td>"+
				        	"</tr>"+
				        	"<tr>"+
				        		"<td colspan='2' class='text-right'>"+
				        			"<button type='button' get_tbl_id='"+option_row_counter+"' type='button' class='btn btn-info btn-sm add_field_btn'>Add Field</button>"+
				        		"</td>"+
				        	"</tr>"+
				        	//append dynamic fields here

	        			"</table>"+
	        		"</td>"+
	        	"</tr>";

	    //console.log(html)
	    $("tbody#append_options_data").append(html)

	    option_row_counter++
	})


	//add fields
	$("tbody#append_options_data").on("click", "button.add_field_btn", function(){
		let tblID = $(this).attr("get_tbl_id")

		let filed_html = "<tr id='option_fields_num_"+option_field_counter+"'>"+
			        		"<td colspan='2'>"+
			        			"<div class='d-flex justify-content-between'>"+
			        				"<input type='text' name='options["+tblID+"][fields]["+option_field_counter+"][option_name]' placeholder='ex: Beaf' class='form-control'>"+
			        				"<input type='number' name='options["+tblID+"][fields]["+option_field_counter+"][extra_charge]' placeholder='Extra charge amount (optional)' class='form-control' step='0.01'>"+
			        				"<button type='button' get_tr_num='option_fields_num_"+option_field_counter+"' class='btn btn-danger btn-sm remove_option_field'><i class='fa fa-times'></i></button>"+
			        			"</div>"+
			        		"</td>"+
			        	"</tr>";

		$("tbody#append_options_data table#options_tbl_id_"+tblID).append(filed_html)
		option_field_counter++
	})



	//remove option
	$("tbody#append_options_data").on("click", "button.remove_option", function(){
		let optionRowID = $(this).attr("get_option_row_id")
		$("tbody#append_options_data tr#"+optionRowID).remove()
	})

	//remove option field
	$("tbody#append_options_data").on("click", "table button.remove_option_field", function(){
		let trNum = $(this).attr("get_tr_num")
		$("tbody#append_options_data tr#"+trNum).remove()
	})
</script>
@endpush