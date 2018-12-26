<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

/**
 * @property string name
 * @property string last_name
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use HasRoles, Notifiable, SoftDeletes;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The mutated attributes that should be added for arrays.
     *
     * @var array
     */
    protected $appends = [
        'full_name'
    ];

    /**
     * The data to build the layout.
     *
     * @var array
     */
    protected $layout = [
        'tools' => [],
        'table' => [],
        'form' => [
            [
                'name' => 'name',
                'type' => 'text',
                'only-view' => true,
            ],
            [
                'name' => 'last_name',
                'type' => 'text',
                'only-view' => true,
            ],
            [
                'name' => 'phone',
                'type' => 'text'
            ],
            [
                'name' => 'cellphone',
                'type' => 'text'
            ],
            [
                'name' => 'address',
                'type' => 'text'
            ],
            [
                'name' => 'neighborhood',
                'type' => 'text'
            ],
            [
                'name' => 'email',
                'type' => 'text',
                'only-view' => true,
            ],
        ],
    ];

    // Mutator

    /**
     * Full name mutator
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return $this->name . ' ' . $this->last_name;
    }

    // Relationships

    /**
     * Get the orders for the user.
     */
    public function orders()
    {
        return $this->hasMany('App\Order');
    }

    /**
     * Get the stores for the user.
     */
    public function stores()
    {
        return $this->hasMany('App\Store');
    }

    // Methods

    /**
     * Get the data to build the layout.
     *
     * @return array
     */
    public function getLayout(): array
    {
        return $this->layout;
    }
}
