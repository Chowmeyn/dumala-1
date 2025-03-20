<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Dumala</title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- ================== BEGIN core-css ================== -->
    <link href="{{ asset('assets/css/vendor.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/facebook/app.min.css') }}" rel="stylesheet" />
    <!-- ================== END core-css ================== -->

    <!-- ================== BEGIN page-css ================== -->
    <link href="{{ asset('assets/plugins/jvectormap-next/jquery-jvectormap.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.css') }}"
        rel="stylesheet" />
    <link href="{{ asset('assets/plugins/gritter/css/jquery.gritter.css') }}" rel="stylesheet" />

    <link href="{{ asset('assets/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}" rel="stylesheet" />
    <style>
    .ck-editor__main {
        border: 1px solid #d2d3d3 !important;
    }

    .widget-list-item {
        display: flex;
        align-items: center;
        text-decoration: none;
        /* Removes underline */
        color: inherit;
        /* Inherits text color */
        cursor: pointer;
        /* Cursor changes to hand */
        transition: background-color 0.3s ease;
        padding: 10px;
        border-radius: 5px;
    }

    .widget-list-item:hover {
        background-color: #f0f0f0;
        /* Background highlight on hover */
    }

    .app-header[data-bs-theme=dark] {
    background: #244625 !important;
    }


    .theme-green {
        --bs-app-theme: #244625 !important;
    }
    </style>
    <link href="{{ asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet" />

    <link href="{{ asset('assets/plugins/select2/dist/css/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/ion-rangeslider/css/ion.rangeSlider.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/tag-it/css/jquery.tagit.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/spectrum-colorpicker2/dist/spectrum.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/select-picker/dist/picker.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/bootstrap3-wysihtml5-bower/dist/bootstrap3-wysihtml5.min.css') }}"
        rel="stylesheet" />
    <!-- ================== END page-css ================== -->
    @stack('style-file')

    <!-- ================== BEGIN core-js ================== -->
    <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
    <!-- ================== END core-js ================== -->

    <!-- ================== BEGIN page-js ================== -->
    <script src="{{ asset('assets/plugins/gritter/js/jquery.gritter.js') }}"></script>
    <script src="{{ asset('assets/plugins/flot/source/jquery.canvaswrapper.js') }}"></script>
    <script src="{{ asset('assets/plugins/flot/source/jquery.colorhelpers.js') }}"></script>
    <script src="{{ asset('assets/plugins/flot/source/jquery.flot.js') }}"></script>
    <script src="{{ asset('assets/plugins/flot/source/jquery.flot.saturated.js') }}"></script>
    <script src="{{ asset('assets/plugins/flot/source/jquery.flot.browser.js') }}"></script>
    <script src="{{ asset('assets/plugins/flot/source/jquery.flot.drawSeries.js') }}"></script>
    <script src="{{ asset('assets/plugins/flot/source/jquery.flot.uiConstants.js') }}"></script>
    <script src="{{ asset('assets/plugins/flot/source/jquery.flot.time.js') }}"></script>
    <script src="{{ asset('assets/plugins/flot/source/jquery.flot.resize.js') }}"></script>
    <script src="{{ asset('assets/plugins/flot/source/jquery.flot.pie.js') }}"></script>
    <script src="{{ asset('assets/plugins/flot/source/jquery.flot.crosshair.js') }}"></script>
    <script src="{{ asset('assets/plugins/flot/source/jquery.flot.categories.js') }}"></script>
    <script src="{{ asset('assets/plugins/flot/source/jquery.flot.navigate.js') }}"></script>
    <script src="{{ asset('assets/plugins/flot/source/jquery.flot.touchNavigate.js') }}"></script>
    <script src="{{ asset('assets/plugins/flot/source/jquery.flot.hover.js') }}"></script>
    <script src="{{ asset('assets/plugins/flot/source/jquery.flot.touch.js') }}"></script>
    <script src="{{ asset('assets/plugins/flot/source/jquery.flot.selection.js') }}"></script>
    <script src="{{ asset('assets/plugins/flot/source/jquery.flot.symbol.js') }}"></script>
    <script src="{{ asset('assets/plugins/flot/source/jquery.flot.legend.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery-sparkline/jquery.sparkline.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jvectormap-next/jquery-jvectormap.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jvectormap-content/world-mill.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>
    <script src="{{ asset('assets/js/demo/dashboard.js') }}"></script>

    <!-- ================== END page-js ================== -->


    <!-- ================== BEGIN page-js ================== -->
    <script src="{{ asset('assets/plugins/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/@fullcalendar/core/index.global.js') }}"></script>
    <script src="{{ asset('assets/plugins/@fullcalendar/daygrid/index.global.js') }}"></script>
    <script src="{{ asset('assets/plugins/@fullcalendar/timegrid/index.global.js') }}"></script>
    <script src="{{ asset('assets/plugins/@fullcalendar/interaction/index.global.js') }}"></script>
    <script src="{{ asset('assets/plugins/@fullcalendar/list/index.global.js') }}"></script>
    <script src="{{ asset('assets/plugins/@fullcalendar/bootstrap/index.global.js') }}"></script>


    <script src="{{ asset('assets/plugins/parsleyjs/dist/parsley.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/@highlightjs/cdn-assets/highlight.min.js') }}"></script>
    <script src="{{ asset('assets/js/demo/render.highlight.js') }}"></script>
    <script src="{{ asset('assets/plugins/sweetalert/dist/sweetalert.min.js') }}"></script>

    <script src="{{ asset('assets/plugins/@ckeditor/ckeditor5-build-classic/build/ckeditor.js') }}"></script>

    <script src="{{ asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.js') }}"></script>


    <script src="{{ asset('assets/plugins/select2/dist/js/select2.min.js') }}"></script>

    <script src="{{ asset('assets/plugins/ion-rangeslider/js/ion.rangeSlider.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery.maskedinput/src/jquery.maskedinput.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery-migrate/dist/jquery-migrate.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/tag-it/js/tag-it.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/clipboard/dist/clipboard.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/spectrum-colorpicker2/dist/spectrum.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/select-picker/dist/picker.min.js') }}"></script>

    <script src="{{ asset('assets/plugins/bootstrap3-wysihtml5-bower/dist/bootstrap3-wysihtml5.all.min.js') }}">
    </script>


    <script>
    function message(params) {
        if (params.icon == 'success') {
            $('#successToast').fadeIn(700).removeClass('hide').addClass('show');
            $('.successToast').html(params.message);
            setTimeout(() => {

                $('#successToast').fadeOut(700, function() {
                    $(this).removeClass('show').addClass('hide');
                });
            }, 2000);
        } else if (params.icon == 'warning') {
            $('#warningToast').fadeIn(700).removeClass('hide').addClass('show');
            $('.warningToast').html(params.message);
            setTimeout(() => {

                $('#warningToast').fadeOut(700, function() {
                    $(this).removeClass('show').addClass('hide');
                });
            }, 2000);
        } else {
            $('#errorToast').fadeIn(700).removeClass('hide').addClass('show');
            $('.errorToast').html(params.message);
            setTimeout(() => {
                $('#errorToast').fadeOut(700, function() {
                    $(this).removeClass('show').addClass('hide');
                });
            }, 2000);
        }
    }
    </script>
    @stack('script-file')
    <!-- ================== END page-js ================== -->
