@extends('layouts.app')

@section('content')
<div class="container welcome">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Welcome!</div>
                <div class="panel-body">
                    This's Groupwarelike Application for the Schedule Management and Communication
                    with Group Members.
                </div>
            </div>

            <!-- Authentication Links -->
            @if (Auth::guest())
            <div class="login-btn">
                <a href="{{ url('/login') }}"><button type="button" class="btn btn-primary">
                  Login
                </button></a>
                <a href="{{ url('/register') }}"><button type="button" class="btn btn-primary">
                  Register
                </button></a>
            </div>
            @endif

        </div>
    </div>
</div>
@endsection
