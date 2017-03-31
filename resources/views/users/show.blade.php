@extends ('layouts.app')
@section ('title', 'User Profile')
@section ('content')
    <profile :user="{{ Auth::user() }}"></profile>
@endsection
