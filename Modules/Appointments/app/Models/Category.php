<?php

namespace Modules\Appointments\Models;

use Carbon\Carbon;
use Database\Factories\CategoryFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Appointments\Database\Factories\CategoryFactory;

class Category extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name'
    ];

    /**
     * Summary of newFactory
     * @return CategoryFactory
     */
    protected static function newFactory()
    {
        return CategoryFactory::new();
    }

    /**
     * Summary of getCreatedAtAttribute
     * @param mixed $value
     * @return string
     */
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d H:i:s');
    }

    /**
     * Summary of getUpdatedAtAttribute
     * @param mixed $value
     * @return string
     */
    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d H:i:s');
    }



      


    /**
     * Summary of services
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Service, Category>
     */
    public function services()
    {
        return $this->hasMany(Service::class);
    }
}
