@extends('layouts.main')



@push('style-file')
<!-- ================== BEGIN page-css ================== -->

<!-- ================== END page-css ================== -->
<style>
.switch-container {
    position: relative;
    display: inline-block;
    width: 70px;
    height: 30px;
}

.switch-input {
    opacity: 0;
    width: 0;
    height: 0;
}

.switch-label {
    position: absolute;
    cursor: pointer;
    background-color: rgb(255, 27, 48);
    border-radius: 30px;
    width: 100%;
    height: 100%;
    transition: background-color 0.3s ease;
    box-sizing: border-box;
}

.switch-label:before {
    content: "";
    position: absolute;
    height: 26px;
    width: 26px;
    border-radius: 50%;
    background-color: white;
    top: 2px;
    left: 2px;
    transition: transform 0.3s ease;
}

.switch-input:checked+.switch-label {
    background-color: green;
}

.switch-input:checked+.switch-label:before {
    transform: translateX(40px);
}

.switch-text {
    position: absolute;
    width: 100%;
    text-align: center;
    color: white;
    
}

.switch-input:checked+.switch-label .switch-text {
    content: 'Active';
    font-size: 11px;
    right: 12px;
    top: 7px;
}

.switch-input:not(:checked)+.switch-label .switch-text {
    content: 'Unactive';
    font-size: 10px;
    left: 13px;
    top: 8px;
}

#dt-search-0 {
    width: 500px;
}

.btn-group .btn {
    border: none;
    /* Remove all borders */
    border-bottom: 2px solid #ccc;
    /* Light gray bottom border */
    border-radius: 0;
    /* No rounded edges */
    color: #aaa;
    /* Gray text for inactive state */
    background-color: transparent;
    /* Transparent background */
    padding: 10px 20px;
    /* Adjust padding */
    cursor: pointer;
    /* Allow clicking */
}

/* Active button - Only text and border color changes */
.btn-group .btn.active {
    border-bottom: 3px solid #244625 !important;
    /* Green bottom border */
    color: #244625 !important;
    /* Green text */
    font-weight: bold;
    /* Make it stand out */
    background-color: transparent !important;
    /* No full background */
}

/* Hover effect for non-active buttons */
.btn-group .btn:not(.active):hover,
.btn-group .btn:not(.active):focus {
    border-bottom: 2px solid #244625 !important;
    color: #244625 !important;
    background-color: #f5f5f5;
    /* Light gray hover background */
}

/* Ensure active button does not change on hover */
.btn-group .btn.active:hover,
.btn-group .btn.active:focus {
    color: #244625 !important;
    /* Keep text green */
    background-color: transparent !important;
    /* No background change */
}
</style>
@endpush

@push('script-file')
<link href="{{ asset('assets/plugins/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}"
    rel="stylesheet" />
<!-- ================== BEGIN page-js ================== -->
<script src="{{ asset('assets/plugins/datatables.net/js/dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js') }}"></script>
<script src="{{ asset('assets/js/demo/table-manage-default.demo.js') }}"></script>
<script src="{{ asset('assets/plugins/@highlightjs/cdn-assets/highlight.min.js') }}"></script>
<script src="{{ asset('assets/js/demo/render.highlight.js') }}"></script>

@endpush


