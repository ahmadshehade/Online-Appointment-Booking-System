<?php

namespace Modules\Appointments\Models;

use App\Enum\UserRoles;
use App\Models\User;
use Database\Factories\AppointmentFactory;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;
use Modules\Appointments\Enum\AppointmentStatus;
use Modules\Payments\Models\Payment;
use Modules\Users\Models\AvailabilitySlot;

// use Modules\Appointments\Database\Factories\AppointmentFactory;

class Appointment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'service_id',
        'user_id',
        'availability_slot_id',
        'status'
    ];

    /**
     * Summary of newFactory
     * @return AppointmentFactory
     */
    protected static function newFactory(): AppointmentFactory
    {
        return AppointmentFactory::new();
    }


    protected  $casts = [
        'status' => AppointmentStatus::class
    ];

    /**
     * Summary of service
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Service, Appointment>
     */
    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    /**
     * Summary of user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User, Appointment>
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Summary of slot
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<AvailabilitySlot, Appointment>
     */
    public  function  slot()
    {
        return $this->belongsTo(AvailabilitySlot::class, 'availability_slot_id');
    }

    /**
     * Summary of coupons
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<Coupon, Appointment, \Illuminate\Database\Eloquent\Relations\Pivot>
     */
    public function coupons()
    {
        return $this->belongsToMany(Coupon::class, 'coupon_appointment');
    }

    /**
     * Summary of payments
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Payment, Appointment>
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }


    /**
     * Summary of booted
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope('user_item', function (Builder $builder) {
            if ($user = Auth::user()) {
                /** @var \App\Models\User $user */
                if ($user->hasRole(UserRoles::SuperAdmin)) {
                    return;
                }
                if ($user->hasRole(UserRoles::Client)) {
                    $builder->where('user_id', $user->id);
                    return;
                }
                if ($user->hasRole(UserRoles::Provider)) {
                    if ($user->serviceProvider) {
                        $builder->whereHas('service', function ($q) use ($user) {
                            $q->where('service_provider_id', $user->serviceProvider->id);
                        });
                    } else {
                        $builder->whereRaw('0=1');
                    }
                    return;
                }
                $builder->whereRaw('0=1');
            }
        });
    }
}
