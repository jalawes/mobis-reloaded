@extends('layouts.basic')
@section ('title', 'Welcome')

@section('content')
<section class="hero is-fullheight is-dark is-bold is-matrix">
    <div class="hero-body">
        <div class="column has-text-centered">
            <img width="348px"
                height="158px"
                src="mobis-reloaded.png"
                title="You take the blue pill, the story ends. You wake up in your bed and believe whatever you want to believe. You take the red pill, you stay in Wonderland, and I show you how deep the rabbit hole goes."
            >
            <div class="tabs is-centered">
                <ul>
                    @if (Auth::guest())
                    <li><a href="/login">Sign In</a></li>
                    @elseif (Auth::check())
                    <li class="is-active"><a href="/users/{{ Auth::user()->id }}">Profile</a></li>
                    <li class="is-active"><a href="/quiz">Quiz</a></li>
                    <li><a href="/logout">Logout</a></li>
                    @endif
                </ul>
            </div>
        </div>

    </div>
</section>
@endsection
