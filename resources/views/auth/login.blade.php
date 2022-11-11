@extends('layouts.login.login')

@section('content')

@include('auth._login')
@include('auth.register',compact('events'))
<div class="overlay-container">
    <div class="overlay">
        <div class="overlay-panel overlay-left">
            <h1>Welcome Back!</h1>
            <p>To keep connected with us please login with your personal info</p>
            <button class="ghost" id="signIn">Sign In</button>
        </div>
        <div class="overlay-panel overlay-right">
            <h1>Hello, Friend!</h1>
            <p>Enter your personal details and start journey with us</p>
            <button class="ghost" id="signUp">Sign Up</button>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function() 
    {
        // If theres exist a session called register and it does have a value, it means registration form failed, so we force to click sign up button to back to the registration form
        var session = "{{session('register')}}";
        if (session) 
        {
            $("#signUp").click();
        }
    });
</script>
@endsection

<?php 
    //Unset register failed form session
    session()->forget('register');
 ?>
