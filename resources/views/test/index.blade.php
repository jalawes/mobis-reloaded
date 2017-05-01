@extends('layouts.app')
@section('title', 'Typing Test')
@section('content')

<div class="container">
    <div class="section">

        <h1 class="title">
            Typing Test
        </h1>

        <type-test
            :user="{{ Auth::user() }}"
        ></type-test>

    </div>
</div>

@endsection
