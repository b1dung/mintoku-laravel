<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\SyncController;
use App\Http\Controllers\PancakeCrmController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/viec-lam', [JobController::class, 'index'])->name('jobs.index');
Route::get('/job/{slug}', [JobController::class, 'show'])->name('jobs.show');

Route::get('/{slug}', [PageController::class, 'show'])
    ->name('page.show');

Route::get('/ve-chuong-toi', [PageController::class, 'about'])->name('about');
# Route::get('/chinh-sach-quyen-rieng-tu', [PageController::class, 'privacy'])->name('privacy');

Route::get('/lien-he', [ContactController::class, 'index'])->name('contact');
Route::post('/lien-he', [ContactController::class, 'store'])->name('contact.store');

//Route::get('/sync-jobs-now', [SyncController::class, 'syncAllJobs']);

Route::get('/run-queue-send-mail', function () {
    Artisan::call('queue:work', ['--stop-when-empty' => true]);
    return "Queue processed successfully!";
});

// Route::get('/sync-jobs-to-crm', function () {
//     Artisan::call('sync:jobs-to-crm', ['--chunk' => 100]);
//     return "Sync completed!" . PHP_EOL . Artisan::output();
// })->middleware('throttle:6,1');



Route::post('/pancake-crm/lead', [PancakeCrmController::class, 'storeLead']);
