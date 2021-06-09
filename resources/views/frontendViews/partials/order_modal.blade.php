<!-- Modal -->
<div class="modal fade" id="orderNowModal" tabindex="-1" aria-labelledby="orderNowModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-xl">
      <div class="modal-content" style="background: #fff">
         <div class="modal-header" style="display: flex; justify-content: space-between; margin-bottom: 30px; background: #ddd; padding: 10px; text-transform: uppercase; border-radius: 2px;">
            <h5 class="modal-title" id="orderNowModalLabel">
               Order Form
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <div class="main">


               <section>
                  <div class="container">
                     <div class="signin-content d-flex justify-content-between">

                        <div class="signin-image">
                           <figure><img class="setItemImage" src="" alt="Item Image"></figure>
                        </div>

                        <div style="padding: 0px 15px 15px 15px; width: 100%;">
                           <form action="" method="POST" class="register-form">
                              @csrf
                              <input type="hidden" name="itemID" value="">
                              <table class="table">
                                 <tr>
                                    <th colspan="3" style="border: none;text-align: center;">Item Details</th>
                                 </tr>
                                 <tr>
                                    <th>Item</th>
                                    <td>:</td>
                                    <td class="setTitleVal">
                                    </td>
                                 </tr>
                                 <tr>
                                    <th>Price</th>
                                    <td>:</td>
                                    <td class="setPriceVal">
                                       {{env('CURRENCY_SYMBOL')}}<span></span>
                                    </td>
                                 </tr>
                              </table>

                              <div class="form-group form-button">
                                 <button class="btn btn-danger" type="submit" style="cursor: pointer;width: 100%">Checkout</button>
                              </div>
                           </form>
                        </div>

                     </div>
                  </div>
               </section>

            </div>
         </div>
      </div>
   </div>
</div>


@push("scripts")

@endpush