<?php namespace patrykbejcer\Reviews;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
        return [
            'patrykbejcer\Reviews\Components\ReviewsForm' => 'reviewsform',
            'patrykbejcer\Reviews\Components\ReviewsDisplay' => 'reviewsdisplay',
        ];
    }

    public function registerSettings()
    {

    }
}
