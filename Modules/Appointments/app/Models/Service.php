<?php

namespace Modules\Appointments\Models;

use App\Enum\UserRoles;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;
use Modules\Users\Models\ServiceProvider;

// use Modules\Appointments\Database\Factories\ServiceFactory;

class Service extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'service_provider_id',
        'category_id',
        'name',
        'description',
        'price'
    ];


    protected $casts = [
        'price' => 'decimal:2',
    ];

    // protected static function newFactory(): ServiceFactory
    // {
    //     // return ServiceFactory::new();
    // }



    /**
     * Summary of category
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Category, Service>
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * Summary of serviceProvider
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<ServiceProvider, Service>
     */
    public function serviceProvider()
    {
        return $this->belongsTo(ServiceProvider::class, 'service_provider_id');
    }

    /**
     * Summary of appointment
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Appointment, Service>
     */
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }



    /**
     * Summary of scopeGetServices
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $user
     * @return Builder
     */
    public  function  scopeGetServices(Builder $query, $user)
    {
        if ($user->hasRole(UserRoles::Provider)) {
            return $query->where('service_provider_id', $user->serviceProvider->id)
                ->orderBy('created_at', 'desc');
        } else {
            return $query->orderBy('created_at', 'desc');
        }
    }

    /**
     * Summary of getCreatedAtAttribute
     * @param mixed $value
     * @return string
     */
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('y-m-d H:i:s');
    }

    /**
     * Summary of getUpdatedAtAttribute
     * @param mixed $value
     * @return string
     */
    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('y-m-d H:i:s');
    }
}