@section('content')
<div class="row" style="margin-right: 18px !important; margin-left: 5px !important;">
    <!-- BEGIN breadcrumb -->
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
        <li class="breadcrumb-item active">Accounts</li>
    </ol>

    <!-- END breadcrumb -->
    <!-- BEGIN page-header -->
    <h1 class="page-header">Accounts <small></small></h1>
    <!-- END page-header -->

    <!-- BEGIN row -->

    <!-- BEGIN panel -->
    <div class="panel panel-inverse" style="padding-left: 0px !important; padding-right: 0px !important;">
        <!-- BEGIN panel-heading -->
        <div class="panel-heading" style="background: #fdfeff !important; padding-bottom: 0px !important;">
            <div class="row">
                <div class="col-md-12 ">
                    <div class="btn-group w-100">
                        <a class="btn btn-outline-inverse all active ">All</a>
                        <a class="btn btn-outline-inverse parish_priest ">Parish priest</a>
                        <a class="btn btn-outline-inverse priest ">Priest</a>
                        <a class="btn btn-outline-inverse secretary">Secretary</a>
                        <a class="btn btn-outline-inverse parishioners">Parishioners</a>
                        <a class="btn btn-outline-inverse non_parishioners">Non-parishioners</a>
                    </div>
                </div>
                <div class="col-md-12 mt-2">
                    <h4 class="panel-title pt-2" style="width: auto !important;">
                        <a href="#modal-dialog-add" data-bs-toggle="modal" class="btn btn-primary btn-sm"
                            style="display: inline !important;">
                            Add Account
                        </a>
                    </h4>
                </div>
            </div>


        </div>
        <!-- END panel-heading -->
        <!-- BEGIN panel-body -->
        <div class="panel-body" style="padding-bottom: 0px !important;">
            <!-- Search Input -->
            <div class="row">
                <div class="col-md-12">

                    <div class="input-group">
                        <input type="text" id="search-input" class="form-control" placeholder="Search by Name or Role"
                            oninput="getList(this.value)">
                        <div class="input-group-text" style="background: #fdfeff !important;"><i
                                class="fa fa-search"></i></div>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <table id="accounts-table" width="100%" class="table">
                <thead>
                    <tr>
                        <th width="1%"></th>
                        <th width="1%" data-orderable="false"></th>
                        <th class="text-nowrap">Name</th>
                        <th class="text-nowrap">Role</th>
                        <th width="1%" class="text-nowrap">Status</th>
                        <th class="text-nowrap" style="text-align: right; padding-right: 50px">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- User data rows will be dynamically inserted here -->
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="row mt-2 justify-content-between">
                <div class="col-md-auto me-auto">
                    <div class="dt-info" aria-live="polite" id="accounts-table_info" role="status">
                        Showing 0 to 0 of 0 entries
                    </div>
                </div>
                <div class="col-md-auto ms-auto">
                    <div class="dt-paging paging_full_numbers">
                        <ul class="pagination" id="pagination-container">
                            <!-- Pagination buttons will be dynamically inserted here -->
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- END panel-body -->
    </div>

    <!-- #modal-dialog-add -->
    <div class="modal fade" id="modal-dialog-add">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="border: 0px !important">
                    <h4 class="modal-title">Add Account</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body" style="margin-top: -10px !important;">
                    <form id="addAccountForm" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-4 d-flex justify-content-center">
                                <img id="previewImage" src="{{ asset('assets/img/user/user-12.jpg') }}" width="200"
                                    height="200" alt="Profile Image" style="border-radius: 100px;" />
                                <input type="file" name="profile_image" id="profile_image" class="form-control"
                                    accept="image/*" style="display: none;" />
                            </div>
                            <div class="col-8 pt-3">
                                <div class="row">
                                    <!-- <div class="col-3">
                                        <div class="form-floating mb-0 mb-md-0">
                                            <input type="text" class="form-control fs-15px" id="prefix" name="prefix"
                                                placeholder="name@example.com"
                                                style="border-bottom: 1px solid gray !important; border-top: 0px !important; border-right: 0px !important; border-left: 0px !important; border-radius: 0px !important; ">
                                            <label for="prefix" class="d-flex align-items-center fs-13px">Prefix</label>
                                        </div>
                                    </div> -->
                                    <div class="col-6">
                                        <div class="form-floating mb-0 mb-md-0">
                                            <input type="text" class="form-control fs-15px" id="firstname"
                                                name="firstname" placeholder="name@example.com"
                                                style="border-bottom: 1px solid gray !important; border-top: 0px !important; border-right: 0px !important; border-left: 0px !important; border-radius: 0px !important; ">
                                            <label for="firstname" class="d-flex align-items-center fs-13px">First
                                                Name</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-floating mb-0 mb-md-0">
                                            <input type="text" class="form-control fs-15px" id="lastname"
                                                name="lastname" placeholder="name@example.com"
                                                style="border-bottom: 1px solid gray !important; border-top: 0px !important; border-right: 0px !important; border-left: 0px !important; border-radius: 0px !important; ">
                                            <label for="lastname" class="d-flex align-items-center fs-13px">Last
                                                Name</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating mb-0 mb-md-0">
                                            <select class="form-control fs-15px" id="role" name="role"
                                                style="border-bottom: 1px solid gray !important; border-top: 0px !important; border-right: 0px !important; border-left: 0px !important; border-radius: 0px !important;">
                                                <!-- <option value="admin">Admin</option> -->
                                                <option value="parish_priest">Parish priest</option>
                                                <option value="secretary">Secretary</option>
                                                <option value="priest">Priest</option>
                                                <option value="parishioners">Parishioners</option>
                                                <option value="non_parishioners">Non-parishioners</option>
                                            </select>
                                            <label for="role" class="d-flex align-items-center fs-13px">User
                                                Role</label>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-floating mb-0 mb-md-0">
                                            <input type="text" class="form-control fs-15px" id="contact" name="contact"
                                                placeholder="name@example.com"
                                                name="contact" placeholder="Contact Number"
                                                maxlength="11" pattern="\d{11}" inputmode="numeric"
                                                required
                                                title="Contact number must be 11 digits"
                                                style="border-bottom: 1px solid gray !important; border-top: 0px !important; border-right: 0px !important; border-left: 0px !important; border-radius: 0px !important; ">
                                            <label for="contact" class="d-flex align-items-center fs-13px">Contact
                                                Number</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating mb-0 mb-md-0">
                                            <input type="email" class="form-control fs-15px" id="email" name="email"
                                                placeholder="name@example.com"
                                                style="border-bottom: 1px solid gray !important; border-top: 0px !important; border-right: 0px !important; border-left: 0px !important; border-radius: 0px !important; ">
                                            <label for="email-address" class="d-flex align-items-center fs-13px">Email
                                                address</label>
                                        </div>
                                    </div>
                                    <!-- <input type="hidden" name="password" value="password"> -->
                                </div>

                            </div>
                        </div>

                        <div class="modal-footer" style="border: 0px !important;">
                            <button type="submit" class="btn btn-success"
                                style="margin-top: 15px !important;">Add</button>

                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>




    <div class="modal fade" id="modal-dialog-edit">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="border: 0px !important">
                    <h4 class="modal-title">Edit Account</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body" style="margin-top: -10px !important;">
                    <form id="editAccountForm" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-4 d-flex justify-content-center">
                                <img id="editProfileImage" src="{{ asset('assets/img/user/user-12.jpg') }}" width="200"
                                    height="200" alt="Profile Image" style="border-radius: 100px;" />
                                <input type="file" name="profile_image" id="editProfileImageInput" class="form-control"
                                    accept="image/*" style="display: none;" />
                            </div>
                            <div class="col-8 pt-3">
                                <div class="row">
                                    <!-- <div class="col-3">
                                        <div class="form-floating mb-0 mb-md-0">
                                            <input type="text" class="form-control fs-15px" id="editPrefix"
                                                name="prefix" placeholder="Prefix"
                                                style="border-bottom: 1px solid gray !important; border-top: 0px !important; border-right: 0px !important; border-left: 0px !important; border-radius: 0px !important; ">
                                            <label for="editPrefix"
                                                class="d-flex align-items-center fs-13px">Prefix</label>
                                        </div>
                                    </div> -->
                                    <div class="col-6">
                                        <div class="form-floating mb-0 mb-md-0">
                                            <input type="text" class="form-control fs-15px" id="editFirstname"
                                                name="firstname" placeholder="First Name"
                                                style="border-bottom: 1px solid gray !important; border-top: 0px !important; border-right: 0px !important; border-left: 0px !important; border-radius: 0px !important; ">
                                            <label for="editFirstname" class="d-flex align-items-center fs-13px">First
                                                Name</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-floating mb-0 mb-md-0">
                                            <input type="text" class="form-control fs-15px" id="editLastname"
                                                name="lastname" placeholder="Last Name"
                                                style="border-bottom: 1px solid gray !important; border-top: 0px !important; border-right: 0px !important; border-left: 0px !important; border-radius: 0px !important; ">
                                            <label for="editLastname" class="d-flex align-items-center fs-13px">Last
                                                Name</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating mb-0 mb-md-0">
                                            <select class="form-control fs-15px" id="editRole" name="role"
                                                style="border-bottom: 1px solid gray !important; border-top: 0px !important; border-right: 0px !important; border-left: 0px !important; border-radius: 0px !important;">
                                                <!-- <option value="admin">Admin</option> -->
                                                <option value="parish_priest">Parish priest</option>
                                                <option value="secretary">Secretary</option>
                                                <option value="priest">Priest</option>
                                                <option value="parishioners">Parishioners</option>
                                                <option value="non_parishioners">Non-parishioners</option>
                                            </select>
                                            <label for="editRole" class="d-flex align-items-center fs-13px">User
                                                Role</label>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-floating mb-0 mb-md-0">
                                            <input type="text" class="form-control fs-15px" id="editContact"
                                                name="contact" placeholder="Contact Number"
                                                maxlength="11" pattern="\d{11}" inputmode="numeric"
                                                required
                                                title="Contact number must be 11 digits"
                                                style="border-bottom: 1px solid gray !important; border-top: 0px !important; border-right: 0px !important; border-left: 0px !important; border-radius: 0px !important; ">
                                            <label for="editContact" class="d-flex align-items-center fs-13px">Contact
                                                Number</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating mb-0 mb-md-0">
                                            <input type="email" class="form-control fs-15px" id="editEmail" name="email"
                                                placeholder="Email"
                                                style="border-bottom: 1px solid gray !important; border-top: 0px !important; border-right: 0px !important; border-left: 0px !important; border-radius: 0px !important; ">
                                            <label for="editEmail" class="d-flex align-items-center fs-13px">Email
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

