<?php

namespace Modules\Users\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Appointments\Models\Coupon;
use Modules\Appointments\Models\Service;
use Modules\Reviews\Models\Review;

// use Modules\Users\Database\Factories\ServiceProviderFactory;

class ServiceProvider extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'phone',
        'address',
        'gender',
        'user_id'
    ];



    // protected static function newFactory(): ServiceProviderFactory
    // {
    //     // return ServiceProviderFactory::new();
    // }

    /**
     * Get the user that owns the ServiceProvider
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }


    /**
     * Get all of the comments for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function availabilitySlots(): HasMany
    {
        return $this->hasMany(AvailabilitySlot::class);
    }

    /**
     * Summary of services
     * @return HasMany<Service, ServiceProvider>
     */
    public function services()
    {
        return $this->hasMany(Service::class);
    }

    /**
     * Summary of reviews
     * @return HasMany<Review, ServiceProvider>
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Summary of coupons
     * @return HasMany<Coupon, ServiceProvider>
     */
    public function coupons()
    {
        return $this->hasMany(Coupon::class);
    }
}
