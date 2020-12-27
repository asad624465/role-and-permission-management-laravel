<?php
Route::get('admin-login','Backend\Auth\Logincontroller@loginForm')->name('admin.login');
Route::post('login/submit','Backend\Auth\Logincontroller@login')->name('admin.login.submit');
Route::post('logout/submit','Backend\Auth\Logincontroller@logout')->name('admin.logout');
Route::get('dashboard','Backend\DashboardController@index')->name('admin.dashboard');
Route::resource('/ad', 'Backend\AdminController');
//Route::resource('/roles', 'Backend\RolesController');