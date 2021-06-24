<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        view()->composer('layouts.client', function ($view) {

            $view->with([
                'profile'   =>  \App\Models\User::where('id', auth()->user()->id)->with('account', 'client', 'lastActivityLog', 'clientWalletBalance')->firstOrFail(),
            ]);
        });

        view()->composer('layouts.dashboard', function ($view) {

            $view->with([
                'profile'   =>  auth()->user()->account,
                'pendingRequests'   => \App\Models\ServiceRequest::PendingRequests()->get()->count(),
                'unresolvedWarranties'  =>  \App\Models\ServiceRequestWarranty::UnresolvedWarranties()->get()->count(),
                'RfqDispatchNotification' =>\App\Models\RfqDispatchNotification::where(['supplier_id' => auth()->user()->id, 'notification'=> 'On' ])->with('rfq', 'service_request')->latest('created_at')->get(),
                'newQuotes' =>  \App\Models\Rfq::PendingQuotes()->get()->count(),
                'toolRequests'  =>  \App\Models\ToolRequest::PendingRequests()->get()->count(),

            ]);
        });

        view()->composer('layouts.partials._cse_sidebar', function ($view) {
            $view->with([
                'cse_availability' => \App\Models\Cse::isAvailable() ? ['Available', 'checked'] : ['Unavailable', ''],
                'unresolvedWarranties' =>\App\Models\ServiceRequestWarranty::with('user.account', 'service_request', 'warranty', 'service_request_warranty_issued')->get()->count(),

                ]);
        });

        view()->composer('layouts.partials._supplier_sidebar', function ($view) {
            $view->with([
                'newQuotes' =>  \App\Models\Rfq::PendingQuotes()->get()->count(),
                'warrantyQuotes' =>  \App\Models\Rfq::orderBy('created_at', 'DESC')->where('type', '=', 'warranty')->count(),
                'RfqDispatchNotification' =>\App\Models\RfqDispatchNotification::where(['supplier_id' => auth()->user()->id ])->with('rfq', 'service_request')->latest('created_at')->get(),


            ]);
        });
        // view()->composer('layouts.partials._supplier_sidebar', function ($view) {
        //     $view->with([
        //         'newQuotes' =>  \App\Models\Rfq::PendingQuotes()->get()->count(),
        //     ]);
        // });
    }
}
