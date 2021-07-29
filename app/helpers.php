<?php

$baseUrl = "http://103.108.140.52/~dokandar/api/";
$imageBaseUrl = "http://103.108.140.52/~dokandar/";
$registerApi = $baseUrl . "user_register";
$verifyPhone = $baseUrl . "verify_phone";
$userRegistration = $baseUrl . "checkuser";
$userProfile = $baseUrl . "myprofile";
$forgotPassword = $baseUrl . "forgot_password";
$forgotPasswordVerify = $baseUrl . "verify_otp";
$changePassword = $baseUrl . "change_password";
$nearByStore = $baseUrl . "nearbystore";
$bannerUrl = $baseUrl . "adminbanner";
$categoryList = $baseUrl . "appcategory";
$subCategoryList = $baseUrl . "appsubcategory";
$productListWithVarient = $baseUrl . "appproduct";
$vendorUrl = $baseUrl . "vendorcategory";
$addToCart = $baseUrl . "order";
$timeSlots = $baseUrl . "timeslot";
$applyCoupon = $baseUrl . "apply_coupon";
$couponList = $baseUrl . "coupon_list";
$checkOut = $baseUrl . "checkout";
$addAddress = $baseUrl . "add_address";
$showAddress = $baseUrl . "show_address";
$area_city_charges = $baseUrl . "area_city_charges";
$selectAddress = $baseUrl . "select_address";
$removeAddress = $baseUrl . "remove_address";
$editAddress = $baseUrl . "edit_address";
$vendorBanner = $baseUrl . "vendorbanner";
$onGoingOrdersUrl = $baseUrl . "ongoingorders";
$completeOrders = $baseUrl . "completed_orders1";
$cancelOrders = $baseUrl . "cancelorderhistory";
$cityList = $baseUrl . "city";
$areaLists = $baseUrl . "area";
$address_selection = $baseUrl . "address_selection";
$cancelReasonList = $baseUrl . "showcomplain";
$cancelOrderApi = $baseUrl . "cancel_order";
$rewardvalues = $baseUrl . "rewardvalues";
$search_keyword = $baseUrl . "search_keyword";
$after_order_reward_msg = $baseUrl . "after_order_reward_msg";
$rewardhistory = $baseUrl . "rewardhistory";
$redeem = $baseUrl . "redeem";
$showWalletAmount = $baseUrl . "showcredit";
$creditHistroy = $baseUrl . "credit_history";
$termcondition = $baseUrl . "termcondition";
$aboutus = $baseUrl . "aboutus";
$support = $baseUrl . "support";
$reffermessage = $baseUrl . "reffermessage";
$paymentvia = $baseUrl . "paymentvia"; //vendor_id
$currencyuri = $baseUrl . "currency"; //vendor_id
$notificationlist = $baseUrl . "notificationlist"; //vendor_id
$dealproductUrl = $baseUrl . "dealproduct"; //vendor_id
$notificationby = $baseUrl . "notificationby"; //vendor_id
$promocode_regenerate = $baseUrl . "promocode_regenerate"; //vendor_id
$country_code = $baseUrl . "country_code"; //vendor_id
// resturant model
$resturant_banner = $baseUrl . "resturant_banner";
$homecategoryss = $baseUrl . "homecategory";
$popular_item = $baseUrl . "popular_item";
$returant_order = $baseUrl . "returant_order";
$orderplaced = $baseUrl . "orderplaced";
$order_cancel = $baseUrl . "order_cancel";
$resturantsearchingFor = $baseUrl . "resturantsearchingFor";
$user_completed_orders = $baseUrl . "user_completed_orders";
$user_cancel_order_history = $baseUrl . "user_cancel_order_history";
$user_ongoing_order = $baseUrl . "user_ongoing_order";

//pharmacy
$pharmacy_banner = $baseUrl . "pharmacy_banner";
$pharmacy_homecategory = $baseUrl . "pharmacy_homecategory";
$pharmacy_popular_item = $baseUrl . "pharmacy_popular_item";
$pharmacy_order = $baseUrl . "pharmacy_order";
$pharmacy_orderplaced = $baseUrl . "pharmacy_orderplaced";
$pharmacy_order_cancel = $baseUrl . "pharmacy_order_cancel";
$pharmacy_user_completed_orders = $baseUrl . "pharmacy_user_completed_orders";
$pharmacy_user_cancel_order_history =
    $baseUrl . "pharmacy_user_cancel_order_history";
$pharmacy_user_ongoing_order = $baseUrl . "pharmacy_user_ongoing_order";
$after_order_reward_msg_new = $baseUrl . "after_order_reward_msg_new";

// parcel
$parcel_banner = $baseUrl . "parcel_banner";
$parcel_detail = $baseUrl . "parcel_detail"; //add to cart
$parcel_charges = $baseUrl . "parcel_charges";
$parcel_orderplaced = $baseUrl . "parcel_orderplaced"; //checkout
$parcel_listcharges = $baseUrl . "parcel_listcharges";
$parcel_after_order_reward_msg = $baseUrl . "parcel_after_order_reward_msg";
$parcel_user_ongoing_order = $baseUrl . "parcel_user_ongoing_order";
$parcel_user_cancel_order = $baseUrl . "parcel_user_cancel_order";
$parcel_user_completed_order = $baseUrl . "parcel_user_completed_order";
$appname = "Dokandar";

function baseUrl($data = ''): string
{
    return "https://admin.dokandar.xyz/api/" . $data;
}

function imageBaseUrl($data = ''): string
{
    return "https://admin.dokandar.xyz/" . $data;
}


?>
