<?php

namespace App\Http\Controllers;

use App\Test;
use Illuminate\Http\Request;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('test.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Test  $Test
     * @return \Illuminate\Http\Response
     */
    public function show(Test $test)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Test  $Test
     * @return \Illuminate\Http\Response
     */
    public function edit(Test $Test)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Test  $Test
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Test $Test)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Test  $Test
     * @return \Illuminate\Http\Response
     */
    public function destroy(Test $Test)
    {
        //
    }

    public function getTest()
    {
        $test = Test::all()->last();
        return $test;
    }

    public function finishTest(Request $request)
    {
        // return $request;
        // return serialize($request->all());
        $test = TestResult::create([
            'test_id' => $request->test_id,
            'user_id' => $request->user_id,
            'correct_words' => $request->correct_words,
            'correct_words_count' => $request->correct_words_count,
            'incorrect_words' => $request->incorrect_words_count,
            'incorrect_words_count' => $request->incorrect_words_count,
            'back_space_count' => $request->back_space_count,
            // 'wpm' => $request->wpm,
        ]);
        return $test;
        return dd($test);
        return $test;
        // if ($results->save()) {
        //     return 'Logged test results in the controller!';
        // } else {
        //     return 'There was an error. The test results could not be saved in the controller.';
        // }
        // $test = Test::all()->last();
    }
}
