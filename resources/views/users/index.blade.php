@extends('layouts.app')
@section('title', 'Leader Board')

@section('content')
<div class="container">
    <div class="section">
        <h1 class="title">Leader Board</h1>

        <table class="table">
            <thead>
                <tr>
                    <th>Rank</th>
                    <th>Username</th>
                    <th>WPM</th>
                    <th>Points</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $key => $user)
                    @if($user->share_stats == true)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td><a href="#">{{ $user->first_name }} {{ $user->last_name }}</a></td>
                            <td>{{ $user->wpm }}</td>
                            <td>{{ $user->points }}</td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
