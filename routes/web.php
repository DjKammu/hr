<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

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
Auth::routes();


Route::get('/', function () {

    if (Auth::user()) { 
        return redirect('/dashboard');
    } 
    return view('welcome');
});

Route::get('/login',function(){
    return redirect('/');
})->name('login');

Route::get('/register',function(){
    return redirect('/');
});

Route::get('/linkstorage', function () {
    Artisan::call('storage:link');
    $exitCode = Artisan::call('storage:link', [] );
    echo $exitCode;
});

Route::get('/migration', function () {
    Artisan::call('migrate');
    $exitCode = Artisan::call('migrate', [] );
    echo $exitCode;
});

Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])
->name('dashboard');

Route::get('/profile', [App\Http\Controllers\HomeController::class, 'profile'])->name('profile');

Route::post('/profile', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('profile');

Route::post('/password', [App\Http\Controllers\HomeController::class, 'updatePassword'])->name('password');

Route::get('/setup', [App\Http\Controllers\HomeController::class, 'setup'])->name('setup');

Route::resource('users', App\Http\Controllers\UserController::class)->middleware('can:add_users');
Route::resource('roles', App\Http\Controllers\RoleController::class)->middleware('can:add_users');

Route::resource('company-types', App\Http\Controllers\CompanyController::class);

Route::resource('departments', App\Http\Controllers\DepartmentController::class);
Route::resource('employee-status', App\Http\Controllers\EmployeeStatusController::class);
Route::resource('employees', App\Http\Controllers\EmployeeController::class);
Route::resource('document-types', App\Http\Controllers\DocumentTypeController::class);
Route::resource('leave-types', App\Http\Controllers\LeaveTypeController::class);





Route::get('documents/search', [App\Http\Controllers\DocumentController::class,'search'])->name('documents.search');

Route::resource('documents', App\Http\Controllers\DocumentController::class);

Route::get('projects/{id}/documents',[App\Http\Controllers\DocumentController::class,'create'])
->name('projects.documents');

Route::get('projects/{id}/documents/{document}',[App\Http\Controllers\DocumentController::class,'show'])->name('projects.documents.show');

Route::post('projects/{id}/documents',[App\Http\Controllers\DocumentController::class,'store'])
->name('projects.documents');

Route::delete('documents/{id}/file', [App\Http\Controllers\DocumentController::class,'destroyFile'])->name('documents.file.destroy');


Route::get('files/{directory?}',[App\Http\Controllers\FileController::class,'index'])->name('files.index');

Route::get('files/{directory}/{property_type}',[App\Http\Controllers\FileController::class,'propertyType'])->name('files.property-type');

Route::get('files/{directory}/{property_type}/{property}',[App\Http\Controllers\FileController::class,'property'])->name('files.property');

Route::get('files/{directory}/{property_type}/{property}/{doc_type}',[App\Http\Controllers\FileController::class,'docType'])->name('files.doc_type');


Route::get('files/{directory}/{property_type}/{property}/{doc_type}/{doc}',[App\Http\Controllers\FileController::class,'doc'])->name('files.doc');

Route::delete('files', [App\Http\Controllers\FileController::class,'destroy'])->name('files.destroy');

Route::resource('trades', App\Http\Controllers\TradeController::class);

Route::get('projects/{id}/trades',[App\Http\Controllers\TradeController::class,'createProjectTrade'])->name('projects.trades');

Route::post('projects/{id}/trades',[App\Http\Controllers\TradeController::class,'storeProjectTrade'])->name('projects.trades');

Route::post('projects/{id}/trades/multiple',[App\Http\Controllers\TradeController::class,'storeMultipleProjectTrade'])->name('projects.trades.multiple');

 Route::delete('projects/{project_id}/trades/{id}', [App\Http\Controllers\TradeController::class,'destroyProjectTrade'])->name('projects.trades.destroy');

 Route::get('projects/{id}/proposals/{trade}',[App\Http\Controllers\ProposalController::class,'create'])->name('projects.proposals');

Route::post('projects/{id}/proposals/{trade}',[App\Http\Controllers\ProposalController::class,'store'])->name('projects.proposals');

Route::get('projects/proposals/{id}',[App\Http\Controllers\ProposalController::class,'show'])->name('projects.proposals.edit');

Route::get('projects/proposals/award/{id}/{status}',[App\Http\Controllers\ProposalController::class,'award'])->name('projects.proposals.award');

Route::post('projects/proposals/{id}',[App\Http\Controllers\ProposalController::class,'update'])->name('projects.proposals.update');

Route::post('projects/proposals/{id}/upload',[App\Http\Controllers\ProposalController::class,'upload'])->name('projects.proposals.upload');

 Route::delete('projects/proposals/{id}', [App\Http\Controllers\ProposalController::class,'destroy'])->name('projects.proposals.destroy');

 Route::delete('projects/proposals/{id}/file', [App\Http\Controllers\ProposalController::class,'destroyFile'])->name('projects.proposals.file.destroy');

Route::get('projects/{id}/payments',[App\Http\Controllers\PaymentController::class,'create'])->name('projects.payments');

Route::post('projects/{id}/payments',[App\Http\Controllers\PaymentController::class,'store'])->name('projects.payments');

Route::get('projects/payments/{id}',[App\Http\Controllers\PaymentController::class,'show'])->name('projects.payments.edit');

Route::post('projects/payments/{id}',[App\Http\Controllers\PaymentController::class,'update'])->name('projects.payments.update');

 Route::delete('projects/payments/{id}', [App\Http\Controllers\PaymentController::class,'destroy'])->name('projects.payments.destroy');

 Route::delete('projects/payments/{id}/file', [App\Http\Controllers\PaymentController::class,'destroyFile'])->name('projects.payments.file.destroy');

Route::resource('subcontractors', App\Http\Controllers\SubcontractorController::class);
Route::resource('vendors', App\Http\Controllers\VendorController::class);