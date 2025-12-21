<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('landing');
});

require __DIR__.'/auth.php';

// Authenticated Routes
Route::middleware(['auth'])->group(function () {
    
    // Dashboard Routes - Redirect to role-specific dashboard
    Route::get('/dashboard', function () {
        $user = auth()->user();
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
    
    Route::get('/dashboard/clerk', function () {
        return view('dashboards.clerk');
    })->name('dashboard.clerk');
    
    Route::get('/dashboard/superintendent', function () {
        return view('dashboards.superintendent');
    })->name('dashboard.superintendent');
    
    Route::get('/dashboard/coordinator', function () {
        return view('dashboards.coordinator');
    })->name('dashboard.coordinator');
    
    Route::get('/dashboard/financial', function () {
        return view('dashboards.financial');
    })->name('dashboard.financial');
    
    Route::get('/dashboard/welfare', function () {
        return view('dashboards.welfare');
    })->name('dashboard.welfare');
    
    Route::get('/dashboard/ict', function () {
        return view('dashboards.ict');
    })->name('dashboard.ict');

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Members Routes
    Route::resource('members', App\Http\Controllers\MemberController::class);

    Route::prefix('members')->name('members.')->group(function () {
        Route::get('/transfers', function () {
            return view('members.transfers');
        })->name('transfers');
    });

    // Sabbath School Routes
    Route::prefix('sabbath-school')->name('sabbath-school.')->group(function () {
        Route::get('/', function () {
            return view('sabbath-school.index');
        })->name('index');
        
        Route::get('/classes', function () {
            return view('sabbath-school.classes');
        })->name('classes');
        
        Route::get('/attendance', function () {
            return view('sabbath-school.attendance');
        })->name('attendance');
        
        Route::get('/assign', function () {
            return view('sabbath-school.assign');
        })->name('assign');
        
        Route::get('/reports', function () {
            return view('sabbath-school.reports');
        })->name('reports');
    });

    // Finance Routes
    Route::prefix('finance')->name('finance.')->controller(App\Http\Controllers\FinanceController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/contributions', 'contributions')->name('contributions');
        Route::post('/contributions', 'storeContributions')->name('contributions.store');
        Route::get('/categories', 'categories')->name('categories');
        Route::post('/categories', 'storeCategory')->name('categories.store');
        Route::put('/categories/{category}', 'updateCategory')->name('categories.update');
        Route::delete('/categories/{category}', 'destroyCategory')->name('categories.destroy');
        Route::get('/reports', 'reports')->name('reports');
    });

    // Reports Routes
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', function () {
            return view('reports.index');
        })->name('index');
        
        Route::get('/members', function () {
            return view('reports.members');
        })->name('members');
        
        Route::get('/attendance', function () {
            return view('reports.attendance');
        })->name('attendance');
        
        Route::get('/financial', function () {
            return view('reports.financial');
        })->name('financial');
    });

    // Notifications Routes
    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', function () {
            return view('notifications.index');
        })->name('index');
    });

    // Settings Routes (ICT and Pastor only)
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', function () {
            return view('settings.index');
        })->name('index');
    });

    // Administration Routes (ICT only)
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/users', function () {
            return view('admin.users');
        })->name('users');
        
        Route::get('/permissions', function () {
            return view('admin.permissions');
        })->name('permissions');
        
        Route::get('/logs', function () {
            return view('admin.logs');
        })->name('logs');
    });
});
