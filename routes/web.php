<?php

use Illuminate\Support\Facades\Route;

//frontend
use App\Http\Controllers\Frontend\RootController;
use App\Http\Controllers\Frontend\PagesController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\FrontendCategoryController;
use App\Http\Controllers\Frontend\SearchPostCodeController;


//Staffs
use App\Http\Controllers\Staff\StaffController; 
use App\Http\Controllers\Staff\StaffOrderController; 
use App\Http\Controllers\Staff\CreditBalanceController; 
use App\Http\Controllers\Staff\StaffProfileController; 


//customer auth
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordCustomController;
use App\Http\Controllers\Customer\CustomerAccountController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\FeedbackController;
use App\Http\Controllers\Customer\OrderController;
use App\Http\Controllers\Customer\CustomerProfileController;
use App\Http\Controllers\Customer\CustomerChatController;


//kithen staff
use App\Http\Controllers\KS\KsDashboardController;
use App\Http\Controllers\KS\KSchatController;


//admin
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminCouponController;
use App\Http\Controllers\Admin\FrontendUIController;
use App\Http\Controllers\Admin\HomeContentController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Admin\PaymentGatewayController;
use App\Http\Controllers\Admin\OrderManagementController;
use App\Http\Controllers\Admin\DeliveryChargeController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\PostCodeController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\AdminStaffController;
use App\Http\Controllers\Admin\BatchCouponController;
use App\Http\Controllers\Admin\DesignationController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\NotificationSettingController;
use App\Http\Controllers\Admin\AdminChatController;



#Cache Config Clear
Route::get("config_clear", function(){
    \Artisan::call('cache:clear');
    \Artisan::call('config:clear');
    \Artisan::call('view:clear');
    \Artisan::call('route:clear');
    echo "<div style='text-align:center'><a href='".route('admin.dashboard')."'>Back to Dashboard</a></div>";
    dd('Done');
});
    
Route::get('item-list', function(){
    return view("frontendViews.item-list");
});
Route::get("/", [RootController::class, "index"])->name("root_page");
Route::get("/items", [PagesController::class, "item_list"])->name("item.list.page");
Route::get("/staff/items", [PagesController::class, "staff_item_list"])->name("staff.item.list.page");
Route::get("/filter_items", [PagesController::class, "filter_items"]);
Route::get("/filter_staff_items", [PagesController::class, "filter_staff_items"]);
Route::get("/details/{slug}", [PagesController::class, "item_details"])->name("item.details.page");
Route::get("/load_product_details", [PagesController::class, "load_product_details"])->name("item.details.load");
Route::post("/search_post_code", [SearchPostCodeController::class, "search_post_code"])->name("postcode.detectCollectionOrDelivery");


//cart items
Route::get("cart-items", [CartController::class, "get_cart_items"])->name("get.cart.items");
Route::get("order-now", [CartController::class, "order_now"])->name("orderNow.item");

#Feedback - like a product
Route::post("feedback", [FeedbackController::class, "feedback_post"]);

#Cart
Route::get("cart/add", function(){return abort(404);});
Route::post("cart/add", [CartController::class, "add"]);
Route::get("cart/update-qty", [CartController::class, "update_qty"]);

Route::get("checkout", [CheckoutController::class, "checkout"])->name("checkout.init");

#Home
Route::get("home", function(){
    return redirect()->route("root_page");
});


#Staff
Route::get("staff", [StaffController::class, "staff"])->name("staff.page");
Route::get("staff/order", [StaffOrderController::class, "order_now"])->name("staff.order.page");


//auth scaffolding
Route::group(['middleware' => ['web']], function() {

// Login Routes for docotors and patients
    //user login
    Route::get('login', [LoginController::class, 'show_login_from'])->name('login');
    Route::post('login', [LoginController::class, 'custom_login'])->name('login.post');
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    #admin authenticateion
    Route::get('admin/login', [AdminLoginController::class, 'show_login_from'])->name('admin.login');
    Route::post('admin/login', [AdminLoginController::class, 'custom_login'])->name('admin.login.post');

// Registration Routes...
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'custom_register'])->name('register.post');

    //reset password
    Route::get('reset_passoword', [ForgotPasswordCustomController::class, 'pass_reset_form'])->name('resetPassForm.get');
    Route::post('send/pass-reset/link', [ForgotPasswordCustomController::class, 'send_reset_link'])->name('sendPassResetLink.post');
    Route::post('reset/password', [ForgotPasswordCustomController::class, 'password_reset_post'])->name('passwordReset.post');

    ##Staff
    //Route::get("staff/login", [LoginController::class, "staff_login_form"])->name("staff.login.form");
    Route::post("staff/login", [LoginController::class, "staff_login"])->name("staff.login.post");

    //Route::get("staff/register", [RegisterController::class, "staff_register_form"])->name("staff.register.form");
    Route::post("staff/register", [RegisterController::class, "staff_register"])->name("staff.register.post");

    //kitch staff auth
    Route::get("kitchen-staff/login", [LoginController::class, "kitchen_staff_login_form"])->name("ks.login.form");
    Route::post("kitchen-staff/login", [LoginController::class, "kitchen_staff_login"])->name("ks.login.post");
});

