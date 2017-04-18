<?php

use App\Question;
use Illuminate\Database\Seeder;

class QuestionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Question::truncate();
        // $questions = factory(App\Question::class, 3)->make();
        $question = Question::create([
            'subject' => 'Laravel: Routing',
            'difficulty' => 'easy',
            'problem' => 'Which of the following is not one of the Available Router Methods in Laravel?',
            'answer' => 'Route::put($uri, $callback);',
            'wrong_one' => 'Route::get($uri, $callback);',
            'wrong_two' => 'Route::post($uri, $callback);',
            'wrong_three' => 'Route::options($uri, $callback);',
            'creator' => 'Jamal',
        ]);
    }
}
