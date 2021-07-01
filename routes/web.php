<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EstateController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\EarningController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\Messaging\Template;
use App\Http\Controllers\Admin\RfqController;
use App\Http\Controllers\Admin\TaxController;
use App\Http\Controllers\SimulationController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\PriceController;
use App\Http\Controllers\CSE\ProfileController;
use App\Http\Controllers\CSE\RequestController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\StatusController;
use App\Http\Controllers\Admin\EWalletController;
use App\Http\Controllers\Admin\GatewayController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Client\ClientController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\WarrantyController;
use App\Http\Controllers\Admin\ActivityLogController;
//use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\AdminRatingController;
use App\Http\Controllers\Admin\AdminReviewController;
use App\Http\Controllers\Admin\ToolsRequestController;
use App\Http\Controllers\Admin\ServicedAreasController;
use App\Http\Controllers\Admin\ToolInventoryController;
use App\Http\Controllers\Admin\User\SupplierController;
use App\Http\Controllers\Payment\FlutterwaveController;
use App\Http\Controllers\AdminLocationRequestController;
use App\Http\Controllers\CSE\CseWarrantyClaimController;

use App\Http\Controllers\Admin\User\FranchiseeController;
use App\Http\Controllers\Admin\User\AdministratorController;
use App\Http\Controllers\QualityAssurance\PaymentController;
use App\Http\Controllers\Supplier\WarrantyDispatchController;
use App\Http\Controllers\Admin\CollaboratorsPaymentController;
use App\Http\Controllers\Admin\Report\SupplierReportController;
use App\Http\Controllers\Admin\ServiceRequestPaymentController;
use App\Http\Controllers\Admin\ServiceRequestSettingController;
use App\Http\Controllers\Admin\User\QualityAssuranceController;
use App\Http\Controllers\ServiceRequest\WarrantClaimController;
use App\Http\Controllers\Admin\User\TechnicianArtisanController;
use App\Http\Controllers\Supplier\SupplierRfqWarrantyController;
use App\Http\Controllers\Technician\TechnicianProfileController;
use App\Http\Controllers\Admin\Report\TechnicianReportController;
use App\Http\Controllers\ServiceRequest\ProjectProgressController;
use App\Http\Controllers\QualityAssurance\ServiceRequestController;
use App\Http\Controllers\ServiceRequest\AssignTechnicianController;
use App\Http\Controllers\Admin\User\Administrator\SummaryController;
use App\Http\Controllers\Admin\User\CustomerServiceExecutiveController;
use App\Http\Controllers\Supplier\RfqController as SupplierRfqController;
use App\Http\Controllers\QualityAssurance\QualityAssuranceProfileController;
use App\Http\Controllers\Client\MessageController as ClientMessageController;
use App\Http\Controllers\Admin\Report\CustomerServiceExecutiveReportController;
use App\Http\Controllers\CSE\CustomerServiceExecutiveController as CseController;
use App\Http\Controllers\Supplier\ProfileController as SupplierProfileController;
use App\Http\Controllers\Supplier\DispatchController as SupplierDispatchController;
use App\Http\Controllers\Admin\User\ClientController as AdministratorClientController;
use App\Http\Controllers\Admin\Prospective\SupplierController as ProspectiveSupplierController;
use App\Http\Controllers\Technician\ServiceRequestController as TechnicianServiceRequestController;

//use App\Http\Controllers\Client\MessageController as ClientMessageController;
use App\Http\Controllers\Admin\ServiceRequest\ActionsController as AdminServiceRequestActionsController;
use App\Http\Controllers\Admin\ServiceRequest\OngoingRequestController as AdminOngoingRequestController;
use App\Http\Controllers\Admin\ServiceRequest\PendingRequestController as AdminPendingRequestController;
use App\Http\Controllers\Client\ServiceRequest\ServiceRequestController as ClientRequestController;
use App\Http\Controllers\Admin\Report\WarrantyReportController;

/*
|--------------------------------------------------------------------------
| Web Routes ONLY AUTHENTICATED USERS HAVE ACCESS TO THIS ROUTE
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
| This routes contain the following middleware
| 1. web -> Laravels web group middlewares
| 2. setlocale -> Middleware to check user language using $request->segment(1)
|                 if $request->segment(1) is not in config('app.available_locales')
|                  default of config('app.locale') is used.
| 3. auth -> Laravels authentication middleware
|
| 4. permitted.user -> Middleware to check if user is permitted
|                      using $request->segment(2)
|                      and Authenticated User Type Url
*/


