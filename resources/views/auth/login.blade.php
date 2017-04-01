@extends('layouts.basic')
@section ('title', 'Login')
@section('content')
<section class="hero is-fullheight is-dark is-bold">
    <div class="hero-body">
        <div class="column is-one-third is-offset-one-third has-text-centered">
            <img width="348px"
                height="158px"
                src="mobis-reloaded.png"
                title="You take the blue pill, the story ends. You wake up in your bed and believe whatever you want to believe. You take the red pill, you stay in Wonderland, and I show you how deep the rabbit hole goes."
            />
            <br>
            <div>
                <form class="form-horizontal" role="form" method="POST" action="{{ route('login') }}">
                    {{ csrf_field() }}
                    <div class="field">
                        <p class="control has-icon">
                            <input id="email" name="email" class="input{{ $errors->has('email') ? ' is-danger' : '' }}" type="email" placeholder="Email" value="{{ old('email') }}" required autofocus>
                            <span class="icon"><i class="fa fa-envelope"></i></span>
                        </p>
                        @if ($errors->has('email'))
                            <span class="help is-danger">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                    <br>
                    <div class="field">
                        <p class="control has-icon">
                            <input id="password" name="password" class="input{{ $errors->has('password') ? ' is-danger' : '' }}" type="password" placeholder="Password" required>
                            <span class="icon">
                                <i class="fa fa-lock"></i>
                            </span>
                        </p>
                        @if ($errors->has('password'))
                            <span class="help is-danger">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="field">
                        <p class="help is-success">
                            <a href="{{ route('password.request') }}">
                                Forgot Your Password?
                            </a>
                        </p>
                        <p class="control">
                            <button type="submit" class="button is-pulled-right is-outlined">
                                Login
                            </button>
                        </p>
                    </div>
                </form>
            </div>
        </div>

    </div>
</section>
@endsection
