<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string name
 */
class Base extends Model
{
    // Variables

    /**
     * The mutated attributes that should be added for arrays.
     *
     * @var array
     */
    protected $appends = [
        'fullName',
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'massive', 'data', 'picture',
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
            'fields' => [],
            'active' => false,
            'actions' => false,
        ],
        'form' => [],
    ];

    // Mutator

    /**
     * Full name mutator
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return __('app.singular_titles.' . $this->table) . ' ' . $this->name;
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

    /**
     * Set baseQuery variable
     *
     * @return array
     */
    public function select()
    {
        return $this->get()->sortBy('name')->pluck('name', 'id');
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
        return $query->where('active', true);
    }
}
