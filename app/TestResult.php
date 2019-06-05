<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TestResult extends Model
{

    protected $fillable = [
        'back_space_count',
        'correct_words',
        'correct_words_count',
        'incorrect_words',
        'incorrect_words_count',
        'test_id',
        'user_id',
        'wpm',
    ];

    /**
     * Defines relationship to user
     *
     * @return void
     */
    public function user() {
        $this->belongsTo(User::class);
    }

}
