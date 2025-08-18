<?php

namespace Modules\Appointments\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

// use Modules\Appointments\Database\Factories\CouponFactory;

class Coupon extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'discount',
        'code',
        'expires_at'
    ];

    protected $casts = [
        'expires_at' => 'date'
    ];




    // protected static function newFactory(): CouponFactory
    // {
    //     // return CouponFactory::new();
    // }


    /**
     * Summary of appointments
     * @return BelongsToMany<Appointment, Coupon, \Illuminate\Database\Eloquent\Relations\Pivot>
     */
    public function appointments():BelongsToMany
    {
        return $this->belongsToMany(Appointment::class,'coupon_appointment');
    }

   
}