Route::prefix('admin')->name('admin.')->group(function () {
    //Route::view('/', 'admin.index')->name('index'); //Take me to Admin Dashboard
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::get('/ratings/job-performance', [AdminRatingController::class, 'cseDiagnosis'])->name('category');
    Route::get('/ratings/services',      [AdminRatingController::class, 'getServiceRatings'])->name('job');
    Route::get('/ratings/service_reviews',      [AdminReviewController::class, 'getServiceReviews'])->name('category_reviews');
    Route::get('/activate/{uuid}',      [AdminReviewController::class, 'activate'])->name('activate_review');
    Route::get('/deactivate/{uuid}',      [AdminReviewController::class, 'deactivate'])->name('deactivate_review');
    Route::get('/delete/{uuid}',      [AdminReviewController::class, 'delete'])->name('delete_review');
    Route::get('/get_ratings_by_service',    [AdminRatingController::class, 'getRatings'])->name('get_ratings_by_service');




    Route::prefix('users')->name('users.')->group(function () {
        Route::resource('administrator', AdministratorController::class);
        Route::resource('clients', AdministratorClientController::class);
        Route::resource('supplier', SupplierController::class);
        Route::resource('cse', CustomerServiceExecutiveController::class);
        Route::resource('franchisee', FranchiseeController::class);
        Route::resource('technician-artisan', TechnicianArtisanController::class);
        Route::resource('quality-assurance', QualityAssuranceController::class);
        Route::get('administrator/summary/{user:uuid}', [SummaryController::class, 'show'])->name('administrator.summary.show');
    });

    Route::prefix('prospective')->name('prospective.')->group(function () {
        Route::resource('cse', \App\Http\Controllers\Admin\Prospective\CSEController::class);
        Route::resource('supplier', ProspectiveSupplierController::class);
        Route::resource('technician-artisan', \App\Http\Controllers\Admin\Prospective\TechnicianArtisanController::class);
        Route::post('supplier-decision', [ProspectiveSupplierController::class, 'decision'])->name('supplier.decision');
        Route::post('cse-decision', [\App\Http\Controllers\Admin\Prospective\CSEController::class, 'decision'])->name('cse.decision');
    });

    //Routes for estate management
    Route::get('/estate/list',      [EstateController::class, 'index'])->name('list_estate');
    Route::get('/estate/add',      [EstateController::class, 'create'])->name('add_estate');
    Route::post('/estate/add',      [EstateController::class, 'store'])->name('store_estate');
    Route::get('/estate/summary/{estate:uuid}',      [EstateController::class, 'estateSummary'])->name('estate_summary');
    Route::get('/estate/edit/{estate:uuid}',      [EstateController::class, 'edit'])->name('edit_estate');
    Route::patch('/estate/edit/{estate:uuid}',      [EstateController::class, 'update'])->name('update_estate');
    Route::get('/estate/reinstate/{estate:uuid}',      [EstateController::class, 'reinstate'])->name('reinstate_estate');
    Route::get('/estate/deactivate/{estate:uuid}',      [EstateController::class, 'deactivate'])->name('deactivate_estate');
    Route::get('/estate/approve/{estate:uuid}',      [EstateController::class, 'approve'])->name('approve_estate');
    Route::get('/estate/decline/{estate:uuid}',      [EstateController::class, 'decline'])->name('decline_estate');
    Route::delete('/estate/delete/{estate:uuid}',      [EstateController::class, 'delete'])->name('delete_estate');

    //Routes for Warranty Management
    Route::get('/warranty',      [WarrantyController::class, 'index'])->name('warranty_list');
    Route::get('/warranty/summary/{details:uuid}',  [WarrantyController::class, 'show'])->name('warranty_summary');
    Route::post('/warranty/add',                    [WarrantyController::class, 'storeWarranty'])->name('save_warranty');
    Route::get('/warranty/edit/{details:uuid}',  [WarrantyController::class, 'edit'])->name('edit_warranty');
    Route::put('/warranty/update/{details:uuid}',  [WarrantyController::class, 'update'])->name('update_warranty');
    Route::get('/warranty/delete/{details:uuid}',  [WarrantyController::class, 'deleteWarranty'])->name('delete_warranty');
    Route::get('/warranty/issued',      [WarrantyController::class, 'issuedWarranties'])->name('issued_warranty');
    Route::get('/warranty/issued/resolved/{warranty:uuid}',      [WarrantyController::class, 'resolvedWarranty'])->name('mark_warranty_resolved');
    Route::get('/warranty/issued/details/{warranty:uuid}',       [CseController::class,  'warranty_details'])->name('warranty_details');
    Route::get('/resolved/warranty/details/{warranty:id}',          [WarrantyController::class, 'warranty_resolved_details'])->name('warranty_resolved_details');
    Route::get('/assign/cses/warranty/claim/{warranty:id}',          [WarrantyController::class, 'assign_cses'])->name('assign_cses');
    Route::post('/save/assigned/cse/warranty/claim/',          [WarrantyController::class, 'save_assigned_waranty_cse'])->name('save_assigned_waranty_cse');


    //Routes for Invoice Management
    Route::get('/invoices',      [InvoiceController::class, 'index'])->name('invoices');
    Route::get('/invoice/{invoice:uuid}', [InvoiceController::class, 'invoice'])->name('invoice');

    //Routes for Simulation
    Route::get('/diagnostic', [SimulationController::class, 'diagnosticSimulation'])->name('diagnostic');
    Route::get('/end-service/{service_request:uuid}', [SimulationController::class, 'endService'])->name('end_service');
    Route::get('/complete-service/{service_request:uuid}', [SimulationController::class, 'completeService'])->name('complete_service');
    Route::get('/invoice/{invoice:id}', [SimulationController::class, 'invoice'])->name('invoice');
    Route::get('/rfq-simulation', [SimulationController::class, 'rfqSimulation'])->name('rfq_simulation');

    //Routes for Income Management
    Route::get('/earnings', [EarningController::class, 'index'])->name('earnings');
    Route::get('/edit-earnings/{earning:uuid}', [EarningController::class, 'editEarning'])->name('edit_earnings');
    Route::patch('/update-earnings/{earning:uuid}', [EarningController::class, 'updateEarnings'])->name('update_earnings');
    Route::delete('/delete-earning/{earning:uuid}', [EarningController::class, 'deleteEarning'])->name('delete_earnings');
    Route::get('/income', [IncomeController::class, 'index'])->name('income');
    Route::get('/edit-income/{income:uuid}', [IncomeController::class, 'editIncome'])->name('edit_income');
    Route::patch('/update-income/{income:uuid}', [IncomeController::class, 'updateIncome'])->name('update_income');
    Route::delete('/delete-income/{income:uuid}', [IncomeController::class, 'deleteIncome'])->name('delete_income');
    Route::get('/income-history', [IncomeController::class, 'history'])->name('income_history');

    //Routes for Category Management
    Route::get('/categories/reassign/{category}',       [CategoryController::class, 'reassign'])->name('categories.reassign');
    Route::post('/categories/reassign-service',         [CategoryController::class, 'reassignService'])->name('categories.reassign_service');
    Route::get('/categories/deactivate/{category}',     [CategoryController::class, 'deactivate'])->name('categories.deactivate');
    Route::get('/categories/reinstate/{category}',      [CategoryController::class, 'reinstate'])->name('categories.reinstate');
    Route::get('/categories/delete/{category}',         [CategoryController::class, 'destroy'])->name('categories.delete');
    Route::resource('categories',                       CategoryController::class);

    //Routes for Services Management
    Route::get('/services/deactivate/{service:uuid}',        [ServiceController::class, 'deactivate'])
        ->name('services.deactivate');
    Route::get('/services/reinstate/{service:uuid}',         [ServiceController::class, 'reinstate'])->name('services.reinstate');
    Route::get('/services/delete/{service:uuid}',            [ServiceController::class, 'destroy'])->name('services.delete');
    Route::get('/services/sub-service/delete/{subService:uuid}',            [ServiceController::class, 'destroySubService'])->name('services.delete_sub_service');
    Route::resource('services',                         ServiceController::class);

    //  location request ajax_contactForm
    Route::get('/location-request',                     [AdminLocationRequestController::class, 'index'])->name('location_request');

    //  serviced areas
    Route::resource('seviced-areas',                     ServicedAreasController::class);

    //Routes for Activity Log Management
    Route::post('/activity-log/sorting',                [ActivityLogController::class, 'sortActivityLog'])->name('activity-log.sorting_users');
    Route::get('/activity-log/details/{activity_log}',  [ActivityLogController::class, 'activityLogDetails'])->name('activity-log.details');
    Route::resource('activity-log',                     ActivityLogController::class);

    //Routes for Tools & Tools Request Management
    Route::get('/tools/delete/{tool}',                  [ToolInventoryController::class, 'destroy'])->name('tools.delete');
    Route::resource('tools',                            ToolInventoryController::class);

    //Routes for Tax Management
    Route::get('/taxes/delete/{tax}',                   [TaxController::class, 'destroy'])->name('taxes.delete');
    Route::resource('taxes',                            TaxController::class);

    //Routes for Discount Management
    Route::get('/discount/add',                     [App\Http\Controllers\DiscountController::class, 'create'])->name('add_discount');
    Route::get('/discount/list',                       [App\Http\Controllers\DiscountController::class, 'index'])->name('discount_list');
    Route::post('/discount/add',                    [App\Http\Controllers\DiscountController::class, 'store'])->name('store_discount');
    Route::post('/LGA',                             [App\Http\Controllers\DiscountController::class, 'getLGA'])->name('getLGA');
    Route::post('/discount/estates',                             [App\Http\Controllers\DiscountController::class, 'estates'])->name('all_estates');
    Route::post('/categories-list',                             [App\Http\Controllers\DiscountController::class, 'category'])->name('categories');
    Route::post('/category-services',                             [App\Http\Controllers\DiscountController::class, 'categoryServices'])->name('category_services');
    Route::post('/discount-users',                    [App\Http\Controllers\DiscountController::class, 'discountUsers'])->name('discount_users');
    Route::post('/discount-users-edit',                    [App\Http\Controllers\DiscountEditController::class, 'discountUsersEdit'])->name('discount_users_edit');
    Route::get('/discount/edit/{discount:id}',                    [App\Http\Controllers\DiscountEditController::class, 'edit'])->name('edit_discount');
    Route::post('/categories-edit',                             [App\Http\Controllers\DiscountEditController::class, 'categoryEdit'])->name('categories_edit');
    Route::post('/category-services-edit',                             [App\Http\Controllers\DiscountEditController::class, 'categoryServicesEdit'])->name('category_services_edit');
    Route::post('/discount/edit',                    [App\Http\Controllers\DiscountEditController::class, 'editDiscount'])->name('store_discount_edit');
    Route::get('/discount/summary/{discount:id}',                    [App\Http\Controllers\DiscountController::class, 'show'])->name('summary');
    Route::get('/discount/delete/{discount:id}',                    [App\Http\Controllers\DiscountController::class, 'delete'])->name('delete_discount');
    Route::get('/discount/deactivate/{discount:id}',                    [App\Http\Controllers\DiscountController::class, 'deactivate'])->name('deactivate_discount');
    Route::get('/discount/activate/{discount:id}',                    [App\Http\Controllers\DiscountController::class, 'reinstate'])->name('activate_discount');
    Route::get('/discount/history',                       [App\Http\Controllers\DiscountHistoryController::class, 'index'])->name('discount_history');

    Route::get('/referral/add',                     [App\Http\Controllers\ReferralController::class, 'create'])->name('add_referral');
    Route::post('/referral/store',                    [App\Http\Controllers\ReferralController::class, 'store'])->name('referral_store');
    Route::get('/referral/list',                       [App\Http\Controllers\ReferralController::class, 'index'])->name('referral_list');
    Route::get('/referral/delete/{referral:id}',                    [App\Http\Controllers\ReferralController::class, 'delete'])->name('delete_referral');
    Route::get('/referral/deactivate/{referral:id}',                    [App\Http\Controllers\ReferralController::class, 'deactivate'])->name('deactivate_referral');
    Route::get('/referral/activate/{referral:id}',                    [App\Http\Controllers\ReferralController::class, 'reinstate'])->name('activate_referral');

    Route::get('/loyalty/add',                     [App\Http\Controllers\LoyaltyManagementController::class, 'create'])->name('add_loyalty');
    Route::post('/loyalty/store',                    [App\Http\Controllers\LoyaltyManagementController::class, 'store'])->name('loyalty_store');
    Route::get('/loyalty/list',                       [App\Http\Controllers\LoyaltyManagementController::class, 'index'])->name('loyalty_list');
    Route::post('/loyalty/users',                             [App\Http\Controllers\LoyaltyManagementController::class, 'loyaltyUsers'])->name('loyalty_users');
    Route::get('/loyalty/summary/{loyalty:id}',                    [App\Http\Controllers\LoyaltyManagementController::class, 'show'])->name('loyalty_summary');
    Route::get('/loyalty/delete/{loyalty:id}/{client:id}',                    [App\Http\Controllers\LoyaltyManagementController::class, 'delete'])->name('delete_loyalty');
    Route::get('/loyalty/edit/{loyalty:id}',                    [App\Http\Controllers\LoyaltyManagementController::class, 'edit'])->name('edit_loyalty');
    Route::post('/loyalty/users-edit',                             [App\Http\Controllers\LoyaltyManagementController::class, 'loyaltyUsersEdit'])->name('loyalty_users_edit');
    Route::post('/loyalty/store-edit',                    [App\Http\Controllers\LoyaltyManagementController::class, 'store_edit'])->name('loyalty_store_edit');
    Route::get('/loyalty/history',                    [App\Http\Controllers\LoyaltyManagementController::class, 'history'])->name('loyalty_history');

    //Admin payment Routes
    Route::get('/payment-gateway/list',                 [GatewayController::class, 'index'])->name('list_payment_gateway');
    Route::post('/paystack/update',                     [GatewayController::class, 'paystackUpdate'])->name('paystack_update');
    Route::post('/flutter/update',                      [GatewayController::class, 'flutterUpdate'])->name('flutter_update');

    // messaging routes messageTemplates
    Route::get('/messaging/templates',                   [Template::class, 'getAllTemplates'])->name('message_template');
    Route::view('/messaging/templates/new',                   'admin.messaging.template.new')->name('new_template');
    Route::view('/messaging/outbox',      'admin.messaging.email.outbox')->name('outbox');
    Route::view('/messaging/inbox',      'admin.messaging.email.inbox')->name('inbox');
    Route::view('/messaging/new',      'admin.messaging.email.new')->name('new_email');

    //Routes for E-Wallet Admin Management
    Route::get('/ewallet/clients',                      [EWalletController::class, 'clients'])->name('ewallet.clients');
    Route::get('/ewallet/client/history',               [EWalletController::class, 'clientHistory'])->name('ewallet.client_history');
    Route::get('/ewallet/transactions',                 [EWalletController::class, 'transactions'])->name('ewallet.transactions');

    //Routes for Price Management
    Route::resource('booking-fees',                     PriceController::class);

    //Routes for Status Management
    Route::get('/statuses/deactivate/{status:uuid}',         [StatusController::class, 'deactivate'])->name('statuses.deactivate');
    Route::get('/statuses/reinstate/{status:uuid}',          [StatusController::class, 'reinstate'])->name('statuses.reinstate');
    Route::get('/statuses/delete/{status:uuid}',             [StatusController::class, 'destroy'])->name('statuses.delete');
    Route::resource('statuses',                         StatusController::class);

    Route::get('/serviceCriteria/delete/{criteria}',              [ServiceRequestSettingController::class, 'destroy'])->name('serviceReq.delete');
    Route::resource('serviceCriteria',                            ServiceRequestSettingController::class);

    //Tool Request Management
    Route::get('/tools-request',                        [ToolsRequestController::class, 'index'])->name('tools_request');
    Route::get('/tools-request/details/{tool_request:uuid}',           [ToolsRequestController::class, 'toolRequestDetails'])->name('tool_request_details');
    Route::get('/tools-request/approve/{tool_request:uuid}',           [ToolsRequestController::class, 'approveRequest'])->name('approve_tool_request');
    Route::get('/tools-request/decline/{tool_request:uuid}',           [ToolsRequestController::class, 'declineRequest'])->name('decline_tool_request');
    Route::get('/tools-request/return/{tool_request:uuid}',            [ToolsRequestController::class, 'returnToolsRequested'])->name('return_tools_requested');

    Route::get('/supplier-invoices',                               [RfqController::class, 'supplierInvoices'])->name('supplier_invoices');
    Route::get('/supplier-invoices/details/{rfq:uuid}',            [RfqController::class, 'supplierInvoiceDetails'])->name('supplier_invoices_details');
    Route::get('/supplier-invoices/accept/{rfq:uuid}',             [RfqController::class, 'acceptSupplierInvoice'])->name('supplier_invoices_acceptance');

    Route::get('/requests-for-quote/details/image/{image:id}',     [RfqController::class, 'rfqDetailsImage'])->name('rfq_details_image');

    //Service Reques Routes
    Route::resource('requests-pending', AdminPendingRequestController::class);
    Route::resource('requests-ongoing', AdminOngoingRequestController::class);
    Route::get('/requests/action/complete/{request:uuid}',          [AdminServiceRequestActionsController::class, 'markCompletedRequest'])->name('request.mark_as_completed');

    //CSE Reporting Routes
    Route::get('/reports/client-service-executive',      [CustomerServiceExecutiveReportController::class, 'index'])->name('cse_reports');
    Route::post('/reports/client-service-executive/job-assigned-sorting',      [CustomerServiceExecutiveReportController::class, 'jobAssignedSorting'])->name('cse_report_first_sorting');
    Route::post('/reports/client-service-executive/amount-earned-sorting',      [CustomerServiceExecutiveReportController::class, 'amountEarnedSorting'])->name('cse_report_second_sorting');

    Route::get('/reports/supplier',             [SupplierReportController::class, 'index'])->name('supplier_reports');
    Route::post('/reports/supplier/item-delivered-sorting', [SupplierReportController::class, 'itemDeliveredSorting'])->name('supplier_report_first_sorting');

    //Routes for report management
    Route::get('/reports/sort_cse_report',      [ReportController::class, 'sortCSEReports'])->name('sort_cse_reports');
    Route::get('/reports/cse_report_details/{activity_log}',      [ReportController::class, 'cseReportDetails'])->name('report_details');
    Route::get('/reports/details/{details:uuid}',                 [ReportController::class, 'cseSummary'])->name('cse_report_details');

    Route::get('/requests-for-quote',                    [RfqController::class, 'index'])->name('rfq');
    Route::get('/requests-for-quote/details/{rfq:uuid}', [RfqController::class, 'rfqDetails'])->name('rfq_details');

    //Technician Reporting Routes
    Route::get('/reports/technician',  [TechnicianReportController::class, 'index'])->name('technician_reports');
    Route::post('/reports/technician/job-assigned-sorting',      [TechnicianReportController::class, 'jobAssignedSorting'])->name('technician_report_first_sorting');

    Route::get('/reports/supplier',             [SupplierReportController::class, 'index'])->name('supplier_reports');
    Route::post('/reports/supplier/item-delivered-sorting', [SupplierReportController::class, 'itemDeliveredSorting'])->name('supplier_report_first_sorting');

    //Admin Payments
    Route::get('/payments/pending', [CollaboratorsPaymentController::class, 'getPendingPayments'])->name('payments.pending');
    Route::get('/payments/disbursed', [CollaboratorsPaymentController::class, 'getdisbursedPayments'])->name('payments.disbursed');
    Route::post('payments.get_checkbox', [CollaboratorsPaymentController::class, 'getCheckbox'])->name('payments.get_checkbox');
    Route::post('/payment_sorting', [CollaboratorsPaymentController::class, 'sortPayments'])->name('payment_sorting');

    //Service Request Actions routes
    Route::post('requests/action/cancel/{cancel_request:uuid}', [AdminServiceRequestActionsController::class, 'cancelRequest'])->name('requests.cancel_request');

    Route::get('/payments/received', [ServiceRequestPaymentController::class, 'getReceivedPayments'])->name('payments.received');
    Route::post('/received_payment_sorting', [ServiceRequestPaymentController::class, 'sortReceivedPayments'])->name('received_payment_sorting');
  
    Route::get('/reports/warranty',  [WarrantyReportController::class, 'index'])->name('warranty_reports');
    Route::get('/reports/warranty/extended',  [WarrantyReportController::class, 'extended_warranty'])->name('extended_warranty_reports');
    Route::post('/reports/warranty/list-sorting',      [WarrantyReportController::class, 'listSorting'])->name('warranty_list_report_sorting');
    Route::post('/reports/warranty/extended/list-sorting',      [WarrantyReportController::class, 'extendedWarrantyListSorting'])->name('extended_warranty_list_report_sorting');

    

});

