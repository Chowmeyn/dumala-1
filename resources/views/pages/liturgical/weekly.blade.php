@extends('layouts.main')

@push('style-file')

@endpush



@section('content')


<!-- END page-header -->

<!-- BEGIN row -->
<div class="row" style="margin-right: 18px !important; margin-left: 5px !important;">
    <!-- BEGIN breadcrumb -->
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
        <li class="breadcrumb-item active">Total Liturgical Services Requested </li>
    </ol>
    <!-- END breadcrumb -->
    <!-- BEGIN page-header -->
    <h1 class="page-header">Total Liturgical Services Requested  <small></small></h1>

    <div class="panel panel-inverse">

        <!-- END panel-heading -->
        <!-- BEGIN panel-body -->
        <div class="panel-body">
            <div class="row">
                <div class="col-md-2">
                    <select id="get-priest" class="form-select" onchange="getPriestId(this)">
                    @foreach(get_all_liturgical() as $priest)
                        <option value=" {{$priest->title}}"> {{$priest->title}}</option>
                        @endforeach

                    </select>
                </div>
                <div class="col-md-12 mt-3">
                    <div class="btn-group w-100">
                        <a href="/liturgical-annual" class="btn btn-outline-success">Annually</a>
                        <a href="/liturgical-month" class="btn btn-outline-success">Monthly</a>
                        <a href="/liturgical-week" class="btn btn-outline-success active">Weekly</a>
                    </div>
                </div>

                <div class="col-md-3 mt-2">
                    <div class="row mb-3">
                        <label class="form-label col-form-label col-md-3">Week:</label>
                        <div class="col-md-9">
                            <div class="input-group" id="default-daterange">
                                <input type="text" name="default-daterange" class="form-control" value=""
                                    placeholder="select the date range" onchange="handleDateChange(this)" />
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 mb-3">
                    <button id="downloadExcel" class="btn btn-success">
                        <i class="fas fa-file-excel"></i> Download Excel
                    </button>
                </div>
                <!-- Add Summary Section -->
                <div class="col-md-12 mb-3">
                    <div class="card">
                        <div class="card-header bg-success text-white">
                            <h5 class="card-title mb-0">Summary Report</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <div class="border rounded p-3 text-center">
                                        <h6>Total Completed</h6>
                                        <h3 id="totalServices">0</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="serviceBreakdown">
                                <!-- Service breakdown will be populated dynamically -->
                            </div>
                        </div>
            </div>
            <div class="row mt-3">



                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Requester Name</th>
                            <th>Request</th>
                            <th>Requested Date</th>
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

</div>
<!-- END row -->

@endsection

@push('scripts')

<script>
var handleRenderDateRangePicker = function() {

    $("#default-daterange").daterangepicker({
        opens: "right",
        format: "MM/DD/YYYY",
        separator: " to ",
        endDate: moment(),
        minDate: "01/01/2024",
        maxDate: "12/31/2025",
    }, function(start, end) {
        $("#default-daterange input").val(start.format("MMMM D, YYYY") + " - " + end.format(
            "MMMM D, YYYY"));
        handleDateChange($("#default-daterange input")[0]);
    });


};
var FormPlugins = function() {
    "use strict";
    return {
        //main function
        init: function() {
            handleRenderDateRangePicker();

        }
    };
}();
$(document).ready(function() {
    FormPlugins.init();
});

$('#reports').addClass('active');
$('#report_priest').addClass('active');


let currentPage = 1;
const defaultStart = moment();
const defaultEnd = moment().add(7, 'days');
const dt = defaultStart.format("MMMM D, YYYY") + " - " + defaultEnd.format("MMMM D, YYYY");
$("#default-daterange input").val(dt);

getList($('#get-priest').val(),dt);


function getPriestId(selectElement) {
    const selectedId = selectElement.value; // Get the selected priest's ID
    getList(selectedId, $("#default-daterange input").val());
    // You can do whatever you need with the ID here, like making an API call
}


function handleDateChange(inputElement) {
    const selectedRange = inputElement.value;
    getList($('#get-priest').val(), selectedRange);
    console.log("Selected Date Range:", selectedRange);

}


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

