<?php

use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\WhyPointController;

use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;

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

Route::domain(env('ADMIN_SUBDOMAIN', 'admin') . '.' . env('APP_DOMAIN_URL'))->namespace('App\\Http\\Controllers')->group(function () {
  Route::group([
    'as' => 'admin.',
  ], function () {
    //Login
    Route::get('login', 'Admin\AdminLoginController@showLogin')->name('login');
    Route::post('login', 'Admin\AdminLoginController@login')->name('login.submit');

    //Forget Password
    Route::get('password/reset', 'Admin\ForgotPasswordController@showLinkRequestForm')->name('password.forgot');
    Route::post('password/email', 'Admin\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::post('password/reset', 'Admin\ResetPasswordController@reset')->name('password.reset.submit');
    Route::get('password/reset/{token}', 'Admin\ResetPasswordController@showResetForm')->name('password.reset');

    Route::group([
      'middleware' => 'forceLogout',
    ], function () {
      Route::get('/', 'Admin\AdminController@dashboard')->name('dashboard');
      Route::get('home', 'Admin\AdminController@dashboard')->name('home');

      // service routes
      Route::resource('services', ServiceController::class);
      Route::resource('why-points', WhyPointController::class);
      Route::resource('testimonials', TestimonialController::class);

      //Logout
      Route::post('logout', 'Admin\AdminLoginController@logout')->name('logout');

      //Profile Update
      Route::get('profile', 'Admin\UserProfileController@index')->name('profile');
      Route::get('profile-edit', 'Admin\UserProfileController@edit')->name('profile.edit');
      Route::patch('profile-edit', 'Admin\UserProfileController@update')->name('profile.update');
      //Change Password
      Route::get('change-password', 'Admin\UserProfileController@changePassword')->name('changePassword');
      Route::post('change-password', 'Admin\UserProfileController@changePasswordStore')->name('changePassword.store');

      Route::resource('roles', 'Admin\RoleController');

      Route::get('admins/updatePassword/{id}', 'Admin\AdminController@updatePassword')->name('admins.updatePassword');
      Route::patch('admins/updatePassword/{id}', 'Admin\AdminController@updatePasswordStore')->name('admins.updatePasswordStore');
      Route::get('activityLog', 'Admin\AdminController@activityLog')->name('activityLog');
      Route::resource('admins', 'Admin\AdminController');

      Route::get('users/updatePassword/{id}', 'Admin\UserController@updatePassword')->name('users.updatePassword');
      Route::patch('users/updatePassword/{id}', 'Admin\UserController@updatePasswordStore')->name('users.updatePasswordStore');
      Route::resource('users', 'Admin\UserController');

      Route::get('invoice/preview', 'Admin\InvoiceController@preview')->name('invoice-preview');
      Route::get('invoice/print', 'Admin\InvoiceController@print')->name('invoice-print');

      //Site Setting
      Route::get('site-settings', 'Admin\SiteSettingController@index')->name('site-settings.index');
      Route::post('site-settings', 'Admin\SiteSettingController@store')->name('site-settings.store');

      //Contact routes
      Route::get('/contacts', [ContactController::class, 'index'])->name('contacts.index');
      Route::delete('/contacts/{contact}', [ContactController::class, 'destroy'])
        ->name('contacts.destroy');
    });
  });
});