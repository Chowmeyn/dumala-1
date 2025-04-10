@extends('layouts.main')

@push('style-file')

@endpush



@section('content')

<style>
    .table {
    border: none !important;
}

.table th,
.table td {
    border: none !important;
}
</style>
<!-- END page-header -->

<!-- BEGIN row -->
<div class="row" style="margin-right: 18px !important; margin-left: 5px !important;">
    <!-- BEGIN breadcrumb -->
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
        <li class="breadcrumb-item active">Requests</li>
    </ol>
    <!-- END breadcrumb -->
    <!-- BEGIN page-header -->
    <h1 class="page-header">Requests <small></small></h1>

    <div class="panel panel-inverse">



        <!-- END panel-heading -->
        <!-- BEGIN panel-body -->
        <div class="panel-body">
            <!--  -->
            @if(Auth::user()->role === 'parishioners' || Auth::user()->role === 'non_parishioners' || Auth::user()->role
            === 'secretary')
            <a href="#modal-create-own-sched" data-bs-toggle="modal" class="btn btn-primary btn-sm me-1 mb-1">Create
                schedule</a>
            @endif
            <div class="input-group mt-2">
                <input type="text" id="search-input" class="form-control" placeholder="Search by Name or Role"
                    oninput="getList(this.value, 1)">
                <div class="input-group-text" style="background: #fdfeff !important;"><i class="fa fa-search"></i></div>
            </div>

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th>Purpose</th>
                        <th>Date</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Populated by JavaScript -->
                </tbody>
            </table>

            <div>
                <div class="pagination pagination-sm d-flex justify-content-end">
                    <!-- Populated by JavaScript -->
                </div>
            </div>
        </div>

    </div>

</div>

