@extends('layouts.app')

@section('content')

<div class="login login-v2 fw-bold">
    <!-- BEGIN login-cover -->
    <div class="login-cover">
        <div class="login-cover-img" style="background-image: url({{ asset('assets/img/wallpaper.jpg') }})"
            data-id="login-cover-image"></div>
        <div class="login-cover-bg" style="background-color: #244625; opacity: 0.9;" ></div>
    </div>
    <!-- END login-cover -->

    <!-- BEGIN login-container -->
    <div class="login-container">
        <!-- BEGIN login-header -->
        <!-- <div class="login-header d-flex justify-content-center">
        <div class="login-cover">
        <div class="login-cover-img" style="background-color: #244625 !important"
            data-id="login-cover-image"></div>
        <div class="login-cover-bg"></div>
    </div>
    <div class="login-container">
        BEGIN login-header -->
        <div class="login-header d-flex justify-content-center">
        <img class="card-img-top w-150px " src="{{ asset('assets/img/cathedral_logo.png') }}" alt="">
            <img class="card-img-top w-200px " src="{{ asset('assets/img/logos-dumala-trans.png') }}" alt="">
        </div>
        <!-- END login-header -->

        <!-- BEGIN login-content -->
        <div class="login-content">
            <form id="loginForm">
                @csrf
                <div class="form-floating mb-20px">
                    <input type="text" name="email" class="form-control fs-13px h-45px border-0"
                        placeholder="Email Address" id="email" required/>
                    <label for="email" class="d-flex align-items-center text-gray-600 fs-13px">Email Address</label>
                    <div class="invalid-feedback" id="emailError"></div>
                </div>
                <div class="form-floating mb-20px position-relative">
                    <input type="password" name="password" class="form-control fs-13px h-45px border-0"
                        placeholder="Password" id="password" required/>
                    <label for="password" class="d-flex align-items-center text-gray-600 fs-13px">Password</label>
                    <div class="invalid-feedback" id="passwordError"></div>
                    <!-- Eye toggle icon -->
                    <span class="toggle-password position-absolute end-0 top-50 translate-middle-y me-3 cursor-pointer">
                        <i class="text-teal-900 fas fa-lg fa-fw me-10px fa-eye-slash" id="togglePasswordIcon"></i>
                    </span>
                </div>
                <!-- <div class="form-check mb-20px">
                    <input class="form-check-input border-0" type="checkbox" name="remember" value="1"
                        id="rememberMe" />
                    <label class="form-check-label fs-13px text-gray-500" for="rememberMe">Remember Me</label>
                </div> -->
                <div class="mb-20px">
                    <button type="submit" class="btn btn-theme d-block w-100 h-45px btn-lg" style="background-color:#244625 !important">Login</button>
                </div>
                <div class="mb-40px pb-40px">
                    Not a member yet? Click <a href="/register" class="text-primary">here</a> to register.
                </div>
            </form>
            <div id="loginMessage" style="display:none;" class="alert"></div>
        </div>
        <!-- END login-content -->
    </div>
    <!-- END login-container -->
</div>
<script>
// swal({
// title: "Good job!",
// text: "You clicked the button!",
// icon: "success",
// buttons: false, 
// timer: 3000,   
// }); fas fa-lg fa-fw me-10px fa-eye-slash

$(document).ready(function() {
    $('#loginForm').on('submit', function(e) {
        e.preventDefault(); // Prevent the default form submission

        // Clear previous messages and errors
        $('#loginMessage').hide().removeClass('alert-success alert-danger').html('');
        $('.form-control').removeClass('is-invalid');
        $('.invalid-feedback').html('');

        // Collect form data
        let formData = {
            email: $('#email').val(),
            password: $('#password').val(),
            remember: $('#rememberMe').is(':checked') ? 1 : 0,
            _token: $('input[name="_token"]').val()
        };

        // Send AJAX request
        $.ajax({
            url: '/user/login',
            method: 'POST',
            data: formData,
            success: function(response) {
                if (response.field == 1) {
                    // Handle success
                    $('#loginMessage')
                        .addClass('alert-success')
                        .html(response.message)
                        .show();

                    setTimeout(function() {
                        window.location.href = response.redirect || '/';
                    }, 1000);
                } else {
                    $('#loginMessage')
                        .addClass('alert-danger')
                        .html(response.message)
                        .show();
                }
            }
        });
    });

    $('#togglePasswordIcon').on('click', function() {
        const passwordInput = $('#password');
        const icon = $(this);

        if (passwordInput.attr('type') === 'password') {
            passwordInput.attr('type', 'text');
            icon.removeClass('fa-eye-slash').addClass('fa-eye');
        } else {
            passwordInput.attr('type', 'password');
            icon.removeClass('fa-eye').addClass('fa-eye-slash');
        }
    });
});
</script>
@endsection