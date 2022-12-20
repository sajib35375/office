<?php

use App\Http\Controllers\Admin\FileController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\FileTicketController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


//Route::get('/', function () {
//    return view('welcome');
//});

Route::middleware('admin:admin')->group(function (){
    Route::get('admin/login',[App\Http\Controllers\AdminController::class,'loginForm']);
    Route::post('admin/login',[App\Http\Controllers\AdminController::class,'store'])->name('admin.login');
});

Route::middleware(['auth:sanctum,admin', config('jetstream.auth_session'), 'verified'])->group(function () {

    Route::get('admin/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/', [App\Http\Controllers\AdminAuthController::class,'adminDash'])->name('dash');
    // User Profile Update
    Route::prefix('profile')->as('profile.')->group(function(){
        Route::get('/view',[App\Http\Controllers\ProfileController::class, 'ProfileView'])->name('view');
        Route::post('/update',[App\Http\Controllers\ProfileController::class, 'profileUpdate'])->name('update');
        Route::post('/passwordChange',[App\Http\Controllers\ProfileController::class, 'passwordChange'])->name('passwordChange');
        Route::post('/logout',[App\Http\Controllers\ProfileController::class, 'logout'])->name('logout');
    });
    // Admin File Tickets CRUD Routes
    Route::prefix('file-tickets')->group(function(){
        Route::get('/', [FileController::class , 'index'])->name('admin.file.index');
        Route::get('/single' , [FileController::class , 'show'])->name('admin.file.show');
        Route::post('/store',[FileController::class,'fileStore'])->name('admin.file.store');

    });
    // Admin Community CRUD Routes
    Route::prefix('community')->as('community.')->group(function(){
        Route::get('/' , [App\Http\Controllers\Admin\CommunityController::class , 'index'])->name('index');
        Route::post('/delete' , [App\Http\Controllers\Admin\CommunityController::class , 'delete'])->name('delete');
        Route::get('/single/{community}' , [App\Http\Controllers\Admin\CommunityController::class , 'show'])->name('show');
        Route::post('/store' , [App\Http\Controllers\Admin\CommunityController::class , 'store'])->name('store');
        Route::get('/status/{community}',[App\Http\Controllers\Admin\CommunityController::class, 'status'])->name('status');
    });
    // Admin User CRUD Routes
    Route::prefix('user')->as('user.')->group(function(){
        Route::get('/' , [App\Http\Controllers\Admin\UserControllr::class , 'index'])->name('index');
        Route::post('/store' , [App\Http\Controllers\Admin\UserControllr::class , 'store'])->name('store');
        Route::get('/delete/{id}' , [App\Http\Controllers\Admin\UserControllr::class , 'delete'])->name('delete');
        Route::get('/edit/{id}' , [App\Http\Controllers\Admin\UserControllr::class , 'editUser'])->name('edit');
        Route::post('/update/{id}' , [App\Http\Controllers\Admin\UserControllr::class , 'updateUser'])->name('update');

    });
    // Admin Role CRUD Routes
    Route::prefix('role')->as('role.')->group(function(){
        Route::get('/' , [App\Http\Controllers\Admin\RoleController::class , 'index'])->name('index');
        Route::post('/store',[App\Http\Controllers\Admin\RoleController::class, 'roleStore'])->name('store');
        Route::get('/status/active/{id}',[App\Http\Controllers\Admin\RoleController::class, 'roleActive'])->name('active');
        Route::get('/status/inactive/{id}',[App\Http\Controllers\Admin\RoleController::class, 'roleInactive'])->name('inactive');
    });
    // Admin General CRUD Routes
    Route::prefix('general')->as('general.')->group(function(){
        Route::get('/' , [App\Http\Controllers\Admin\GeneralController::class , 'index'])->name('index');
        Route::get('/setting',[App\Http\Controllers\Admin\GeneralController::class,'setting'])->name('setting');
    });
    //admin department edit
    Route::get('department/edit/{id}',[App\Http\Controllers\Admin\RoleController::class,'EditDepartment'])->name('edit.department');
    Route::post('department/update',[App\Http\Controllers\Admin\RoleController::class,'UpdateDepartment'])->name('update.department');
    Route::get('department/delete/{id}',[App\Http\Controllers\Admin\RoleController::class,'DeleteDepartment'])->name('delete.department');
    //file related route


    Route::get('file/filter/{id}',[App\Http\Controllers\Admin\FileController::class,'FileFilter'])->name('file.filter');
    Route::get('show/all/file',[App\Http\Controllers\Admin\FileController::class,'FileShowAll'])->name('file.show.all');
    //general setting
    Route::post('general/store',[App\Http\Controllers\Admin\GeneralController::class,'generalStore'])->name('general.store');
    //file edit
    Route::get('single/file/{id}',[App\Http\Controllers\Admin\FileController::class,'singleFile'])->name('single.file');
    Route::get('file/edit/{id}',[App\Http\Controllers\Admin\FileController::class,'fileEdit'])->name('file.edit');
    Route::get('file/delete/{id}',[App\Http\Controllers\Admin\FileController::class,'fileDelete'])->name('file.delete');
    Route::get('file/download/{file}',[App\Http\Controllers\Admin\FileController::class,'FileDownload'])->name('file.download');

    Route::post('file/update/{id}',[App\Http\Controllers\Admin\FileController::class,'fileUpdate'])->name('file.update');

});

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::prefix('file-tickets')->as('file.')->group(function(){
        Route::get('/' , [FileTicketController::class , 'index'])->name('index');
        Route::get('/single/{id}' , [FileTicketController::class , 'show'])->name('show');
        Route::get('/download/{file}',[FileTicketController::class,'FileDownload'])->name('file.download');
        Route::get('single/file/{id}',[FileTicketController::class,'singleFile'])->name('single');
    });
    Route::prefix('community')->as('community.')->group(function(){
        Route::get('/' , [CommunityController::class , 'index'])->name('index');
        Route::get('/single/{community}' , [CommunityController::class , 'show'])->name('show');
        Route::get('/edit/{community}' , [CommunityController::class , 'edit'])->name('edit');
        Route::post('/store' , [CommunityController::class , 'store'])->name('store');
        Route::post('/reply/{community' , [CommunityController::class , 'reply'])->name('reply');
        Route::post('/update' , [CommunityController::class , 'update'])->name('update');
        Route::post('/delete' , [CommunityController::class , 'delete'])->name('delete');
    });
    Route::prefix('user')->as('user.')->group(function(){
        Route::get('/',[UserController::class , 'index'])->name('index');
    });

});


// User Profile Update
Route::prefix('profile')->as('profile.')->group(function(){
    Route::get('/view',[App\Http\Controllers\ProfileController::class, 'ProfileView'])->name('view');
    Route::post('/update',[App\Http\Controllers\ProfileController::class, 'profileUpdate'])->name('update');
    Route::post('/passwordChange',[App\Http\Controllers\ProfileController::class, 'passwordChange'])->name('passwordChange');
    Route::post('/logout',[App\Http\Controllers\ProfileController::class, 'logout'])->name('logout');
});






