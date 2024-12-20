<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminLogsController;
use App\Http\Controllers\AdminSettingsController;
use App\Http\Controllers\AdminUserRoleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return redirect()->route('store.index');
});

// Store routes with prefix and name
Route::prefix('store')->name('store.')->group(function () {
    // Show products list
    Route::get('/', [StoreController::class, 'index'])->name('index');

    // Show form to add a new product
    Route::get('create', [StoreController::class, 'create'])->name('create');

    // Store new product (POST request)
    Route::post('store', [StoreController::class, 'store'])->name('store');

    // Show details of a specific product
    Route::get('show/{id}', [StoreController::class, 'show'])->name('show');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::group(['middleware' => 'is.admin', 'prefix' => 'admin'], function () {
    // Admin Dashboard Routes
    Route::get('/dashboard', [AdminDashboardController::class, 'home'])->name('admin.home');
    Route::get('/settings', [AdminSettingsController::class, 'settings'])->name('admin.settings');

    // User Routes
    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::get('/users/{userId}', [UserController::class, 'show'])->name('user.show');

    // Category Routes
    Route::get('/dashboard/category/new', [CategoryController::class, 'create'])->name('category.new');
    Route::post('/dashboard/category/new', [CategoryController::class, 'store'])->name('category.store');
    Route::get('/dashboard/categories', [CategoryController::class, 'index'])->name('categories');
    Route::get('/dashboard/category/edit/{categoryId}', [CategoryController::class, 'edit'])->name('category.edit');
    Route::post('/dashboard/category/update/{categoryId}', [CategoryController::class, 'update'])->name('category.update');

    // User Routes in admin
    Route::get('/dashboard/users/new', [UserController::class, 'create'])->name('user.new');
    Route::post('/dashboard/users/new', [UserController::class, 'store'])->name('user.store');
    Route::get('/dashboard/users/edit/{userId}', [UserController::class, 'edit'])->name('user.edit');
    Route::post('/dashboard/users/update/{userId}', [UserController::class, 'update'])->name('user.update');
    Route::post('/forum/banuser/{userId}', [UserController::class, 'add_forum_ban'])->name('forum.ban');
    Route::get('/forum/banuser/{userId}', [UserController::class, 'del_forum_ban'])->name('forum.unban');

    // Contact form messages 
    Route::get('/dashboard/contact-messages', [ContactController::class, 'index'])->name('contact.index');
    Route::get('/dashboard/contact-message/{messageId}', [ContactController::class, 'show'])->name('contact.show');

    // Admin logs
    Route::get('/dashboard/admin-logs', [AdminLogsController::class, 'index'])->name('logs.index');
    Route::post('/dashboard/logs', [AdminLogsController::class, 'store'])->name('logs.store');

    // Reports to admins
    Route::get('/dashboard/reports', [ReportController::class, 'index'])->name('reports.index');

    // User Role system
    Route::get('/user-roles', [AdminUserRoleController::class, 'index'])->name('user_roles');
    Route::get('/user-role/show/{userroleId}', [AdminUserRoleController::class, 'show'])->name('role.show');
    Route::get('/user-role/new', [AdminUserRoleController::class, 'create'])->name('role.create');
    Route::post('/user-role/update/{userroleId}', [AdminUserRoleController::class, 'update'])->name('role.update');
    Route::get('/user-role/edit/{userroleId}', [AdminUserRoleController::class, 'edit'])->name('role.edit');
    Route::post('/user-role', [AdminUserRoleController::class, 'store'])->name('role.store');
});

require __DIR__ . '/auth.php';
