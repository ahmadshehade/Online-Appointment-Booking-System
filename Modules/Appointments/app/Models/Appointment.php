<?php

namespace Modules\Appointments\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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

    // protected static function newFactory(): AppointmentFactory
    // {
    //     // return AppointmentFactory::new();
    // }


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
}
