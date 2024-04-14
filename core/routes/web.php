<?php

use Illuminate\Support\Facades\Route;

Route::get('/clear', function(){
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
});
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::namespace('Gateway')->prefix('ipn')->name('ipn.')->group(function () {
    Route::post('paypal', 'Paypal\ProcessController@ipn')->name('Paypal');
    Route::get('paypal-sdk', 'PaypalSdk\ProcessController@ipn')->name('PaypalSdk');
    Route::post('perfect-money', 'PerfectMoney\ProcessController@ipn')->name('PerfectMoney');
    Route::post('stripe', 'Stripe\ProcessController@ipn')->name('Stripe');
    Route::post('stripe-js', 'StripeJs\ProcessController@ipn')->name('StripeJs');
    Route::post('stripe-v3', 'StripeV3\ProcessController@ipn')->name('StripeV3');
    Route::post('skrill', 'Skrill\ProcessController@ipn')->name('Skrill');
    Route::post('paytm', 'Paytm\ProcessController@ipn')->name('Paytm');
    Route::post('payeer', 'Payeer\ProcessController@ipn')->name('Payeer');
    Route::post('paystack', 'Paystack\ProcessController@ipn')->name('Paystack');
    Route::post('voguepay', 'Voguepay\ProcessController@ipn')->name('Voguepay');
    Route::get('flutterwave/{trx}/{type}', 'Flutterwave\ProcessController@ipn')->name('Flutterwave');
    Route::post('razorpay', 'Razorpay\ProcessController@ipn')->name('Razorpay');
    Route::post('instamojo', 'Instamojo\ProcessController@ipn')->name('Instamojo');
    Route::get('blockchain', 'Blockchain\ProcessController@ipn')->name('Blockchain');
    Route::get('blockio', 'Blockio\ProcessController@ipn')->name('Blockio');
    Route::post('coinpayments', 'Coinpayments\ProcessController@ipn')->name('Coinpayments');
    Route::post('coinpayments-fiat', 'Coinpayments_fiat\ProcessController@ipn')->name('CoinpaymentsFiat');
    Route::post('coingate', 'Coingate\ProcessController@ipn')->name('Coingate');
    Route::post('coinbase-commerce', 'CoinbaseCommerce\ProcessController@ipn')->name('CoinbaseCommerce');
    Route::get('mollie', 'Mollie\ProcessController@ipn')->name('Mollie');
    Route::post('cashmaal', 'Cashmaal\ProcessController@ipn')->name('Cashmaal');
    Route::post('authorize-net', 'AuthorizeNet\ProcessController@ipn')->name('AuthorizeNet');
    Route::post('2check-out', 'TwoCheckOut\ProcessController@ipn')->name('TwoCheckOut');
    Route::post('mercado-pago', 'MercadoPago\ProcessController@ipn')->name('MercadoPago');
});

// User Support Ticket
Route::prefix('ticket')->group(function () {
    Route::get('/', 'TicketController@supportTicket')->name('ticket');
    Route::get('/new', 'TicketController@openSupportTicket')->name('ticket.open');
    Route::post('/create', 'TicketController@storeSupportTicket')->name('ticket.store');
    Route::get('/view/{ticket}', 'TicketController@viewTicket')->name('ticket.view');
    Route::post('/reply/{ticket}', 'TicketController@replyTicket')->name('ticket.reply');
    Route::get('/download/{ticket}', 'TicketController@ticketDownload')->name('ticket.download');
});


/*
|--------------------------------------------------------------------------
| Start Admin Area
|--------------------------------------------------------------------------
*/

