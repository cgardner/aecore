<?php

/*
|--------------------------------------------------------------------------
| Storefront Routes
|--------------------------------------------------------------------------
*/

Route::get('/', 'StorefrontController@index');
Route::get('home', 'StorefrontController@index');

// Custom Auth Routes
Route::get('login', function() { return view('auth.login'); });
Route::get('signup', function() { return view('auth.signup'); });
Route::get('password', function() { return view('auth.password'); });
Route::get('reactivate', function() { return view('auth.reactivate'); });

// Default Auth Routes
Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

/* Help */
Route::get('help/slack', function() { return view('help.slack'); });

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
*/

// User must be linked to a company
Route::group(['middleware'=>'userstatus', 'middleware'=>'companycheck'], function(){

    /* Company Settings */
    Route::group(['middleware'=>'admincheck'], function(){
        Route::get('settings/company/users', 'SettingsController@showUsers');
        Route::get('settings/company/{view}', 'SettingsController@show');
        Route::post('settings/company/update', 'SettingsController@updateCompany');
        Route::post('settings/company/uploadlogo', 'UploadsController@uploadLogoCompany');
        Route::post('settings/company/savelogo', 'SettingsController@saveLogoCompany');
        Route::get('settings/company/remove/{usercode}', 'SettingsController@removeUserModal');
        Route::post('settings/company/remove', 'SettingsController@removeUser');
        Route::get('settings/company/admin/{usercode}', 'SettingsController@makeUserAdmin');
        
        Route::get('settings/company/costcodes/download', 'SettingsController@downloadCostcode');
        Route::get('settings/company/costcodes/{action}', 'SettingsController@costcodeModal');
        Route::post('settings/company/costcodes/update', 'SettingsController@updateCostcode');
        Route::post('settings/company/costcodes/delete', 'SettingsController@deleteCostcode');
        Route::post('settings/company/costcodes/upload', 'SettingsController@uploadCostcode');
    });
  
    /* Projects */
    Route::resource('projects', 'ProjectsController');
    Route::get('dashboard', 'DashboardController@showDashboard');

    /* Collaborators */
    Route::get('collaborators/{type}', 'CollaboratorsController@collabModal');
    Route::resource('collaborators', 'CollaboratorsController');
    
    /* RFI's */
    Route::resource('rfis', 'RfisController');
    
    /* PDF's */
    Route::get('pdf/log/{view}', 'PdfsController@pdfModal');
    Route::get('pdf/{type}', 'PdfsController@pdf');
    
    /* Integrations */
    Route::get('integrations/slack/{projectId}', 'IntegrationsController@slackModal');
    Route::post('integrations/slack', 'IntegrationsController@addSlackProject');
    
});

// These routes don't require a user to join a company
Route::group(['middleware'=>'userstatus'], function(){

    /* Welcome */
    Route::get('welcome/company', function() {
        return view('welcome.company');
    });
  
    Route::get('settings/create-company', function() {
      return view('settings.company.create');
    });
    Route::post('settings/create-company', 'SettingsController@createCompany');
    
    /* Notifications */
    Route::post('notifications/read/all', 'NotificationsController@readAll');
    Route::post('notifications/read/{id}', 'NotificationsController@readNotification');
  
  /* Tasks */
  Route::post('tasks/create', 'TasksController@createTask');
  Route::post('tasks/update', 'TasksController@updateTask');
  Route::get('tasks/refresh', 'TasksController@refreshList');
  Route::post('tasks/comment', 'TasksController@postTaskComment');
  Route::get('tasks/priority/{priority}/{taskcode}', 'TasksController@priorityChange');
  Route::get('tasks/{listcode?}', 'TasksController@index');
  Route::get('tasks/following/{usercode}', array('uses' => 'TasksController@indexFollowing'));
  
  /* Task details */
  Route::get('tasks/details/{taskcode}', array('uses' => 'TasksController@showTask'));
  Route::post('tasks/follower', 'TasksController@updateFollower');
  Route::post('tasks/attachment/{action}/{code}', array('uses' => 'TasksController@TaskAttachment'));
  
  /* Task Lists */
  Route::post('tasks/list/create', 'TasksController@createList');
  Route::post('tasks/list/remove', 'TasksController@removeList');    
  
  /* Personal Settings */
  Route::get('settings/{view}', 'SettingsController@show');
  Route::post('settings/avatar/upload/{type}', array('uses' => 'UploadsController@uploadAvatar'));
  Route::post('settings/profile/update', 'SettingsController@updateProfile');
  Route::post('settings/account/change-password', array('uses' => 'SettingsController@changePassword'));
  Route::post('settings/account/delete', array('uses' => 'SettingsController@deleteAccount'));
  Route::get('settings/avatar/crop/{type}', function() {
    return view('settings.modals.crop')->with('type', $type);
  });
  Route::post('settings/avatar/crop/{type}', array('uses' => 'UploadsController@cropAvatar'));
  Route::post('settings/company/join', 'SettingsController@joinCompany');
  Route::post('settings/company/leave', 'SettingsController@leaveCompany');
    
  /* Autocomplete */
  Route::post('autocomplete/companies', 'AutocompleteController@findCompanies');
  Route::post('autocomplete/users', 'AutocompleteController@findUsers');
  Route::post('autocomplete/tasklists', 'AutocompleteController@findTasklists');
  
  /* Updloads */
  Route::post('attachment/upload', array('uses' => 'UploadsController@uploadFile'));
  
});