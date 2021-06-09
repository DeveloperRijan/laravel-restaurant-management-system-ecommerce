<div class="col-lg-12 col-md-12">
  <h4 style="font-size: 16px;margin-top: 70px;text-align: center;"><b>{{Auth::user()->name}}</b>, Please Confirm Your Shipping Address</h4>
  <div>
    <div class="row">
      <div class="col-lg-3 col-md-12"></div>

      <div class="col-lg-6 col-md-12">
        <div class="form-group d-flex justify-content-between address_options">
          <div>
            <select class="address" name="shipping_address">
              <option value="">Select One</option>
              @foreach($addresses as $key=>$address)
              <option value="{{encrypt($address->id)}}">{{$address->nick_name}}</option>
              @endforeach
            </select>
          </div>
          <div>
            <button type="button" data-bs-toggle="modal" data-bs-target="#addNewAddressModal">Add New Address</button>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-12"></div>
    </div>

    <div>
      <div class="row">
        <div class="col-lg-3 col-md-12"></div>

        <div class="col-lg-6 col-md-12">
          <form id="addressUpdateForm" action="{{route('customer.address.update')}}" method="POST">
              @csrf
              <div id="address-preview-form-wrapper" class="d-none"
                  style="padding: 10px; border: 1px solid #ddd; border-radius: 3px; box-shadow: 0 2px 4px 0 rgb(0 0 0 / 8%);">
                
                  <div>
                    @include("frontendViews.checkout.partials.address_preview")
                  </div>

              </div>
          </form>
        </div>

        <div class="col-lg-3 col-md-12"></div>
      </div>
    </div>
  </div>
</div>




<!-- Modal -->
<div class="modal fade" id="addNewAddressModal" tabindex="-1" aria-labelledby="exampleModalLabelAddress" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabelAddress">Add New Address</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="addNewAddressForm" method="POST" action="{{route('customer.address.add')}}">
          @csrf
          <div class="form-group">
            <label>* Nick Name (Unique Address Identifier)</label>
            <input type="text" name="nick_name" class="form-control" placeholder="Nick Name" required="1" maxlength="99">
          </div>
          <div class="form-group">
            <label>* Mobile</label>
            <input type="text" name="mobile_number" placeholder="Mobile Number" required="1" maxlength="20" class="form-control">
          </div>
          <div class="form-group">
            <label>* Address Line 1</label>
            <input type="text" name="address_line_1" placeholder="Address Line 1" required="1" maxlength="250" class="form-control">
          </div>
          <div class="form-group">
            <label>Address Line 2</label>
            <input type="text" name="address_line_2" placeholder="Address Line 2" maxlength="250" class="form-control">
          </div>

          <div class="form-group">
            <div class="row"> 
              <div class="col-lg-6 col-md-12">
                <div class="form-group">
                  <label>* City</label>
                  <input type="text" name="city" placeholder="City" class="form-control" maxlength="99">
                </div>
              </div>
              <div class="col-lg-6 col-md-12">
                <div class="form-group">
                  <label>* Post Code</label>
                  <input type="text" name="post_code" placeholder="Post Code" class="form-control" maxlength="99">
                </div>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label>Note</label>
            <textarea class="form-control" name="note" placeholder="Note (optional)" cols="10" rows="4"></textarea>
          </div>

          <button class="btn btn-primary btn-sm" type="submit">Add</button>
        </form>
      </div>
    </div>
  </div>
</div>

@push("scripts")
<script type="text/javascript">
   $("form#addNewAddressForm").on('submit', function(e){
         e.preventDefault();
         var form = $(this);
         var url = form.attr('action');
         var type = form.attr('method');
         //var form_data = form.serialize();
   
         formSubmitWithFile("addNewAddressForm", url, type);
     })
</script>

<script type="text/javascript">
  $("select[name='shipping_address']").on("change", function(){
    if ($(this).val() === '') {
      $("#address-preview-form-wrapper").addClass('d-none')
      return;
    }

    //get address details
    $.ajax({
        url: "/checkout?get_address_details_by_id="+$(this).val(),
        method: "GET",
        dataType: 'HTML',
        cache: false,
        beforeSend:function(){
          $("#form__processing__gif").show()
          $("#address-preview-form-wrapper").addClass('d-none')
        },
        success: function(response){
          $("#form__processing__gif").hide()
          $("#address-preview-form-wrapper").removeClass('d-none')

          $("#address-preview-form-wrapper").html(response)
        },
        error: function (jqXHR, textStatus, errorThrown) {
          $("#form__processing__gif").hide()
          $("#address-preview-form-wrapper").addClass('d-none')
              alert("Something wrong")
          },
          complete:function(){
            $("#form__processing__gif").hide()
          }
    });
  })



  function returnToPaymentGateway(e){
    e.preventDefault()
    let addressID = $("select[name='shipping_address']").val()
    if (addressID == '') {
      alert("Please select address")
      return;
    }
    window.location.href = "{{route('checkout.init')}}?step=payment&address="+addressID
  }



  //update address
  $("form#addressUpdateForm").on("click", "button#updateAddressButton", function(e){
     e.preventDefault();
     $("form#addressUpdateForm").submit()
  })
</script>
@endpush