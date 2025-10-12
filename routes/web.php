<?php

use App\Http\Controllers\ExamController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TranscriptController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

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

Route::prefix("exam")->middleware("auth")->group(function () {
    Route::get("/user-exams", [ExamController::class, "userExams"])->middleware("checkRole:user")->name("exam.user");
    Route::post("/create-exam", [ExamController::class, "create"])->middleware("checkRole:admin")->name("exam.create");
    Route::put("/give-vote", [TranscriptController::class, "assignVote"])
    ->middleware(['checkRole:admin,super-admin'])->name("exam.assignment");
});
//------------------------------------- FINE PRIVATE-----------------------------------------------------------------

require __DIR__.'/auth.php';
