<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\KanbanController;
use Illuminate\Support\Facades\Route;

Route::get(\'/\', function () {
    return redirect()->route(\'projects.index\');
});

Route::middleware([\'auth\', \'verified\'])->group(function () {
    Route::get(\'/dashboard\', [DashboardController::class, \'index\'])->name(\'dashboard\');

    Route::resource(\'projects\', ProjectController::class);
    Route::resource(\'tasks\', TaskController::class)->except([\'index\', \'show\']);
    Route::patch(\'tasks/{task}/status\', [TaskController::class, \'updateStatus\'])->name(\'tasks.updateStatus\');
    Route::post(\'tasks/{task}/comments\', [CommentController::class, \'store\'])->name(\'comments.store\');
    Route::delete(\'comments/{comment}\, [CommentController::class, \'destroy\'])->name(\'comments.destroy\');

    // Anexos
    Route::post(\'tasks/{task}/attachments\', [TaskController::class, \'uploadAttachment\'])->name(\'tasks.attachments.store\');
    Route::delete(\'attachments/{attachment}\, [TaskController::class, \'deleteAttachment\'])->name(\'attachments.destroy\');

    Route::get(\'/invitations\', [InvitationController::class, \'index\'])->name(\'invitations.index\');
    Route::post(\'/invitations\', [InvitationController::class, \'store\'])->name(\'invitations.store\');
    Route::delete(\'/invitations/{invitation}\, [InvitationController::class, \'destroy\'])->name(\'invitations.destroy\');

    // Notificações
    Route::get(\'/notifications\', [NotificationController::class, \'index\'])->name(\'notifications.index\');
    Route::get(\'/notifications/{id}/read\', [NotificationController::class, \'markAsRead\'])->name(\'notifications.read\');
    Route::post(\'/notifications/mark-all-read\', [NotificationController::class, \'markAllAsRead\'])->name(\'notifications.mark-all-read\');

    // Rotas do Kanban
    Route::get(\'/kanban\', [KanbanController::class, \'index\'])->name(\'kanban.index\');
    Route::patch(\'/kanban/tasks/{task}/status\', [KanbanController::class, \'updateTaskStatus\'])->name(\'kanban.updateTaskStatus\');

    Route::get(\'/profile\', [ProfileController::class, \'edit\'])->name(\'profile.edit\');
    Route::patch(\'/profile\', [ProfileController::class, \'update\'])->name(\'profile.update\');
    Route::delete(\'/profile\', [ProfileController::class, \'destroy\'])->name(\'profile.destroy\');
});

require __DIR__.\'/auth.php\';