//All routes regarding clients should be in here
Route::prefix('client')->name('client.')->middleware('verified', 'monitor.clientservice.request.changes')->group(function () {
    //All routes regarding clients should be in here
    Route::get('/',                                      [ClientController::class, 'index'])->name('index'); //Take me to Supplier Dashboard

    // *****************Client profile**********************//
    Route::get('/settings',                              [ClientController::class, 'settings'])->name('settings');
    Route::post('/profile/update',                       [ClientController::class, 'update_profile'])->name('updateProfile');
    Route::post('/updatePassword',                       [ClientController::class, 'updatePassword'])->name('updatePassword');

    // Route::get('/requests',                              [ClientController::class, 'index'])->name('requests');
    Route::get('/requests/details/{request:uuid}',         [ClientController::class, 'clientRequestDetails'])->name('request_details');
    Route::get('/requests/edit/{request:uuid}',            [ClientController::class, 'editRequest'])->name('edit_request');
    Route::get('/requests/cancel/{request:id}',          [ClientController::class, 'cancelRequest'])->name('cancel_request');
    Route::get('/requests/send-messages',                [ClientController::class, 'sendMessages'])->name('send_messages');
    Route::post('/requests/update-request/{request:id}', [ClientController::class, 'updateRequest'])->name('update_request');
    Route::post('/requests/technician_profile',          [ClientController::class, 'technicianProfile'])->name('technician_profile');
    Route::get('/requests/warranty/{request:id}',          [ClientController::class, 'warrantyInitiate'])->name('warranty_initiate');
    Route::get('/requests/reinstate/{request:uuid}',          [ClientController::class, 'reinstateRequest'])->name('reinstate_request');
    Route::get('/requests/completed-request/{request:id}',          [ClientController::class, 'markCompletedRequest'])->name('completed_request');

    //Profile and password update
    Route::any('/getDistanceDifference',                 [ClientController::class, 'getDistanceDifference'])->name('getDistanceDifference');

    // *****************client wallet funding**********************//
    Route::get('wallet',                                [ClientController::class, 'wallet'])->name('wallet');
    Route::any('fund',                                  [ClientController::class, 'walletSubmit'])->name('wallet.submit');

    Route::get('loyalty',                            [ClientController::class, 'loyalty'])->name('loyalty');
    Route::any('loyalty/submit',                     [ClientController::class, 'loyaltySubmit'])->name('loyalty.submit');
    Route::get('payments',                           [ClientController::class, 'payments'])->name('payments');
    Route::get('payment/details/{payment:id}',   [ClientController::class, 'paymentDetails'])->name('payment.details');

    Route::any('/ipnpaystack',                       [ClientController::class, 'paystackIPN'])->name('ipn.paystack');
    Route::get('/apiRequest',                            [ClientController::class, 'apiRequest'])->name('ipn.paystackApiRequest');
    // for payment
    Route::any('/serviceRequestpaystack',                [ClientController::class, 'initiatePayment'])->name('serviceRequest.initiatePayment');
    Route::get('/serviceRequestVerify',                  [ClientController::class, 'verifyPayment'])->name('serviceRequest.verifyPayment');
    Route::any('/ipnflutter',                            [ClientController::class, 'flutterIPN'])->name('ipn.flutter');

    // Service request SECTION
    Route::get('/services',                     [ClientController::class, 'services'])->name('services.list');
    Route::get('services/quote/{service:uuid}',      [ClientRequestController::class, 'show'])->name('services.quote')->whereUuid('service');
    Route::get('services/details/{service}',    [ClientController::class, 'serviceDetails'])->name('services.details');
    Route::post('services/search',              [ClientController::class, 'search'])->name('services.search');
    Route::get('services/custom/',              [ClientController::class, 'customService'])->name('services.custom');

    Route::any('invoicePayment',                [InvoiceController::class, 'savePayment'])->name('invoice.payment');
    Route::get('verify/invoicePayment',         [InvoiceController::class, 'verifyPayment'])->name('invoice.verifyPayment');
    Route::any('/invoiceRequestpaystack',       [InvoiceController::class, 'initiatePayment'])->name('invoice.initiatePayment');

    // *****************my service request**********************//
    Route::get('requests',                     [ClientController::class, 'myServiceRequest'])->name('service.all');
    Route::get('/requests/details/{ref}',      [ClientController::class, 'requestDetails'])->name('client.request_details');
    Route::get('/requests/edit/{id}',          [ClientController::class, 'editRequest'])->name('client.edit_request');
    Route::put('/requests/update/{id}',        [ClientController::class, 'update'])->name('client.update_request');

    // Client Warranty Invoice Decision
    Route::put('/update-warranty/{invoice:uuid}', [InvoiceController::class, 'updateInvoice'])->name('warranty_decision');

    Route::post('servicesRequest',              [ClientController::class, 'serviceRequest'])->name('services.serviceRequest');
    // add my new contact to DB
    Route::post('/create-new-client-contact',            [ClientController::class, 'createNewClientContact'])->name('ajax_contactForm');

    Route::get('myContactList',                 [ClientController::class, 'myContactList'])->name('service.myContacts');

    Route::post('/update_service_request',  [ClientController::class, 'update_client_service_rating'])->name('update_service_request');
    Route::post('/submit_ratings',  [ClientController::class, 'client_rating'])->name('handle.ratings');
    Route::get('/discount_mail',  [ClientController::class, 'discount_mail'])->name('discount_mail');

    Route::post('available-tool-quantity', [CseController::class, 'getAvailableToolQuantity'])->name('available.tools');
    Route::post('get-sub-service-list', [CseController::class, 'getSubServices'])->name('needed.sub_service');

    //Client messaging routes
    Route::resource('messages',         ClientMessageController::class);

    Route::post('invoicePayment', [InvoiceController::class, 'invoicePayment'])->name('invoice_payment');
    Route::get('initialize-invoice-request/{payment:reference_id}', [InvoiceController::class, 'init'])->name('invoice_payment.init');

    //Client service request routes
    Route::resource('service-request',  ClientRequestController::class);
    Route::get('initialize-service-request/{payment:reference_id}', [ClientRequestController::class, 'init'])->name('service_request.init');
    Route::post('service-request/verify-service-area',  [ClientRequestController::class, 'verifyServiceArea'])->name('service-request.validate_service_area');
});

