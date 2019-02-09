<?php

namespace App;

/**
 * @property int id
 * @property float latitude
 * @property float longitude
 * @property boolean provider
 * @property string full_name
 */
class Store extends Base
{
    // Variables

    /**
     * The mutated attributes that should be added for arrays.
     *
     * @var array
     */
    protected $appends = [
        'actions', 'full_name', 'picture', 'picture_min',
    ];

    /**
     * The data to build the layout.
     *
     * @var array
     */
    protected $layout = [
        'tools' => [
            'create' => true,
            'reload' => false,
        ],
        'table' => [
            'check' => true,
            'fields' => ['picture', 'document', 'name'],
            'active' => true,
            'actions' => true,
        ],
        'form' => [
            [
                'default' => '/storage/stores/default.jpg',
                'name' => 'picture',
                'type' => 'picture',
            ],
            [
                'name' => 'document',
                'type' => 'text'
            ],
            [
                'name' => 'name',
                'type' => 'text'
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
                'type' => 'position'
            ],
        ],
    ];

    // Mutator

    /**
     * Actions mutator
     *
     * @return array
     */
    public function getActionsAttribute()
    {
        return [
            'id' => $this->id,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'title' => $this->full_name,
        ];
    }

    /**
     * Full name mutator
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        if ($this->provider) return $this->name;
        else return  __('app.singular_titles.' . $this->table) . ' ' .$this->name;
    }

    /**
     * Picture mutator
     *
     * @return string
     */
    public function getPictureAttribute()
    {
        if(file_exists(storage_path('app/public/stores/' . $this->id . '.jpg'))){
            return asset('storage/stores/' . $this->id . '.jpg');
        }
        return asset('storage/stores/default.jpg');
    }

    /**
     * Picture min mutator
     *
     * @return string
     */
    public function getPictureMinAttribute()
    {
        if(file_exists(storage_path('app/public/stores/' . $this->id . '.jpg'))){
            return asset('storage/stores/' . $this->id . '.jpg');
        }
        return asset('storage/stores/default.jpg');
    }

    // Relationships

    /**
     * Get the orders for the store.
     */
    public function orders()
    {
        return $this->hasMany('App\Order');
    }

    /**
     * Get the orders for the store.
     */
    public function payments()
    {
        return $this->hasMany('App\Payment');
    }

    /**
     * Get the products for the store.
     */
    public function products()
    {
        return $this->hasMany('App\Product');
    }

    /**
     * Get the user that owns the store.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    // Scopes

    /**
     * Return enabled elements.
     *
     * @param $query
     * @return array
     */
    public function scopeActive($query)
    {
        return $query->where('active', true)->whereHas('products');
    }

    /**
     * Return enabled elements.
     *
     * @param $query
     * @return array
     */
    public function scopeProvider($query)
    {
        return $query->where('provider', true);
    }

    /**
     * Return enabled elements.
     *
     * @param $query
     * @return array
     */
    public function scopeStore($query)
    {
        return $query->where('provider', false);
    }
}