<div class="modal fade" id="modal-dialog-decline">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Decline Request</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <form id="decline-form">
                <div class="modal-body">
                    <input type="hidden" id="schedule_id" name="schedule_id"> <!-- Hidden input for schedule ID -->

                    <div class="mb-3">
                        <label class="form-label">Refer Another Priest:</label>
                        <select class="form-select" id="priest-select" name="priest_id">
                            <option value="" selected>Choose a priest</option>
                            @foreach(get_all_priest() as $priest)
                            <option value="{{ $priest->id }}">{{ $priest->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Add a reason:</label>
                        <textarea id="editor-text" name="reason" class="form-control"></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <a href="javascript:;" class="btn btn-white" data-bs-dismiss="modal">Close</a>
                    <button type="submit" class="btn btn-danger">Decline</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="modal-dialog-assign-to-priest">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Assign a priest</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body">
                <div class="widget-list rounded mb-4" data-id="widget">
                    <!-- BEGIN widget-list-item -->

                    @foreach(get_all_priest() as $priest)
                    <div class="widget-list-item">
                        <div class="widget-list-media">
                            <img src="{{ $priest->profile_image ?? '/assets/img/user/user-profile-icon.jpg'}}"
                                width="50" alt="" class="rounded">
                        </div>
                        <div class="widget-list-content">
                            <h4 class="widget-list-title">{{ $priest->prefix ? $priest->prefix.'.' : '' }}
                                {{ $priest->firstname }} {{ $priest->lastname }}</h4>
                        </div>
                        <div class="widget-list-action">
                            <a href="javascript:;" data-id="" onclick="onclickAssignPost({{ $priest->id }})"
                                class="btn btn-success btn-icon btn-circle btn-lg assign_post">
                                <i class="fa fa-add"> </i>
                            </a>
                        </div>
                    </div>
                    @endforeach

                    <!-- END widget-list-item -->
                </div>


            </div>
        </div>
    </div>
</div>
<!-- END row -->
<div class="modal fade" id="modal-create-own-sched">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create schedule</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-5">
                        <h6 class="mb-3 mt-3">Enter Date</h6>
                        <hr>
                        <div class="mb-3">
                            <label class="form-label" for="exampleInputEmail1">Date</label>
                            <div class="input-group date" id="datepicker-disabled-past" data-date-format="yyyy-m-d"
                                data-date-start-date="Date.default">
                                <input type="text" class="form-control form-control-sm" placeholder="Select Date" />
                                <span class="input-group-text input-group-addon"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                        <h6 class="mb-3">Enter Time</h6>
                        <hr>
                        <div class="mb-3">
                            <label class="form-label">From</label>
                            <div class="input-group bootstrap-timepicker">
                                <input id="timepicker-from" type="text" class="form-control form-control-sm" />
                                <span class="input-group-text input-group-addon"><i class="fa fa-clock"></i></span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">To</label>
                            <div class="input-group bootstrap-timepicker">
                                <input id="timepicker-to" type="text" class="form-control form-control-sm" />
                                <span class="input-group-text input-group-addon"><i class="fa fa-clock"></i></span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Request priest:</label>
                            <select class="form-select priest-select" id="priest-select">
                                <option value="" selected>Choose a priest</option>
                                @foreach(get_all_priest() as $priest)

                                <option value="{{ $priest->id }}">{{ $priest->firstname }}
                                {{ $priest->lastname }}</option>
                                @endforeach

                            </select>
                        </div>
                    </div>
                    <div class="col-7">
                        <div class="mb-3">
                            <label class="form-label">Venue:</label>
                            <input class="form-control form-control-sm venue" id="venue" type="text"
                                placeholder="venue..." />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Address:</label>
                            <input class="form-control form-control-sm address" id="address" type="text"
                                placeholder="address..." />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Purpose:</label>
                            @foreach(get_all_liturgical() as $priest)

                            @if($priest->id != 1)
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="flexRadioDefault"
                                    data-val="{{$priest->title}}" data-id="{{$priest->id}}">
                                <label class="form-check-label" for="{{$priest->title}}">
                                    {{$priest->title}}
                                </label>
                            </div>
                            @endif


                            @endforeach

                        </div>
                        <div class="mb-3">
                            <label class="form-label">If others, please specify:</label>
                            <input class="form-control form-control-sm others" type="text"
                                placeholder="if others, please specify..." disabled />
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <a href="javascript:;" class="btn btn-white btn-xs" data-bs-dismiss="modal">Close</a>
                <a href="javascript:;" class="btn btn-primary btn-xs" id="save-schedule">Submit</a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-edit-own-sched">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create schedule</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-5">
                        <h6 class="mb-3 mt-3">Enter Date</h6>
                        <hr>
                        <div class="mb-3">
                            <label class="form-label" for="exampleInputEmail1">Date</label>
                            <div class="input-group date" id="datepicker-disabled-past" data-date-format="yyyy-m-d"
                                data-date-start-date="Date.default">
                                <input type="text" class="form-control form-control-sm" placeholder="Select Date" />
                                <span class="input-group-text input-group-addon"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                        <h6 class="mb-3">Enter Time</h6>
                        <hr>
                        <div class="mb-3">
                            <label class="form-label">From</label>
                            <div class="input-group bootstrap-timepicker">
                                <input id="timepicker-from" type="text" class="form-control form-control-sm" />
                                <span class="input-group-text input-group-addon"><i class="fa fa-clock"></i></span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">To</label>
                            <div class="input-group bootstrap-timepicker">
                                <input id="timepicker-to" type="text" class="form-control form-control-sm" />
                                <span class="input-group-text input-group-addon"><i class="fa fa-clock"></i></span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Request priest:</label>
                            <select class="form-select priest-select" id="priest-select">
                                <option value="" selected>Choose a priest</option>
                                @foreach(get_all_priest() as $priest)

                                <option value="{{ $priest->id }}">{{ $priest->firstname }}
                                {{ $priest->lastname }}</option>
                                @endforeach

                            </select>
                        </div>
                    </div>
                    <div class="col-7">
                        <div class="mb-3">
                            <label class="form-label">Venue:</label>
                            <input class="form-control form-control-sm venue" id="venue" type="text"
                                placeholder="venue..." />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Address:</label>
                            <input class="form-control form-control-sm address" id="address" type="text"
                                placeholder="address..." />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Purpose:</label>
                            @foreach(get_all_liturgical() as $priest)

                            @if($priest->id != 1)
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="flexRadioDefault"
                                    data-val="{{$priest->title}}" data-id="{{$priest->id}}">
                                <label class="form-check-label" for="{{$priest->title}}">
                                    {{$priest->title}}
                                </label>
                            </div>
                            @endif


                            @endforeach

                        </div>
                        <div class="mb-3">
                            <label class="form-label">If others, please specify:</label>
                            <input class="form-control form-control-sm others" type="text"
                                placeholder="if others, please specify..." disabled />
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <a href="javascript:;" class="btn btn-white btn-xs" data-bs-dismiss="modal">Close</a>
                <a href="javascript:;" class="btn btn-primary btn-xs" id="save-schedule">Submit</a>
            </div>
        </div>
    </div>
</div>


@endsection

@push('scripts')

<script>
$(document).ready(function() {
    $("input[type='radio'][name='flexRadioDefault']").on("change", function() {
        let selectedValue = $(this).data("val"); // Get the selected radio value

        if (selectedValue.toLowerCase() === "others") {
            $(".others").prop("disabled", false).focus(); // Enable input field
        } else {
            $(".others").prop("disabled", true).val(""); // Disable and clear input field
        }
    });
});
$('#requests').addClass('active');
let currentPage = 1;
getList();
$(document).on('click', '#save-schedule', function() {
    let priestId = $('.priest-select').val();
    const data = {
        date: $('#datepicker-disabled-past input').val(),
        time_from: $('#timepicker-from').val(),
        time_to: $('#timepicker-to').val(),
        venue: $('.venue').val(),
        address: $('.address').val(),
        purpose: $('input[name="flexRadioDefault"]:checked').attr('data-val'),
        liturgical_id: $('input[name="flexRadioDefault"]:checked').attr('data-id'),
        others: $('.others').val(),
        sched_type: 'own_sched',
        assign_to: priestId,
        _token: $('meta[name="csrf-token"]').attr('content'),
        
    };

    $.ajax({
        url: '{{ route("schedules.store") }}',
        method: 'POST',
        data: data,
        success: function(response) {

            alert(response.message);
            location.reload(); // Reload the page or update the DOM dynamically
        },
        error: function(xhr) {
            console.log(xhr);
            alert(xhr.responseJSON.message);
        },
    });
});

/*
Template Name: Color Admin - Responsive Admin Dashboard Template build with Twitter Bootstrap 5
Version: 5.4.1
Author: Sean Ngu
Website: http://www.seantheme.com/color-admin/
*/

var handleCkeditor = function() {
    var elm = document.querySelector('#editor-text');
    ClassicEditor.create(elm, {
        toolbar: {
            items: [
                'bold',
                'italic',
                'undo',
                'redo'
                // The unwanted features (Link, BlockQuote, Insert Table, Image Upload) are omitted here
            ]
        }
    }).then(editor => {
        // Add the editor instance to a global variable to access it later
        window.editor = editor;
    }).catch(error => {
        console.error(error);
    });
};

var FormWysihtml = function() {
    "use strict";
    return {
        // Main function
        init: function() {
            handleCkeditor();
            // handleBootstrapWysihtml5();
        }
    };
}();

$(document).ready(function() {
    FormWysihtml.init();

    $(document).on('theme-reload', function() {
        $('.wysihtml5-sandbox, input[name="_wysihtml5_mode"], .wysihtml5-toolbar').remove();
        $('#wysihtml5').show();
        // handleBootstrapWysihtml5();/
    });
});
// Clear the CKEditor content
function clearEditorContent() {
    if (window.editor) {
        window.editor.setData(''); // Clears the editor content
    }
}

// Populate the CKEditor with data for editing
function populateEditorWithData(data) {
    if (window.editor) {
        window.editor.setData(data); // Sets the content to the editor
    }
}

function getList(search = '', page = 1) {
    currentPage = page; // Update current page
    
    $.ajax({
        url: '/list-request',
        method: 'GET',
        dataType: 'json',
        data: { search, page },
        success: function(response) {
            const { data, total, current_page, per_page } = response;
            const tbody = $('table.table tbody');
            tbody.empty();

            if (!data.length) {
                tbody.append(`
                    <tr>
                        <td colspan="4" class="text-center">No data available.</td>
                    </tr>
                `);
                return;
            }

            data.forEach((item, index) => {
                console.log(item);

                const rowId = `detailsRow${index + 1}`;
                const arrowId = `arrow${index + 1}`;
                const userRole = "<?= Auth::user()->role ?>";
                const userName = "<?= Auth::user()->firstname . ' ' . Auth::user()->lastname ?>";
                const isAdminOrPriest = userRole === "admin" || userRole === "parish_priest" || userRole === "priest";
                
                if (isAdminOrPriest) {
                    tbody.append(`
                        <!-- Main Row -->
                        <tr class="toggle-row" data-index="${index + 1}" data-bs-toggle="collapse" 
                            data-bs-target="#${rowId}" aria-expanded="false" aria-controls="${rowId}">
                            <td><img src="${item.profile_image}" class="rounded h-50px my-n1 mx-n1" alt="User" /></td>
                            <td style="padding-top: 20px;">${item.created_by_name}</td>
                            <td style="padding-top: 20px;">${item.purpose}</td>
                            <td style="padding-top: 20px;">${item.date}</td>
                            <td style="padding-top: 20px;">
                                <span id="${arrowId}" class="ms-2 toggle-arrow"><i class="fa fa-ellipsis-h fs-30px"></i></span>
                            </td>
                        </tr>
                        <!-- Collapsible Content -->
                        <tr id="${rowId}" class="collapse fade">
                            <td colspan="5">
                                <div class="p-1 bg-light">
                                    <div class="d-flex p-1">
                                        <div class="flex-1">
                                            <table class="table mb-2" style="border: none !important;">
                                                <tbody>
                                                    <tr>
                                                        <td><strong>Requested Priest:</strong></td>
                                                        <td>${item.assign_to_name || 'N/A'}</td>
                                                        <td><strong>Time:</strong></td>
                                                        <td>${item.time_from} - ${item.time_to}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Venue:</strong></td>
                                                        <td>${item.venue || 'N/A'}</td>
                                                        <td><strong>Status:</strong></td>
                                                        <td>${getStatusBadge(item.status, item.role_model)}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Address:</strong></td>
                                                        <td>${item.address || 'N/A'}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            ${getActionButtons(item, userRole, userName)}
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    `);
                }

                if (userRole === 'secretary' ) {
                    tbody.append(`
                        <!-- Main Row -->
                        <tr class="toggle-row" data-index="${index + 1}" data-bs-toggle="collapse" 
                            data-bs-target="#${rowId}" aria-expanded="false" aria-controls="${rowId}">
                            <td><img src="${item.profile_image}" class="rounded h-50px my-n1 mx-n1" alt="User" /></td>
                            <td style="padding-top: 20px;">${item.created_by_name}</td>
                            <td style="padding-top: 20px;">${item.purpose}</td>
                            <td style="padding-top: 20px;">${item.date}</td>
                            <td style="padding-top: 20px;">
                                <span id="${arrowId}" class="ms-2 toggle-arrow"><i class="fa fa-ellipsis-h fs-30px"></i></span>
                            </td>
                        </tr>
                        <!-- Collapsible Content -->
                        <tr id="${rowId}" class="collapse fade">
                            <td colspan="5">
                                <div class="p-1 bg-light">
                                    <div class="d-flex p-1">
                                        <div class="flex-1">
                                            <table class="table mb-2" style="border: none !important;">
                                                <tbody>
                                                    <tr>
                                                        <td><strong>Requested Priest:</strong></td>
                                                        <td>${item.assign_to_name || 'N/A'}</td>
                                                        <td><strong>Time:</strong></td>
                                                        <td>${item.time_from} - ${item.time_to}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Venue:</strong></td>
                                                        <td>${item.venue || 'N/A'}</td>
                                                        <td><strong>Status:</strong></td>
                                                        <td>${getStatusBadge(item.status, item.role_model)}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Address:</strong></td>
                                                        <td>${item.address || 'N/A'}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            ${getActionButtons(item, userRole)}
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    `);
                }


                if (userRole === 'parishioners' || userRole === 'non_parishioners') {
                    tbody.append(`
                        <!-- Main Row -->
                        <tr class="toggle-row" data-index="${index + 1}" data-bs-toggle="collapse" 
                            data-bs-target="#${rowId}" aria-expanded="false" aria-controls="${rowId}">
                            <td><img src="${item.profile_image}" class="rounded h-50px my-n1 mx-n1" alt="User" /></td>
                            <td style="padding-top: 20px;">${item.created_by_name}</td>
                            <td style="padding-top: 20px;">${item.purpose}</td>
                            <td style="padding-top: 20px;">${item.date}</td>
                            <td style="padding-top: 20px;">
                                <span id="${arrowId}" class="ms-2 toggle-arrow"><i class="fa fa-ellipsis-h fs-30px"></i></span>
                            </td>
                        </tr>
                        <!-- Collapsible Content -->
                        <tr id="${rowId}" class="collapse fade">
                            <td colspan="5">
                                <div class="p-1 bg-light">
                                    <div class="d-flex p-1">
                                        <div class="flex-1">
                                            <table class="table mb-2" style="border: none !important;">
                                                <tbody>
                                                    <tr>
                                                        <td><strong>Requested Priest:</strong></td>
                                                        <td>${item.assign_to_name || 'N/A'}</td>
                                                        <td><strong>Time:</strong></td>
                                                        <td>${item.time_from} - ${item.time_to}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Venue:</strong></td>
                                                        <td>${item.venue || 'N/A'}</td>
                                                        <td><strong>Status:</strong></td>
                                                        <td>${getStatusBadge(item.status, item.role_model)}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Address:</strong></td>
                                                        <td>${item.address || 'N/A'}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            ${getActionButtons(item, userRole)}
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    `);
                }
            });
            
            updatePagination(total, current_page, per_page);
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error:', error);
            const tbody = $('table.table tbody');
            tbody.empty().append(`
                <tr>
                    <td colspan="4" class="text-center">An error occurred while fetching data.</td>
                </tr>
            `);
        }
    });
}

function getStatusBadge(status,role) {
    const statuses = {
        1: '<span class="badge bg-yellow text-black">Pending</span>',
        2: '<span class="badge bg-primary">Accepted by Parish priest</span>',
        3: '<span class="badge bg-danger">Declined</span>',
        4: '<span class="badge bg-info text-black">Complete</span>',
        5: '<span class="badge bg-secondary">Archived</span>',
        default: '<span class="badge bg-success">Accepted by priest</span>'
    };
    return statuses[status] || statuses.default;
}

function getActionButtons(item, userRole, userName) {
    console.log('assign_to_name:', item.assign_to_name);
    
    if (item.status === 1) {
        if(item.assign_to_name === "N/A"){
        return `
            <p class="mb-0 d-flex justify-content-end">
                <a href="javascript:;" class="btn btn-sm btn-primary" onclick="onclickAssignToPriest(${item.schedule_id})">Assign a priest</a>
            </p>
        `;
        } else if (item.assign_to === <?= Auth::user()->id ?> && item.created_by === <?= Auth::user()->id ?>) {
            return `
            <p class="mb-0 d-flex justify-content-end">
            ${(userRole === 'parishioners' || userRole === 'non_parishioners') ? `` : `<a href="javascript:;" class="btn btn-sm btn-success me-5px" onclick="onclickAccept('<?= Auth::user()->id ?>', ${item.schedule_id},6)">Accept</a>` } 
            <a href="javascript:;" class="btn btn-sm btn-danger me-5px btn_decline" onclick="onclickDecline(${item.schedule_id})">Decline</a>
            ${item.declined_priest_id && (userRole === 'admin' || userRole === 'parish_priest') ? `
                <a href="javascript:;" class="btn btn-sm btn-primary" onclick="onclickAssignToPriest(${item.schedule_id})">Assign another priest</a>
            ` : ''}
        </p>
        `;
        }else if (item.assign_to === <?= Auth::user()->id ?>) {
            return `
            <p class="mb-0 d-flex justify-content-end">
            ${(userRole === 'parishioners' || userRole === 'non_parishioners') ? `` : `<a href="javascript:;" class="btn btn-sm btn-success me-5px" onclick="onclickAccept('<?= Auth::user()->id ?>', ${item.schedule_id},6)">Accept</a>` } 
            <a href="javascript:;" class="btn btn-sm btn-danger me-5px btn_decline" onclick="onclickDecline(${item.schedule_id})">Decline</a>
            ${item.declined_priest_id && (userRole === 'admin' || userRole === 'parish_priest') ? `
                <a href="javascript:;" class="btn btn-sm btn-primary" onclick="onclickAssignToPriest(${item.schedule_id})">Assign another priest</a>
            ` : ''}
        </p>
        `;
        } else if (item.created_by === <?= Auth::user()->id ?>) {
            return `
            <p class="mb-0 d-flex justify-content-end">
            ${(userRole === 'parishioners' || userRole === 'non_parishioners') ? `` : `<a href="javascript:;" class="btn btn-sm btn-success me-5px" onclick="onclickEdit('<?= Auth::user()->id ?>', ${item.schedule_id},1)">Edit</a>` } 
            <a href="javascript:;" class="btn btn-sm btn-danger me-5px btn_decline" onclick="onclickDelete(${item.schedule_id})">Cancel</a>
            ${item.declined_priest_id && (userRole === 'admin' || userRole === 'parish_priest') ? `
                <a href="javascript:;" class="btn btn-sm btn-primary" onclick="onclickAssignToPriest(${item.schedule_id})">Assign another priest</a>
            ` : ''}
        </p>
        `;
        }
        return `
            <p class="mb-0 d-flex justify-content-end">
            ${item.declined_priest_id && (userRole === 'admin' || userRole === 'parish_priest') ? `
                <a href="javascript:;" class="btn btn-sm btn-primary" onclick="onclickAssignToPriest(${item.schedule_id})">Assign another priest</a>
            ` : ''}
        </p>
        `;
    } else if(item.status === 2 || item.status === 4) { 
        return `
            <p class="mb-0 d-flex justify-content-end">
            
        </p>
        `;
    }
        return `
            <p class="mb-0 d-flex justify-content-end">
            ${(userRole === 'parishioners' || userRole === 'non_parishioners') ? `` : `<a href="javascript:;" class="btn btn-sm btn-success me-5px" onclick="onclickAccept('<?= Auth::user()->id ?>', ${item.schedule_id},2)">Approve</a>` } 
            <a href="javascript:;" class="btn btn-sm btn-danger me-5px btn_decline" onclick="onclickDecline(${item.schedule_id})">Decline</a>
            ${item.declined_priest_id && (userRole === 'admin' || userRole === 'parish_priest') ? `
                <a href="javascript:;" class="btn btn-sm btn-primary" onclick="onclickAssignToPriest(${item.schedule_id})">Assign another priest</a>
            ` : ''}
        </p>
        `;
    
}


function onclickEdit(userId, schedId, status = 1) {
    // Fetch the current request data
    $.ajax({
        url: `/list-request/${schedId}`, // Replace with the correct endpoint to fetch request details
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            const data = response.data;

            // Populate the modal fields with the request data
            $('#modal-edit-own-sched #datepicker-disabled-past input').val(data.date);
            $('#modal-edit-own-sched #timepicker-from').val(data.time_from);
            $('#modal-edit-own-sched #timepicker-to').val(data.time_to);
            $('#modal-edit-own-sched #venue').val(data.venue);
            $('#modal-edit-own-sched #address').val(data.address);
            $('#modal-edit-own-sched .priest-select').val(data.assign_to);
            $('input[name="flexRadioDefault"][data-id="' + data.liturgical_id + '"]').prop('checked', true);

            if (data.purpose.toLowerCase() === "others") {
                $('.others').prop('disabled', false).val(data.others);
            } else {
                $('.others').prop('disabled', true).val('');
            }

            // Open the modal
            $('#modal-edit-own-sched').modal('show');
        },
        error: function(xhr) {
            console.error('Error fetching request data:', xhr.responseText);
            alert('Failed to fetch request details.');
        }
    });
}

function onclickDelete(schedId) {
    if (!confirm('Are you sure you want to cancel this request?')) {
        return;
    }

    // Send a DELETE request to cancel the request
    $.ajax({
        url: `/request/${schedId}/delete`, // Replace with the correct endpoint for deleting requests
        method: 'POST',
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
                alert('Request canceled successfully.');
                getList(); // Refresh the list
            } else {
                alert('Failed to cancel the request.');
            }
        },
        error: function(xhr) {
            console.error('Error canceling request:', xhr.responseText);
            alert('An error occurred while canceling the request.');
        }
    });
}

