@if(isset($addressDetails))
  <h4 
    style="font-size: 20px; font-weight: bold; margin-bottom: 15px; text-align: center;" 
  >Address Preview</h4>

  <input type="hidden" name="addressID" value="{{encrypt($addressDetails->id)}}">
  <div class="form-group">
    <label>* Nick Name (Unique Address Identifier)</label>
    <input type="text" name="nick_name" class="form-control" placeholder="Nick Name" required="1" maxlength="99"
    value="{{$addressDetails->nick_name}}">
  </div>
  <div class="form-group">
    <label>* Mobile</label>
    <input type="text" name="mobile_number" placeholder="Mobile Number" required="1" maxlength="20" class="form-control"
    value="{{$addressDetails->mobile_number}}">
  </div>
  <div class="form-group">
    <label>* Address Line 1</label>
    <input type="text" name="address_line_1" placeholder="Address Line 1" required="1" maxlength="250" class="form-control"
    value="{{$addressDetails->address_line_1}}">
  </div>
  <div class="form-group">
    <label>Address Line 2</label>
    <input type="text" name="address_line_2" placeholder="Address Line 2" maxlength="250" class="form-control"
    value="{{$addressDetails->address_line_2}}">
  </div>

  <div class="form-group">
    <div class="row"> 
      <div class="col-lg-6 col-md-12">
        <div class="form-group">
          <label>* City</label>
          <input type="text" name="city" placeholder="City" class="form-control" maxlength="99"
          value="{{$addressDetails->city}}" required="1">
        </div>
      </div>
      <div class="col-lg-6 col-md-12">
        <div class="form-group">
          <label>* Post Code</label>
          <input type="text" name="post_code" placeholder="Post Code" class="form-control" maxlength="99"
          value="{{$addressDetails->post_code}}" required="1">
        </div>
      </div>
    </div>
  </div>

  <div class="form-group">
    <label>Note</label>
    <textarea class="form-control" name="note" placeholder="Note (optional)" cols="10" rows="4">{!! nl2br(e($addressDetails->note)) !!}</textarea>
  </div>

  <div class="form-group">
    <div class="d-flex justify-content-between">
      <button id="updateAddressButton" type="button" class="btn btn-primary btn-sm btn-block"
      style="margin-right: 10px;width: 50%">Update Address</button>
      <a href="" onclick="returnToPaymentGateway(event)" class="proceed_next_link" style="width: 50%">Go to Payment <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
@endif