function getList(search = '', date_range = '', page = 1) {
    currentPage = page; // Update current page
    $.ajax({
        url: '/list-request-liturgical',
        method: 'GET',
        dataType: 'json',
        data: {
            search: search,
            date_range: date_range,
            page: page
        },
        success: function(response) {
            const {
                data,
                total,
                current_page,
                per_page
            } = response;
            
            updateSummaryStats(data, total);

            const tbody = $('table.table tbody');
            tbody.empty();

            if (data.length === 0) {
                tbody.append(`
                    <tr>
                        <td colspan="4" class="text-center">No data available.</td>
                    </tr>
                `);
                return;
            }

            // Populate table rows
            data.forEach((item, index) => {
                const rowId = `detailsRow${index + 1}`;
                tbody.append(`
                    <!-- Main Row -->
                    <tr data-bs-toggle="collapse" data-bs-target="#${rowId}" aria-expanded="false" aria-controls="${rowId}">
                        <td>
                            <img src="${item.profile_image}" class="rounded h-50px my-n1 mx-n1" alt="User" />
                        </td>
                        <td style="padding-top: 20px;">${item.created_by_name}</td>
                        <td style="padding-top: 20px;">${item.purpose}</td>
                        <td style="padding-top: 20px;">${item.date}</td>
                        
                    </tr>
                    <!-- Collapsible Content -->
                    <tr id="${rowId}" class="collapse fade">
                        <td colspan="4">
                            <div class="p-1 bg-light">
                                <div class="d-flex p-1">
                                    <div class="flex-1">
                                        <table class="table mb-2" style="border: none !important;">
                                            <tbody>
                                                <tr>
                                                    <td style="border: none !important;"><strong>Requested Priest:</strong></td>
                                                    <td style="border: none !important;">${item.assign_to_name || 'N/A'}</td>
                                                    <td style="border: none !important;"><strong>Time:</strong></td>
                                                    <td style="border: none !important;">${item.time_from} - ${item.time_to}</td>
                                                    
                                                </tr>
                                                <tr>
                                                    <td style="border: none !important;"><strong>Venue:</strong></td>
                                                    <td style="border: none !important;">${item.venue || 'N/A'}</td>
                                                    <td style="border: none !important;"><strong>Status:</strong></td>
                                                    <td style="border: none !important;">${item.status === 1 
                                                            ? '<span class="badge bg-yellow text-black">Pending</span>' 
                                                            : item.status === 2 
                                                                ? '<span class="badge bg-primary">Accepted</span>' 
                                                                : item.status === 3 
                                                                    ? '<span class="badge bg-danger">Declined</span>' 
                                                                    : item.status === 4 
                                                                        ? '<span class="badge bg-info text-black">Complete</span>' 
                                                                        : item.status === 5 
                                                                            ? '<span class="badge bg-secondary">Archived</span>' 
                                                                            : '<span class="badge bg-success">Accepted by priest</span>' }</td>
                                                    
                                                </tr>
                                                <tr>
                                                    <td style="border: none !important;"><strong>Address:</strong></td>
                                                    <td style="border: none !important;">${item.address || 'N/A'}</td>
                                                    
                                                </tr>
                                            </tbody>
                                        </table>
                                        
                                        
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                `);
            });

            // Update pagination
            updatePagination(total, current_page, per_page);
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error:', error);
            const tbody = $('table.table tbody');
            tbody.empty();
            tbody.append(`
                <tr>
                    <td colspan="4" class="text-center">An error occurred while fetching data.</td>
                </tr>
            `);
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

$('#downloadExcel').click(function() {
    const selectedDateRange = $('#default-daterange input').val();
    const selectedPurpose = $('#get-priest').val();
    
    $.ajax({
        url: '/generate-priest-report',
        method: 'POST',
        data: {
            date_range: selectedDateRange,
            purpose: selectedPurpose,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            // Create a temporary link and click it to download the file
            const link = document.createElement('a');
            link.href = response.file;
            // Extract the filename from the full URL
            const fullPath = response.file;
            const fileName = fullPath.split('/').pop();
            link.download = fileName;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        },
        error: function(xhr, status, error) {
            console.error('Error generating report:', error);
            alert('Error generating report. Please try again.');
        }
    });
});

function updateSummaryStats(data, total) {
    // Calculate service type statistics
    const serviceStats = {};
    
    data.forEach(item => {
        if (!serviceStats[item.purpose]) {
            serviceStats[item.purpose] = {
                total: 0,
                completed: 0
            };
        }
        serviceStats[item.purpose].total++;
        if (item.status === 4) {
            serviceStats[item.purpose].completed++;
        }
    });

    // Update total services
    $('#totalServices').text(total);
}
</script>
@endpush