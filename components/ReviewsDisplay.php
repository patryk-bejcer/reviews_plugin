<?php
/**
 * User: Patryk Bejcer
 * Date: 2017-11-30
 * Time: 08:29
 */

namespace patrykbejcer\Reviews\Components;

use Cms\Classes\ComponentBase;
use patrykbejcer\Reviews\Models\Review;
use Response;
use View;

class ReviewsDisplay extends ComponentBase
{

    public $reviews;

    /**
     * Returns information about this component, including name and description.
     */
    public function componentDetails()
    {
        return [
            'name' => 'Display Reviews',
            'description' => 'Display all reviews',
        ];
    }


    public function getAllReviews(){

        $query = Review::orderBy('created_at', 'desc')->simplePaginate(50)->all();

        return $query;

    }

    public function onRun(){
        $this->reviews = $this->getAllReviews();
    }





}