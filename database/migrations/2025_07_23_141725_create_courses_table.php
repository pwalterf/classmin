<?php

declare(strict_types=1);

use App\Enums\CourseStatuses;
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
        Schema::create('courses', function (Blueprint $table): void {
            $table->id();
            $table->string('title')->unique();
            $table->text('description')->nullable();
            $table->date('started_at');
            $table->enum('status', CourseStatuses::getStatuses());
            $table->timestamps();
        });
    }
};