Route::prefix('cse')->name('cse.')->middleware('monitor.cseservice.request.changes')->group(function () {
    //All routes regarding CSE's should be in here
    Route::get('/', [CseController::class, 'index'])->name('index'); //Take me to CSE Dashboard
    Route::post('accept-service-request', [CseController::class, 'setJobAcceptance'])->name('accept-job');
    Route::post('cse-availablity-request', [CseController::class, 'setAvailablity'])->name('availablity');

    Route::post('available-tool-quantity', [CseController::class, 'getAvailableToolQuantity'])->name('available.tools');
    Route::post('get-sub-service-list', [CseController::class, 'getSubServices'])->name('needed.sub_service');

    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('index');
        Route::get('edit', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('edit', [ProfileController::class, 'update'])->name('update');
        Route::post('change-password', [ProfileController::class, 'change_password'])->name('change-password');
    });

    Route::middleware('throttle:6,1')->group(function () {
        Route::post('notify-client-schedule-date', [RequestController::class, 'sendNotification'])->name('notify.client');

        Route::get('requests/status', [RequestController::class, 'search'])->name('requests.status');
        Route::resource('requests', RequestController::class);

        // All incoming service request actions
        Route::post('service-request-action/{service_request:uuid}', [\App\Http\Controllers\ServiceRequest\RequestActionController::class, 'incoming'])->name('service.request.action')->whereUuid('service_request');

        Route::post('project-progress', [ProjectProgressController::class, '__invoke'])->name('project.progress.update');
        Route::post('/submit_ratings',  [CseController::class, 'user_rating'])->name('handle.ratings');
        Route::post('/update_service_request',  [CseController::class, 'update_cse_service_rating'])->name('update_service_request');
    });


    Route::view('/messages/inbox', 'cse.messages.inbox')->name('messages.inbox');
    Route::view('/messages/sent', 'cse.messages.sent')->name('messages.sent');
    Route::view('/payments', 'cse.payments')->name('payments');
    Route::resource('requests', RequestController::class);

    Route::post('assign-technician', [AssignTechnicianController::class, '__invoke'])->name('assign.technician');
    Route::post('project-progress', [ProjectProgressController::class, '__invoke'])->name('project.progress.update');
    Route::post('/submit_ratings',  [CseController::class, 'user_rating'])->name('handle.ratings');
    Route::post('/update_service_request',  [CseController::class, 'update_cse_service_rating'])->name('update_service_request');

    Route::post('assign/warranty/technician', [WarrantClaimController::class, 'store'])->name('assign.warranty_technician');
    Route::get('warranty/download/{file:id}', [WarrantyController::class, 'download'])->name('warranty_download');


    Route::get('/cse/accept/warranty/claims/{warranty:id}',          [CseWarrantyClaimController::class, 'accept_warranty_claim'])->name('accept_warranty_claim');
    Route::get('/warranty/claims/list', [CseController::class, 'warranty_claims_list'])->name('warranty_claims_list');
    Route::get('/warranty-claims/details', [CseController::class, 'warranty_claims'])->name('warranty_claims');

    Route::get('/warranty/claims/details/{warranty:uuid}',      [CseController::class, 'warranty_details'])->name('warranty_details');
    Route::get('/warranty/resolved/claims/details/{warranty:id}',          [WarrantyController::class, 'warranty_resolved_details'])->name('warranty_resolved_details');
    Route::get('/mark/warrant/claims/resolved/{warranty:uuid}',      [WarrantyController::class, 'resolvedWarranty'])->name('mark_warranty_resolved');
    Route::get('/requests-for-quote/details/image/{image:id}',            [RequestController::class, 'rfqDetailsImage'])->name('rfq_details_image');

    Route::get('/sub-service-dynamic-feilds',  [CseController::class, 'subServiceDynamicFields'])->name('sub_service_dynamic_fields');
    Route::get('/tools-request/details/{tool_request:uuid}',           [RequestController::class, 'toolRequestDetails'])->name('tool_request_details');
    Route::get('/warranty/supplier/details/image/{image:id}',            [WarrantClaimController::class, 'rfqDetailsImage'])->name('rfq_waranty_details_image');
});

