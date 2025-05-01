@extends('layouts.main')

@section('content')
<style>
.tab-link {
    border-bottom: 2px solid #2c3e50 !important;
    background-color: white !important;
    color: #2c3e50 !important;
    border-radius: 0px !important;
}

.scroll-container {
    height: 70vh !important;
    /* Set height to 80% of the viewport */
    overflow-y: auto !important;
    /* Enable vertical scrolling */
    overflow-x: hidden !important;
    /* Prevent horizontal scrolling */
    border: 1px solid #ccc !important;
    /* Optional: Add border */
    padding-right: 10px !important;
    /* Prevent content from cutting off */
}

.no-data-container {
    display: flex;
    justify-content: center;
    /* Center horizontally */
    align-items: center;
    /* Center vertically */
    height: 100px;
    /* Adjust height to suit your needs */
    text-align: center;
    /* Ensure text is centered inside the container */
}

.modal-content {
    background-color: #f1f4e4;
    color: #3d4b3e;
    border-radius: 10px;
    font-family: 'Arial', sans-serif;
}

.modal-title {
    font-weight: bold;
}

.modal-body p {
    margin-bottom: 8px;
}

.btn-success {
    background-color: #2d5a27;
    border-color: #2d5a27;
}

.btn-danger {
    background-color: #c0392b;
    border-color: #c0392b;
}

.btn-success:hover {
    background-color: #274d22;
}

.btn-danger:hover {
    background-color: #a93226;
}
</style>
<script src="{{ asset('assets/js/demo/calendar.demo.js') }}"></script>
<div class="row" style="margin-right: 18px !important; margin-left: 5px !important;">
    <!-- BEGIN breadcrumb -->
    <ol class="breadcrumb" style="margin-left: 6px !important;">
        <li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>
    <!-- END breadcrumb -->
    <!-- BEGIN page-header -->
    <h1 class="page-header" style="margin-left: 5px !important;">Dashboard <small></small></h1>
    <!-- END page-header -->


    <!-- BEGIN row -->

    <!-- BEGIN col-8 -->
    <div class="col-xl-12">

        <!-- END panel -->
        <!-- BEGIN tabs -->
        <ul class="nav nav-tabs nav-tabs-inverse nav-justified" data-sortable-id="index-2">
            <li class="nav-item"><a href="#latest-post" data-bs-toggle="tab" id="latest-post-tab" class="nav-link">
                    <span class="d-none d-md-inline">Announcements
                    </span></a></li>
            <li class="nav-item"><a href="#purchase" data-bs-toggle="tab" id="purchase-tab" class="nav-link active">
                    <span class="d-none d-md-inline">Mass Schedules</span></a>
            </li>
        </ul>
        <div class="tab-content panel rounded-0 rounded-bottom mb-20px" data-sortable-id="index-3">
            <div class="tab-pane fade" id="latest-post">
                <ul class="nav nav-pills mb-2 mt-2" style="margin-left: 8px !important">
                    <li class="nav-item">
                        <a href="#nav-pills-tab-1" data-bs-toggle="tab" data-val="all" id="all-tab"
                            class="nav-link active">
                            <span class="d-sm-block d-none"><strong>All</strong></span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#nav-pills-tab-2" data-bs-toggle="tab" data-val="public" id="public-tab"
                            class="nav-link">
                            <span class="d-sm-block d-none"><strong>Public Announcements</strong></span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#nav-pills-tab-3" data-bs-toggle="tab" data-val="marriage" id="marriage-tab"
                            class="nav-link">
                            <span class="d-sm-block d-none"><strong>Marriage Banns</strong></span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#nav-pills-tab-4" data-bs-toggle="tab" data-val="project" id="project-tab"
                            class="nav-link">
                            <span class="d-sm-block d-none"><strong>Project and Financials</strong></span>
                        </a>
                    </li>
                </ul>

                <!-- Tab Content -->
                <div class="tab-content">
                    <!-- All Tab -->
                    <div class="tab-pane fade show active" id="nav-pills-tab-1">
                        <div class="card" style="border: none !important;">
                            <div class="card-body all_announcements scroll-container">


                            </div>
                        </div>
                    </div>

                    <!-- Public Announcements Tab -->
                    <div class="tab-pane fade" id="nav-pills-tab-2">
                        <div class="card" style="border: none !important;">
                            <div class="card-body public_announcements scroll-container">


                            </div>
                        </div>
                    </div>

                    <!-- Marriage Bans Tab -->
                    <div class="tab-pane fade" id="nav-pills-tab-3">
                        <div class="card" style="border: none !important;">
                            <div class="card-body marrige_announcements scroll-container">


                            </div>
                        </div>
                    </div>

                    <!-- Project and Financials Tab -->
                    <div class="tab-pane fade" id="nav-pills-tab-4">
                        <div class="card" style="border: none !important;">
                            <div class="card-body project_announcements scroll-container">


                            </div>
                        </div>
                    </div>
                </div>


            </div>
            <div class="tab-pane fade active show" id="purchase">
                <div class=" p-3 scroll-container" data-scrollbar="true">
                    <h2>Mass Schedules</h2>
                    <h5 style="margin: 20px;">Mass Schedule of St. Joseph the Worker Cathedral (Tagbilaran Cathedral).
                        Located at Bohol Circumferential Road, Tagbilaran City, Bohol</h5>

                    <div class="row">
                        <!-- BEGIN event-list -->

                        <!-- END event-list -->
                        <div class="col-lg">
                            <!-- BEGIN calendar -->
                            <div id="calendar" class="calendar"></div>
                            <!-- END calendar -->
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- END tabs -->

        <!-- END panel -->
    </div>
    <!-- END col-8 -->
    <div class="modal fade" id="announcementModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modalContent"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END row -->
