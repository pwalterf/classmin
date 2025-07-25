<?php

declare(strict_types=1);

use App\Enums\EnrollmentStatus;
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
        Schema::create('enrollments', function (Blueprint $table): void {
            $table->id();
            $table->enum('status', EnrollmentStatus::getStatuses());
            $table->date('enrolled_at');
            $table->tinyInteger('credits');
            $table->tinyInteger('discount_pct')->nullable();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('course_id')->constrained();
            $table->timestamps();
        });
    }
};