Route::prefix('supplier')->name('supplier.')->group(function () {
    //All routes regarding suppliers should be in here
    Route::get('/',                    [SupplierProfileController::class, 'dashboard'])->name('index'); //Take me to Supplier Dashboard
    Route::view('/messages/inbox',      'supplier.messages.inbox')->name('messages.inbox');
    Route::view('/messages/sent',       'supplier.messages.sent')->name('messages.sent');
    Route::view('/payments',            'supplier.payments')->name('payments');
    Route::get('/profile',             [SupplierProfileController::class, 'index'])->name('view_profile');
    Route::get('/profile/edit',        [SupplierProfileController::class, 'show'])->name('edit_profile');
    Route::get('/requests-for-quote',                               [SupplierRfqController::class, 'index'])->name('rfq');
    Route::get('/requests-for-quote/details/{rfq:uuid}',            [SupplierRfqController::class, 'rfqDetails'])->name('rfq_details');
    Route::get('/request-for-quotes/details/{rfq:uuid}',            [SupplierRfqController::class, 'linkRfqDetails'])->name('rfq_link_details');
    Route::get('/requests-for-quote/send-invoice/{rfq:uuid}',       [SupplierRfqController::class, 'sendInvoice'])->name('rfq_send_supplier_invoice');
    Route::post('/rfqs/store/',                       [SupplierRfqController::class, 'store'])->name('rfq_store_supplier_invoice');
    Route::get('/invoices/sent',                      [SupplierRfqController::class, 'sentInvoices'])->name('rfq_sent_invoices');
    Route::get('/invoices/approved',                  [SupplierRfqController::class, 'approvedInvoices'])->name('rfq_approved_invoices');
    Route::get('/invoices/declined',                  [SupplierRfqController::class, 'declinedInvoices'])->name('rfq_declined_invoices');
    Route::get('/sent-invoices/details/{rfq:id}',     [SupplierRfqController::class, 'sentInvoiceDetails'])->name('sent_supplier_invoice_details');
    Route::put('/profile/update-password',            [SupplierProfileController::class, 'updatePassword'])->name('update_profile_password');
    Route::resource('profile-updates',                SupplierProfileController::class);
    Route::get('/dispatch',                          [SupplierDispatchController::class, 'index'])->name('dispatches');
    Route::get('/dispatch/details/{dispatch:id}',     [SupplierDispatchController::class, 'dispatchDetails'])->name('dispatch_details');
    Route::get('/dispatch/generate/',                 [SupplierDispatchController::class, 'generateDeliveryCode'])->name('generate_dispatch_code');
    Route::post('/dispatch/store/',                   [SupplierDispatchController::class, 'store'])->name('store_dispatch');
    Route::get('/dispatch/update/{dispatch:id}',     [SupplierDispatchController::class, 'updateDispatchStatus'])->name('update_dispatch_status');
    Route::get('/dispatch/delivered',                          [SupplierDispatchController::class, 'dispatchDelivered'])->name('dispatches_delivered');
    Route::get('/dispatch/returned',                          [SupplierDispatchController::class, 'dispatchReturned'])->name('dispatches_returned');
    Route::post('/warranty/replacement/notify/{dispatch:id}',                          [SupplierRfqController::class, 'warrantyReplacementNotify'])->name('warranty_replacement_notify');
    Route::get('/requests-for-quote/details/image/{image:id}',            [SupplierRfqController::class, 'rfqDetailsImage'])->name('rfq_details_image');
    Route::get('/requests/warranty/claims/quote',                               [SupplierRfqWarrantyController::class, 'index'])->name('rfq.warranty');

    Route::post('/rfqs/warranty/claims/store',                               [SupplierRfqWarrantyController::class, 'store'])->name('rfq_store_supplier_warranty_claim');
    Route::get('/warranty-claim/requests-for-quote/send-invoice/{rfq:uuid}',       [SupplierRfqWarrantyController::class, 'sendInvoice'])->name('rfq_warranty_send_supplier_invoice');
    Route::get('/requests-for-quote/warranty/details/{rfq:uuid}',            [SupplierRfqController::class, 'rfqDetails'])->name('rfq_warranty_details');
    Route::post('/warranty/replacement/notify/{dispatch:id}',                          [SupplierRfqController::class, 'warrantyReplacementNotify'])->name('warranty_replacement_notify');
    Route::get('/requests-for-quote/details/image/{image:id}',            [SupplierRfqController::class, 'rfqDetailsImage'])->name('rfq_details_image');
    Route::get('/requests-for-quote/warranty/details/{rfq:uuid}',            [SupplierRfqController::class, 'rfqDetails'])->name('rfq_warranty_details');
    Route::get('/warranty/invoices/sent',                      [SupplierRfqWarrantyController::class, 'sentInvoices'])->name('warranty_sent_invoices');
    Route::post('/warranty/dispatch/store/',                   [WarrantyDispatchController::class, 'store'])->name('warranty_store_dispatch');
    Route::get('/warranty/dispatch',                          [WarrantyDispatchController::class, 'index'])->name('warranty_dispatches');

    Route::get('/requests-for-quote/warranty/details/{rfq:uuid}',            [SupplierRfqController::class, 'rfqDetails'])->name('rfq_warranty_details');
});

