<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Base
{
    // Variables

    /**
     * The mutated attributes that should be added for arrays.
     *
     * @var array
     */
    protected $appends = [];

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
            'check' => false,
            'fields' => ['created_at', 'value'],
            'active' => false,
            'actions' => false,
        ],
        'form' => [
            [
                'name' => 'value',
                'type' => 'text'
            ],
        ],
    ];

    // Relationships

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
}
