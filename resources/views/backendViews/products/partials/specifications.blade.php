<?php
  $current_field_names = NULL;
  $current_field_values = NULL;
  $current_contents = NULL;

  if (isset($editData)) {
    $current_field_names = $editData->field_names;
    $current_field_values = $editData->field_values;
  }

  if ($current_field_names !== NULL && $current_field_values !== NULL) {
     $current_field_names = json_decode($current_field_names,true);
     $current_field_values = json_decode($current_field_values,true);

     $newCombo = array_combine($current_field_names, $current_field_values);
     $totalRaws = 1;

     foreach ($newCombo as $key => $value) {
       $current_contents .= "
       <tr class='signle__dynamic__row' id='raw-".$totalRaws."'>
            <td>
              <input value='".$key."' type='text' name='field_names[]' class='form-control' required='1'>
            </td>
            <td>
              <input type='text' value='".$value."' name='field_values[]' class='form-control' required='1'>
            </td> 
            <td width='10%'>
              <button type='button' class='remove_field btn btn-danger btn-sm' getrawid='".$totalRaws."'>X</button>
            </td>
        </tr>";
        $totalRaws++;
     }
  }
?>


<div class="single--block product-image form-group">
  <div class="row">

    <div class="col-lg-12 col-md-12">
      <table class="table">
        <tbody id="append__data">

          <?php
            if ($current_field_names !== NULL && $current_field_values !== NULL) {
              echo $current_contents;
            }
          ?>

        </tbody>
      </table>
    </div>

  </div>
</div>



@push('scripts')
<script type="text/javascript">
  
  @if($current_field_names !== NULL && $current_field_values !== NULL)
    var i = {{$totalRaws}}
    @else
    var i = 1;
  @endif


  $("#add_field_btn").on("click", function(){
    addField();
  })

  function addField(){
    if ($("#append__data .signle__dynamic__row").length > 19) {
      alert('Raws are limited upto 20')
      return false;
    }else{

      if ($("#append__data #raw-"+i).length) {
        incrementRawNumber()
        return;
      }

      $("#append__data").append("<tr class='signle__dynamic__row' id='raw-"+i+"'><td><input type='text' name='field_names[]' class='form-control' placeholder='Name' required='1'></td><td><input type='text' name='field_values[]' class='form-control' placeholder='Value' required='1'></td> <td width='10%'><button type='button' class='remove_field btn btn-danger btn-sm' getrawid='"+i+"'>X</button></td></tr>")
      i++;
    }
  }

  $("#append__data").on("click", ".remove_field", function(){
    let getRawID = $(this).attr('getrawid')
    $("#append__data #raw-"+getRawID).remove()
    i--;
  })

  function incrementRawNumber(){
    i++;
    if ($("#append__data #raw-"+i).length) {
        i++;
    }
    addField();
  }
</script>
@endpush