<!-- Event Details Modal -->
<div class="modal fade" id="event-details-modal" tabindex="-1" aria-labelledby="eventDetailsLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-3" style="background-color: #f1f4e4; border-radius: 10px;">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold" style="color: #3d4b3e;">Schedule details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="sched_ids">
                <input type="hidden" id="event-priest-id">
                <!-- <p><strong>Status:</strong> <span id="event-status"></span></p> -->
                <p><strong>Date:</strong> <span id="event-date"></span></p>
                <p><strong>Time:</strong> <span id="event-time"></span></p>
                <p><strong>Purpose:</strong> <span id="event-purpose"></span></p>
                <p><strong>Requested priest:</strong> <span id="event-priest"></span></p>
                <p><strong>Requested by:</strong> <span id="event-requested-by"></span></p>
                <p><strong>Venue:</strong> <span id="event-venue"></span></p>
                <p><strong>Address:</strong> <span id="event-address"></span></p>
                <p><strong>Additional Comment:</strong> <span id="event-comment"></span></p>
            </div>
            <!-- <div class="modal-footer border-0 d-flex justify-content-between">
                <button type="button" class="btn btn-success px-4" id="update-btn">Update</button>
                <button type="button" class="btn btn-danger px-4" id="complete-btn">Complete</button>
            </div> -->
        </div>
    </div>
