@extends('layouts.app')

@section('content')

<div class="login login-v2 fw-bold">
    <!-- BEGIN login-cover -->
    <div class="login-cover">
        <div class="login-cover-img" style="background-image: url({{ asset('assets/img/wallpaper.jpg') }})"
            data-id="login-cover-image"></div>
        <div class="login-cover-bg"></div>
    </div>
    <!-- END login-cover -->

    <!-- BEGIN login-container -->
    <div class="login-container">
        <!-- BEGIN login-header -->
        <div class="login-header d-flex justify-content-center">
            <!-- <div class="brand">
                <div class="d-flex align-items-center">
                    <i class="fab fa-facebook-square fa-lg me-3"></i> <b>Color</b> Admin
                </div>
                <small>Bootstrap 5 Responsive Admin Template</small>
            </div>
            <div class="icon">
                <i class="fa fa-lock"></i>
            </div> -->
            <img class="card-img-top w-200px " src="{{ asset('assets/img/logos-dumala-trans.png') }}" alt="">
        </div>
        <!-- END login-header -->

        <!-- BEGIN login-content -->
        <div class="login-content">
            <form id="loginForm">
                @csrf
                <div class="form-floating mb-20px">
                    <input type="text" name="email" class="form-control fs-13px h-45px border-0"
                        placeholder="Email Address" id="email" />
                    <label for="email" class="d-flex align-items-center text-gray-600 fs-13px">Email Address</label>
                    <div class="invalid-feedback" id="emailError"></div>
                </div>
                <div class="form-floating mb-20px position-relative">
                    <input type="password" name="password" class="form-control fs-13px h-45px border-0"
                        placeholder="Password" id="password" />
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

        // Get input values
        let email = $('#email').val().trim();
        let password = $('#password').val().trim();
        let isValid = true;

        // Email validation
        if (!email) {
            $('#email').addClass('is-invalid');
            $('#emailError').html('Email is required.');
            isValid = false;
        } else if (!validateEmail(email)) {
            $('#email').addClass('is-invalid');
            $('#emailError').html('Invalid email format.');
            isValid = false;
        }

        // Password validation
        if (!password) {
            $('#password').addClass('is-invalid');
            $('#passwordError').html('Password is required.');
            isValid = false;
        }

        if (!isValid) return; // Stop if validation fails

        // Collect form data
        let formData = {
            email: email,
            password: password,
            remember: $('#rememberMe').is(':checked') ? 1 : 0,
            _token: $('input[name="_token"]').val()
        };

        // Send AJAX request
        $.ajax({
            url: '/user/login',
            method: 'POST',
            data: formData,
            success: function(response) {
<<<<<<< HEAD

                console.log(response); 

=======
>>>>>>> upstream/main
                if (response.field == 1) {
                    $('#loginMessage')
                        .addClass('alert-success')
                        .html(response.message)
                        .show();

                    setTimeout(function() {
                        window.location.href = response.redirect || '/';
                    }, 1000);
<<<<<<< HEAD
                } else if (response.field == 2) {
                    $('#password').val('');
                    $('#loginMessage')
                        .addClass('alert-danger')
                        .html(response.message)
                        .show();

                } else if (response.field == 3) {
                    $('#password').val('');
                    $('#loginMessage')
                        .addClass('alert-danger')
                        .html(response.message)
                        .show();

                } else if (response.field == 4) {
                    $('#email').val('');
                    $('#loginMessage')
                        .addClass('alert-danger')
                        .html(response.message)
                        .show();
                // } else {
                //     $('#loginMessage')
                //         .addClass('alert-danger')
                //         .html(response.message)
                //         .show();
                }
            }, error: function(xhr) {
                // Check if the response status is 422 (validation error)
                if (xhr.status === 422) {
                    // Get the validation errors from the response
                    var errors = xhr.responseJSON.errors;
                    var errorMessage = '';

                    // Loop through each error and create a string with all the messages
                    $.each(errors, function(field, messages) {
                        errorMessage += messages.join('\n');
                    });

                    // Display the error messages in the login message container
=======
                } else {
>>>>>>> upstream/main
                    $('#loginMessage')
                        .addClass('alert-danger')
                        .html(errorMessage.replace(/\n/g, '<br>'))
                        .show();
                } else {
                    // If any other error occurs
                    $('#loginMessage')
                        .addClass('alert-danger')
                        .html('An unexpected error occurred. Please try again.')
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

    function validateEmail(email) {
        const re = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        return re.test(email);
    }
});
</script>
@endsection