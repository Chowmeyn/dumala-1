@extends('layouts.main')



@push('style-file')
<!-- ================== BEGIN page-css ================== -->

<!-- ================== END page-css ================== -->
<style>

.active-filter{
    border-bottom: 2px solid #2c3e50 !important;
    background-color: white !important;
    color: #2c3e50 !important;
    border-radius: 0px !important;
}


.active-filter{
    border-bottom: 2px solid #2c3e50 !important;
    background-color: white !important;
    color: #2c3e50 !important;
    border-radius: 0px !important;
}

.switch-container {
    position: relative;
    display: inline-block;
    width: 60px;
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
    transform: translateX(30px);
}

.switch-text {
    position: absolute;
    width: 100%;
    text-align: center;
    color: white;
    font-size: 12px;
    top: 7px;
}

.switch-input:checked+.switch-label .switch-text {
    content: 'Active';
}

.switch-input:not(:checked)+.switch-label .switch-text {
    content: 'Unactive';
}

#dt-search-0 {
    width: 500px;
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
    <div class="panel-heading d-flex justify-content-between align-items-center" style="background: #fdfeff !important; padding-bottom: 0px !important;">
        <h4 class="panel-title pt-2" style="width: auto !important;">
            <!-- User Role Filter -->
            <ul class="nav nav-pills mb-2 mt-2" style="margin-left: 8px !important">
                <li class="nav-item">
                    <a href="#" data-val="all" id="all-tab" class="nav-link" onclick="filterByRole('all')">
                        <span class="d-sm-block d-none"><strong>All</strong></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" data-val="parish_priest" id="parish_priest-tab" class="nav-link" onclick="filterByRole('parish_priest')">
                        <span class="d-sm-block d-none"><strong>Parish Priest</strong></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" data-val="secretary" id="secretary-tab" class="nav-link" onclick="filterByRole('secretary')">
                        <span class="d-sm-block d-none"><strong>Secretary</strong></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" data-val="priest" id="priest-tab" class="nav-link" onclick="filterByRole('priest')">
                        <span class="d-sm-block d-none"><strong>Priest</strong></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" data-val="parishioners" id="parishioners-tab" class="nav-link" onclick="filterByRole('parishioners')">
                        <span class="d-sm-block d-none"><strong>Parishioners</strong></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" data-val="non_parishioners" id="non_parishioners-tab" class="nav-link" onclick="filterByRole('non_parishioners')">
                        <span class="d-sm-block d-none"><strong>Non-parishioners</strong></span>
                    </a>
                </li>
            </ul>
        </h4>
        <a href="#modal-dialog-add" data-bs-toggle="modal" class="btn btn-success btn-sm" style="display: inline !important;">
            Add Account
        </a>
    </div>
    <!-- END panel-heading -->
    <!-- BEGIN panel-body -->
    <div class="panel-body" style="padding-bottom: 0px !important;">
        <!-- Search Input -->
        <div class="row">
            <div class="col-md-12">
                <div class="input-group">
                    <input type="text" id="search-input" class="form-control" placeholder="Search by Name or Role" oninput="getList(this.value)">
                    <div class="input-group-text" style="background: #fdfeff !important;"><i class="fa fa-search"></i></div>
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
        <!-- END panel -->
    </div>
    
    <!-- Add Account Modal -->
    
    <!-- Add Account Modal -->
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
                                    <div class="col-3">
                                        <div class="form-floating mb-0 mb-md-0">
                                            <input type="text" class="form-control fs-15px" id="prefix" name="prefix"
                                                placeholder="name@example.com"
                                                style="border-bottom: 1px solid gray !important; border-top: 0px !important; border-right: 0px !important; border-left: 0px !important; border-radius: 0px !important; ">
                                            <label for="prefix" class="d-flex align-items-center fs-13px">Prefix</label>
                                        </div>
                                    </div>
                                    <div class="col-9">
                                        <div class="form-floating mb-0 mb-md-0">
                                            <input type="text" class="form-control fs-15px" id="firstname"
                                                name="firstname" placeholder="name@example.com"
                                                style="border-bottom: 1px solid gray !important; border-top: 0px !important; border-right: 0px !important; border-left: 0px !important; border-radius: 0px !important; ">
                                            <label for="firstname" class="d-flex align-items-center fs-13px">First
                                                Name</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
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
                                                <option value="admin">Admin</option>
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

