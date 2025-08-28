<?php

namespace Modules\Users\Models;

use App\Enum\UserRoles;
use App\Models\User;
use Carbon\Carbon;
use Database\Factories\AvailabilitySlotFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Appointments\Models\Appointment;

// use Modules\Users\Database\Factories\AvailabilitySlotFactory;

class AvailabilitySlot extends Model
{
    use HasFactory;


    /**
     * Summary of newFactory
     * @return AvailabilitySlotFactory
     */
    protected static function newFactory()
    {
        return AvailabilitySlotFactory::new();
    }
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'day_of_week',
        'start_time',
        'end_time',
        'service_provider_id'
    ];


    /**
     * Summary of casts
     * @var array
     */
    protected $casts = [
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
    ];

    /**
     * Get the user that owns the AvailabilitySlot
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function serviceProvider(): BelongsTo
    {
        return $this->belongsTo(ServiceProvider::class, 'service_provider_id', 'id');
    }

    /**
     * Summary of scopForUser
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $user
     * @return Builder
     */
    public function scopeForUser(Builder $query, $user)
    {

        if ($user->hasRole(UserRoles::Provider)) {
            return $query->where('service_provider_id', $user->serviceProvider->id);
        }
        return $query;
    }


    /**
     * Summary of ppointments
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Appointment, AvailabilitySlot>
     */
    public function apointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
