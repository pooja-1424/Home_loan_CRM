<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\contact\ContactController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

// Route::get('index/{locale}',[App\Http\Controllers\HomeController::class, 'lang']);
// Route::get('/', [App\Http\Controllers\HomeController::class, 'root'])->name('root');

Route::post('/login',[App\Http\Controllers\AuthController::class,'login'])->name('user.login');
Route::post('/register',[App\Http\Controllers\AuthController::class,'register'])->name('user.register');


 /* Contact Module Routing */
 Route::resource('/contacts', ContactController::class)->only(['index', 'show','edit','store','create','update']);
 Route::post('changestatus',[ContactController::class,'changestatus']);
 Route::post('filterContact',[ContactController::class,'filterContact'])->name('filterContact');
 Route::post('/addContactComment', [ContactController::class, 'addContactComment'])->name('contact.addContactComment');
 Route::post('/getLeadSourceTL', [ContactController::class, 'getLeadSourceTL'])->name('contact.getLeadSourceTL');
 Route::post('/getLeadSourceTLTeam', [ContactController::class, 'getLeadSourceTLTeam'])->name('contact.getLeadSourceTLTeam');