</div>

@endsection

@push('scripts')

<script>
getList(null);

function updateSwitchText(id) {

    const $switchInput = $('#customSwitch' + id);
    const $switchText = $('.switch-text' + id);

    if ($switchInput.is(':checked')) {
        $switchText.text('Active');
    } else {
        $switchText.text('Unactive');
    }
}

$(".btn-group .btn").on("click", function() {
    $(".btn-group .btn").removeClass("active"); // Remove active class from all buttons
    $(this).addClass("active"); // Add active class to the clicked button

    // Get and log the class of the clicked button (excluding 'btn' and 'active')
    let selectedClass = $(this).attr("class").split(" ").filter(cls =>
        cls !== "btn" && cls !== "btn-outline-inverse" && cls !== "active"
    ).join(" ");
    console.log(selectedClass);
    if (selectedClass == 'all') {
        getList(null)
    }else{
        getList(selectedClass);
    }
    

});


$('#accounts').addClass('active');
$('#accounts-table').DataTable({
    responsive: true,
    paging: false,
    info: false,
    searching: false,
    ordering: false
});

$('#editProfileImage').on('click', function() {
    $('#editProfileImageInput').click();
});

$('#editProfileImageInput').on('change', function(e) {
    const reader = new FileReader();
    reader.onload = function(event) {
        $('#editProfileImage').attr('src', event.target.result);
    };
    reader.readAsDataURL(e.target.files[0]);
});

