<?php
	$productOptions = json_decode($productDetailsData->options, true);
?>

<div class="product-options-block">
	@foreach($productOptions as $key=>$option)
	<div class="single-option-wrapper">
		<button class="btn btn-primary option-btn" type="button" data-bs-toggle="collapse" 
		data-bs-target="#productOptionCollapse_{{$key}}" aria-expanded="false" 
		aria-controls="collapseExample">
			<span>{{$option['label']}}</span> <span><i class="fas fa-chevron-down"></i></span>
		</button>
		<div class="collapse" id="productOptionCollapse_{{$key}}">
		  <div class="card card-body">
		  	<ul>
		  		@foreach($option['fields'] as $fieldKey=>$field)
		  			<li>
		  				<div class="d-flex justify-content-between">
		  					<div>
			  					<input option_type="{{$option['option_type']}}" id="field_{{$fieldKey}}" type="checkbox" name="options[]" 
			  					ec="{{$field['extra_charge']}}"
			  					label-key='{{$key}}' field-key='{{$fieldKey}}'
			  					class="option_field_{{$key}}"
			  					value="{{$key}}__{{$fieldKey}}"> 
			  					<label for="field_{{$fieldKey}}">{{$field['option_name']}}</label>
			  				</div>
			  				<div>
			  					@if($field['extra_charge'] != '')
			  						+ {{env('CURRENCY_SYMBOL').number_format($field['extra_charge'], 2, '.', '')}}
			  					@endif
			  				</div>
		  				</div>
		  			</li>
		  		@endforeach
		  	</ul>
		  </div>
		</div>
	</div>
	@endforeach
</div>