Route::prefix('technician')->name('technician.')->group(function () {
    //All routes regarding technicians should be in here
    Route::get('/',                                 [TechnicianProfileController::class, 'index'])->name('index');    //Take me to Technician Dashboard
    Route::get('/location-request',                 [TechnicianProfileController::class, 'locationRequest'])->name('location_request');
    Route::get('/requests',                         [TechnicianProfileController::class, 'serviceRequests'])->name('requests');
    Route::get('/requests/details/{details:uuid}',                 [TechnicianProfileController::class, 'serviceRequestDetails'])->name('request_details');

    Route::get('/profile',                         [TechnicianProfileController::class, 'viewProfile'])->name('view_profile');
    Route::get('/profile/edit',                     [TechnicianProfileController::class, 'editProfile'])->name('edit_profile');
    Route::patch('/update_profile',                     [TechnicianProfileController::class, 'updateProfile'])->name('update_profile');
    Route::patch('/update_password',                     [TechnicianProfileController::class, 'updatePassword'])->name('update_password');
    Route::get('/payments', [TechnicianProfileController::class, 'get_technician_disbursed_payments'])->name('payments');
    Route::post('/disbursed_payments_sorting', [TechnicianProfileController::class, 'sortDisbursedPayments'])->name('disbursed_payments_sorting');
    Route::view('/messages/inbox', 'technician.messages.inbox')->name('messages.inbox');
    Route::view('/messages/sent', 'technician.messages.outbox')->name('messages.outbox');
    Route::get('/requests/active',  [TechnicianServiceRequestController::class, 'getActiveRequests'])->name('requests.active');
    Route::get('/requests/completed',  [TechnicianServiceRequestController::class, 'getCompletedRequests'])->name('requests.completed');
    Route::get('/requests/cancelled',  [TechnicianServiceRequestController::class, 'getCancelledRequests'])->name('requests.cancelled');
    Route::get('/requests/warranty-claim', [TechnicianServiceRequestController::class, 'getWarranties'])->name('requests.warranty_claim');
    Route::get('/requests/active_details/{uuid}', [TechnicianServiceRequestController::class, 'acceptedJobDetails'])->name('requests.active_details');


    Route::get('/payments/history', [TechnicianProfileController::class, 'paymentHistory'])->name('payment.history');




    Route::view('/consultations/pending', 'technician.consultations.pending')->name('consultations.pending');
    Route::view('/consultations/ongoing', 'technician.consultations.ongoing')->name('consultations.ongoing');
    Route::view('/consultations/completed', 'technician.consultations.completed')->name('consultations.completed');
});

