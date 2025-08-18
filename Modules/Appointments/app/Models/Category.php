<?php

namespace Modules\Appointments\Models;

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




    // protected static function newFactory(): CategoryFactory
    // {
    //     // return CategoryFactory::new();
    // }


    /**
     * Summary of services
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Service, Category>
     */
    public function services()
    {
        return $this->hasMany(Service::class);
    }
}