$(document).ready(function() { 
    $('#previewImage').on('click', function() {
        $('#profile_image').click();
    });

    $('#profile_image').on('change', function(e) {
        const reader = new FileReader();
        reader.onload = function(event) {
            $('#previewImage').attr('src', event.target.result);
        };
        reader.readAsDataURL(e.target.files[0]);
    });

    // Contact number validation
    $('#contact').on('input', function() {
        let value = $(this).val().replace(/\D/g, ''); // Remove non-numeric characters
        if (value.length > 11) {
            value = value.substring(0, 11); // Limit to 11 digits
        }
        $(this).val(value);
    });

    $("#email").on("input", function() {
        var email = $(this).val();
        var emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        
        if (emailPattern.test(email)) {
            $(this).css("border-bottom", "1px solid green");
        } else {
            $(this).css("border-bottom", "1px solid red");
        }
    });

    $('#addAccountForm').on('submit', function(e) {
        e.preventDefault();

        // Validate First Name
        let firstName = $('#firstname').val();
        if (!/^[a-zA-Z\s]+$/.test(firstName)) {
            alert('First name cannot contain numbers or special characters.');
            return;
        }

        // Validate Last Name
        let lastName = $('#lastname').val();
        if (!/^[a-zA-Z\s]+$/.test(lastName)) {
            alert('Last name cannot contain numbers or special characters.');
            return;
        }

        let contactNumber = $('#contact').val();
        if (contactNumber.length !== 11) {
            alert('Contact number must be exactly 11 digits.');
            return;
        }
        if (!/^\d+$/.test(contactNumber)) {
            alert('Contact number must contain only numbers.');
            return;
        }

        let email = $('#email').val();
        var emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        if (!emailPattern.test(email)) {
            alert('Invalid email format. Please enter a valid email.');
            return;
        }

        let formData = new FormData(this);

        $.ajax({
            url: "{{ route('user.store') }}",
            method: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                getList(null);
                message({
                    title: 'Success!',
                    message: response.message,
                    icon: 'success'
                });

                $('#modal-dialog-add').modal('hide');
                $('#addAccountForm')[0].reset();
            },
            error: function(xhr) {
                alert('Error: ' + xhr.responseJSON.message);
            }
        });
    });
});

