@if(isset($categoriesList))
<select class="form-control" name="category">
	@if(is_numeric($reqeust->current_category))
		@foreach($categoriesList as $key=>$row)
			<option @if($reqeust->current_category == $row->id) selected @endif value="{{$row->id}}">{{$row->name}}</option>
		@endforeach
	@else
		@foreach($categoriesList as $key=>$row)
			<option value="{{$row->id}}">{{$row->name}}</option>
		@endforeach
	@endif
</select>
@endif