</div>
<div class="modal fade" id="modal-create-own-sched">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update schedule</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-5">
                        <input type="hidden" id="update_sched">
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
                            <label class="form-label purpose-label">Purpose:</label>
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
                                placeholder="If others, please specify..." disabled />
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <a href="javascript:;" class="btn btn-white btn-xs" data-bs-dismiss="modal">Close</a>
                <a href="javascript:;" class="btn btn-primary btn-xs" id="save-schedule">Action</a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-create-mass-sched">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update mass schedule</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="update_mass_sched">
                <div class="mb-3">
                    <label class="form-label" for="exampleInputEmail1">Date</label>
                    <div class="input-group date" id="datepicker-mass" data-date-format="yyyy-m-d"
                        data-date-start-date="Date.default">
                        <input type="text" class="form-control form-control-sm" id="datepicker-mass-input"
                            placeholder="Select Date" />
                        <span class="input-group-text input-group-addon"><i class="fa fa-calendar"></i></span>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="row">
                        <div class="col-6">
                            <label class="form-label">From</label>
                            <div class="input-group bootstrap-timepicker">
                                <input id="timepicker-mass-from" type="text" class="form-control form-control-sm" />
                                <span class="input-group-text input-group-addon"><i class="fa fa-clock"></i></span>
                            </div>
                        </div>
                        <div class="col-6">
                            <label class="form-label">To</label>
                            <div class="input-group bootstrap-timepicker">
                                <input id="timepicker-mass-to" type="text" class="form-control form-control-sm" />
                                <span class="input-group-text input-group-addon"><i class="fa fa-clock"></i></span>
                            </div>
                        </div>

                    </div>

                </div>
                <div class="mb-3">
                    <label class="form-label">Assign a priest:</label>
                    <select class="form-select" id="priest-select">
                        <option value="" selected>Choose a priest</option>
                        @foreach(get_all_priest() as $priest)

                        <option value="{{ $priest->id }}">{{ $priest->name }}</option>
                        @endforeach

                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <a href="javascript:;" class="btn btn-white btn-xs" data-bs-dismiss="modal">Close</a>
                <a href="javascript:;" class="btn btn-success btn-xs" id="save-event-btn">Save</a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')

<script>
$('#all-tab').addClass('tab-link');
$(document).ready(function() {
    $('#dashboard').addClass('active');

    setTimeout(function() {
        $('#latest-post-tab').tab('show');
    }, 1); // 2000 milliseconds = 2 seconds


    $('#all-tab').on('click', function() {
        // $('#announcement_status').val('is_posted');
        $(this).addClass('tab-link');
        $('#public-tab').removeClass('tab-link');
        $('#marriage-tab').removeClass('tab-link');
        $('#project-tab').removeClass('tab-link');
        // fetchAnnouncements();

    });
    $('#public-tab').on('click', function() {
        // $('#announcement_status').val('is_pending');
        $(this).addClass('tab-link');
        $('#all-tab').removeClass('tab-link');
        $('#marriage-tab').removeClass('tab-link');
        $('#project-tab').removeClass('tab-link');
        // fetchAnnouncements();
    });
    $('#marriage-tab').on('click', function() {
        // $('#announcement_status').val('is_archive');
        $(this).addClass('tab-link');
        $('#all-tab').removeClass('tab-link');
        $('#public-tab').removeClass('tab-link');
        $('#project-tab').removeClass('tab-link');
        // fetchAnnouncements();

    });
    $('#project-tab').on('click', function() {
        // $('#announcement_status').val('is_archive');
        $(this).addClass('tab-link');
        $('#all-tab').removeClass('tab-link');
        $('#marriage-tab').removeClass('tab-link');
        $('#public-tab').removeClass('tab-link');
        // fetchAnnouncements();

    });

});
$(document).ready(function() {
    $('#update-btn').on('click', function() {
        // Fetch event details from #event-details-modal
        let status = $('#event-status').text();
        let date = $('#event-date').text();
        let time = $('#event-time').text().split(' - '); // Assuming format: "08:00 AM - 10:00 AM"
        let purpose = $('#event-purpose').text().trim();
        let venue = $('#event-venue').text();
        let address = $('#event-address').text();
        let others = $('.others').val();
        let priestId = $('#event-priest-id').val(); // Assuming there's an element with priest ID


        // Convert the date using JavaScript
        let parsedDate = new Date(date);

        // Format it to YYYY-MM-DD
        let formattedDate = parsedDate.getFullYear() + "-" +
            String(parsedDate.getMonth() + 1).padStart(2, '0') + "-" +
            String(parsedDate.getDate()).padStart(2, '0');


        if (purpose === "Mass Schedule") {
            // Populate Mass Schedule Modal

            $('#update_mass_sched').val($('#sched_ids').val());
            $('#datepicker-mass-input').val(formattedDate);
            $('#timepicker-mass-from').val(time[0]); // Start time
            $('#timepicker-mass-to').val(time[1]); // End time
            $('#priest-select').val(priestId); // Select priest
            // assign_to_id
            // Hide event details modal & show Mass Schedule modal
            $('#event-details-modal').modal('hide');
            setTimeout(() => {
                $('#modal-create-mass-sched').modal('show');
            }, 500);
        } else {
            // Populate Own Schedule Modal
            $('#update_sched').val($('#sched_ids').val());

            $('#datepicker-disabled-past input').val(formattedDate);
            $('#timepicker-from').val(time[0]); // Start time
            $('#timepicker-to').val(time[1]); // End time
            $('#venue').val(venue);
            $('#address').val(address);
            $('.others').val(others || "").prop('disabled', !others);

            // Select the correct Purpose radio button
            $('input[name="flexRadioDefault"]').each(function() {
                if ($(this).data('val') === purpose) {
                    $(this).prop('checked', true);
                }
            });

            // Hide event details modal & show Own Schedule modal
            $('#event-details-modal').modal('hide');
            setTimeout(() => {
                $('#modal-create-own-sched').modal('show');
            }, 500);
        }
    });
});