Route::namespace('Admin')->prefix('admin')->name('admin.')->group(function () {
    Route::namespace('Auth')->group(function () {
        Route::get('/', 'LoginController@showLoginForm')->name('login');
        Route::post('/', 'LoginController@login')->name('login');
        Route::get('logout', 'LoginController@logout')->name('logout');
        // Admin Password Reset
        Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.reset');
        Route::post('password/reset', 'ForgotPasswordController@sendResetCodeEmail');
        Route::post('password/verify-code', 'ForgotPasswordController@verifyCode')->name('password.verify.code');
        Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset.form');
        Route::post('password/reset/change', 'ResetPasswordController@reset')->name('password.change');
    });

    Route::middleware('admin')->group(function () {
        Route::get('dashboard', 'AdminController@dashboard')->name('dashboard');

        // Generate Pin Controller 
        Route::get('generatepin', 'GeneratePinController@index')->name('generatepin.index');
        Route::get('generatepin/create', 'GeneratePinController@create')->name('generatepin.create');
        Route::post('getpin', 'GeneratePinController@getPin')->name('getpin');
        Route::post('update_payment_status', 'ManageUsersController@updatePaymentStatus')->name('update_payment_status');
        Route::post('generatepin/store', 'GeneratePinController@store')->name('generatepin.store');
        Route::post('generatepin/remove', 'GeneratePinController@remove')->name('generatepin.remove');

        // Category Controller
        Route::get('category', 'CategoryController@index')->name('category.index');
        Route::get('category/create', 'CategoryController@create')->name('category.create');
        Route::post('category/store', 'CategoryController@store')->name('category.store');
        Route::get('category/edit/{id}', 'CategoryController@edit')->name('category.edit');
        Route::post('category/update/{id}', 'CategoryController@update')->name('category.update');
        Route::post('category/remove', 'CategoryController@remove')->name('category.remove');
        //Helps
        Route::get('provide-help', 'HelpController@provide_help')->name('provide_help');
        Route::get('get-help', 'HelpController@get_help')->name('get_help');
        // Web tasks
        Route::get('webtasksuploads', 'HelpController@webTasksUploads')->name('web_tasks.upload');
        Route::post('webtasksuploads-upload', 'HelpController@webTasksUploadsPost')->name('upload_a_task');
        Route::get('userWebTaskSubmissionGet', 'HelpController@userWebTaskSubmission')->name('userWebTaskSubmission');
        
        Route::get('provide-help/edit/{id}', 'HelpController@provide_help_edit')->name('provide_help.edit');
        Route::get('get-help/edit/{id}', 'HelpController@get_help_edit')->name('get_help.edit');
        Route::post('provide-help/update/{id}', 'HelpController@provide_help_update')->name('provide_help.update');
        Route::post('get-help/update/{id}', 'HelpController@get_help_update')->name('get_help.update');
        // Product Controller
        Route::get('product', 'ProductController@index')->name('product.index');
        Route::get('product/create', 'ProductController@create')->name('product.create');
        Route::post('product/store', 'ProductController@store')->name('product.store');
        Route::get('product/edit/{id}', 'ProductController@edit')->name('product.edit');
        Route::post('product/update/{id}', 'ProductController@update')->name('product.update');
        Route::post('product/remove', 'ProductController@remove')->name('product.remove');

        // Order Controller
        Route::get('order', 'OrderController@getOrder')->name('order.index');
        Route::get('order/{id}', 'OrderController@list')->name('order.list');
        Route::post('admin.update', 'OrderController@changeStatus')->name('update');

        Route::get('profile', 'AdminController@profile')->name('profile');
        Route::post('profile', 'AdminController@profileUpdate')->name('profile.update');
        Route::get('password', 'AdminController@password')->name('password');
        Route::post('password', 'AdminController@passwordUpdate')->name('password.update');

        //Notification
        Route::get('notifications','AdminController@notifications')->name('notifications');
        Route::get('notification/read/{id}','AdminController@notificationRead')->name('notification.read');
        Route::get('notifications/read-all','AdminController@readAll')->name('notifications.readAll');

        //Report Bugs
        Route::get('request-report','AdminController@requestReport')->name('request.report');
        Route::post('request-report','AdminController@reportSubmit');
        Route::get('system-info','AdminController@systemInfo')->name('system.info');


        // Users Manager
        Route::get('users', 'ManageUsersController@allUsers')->name('users.all');
        Route::get('users/active', 'ManageUsersController@activeUsers')->name('users.active');
        Route::get('users/banned', 'ManageUsersController@bannedUsers')->name('users.banned');
        Route::get('users/email-verified', 'ManageUsersController@emailVerifiedUsers')->name('users.email.verified');
        Route::get('users/email-unverified', 'ManageUsersController@emailUnverifiedUsers')->name('users.email.unverified');
        Route::get('users/sms-unverified', 'ManageUsersController@smsUnverifiedUsers')->name('users.sms.unverified');
        Route::get('users/sms-verified', 'ManageUsersController@smsVerifiedUsers')->name('users.sms.verified');
        Route::get('users/with-balance', 'ManageUsersController@usersWithBalance')->name('users.with.balance');

        Route::get('users/{scope}/search', 'ManageUsersController@search')->name('users.search');
        Route::get('user/detail/{id}', 'ManageUsersController@detail')->name('users.detail');
        Route::post('user/update/{id}', 'ManageUsersController@update')->name('users.update');
        Route::post('user/add-sub-balance/{id}', 'ManageUsersController@addSubBalance')->name('users.add.sub.balance');
        Route::get('user/send-email/{id}', 'ManageUsersController@showEmailSingleForm')->name('users.email.single');
        Route::post('user/send-email/{id}', 'ManageUsersController@sendEmailSingle')->name('users.email.single');
        Route::get('user/login/{id}', 'ManageUsersController@login')->name('users.login');
        Route::get('user/transactions/{id}', 'ManageUsersController@transactions')->name('users.transactions');
        Route::get('user/deposits/{id}', 'ManageUsersController@deposits')->name('users.deposits');
        Route::get('user/deposits/via/{method}/{type?}/{userId}', 'ManageUsersController@depositViaMethod')->name('users.deposits.method');
        Route::get('user/withdrawals/{id}', 'ManageUsersController@withdrawals')->name('users.withdrawals');
        Route::get('user/withdrawals/via/{method}/{type?}/{userId}', 'ManageUsersController@withdrawalsViaMethod')->name('users.withdrawals.method');
        // Login History
        Route::get('users/login/history/{id}', 'ManageUsersController@userLoginHistory')->name('users.login.history.single');

        Route::get('users/send-email', 'ManageUsersController@showEmailAllForm')->name('users.email.all');
        Route::post('users/send-email', 'ManageUsersController@sendEmailAll')->name('users.email.send');
        Route::get('users/email-log/{id}', 'ManageUsersController@emailLog')->name('users.email.log');
        Route::get('users/email-details/{id}', 'ManageUsersController@emailDetails')->name('users.email.details');

        //User Referral
        Route::get('users/referral/log/{id}', 'ManageUsersController@referralLog')->name('users.referral.log');
        Route::get('users/referral/level/{id}', 'ManageUsersController@userLevelReferrals')->name('users.referral.level.log');
        Route::get('users/referral/commissions/{id}', 'ManageUsersController@referralCommission')->name('users.referral.commission');
        Route::get('users/level/commissions/{id}', 'ManageUsersController@levelCommission')->name('users.level.commission');

        //User Pin
        Route::get('users/generate/pin/{id}', 'ManageUsersController@generatePin')->name('users.generate.pin');
        Route::get('users/used/pin/{id}', 'ManageUsersController@usedPin')->name('users.used.pin');
        
        // Pin Controller 
        Route::get('pin', 'PinController@index')->name('pin.index'); 
        Route::post('pin/store', 'PinController@store')->name('pin.store'); 
        Route::get('used/pin', 'PinController@used')->name('pin.used'); 
        Route::get('unused/pin', 'PinController@unUsed')->name('pin.unused'); 
        Route::get('pin/generate', 'PinController@adminPin')->name('pin.generate'); 
        Route::get('user/pin/generate', 'PinController@userPin')->name('pin.user'); 
        Route::get('pin/search', 'PinController@search')->name('pin.search'); 

        // Plan Controller
        Route::get('plan', 'PlanController@index')->name('plan.index');
        Route::get('plan/create', 'PlanController@create')->name('plan.create');
        Route::post('plan/store', 'PlanController@store')->name('plan.store');
        Route::get('plan/edit/{id}', 'PlanController@edit')->name('plan.edit');
        Route::post('plan/update/{id}', 'PlanController@update')->name('plan.update');
        Route::post('matrix/setting', 'PlanController@matrixSetting')->name('matrix.setting');

        //Plan subscription
        Route::get('plan/subscribers', 'PlanController@subscribersIndex')->name('plan.subscribers.index');
        Route::get('plan/subscribers/{planId}', 'PlanController@subscribtionPlan')->name('plan.subscribers');
        Route::get('subscribers/search', 'PlanController@subscribersSearchs')->name('plan.subscribers.search');

        // Subscriber
        Route::get('subscriber', 'SubscriberController@index')->name('subscriber.index');
        Route::get('subscriber/send-email', 'SubscriberController@sendEmailForm')->name('subscriber.sendEmail');
        Route::post('subscriber/remove', 'SubscriberController@remove')->name('subscriber.remove');
        Route::post('subscriber/send-email', 'SubscriberController@sendEmail')->name('subscriber.sendEmail');


        // Deposit Gateway
        Route::name('gateway.')->prefix('gateway')->group(function(){
            // Automatic Gateway
            Route::get('automatic', 'GatewayController@index')->name('automatic.index');
            Route::get('automatic/edit/{alias}', 'GatewayController@edit')->name('automatic.edit');
            Route::post('automatic/update/{code}', 'GatewayController@update')->name('automatic.update');
            Route::post('automatic/remove/{code}', 'GatewayController@remove')->name('automatic.remove');
            Route::post('automatic/activate', 'GatewayController@activate')->name('automatic.activate');
            Route::post('automatic/deactivate', 'GatewayController@deactivate')->name('automatic.deactivate');


            // Manual Methods
            Route::get('manual', 'ManualGatewayController@index')->name('manual.index');
            Route::get('manual/new', 'ManualGatewayController@create')->name('manual.create');
            Route::post('manual/new', 'ManualGatewayController@store')->name('manual.store');
            Route::get('manual/edit/{alias}', 'ManualGatewayController@edit')->name('manual.edit');
            Route::post('manual/update/{id}', 'ManualGatewayController@update')->name('manual.update');
            Route::post('manual/activate', 'ManualGatewayController@activate')->name('manual.activate');
            Route::post('manual/deactivate', 'ManualGatewayController@deactivate')->name('manual.deactivate');
        });


        // DEPOSIT SYSTEM
        Route::name('deposit.')->prefix('deposit')->group(function(){
            Route::get('/', 'DepositController@deposit')->name('list');
            Route::get('pending', 'DepositController@pending')->name('pending');
            Route::get('rejected', 'DepositController@rejected')->name('rejected');
            Route::get('approved', 'DepositController@approved')->name('approved');
            Route::get('successful', 'DepositController@successful')->name('successful');
            Route::get('details/{id}', 'DepositController@details')->name('details');

            Route::post('reject', 'DepositController@reject')->name('reject');
            Route::post('approve', 'DepositController@approve')->name('approve');
            Route::get('via/{method}/{type?}', 'DepositController@depositViaMethod')->name('method');
            Route::get('/{scope}/search', 'DepositController@search')->name('search');
            Route::get('date-search/{scope}', 'DepositController@dateSearch')->name('dateSearch');

        });


        // WITHDRAW SYSTEM
        Route::name('withdraw.')->prefix('withdraw')->group(function(){
            Route::get('pending', 'WithdrawalController@pending')->name('pending');
            Route::get('approved', 'WithdrawalController@approved')->name('approved');
            Route::get('rejected', 'WithdrawalController@rejected')->name('rejected');
            Route::get('log', 'WithdrawalController@log')->name('log');
            Route::get('via/{method_id}/{type?}', 'WithdrawalController@logViaMethod')->name('method');
            Route::get('{scope}/search', 'WithdrawalController@search')->name('search');
            Route::get('date-search/{scope}', 'WithdrawalController@dateSearch')->name('dateSearch');
            Route::get('details/{id}', 'WithdrawalController@details')->name('details');
            Route::post('approve', 'WithdrawalController@approve')->name('approve');
            Route::post('reject', 'WithdrawalController@reject')->name('reject');


            // Withdraw Method
            Route::get('method/', 'WithdrawMethodController@methods')->name('method.index');
            Route::get('method/create', 'WithdrawMethodController@create')->name('method.create');
            Route::post('method/create', 'WithdrawMethodController@store')->name('method.store');
            Route::get('method/edit/{id}', 'WithdrawMethodController@edit')->name('method.edit');
            Route::post('method/edit/{id}', 'WithdrawMethodController@update')->name('method.update');
            Route::post('method/activate', 'WithdrawMethodController@activate')->name('method.activate');
            Route::post('method/deactivate', 'WithdrawMethodController@deactivate')->name('method.deactivate');
        });

        // Report
        Route::get('report/transaction', 'ReportController@transaction')->name('report.transaction');

        Route::get('report/provide_helps', 'ReportController@provide_helps')->name('report.provide_helps');
        Route::get('report/get_helps', 'ReportController@get_helps')->name('report.get_helps');
        Route::get('report/transaction/search', 'ReportController@transactionSearch')->name('report.transaction.search');
        Route::get('report/login/history', 'ReportController@loginHistory')->name('report.login.history');
        Route::get('report/login/ipHistory/{ip}', 'ReportController@loginIpHistory')->name('report.login.ipHistory');
        Route::get('report/email/history', 'ReportController@emailHistory')->name('report.email.history');

        //Recharge
        Route::get('report/recharge', 'ReportController@recharge')->name('report.recharge');
        Route::get('report/recharge/search', 'ReportController@rechargeSearch')->name('report.recharge.search');

        //Commissions
        Route::get('report/commissions', 'ReportController@commissions')->name('report.commissions');
        Route::get('report/commissions/search', 'ReportController@commissionsSearch')->name('report.commissions.search');
        Route::get('report/commissions/log', 'ReportController@commissionSelect')->name('report.commissions.log');

        // Admin Support
        Route::get('tickets', 'SupportTicketController@tickets')->name('ticket');
        Route::get('tickets/pending', 'SupportTicketController@pendingTicket')->name('ticket.pending');
        Route::get('tickets/closed', 'SupportTicketController@closedTicket')->name('ticket.closed');
        Route::get('tickets/answered', 'SupportTicketController@answeredTicket')->name('ticket.answered');
        Route::get('tickets/view/{id}', 'SupportTicketController@ticketReply')->name('ticket.view');
        Route::post('ticket/reply/{id}', 'SupportTicketController@ticketReplySend')->name('ticket.reply');
        Route::get('ticket/download/{ticket}', 'SupportTicketController@ticketDownload')->name('ticket.download');
        Route::post('ticket/delete', 'SupportTicketController@ticketDelete')->name('ticket.delete');


        // Language Manager
        Route::get('/language', 'LanguageController@langManage')->name('language.manage');
        Route::post('/language', 'LanguageController@langStore')->name('language.manage.store');
        Route::post('/language/delete/{id}', 'LanguageController@langDel')->name('language.manage.del');
        Route::post('/language/update/{id}', 'LanguageController@langUpdate')->name('language.manage.update');
        Route::get('/language/edit/{id}', 'LanguageController@langEdit')->name('language.key');
        Route::post('/language/import', 'LanguageController@langImport')->name('language.importLang');



        Route::post('language/store/key/{id}', 'LanguageController@storeLanguageJson')->name('language.store.key');
        Route::post('language/delete/key/{id}', 'LanguageController@deleteLanguageJson')->name('language.delete.key');
        Route::post('language/update/key/{id}', 'LanguageController@updateLanguageJson')->name('language.update.key');



        // General Setting
        Route::get('general-setting', 'GeneralSettingController@index')->name('setting.index');
        Route::post('general-setting', 'GeneralSettingController@update')->name('setting.update');
        Route::get('optimize', 'GeneralSettingController@optimize')->name('setting.optimize');

        // Logo-Icon
        Route::get('setting/logo-icon', 'GeneralSettingController@logoIcon')->name('setting.logo.icon');
        Route::post('setting/logo-icon', 'GeneralSettingController@logoIconUpdate')->name('setting.logo.icon');

        //Custom CSS
        Route::get('custom-css','GeneralSettingController@customCss')->name('setting.custom.css');
        Route::post('custom-css','GeneralSettingController@customCssSubmit');


        //Cookie
        Route::get('cookie','GeneralSettingController@cookie')->name('setting.cookie');
        Route::post('cookie','GeneralSettingController@cookieSubmit');


        // Plugin
        Route::get('extensions', 'ExtensionController@index')->name('extensions.index');
        Route::post('extensions/update/{id}', 'ExtensionController@update')->name('extensions.update');
        Route::post('extensions/activate', 'ExtensionController@activate')->name('extensions.activate');
        Route::post('extensions/deactivate', 'ExtensionController@deactivate')->name('extensions.deactivate');



        // Email Setting
        Route::get('email-template/global', 'EmailTemplateController@emailTemplate')->name('email.template.global');
        Route::post('email-template/global', 'EmailTemplateController@emailTemplateUpdate')->name('email.template.global');
        Route::get('email-template/setting', 'EmailTemplateController@emailSetting')->name('email.template.setting');
        Route::post('email-template/setting', 'EmailTemplateController@emailSettingUpdate')->name('email.template.setting');
        Route::get('email-template/index', 'EmailTemplateController@index')->name('email.template.index');
        Route::get('email-template/{id}/edit', 'EmailTemplateController@edit')->name('email.template.edit');
        Route::post('email-template/{id}/update', 'EmailTemplateController@update')->name('email.template.update');
        Route::post('email-template/send-test-mail', 'EmailTemplateController@sendTestMail')->name('email.template.test.mail');


        // SMS Setting
        Route::get('sms-template/global', 'SmsTemplateController@smsTemplate')->name('sms.template.global');
        Route::post('sms-template/global', 'SmsTemplateController@smsTemplateUpdate')->name('sms.template.global');
        Route::get('sms-template/setting','SmsTemplateController@smsSetting')->name('sms.templates.setting');
        Route::post('sms-template/setting', 'SmsTemplateController@smsSettingUpdate')->name('sms.template.setting');
        Route::get('sms-template/index', 'SmsTemplateController@index')->name('sms.template.index');
        Route::get('sms-template/edit/{id}', 'SmsTemplateController@edit')->name('sms.template.edit');
        Route::post('sms-template/update/{id}', 'SmsTemplateController@update')->name('sms.template.update');
        Route::post('email-template/send-test-sms', 'SmsTemplateController@sendTestSMS')->name('sms.template.test.sms');

        // SEO
        Route::get('seo', 'FrontendController@seoEdit')->name('seo');


        // Frontend
        Route::name('frontend.')->prefix('frontend')->group(function () {


            Route::get('templates', 'FrontendController@templates')->name('templates');
            Route::post('templates', 'FrontendController@templatesActive')->name('templates.active');
            

            Route::get('frontend-sections/{key}', 'FrontendController@frontendSections')->name('sections');
            Route::post('frontend-content/{key}', 'FrontendController@frontendContent')->name('sections.content');
            Route::get('frontend-element/{key}/{id?}', 'FrontendController@frontendElement')->name('sections.element');
            Route::post('remove', 'FrontendController@remove')->name('remove');
            Route::get('plan_detail', 'FrontendController@plan_detail')->name('plan_detail');

            // Page Builder
            Route::get('manage-pages', 'PageBuilderController@managePages')->name('manage.pages');
            Route::post('manage-pages', 'PageBuilderController@managePagesSave')->name('manage.pages.save');
            Route::post('manage-pages/update', 'PageBuilderController@managePagesUpdate')->name('manage.pages.update');
            Route::post('manage-pages/delete', 'PageBuilderController@managePagesDelete')->name('manage.pages.delete');
            Route::get('manage-section/{id}', 'PageBuilderController@manageSection')->name('manage.section');
            Route::post('manage-section/{id}', 'PageBuilderController@manageSectionUpdate')->name('manage.section.update');
        });
    });
});




