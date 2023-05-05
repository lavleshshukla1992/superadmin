<?php

use App\Models\Admin;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;
use App\Http\Controllers\StateController;
use App\Http\Controllers\PincodeController;
use App\Http\Controllers\PanchayatController;


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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', 'HomeController@redirectAdmin')->name('index');
Route::get('/home', 'HomeController@index')->name('home');

/**
 * Admin routes
 */
Route::group(['prefix' => 'admin'], function () {
    Route::get('/', 'Backend\DashboardController@index')->name('admin.dashboard');
    Route::resource('roles', 'Backend\RolesController', ['names' => 'admin.roles']);
    Route::resource('users', 'Backend\UsersController', ['names' => 'admin.users']);
    Route::resource('admins', 'Backend\AdminsController', ['names' => 'admin.admins']);

    Route::post('districts-list',[PincodeController::class,'getDistrictList']);
    Route::post('panchayat-list',[PanchayatController::class,'panchayatListStateWise']);

    // panchayat-list
    // Login Routes
    Route::get('/login', 'Backend\Auth\LoginController@showLoginForm')->name('admin.login');
    Route::post('/login/submit', 'Backend\Auth\LoginController@login')->name('admin.login.submit');

    // Logout Routes
    Route::post('/logout/submit', 'Backend\Auth\LoginController@logout')->name('admin.logout.submit');

    // Forget Password Routes
    Route::get('/password/reset', 'Backend\Auth\ForgetPasswordController@showLinkRequestForm')->name('admin.password.request');
    Route::post('/password/reset/submit', 'Backend\Auth\ForgetPasswordController@reset')->name('admin.password.update');

    // Ads
    Route::resource('notifications', 'NotificationController');
    Route::resource('training', 'TrainingController');
    Route::resource('scheme', 'SchemeController');
    Route::resource('feedback', 'FeedbackController');
    Route::resource('ad', 'Backend\AdController', ['names' => 'admin.ad']);
    Route::resource('country', 'CountryController');
    Route::resource('state', 'StateController');
    Route::resource('district', 'DistrictController');
    // Route::resource('categories', 'CategoryController');
    // Route::resource('sub-categories', 'SubCategoryController');
    Route::resource('pin-codes', 'PincodeController')->parameter('pin-codes','pinCode');
    Route::resource('market-places', 'MarketPlaceController')->parameter('market-places','marketPlace');
    Route::resource('vending', 'VendingController');
    Route::resource('memberships', 'MemebershipController');
});

Route::get('/test',function(){
    $permissions = [
        // [
        //     'group_name' => 'pincode',
        //     'permissions' => [
        //         // role Permissions
        //         'pincode.create',
        //         'pincode.view',
        //         'pincode.edit',
        //         'pincode.delete',
        //         'pincode.approve',
        //     ]
        // ],
        // [
        //     'group_name' => 'market_place',
        //     'permissions' => [
        //         // role Permissions
        //         'market_place.create',
        //         'market_place.view',
        //         'market_place.edit',
        //         'market_place.delete',
        //         'market_place.approve',
        //     ]
        // ],
        // [
        //     'group_name' => 'vending',
        //     'permissions' => [
        //         // role Permissions
        //         'vending.create',
        //         'vending.view',
        //         'vending.edit',
        //         'vending.delete',
        //         'vending.approve',
        //     ]
        // ],
        // [
        //     'group_name' => 'membership',
        //     'permissions' => [
        //         // role Permissions
        //         'membership.create',
        //         'membership.view',
        //         'membership.edit',
        //         'membership.delete',
        //         'membership.approve',
        //     ]
        // ],
        // [
        //     'group_name' => 'feedback',
        //     'permissions' => [
        //         // role Permissions
        //         'feedback.create',
        //         'feedback.view',
        //         'feedback.edit',
        //         'feedback.delete',
        //         'feedback.approve',
        //     ]
        // ],
        [
            'group_name' => 'training',
            'permissions' => [
                // role Permissions
                'training.create',
                'training.view',
                'training.edit',
                'training.delete',
                'training.approve',
            ]
        ],
        [
            'group_name' => 'notification',
            'permissions' => [
                // role Permissions
                'notification.create',
                'notification.view',
                'notification.edit',
                'notification.delete',
                'notification.approve',
            ]
        ],
        [
            'group_name' => 'scheme',
            'permissions' => [
                // role Permissions
                'scheme.create',
                'scheme.view',
                'scheme.edit',
                'scheme.delete',
                'scheme.approve',
            ]
        ],
    ];

    $roleSuperAdmin = Role::firstOrCreate(['name' => 'superadmin', 'guard_name' => 'admin']);

        // Create and Assign Permissions
        for ($i = 0; $i < count($permissions); $i++) {
            $permissionGroup = $permissions[$i]['group_name'];
            for ($j = 0; $j < count($permissions[$i]['permissions']); $j++) {
                // Create Permission
                $permissionCount = Permission::where(['name' => $permissions[$i]['permissions'][$j], 'group_name' => $permissionGroup, 'guard_name' => 'admin'])->count('id');
                if ($permissionCount == 0) 
                {
                    $permission = Permission::create(['name' => $permissions[$i]['permissions'][$j], 'group_name' => $permissionGroup, 'guard_name' => 'admin']);
                    $roleSuperAdmin->givePermissionTo($permission);
                    $permission->assignRole($roleSuperAdmin);
                }
            }
        }

        // Assign super admin role permission to superadmin user
        $admin = Admin::where('username', 'superadmin')->first();
        if ($admin) {
            $admin->assignRole($roleSuperAdmin);
        }
});
