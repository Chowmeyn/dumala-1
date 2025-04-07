@extends('layouts.main')

@push('style-file')
@endpush

@section('content')
<!-- END page-header -->
<style>
.tab-link {
    border-bottom: 2px solid #2c3e50 !important;
    background-color: white !important;
    color: #2c3e50 !important;
    border-radius: 0px !important;
}
</style>
<!-- BEGIN row -->
<div class="row" style="margin-right: 18px !important; margin-left: 5px !important;">
    <!-- BEGIN breadcrumb -->
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
        <li class="breadcrumb-item active">Announcement</li>
    </ol>
    <!-- END breadcrumb -->
    <!-- BEGIN page-header -->
    <h1 class="page-header">Announcement <small></small></h1>

    <div class="panel panel-inverse">
        <div class="panel-heading" style="background: #fdfeff !important;">
            <h4 class="panel-title" style="width: auto !important;">
                <a href="{{ route('public_announce') }}" class="btn btn-primary btn-sm"
                    style="display: inline !important;">Create announcement</a>
                <!-- <a href="{{ route('post_regular_sched') }}" class="btn btn-success btn-sm"
                    style="display: inline !important;">Post regular schedule</a> -->
            </h4>
        </div>
        <!-- END panel-heading -->
        <!-- BEGIN panel-body -->
        <div class="panel-body">
            <div class="panel-heading-btn">
                <div class="row">
                    <div class="col-5 mb-3">
                        <div class="navbar-item navbar-form d-flex justify-content-end">
                            <select class="form-select" id="announcement_type" name="announcement_type">
                                <option value="all" selected>All</option>
                                <option value="public">Public announcement</option>
                                <option value="marriage">Marriage banns</option>
                                <option value="project">Project and financial</option>
                                <option value="mass">Mass schedules</option>
                            </select>
                        </div>
                    </div>
                    <!-- Search Form -->

                </div>
            </div>
            <input type="hidden" id="announcement_status" />
            <ul class="nav nav-pills mb-2">
                <li class="nav-item">
                    <a href="#nav-pills-tab-1" data-bs-toggle="tab" id="posted-tab" class="nav-link active">
                        <span class="d-sm-block d-none"><strong>Posted</strong></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#nav-pills-tab-2" data-bs-toggle="tab" id="pending-tab" class="nav-link">
                        <span class="d-sm-block d-none"><strong>Pending</strong></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#nav-pills-tab-3" data-bs-toggle="tab" id="archives-tab" class="nav-link">
                        <span class="d-sm-block d-none"><strong>Archives</strong></span>
                    </a>
                </li>
            </ul>
            <table class="table table-hover">
                <thead>
                    
                </thead>
                <tbody>

                </tbody>
            </table>

            <!-- Pagination links -->
            <div class="pagination pagination-sm d-flex justify-content-end"></div>
        </div>
    </div>
</div>
<!-- END row -->
@endsection

@push('scripts')
<script>
$('#announcements').addClass('active');
$('#posted-tab').addClass('tab-link');
$('#announcement_status').val('is_posted');

