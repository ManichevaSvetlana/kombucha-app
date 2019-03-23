<?php

namespace Acme\BelongsToWithType;

use Laravel\Nova\Fields\Field;

class BelongsToWithType extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'belongs-to-with-type';
}