function openEditModal(userId) {
    $.ajax({
        url: `/user/${userId}/edit`, // Replace with your URL
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            // Populate modal fields with user data
            $('#editPrefix').val(response.data.prefix);
            $('#editFirstname').val(response.data.firstname);
            $('#editLastname').val(response.data.lastname);
            $('#editRole').val(response.data.role);
            $('#editContact').val(response.data.contact);
            $('#editEmail').val(response.data.email);
            $('#editProfileImage').attr('src', response.data.profile_image ||
                '/assets/img/user/user-12.jpg');

            // Store the user ID in a hidden field for form submission
            $('#editAccountForm').data('userId', userId);

            // Show the modal
            $('#modal-dialog-edit').modal('show');
        },
        error: function(xhr, status, error) {
            console.error('Error fetching user data:', error);
        }
    });
}

$('#editAccountForm').on('submit', function(event) {
    event.preventDefault(); // Prevent default form submission

    const userId = $(this).data('userId');
    const formData = new FormData(this);

    // Validate First Name
        let firstName = $('#editFirstname').val();
            if (!/^[a-zA-Z\s]+$/.test(firstName)) {
                alert('First name cannot contain numbers or special characters.');
                return;
            }

            // Validate Last Name
            let lastName = $('#editLastname').val();
            if (!/^[a-zA-Z\s]+$/.test(lastName)) {
                alert('Last name cannot contain numbers or special characters.');
                return;
        }
        let contactNumber = $('#editContact').val();
        if (contactNumber.length !== 11) {
            alert('Contact number must be exactly 11 digits.');
            return;
        }
        if (!/^\d+$/.test(contactNumber)) {
            alert('Contact number must contain only numbers.');
            return;
        }

        let email = $('#editEmail').val();
        var emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        if (!emailPattern.test(email)) {
            alert('Invalid email format. Please enter a valid email.');
            return;
        }

    $.ajax({
        url: `/user/${userId}/update`, // Replace with your update URL
        method: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                message({
                    title: 'Success!',
                    message: 'Account updated successfully!',
                    icon: 'success'
                });

                getList(null);
                $('#modal-dialog-edit').modal('hide');
            } else {
                message({
                    title: 'Error!',
                    message: 'Failed to update account.',
                    icon: 'error'
                });
            }
        },
        error: function(xhr) {
            if (xhr.status === 422) {
                // Laravel validation error handling
                const errors = xhr.responseJSON.errors;
                let errorMessages = '';

                $.each(errors, function(key, value) {
                    errorMessages += value[0] + '<br>';
                    $(`#edit${key.charAt(0).toUpperCase() + key.slice(1)}`).addClass('is-invalid');
                });

                message({
                    title: 'Validation Error!',
                    message: errorMessages,
                    icon: 'error'
                });
            } else {
                console.error('Error updating user:', xhr.responseText);
            }
        }
    });
});

