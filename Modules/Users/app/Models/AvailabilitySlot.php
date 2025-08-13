<?php

namespace Modules\Users\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// use Modules\Users\Database\Factories\AvailabilitySlotFactory;

class AvailabilitySlot extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'day_of_week',
        'start_time',
        'end_time'
    ];

    protected $guarded = ['service_provider_id'];

    // protected static function newFactory(): AvailabilitySlotFactory
    // {
    //     // return AvailabilitySlotFactory::new();
    // }

    /**
     * Get the user that owns the AvailabilitySlot
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function serviceProvider(): BelongsTo
    {
        return $this->belongsTo(User::class, 'service_provider_id', 'id');
    }
}