$(document).ready(function() {
    $('#announcement_type').on('change', function() {
        fetchAnnouncements();
    });

    function fetchAnnouncements(page = 1) {

        $('thead').html(`
        <tr>
                        <th style="width: 50%;">Title</th>
                        <th style="width: 50%;">Date</th>
                        
                    </tr>
        `);

        if ($('#announcement_status').val() == "is_archive") {
            $('thead').html(`
        <tr>
                        <th style="width: 50%;">Title</th>
                        <th style="width: 50%;">Date</th>
                        <th style="width: 50%;">Date</th>
                        
                    </tr>
        `);
        }

        $('#loading').show(); // Show loading indicator
        const announcementType = $('#announcement_type').val(); // Get selected announcement type
        $.ajax({
            url: "{{ route('announcements.fetch') }}?page=" + page + "&type=" + announcementType +
                "&announcement_status=" + $('#announcement_status').val(), // Append selected type
            method: 'GET',
            success: function(response) {
                $('#loading').hide(); // Hide loading indicator
                let tbody = '';

                // Check if there are announcements
                if (response.data.length === 0) {
                    tbody = `
                    <tr>
                        <td colspan="2" class="text-center">No Data</td>
                    </tr>
                `;
                } else {

                    if ($('#announcement_status').val() == "is_archive") {
                        response.data.forEach(announcement => {
                        tbody += `
                        <tr data-bs-toggle="collapse" data-bs-target="#detailsRow${announcement.id}" aria-expanded="false" aria-controls="detailsRow${announcement.id}">
                            <td style="padding-top: 20px;">${announcement.title}</td>
                            <td style="padding-top: 20px;">${new Date(announcement.created_at).toLocaleDateString()}</td>
                            <td style="padding-top: 20px;">${new Date(announcement.updated_at).toLocaleDateString()}</td>
                        </tr>
                        <tr id="detailsRow${announcement.id}" class="collapse fade">
                            <td colspan="6">
                                <div class="p-1 bg-light">
                                    <div class="d-flex p-1">
                                        <div class="flex-1">
                                            <table class="table mb-2" style="border: none !important;">
                                                <tbody>
                                                    <tr>
                                                        <td style="border: none !important;">${announcement.content}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <p class="mb-0 d-flex justify-content-end">
                                                ${getStatus(announcement)}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    `;
                    });
                    }else{
                        response.data.forEach(announcement => {
                        tbody += `
                        <tr data-bs-toggle="collapse" data-bs-target="#detailsRow${announcement.id}" aria-expanded="false" aria-controls="detailsRow${announcement.id}">
                            <td style="padding-top: 20px;">${announcement.title}</td>
                            <td style="padding-top: 20px;">${new Date(announcement.created_at).toLocaleDateString()}</td>
                        </tr>
                        <tr id="detailsRow${announcement.id}" class="collapse fade">
                            <td colspan="5">
                                <div class="p-1 bg-light">
                                    <div class="d-flex p-1">
                                        <div class="flex-1">
                                            <table class="table mb-2" style="border: none !important;">
                                                <tbody>
                                                    <tr>
                                                        <td style="border: none !important;">${announcement.content}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <p class="mb-0 d-flex justify-content-end">
                                                ${getStatus(announcement)}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    `;
                    });
                    }
                    
                }

                $('tbody').html(tbody);

                // Update pagination links
                $('.pagination').html(`
                <div class="page-item ${response.prev_page_url ? '' : 'disabled'}">
                    <a href="javascript:;" class="page-link" data-page="${response.current_page - 1}">«</a>
                </div>
                ${[...Array(response.last_page)].map((_, i) => `
                    <div class="page-item ${response.current_page == i + 1 ? 'active' : ''}">
                        <a href="javascript:;" class="page-link" data-page="${i + 1}">${i + 1}</a>
                    </div>
                `).join('')}
                <div class="page-item ${response.next_page_url ? '' : 'disabled'}">
                    <a href="javascript:;" class="page-link" data-page="${response.current_page + 1}">»</a>
                </div>
            `);
            },
            error: function(xhr) {
                $('#loading').hide(); // Hide loading indicator
                console.error(xhr);
                // Optionally display an error message
                $('tbody').html(
                    '<tr><td colspan="2" class="text-center">Error fetching data.</td></tr>');
            }
        });
    }

    function getStatus(data) {
        var html = ``;
        
        

        if (data.status == 'is_pending') {
            html =
                `@if(Auth::user()->role == 'secretary') <a href="javascript:;" class="btn btn-sm btn-danger me-5px is_archive_class" data-id="${data.id}" aria-label="Decline">Decline</a>
                                                <a href="${data.announcement_type == 'marriage' ? `/marriage/${data.parent}/edit`: data.announcement_type == 'project' ? `/project_financial/${data.id}/edit` : data.announcement_type == 'public' ? `/public_announce/${data.id}/edit`: "javascript:;" }" class="btn btn-sm btn-success" aria-label="Edit">Edit</a>  @else <a href="javascript:;" class="btn btn-sm btn-success me-5px is_posted_class" data-id="${data.id}" aria-label="Post">Post</a>
                                                <a href="javascript:;" class="btn btn-sm btn-danger me-5px is_archive_class" data-id="${data.id}" aria-label="Decline">Decline</a>
                                                <a href="${data.announcement_type == 'marriage' ? `/marriage/${data.parent}/edit`: data.announcement_type == 'project' ? `/project_financial/${data.id}/edit` : data.announcement_type == 'public' ? `/public_announce/${data.id}/edit`: "javascript:;" }" class="btn btn-sm btn-success" aria-label="Edit">Edit</a> @endif `;

        } else if (data.status == 'is_posted') {

            html =
                `
                <a href="${data.announcement_type == 'marriage' ? `/marriage/${data.parent}/edit`: data.announcement_type == 'project' ? `/project_financial/${data.id}/edit` : data.announcement_type == 'public' ? `/public_announce/${data.id}/edit`: "javascript:;" }" class="btn btn-sm btn-success" aria-label="Edit" >Edit</a>
                
                <a href="javascript:;" class="btn btn-sm btn-danger is_archive_class" data-id="${data.id}" style="margin-left: 10px !important" aria-label="Archive">Archive</a> `;
        } else {
            html = ``;
        }

        return html;
    }

    // Fetch announcements on page load
    fetchAnnouncements();

    // Handle pagination click
    $(document).on('click', '.page-link', function() {
        const page = $(this).data('page');
        fetchAnnouncements(page);
    });

    // Search functionality (if needed)
    $('#search-input').on('keyup', function() {
        const keyword = $(this).val().toLowerCase();
        $('tbody tr').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(keyword) > -1);
        });
    });


    $('#posted-tab').on('click', function() {
        $('#announcement_status').val('is_posted');
        $(this).addClass('tab-link');
        $('#pending-tab').removeClass('tab-link');
        $('#archives-tab').removeClass('tab-link');
        fetchAnnouncements();

    });
    $('#pending-tab').on('click', function() {
        $('#announcement_status').val('is_pending');
        $(this).addClass('tab-link');
        $('#posted-tab').removeClass('tab-link');
        $('#archives-tab').removeClass('tab-link');
        fetchAnnouncements();
    });
    $('#archives-tab').on('click', function() {
        $('#announcement_status').val('is_archive');
        $(this).addClass('tab-link');
        $('#posted-tab').removeClass('tab-link');
        $('#pending-tab').removeClass('tab-link');
        fetchAnnouncements();

    });

    $(document).on('click', '.is_posted_class', function() {
        var id = $(this).attr('data-id');
        console.log(id);

        $.ajax({
            url: "{{ route('announcements.store') }}", // Ensure the correct route here
            type: "POST",
            data: {
                _token: '{{ csrf_token() }}',
                id: id,
                tab_data: 'is_posted'
            },
            dataType: 'json',
            success: function(response) {
                location.href = "{{ route('anouncements') }}";
            },
            error: function(xhr) {
                console.log(xhr.responseText); // Debugging the error response
                alert('Error saving the announcement');
            }
        });
    });


    $(document).on('click', '.is_archive_class', function() {
        var id = $(this).attr('data-id');
        console.log(id);

        $.ajax({
            url: "{{ route('announcements.store') }}", // Ensure the correct route here
            type: "POST",
            data: {
                _token: '{{ csrf_token() }}',
                id: id,
                tab_data: 'is_archive'
            },
            dataType: 'json',
            success: function(response) {
                location.href = "{{ route('anouncements') }}";
            },
            error: function(xhr) {
                console.log(xhr.responseText); // Debugging the error response
                alert('Error saving the announcement');
            }
        });
    });



});
</script>
@endpush