function getList(search, url = '/user-list') {
    $.ajax({
        url: url,
        method: 'GET',
        data: {
            search: search, // Include search parameter
        },
        dataType: 'json',
        success: function(response) {
            let tableContent = '';

            if (response.data.length === 0) {
                tableContent = `
                    <tr>
                        <td colspan="6" class="text-center">No data available</td>
                    </tr>
                `;
            } else {
                response.data.forEach((user, index) => {
                    // Determine profile image or fallback
                    const profileImage = user.profile_image ?
                        `<img src="${user.profile_image}" class="rounded h-30px my-n1 mx-n1" />` :
                        `<img src="/assets/img/user/user-profile-icon.jpg" class="rounded h-30px my-n1 mx-n1" />`;

                    // Determine the status checkbox and label
                    const isChecked = user.user_status === 'active';
                    const statusSwitch = `
                        <div class="switch-container">
                            <input type="checkbox" id="customSwitch${user.id}" onchange="updateSwitchText(${user.id})"
                                   class="switch-input" ${isChecked ? 'checked' : ''} />
                            <label for="customSwitch${user.id}" class="switch-label">
                                <span title="${isChecked ? 'Active' : 'Inactive'}" class="switch-text switch-text${user.id}">${isChecked ? 'Active' : 'Inactive'}</span>
                            </label>
                        </div>
                    `;

                    let role = user.role; // Get the role text and trim spaces
                    let displayRole = "";

                    if (role === "priest") {
                        displayRole = "Priest";
                    }else if (role === "parish_priest") {
                        displayRole = "Parish Priest";
                    }else if (role === "secretary") {
                        displayRole = "Secretary";
                    } else if (role === "parishioners") {
                        displayRole = "Parishioners";
                    } else if (role === "non_parishioners") {
                        displayRole = "Non-parishioners";
                    }


                    // Create the table row
                    tableContent += `
                        <tr>
                            <td width="1%" class="fw-bold">${index + 1}</td>
                            <td width="1%" class="with-img">${profileImage}</td>
                            <td>${user.prefix ? user.prefix+'.': ''} ${user.firstname} ${user.lastname}</td>
                            <td>${displayRole}</td>
                            <td>${statusSwitch}</td>
                            <td style="text-align: right; padding-right: 50px">
                                <a href="#" class="text-body text-opacity-50" onclick="openEditModal(${user.id})">
                                    <i class="fa fa-ellipsis-h fs-30px"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a href="#" class="dropdown-item" onclick="openEditModal(${user.id})">Edit</a>
                                    <a href="#" onclick="delete_user(${user.id})" class="dropdown-item">Delete</a>
                                </div>
                            </td>
                        </tr>
                    `;
                });
            }

            $('#accounts-table tbody').html(tableContent);

            const paginationInfo =
                `Showing ${response.meta.from} to ${response.meta.to} of ${response.meta.total} entries`;
            $('#accounts-table_info').text(paginationInfo);

            if (response.meta && response.meta.links) {
                let paginationLinks = '';
                response.meta.links.forEach(link => {
                    if (link.url) {
                        paginationLinks += `<li class="page-item ${link.active ? 'active' : ''}">
                                                <a href="#" class="page-link" data-url="${link.url}" onclick="handlePaginationClick(event)">${link.label}</a>
                                              </li>`;
                    }
                });

                $('#pagination-container').html(paginationLinks);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error fetching data:', error);
        }
    });
}

// Handle pagination button click
function handlePaginationClick(event) {
    event.preventDefault();
    const url = $(event.target).data('url');
    const search = $('#search-input').val();
    getList(search, url);
}

function updateSwitchText(id) {
    const switchElement = $(`#customSwitch${id}`);
    const isChecked = switchElement.is(':checked');
    const statusText = isChecked ? 'Active' : 'Deactivated';
    const statusText_save_data = isChecked ? 'active' : 'deactivated';
    $(`.switch-text${id}`).attr('title', statusText);
    $(`.switch-text${id}`).text(statusText);

    $.ajax({
        url: `/user/${id}/update_status`,
        method: 'POST',
        data: {
            user_status: statusText_save_data
        },
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {

            if (response.success) {
                message({
                    title: 'Success!',
                    message: 'Account ' + statusText + ' successfully!',
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

}

function delete_user(id) {
    $.ajax({
        url: `/user/${id}/delete`,
        method: 'POST',
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {

            if (response.success) {

                message({
                    title: 'Success!',
                    message: 'Account delete successfully!',
                    icon: 'success'
                });
                getList(null);
            } else {
                message({
                    title: 'Error!',
                    message: 'Failed to delete account.',
                    icon: 'error'
                });
            }
        },
        error: function(xhr, status, error) {
            console.error('Error updating user:', error);
        }
    });
}
</script>
@endpush