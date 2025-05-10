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
        <li class="breadcrumb-item active">Priest Completed Services</li>
    </ol>
    <!-- END breadcrumb -->
    <!-- BEGIN page-header -->
    <h1 class="page-header">Priest Completed Services <small></small></h1>

    <div class="panel panel-inverse">

        <!-- END panel-heading -->
        <!-- BEGIN panel-body -->
        <div class="panel-body">
            <div class="row">

                <div class="col-md-2">
                    <select id="get-priest" class="form-select" onchange="getPriestId(this)">
                        @foreach(extract_all_priest() as $priest)
                        <option value="{{ $priest->id }}">{{ $priest->firstname }}
                            {{ $priest->lastname }}</option>
                        @endforeach

                    </select>
                </div>



                <div class="col-md-12 mt-3">
                    <div class="btn-group w-100">
                        <a href="/report-annual" class="btn btn-outline-success">Annually</a>
                        <a href="/report-month" class="btn btn-outline-success active">Monthly</a>
                        <a href="/report-week" class="btn btn-outline-success">Weekly</a>
                    </div>
                </div>

                <div class="col-md-3 mt-2">
                    <div class="row mb-3">
                        <label class="form-label col-form-label col-md-2">Month:</label>
                        <div class="col-md-6">
                            <select class="form-select" id="monthSelect"  onchange="getMonth(this)">
                                <option disabled selected>Select Month</option>
                            </select>
                        </div>
                    </div>

                </div>

                <div class="col-md-2 mt-2">
                    <div class="row mb-3">
                        <label class="form-label col-form-label col-md-2">Year:</label>
                        <div class="col-md-6">
                            <select class="form-select" id="yearSelect" onchange="getYear(this)">
                                <option disabled selected>Select Year</option>
                            </select>
                        </div>
                    </div>

                </div>
                <!-- Add Purpose Filter -->
                <div class="col-md-2 mt-2">
                    <div class="row mb-3">
                        <label class="form-label col-form-label col-md-3">Purpose:</label>
                        <div class="col-md-9">
                            <select id="get-liturgical" class="form-select" onchange="getLiturgicalId(this)">
                                <option value="all"> All</option>
                                @foreach(get_all_liturgical() as $liturgical)
                                <option value=" {{$liturgical->title}}"> {{$liturgical->title}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <!-- Add Download Excel Button -->
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
                                        <h6>Total Completed Services</h6>
                                        <h3 id="totalServices">0</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="serviceBreakdown">
                                <!-- Service breakdown will be populated dynamically -->
                            </div>
                        </div>
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
const startYear = 1990; // Simula ng taon
const endYear = new Date().getFullYear(); // Kasalukuyang taon
const select = document.getElementById("yearSelect");

// Populate Year Dropdown
for (let year = endYear; year >= startYear; year--) { // Loop in descending order
    let option = document.createElement("option");
    option.value = year;
    option.textContent = year;

    // Check if the current year matches the year in the loop, and mark it as selected
    if (year === endYear) {
        option.selected = true;
    }

    select.appendChild(option);
}

// Populate Month Dropdown
const months = [
    "January", "February", "March", "April", "May", "June",
    "July", "August", "September", "October", "November", "December"
];

const monthSelect = document.getElementById("monthSelect");
const currentMonth = new Date().getMonth(); // Get the current month (0-based index)

months.forEach((month, index) => {
    let option = document.createElement("option");
    option.value = month; // Month value (1-12)
    option.textContent = month;

    // Check if the current month matches, and mark it as selected
    if (index === currentMonth) {
        option.selected = true;
    }

    monthSelect.appendChild(option);
});

// Adding active class to specific elements
$('#reports').addClass('active');
$('#report_priest').addClass('active');


let currentPage = 1;
getList($('#get-priest').val(), $('#yearSelect').val(),$('#monthSelect').val());


function getPriestId(selectElement) {
    const selectedId = selectElement.value; // Get the selected priest's ID
    $('#get-liturgical').val('all');
    getList(selectedId, $('#yearSelect').val(),$('#monthSelect').val());
}


function getYear(selectElement) { 
    const selectedId = selectElement.value; // Get the selected priest's ID yearSelect
    $('#get-liturgical').val('all');
    getList($('#get-priest').val(), selectedId,$('#monthSelect').val());

}


function getMonth(selectElement) {
    const selectedId = selectElement.value; // Get the selected priest's ID
    $('#get-liturgical').val('all');
    getList($('#get-priest').val(),$('#yearSelect').val(), selectedId);

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

function getList(search = '', year = '', month = '', page = 1) {
    currentPage = page; // Update current page
    $.ajax({
        url: '/list-request-complete',
        method: 'GET',
        dataType: 'json',
        data: {
            search: search,
            year: year,
            month: month,
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
    <td colspan="3" class="text-center">An error occurred while fetching data.</td>
</tr>
`);
        }
    });
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

function getLiturgicalList(search = '', year='', page = 1) {
    currentPage = page; // Update current page
    $.ajax({
        url: '/list-request-liturgical',
        method: 'GET',
        dataType: 'json',
        data: {
            search: search === 'all' ? '' : search,
            year: year,
            page: page,
            priest_id: $('#get-priest').val() // Add the priest ID to maintain selection
        },
        success: function(response) {
            const {
                data,
                total,
                current_page,
                per_page
            } = response;
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
                    <td colspan="3" class="text-center">An error occurred while fetching data.</td>
                </tr>
            `);
        }
    });
}

// Also update the getLiturgicalId function to pass both values
function getLiturgicalId(selectElement) {
    const selectedLiturgical = selectElement.value;
    const selectedPriest = $('#get-priest').val();
    const selectedYear = $('#yearSelect').val();
    if (selectedLiturgical === 'all') {
        // If 'all' is selected, use the regular getList function
        getList(selectedPriest, selectedYear, 1);
    } else {
        // Otherwise use the liturgical-specific list
        getLiturgicalList(selectedLiturgical, selectedYear, 1);
    }
}

// Add this new function for Excel download
$('#downloadExcel').click(function() {
    const selectedPriest = $('#get-priest').val();
    const selectedYear = $('#yearSelect').val();
    const selectedMonth = $('#monthSelect').val();
    const selectedPurpose = $('#get-liturgical').val();
    
    $.ajax({
        url: '/generate-priest-report',
        method: 'POST',
        data: {
            priest_id: selectedPriest,
            year: selectedYear,
            month: selectedMonth,
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
    
    // Update service breakdown
    const breakdownContainer = $('#serviceBreakdown');
    breakdownContainer.empty();

    Object.entries(serviceStats).forEach(([service, stats]) => {
        breakdownContainer.append(`
            <div class="col-md-3 mb-3">
                <div class="border rounded p-3 text-center">
                    <h6>${service}</h6>
                    <div class="mt-2">
                        <h4>${stats.completed}</h4>
                        <small class="text-muted">Completed Services</small>
                    </div>
                </div>
            </div>
        `);
    });
}
</script>
@endpush