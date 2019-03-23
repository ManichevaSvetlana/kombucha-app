<?php

namespace App\Nova;

use Acme\AccountContacts\AccountContacts;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Place;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;

class Accounts extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\NovaModels\Account';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),
            Text::make('Name')->sortable(),
            Place::make('Delivery Address')->sortable(),
            Date::make('Delivery Day')->sortable(),
            Boolean::make('Purchase Order Required')->sortable(),
            Textarea::make('Re-Order Message To Customer', 'message')->sortable(),
            BelongsTo::make('SalesRepresentative')->sortable(),

            AccountContacts::make('Contact #1', 'contact_1')->onlyOnForms(),
            AccountContacts::make('Contact #2', 'contact_2')->onlyOnForms(),
            AccountContacts::make('Contact #3', 'contact_3')->onlyOnForms(),

            AccountContacts::make('Contact #1', 'contact_1')->onlyOnDetail(),
            AccountContacts::make('Contact #2', 'contact_2')->onlyOnDetail(),
            AccountContacts::make('Contact #3', 'contact_3')->onlyOnDetail(),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }
}
