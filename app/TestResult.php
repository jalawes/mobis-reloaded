<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TestResult extends Model
{
    protected $fillable = [
        'test_id',
        'user_id',
        'correct_words',
        'correct_words_count',
        'incorrect_words',
        'incorrect_words_count',
        'back_space_count',
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