<!-- Edit Account Modal -->
<!-- Edit Account Modal -->
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
                                    <div class="col-3">
                                        <div class="form-floating mb-0 mb-md-0">
                                            <input type="text" class="form-control fs-15px" id="editPrefix"
                                                name="prefix" placeholder="Prefix"
                                                style="border-bottom: 1px solid gray !important; border-top: 0px !important; border-right: 0px !important; border-left: 0px !important; border-radius: 0px !important; ">
                                            <label for="editPrefix"
                                                class="d-flex align-items-center fs-13px">Prefix</label>
                                        </div>
                                    </div>
                                    <div class="col-9">
                                        <div class="form-floating mb-0 mb-md-0">
                                            <input type="text" class="form-control fs-15px" id="editFirstname"
                                                name="firstname" placeholder="First Name"
                                                style="border-bottom: 1px solid gray !important; border-top: 0px !important; border-right: 0px !important; border-left: 0px !important; border-radius: 0px !important; ">
                                            <label for="editFirstname" class="d-flex align-items-center fs-13px">First
                                                Name</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
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
                                                <option value="admin">Admin</option>
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

    $('#addAccountForm').on('submit', function(e) {
        e.preventDefault();

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

$(document).ready(function() {
    // Initialize the active tab
    $('#all-tab').addClass('active-filter');

    // Add click event listeners to the tabs
    $('.nav-link').on('click', function() {
        // Remove the active-filter class from all tabs
        $('.nav-link').removeClass('active-filter');
        // Add the active-filter class to the clicked tab
        $(this).addClass('active-filter');
        // Get the role from the data-val attribute
        const role = $(this).data('val');
        // Filter the list based on the selected role
        filterByRole(role);
    });

    // Initial load
    getList(null);
});

function filterByRole(role) {
    const search = $('#search-input').val();
    getList(search, '/user-list', role);
}

function getList(search, url = '/user-list', role = 'all') {
    $.ajax({
        url: url,
        method: 'GET',
        data: {
            search: search,
            role: role
            search: search,
            role: role
        },
        dataType: 'json',
        success: function(response) {
            renderTable(response);
        },
        error: function(xhr, status, error) {
            console.error('Error fetching data:', error);
        }
    });
}

function renderTable(response) {
    let tableContent = '';

    if (response.data.length === 0) {
        tableContent = `
            <tr>
                <td colspan="6" class="text-center">No data available</td>
            </tr>
        `;
    } else {
        response.data.forEach((user, index) => {
            const profileImage = user.profile_image ?
                `<img src="${user.profile_image}" class="rounded h-30px my-n1 mx-n1" />` :
                `<img src="/assets/img/user/user-profile-icon.jpg" class="rounded h-30px my-n1 mx-n1" />`;
    if (response.data.length === 0) {
        tableContent = `
            <tr>
                <td colspan="6" class="text-center">No data available</td>
            </tr>
        `;
    } else {
        response.data.forEach((user, index) => {
            const profileImage = user.profile_image ?
                `<img src="${user.profile_image}" class="rounded h-30px my-n1 mx-n1" />` :
                `<img src="/assets/img/user/user-profile-icon.jpg" class="rounded h-30px my-n1 mx-n1" />`;

            const isChecked = user.user_status === 'active';
            const statusSwitch = `
                <div class="switch-container">
                    <input type="checkbox" id="customSwitch${user.id}" onchange="updateSwitchText(${user.id})"
                           class="switch-input" ${isChecked ? 'checked' : ''} />
                    <label for="customSwitch${user.id}" class="switch-label">
                        <span title="${isChecked ? 'Active' : 'Deactivated'}" class="switch-text switch-text${user.id}">${isChecked ? 'Active' : 'Deactivated'}</span>
                    </label>
                </div>
            `;

            tableContent += `
                <tr>
                    <td width="1%" class="fw-bold">${index + 1}</td>
                    <td width="1%" class="with-img">${profileImage}</td>
                    <td>${user.prefix ? user.prefix+'.': ''} ${user.firstname} ${user.lastname}</td>
                    <td>${user.role}</td>
                    <td>${statusSwitch}</td>
                    <td style="text-align: right; padding-right: 50px">
                        <a href="#" data-bs-toggle="dropdown" class="text-body text-opacity-50">
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
    $('#accounts-table tbody').html(tableContent);

    if (response.meta) {
        const paginationInfo =
            `Showing ${response.meta.from} to ${response.meta.to} of ${response.meta.total} entries`;
        $('#accounts-table_info').text(paginationInfo);
    if (response.meta) {
        const paginationInfo =
            `Showing ${response.meta.from} to ${response.meta.to} of ${response.meta.total} entries`;
        $('#accounts-table_info').text(paginationInfo);

        if (response.meta.links) {
            let paginationLinks = '';
            response.meta.links.forEach(link => {
                if (link.url) {
                    const label = link.label.replace(/&laquo;|&raquo;/g, '').trim();
                    if (!isNaN(label)) {
        if (response.meta.links) {
            let paginationLinks = '';
            response.meta.links.forEach(link => {
                if (link.url) {
                    const label = link.label.replace(/&laquo;|&raquo;/g, '').trim();
                    if (!isNaN(label)) {
                        paginationLinks += `<li class="page-item ${link.active ? 'active' : ''}">
                                                <a href="#" class="page-link" data-url="${link.url}" onclick="handlePaginationClick(event)">${label}</a>
                                            </li>`;
                    }
                }
            });

            $('#pagination-container').html(paginationLinks);
        }
    }
}

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
                    message: 'Account deleted successfully!',
                    message: 'Account deleted successfully!',
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
            console.error('Error deleting user:', error);
            console.error('Error deleting user:', error);
        }
    });
}


</script>
@endpush