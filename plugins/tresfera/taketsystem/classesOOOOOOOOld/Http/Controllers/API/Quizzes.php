<?php

namespace Tresfera\Taketsystem\Classes\Http\Controllers\API;

use Tresfera\Taketsystem\Classes\Http\Controllers\API;
use Request;
use Tresfera\Taketsystem\Models\Quiz;
use Tresfera\Taketsystem\Models\Answer;
use Tresfera\Taketsystem\Models\Result;
use Tresfera\Taketsystem\Models\Slide;

class Quizzes extends API
{
    /**
     * Instantiate a new API instance.
     */
    public function __construct()
    {
        // Auth
        $this->middleware('Tresfera\Taketsystem\Classes\Http\Middleware\API\Auth');
    }

    /**
     * List quizzes.
     *
     * @return Response
     */
    public function index()
    {
        // Auth
        $this->tokenAuth();
		
        // Get active quizzes
        $quizzes = $this->device->quizzes()->with('slides')->get();
        // Response
        return $this->response(['quizzes' => $quizzes]);
    }

    /**
     * Save quizzes results.
     *
     * @return Response
     */
    public function save()
    {
        // Auth
        $this->tokenAuth();

        // Results
        $results = Request::get('results');
        if (is_array($results) && !empty($results)) {

            // Results
            foreach ($results as $result_data) {
				if(!isset($result_data['quizz_id'])) continue;
                // Create result
                $result = new Result();
                $result->quiz()->associate(Quiz::findOrFail($result_data['quizz_id']));
                $result->device()->associate($this->device);
                $result->save();

                // Answers
                foreach ($result_data['answers'] as $answer_data) {

                    // Create answer
                    $answer = new Answer();
                    $answer->slide()->associate(Slide::findOrFail($answer_data['slide_id']));
                    $answer->result()->associate($result);
                    $answer->value           = $answer_data['answer'];
                    $answer->question_number = $answer_data['question_id'];
                    $answer->question_title  = $answer_data['question'];
                    $answer->question_type   = $answer_data['type'];
                    $answer->created_at      = date('Y-m-d H:i:s', strtotime($answer_data['create_at']));
                    $answer->save();
                }
            }
        }

        // Response
        return $this->response();
    }
}