function onclickDecline(id) {

    console.log(id);


    $('#modal-dialog-decline').modal('show');
    clearEditorContent();

    $('#priest-select').val('');

    $('#schedule_id').val(id);


}

function onclickAssignToPriest(id) {

    $('#modal-dialog-assign-to-priest').modal('show');
    $('.assign_post').attr('data-id', id);

}

function onclickAssignPost(id) {
    console.log(id);


    $.ajax({
        url: `/assign_priest`,
        method: 'POST',
        dataType: 'json',
        data: {
            user_id: id,
            sched_id: $('.assign_post').attr('data-id')
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {

            if (response.status == 1) {
                $('#modal-dialog-assign-to-priest').modal('hide');
                message({
                    title: 'Success!',
                    message: response.message,
                    icon: 'success'
                });
                getList();
            } else {
                message({
                    title: 'Error!',
                    message: response.message,
                    icon: 'error'
                });
            }

        },
        error: function(xhr, status, error) {
            console.error('Error updating user:', error);
        }
    });


}

function onclickAccept(id, sched_id,status=9) {


    $.ajax({
        url: `/assign_priest`,
        method: 'POST',
        dataType: 'json',
        data: {
            user_id: id,
            sched_id: sched_id,
            status: status,
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {

            if (response.status == 1) {
                $('#modal-dialog-assign-to-priest').modal('hide');
                message({
                    title: 'Success!',
                    message: response.message,
                    icon: 'success'
                });
                getList();
            } else {
                message({
                    title: 'Error!',
                    message: response.message,
                    icon: 'error'
                });
            }

        },
        error: function(xhr, status, error) {
            console.error('Error updating user:', error);
        }
    });


}



function updatePagination(total, currentPage, perPage) {
    const pagination = $('.pagination');
    const totalPages = Math.ceil(total / perPage);

    pagination.empty();
    if (totalPages === 0) return;

    pagination.append(`
        <div class="page-item ${currentPage === 1 ? 'disabled' : ''}">
            <a href="javascript:;" class="page-link" onclick="getList($('#search-input').val(), ${currentPage - 1})">«</a>
        </div>
    `);

    for (let i = 1; i <= totalPages; i++) {
        pagination.append(`
            <div class="page-item ${currentPage === i ? 'active' : ''}">
                <a href="javascript:;" class="page-link" onclick="getList($('#search-input').val(), ${i})">${i}</a>
            </div>
        `);
    }

    pagination.append(`
        <div class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
            <a href="javascript:;" class="page-link" onclick="getList($('#search-input').val(), ${currentPage + 1})">»</a>
        </div>
    `);

}


$("#datepicker-disabled-past").datepicker({
    todayHighlight: true
});

$("#datepicker-mass").datepicker({
    format: 'yyyy-mm-dd',
    autoclose: true
});

$("#timepicker-from").timepicker();
$("#timepicker-to").timepicker();
$("#timepicker-mass-from").timepicker();
$("#timepicker-mass-to").timepicker();

$(document).ready(function() {
    $("#decline-form").on("submit", function(e) {
        e.preventDefault(); // Prevent default form submission

        let scheduleId = $("#schedule_id").val();
        let priestId = $("#priest-select").val();
        let reason = $("#editor-text").val().trim();

        // Clear previous errors
        $(".error-message").remove();

        // Validation
        let hasError = false;

        if (!priestId) {
            $("#priest-select").after(
                '<small class="text-danger error-message">Please select a priest.</small>');
            hasError = true;
        }
        if (!reason) {
            $("#editor-text").after(
                '<small class="text-danger error-message">Reason is required.</small>');
            hasError = true;
        }

        if (hasError) {
            return; // Stop submission if validation fails
        }

        $.ajax({
            url: `/request/${scheduleId}/decline`,
            method: "POST",
            data: {
                priest_id: priestId,
                reason: reason,
                _token: $('meta[name="csrf-token"]').attr("content")
            },
            success: function(response) {
                if (response.success) {
                    alert("Request declined successfully.");
                    $("#modal-dialog-decline").modal("hide");
                    location.reload();
                } else {
                    alert(response.message);
                }
            },
            error: function(xhr) {
                alert("An error occurred while processing the request.");
            }
        });
    });

    // Set Schedule ID when opening modal
    $("#modal-dialog-decline").on("show.bs.modal", function(e) {
        let scheduleId = $(e.relatedTarget).data("schedule-id");
        $("#schedule_id").val(scheduleId);
    });
});
</script>
@endpush