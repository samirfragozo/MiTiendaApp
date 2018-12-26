<?php

namespace App;


class Category extends Base
{
    // Relationships

    /**
     * Get the products for the category.
     */
    public function products()
    {
        return $this->hasMany('App\Product');
    }
}
