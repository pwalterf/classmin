<?php

declare(strict_types=1);

use App\Enums\CreditTransactionType;
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
        Schema::create('credit_transactions', function (Blueprint $table): void {
            $table->id();
            $table->date('transacted_at');
            $table->enum('type', CreditTransactionType::values());
            $table->tinyInteger('credits');
            $table->tinyInteger('balance');
            $table->string('description')->nullable();
            $table->foreignId('enrollment_id')->constrained();
            $table->foreignId('payment_id')->nullable()->constrained();
            $table->timestamps();
        });
    }
};
