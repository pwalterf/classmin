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
        Schema::create('payments', function (Blueprint $table): void {
            $table->id();
            $table->decimal('amount', 9, 2);
            $table->char('currency', 3);
            $table->tinyInteger('credits_purchased');
            $table->date('paid_at');
            $table->text('comments')->nullable();
            $table->foreignId('enrollment_id')->constrained();
            $table->timestamps();
        });
    }
};
