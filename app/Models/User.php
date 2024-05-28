<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;
use App\Filters\Shared\SearchByFilter;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public $filters = [
        'search' => SearchByFilter::class
    ];
    

    public function scopeFilter(Builder $query, $filters): Builder
    {
        if(count($filters) === 0) return $query;
        foreach($filters as $key => $value){
            if(array_key_exists($key, $this->filters)){
                $filterClass = $this->filters[$key];
                $filterObject = new $filterClass();
                $query = $filterObject->handle($query, $value);
            }
        }

        return $query;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'last_name',
        'company',
        'area',
        'department',
        'job_title',
        'picture_url',
        'status'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
    ];
}
