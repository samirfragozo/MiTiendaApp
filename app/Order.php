<?php

namespace App;

use Illuminate\Support\Collection;

/**
 * @property int id
 * @property Collection products
 * @property string status
 */
class Order extends Base
{
    // Variables

    /**
     * The mutated attributes that should be added for arrays.
     *
     * @var array
     */
    protected $appends = [
        'actions_user', 'actions', 'total', 'quantity', 'translated_status',
    ];

    /**
     * The data to build the layout.
     *
     * @var array
     */
    protected $layout = [
        'tools' => [
            'create' => false,
            'reload' => false,
        ],
        'table' => [
            'check' => false,
            'fields' => ['created_at', 'user_id', 'quantity', 'total', 'status'],
            'active' => false,
            'actions' => true,
        ],
        'form' => [],
    ];

    // Mutator

    /**
     * Quantity mutator
     *
     * @return array
     */
    public function getActionsAttribute()
    {
        return [
            'id' => $this->id,
            'cancel' => $this->status == 'pending' or $this->status == 'dispatched',
            'next' => __('app.selects.orders.status_next.' . $this->status),
        ];
    }

    /**
     * Quantity mutator
     *
     * @return array
     */
    public function getActionsUserAttribute()
    {
        return [
            'id' => $this->id,
            'cancel' => $this->status == 'pending',
        ];
    }

    /**
     * Quantity mutator
     *
     * @return string
     */
    public function getQuantityAttribute()
    {
        return $this->products()->count();
    }

    /**
     * Total mutator
     *
     * @return string
     */
    public function getTotalAttribute()
    {
        $total = 0;

        foreach ($this->products as $product) $total += $product->pivot->subtotal;

        return $total;
    }

    /**
     * Translated status mutator
     *
     * @return array
     */
    public function getTranslatedStatusAttribute()
    {
        return [
            'status' => __('app.selects.orders.status.' . $this->status),
            'class' => __('app.selects.orders.status_class.' . $this->status),
        ];
    }

    // Relationships

    /**
     * The products that belong to the order.
     */
    public function products()
    {
        return $this->belongsToMany('App\Product')->withPivot('quantity', 'historical_price', 'subtotal');
    }

    /**
     * Get the store that owns the order.
     */
    public function store()
    {
        return $this->belongsTo('App\Store');
    }

    /**
     * Get the user that owns the order.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    // Scopes

    /**
     * Return orders for the providers.
     *
     * @param $query
     * @return array
     */
    public function scopeProvider($query)
    {
        return $query->whereHas('store', function ($user) {
            $user->where('provider', true);
        });
    }

    /**
     * Return orders for the stores.
     *
     * @param $query
     * @return array
     */
    public function scopeStore($query)
    {
        return $query->whereHas('store', function ($user) {
            $user->where('provider', false);
        });
    }
}
