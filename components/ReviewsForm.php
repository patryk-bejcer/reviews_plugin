<?php
/**
 * User: Patryk Bejcer
 * Date: 2017-11-30
 * Time: 08:29
 */

namespace patrykbejcer\Reviews\Components;

use Cms\Classes\ComponentBase;
use Input;
use patrykbejcer\Reviews\Models\Review;
use Flash;
use Validator;
use Redirect;
use Mail;

class ReviewsForm extends ComponentBase
{

    public $message;


    /**
     * Returns information about this component, including name and description.
     */
    public function componentDetails()
    {
        return [
            'name' => 'Add new review',
            'description' => 'Add new reviews from front form',
        ];
    }


    public function onSend(){

        $validator = Validator::make(
            [
                'email' => Input::get('email'),
                'content' => Input::get('content'),
                'author' => Input::get('author'),
                'reviewimage' => Input::file('reviewimage')
            ],
            [
                'email' => 'required|min:3|max:50|email',
                'content' => 'required|min:10|max:150',
                'author' => 'required|min:3|max:30',
                'reviewimage' => 'image:jpg,png'
            ]
        );

        if ($validator->fails()) {

            return Redirect::back()->withErrors($validator)->withInput()->with('message', 'IT WORKS!');

        } else {
            $vars = [
                'email' => Input::get('email'),
                'content' => Input::get('content'),
                'author' => Input::get('author'),
                'id' => '',
            ];

            $review = new Review();
            $review->author = $vars['author'];
            $review->email = $vars['email'];
            $review->content = $vars['content'];
            $review->created_at = date('Y-m-d H:i:s');
            $review->reviewimage = Input::file('reviewimage');

            $review->save();

            $vars['id'] = $review->id;

            $this->message = 'All okay!';

            Mail::send('patrykbejcer.reviews::mail.message', $vars, function($message) {

                $message->to('admin@domain.tld', 'Admin Person');
                $message->subject('New review from your Client(s)');

            });

            Flash::success('We would like to inform you that your review has been sent and will be published after verification by the site administrator. Thank you.');

            return Redirect::back();
        }

    }


}