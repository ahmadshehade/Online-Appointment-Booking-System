<?php

namespace Modules\Payments\Models;

use App\Enum\UserRoles;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;
use Modules\Appointments\Models\Appointment;

// use Modules\Payments\Database\Factories\PaymentFactory;

class Payment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'appointment_id',
        'amount',
        'status',
    ];

    // protected static function newFactory(): PaymentFactory
    // {
    //     // return PaymentFactory::new();
    // }


    /**
     * Summary of appointment
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Appointment, Payment>
     */
    public function appointment()
    {
        return $this->belongsTo(Appointment::class, 'appointment_id');
    }

    /**
     * Summary of booted
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope('user_scope', function (Builder $builder) {
            $user = Auth::user();
            /** @var \App\Models\User $user */
            if (!$user) {
                $builder->whereRaw('0=1');
                return;
            }

            if ($user->hasRole(UserRoles::SuperAdmin)) {
                return;
            }


            if ($user->hasRole(UserRoles::Provider)) {
                $builder->whereHas('appointment.service.serviceProvider', function ($q) use ($user) {
                    $q->where('id', $user->serviceProvider->id);
                });
            } else if ($user->hasRole(UserRoles::Client)) {
                $builder->whereHas('appointment', function ($q) use ($user) {
                    $q->where('user_id', $user->id);
                });
            }
        });
    }
}
