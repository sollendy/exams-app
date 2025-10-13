<?php

use App\Http\Controllers\ExamController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TranscriptController;
use App\Http\Middleware\CheckRole;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rotte per gli esami
//-------------------------------------- PUBBLICA ------------------------------------------------------------------------------------

Route::get("/", [ExamController::class, "allExams"])->name("exams.index");

//-------------------------------------- PUBBLICA ------------------------------------------------------------------------------------

//------------------------------------- PRIVATE -----------------------------------------------------------------

Route::middleware("auth")->group(function () {
    Route::get("/dashboard", [ExamController::class, "userExams"])->middleware(CheckRole::class.':user');
    Route::post("/create-exam", [ExamController::class, "create"])->middleware("CheckRole:admin")->name("exam.create");
    Route::put("/give-vote", [TranscriptController::class, "assignVote"])
    ->middleware(['checkRole:admin,super-admin'])->name("exam.assignment");
});
//------------------------------------- FINE PRIVATE-----------------------------------------------------------------

require __DIR__.'/auth.php';
