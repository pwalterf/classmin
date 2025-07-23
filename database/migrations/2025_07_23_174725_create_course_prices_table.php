<?php

declare(strict_types=1);

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
        Schema::create('course_prices', function (Blueprint $table): void {
            $table->id();
            $table->decimal('price', 7, 2);
            $table->char('currency', 3);
            $table->date('started_at');
            $table->date('ended_at')->nullable();
            $table->timestamps();
            $table->foreignId('course_id')->constrained();
        });
    }
};
