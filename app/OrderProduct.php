<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class OrderProduct extends Pivot
{
    // Variables

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
