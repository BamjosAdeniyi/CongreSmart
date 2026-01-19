<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DisciplinaryController;

// Landing page - redirect authenticated users to their dashboard
Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        $role = $user->role ?? 'pastor';

        // Map role to dashboard route
        $roleRoutes = [
            'pastor' => 'dashboard.pastor',
            'clerk' => 'dashboard.clerk',
            'superintendent' => 'dashboard.superintendent',
            'coordinator' => 'dashboard.coordinator',
            'financial' => 'dashboard.financial',
            'welfare' => 'dashboard.welfare',
            'ict' => 'dashboard.ict',
        ];

        $dashboardRoute = $roleRoutes[$role] ?? 'dashboard.pastor';

        return redirect()->route($dashboardRoute);
    }

    return view('landing');
});

require __DIR__.'/auth.php';

// Authenticated Routes
Route::middleware(['auth'])->group(function () {

    // Dashboard Routes - Redirect to role-specific dashboard
    Route::get('/dashboard', function () {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $role = $user->role ?? 'pastor';

        // Map role to dashboard route
        $roleRoutes = [
            'pastor' => 'dashboard.pastor',
            'clerk' => 'dashboard.clerk',
            'superintendent' => 'dashboard.superintendent',
            'coordinator' => 'dashboard.coordinator',
            'financial' => 'dashboard.financial',
            'welfare' => 'dashboard.welfare',
            'ict' => 'dashboard.ict',
        ];

        $dashboardRoute = $roleRoutes[$role] ?? 'dashboard.pastor';

        try {
            return redirect()->route($dashboardRoute);
        } catch (\Exception $e) {
            // Fallback to pastor dashboard if route doesn't exist
            return redirect()->route('dashboard.pastor');
        }
    })->name('dashboard');

    // Role-based dashboards
    Route::get('/dashboard/pastor', [DashboardController::class, 'pastor'])
        ->name('dashboard.pastor');

    Route::get('/dashboard/clerk', [DashboardController::class, 'clerk'])
        ->name('dashboard.clerk');

    Route::get('/dashboard/superintendent', [DashboardController::class, 'superintendent'])
        ->name('dashboard.superintendent');

    Route::get('/dashboard/coordinator', [DashboardController::class, 'coordinator'])
        ->name('dashboard.coordinator');

    Route::get('/dashboard/financial', [DashboardController::class, 'financial'])
        ->name('dashboard.financial');

    Route::get('/dashboard/welfare', [DashboardController::class, 'welfare'])
        ->name('dashboard.welfare');

    Route::get('/dashboard/ict', [DashboardController::class, 'ict'])
        ->name('dashboard.ict');

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Members Routes
    Route::prefix('members')->name('members.')->group(function () {
        Route::get('/transfers', function () {
            return view('members.transfers');
        })->name('transfers');
        Route::post('/transfer', [App\Http\Controllers\MemberController::class, 'transfer'])->name('transfer');
        Route::post('/transfer/{id}/update', [App\Http\Controllers\MemberController::class, 'updateTransfer'])->name('transfer.update');
    });

    Route::resource('members', App\Http\Controllers\MemberController::class);

    // Sabbath School Routes
    Route::prefix('sabbath-school')->name('sabbath-school.')->controller(App\Http\Controllers\SabbathSchoolController::class)->group(function () {
        Route::get('/reports', 'reports')->name('reports');
        Route::get('/{class}/attendance', 'attendance')->name('attendance');
        Route::get('/{class}/attendance/data', 'getAttendanceDataForDate')->name('attendance.data');
        Route::post('/{class}/attendance', 'storeAttendance')->name('attendance.store');
        Route::get('/{class}/assign-members', 'assignMembers')->name('assign-members');
        Route::post('/{class}/assign-members', 'updateMemberAssignments')->name('assign-members.update');
    });

    Route::resource('sabbath-school', App\Http\Controllers\SabbathSchoolController::class)->parameters([
        'sabbath-school' => 'class'
    ]);

    // Finance Routes
    Route::prefix('finance')->name('finance.')->controller(App\Http\Controllers\FinanceController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/contributions', 'listContributions')->name('contributions');
        Route::get('/contributions/create', 'createContribution')->name('contributions.create');
        Route::post('/contributions', 'storeContributions')->name('contributions.store');
        Route::get('/categories', 'categories')->name('categories');
        Route::post('/categories', 'storeCategory')->name('categories.store');
        Route::put('/categories/{category}', 'updateCategory')->name('categories.update');
        Route::delete('/categories/{category}', 'destroyCategory')->name('categories.destroy');
        Route::get('/reports', 'reports')->name('reports');
    });

    // Reports Routes
    Route::prefix('reports')->name('reports.')->controller(App\Http\Controllers\ReportsController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/members', 'members')->name('members');
        Route::get('/attendance', 'attendance')->name('attendance');
        Route::get('/financial', 'financial')->name('financial');
    });

    // Notifications Routes
    Route::prefix('notifications')->name('notifications.')->controller(App\Http\Controllers\NotificationsController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/{id}/read', 'markAsRead')->name('mark-read');
        Route::post('/mark-all-read', 'markAllAsRead')->name('mark-all-read');
    });

    // Settings Routes (ICT and Pastor only)
    Route::prefix('settings')->name('settings.')->controller(App\Http\Controllers\SettingsController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/profile', 'updateProfile')->name('profile.update');
        Route::post('/password', 'updatePassword')->name('password.update');
        Route::post('/preferences', 'updatePreferences')->name('preferences.update');
        Route::get('/system-info', 'systemInfo')->name('system-info');
    });

    // Administration Routes (ICT only)
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/users', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('users')->middleware('role:ict');
        Route::get('/users/create', [\App\Http\Controllers\Admin\UserController::class, 'create'])->name('users.create')->middleware('role:ict');
        Route::post('/users', [\App\Http\Controllers\Admin\UserController::class, 'store'])->name('users.store')->middleware('role:ict');
        Route::get('/users/{user}', [\App\Http\Controllers\Admin\UserController::class, 'show'])->name('users.show')->middleware('role:ict');
        Route::get('/users/{user}/edit', [\App\Http\Controllers\Admin\UserController::class, 'edit'])->name('users.edit')->middleware('role:ict');
        Route::put('/users/{user}', [\App\Http\Controllers\Admin\UserController::class, 'update'])->name('users.update')->middleware('role:ict');
        Route::delete('/users/{user}', [\App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('users.destroy')->middleware('role:ict');

        Route::get('/permissions', function () {
            return view('admin.permissions');
        })->name('permissions')->middleware('role:ict');

        Route::get('/logs', function () {
            return view('admin.logs');
        })->name('logs')->middleware('role:ict');
    });

    // Disciplinary Routes (Pastor and Clerk only)
    Route::middleware(['role:pastor,clerk'])->group(function () {
        Route::resource('disciplinary', DisciplinaryController::class);
    });
});