var handleCalendarDemo = function() {
    var containerEl = document.getElementById('external-events');
    var Draggable = FullCalendar.Interaction.Draggable;


    var calendarElm = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarElm, {
        headerToolbar: {
            left: 'dayGridMonth,timeGridWeek,timeGridDay',
            center: 'title',
            right: 'prev,next today'
        },
        initialView: 'dayGridMonth',
        editable: false, // Set to false to disable editing
        droppable: false, // Disable event dropping
        themeSystem: 'bootstrap',
        events: getEvets(),
        eventClick: function(info) {
            console.log("info ::", info.event._def.extendedProps);

            $('#sched_ids').val(info.event._def.extendedProps.schedule_id);
            $('#event-status').text(info.event._def.extendedProps.status);
            $('#event-date').text(info.event._def.extendedProps.formated_date);
            $('#event-time').text(info.event._def.extendedProps.start_time + " - " + info.event._def
                .extendedProps.end_time);
            $('#event-purpose').text(info.event._def.extendedProps.purpose);
            $('#event-priest').text(info.event._def.extendedProps.assign_to);
            $('#event-requested-by').text(info.event._def.extendedProps.created_by);
            $('#event-venue').text(info.event._def.extendedProps.venue);
            $('#event-address').text(info.event._def.extendedProps.address);
            $('#event-comment').text(info.event._def.extendedProps.others || "None");
            $('#event-priest-id').val(info.event._def.extendedProps.assign_to_id);

            $('#event-details-modal').modal('show');
        }


    });

    calendar.render();

    function getEvets() {
        let ret = {};
        $.ajax({
            url: '/get-events',
            method: 'GET',
            async: false,
            success: function(data) {
     
                if (typeof data === 'string') {
                    try {
                        const parsedData = JSON.parse(data);
                        ret = parsedData.filter(event => event.title === "Mass Schedule").map(event => {
                            const date = new Date(event.start);
                            event.startFormatted = date.toLocaleString('en-US', {
                                hour: 'numeric',
                                minute: '2-digit',
                                hour12: true
                            });
                            return event;
                        });
                    } catch (error) {
                        console.error("JSON parsing error:", error);
                    }
                } else { 
                    // Mass Schedule
                    ret = data.filter(event => event.title === "Mass Schedule").map(event => {
                        const date = new Date(event.start);
                        event.startFormatted = date.toLocaleString('en-US', {
                            hour: 'numeric',
                            minute: '2-digit',
                            hour12: true
                        });
                        return event;
                    });
                }
            },
            error: function(xhr) {
                console.error(xhr.responseText);
            }
        });
        return ret;
    }

    function saveEvent(eventData) {
        $.ajax({
            url: '/save-event',
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                ...eventData
            },
            success: function(response) {
                console.log(response);
            },
            error: function(xhr) {
                console.error(xhr.responseJSON.error);
            }
        });
    }
};

var Calendar = function() {
    "use strict";
    return {
        init: function() {
            handleCalendarDemo();
        }
    };
}();


