<?php

namespace Modules\Appointments\Models;

use Carbon\Carbon;
use Database\Factories\CouponFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Users\Models\ServiceProvider;

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
        'expires_at',
        'service_provider_id'
    ];

    protected $casts = [
        'expires_at' => 'datetime'
    ];




    protected static function newFactory(): CouponFactory
    {
        return CouponFactory::new();
    }


    /**
     * Summary of appointments
     * @return BelongsToMany<Appointment, Coupon, \Illuminate\Database\Eloquent\Relations\Pivot>
     */
    public function appointments(): BelongsToMany
    {
        return $this->belongsToMany(Appointment::class, 'coupon_appointment');
    }


    /**
     * Summary of serviceProvider
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<ServiceProvider, Coupon>
     */
    public function serviceProvider()
    {
        return $this->belongsTo(ServiceProvider::class, 'service_provider_id', 'id');
    }


    /**
     * Summary of getCreatedAtAttribute
     * @param mixed $value
     * @return string
     */
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d');
    }

    /**
     * Summary of getUpdatedAtAttribute
     * @param mixed $value
     * @return string
     */
    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d');
    }

    /**
     * Summary of getExpiresAtAttribute
     * @param mixed $value
     * @return string
     */
    public function getExpiresAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d');
    }
}
