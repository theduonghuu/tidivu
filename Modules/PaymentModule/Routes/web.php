<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix'=>'payment','middleware'=>['detectUser']],function () {

    //SSLCOMMERZ
    Route::group(['prefix'=>'sslcommerz','as'=>'sslcommerz.'], function () {
        Route::get('pay','SslCommerzPaymentController@index');
        Route::post('success','SslCommerzPaymentController@success');
        Route::post('failed','SslCommerzPaymentController@failed');
        Route::post('canceled','SslCommerzPaymentController@canceled');
    });

    //STRIPE
    Route::group(['prefix'=>'stripe','as'=>'stripe.'], function () {
        Route::get('pay','StripePaymentController@index');
        Route::get('token','StripePaymentController@payment_process_3d')->name('token')->WithoutMiddleware('detectUser');
        Route::any('success','StripePaymentController@success')->name('success')->WithoutMiddleware('detectUser');
    });

    //RAZOR-PAY
    Route::group(['prefix'=>'razor-pay','as'=>'razor-pay.'], function () {
        Route::get('pay','RazorPayController@index');
        Route::post('payment','RazorPayController@payment')->name('payment')->WithoutMiddleware('detectUser');
    });

    //PAYPAL
    Route::group(['prefix'=>'paypal','as'=>'paypal.'], function () {
        Route::get('pay','PaypalPaymentController@index');
        Route::any('callback','StripePaymentController@callback')->name('callback');
        Route::any('failed','StripePaymentController@failed')->name('failed');
    });

    //SENANG-PAY
    Route::group(['prefix'=>'senang-pay','as'=>'senang-pay.'], function () {
        Route::get('pay','SenangPayController@index');
        //
    });

    //PAYTM
    Route::group(['prefix'=>'paytm','as'=>'paytm.'], function () {
        Route::get('pay','PaytmController@payment');
        Route::any('response','PaytmController@response')->name('response');
    });

    //FLUTTERWAVE
    Route::group(['prefix'=>'flutterwave','as'=>'flutterwave.'], function () {
        Route::get('pay','FlutterwaveController@initialize')->name('pay');
        Route::get('callback', 'FlutterwaveController@callback')->name('callback')->WithoutMiddleware('detectUser');
    });

    //PAYSTACK
    Route::group(['prefix'=>'paystack','as'=>'paystack.'], function () {
        Route::get('pay','PaystackController@index')->name('pay');
        Route::post('payment','PaystackController@redirectToGateway')->name('payment')->WithoutMiddleware('detectUser');
        Route::get('callback', 'PaystackController@handleGatewayCallback')->name('callback');
    });

});



Route::group(['prefix' => 'admin', 'as'=>'admin.', 'namespace' => 'Web\Admin','middleware'=>['admin','mpc:system_management']], function () {
    Route::group(['prefix'=>'configuration','as'=>'configuration.'],function (){
        Route::get('payment-get', 'PaymentConfigController@payment_config_get')->name('payment-get');
        Route::put('payment-set', 'PaymentConfigController@payment_config_set')->name('payment-set');
    });
});