/*
|--------------------------------------------------------------------------
| Start User Area
|--------------------------------------------------------------------------
*/


Route::name('user.')->group(function () {
    Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('/login', 'Auth\LoginController@login');
    Route::get('logout', 'Auth\LoginController@logout')->name('logout');

    Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
    Route::post('register', 'Auth\RegisterController@register')->middleware('regStatus');
    Route::post('check-mail', 'Auth\RegisterController@checkUser')->name('checkUser');
    Route::post('/validate_pin', 'Auth\RegisterController@validatePin')->name('validate_pin');
    Route::post('/fetch_username', 'Auth\RegisterController@fetchUsername')->name('fetch_username');
    


    Route::get('/growth_rate/{growth}','UserController@growth_balance')->name('growth.rate');

    Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetCodeEmail')->name('password.email');
    Route::get('password/code-verify', 'Auth\ForgotPasswordController@codeVerify')->name('password.code.verify');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');
    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/verify-code', 'Auth\ForgotPasswordController@verifyCode')->name('password.verify.code');
});

Route::name('user.')->prefix('user')->group(function () {
    Route::middleware('auth')->group(function () {
        Route::get('authorization', 'AuthorizationController@authorizeForm')->name('authorization');
        Route::get('resend-verify', 'AuthorizationController@sendVerifyCode')->name('send.verify.code');
        Route::post('verify-email', 'AuthorizationController@emailVerification')->name('verify.email');
        Route::post('verify-sms', 'AuthorizationController@smsVerification')->name('verify.sms');
        Route::post('verify-g2fa', 'AuthorizationController@g2faVerification')->name('go2fa.verify');

        Route::middleware(['checkStatus'])->group(function () {
            Route::get('dashboard', 'UserController@home')->name('home');


            Route::get('cart', 'UserController@cart')->name('cart');
            Route::post('provide-help', 'UserController@provide_help')->name('provide_help');
            Route::post('save-get-help', 'UserController@save_get_help')->name('save_get_help');
            Route::get('cart', 'CartController@cartList')->name('cart');

            Route::get('order', 'OrderController@index')->name('order'); 
            Route::get('order', 'OrderController@view')->name('order');
            Route::get('item/{id}', 'OrderController@list')->name('item');


            Route::get('profile-setting', 'UserController@profile')->name('profile.setting');
            Route::get('account-details', 'UserController@account_details')->name('account_details');
            Route::post('account-details-save', 'UserController@account_save')->name('account_save');
            Route::post('profile-setting', 'UserController@submitProfile');
            Route::get('change-password', 'UserController@changePassword')->name('change.password');
            Route::post('change-password', 'UserController@submitPassword');
            // web tasks
            Route::get('web-tasks/{webTasks}', 'UserController@webTasks')->name('web.tasks');
            Route::post('submitWebTasks/{webTasks}', 'UserController@submitWebTasks')->name('submitWebTasks');
            Route::get('cancel_help','UserController@cancel_help')->name('cancel_help');

            Route::post('/saveProof/{saveHelpProof}', 'UserController@saveProof')->name('saveProof');
            //2FA
            Route::get('twofactor', 'UserController@show2faForm')->name('twofactor');
            Route::post('twofactor/enable', 'UserController@create2fa')->name('twofactor.enable');
            Route::post('twofactor/disable', 'UserController@disable2fa')->name('twofactor.disable');

        // Deposit
            Route::any('/deposit', 'Gateway\PaymentController@deposit')->name('deposit');
            Route::post('deposit/insert', 'Gateway\PaymentController@depositInsert')->name('deposit.insert');
            Route::get('deposit/preview', 'Gateway\PaymentController@depositPreview')->name('deposit.preview');
            Route::get('deposit/confirm', 'Gateway\PaymentController@depositConfirm')->name('deposit.confirm');
            Route::get('deposit/manual', 'Gateway\PaymentController@manualDepositConfirm')->name('deposit.manual.confirm');
            Route::post('deposit/manual', 'Gateway\PaymentController@manualDepositUpdate')->name('deposit.manual.update');
            Route::any('deposit/history', 'UserController@depositHistory')->name('deposit.history');
            Route::get('transaction/history', 'UserController@transactionHistory')->name('transaction.history');

            // Withdraw
            Route::get('/withdraw', 'UserController@withdrawMoney')->name('withdraw');
            Route::post('/withdraw', 'UserController@withdrawStore')->name('withdraw.money');
            Route::get('/withdraw/preview', 'UserController@withdrawPreview')->name('withdraw.preview');
            Route::post('/withdraw/preview', 'UserController@withdrawSubmit')->name('withdraw.submit');
            Route::get('/withdraw/history', 'UserController@withdrawLog')->name('withdraw.history');

            //Balance Transfer
            Route::get('/balance/transfer', 'UserController@balanceTransfer')->name('balance.transfer');
            Route::post('/balance/transfer/receiver', 'UserController@balanceTransferUser')->name('balance.transfer.anotheruser');

            //Commissions
            Route::get('/referral/users', 'UserController@referrallog')->name('referral.log');
            Route::get('/referral/commissions/plan', 'UserController@referralCommission')->name('referral.commissions');
            Route::get('/level/commissions/plan', 'UserController@levelCommission')->name('level.commissions');

            //Under Position User
            Route::get('/level/position/', 'UserController@userLevelReferral')->name('level.position');

              //ProductController
           Route::post('/product/order', 'ProductController@getProduct')->name('product.get');

            //PlanController
            Route::post('/subscribe/plan/order', 'PlanController@planOrder')->name('plan.order');

            //E-pin Recharge 
            Route::get('/e-pin/recharge', 'EpinController@epin')->name('epin.recharge');
            Route::get('/e-pin/recharge/log', 'EpinController@epinRechargeLog')->name('recharge.log');
            Route::post('/e-recharge', 'EpinController@eRecharge')->name('erecharge');
            Route::post('/pin/generate', 'EpinController@pinGenerate')->name('pin.generate');

        });
    });
});

            Route::get('/subscribe/plan', 'PlanController@plan')->name('plan');
            Route::get('/category/{id}', 'CatDetailController@show')->name('category');
            Route::get('/product', 'ProductController@getProduct')->name('product');

            Route::post('/update_product_cart', 'CartController@store')->name('update_product_cart');
            Route::post('/update_product_cart_page', 'CartController@cartStore')->name('update_product_cart_page');
            Route::post('/delete_from_cart', 'CartController@cartDelete')->name('delete_from_cart');
            Route::post('/checkout_update', 'CartController@updateCheckout')->name('checkout_update');
            Route::get('/cart', 'ProductController@cart')->name('cart');


            Route::get('/menu/{slug}/{id}', 'SiteController@footerMenu')->name('footer.menu');
            Route::post('/subscribe', 'SiteController@subscribe')->name('subscribe');
            Route::get('/contact', 'SiteController@contact')->name('contact');
            Route::post('/contact', 'SiteController@contactSubmit');
            Route::get('/change/{lang?}', 'SiteController@changeLanguage')->name('lang');
            Route::get('/cookie/accept', 'SiteController@cookieAccept')->name('cookie.accept');
            Route::get('blog', 'SiteController@blog')->name('blog');
            Route::get('blog/{id}/{slug}', 'SiteController@blogDetails')->name('blog.details');
            Route::get('placeholder-image/{size}', 'SiteController@placeholderImage')->name('placeholder.image');
            Route::get('/{slug}', 'SiteController@pages')->name('pages');
            Route::get('/', 'SiteController@index')->name('home');
            Route::get('/idealogy/{idealogy}', 'SiteController@idealogy')->name('idealogy');
            Route::get('/plan_detail/{plan_detail}', 'SiteController@plan_detail')->name('plan_detail');