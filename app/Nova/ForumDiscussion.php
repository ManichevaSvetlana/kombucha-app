<?php

namespace App\Nova;

use App\ForumCategory;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;

class ForumDiscussion extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\ForumDiscussion';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'slug';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'slug', 'user_id', 'user_name', 'title', 'views', 'content'
    ];

    /**
     * @return string
     */
    public static function label(): string
    {
        return 'Forum Discussions';
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        $options = \App\User::pluck('email', 'id');
        return [
            ID::make()->sortable(),
            BelongsTo::make('Category'),


            Select::make('User', 'user_id')->options($options)->onlyOnForms(),
            Text::make('User', 'user_name')->onlyOnIndex()->sortable(),
            Text::make('User', 'user_name')->onlyOnDetail()->sortable(),

            Text::make('Title')->sortable(),
            Text::make('Slug')->sortable(),
            Number::make('Views')->sortable()->onlyOnIndex(),

            Textarea::make('Content')->onlyOnForms(),
            Textarea::make('Content')->onlyOnDetail(),


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
