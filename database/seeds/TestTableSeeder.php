<?php

use App\Test;
use Illuminate\Database\Seeder;

class TestTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Test::truncate();
        $test = factory(Test::class, 10)->create();

        $test = Test::create([
            'title' => '# You Don\'t Know JS Types and Grammar Pt. 1',
            'text' => 'In JavaScript, variables don\'t have types - values have types. Variables can hold any value, at any time.

Another way to think about JS types is that JS doesn\'t have "type enforcement," in that the engine doesn\'t insist that a variable always holds values of the same initial type that it starts out with. A variable can, in one assignment statement, hold a string, and in the next hold a number, and so on.

The value 42 has an intrinsic type of number, and its type cannot be changed. Another value, like "42" with the string type, can be created from the number value 42 through a process called coercion (see Chapter 4).

If you use typeof against a variable, it\'s not asking "What\'s the type of the variable?" as it may seem, since JS variables have no types. Instead, it\'s asking "What\'s the type of the value in the variable?"
    var a = 42;
    typeof a; // "number"
    a = true;
    typeof a; // "boolean"
The typeof operator always returns a string. So: typeof typeof 42; // "string"
The first typeof 42 returns "number", and typeof "number" is "string".
'
        ]);
    }
}
