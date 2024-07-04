<?php

namespace Cboxdk\StatamicOverseer\Scopes;

use Statamic\Query\Scopes\Filter;

class OverseerDate extends Filter
{
    /**
     * Pin the filter.
     *
     * @var bool
     */
    public $pinned = false;

    /**
     * Define the filter's title.
     *
     * @return string
     */
    public static function title()
    {
        return __('StatamicOverseerFilter');
    }

    /**
     * Define the filter's field items.
     *
     * @return array
     */
    public function fieldItems()
    {
        // return [
        //     'featured' => [
        //         'type' => 'radio',
        //         'options' => [
        //             'featured' => __('Featured'),
        //             'not_featured' => __('Not Featured'),
        //         ]
        //     ]
        // ];
    }

    /**
     * Apply the filter.
     *
     * @param  \Statamic\Query\Builder  $query
     * @param  array  $values
     * @return void
     */
    public function apply($query, $values)
    {
        // $query->where('featured', $values['featured'] === 'featured');
    }

    /**
     * Define the applied filter's badge text.
     *
     * @param  array  $values
     * @return string
     */
    public function badge($values)
    {
        // return $values['featured'] === 'featured'
        //     ? __('Featured')
        //     : __('Not Featured');
    }

    /**
     * Determine when the filter is shown.
     *
     * @param  string  $key
     * @return bool
     */
    public function visibleTo($key)
    {
        return $key === 'overseer_audit' || $key === 'overseer_event' || $key === 'overseer_execution';
    }
}