</head>

<body class="pace-done theme-green" style="background-color: #C4DDA9 !important;">

    <!-- BEGIN #loader -->
    <div id="loader" class="app-loader">
        <span class="spinner"></span>
    </div>
    <!-- END #loader -->

    <!-- BEGIN #app -->
    <div id="app" class="app app-header-fixed app-sidebar-fixed app-content-full-height">

        <!-- BEGIN #header -->

        @include('layouts.header')

        <!-- END #header -->

        <!-- BEGIN #sidebar -->

        @include('layouts.sidebar')

        <!-- END #sidebar -->

        <!-- BEGIN #content -->
        <div id="content" class="app-content d-flex flex-column p-0">

            @yield('content')


            <!-- @include('layouts.footer') -->
        </div>

        <!-- END #content -->

        <!-- BEGIN scroll-top-btn -->
        <a href="javascript:;" class="btn btn-icon btn-circle btn-theme btn-scroll-to-top"
            data-toggle="scroll-to-top"><i class="fa fa-angle-up"></i></a>
        <!-- END scroll-top-btn -->
    </div>
    <div class="toast-container">

        <!-- Success Toast -->
        <div id="successToast" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header" style="background-color: #e6f9ea;">
                <div class="rounded w-25px h-25px d-flex align-items-center justify-content-center text-white"
                    style="background-color: #28a745;">
                    <i class="fa fa-check-circle"></i>
                </div>
                <strong class="me-auto ms-2">Success</strong>

                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body successToast" style="background-color: #e6f9ea;">
                Your action was successful!
            </div>
        </div>

        <!-- Warning Toast -->
        <div id="warningToast" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header" style="background-color: #fff7e6;">
                <div class="rounded w-25px h-25px d-flex align-items-center justify-content-center text-white"
                    style="background-color: #ffc107;">
                    <i class="fa fa-exclamation-triangle"></i>
                </div>
                <strong class="me-auto ms-2">Warning</strong>

                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body warningToast" style="background-color: #fff7e6;">
                Please be cautious with this action!
            </div>
        </div>

        <!-- Error Toast -->
        <div id="errorToast" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header" style="background-color: #fcebea;">
                <div class="rounded w-25px h-25px d-flex align-items-center justify-content-center text-white"
                    style="background-color: #dc3545;">
                    <i class="fa fa-times-circle"></i>
                </div>
                <strong class="me-auto ms-2">Error</strong>

                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body errorToast" style="background-color: #fcebea;">
                Something went wrong. Please try again!
            </div>
        </div>

    </div>



    <!-- #modal-dialog -->
    <div class="modal fade" id="modal-dialog-changepass">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Change password</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body">

                  
                    <div class="mb-3">
                        <label class="form-label" for="old_password">Old password</label>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" id="old_password" name="old_password"
                                placeholder="Old Password">
                            <div class="input-group-text">
                                <i class="fa fa-eye" onclick="changeEye('old_password', this)"></i>
                            </div>
                            <div class="invalid-feedback old_password_feed_back"></div>
                        </div>

                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="new_password">New password</label>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" id="new_password" name="new_password"
                                placeholder="New Password">
                            <div class="input-group-text">
                                <i class="fa fa-eye" onclick="changeEye('new_password', this)"></i>
                            </div>
                            <div class="invalid-feedback new_password_feed_back"></div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="confirm_pass">Confirm password</label>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" id="confirm_pass" name="confirm_pass"
                                placeholder="Confirm Password">
                            <div class="input-group-text">
                                <i class="fa fa-eye" onclick="changeEye('confirm_pass', this)"></i>
                            </div>
                            <div class="invalid-feedback confirm_pass_feed_back"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="javascript:;" class="btn btn-white" data-bs-dismiss="modal">Close</a>
                    <a href="javascript:;" class="btn btn-success" id="change-password-btn">Save Changes</a>
                </div>
            </div>
        </div>
    </div>



    <div class="modal fade" id="modal-dialog-edit-profile">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="border: 0px !important">
                    <h4 class="modal-title">Edit Profile</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body" style="margin-top: -10px !important;">
                    <form id="editAccountFormProfilev1" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-4 d-flex justify-content-center">
                                <img id="editProfileImageProfile" src="{{ asset('assets/img/user/user-12.jpg') }}"
                                    width="200" height="200" alt="Profile Image" style="border-radius: 100px;" />
                                <input type="file" name="profile_image" id="editProfileImageProfileInput"
                                    class="form-control" accept="image/*" style="display: none;" />
                            </div>
                            <div class="col-8 pt-3">
                                <div class="row">
                                    <div class="col-3">
                                        <div class="form-floating mb-0 mb-md-0">
                                            <input type="text" class="form-control fs-15px" id="editPrefixProfile"
                                                name="prefix" placeholder="Prefix"
                                                style="border-bottom: 1px solid gray !important; border-top: 0px !important; border-right: 0px !important; border-left: 0px !important; border-radius: 0px !important; ">
                                            <label for="editPrefixProfile"
                                                class="d-flex align-items-center fs-13px">Prefix</label>
                                        </div>
                                    </div>
                                    <div class="col-9">
                                        <div class="form-floating mb-0 mb-md-0">
                                            <input type="text" class="form-control fs-15px" id="editFirstnameProfile"
                                                name="firstname" placeholder="First Name"
                                                style="border-bottom: 1px solid gray !important; border-top: 0px !important; border-right: 0px !important; border-left: 0px !important; border-radius: 0px !important; ">
                                            <label for="editFirstnameProfile"
                                                class="d-flex align-items-center fs-13px">First
                                                Name</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating mb-0 mb-md-0">
                                            <input type="text" class="form-control fs-15px" id="editLastnameProfile"
                                                name="lastname" placeholder="Last Name"
                                                style="border-bottom: 1px solid gray !important; border-top: 0px !important; border-right: 0px !important; border-left: 0px !important; border-radius: 0px !important; ">
                                            <label for="editLastnameProfile"
                                                class="d-flex align-items-center fs-13px">Last
                                                Name</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating mb-0 mb-md-0">
                                            <select class="form-control fs-15px" id="editRoleProfile" name="role"
                                                style="border-bottom: 1px solid gray !important; border-top: 0px !important; border-right: 0px !important; border-left: 0px !important; border-radius: 0px !important;">
                                                <option value="admin">Admin</option>
                                                <option value="parish_priest">Parish priest</option>
                                                <option value="secretary">Secretary</option>
                                                <option value="priest">Priest</option>
                                                <option value="parishioners">Parishioners</option>
                                                <option value="non_parishioners">Non-parishioners</option>
                                            </select>
                                            <label for="editRoleProfile" class="d-flex align-items-center fs-13px">User
                                                Role</label>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-floating mb-0 mb-md-0">
                                            <input type="tel" class="form-control fs-15px" id="editContactProfile"
                                                name="contact" placeholder="Contact Number"
                                                maxlength="11" pattern="\d{11}" inputmode="numeric"
                                                required
                                                title="Contact number must be 11 digits"
                                                style="border-bottom: 1px solid gray !important; border-top: 0px !important; border-right: 0px !important; border-left: 0px !important; border-radius: 0px !important;">
                                            <label for="editContactProfile" class="d-flex align-items-center fs-13px">Contact Number</label>
                                        </div>
                                    </div>
                                    <!-- <div class="col-12">
                                        <div class="form-floating mb-0 mb-md-0">
                                            <input type="text" class="form-control fs-15px" id="editContactProfile"
                                                name="contact" placeholder="Contact Number"
                                                style="border-bottom: 1px solid gray !important; border-top: 0px !important; border-right: 0px !important; border-left: 0px !important; border-radius: 0px !important; ">
                                            <label for="editContactProfile"
                                                class="d-flex align-items-center fs-13px">Contact
                                                Number</label>
                                        </div>
                                    </div> -->
                                    <div class="col-12">
                                        <div class="form-floating mb-0 mb-md-0">
                                            <input type="email" class="form-control fs-15px" id="editEmailProfile"
                                                name="email" placeholder="Email"
                                                style="border-bottom: 1px solid gray !important; border-top: 0px !important; border-right: 0px !important; border-left: 0px !important; border-radius: 0px !important; ">
                                            <label for="editEmailProfile"
                                                class="d-flex align-items-center fs-13px">Email
                                                Address</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer" style="border: 0px !important;">
                            <button type="submit" class="btn btn-primary" style="margin-top: 15px !important;">Save
                                Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="offcanvas offcanvas-end bg-gray-300" id="offcanvasEndExample">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title">Notifications List</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">

            <div class="widget-list rounded mb-4 bg-gray-300  list_notifyasa" data-id="widget">
                <!-- BEGIN widget-list-item -->
                @foreach(get_all_notifications() as $noti)
                <a href="{{ $noti['data']['url'] }}" class="widget-list-item media" data-id="{{ $noti['id'] }}">
                    <div class="widget-list-media">
                        <img src="{{$noti['data']['image_path']}}" width="50" alt="" class="rounded">
                    </div>
                    <div class="widget-list-content">
                        <h4 class="widget-list-title">{{$noti['data']['title']}} 
                        @if($noti['read_at'] == null) <span class="badge bg-danger rounded-pill">Unread</span> @endif
                         
                        </h4>
                        <p class="widget-list-desc">{{$noti['data']['description']}}</p>
                    </div>
                </a>
                @endforeach
                
            </div>
        </div>
    </div>

    <script>
    $('#change-password-btn').on('click', function() {
        // Get values from the input fields
        var oldPassword = $('#old_password').val();
        var newPassword = $('#new_password').val();
        var confirmPassword = $('#confirm_pass').val();

        // Validation
        if (oldPassword === "") {
            $('#new_password').removeClass('is-invalid');
            $('#confirm_pass').removeClass('is-invalid');
            $('#old_password').addClass('is-invalid');
            $('.old_password_feed_back').html('*Old password fields are required!');


            return;
        }
        if (newPassword === "") {
            $('#old_password').removeClass('is-invalid');
            $('#confirm_pass').removeClass('is-invalid');
            $('#new_password').addClass('is-invalid');
            $('.new_password_feed_back').html('*Old password fields are required!');

            return;
        }
        if (confirmPassword === "") {
            $('#new_password').removeClass('is-invalid');
            $('#old_password').removeClass('is-invalid');
            $('#confirm_pass').addClass('is-invalid');
            $('.confirm_pass_feed_back').html('*Old password fields are required!');

            return;
        }



        if (newPassword !== confirmPassword) {

            $('#new_password').addClass('is-invalid');
            $('.new_password_feed_back').html('*New password and Confirm password do not match!');

            $('#confirm_pass').val('');
            return;
        }

        $('#new_password').removeClass('is-invalid');
        $('#old_password').removeClass('is-invalid');
        $('#confirm_pass').removeClass('is-invalid');

        // Send data via AJAX
        $.ajax({
            url: '/change-password', // Replace with the URL of your password change endpoint
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'), // Include CSRF token for security
                old_password: oldPassword,
                new_password: newPassword,
                confirm_pass: confirmPassword
            },
            success: function(response) {

                if (response.success) {
                    $('#modal-dialog-changepass').modal('hide');
                    message({
                        title: 'Success!',
                        message: response.message,
                        icon: 'success'
                    });
                } else {
                    if (response.status == '1') {
                        $('#old_password').addClass('is-invalid');
                        $('.old_password_feed_back').html('*' + response.message);
                    } else {
                        $('#new_password').addClass('is-invalid');
                        $('.new_password_feed_back').html(
                            '*New password and Confirm password do not match!');
                    }
                }

                console.log('response ::', response);


            },
            error: function(xhr, status, error) {
                console.error("An error occurred: ", error);
                alert("Something went wrong. Please try again later.");
            }
        });
    });

    function changeEye(inputId, icon) {
        // Get the password input field
        const input = document.getElementById(inputId);

        // Toggle the input type between 'password' and 'text'
        if (input.type === "password") {
            input.type = "text";
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = "password";
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }

    $('#editProfileImageProfile').on('click', function() {
        $('#editProfileImageProfileInput').click();
    });

    $('#editProfileImageProfileInput').on('change', function(e) {
        const reader = new FileReader();
        reader.onload = function(event) {
            $('#editProfileImageProfile').attr('src', event.target.result);
        };
        reader.readAsDataURL(e.target.files[0]);
    });

    function openEditModalv(userId) {
        console.log(userId);

        $.ajax({
            url: `/user/${userId}/edit`, // Replace with your URL
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                // Populate modal fields with user data
                $('#editPrefixProfile').val(response.data.prefix);
                $('#editFirstnameProfile').val(response.data.firstname);
                $('#editLastnameProfile').val(response.data.lastname);
                $('#editRoleProfile').val(response.data.role);
                $('#editContactProfile').val(response.data.contact);
                $('#editEmailProfile').val(response.data.email);
                $('#editProfileImageProfile').attr('src', response.data.profile_image ||
                    '/assets/img/user/user-12.jpg');

                // Store the user ID in a hidden field for form submission
                $('#editAccountFormProfilev1').data('userId', userId);

                // Show the modal
                $('#modal-dialog-edit-profile').modal('show');
            },
            error: function(xhr, status, error) {
                console.error('Error fetching user data:', error);
            }
        });
    }

    $('#editAccountFormProfilev1').on('submit', function(event) {
        event.preventDefault(); // Prevent default form submission

        const userId = $(this).data('userId');
        const formData = new FormData(this);

        $.ajax({
            url: `/user/${userId}/update`, // Replace with your update URL
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('#modal-dialog-edit-profile').modal('hide');
                    message({
                        title: 'Success!',
                        message: 'Account updated successfully!',
                        icon: 'success'
                    });

                    getList(null);

                } else {
                    message({
                        title: 'Error!',
                        message: 'Failed to update account.',
                        icon: 'error'
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error('Error updating user:', error);
            }
        });
    });

    function formatRelativeTime(createdAt) {
        // Parse the createdAt string into a JavaScript Date object
        const createdDate = new Date(createdAt);
        const currentDate = new Date();

        // Calculate the difference in milliseconds
        const diffMs = currentDate - createdDate;

        // Convert milliseconds to time components
        const diffSeconds = Math.floor(diffMs / 1000); // Total seconds
        const diffMinutes = Math.floor(diffSeconds / 60); // Total minutes
        const diffHours = Math.floor(diffMinutes / 60); // Total hours
        const diffDays = Math.floor(diffHours / 24); // Total days

        // Generate the output based on the time difference
        if (diffDays > 0) {
            // More than a day
            const hours = diffHours % 24; // Hours within the day
            return `${diffDays} day${diffDays > 1 ? 's' : ''} ${hours} hour${hours !== 1 ? 's' : ''}`;
        } else if (diffHours > 0) {
            // More than an hour
            const minutes = diffMinutes % 60; // Minutes within the hour
            return `${diffHours} hour${diffHours > 1 ? 's' : ''} ${minutes} min${minutes !== 1 ? 's' : ''}`;
        } else if (diffMinutes > 0) {
            // More than a minute
            const seconds = diffSeconds % 60; // Seconds within the minute
            return `${diffMinutes} min${diffMinutes !== 1 ? 's' : ''} ${seconds} sec${seconds !== 1 ? 's' : ''}`;
        } else {
            // Less than a minute
            return `${diffSeconds} sec${diffSeconds !== 1 ? 's' : ''}`;
        }
    }

    function fetchNotifications() {
        $.ajax({
            url: '/notifications',
            method: 'GET',
            success: function(data) {
                let notifications = '';

                if (data.length === 0) {
                    notifications =
                        `<div class="dropdown-item text-center text-muted">No notifications</div>`;
                } else {
                    data.forEach(notification => {
                        notifications += `
                            <a href="${notification.data.url}" class="dropdown-item media" data-id="${notification.id}">
                                <div class="media-left">
                                    <img src="${notification.data.image_path? notification.data.image_path: '/assets/img/user/user-profile-icon.jpg'}" class="media-object" alt="" />
                                </div>
                                <div class="media-body">
                                    <h6 class="media-heading">${notification.data.title}</h6>
                                    <p>${notification.data.description}</p>
                                    <div class="text-muted fs-10px">${formatRelativeTime(notification.created_at)}</div>
                                </div> 
                            </a>
                        `;
                    });
                }

                // Update the notification list
                $('.list_notify').html(notifications);
            },
            error: function() {
                $('.list_notify').html(
                    '<div class="dropdown-item text-center text-danger">Error loading notifications</div>'
                );
            }
        });
    }

    setInterval(() => {
        fetchNotifications();
        getCount();
    }, 10000);
    fetchNotifications(); // Fetch on page load

    function getCount() {

        $.ajax({
            url: `/notifications-count`, // Replace with your URL
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response == 0) {
                    $('.noti').html('');
                    $('.noti_head').html('NOTIFICATIONS (0)');
                } else {
                    $('.noti').html('<span class="badge">' + response + '</span>');
                    $('.noti_head').html('NOTIFICATIONS (' + response + ')');
                }


            },
            error: function(xhr, status, error) {
                console.error('Error fetching user data:', error);
            }
        });
    }

    $(document).on('click', '.list_notify a', function(e) {
        e.preventDefault();
        const id = $(this).data('id');
        const url = $(this).attr('href');

        $.ajax({
            url: `/notifications/read/${id}`,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function() {
                window.location.href = url; // Redirect after marking as read
            }
        });
    });


    $(document).on('click', '.list_notifyasa a', function(e) {
        e.preventDefault();
        const id = $(this).data('id');
        const url = $(this).attr('href');

        $.ajax({
            url: `/notifications/read/${id}`,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function() {
                window.location.href = url; // Redirect after marking as read
            }
        });
    });

    $('#send-notification-btn').on('click', function() {
        const data = {
            title: $('#notification-title').val(),
            body: $('#notification-body').val(),
            user_id: $('#user-id').val(),
        };

        $.ajax({
            url: '/send-notification',
            method: 'POST',
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function(response) {
                alert(response.message);
            },
            error: function(xhr) {
                alert(xhr.responseJSON.message);
            },
        });
    });
    </script>
    <!-- END #app -->
    @stack('scripts')
</body>

</html>