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
                        @foreach(get_all_priest() as $priest)
                        <option value="{{ $priest->id }}">{{ $priest->prefix  }}. {{ $priest->firstname }} {{ $priest->lastname }}</option>
                        @endforeach

                    </select>
                </div>
                <div class="col-md-12 mt-3">
                    <div class="btn-group w-100">
                        <a href="/report-annual" class="btn btn-outline-success active">Annually</a>
                        <a href="/report-month" class="btn btn-outline-success">Monthly</a>
                        <a href="/report-week" class="btn btn-outline-success">Weekly</a>
                    </div>
                </div>

                <div class="col-md-2 mt-2">
                    <div class="row mb-3">
                        <label class="form-label col-form-label col-md-3">Year:</label>
                        <div class="col-md-9">
                            <select class="form-select" id="yearSelect" onchange="getYear(this)">
                                <option disabled selected>Select Year</option>
                            </select>
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
$('#reports').addClass('active');
$('#report_priest').addClass('active');


let currentPage = 1;
getList($('#get-priest').val(),$('#yearSelect').val());


function getPriestId(selectElement) {
    const selectedId = selectElement.value; // Get the selected priest's ID
    getList(selectedId);
    // You can do whatever you need with the ID here, like making an API call
}


function getYear(selectElement) {
    const selectedId = selectElement.value; // Get the selected priest's ID
    getList($('#get-priest').val(),selectedId);
    // You can do whatever you need with the ID here, like making an API call
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

function getList(search = '', year='', page = 1) {
    currentPage = page; // Update current page
    $.ajax({
        url: '/list-request-complete',
        method: 'GET',
        dataType: 'json',
        data: {
            search: search,
            year: year,
            page: page
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




function onclickDecline(id) {

    $('#modal-dialog-decline').modal('show');
    clearEditorContent();

    $('#priest-select').val('');


}

function onclickAssignToPriest(id) {

    $('#modal-dialog-assign-to-priest').modal('show');
    $('.assign_post').attr('data-id',id);
    

}

function onclickAssignPost(id) {
    console.log(id);
    

    $.ajax({
        url: `/assign_priest`,
        method: 'POST',
        dataType: 'json',
        data: {
            user_id: id,
            sched_id:  $('.assign_post').attr('data-id')
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
            }else{
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
</script>
@endpush