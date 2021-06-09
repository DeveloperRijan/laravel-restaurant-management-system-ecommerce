<html xmlns="http://www.w3.org/1999/xhtml">
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <head>
         <title>{{ env("APP_NAME") }}</title>
         <style type="text/css">
            div, p, a, li, td {
            -webkit-text-size-adjust:none;
            }
            .ReadMsgBody {
            width: 100%;
            background-color: #cecece;
            }
            .ExternalClass {
            width: 100%;
            background-color: #cecece;
            }
            body {
            width: 100%;
            height: 100%;
            background-color: #cecece;
            margin:0;
            padding:0;
            -webkit-font-smoothing: antialiased;
            }
            html {
            width: 100%;
            }
            img{
            border:none;
            }
            table td[class=show]{
            display:none !important;
            }
            @media only screen and (max-width: 640px) {
            body {
            width:auto!important;
            }
            table[class=full] {
            width:100%!important;
            }
            table[class=devicewidth] {
            width:100% !important;
            padding-left:20px !important;
            padding-right: 20px!important;
            }
            table[class=inner] {
            width:100%!important;
            text-align: center!important;
            clear: both;
            }
            table[class=inner-centerd] {
            width:78%!important;
            text-align: center!important;
            clear: both;
            float:none !important;
            margin:0 auto !important;
            }
            table td[class=hide], .hide {
            display:none !important;
            }
            table td[class=show], .show{
            display:block !important;
            }
            img[class=responsiveimg]{
            width:100% !important;
            height:atuo !important;
            display:block !important;
            }
            table[class=btnalign]{
            float:left !important;
            }
            table[class=btnaligncenter]{
            float:none !important;
            margin:0 auto !important;
            }
            table td[class=textalignleft]{
            text-align:left !important;
            padding:0 !important;
            }
            table td[class=textaligcenter]{
            text-align:center !important;
            }
            table td[class=heightsmalldevices]{
            height:45px !important;
            }
            table td[class=heightSDBottom]{
            height:28px !important;
            }
            table[class=adjustblock]{
            width:87% !important;
            }
            table[class=resizeblock]{
            width:92% !important;
            }
            table td[class=smallfont]{
            font-size:8px !important;
            }
            }
            @media only screen and (max-width: 520px) {
            table td[class=heading]{
            font-size:24px !important;
            }
            table td[class=heading01]{
            font-size:18px !important;
            }
            table td[class=heading02]{
            font-size:27px !important;
            }
            table td[class=text01]{
            font-size:22px !important;
            }
            table[class="full mhide"], table tr[class=mhide]{
            display:none !important;
            }
            }
            @media only screen and (max-width: 480px) {
            table {
            border-collapse: collapse;
            }
            table[id=colaps-inhiret01],
            table[id=colaps-inhiret02],
            table[id=colaps-inhiret03],
            table[id=colaps-inhiret04],
            table[id=colaps-inhiret05],
            table[id=colaps-inhiret06],
            table[id=colaps-inhiret07],
            table[id=colaps-inhiret08],
            table[id=colaps-inhiret09]{
            border-collapse:inherit !important;
            }
            }
            @media only screen and (max-width: 320px) {
            }
         </style>
   </head>
   <body>
      <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" class="full">
         <tr style="text-align: center;">
            <td align="center" valign="middle">
               <a href="">
               <img src="{{ url('/').$publicAssetsPathStart.'uploads/app/app_logo.png' }}" alt="{{ env('APP_NAME') }}" style="max-width: 100%" height="100px">
               </a>
            </td>
         </tr>
      </table>
      <!-- ----------------- Header End Here ------------------------- -->
      <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" class="full">
         <tr>
            <td align="center">
               <table width="600" border="0" cellspacing="0" cellpadding="0" align="center" class="devicewidth">
                  <tr>
                     <td>
                        <table width="100%" bgcolor="#ffffff"  border="0" cellspacing="0" cellpadding="0" align="center" class="full" style="text-align:center; border-bottom:1px solid #e5e5e5;padding: 15px">
                           <tr>
                              <td class="heightsmalldevices" height="40">&nbsp;</td>
                           </tr>
                           <tr>
                              <td style="font:bold 18px Arial, Helvetica, sans-serif; color:#404040; text-align: left !important;">
                                 Hello {{$userData->name}}
                              </td>
                           </tr>
                           <tr>
                              <td height="21">&nbsp;</td>
                           </tr>
                           <tr>
                              <td style="font:18px Arial, Helvetica, sans-serif; color:#404040;text-align: left !important;">
                              <p>Your order is now  <b>{{$orderData->status}}</b></p>
                              <p>Order ID : #{{$orderData->order_id}}</p>
                              <p style="text-align: center;">For any inquiry regarding your order please contact us!</p>
                           </td>
                           </tr>      
                           <tr>
                              <td height="32">&nbsp;</td>
                           </tr>
                           <tr>
                              <td align="center">
                                 <table width="250" align="center" border="0" cellspacing="0" cellpadding="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; text-align:center;">
                                    <tr>
                                       @if($orderData->order_by === "Staff")
                                       <td align="center" bgcolor="#1b1e5b" style="border-radius:28px;" height="61">
                                          <a href="{{url('/staff')}}" 
                                                style="color:#ffffff; text-decoration:none; 
                                                overflow:hidden; outline:none;
                                                text-transform: uppercase;
                                                display: block !important;
                                                width: 100%!important;
                                                ">
                                             Login For More Info
                                          </a>
                                       </td>
                                       @else
                                       <td align="center" bgcolor="#1b1e5b" style="border-radius:28px;" height="61">
                                          <a href="{{url('/')}}" 
                                                style="color:#ffffff; text-decoration:none; 
                                                overflow:hidden; outline:none;
                                                text-transform: uppercase;
                                                display: block !important;
                                                width: 100%!important;
                                                ">
                                             Login For More Info
                                          </a>
                                       </td>
                                       @endif
                                    </tr>
                                 </table>
                              </td>
                           </tr>
                           <tr>
                              <td class="heightsmalldevices" height="60">&nbsp;</td>
                           </tr>
                        </table>
                     </td>
                  </tr>
               </table>
            </td>
         </tr>
      </table>
      

      <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" class="full">
         <tr>
            <td align="center">
               <table width="600" border="0" cellspacing="0" cellpadding="0" align="center" class="devicewidth">
                  <tr>
                     <td>
                        <table width="100%" bgcolor="#ffffff"  border="0" cellspacing="0" cellpadding="0" align="center" class="full" style="text-align:center;">
                           <tr>
                              <td height="50">&nbsp;</td>
                           </tr>
                           <tr>
                              <td style="font:16px Arial, Helvetica, sans-serif; color:#404040; padding:0 10px;">
                                 <p style="margin: 0;padding: 0"><b>Thanks</b></p>
                                 <p style="margin: 0;padding: 0">{{env('APP_NAME')}} Team</p>
                                 @if($frontendUIData)
                                 <p style="margin: 0;padding: 0">Tel: {{$frontendUIData->contact_phone}}</p>
                                 <p style="margin: 0;padding: 0">Email: {{$frontendUIData->contact_email}}</p>
                                 @endif
                              </td>
                           </tr>
                           <tr>
                              <td height="28">&nbsp;</td>
                           </tr>
                        </table>
                     </td>
                  </tr>
               </table>
            </td>
         </tr>
      </table>
      

   </body>
</html>