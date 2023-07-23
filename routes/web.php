<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\contact\ContactController;
use App\Http\Controllers\disbursement\DisbursementController;
use App\Http\Controllers\Sanction\SanctionController;
use App\Http\Controllers\Role\RoleController;
use App\Http\Controllers\Role\RolesController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\Permission\PermissionController;
use App\Http\Controllers\Group\GroupController;
use App\Http\Controllers\Group\GroupLeaderController;
use App\helpers\commentHelper as helper;
use App\Http\Controllers\data_share\DataShareController;
use App\Http\Controllers\BankPayoutController;
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

/* Guest Login Routes */
Route::middleware(['guest'])->group(function () {
    Route::get('/', [AuthController::class, 'login'])->name('login');
    Route::get('/login', function(){ return redirect('/'); });
    Route::get('/register', [AuthController::class, 'register_view'])->name('register');

    Route::post('/login', [AuthController::class, 'login_user'])->name('user.login');
    Route::post('/register', [AuthController::class, 'register_user'])->name('user.register');
    Route::get('/home', [AuthController::class, 'dashboard'])->name('dashboard');
});

Route::middleware(['auth'])->group(function () {

    /* Authentication Module Routing */
    Route::get('/home', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    
    /* Contact Module Routing */
    Route::resource('/contacts', ContactController::class)->only(['index', 'show','edit','store','create','update']);
    Route::post('changestatus',[ContactController::class,'changestatus']);
    Route::post('filterContact',[ContactController::class,'filterContact'])->name('filterContact');
    Route::post('/addContactComment', [ContactController::class, 'addContactComment'])->name('contact.addContactComment');
    Route::post('/getLeadSourceTL', [ContactController::class, 'getLeadSourceTL'])->name('contact.getLeadSourceTL');
    Route::post('/getLeadSourceTLTeam', [ContactController::class, 'getLeadSourceTLTeam'])->name('contact.getLeadSourceTLTeam');
    Route::post('/gethomeloanTLTeam', [ContactController::class, 'getHomeloanTL']);
    Route::post('/getassignedTo', [ContactController::class, 'getAssignedTo']);
    Route::post('/getclosingBy', [ContactController::class, 'getClosingBy']);
    // Route::resource('sanction',SanctionController::class);
    
    /* Disbursements Module Routing */
    Route::resource('/disbursements',DisbursementController::class)->only(['index', 'show','edit','store','create','update']);
    Route::post('disbursementstatus',[DisbursementController::class,'changestatus'])->name('disbursement');
    Route::post('dynamic_dependent/fetch',[DisbursementController::class,'fetch'])->name('dynamicdependent.fetch');
    Route::post('filterDisbursement',[DisbursementController::class,'filterDisbursement'])->name('filterDisbursement');
    Route::post('/fetch-data/{id}', [DisbursementController::class,'fetchData']);
    Route::post('/addDisbursementComment', [DisbursementController::class, 'addDisbursementComment'])->name('disbursement.addDisbursementComment');
    
    /* Sanction Module Routing */
    Route::resource('sanction',SanctionController::class)->only(['index', 'show','edit','store','create','update']);
    Route::post('sanctionstatus',[SanctionController::class,'changestatus']);
    Route::post('filterSanction',[SanctionController::class,'filterSanction'])->name('filterSanction');
    Route::post('/addSanctionComment', [SanctionController::class, 'addSanctionsComment'])->name('sanction.addSanctionComment');

    /* Role Module Routing */
    Route::resource('role',RolesController::class);

    /* Permission Module Routing */
    Route::resource('permission', PermissionController::class);

    /* Roles Module Routing : merge of dharini role module */
    Route::resource('roles',RoleController::class);

    /* Status Update Routing */
    Route::post('/status_update', [RoleController::class, 'status_update'])->name('roles.status.change');

    /* User Module Routes */
     Route::resource('users', UserController::class);
     Route::post('/userstatusdata',[UserController::class,'changestatus']);
     Route::get('userFilter',[UserController::class,'filterUser'])->name('userFilter');

    /* Permission Module Routes */
    Route::resource('permissions', PermissionController::class);

    /* Team Module Routing */
    Route::resource('groups', GroupController::class);
    Route::get('groups/{group}/manage-membership', [GroupController::class, 'manageMembership'])->name('groups.manage_membership');
    Route::get('groups/{group}/add-teamleader', [GroupController::class, 'addTeamLeader'])->name('groups.addTl');
    Route::post('groups/{group}/add-user', [GroupController::class, 'addUser'])->name('groups.addUser');
    Route::post('groups/{group}/remove-user', [GroupController::class, 'removeUser'])->name('groups.removeUser');

    /* Team Leader Module Routing */
    Route::post('group_leader/{group}/assign', [GroupLeaderController::class, 'store'])->name('groupLeader.store');

    /* Add Bank Submodule Routes */
     Route::resource('/addbank', BankController::class);
    //  Route::post('addbank',[BankController::class,'store']);
    Route::get('edit-bank/{id}',[BankController::class,'edit']);
    Route::put('update-bank',[BankController::class,'update']);

     /* Data Sharing group routing */
     Route::resource('data-share', DataShareController::class);
     Route::post('groupFilter',[DataShareController::class,'groupFilter'])->name('groupFilter');
    //  Route::get('data-share/{data_sharing_group}/manage_members', [DataShareController::class, 'manage_members'])->name('data-share.manage_members');
    // Route::post('data-share/{data_sharing_group}/add_sharing_rule', [DataShareController::class, 'add_sharing_rule'])->name('data-share.add_sharing_rule');
    
    /* Manage Sharing Rules routing */
    Route::get('manage_members', [DataShareController::class, 'manage_members'])->name('manage_members');
    Route::get('create_sharing_group', [DataShareController::class, 'createDataSharingGroups'])->name('createDataSharingGroups');
    Route::post('add_sharing_rule', [DataShareController::class, 'add_sharing_rule'])->name('add_sharing_rule');
   
    /*Bank Payout Structure Routing|*/
    Route::resource('/payouts',BankPayoutController::class)->only(['index', 'show','edit','store','create','update']);
});
