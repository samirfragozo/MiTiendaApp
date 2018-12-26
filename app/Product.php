<?php

namespace App;

class Product extends Base
{
    // Variables

    /**
     * The mutated attributes that should be added for arrays.
     *
     * @var array
     */
    protected $appends = [
        'full_name', 'picture', 'picture_min',
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
            'fields' => ['picture', 'name', 'price', 'category_id'],
            'active' => true,
            'actions' => false,
        ],
        'form' => [
            [
                'default' => '/storage/products/default.jpg',
                'name' => 'picture',
                'type' => 'picture',
            ],
            [
                'name' => 'name',
                'type' => 'text'
            ],
            [
                'name' => 'price',
                'type' => 'text'
            ],
            [
                'name' => 'category_id',
                'type' => 'select_reload',
            ],
            [
                'name' => 'description',
                'type' => 'textarea',
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
        return $this->name;
    }

    /**
     * Picture mutator
     *
     * @return string
     */
    public function getPictureAttribute()
    {
        if(file_exists(storage_path('app/public/products/' . $this->id . '.jpg'))){
            return asset('storage/products/' . $this->id . '.jpg');
        }
        return asset('storage/products/default.jpg');
    }

    /**
     * Picture min mutator
     *
     * @return string
     */
    public function getPictureMinAttribute()
    {
        if(file_exists(storage_path('app/public/products/' . $this->id . '.jpg'))){
            return asset('storage/products/' . $this->id . '.jpg');
        }
        return asset('storage/products/default.jpg');
    }

    // Relationships

    /**
     * Get the category that owns the product.
     */
    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    /**
     * The orders that belong to the product.
     */
    public function orders()
    {
        return $this->belongsToMany('App\Order');
    }

    /**
     * Get the store that owns the product.
     */
    public function store()
    {
        return $this->belongsTo('App\Store');
    }
}