$('#announcement_status').val('is_posted');

$(document).ready(function() {
    $('#all-tab').on('click', function() {
        fetchAnnouncements('all');
    });
    $('#marriage-tab').on('click', function() {
        fetchAnnouncements('marriage');
    });
    $('#project-tab').on('click', function() {
        fetchAnnouncements('project');
    });
    $('#public-tab').on('click', function() {
        fetchAnnouncements('public');
    });

    function fetchAnnouncements(_type) {
        $('#loading').show(); // Show loading indicator
        const announcementType = $('#announcement_type').val(); // Get selected announcement type

        $.ajax({
            url: "{{ route('announcements.fetch.dash') }}?page=1&type=" + _type +
                "&announcement_status=is_posted", // Append selected type
            method: 'GET',
            success: function(response) {
                let html = ``;

                console.log(response.length);



                if (response.length === 0) {
                    html = `
                    <div class="d-flex">
                        <div class="flex-1 ps-3 no-data-container">
                            
                            <p>No data</p>
                        </div>
                    </div>
                    <hr class="bg-gray-500" style="border: none !important;" />
                    
                    `;
                } else {

                    response.forEach(function(item, index) {

                        let content1 = item.content.replace(/<\/?[^>]+(>|$)/g, "");
                        console.log(content1);
                        let content = item.content;
                        let maxLength = 150;
                        let displayContent = content1.length > maxLength ?
                            content1.substring(0, maxLength) +
                            ' .. <a href="#" class="show-modal" data-date_format="' +
                            formatDate(item.updated_at) + '" data-content="' +
                            encodeURIComponent(content) + '" data-title="' +
                            encodeURIComponent(
                                item.title) + '">View more...</a>' :
                            content;

                        html += `
                            <div class="d-flex m">
                                <div class="border-end text-center d-flex align-items-center justify-content-center"
                                    style="width: 200px !important; height: 100px;">
                                    <div class="mb-3px">${formatDate(item.updated_at)}</div>
                                </div>
                                <div class="flex-1 ps-3 pt-3">
                                    <h5>${item.title}</h5>
                                    <div class="announcement-content">${displayContent}</div>
                                </div>
                            </div>
                            <hr class="bg-gray-500" style="border: none !important;" />
                            `;
                    });

                }


                if (_type == 'public') {
                    $('.public_announcements').html(html);
                } else if (_type == 'marriage') {
                    $('.marrige_announcements').html(html);
                } else if (_type == 'project') {
                    $('.project_announcements').html(html);
                } else {
                    $('.all_announcements').html(html);
                }



                $('#loading').hide(); // Hide loading indicator
            },
            error: function(xhr) {
                $('#loading').hide(); // Hide loading indicator
            }
        });
    }

    // Event listener for modal trigger
    $(document).on("click", ".show-modal", function(e) {
        e.preventDefault();
        let fullContent = decodeURIComponent($(this).data("content"));
        let title = decodeURIComponent($(this).data("title"));
        let _date = decodeURIComponent($(this).data("date_format"));

        $("#modalTitle").text(title);
        $("#modalContent").html('<strong>' + _date + '</strong><br><br>' + fullContent);
        $("#announcementModal").modal("show"); // Show Bootstrap Modal
    });



    function getStatus(data) {
        var html = ``;

        if (data.status == 'is_pending') {
            html =
                `<a href="javascript:;" class="btn btn-sm btn-success me-5px is_posted_class" data-id="${data.id}" aria-label="Post">Post</a>
                                                <a href="javascript:;" class="btn btn-sm btn-danger me-5px is_archive_class" data-id="${data.id}" aria-label="Decline">Decline</a>
                                                <a href="javascript:;" class="btn btn-sm btn-primary" aria-label="Edit">Edit</a>`;

        } else if (data.status == 'is_posted') {

            html =
                `<a href="javascript:;" class="btn btn-sm btn-primary is_archive_class" data-id="${data.id}" aria-label="Archive">Archive</a>`;
        } else {
            html = ``;
        }

        return html;
    }

    // Fetch announcements on page load
    fetchAnnouncements('all');

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

    function formatDate(timestamp) {
        const date = new Date(timestamp);
        const now = new Date();

        // Check if the date is today
        const isToday = date.toDateString() === now.toDateString();

        if (isToday) {
            return `Today, ${date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', hour12: true })}`;
        } else {
            return date.toLocaleString('en-US', {
                weekday: 'short',
                month: 'short',
                day: 'numeric',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                hour12: true
            });
        }
    }


});

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
    $("input[type='radio'][name='flexRadioDefault']").on("change", function() {
        let selectedValue = $(this).data("val"); // Get the selected radio value

        if (selectedValue.toLowerCase() === "others") {
            $(".others").prop("disabled", false).focus(); // Enable input field
        } else {
            $(".others").prop("disabled", true).val(""); // Disable and clear input field
        }
    });
});
$(document).on('click', '#save-schedule', function() {
    let isValid = true; // Track overall form validity
    $('.error-message').remove(); // Remove previous error messages
    $('.form-control, .form-check-input').removeClass('is-invalid');
    $('.form-label.purpose-label').removeClass('text-danger'); // Reset Purpose label

    const dateInput = $('#datepicker-disabled-past input');
    const dateValue = dateInput.val().trim();

    if (dateValue === '') {
        isValid = false;
        dateInput.addClass('is-invalid'); // Highlight the date field
        // dateInput.after('<div class="text-danger error-message small">Date is required.</div>'); // Show error message
    }

    const data = {
        schedId: $('#update_sched').val(),
        date: dateValue,
        time_from: $('#timepicker-from').val(),
        time_to: $('#timepicker-to').val(),
        venue: $('.venue').val(),
        address: $('.address').val(),
        purpose: $('input[name="flexRadioDefault"]:checked').attr('data-val'),
        liturgical_id: $('input[name="flexRadioDefault"]:checked').attr('data-id'),
        others: $('.others').val(),
        sched_type: 'own_sched',
        assign_to: '',
        _token: $('meta[name="csrf-token"]').attr('content'),
    };

    if (!isValid) {
        return; // Stop submission if any validation fails
    }

    $.ajax({
        url: '{{ route("schedules.store") }}',
        method: 'POST',
        data: data,
        success: function(response) {
            alert(response.message);
            location.reload(); // Reload the page or update the DOM dynamically
        },
        error: function(xhr) {
            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;
                $.each(errors, function(field, messages) {
                    let inputField = $('.' + field.replace('_', '-')); // Match class

                    if (field === 'purpose') {
                        $('.purpose-label').addClass(
                        'text-danger'); // Add red text to label
                    } else {
                        inputField.addClass('is-invalid'); // Highlight error field
                        inputField.after('<div class="text-danger error-message small">' +
                            messages[0] + '</div>'); // Show error
                    }
                });
            } else {
                console.log(xhr);
                alert(xhr.responseJSON.message);
            }
        },
    });
});




$('#save-event-btn').on('click', function() {
    var selectedDate = $('#datepicker-mass-input').val();
    var fromTime = $('#timepicker-mass-from').val();
    var toTime = $('#timepicker-mass-to').val();
    var priestId = $('#priest-select').val();

    // Validate data

    // Send data using AJAX
    $.ajax({
        url: '{{ route("schedules.store") }}',
        method: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            schedId: $('#update_mass_sched').val(),
            liturgical_id: '1',
            date: selectedDate,
            time_from: fromTime,
            time_to: toTime,
            assign_to: priestId,
            sched_type: 'mass_sched',
        },
        success: function(response) {
            alert('Event saved successfully.');
            // Optionally, you can close the modal or reset the form here
            $('#datepicker').val('');
            $('#timepicker-mass-from').val('');
            $('#timepicker-mass-to').val('');
            $('#priest-select').val('');
            // Close modal
            $('[data-bs-dismiss="modal"]').click();
        },
        error: function(xhr, status, error) {
            console.log(xhr);
            alert(xhr.responseJSON.message);
        }
    });
});
</script>
@endpush