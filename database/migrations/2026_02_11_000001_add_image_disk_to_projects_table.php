<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->string('image_disk')->nullable()->after('image_path');
        });

        DB::table('projects')
            ->whereNotNull('image_path')
            ->whereNull('image_disk')
            ->update(['image_disk' => config('taskflow.project_images_disk', 'public')]);
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('image_disk');
        });
    }
};