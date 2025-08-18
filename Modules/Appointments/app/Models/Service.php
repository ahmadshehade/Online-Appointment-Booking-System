<?php

namespace Modules\Appointments\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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
}