//Auth::routes();
//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

#Staff routes
Route::group(["prefix"=>"staff", "as"=>"staff.", "middleware"=>["auth", "staffMW"]], function(){
    Route::get("account", [StaffController::class, "account"])->name("account.get");
    
    #profile
    Route::post('profile', [StaffProfileController::class, 'profile_update'])->name('profile.update');
    Route::post('update-password', [StaffProfileController::class, 'password_update'])->name('password.update');

    //shipping address 
    Route::post("address-add", [StaffController::class, "add_address"])->name("address.add");
    Route::post("address-update", [StaffController::class, "update_address"])->name("address.update");
    Route::get("my-addresses", [StaffController::class, "my_addresses"])->name("my.addresses");
    
    //save the order
    Route::post("order_save", [StaffOrderController::class, "order_save"])->name("order.post");

    #Credit Balance
    Route::resource("credit-balance", CreditBalanceController::class);
    Route::get("testCreditBalanceTopUP/{amount}", [CreditBalanceController::class, "testCreditBalance"])->name("test.credit.topup");
});


#Customer routes
Route::group(["prefix"=>"customer", "as"=>"customer.", "middleware"=>["auth", "customerMW"]], function(){
	Route::get("account", [CustomerAccountController::class, "account"])->name("account.get");
    Route::post("addresses/add", [CustomerAccountController::class, "add_address"])->name("address.add");
    Route::post("addresses/update", [CustomerAccountController::class, "update_address"])->name("address.update");
    
    #profile
    Route::post('profile', [CustomerProfileController::class, 'profile_update'])->name('profile.update');
    Route::post('update-password', [CustomerProfileController::class, 'password_update'])->name('password.update');

    #Orders
    Route::post("order", [OrderController::class, "post_order"])->name("order.post");
    Route::get("order_actions/{orderID}/{type}", [OrderController::class, "order_actions"])->name("order.actions");

    #live support
    Route::post("open-support-ticket", [CustomerChatController::class, "open_ticket"])->name("support.openTicket");
    Route::get("support", [CustomerChatController::class, "chat_page"])->name("support.page");
    Route::post("sendMsg", [CustomerChatController::class, "sendMsg"])->name("sendMsg.post");
    Route::get("getMessages", [CustomerChatController::class, "getMessages"])->name("getMessages.get");
    Route::get("support_ticket_actions/{supportTicketID}/{actionType}", [CustomerChatController::class, "ticket_actions"])->name("supportTicketsActions");
});




#Kitchen Staff (ks) routes
Route::group(["prefix"=>"kitchen-staff", "as"=>"ks.", "middleware"=>["auth", "ksMW"]], function(){
    Route::get("dashboard", [KsDashboardController::class, "index"])->name("dashboard");
    Route::post("addresses/add", [CustomerAccountController::class, "add_address"])->name("address.add");
    Route::post("addresses/update", [CustomerAccountController::class, "update_address"])->name("address.update");

    #profile
    Route::get('profile', [AdminProfileController::class, 'get_profile'])->name('profile.get');
    Route::post('profile', [AdminProfileController::class, 'profile_update'])->name('profile.update');
    Route::get('update-password', [AdminProfileController::class, 'pass_update_form'])->name('password.update.form');
    Route::post('update-password', [AdminProfileController::class, 'password_update'])->name('password.update');

    #Order Management
    Route::resource("orders", OrderManagementController::class);
    Route::get("get-orders-data", [OrderManagementController::class, "custom_datatables_data"])->name("ordersDatatableCustom.data");
    Route::get("order_actions/{orderID}/{actionType}", [OrderManagementController::class, "order_actions"])->name("order.actions");

    #Users
    Route::resource("users", UserManagementController::class);

    #Products
    Route::resource("products", AdminProductController::class);
    Route::get("product_actions/{productID}/{actionType}", [AdminProductController::class, "actions"])->name("product.action");

    #live support
    Route::get("support", [KSchatController::class, "chat_page"])->name("support.page");
    Route::post("sendMsg", [KSchatController::class, "sendMsg"])->name("sendMsg.post");
    Route::get("getMessages", [KSchatController::class, "getMessages"])->name("getMessages.get");
    Route::get("support_ticket_actions/{supportTicketID}/{actionType}", [KSchatController::class, "ticket_actions"])->name("supportTicketsActions");
});


