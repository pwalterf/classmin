<?php

declare(strict_types=1);

use App\Enums\AttendanceStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table): void {
            $table->id();
            $table->enum('status', AttendanceStatus::values());
            $table->text('notes')->nullable();
            $table->date('registered_at');
            $table->foreignId('lesson_id')->constrained();
            $table->foreignId('enrollment_id')->constrained();
            $table->timestamps();
        });
    }
};