Route::prefix('quality-assurance')->name('quality-assurance.')->group(function () {
    //All routes regarding quality_assurance should be in here
    Route::get('/', [ServiceRequestController::class, 'index'])->name('index');
    Route::get('/profile',    [QualityAssuranceProfileController::class, 'view_profile'])->name('view_profile');
    Route::get('/profile/edit_profile', [QualityAssuranceProfileController::class, 'edit'])->name('edit_profile');
    Route::patch('/profile/update_profile', [QualityAssuranceProfileController::class, 'update'])->name('update_profile');
    Route::patch('/update_password', [QualityAssuranceProfileController::class, 'update_password'])->name('update_password');
    Route::get('/requests', [ServiceRequestController::class, 'get_requests'])->name('requests');
    Route::get('/payments', [PaymentController::class, 'get_qa_disbursed_payments'])->name('payments');
    Route::get('payment_details/{payment:id}',   [PaymentController::class, 'paymentDetails'])->name('payment_details');

    Route::get('/accept_job/{uuid}',  [ServiceRequestController::class, 'QaJobAccept'])->name('accept_job');
    Route::view('/messages/sent', 'quality-assurance.messages.sent')->name('messages.sent');
    Route::view('/messages/inbox', 'quality-assurance.messages.inbox')->name('messages.inbox');
    Route::get('/requests/active', [ServiceRequestController::class, 'getActiveJobs'])->name('requests.active');
    Route::get('/requests/completed', [ServiceRequestController::class, 'getCompletedJobs'])->name('requests.completed');
    Route::get('/requests/cancelled', [ServiceRequestController::class, 'getCancelledJobs'])->name('requests.cancelled');
    Route::get('/requests/active_details/{uuid}', [ServiceRequestController::class, 'acceptedJobDetails'])->name('requests.active_details');
    Route::get('/requests/warranty_claim', [ServiceRequestController::class, 'getWarranties'])->name('requests.warranty_claim');
    Route::get('/requests/warranty/{uuid}', [ServiceRequestController::class, 'warrantyDetails'])->name('requests.warranty');
    Route::get('/consultations/pending', [ServiceRequestController::class, 'getPendingConsultations'])->name('consultations.pending');
    Route::get('/consultations/ongoing', [ServiceRequestController::class, 'getOngoingConsultations'])->name('consultations.ongoing');
    Route::get('/consultations/ongoing_details/{uuid}', [ServiceRequestController::class, 'getOngoingConsultationDetails'])->name('consultations.ongoing_details');
    Route::get('/consultations/completed', [ServiceRequestController::class, 'getCompletedConsultations'])->name('consultations.completed');
    Route::post('/disbursed_payments_sorting', [PaymentController::class, 'sortDisbursedPayments'])->name('disbursed_payments_sorting');
    Route::get('/get_chart_data', [ServiceRequestController::class, 'chat_data']);
    Route::get('/consultations/pending_details/{uuid}',  [ServiceRequestController::class, 'show'])->name('consultations.pending_details');
});

Route::prefix('franchisee')->name('franchisee.')->group(function () {
    Route::view('/',                'franchisee.index')->name('index'); //Take me to frnahisee Dashboard
    Route::view('/messages/inbox',      'franchisee.messages.inbox')->name('messages.inbox');
    Route::view('/messages/sent',       'franchisee.messages.sent')->name('messages.sent');
    Route::view('/payments',            'franchisee.payments')->name('payments');
    Route::view('/requests',            'franchisee.requests')->name('requests');
    Route::view('/requests/details',    'franchisee.request_details')->name('request_details');
    Route::view('/profile',             'franchisee.view_profile')->name('view_profile');
    Route::view('/profile/edit',        'franchisee.edit_profile')->name('edit_profile');
    Route::view('/location-request',    'franchisee.location_request')->name('location_request');
});
