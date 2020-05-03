<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Route::get('/foo', function () {
    // Artisan::call('storage:link');
    // });
   

Route::get('/', function () {
    return view('welcome');
});
Route::get('/dashboard', function () {
    return view('dashboard');
});
Route::get('/logoutuser', 'UserController@logout');



Auth::routes();
Route::prefix('/app')->group(function () {
    Route::resource('/user', 'UserController');
    Route::resource('/document', 'Dashboard\DocumentController');
    Route::resource('/machine', 'Dashboard\MachineController');
    Route::resource('/usertype', 'Dashboard\UserTypeController');
    Route::resource('/project', 'Dashboard\ProjectController'); 
    Route::resource('/expensecategory', 'Dashboard\ExpenseCategoryController');
    Route::resource('/expense', 'Dashboard\ExpenseController');
    Route::resource('/product', 'Dashboard\ProductController');
    Route::resource('/excellsheet', 'Dashboard\ExcellSheetController');
    Route::resource('/dashboardoverview', 'Dashboard\DashboardController');
    Route::resource('/bde', 'Dashboard\BDEController');
    Route::resource('/bdm', 'Dashboard\BDMController');
    Route::resource('/target', 'Dashboard\TargetController');
    Route::resource('/bussinessdevelopmentexecutive', 'Dashboard\BussinessDevelopmentExecutiveController');
    Route::resource('/ledgerhead', 'Dashboard\LedgerHeadController');
    Route::resource('/ledger', 'Dashboard\LedgerController');
    Route::resource('/customer', 'Dashboard\CustomerController');


    Route::resource('/callback', 'Dashboard\CallBackController');  // testing purpose
    Route::resource('/test', 'TestController');                    // testing purpose
    Route::resource('/message', 'Dashboard\MessageController');    // testing purpose
});


Route::get('/app/getunsignmachine','Dashboard\MachineController@getunsignmachine');
Route::get('/app/getunsigadmin','Dashboard\MachineController@getunsigadmin');


//Zone 
Route::get('/app/customerzone','Dashboard\ZoneController@getAllZone');
Route::get('/app/routezone','Dashboard\ZoneController@getAllZoneForRoute');


//Coupon
// Route::get('/app/getcustomer/coupon','Dashboard\CouponController@getCustomer');
Route::get('/app/getcoupon/coupon','Dashboard\CouponController@getCoupon');
// Route::post('/app/assigncoupon/coupon','Dashboard\CouponController@assignCouponToCustomer');
// Route::get('/app/getcustomerlist/coupon','Dashboard\CouponController@getCustomerCouponlist');
// Route::post('/app/assigncouponupdate/coupon','Dashboard\CouponController@updateCouponCustomer');
// Route::delete('/app/deletecoupon/coupon/{id}','Dashboard\CouponController@deleteCustomerCoupon');

//CustomerCoupon
Route::post('/app/customercouponupdate/customercoupon','Dashboard\CustomerCouponController@updateCouponCustomer');
Route::get('/app/getcustomer/customercoupon','Dashboard\CustomerCouponController@getCustomer');
Route::get('/app/getsaleperson/customercoupon','Dashboard\CustomerCouponController@getSalePerson');

//Driver 
Route::post('/app/updatedriver/driver','Dashboard\DriverController@updateDriver');
Route::post('/app/updatedriverpassword/driver','Dashboard\DriverController@updatePassword');

//Vehicle Type
Route::post('/app/updatevehicletype/vehicletype','Dashboard\VehicletypeController@updateVehicleType');

//Vehicle
Route::get('/app/getvehicletype/vehicle','Dashboard\VehicleController@getVehicleType');
Route::post('/app/updatevehicle/vehicle','Dashboard\VehicleController@updateVehicle');

//Route 
Route::post('/app/updatepassword/route','Dashboard\RouteController@updatePassword');
Route::get('/app/routeuser/route/{id}','Dashboard\RouteController@routeUserData');
Route::post('/app/getroutecustomerlocation/route','Dashboard\RouteController@getrouteCustomerLocation');


//Route Customer
Route::post('/app/getroutecustomerlistnew/routecustomer','Dashboard\RouteCustomerController@getNewRouteCustomerList');
Route::post('/app/routecustomerlistupdate/routecustomer','Dashboard\RouteCustomerController@updateRouteCustomerList');
Route::get('/app/unassignroutecustomer/routecustomer','Dashboard\RouteCustomerController@getUnsingedRouteCustomerList');


//setting
Route::post('/app/updateUser','UserController@updateUser');
Route::get('/app/profile', 'UserController@profile');
Route::post('/app/changepassword', 'UserController@changePass');
Route::post('/app/updatepassword', 'UserController@updatepassword');
Route::post('/app/avatar','UserController@avatar');


//CustomerZonebranch
Route::get('/app/getcustomerzonebranch/customerzonebranch','Dashboard\CustomerZoneBranchController@getCustomer');
Route::get('/app/getcustomerzonebranchzone/customerzonebranch','Dashboard\CustomerZoneBranchController@getZone');
Route::post('/app/updatecustomerzonebranch/customerzonebranch','Dashboard\CustomerZoneBranchController@updateZoneBranch');
Route::get('/app/getcustomerinformation/customerzonebranch/{id}','Dashboard\CustomerZoneBranchController@getcustomerinformation');
Route::post('/app/savecustomerzonebranch/customerzonebranch','Dashboard\CustomerZoneBranchController@saveCustomerZoneBranch');
Route::get('/app/getcustomerzonebranchlist/customerzonebranch/{id}','Dashboard\CustomerZoneBranchController@getCustomerZoneBranchList');
Route::post('/app/updatecustomerzonebranchlist/customerzonebranch','Dashboard\CustomerZoneBranchController@updateCustomerZoneBranchList');
Route::delete('/app/deletecustomerzonebranch/customerzonebranch/{id}','Dashboard\CustomerZoneBranchController@deleteCustomerZoneBranchList');
Route::get('/app/getsumcustodybottle/customerzonebranch','Dashboard\CustomerZoneBranchController@sumCustodyBottle');
Route::get('/app/getsumcustodydespenser/customerzonebranch','Dashboard\CustomerZoneBranchController@sumCustodyDespenser');
Route::get('/app/getonlysumcustodybottle/customerzonebranch/{id}','Dashboard\CustomerZoneBranchController@sumOnlyCustodyBottle');
Route::get('/app/getonlysumcustodydespenser/customerzonebranch/{id}','Dashboard\CustomerZoneBranchController@sumOnlyCustodyDespenser');

//customercouponconsume

Route::post('/app/getcustomerdeliveryreport','Dashboard\CustomerConsumeCouponController@getCustomerDeleiveryReport');
Route::post('/app/renewcustomercoupon','Dashboard\CustomerConsumeCouponController@renewCustomerCoupon');

Route::post('/app/getcustomerpurchasereport','Dashboard\CustomerConsumeCouponController@getCustomerPurchaseReport');
Route::get('/app/getgeneraldeatilcustomer/{id}','Dashboard\CustomerConsumeCouponController@getCustomerInformation');


//Report
Route::put('/app/routereport/report/{id}','Dashboard\ReportController@getRouteReport');
Route::put('/app/routecustomerreport/report/{id}','Dashboard\ReportController@getRouteCustomerReport');
Route::get('/app/customerlist/report/','Dashboard\ReportController@getCustomerList');
Route::post('/app/customerdeliveryreport/report','Dashboard\ReportController@getCustomerDeleiveryReport');
Route::post('/app/customerpurchasereport/report','Dashboard\ReportController@getCustomerPurchaseReport');
Route::post('/app/customeralldeliveryreport/report','Dashboard\ReportController@getAllCustomerDeleiveryReport');
Route::post('/app/salist/report','Dashboard\ReportController@getSaleList');

Route::get('/app/copy/','Dashboard\RouteController@copy');

//Saleperson
Route::post('/app/updatesalepassword/sale','Dashboard\SalesPeopleController@updatePassword');

//csutomer
Route::post('/app/updatecustomerpassword/customer','Dashboard\CustomerController@updatePassword');


Route::any('/{slug}/{child}', [
    'uses' => 'HomeController@dashboard',
 ]);
Route::any('/{slug}/{child}/{sub}', [
    'uses' => 'HomeController@dashboard',
 ]);
Route::any('/{slug}/{child}/{sub}/{id}', [
    'uses' => 'HomeController@dashboard',
 ]);