#Admin routes
Route::group(["prefix"=>"admin", "as"=>"admin.", "middleware"=>["auth", "adminMW"]], function(){
    #Cache Config Clear
    Route::get("config_clear", function(){
        \Artisan::call('cache:clear');
        \Artisan::call('config:clear');
        \Artisan::call('view:clear');
        \Artisan::call('route:clear');
        echo "<div style='text-align:center'><a href='".route('admin.dashboard')."'>Back to Dashboard</a></div>";
        dd('Done');
    });

    Route::get("dashboard", [AdminDashboardController::class, "index"])->name("dashboard");

    #profile
    Route::get('profile', [AdminProfileController::class, 'get_profile'])->name('profile.get');
    Route::post('profile', [AdminProfileController::class, 'profile_update'])->name('profile.update');
    Route::get('update-password', [AdminProfileController::class, 'pass_update_form'])->name('password.update.form');
    Route::post('update-password', [AdminProfileController::class, 'password_update'])->name('password.update');

    #Categories
    Route::resource("categories", CategoryController::class);
    Route::get("delete_cat/{categoryID}", [CategoryController::class, 'delete_cat'])->name("delete.category");
    Route::post("manage_and_delete_cat", [CategoryController::class, 'manage_and_delete_cat'])->name("manage_and_delete_cat");

    #Products
    Route::resource("products", AdminProductController::class);
    Route::get("get_categories_type_wise", [AdminProductController::class, "get_categories_type_wise"]);
    Route::get("product_actions/{productID}/{actionType}", [AdminProductController::class, "actions"])->name("product.action");

    #Coupons
    Route::resource("coupons", AdminCouponController::class);
    Route::get("coupon_actions/{couponID}/{actionType}", [AdminCouponController::class, "actions"])->name("coupon.action");

    #Frontend UI
    Route::resource("frontend-ui", FrontendUIController::class);

    #Home Content Setup
    Route::resource("home-content", HomeContentController::class);

    #Payment Gateway
    Route::resource("payment-gateway", PaymentGatewayController::class);

    #Order Management
    Route::resource("orders", OrderManagementController::class);
    Route::get("get-orders-data", [OrderManagementController::class, "custom_datatables_data"])->name("ordersDatatableCustom.data");
    Route::get("order_actions/{orderID}/{actionType}", [OrderManagementController::class, "order_actions"])->name("order.actions");


    #Delivery
    Route::resource("delivery-charge", DeliveryChargeController::class);

    #Notifications
    Route::resource("notifications", NotificationController::class);
    Route::get("notification_delete/{ID}", [NotificationController::class, "delete"])->name("delete.notification");

    #postCodes
    Route::resource("postcodes", PostCodeController::class);
    Route::get("post_codes/{postCodeID}/{actionType}", [PostCodeController::class, "actions"])->name("postcode.actions");

    #Sliders
    Route::resource("sliders", SliderController::class);
    Route::get("slider/{sliderID}/{actionType}", [SliderController::class, "actions"])->name("slider.actions");

    #Users
    Route::resource("users", UserManagementController::class);
    Route::post("user_password_update", [UserManagementController::class, "user_password_update"])->name("user.pass.update");
    Route::get("add-kitchen-staff", [UserManagementController::class, "add_kitchen_staff_form"])->name("add.kitchen.staff.form");
    Route::post("add-kitchen-staff", [UserManagementController::class, "add_kitchen_staff_post"])->name("add.kitchen.staff.post");
    Route::get("edit-kitchen-staff/{id}", [UserManagementController::class, "edit_kitchen_staff_form"])->name("edit.kitchen.staff.get");
    Route::post("edit-kitchen-staff", [UserManagementController::class, "edit_kitchen_staff_post"])->name("edit.kitchen.staff.post");
    Route::get("user/{userID}/{actionType}", [UserManagementController::class, "actions"])->name("user.actions");

    #Staff
    Route::resource("staffs", AdminStaffController::class);
    Route::get("staff-allowed-for-delivery", [AdminStaffController::class, "staff_delivey_type"])->name("staff.allowedForDelivery.order");
    Route::post("staff-allowed-for-delivery", [AdminStaffController::class, "staff_delivey_type_post"])->name("staff.allowedForDelivery.order.post");
    Route::get("delete-staff-allowed-for-delivery/{id}/{actionType}", [AdminStaffController::class, "staff_delivey_type_delete"])->name("staff.allowedForDelivery.delete");

    #Staff Coupon/Batch Coupon
    Route::get("add-batch-coupon", [BatchCouponController::class, "add_batch_coupon_form"])->name("add.batch.coupon.get");
    Route::post("add-batch-coupon", [BatchCouponController::class, "add_batch_coupon_post"])->name("add.batch.coupon.post");
    Route::get("batch-coupon-setting", [BatchCouponController::class, "batch_coupon_setting"])->name("batch.coupon.setting");
    Route::post("batch-coupon-setting", [BatchCouponController::class, "batch_coupon_setting_post"])->name("batch.coupon.setting.post");
    

    #Designation
    Route::resource("designations", DesignationController::class);
    Route::get("designation/{designationID}/{actionType}", [DesignationController::class, "actions"])->name("designation.actions");

    #Designation
    //Route::resource("cities", CityController::class);
    //Route::get("city/{cityID}/{actionType}", [CityController::class, "actions"])->name("city.actions");

    Route::resource("notification-settings", NotificationSettingController::class);
    Route::get("designation/{designationID}/{actionType}", [NotificationSettingController::class, "actions"])->name("designation.actions");
    
});