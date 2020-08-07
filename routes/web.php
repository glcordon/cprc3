<?php

Route::redirect('/', '/login');
Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});

Auth::routes(['register' => false]);
// Admin

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('user-alerts/read', 'UserAlertsController@read');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Teams
    Route::delete('teams/destroy', 'TeamController@massDestroy')->name('teams.massDestroy');
    Route::resource('teams', 'TeamController');

    // User Alerts
    Route::delete('user-alerts/destroy', 'UserAlertsController@massDestroy')->name('user-alerts.massDestroy');
    Route::resource('user-alerts', 'UserAlertsController', ['except' => ['edit', 'update']]);

    // Services
    Route::delete('services/destroy', 'ServicesController@massDestroy')->name('services.massDestroy');
    Route::resource('services', 'ServicesController');

    // Vendors
    Route::delete('vendors/destroy', 'VendorsController@massDestroy')->name('vendors.massDestroy');
    Route::resource('vendors', 'VendorsController');

    Route::get('messenger', 'MessengerController@index')->name('messenger.index');
    Route::get('messenger/create', 'MessengerController@createTopic')->name('messenger.createTopic');
    Route::post('messenger', 'MessengerController@storeTopic')->name('messenger.storeTopic');
    Route::get('messenger/inbox', 'MessengerController@showInbox')->name('messenger.showInbox');
    Route::get('messenger/outbox', 'MessengerController@showOutbox')->name('messenger.showOutbox');
    Route::get('messenger/{topic}', 'MessengerController@showMessages')->name('messenger.showMessages');
    Route::delete('messenger/{topic}', 'MessengerController@destroyTopic')->name('messenger.destroyTopic');
    Route::post('messenger/{topic}/reply', 'MessengerController@replyToTopic')->name('messenger.reply');
    Route::get('messenger/{topic}/reply', 'MessengerController@showReply')->name('messenger.showReply');
});
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
// Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
    }
});
Route::group(['prefix' => 'client',  'middleware' => ['auth']], function () {
    // Change password
        // if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
            Route::get('/', 'ClientController@index')->name('view.clients');
            Route::get('/add', 'ClientController@create')->name('add.clients');
            Route::post('/store', 'ClientController@store')->name('store.clients');
            Route::get('{client}/show', 'ClientController@show')->name('show.clients');

            Route::post('/add-job', 'ClientController@updateJob')->name('client.updateJob');
            Route::post('delete-job', 'ClientController@deleteJob')->name('client.deleteJob');
        // }
    });

// Route::post('/add-note', 'NoteController@store')->name('note.add');
Route::post('/add-note', 'NoteController@store')->name('note.add');
Route::post('/add-service', 'ClientController@addService');
Route::get('/report-generate', 'ReportController@index')->name('pdf');
Route::post('/report-generate', 'ReportController@index')->name('pdf_post');
Route::post('/participation-report', 'ReportController@participantReport')->name('participation_report');
Route::get('/ap', 'AccountsPayableController@index');
Route::post('/ap/get-month', 'AccountsPayableController@index');
Route::post('/ap/update-service', 'AccountsPayableController@updateService');
Route::get('/ap/{id}/delete/', 'AccountsPayableController@destroy');
Route::get('/ap/{id}/export/', 'AccountsPayableController@show');
Route::get('/get-file/{id}/{file_url}', 'ClientController@getFile');
Route::get('/get-service/{service}', 'ClientController@getService');
Route::post('/update-service/{service}', 'ClientController@getService');

Route::get('/ap', 'AccountsPayableController@index');
Route::post('/ap/update-service', 'AccountsPayableController@updateService');
Route::get('/ap/{id}/delete/', 'AccountsPayableController@destroy');


Route::get('/report-generate', 'ReportController@index')->name('pdf');
Route::post('/report-generate', 'ReportController@index')->name('pdf_post');
Route::post('/participation-report', 'ReportController@participantReport')->name('participation_report');
