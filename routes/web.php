<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Carbon; // Ensure this is at the top of the file
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TelegramController;
use App\Http\Controllers\KabidSuratController;
use App\Http\Controllers\KadisSuratController;
use App\Http\Controllers\SuratKeluarController;
use App\Http\Controllers\SuratKeluarPreviewController;

use Dompdf\Dompdf; // Untuk PDF generation (jika pakai Dompdf)
use Dompdf\Options;

// ====================> Web Routes
    // Route::get('/', function () {
    //     return view('welcome');
    // });

    Route::get('/', [SuratKeluarController::class, 'dashboard'])->name('dashboard');

    // Route::get('/', [DocumentController::class, 'dashboard'] )->name('dashboard'); 

// ------------------------> Web Routes

// ------------------------> Auth Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
}); // ------------------------> Auth Routes

// ===================> Document routes
    Route::prefix('documents')->name('documents.')->group(function () {
        Route::get('/', [DocumentController::class, 'index'])->name('index'); // Tampilkan daftar dokumen
        Route::get('/documents/{document}', [DocumentController::class, 'show'])->name('show'); // Tampilkan detail dokumen
    });
// ===================> Document routes


// ====================> User Management routes 
    Route::middleware(['auth', 'role:superadmin'])->group(function () {
        Route::resource('users', UserController::class);
    });
// ====================> User Management routes

// ====================> Surat Keluar routes -> KABID
    Route::middleware(['auth', 'role:kabid|kasubag'])->prefix('kabid')->name('kabid.')->group(function () {
        Route::get('/surat', [KabidSuratController::class, 'index'])->name('surat.index');
        Route::put('/surat/{id}/approve', [KabidSuratController::class, 'approve'])->name('surat.approve');
        Route::post('/surat', [KabidSuratController::class, 'store'])->name('surat.store');
        // Route::get('/surat-keluar/{id}/preview-pdf', [KabidController::class, 'preview'])->name('surat-keluar.show-pdf');
        // Route::get('/surat/{id}/preview', [KabidSuratController::class, 'preview'])->name('surat-keluar.show-pdf');
        Route::get('/surat/{id}/preview', [KabidSuratController::class, 'preview'])->name('surat.preview');
        Route::put('/surat/{id}/reject', [KabidSuratController::class, 'reject'])->name('surat.reject');
    });
// ====================> Surat Keluar routes -> KABID

// ====================> Surat Keluar routes -> KADIS
    Route::middleware(['auth', 'role:Kadis'])->prefix('Kadis')->name('kadis.')->group(function () {
        Route::get('/surat', [KadisSuratController::class, 'index'])->name('surat.index');
        Route::get('/surat/{id}/preview', [KadisSuratController::class, 'preview'])->name('surat.preview');
        // Route::get('/surat-keluar/{id}/preview', [SuratKeluarPreviewController::class, 'preview'])->name('surat-keluar.preview');
        Route::post('/surat/{id}/sign-electronic', [KadisSuratController::class, 'signElectronic'])->name('surat.signElectronic'); // <-- BARU
        Route::post('/surat/{id}/sign-manual', [KadisSuratController::class, 'signManual'])->name('surat.signManual'); // <-- BARU

    });
// ====================> Surat Keluar routes -> KADIS

// ====================> Surat Keluar routes -> EXPORT PDF
    Route::get('/preview-surat-keluar/{id}', [SuratKeluarPreviewController::class, 'preview'])
    ->name('preview.surat-keluar');
    Route::get('/surat-keluar/{record}/pdf', function (\App\Models\SuratKeluar $record) {
        return view('filament.pdf.surat-keluar', [
            'surat' => $record,
        ]);
    })->name('surat-keluar.show-pdf');
// ====================> Surat Keluar routes -> EXPORT PDF-test
    Route::get('/test-dompdf-options', function() {
        try {
            $options = new Options();
            dd('Dompdf Options class found successfully!');
        } catch (\Throwable $e) {
            dd('Error: ' . $e->getMessage());
        }
    });
// ====================> Surat Keluar routes -> EXPORT PDF

// ====================> TELEGRAM ROUTES
    Route::post('/telegram/webhook', [TelegramController::class, 'handleWebhook']);
    // Route::get('/telegram/send-message', [TelegramController::class, 'sendMessage']);
    // Route::get('/telegram/send-message-today', [TelegramController::class, 'sendMessageToday']);
    // Route::get('/telegram/send-message-today-afternoon', [TelegramController::class, 'sendMessageTodayAfternoon']);
    // Route::get('/telegram/send-message-tomorrow', [TelegramController::class, 'sendMessageTomorrow']);
    Route::middleware('throttle:1,1')->group(function () {
        Route::get('/telegram/send-message-today', [TelegramController::class, 'sendMessageToday']);
        Route::get('/telegram/send-message-today-afternoon', [TelegramController::class, 'sendMessageTodayAfternoon']);
        Route::get('/telegram/send-message-tomorrow', [TelegramController::class, 'sendMessageTomorrow']);
    });
// ====================> TELEGRAM ROUTES



require __DIR__.'/auth.php';
