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
            <img class="card-img-top w-150px " src="{{ asset('assets/img/cathedral_logo.png') }}" alt="">
            <img class="card-img-top w-200px " src="{{ asset('assets/img/logos-dumala-trans.png') }}" alt="">
        </div>
        <!-- END login-header -->

        <!-- BEGIN login-content -->
        <div class="login-content">
            <form id="loginForm">

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-floating mb-20px">
                            <input type="text" name="firstname" class="form-control fs-13px h-45px border-0"
                                placeholder="First Name" id="firstname" />
                            <label for="firstname" class="d-flex align-items-center text-gray-600 fs-13px">First
                                Name</label>
                            <div class="invalid-feedback" id="firstnameError"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating mb-20px">
                            <input type="text" name="lastname" class="form-control fs-13px h-45px border-0"
                                placeholder="Last name" id="lastname" />
                            <label for="lastname" class="d-flex align-items-center text-gray-600 fs-13px">Last
                                Name</label>
                            <div class="invalid-feedback" id="lastnameError"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-floating mb-20px">
                            <input type="text" name="email" class="form-control fs-13px h-45px border-0"
                                placeholder="Email Address" id="email" />
                            <label for="email" class="d-flex align-items-center text-gray-600 fs-13px">Email
                                Address</label>
                            <div class="invalid-feedback" id="emailError"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-floating mb-20px position-relative">
                            <input type="password" name="password" class="form-control fs-13px h-45px border-0"
                                placeholder="Password" id="password" />
                            <label for="password"
                                class="d-flex align-items-center text-gray-600 fs-13px">Password</label>
                            <div class="invalid-feedback" id="passwordError"></div>
                            <!-- Eye toggle icon -->
                            <span
                                class="toggle-password position-absolute end-0 top-50 translate-middle-y me-3 cursor-pointer">
                                <i class="text-teal-900 fas fa-lg fa-fw me-10px fa-eye-slash"
                                    id="togglePasswordIcon"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-floating mb-20px position-relative">
                            <input type="password" name="confirm-password" class="form-control fs-13px h-45px border-0"
                                placeholder="Confirm Password" id="confirm-password" />
                            <label for="confirm-password"
                                class="d-flex align-items-center text-gray-600 fs-13px">Confirm Password</label>
                            <div class="invalid-feedback" id="confirm-passwordError"></div>
                            <!-- Eye toggle icon -->
                            <span
                                class="toggle-confirm-password position-absolute end-0 top-50 translate-middle-y me-3 cursor-pointer">
                                <i class="text-teal-900 fas fa-lg fa-fw me-10px fa-eye-slash"
                                    id="toggleconfirm-passwordIcon"></i>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="mb-20px">
                    <button type="submit" class="btn btn-theme d-block w-100 h-45px btn-lg" style="background-color:#244625 !important">Register</button>
                </div>
                <div class="mb-4 pb-5">
                    Already a member? Click <a href="/login">here</a> to login.
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
        e.preventDefault(); // Prevent default form submission

        let isValid = true;

        // Get form values
        let firstname = $('#firstname').val().trim();
        let lastname = $('#lastname').val().trim();
        let email = $('#email').val().trim();
        let password = $('#password').val(); // Declare password only once
        let confirmPassword = $('#confirm-password').val();

        // Clear previous error messages
        $('.invalid-feedback').text('');
        $('.form-control').removeClass('is-invalid');

        // Validate first name (no numbers allowed)
        if (!/^[a-zA-Z\s]+$/.test(firstname)) {
            $('#firstname').addClass('is-invalid');
            $('#firstnameError').text('First name should not contain numbers or special characters.');
            isValid = false;
        }

        // Validate last name (no numbers allowed)
        if (!/^[a-zA-Z\s]+$/.test(lastname)) {
            $('#lastname').addClass('is-invalid');
            $('#lastnameError').text('Last name should not contain numbers or special characters.');
            isValid = false;
        }

        // Validate email (correct email format)
        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            $('#email').addClass('is-invalid');
            $('#emailError').text('Please enter a valid email address.');
            isValid = false;
        }

        // Validate password and confirm password
        if (password !== confirmPassword) {
            $('#confirm-password').addClass('is-invalid');
            $('#confirm-passwordError').text('Passwords do not match.');
            isValid = false;
        }

        // If the form is not valid, stop submission
        if (!isValid) {
            return;
        }

        // Serialize form data
        let formData = $(this).serialize();

        $.ajax({
            url: '/user/register', // Update with your Laravel route
            type: 'POST',
            data: formData,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function() {
                $('.invalid-feedback').text(''); // Clear previous error messages
                $('.form-control').removeClass('is-invalid');
            },
            success: function(response) {
                if (response.success) {
                    $('#loginMessage').removeClass('alert-danger').addClass('alert-success')
                        .text(response.message).show();
                    $('#loginForm')[0].reset(); // Reset form fields on success
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        $('#' + key).addClass('is-invalid');
                        $('#' + key + 'Error').text(value[0]);
                    });
                } else {
                    $('#loginMessage').removeClass('alert-success').addClass('alert-danger')
                        .text('An error occurred. Please try again.').show();
                }
            }
        });
    });

    $('#confirm-password').on('keyup', function() {
        let password = $('#password').val();
        let confirmPassword = $(this).val();

        if (password !== confirmPassword) {
            $(this).addClass('is-invalid');
            $('#confirm-passwordError').text('Passwords do not match.');
        } else {
            $(this).removeClass('is-invalid');
            $('#confirm-passwordError').text('');
        }
    });

    // Password Toggle
    $('.toggle-password').on('click', function() {
        let input = $('#password');
        let icon = $('#togglePasswordIcon');
        if (input.attr('type') === 'password') {
            input.attr('type', 'text');
            icon.removeClass('fa-eye-slash').addClass('fa-eye');
        } else {
            input.attr('type', 'password');
            icon.removeClass('fa-eye').addClass('fa-eye-slash');
        }
    });

    $('.toggle-confirm-password').on('click', function() {
        let input = $('#confirm-password');
        let icon = $('#toggleconfirm-passwordIcon');
        if (input.attr('type') === 'password') {
            input.attr('type', 'text');
            icon.removeClass('fa-eye-slash').addClass('fa-eye');
        } else {
            input.attr('type', 'password');
            icon.removeClass('fa-eye').addClass('fa-eye-slash');
        }
    });
});
</script>
@endsection