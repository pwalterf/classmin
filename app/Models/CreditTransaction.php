<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\CreditTransactionType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

final class CreditTransaction extends Model
{
    /** @use HasFactory<\Database\Factories\CreditTransactionFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'transacted_at',
        'type',
        'credits',
        'balance',
        'description',
        'enrollment_id',
        'transactable_type',
        'transactable_id',
    ];

    /**
     * Get the enrollment that owns the credit transaction.
     *
     * @return BelongsTo<Enrollment, $this>
     */
    public function enrollment(): BelongsTo
    {
        return $this->belongsTo(Enrollment::class);
    }

    /**
     * Get the parent transactable model.
     *
     * @return MorphTo<Model, $this>
     */
    public function transactable(): MorphTo
    {
        return $this->morphTo();
    }

    protected function casts(): array
    {
        return [
            'transacted_at' => 'date',
            'type' => CreditTransactionType::class,
        ];
    }
}
