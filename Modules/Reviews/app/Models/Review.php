<?php

namespace Modules\Reviews\Models;

use App\Enum\UserRoles;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;
use Modules\Users\Models\ServiceProvider;

// use Modules\Reviews\Database\Factories\ReviewFactory;

class Review extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'service_provider_id',
        'user_id',
        'rating',
        'comment'
    ];

    // protected static function newFactory(): ReviewFactory
    // {
    //     // return ReviewFactory::new();
    // }

    /**
     * Summary of serviceProvider
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<ServiceProvider, Review>
     */
    public function serviceProvider()
    {
        return $this->belongsTo(ServiceProvider::class, 'service_provider_id');
    }


    /**
     * Summary of user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User, Review>
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    /**
     * Summary of booted
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope('review-item', function ($query) {
            /**
             * @var \App\Models\User as $user
             */
            $user = Auth::user();
            if ($user->hasRole(UserRoles::SuperAdmin)) {
                return;
            }
            if ($user->hasRole(UserRoles::Provider)) {
                $query->where('service_provider_id', $user->serviceProvider->id);
                return;
            }
            if ($user->hasRole(UserRoles::Client)) {
                $query->where('user_id', $user->id);
                return;
            }
            if (!$user) {
                $query->whereRaw('0=1');
                return;
            }

              $query->whereRaw('0=1');
        });
    }
}
