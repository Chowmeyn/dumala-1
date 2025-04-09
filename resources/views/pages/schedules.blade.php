@extends('layouts.main')


@push('style-file')

@endpush

@push('script-file')


@endpush

@section('content')
<div class="row" style="margin-right: 18px !important; margin-left: 5px !important;">
    <!-- BEGIN #content -->

    <!-- BEGIN breadcrumb -->
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
        <li class="breadcrumb-item active">Schedules</li>
    </ol>
    <!-- END breadcrumb -->
    <!-- BEGIN page-header -->
    <h1 class="page-header">Schedules <small>
            @if( Auth::user()->role === 'admin' || Auth::user()->role === 'parish_priest')
            <a id="createOwnSchedButton" class="btn btn-primary btn-sm me-1 mb-1" onclick="setCreateOwnSched()">Create own
                schedule</a>
            <a id="createMassSchedButton" class="btn btn-primary btn-sm me-1 mb-1" onclick="setCreateMassSched()">Create mass schedule</a>
            @endif

            @if(Auth::user()->role === 'priest' )
            <a id="createOwnSchedButton" class="btn btn-primary btn-sm me-1 mb-1" onclick="setCreateOwnSched()">Create own
                schedule</a>
            @endif

        </small></h1>
    <!-- END page-header -->
    <hr />
    <!-- BEGIN row -->
    <div class="row">
        <!-- BEGIN event-list -->
        <?php
                $role = Auth::user()->role;
                $shouldHide = $role === 'admin' || $role === 'parish_priest' || $role === 'priest' || $role === 'secretary';
            ?>
        <div class="d-none d-lg-block" style="width: 215px">
            <div id="external-events" class="fc-event-list" <?= $shouldHide ? '' : 'style="display: none;"' ?>>
                <h5 class="mb-3">Priests</h5>

                <label class="d-flex align-items-center mb-2" data-sched_id="1" data-color="#00acac">
                    <!-- <input type="checkbox" name="events[]" value="1" checked class="me-2">
                    <i class="fas fa-circle fa-fw fs-9px text-success me-2"></i>
                    <span class="fc-event-text">Unassigned</span> -->
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked="">
                        <label class="form-check-label" for="flexCheckChecked">
                            <b>Unassigned</b>
                        </label>
                    </div>

                </label>

                <label class="d-flex align-items-center mb-2" data-sched_id="2" data-color="#348fe2">


                    <div class="form-check mb-2">
                        <input class="form-check-input flexCheckChecked" type="checkbox" value="{{Auth::user()->id}}" id="flexCheckChecked_{{Auth::user()->id}}" checked
                            onclick="getEvents('{{Auth::user()->id}}')">
                        <label class="form-check-label" for="flexCheckChecked_{{Auth::user()->id}}">
                            <b>Own Schedule</b>
                        </label>
                    </div>
                </label>


                @foreach(get_all_priest() as $priest)

                @if($priest->name != Auth::user()->name)
                <label class="d-flex align-items-center mb-2" data-sched_id="2" data-color="#348fe2">


                    <div class="form-check mb-2">
                        <input class="form-check-input flexCheckChecked" type="checkbox" value="{{$priest->id}}" id="flexCheckChecked_{{$priest->id}}" <?=(Auth::user()->role === 'admin') ? "checked" : "" ?> onclick="getEvents('{{$priest->id}}')">
                        <label class="form-check-label" for="flexCheckChecked_{{$priest->id}}">
                            <b>{{ $priest->prefix }} {{ $priest->firstname }} {{ $priest->lastname }}</b>
                        </label>
                    </div>
                </label>
                @endif


                <!-- <option value="{{ $priest->id }}">{{ $priest->name }}</option> -->
                @endforeach

                <!-- <label class="d-flex align-items-center mb-2" data-sched_id="3" data-color="#f59c1a">
                    <input type="checkbox" name="events[]" value="3" class="me-2">
                    <i class="fas fa-circle fa-fw fs-9px text-warning me-2"></i>
                    <span class="fc-event-text">Group Discussion</span>
                </label> -->



                <hr class="my-3" />
            </div>
        </div>
        <!-- END event-list -->
        <div class="col-lg">
            <!-- BEGIN calendar -->
            <div id="calendar" class="calendar"></div>
            <!-- END calendar -->
        </div>
    </div>
    <!-- END row -->

    <!-- END #content -->

    <!-- END page-header -->
</div>

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
                <p><strong>Status:</strong> <span id="event-status"></span></p>
                <p><strong>Date:</strong> <span id="event-date"></span></p>
                <p><strong>Time:</strong> <span id="event-time"></span></p>
                <p><strong>Purpose:</strong> <span id="event-purpose"></span></p>
                <p><strong>Requested priest:</strong> <span id="event-priest"></span></p>
                <p><strong>Requested by:</strong> <span id="event-requested-by"></span></p>
                <p><strong>Venue:</strong> <span id="event-venue"></span></p>
                <p><strong>Address:</strong> <span id="event-address"></span></p>
                <p><strong>Additional Comment:</strong> <span id="event-comment"></span></p>
            </div>
            <div class="modal-footer border-0 d-flex justify-content-center modal-footer-detail">
                <button type="button" class="btn btn-success px-4" id="update-btn">Archive</button>
            </div>

        </div>
    </div>
</div>
<div class="modal fade" id="modal-create-own-sched">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Own schedule</h5>
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
                                <input type="text" class="form-control form-control-sm" id="datepicker-own-input" placeholder="Select Date" />
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
            <!-- <div class="modal-header">
                <h5 class="modal-title">Mass schedule</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div> -->
            <div class="modal-body">
                <input type="hidden" id="update_mass_sched">
                <div class="mb-3 d-none">
                    <label class="form-label" for="exampleInputEmail1">Date</label>
                    <div class="input-group date" id="datepicker-mass" data-date-format="yyyy-m-d"
                        data-date-start-date="Date.default">
                        <input type="text" class="form-control form-control-sm" id="datepicker-mass-input"
                            placeholder="Select Date" />
                        <span class="input-group-text input-group-addon"><i class="fa fa-calendar"></i></span>
                    </div>
                </div>

                <div class="mb-3 d-none">
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
<!-- END row -->
@endsection

@push('scripts')

<script>
$('#schedules').addClass('active');
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

let createOwnSched = false;
let createMassSched = false;
const ownSchedButton = document.getElementById('createOwnSchedButton');
    const massSchedButton = document.getElementById('createMassSchedButton');

function setCreateOwnSched() {
    createOwnSched = true;
    createMassSched = false;
    console.log('createOwnSched set to:', createOwnSched);
    console.log('createMassSched set to:', createMassSched);

    

    $('#createOwnSchedButton').button('toggle');
    $('#createMassSchedButton').removeClass('active');
}

function setCreateMassSched() {
    createMassSched = true;
    createOwnSched = false;
    console.log('createOwnSched set to:', createOwnSched);
    console.log('createMassSched set to:', createMassSched);

    $('#createMassSchedButton').button('toggle');
    $('#createOwnSchedButton').removeClass('active');
}

function UpdateBTN() {
    console.log("5");

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
}




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
        selectable: true,
        events: getEvents(),
        // dateClick: function(info) {
        //     console.log("Clicked date:", info.dateStr);
        //     alert("You clicked on: " + info.dateStr);
        // },
        select: function(info) {
            let startDate = new Date(info.start);
            let endDate = new Date(info.end);
            let currentDate = new Date();

            // Remove time from currentDate for comparison
            currentDate.setHours(0, 0, 0, 0);

            

            // Format: YYYY-MM-DD
            let formattedDate = startDate.getFullYear() + "-" +
                String(startDate.getMonth() + 1).padStart(2, '0') + "-" +
                String(startDate.getDate()).padStart(2, '0');

            // Format: HH:MM AM/PM
            let formattedStartTime = startDate.toLocaleTimeString('en-US', {
                hour: 'numeric',
                minute: '2-digit',
                hour12: true
            });

            let formattedEndTime = endDate.toLocaleTimeString('en-US', {
                hour: 'numeric',
                minute: '2-digit',
                hour12: true
            });

            let formattedRange = formattedDate + " " + formattedStartTime + " to " + formattedEndTime;

            if (createOwnSched) {
                // Check if the selected date is in the past
                if (startDate < currentDate) {
                    alert("You cannot select a past date.");
                    return; // Stop further execution
                }else{
                    console.log("Selected datetime:", formattedRange);

                    // Set values in modal input fields
                    $('#datepicker-own-input').val(formattedDate); // YYYY-MM-DD

                    // Show modal
                    $('#modal-create-own-sched').modal('show');
                    // createOwnSched = false;
                }
            } else if (createMassSched) {
                if (startDate < currentDate) {
                    alert("You cannot select a past date.");
                    return; // Stop further execution
                }else{
                    console.log("Selected datetime:", formattedRange);

                    // Set values in modal input fields
                    $('#datepicker-mass-input').val(formattedDate); // YYYY-MM-DD
                    $('#timepicker-mass-from').val(formattedStartTime); // HH:MM AM/PM
                    $('#timepicker-mass-to').val(formattedEndTime); // HH:MM AM/PM

                    // Show modal
                    $('#modal-create-mass-sched').modal('show');
                        // createOwnSched = false;
                }
            }
            
            
        },
        eventClick: function(info) {
            console.log("info ::", info.event._def.extendedProps);
            if (info.event._def.extendedProps.status != 5) {

            }
            const status = info.event._def.extendedProps.status;
            let statusBadge = '';

            if (status === 1) {
                statusBadge = '<span class="badge bg-yellow text-black">Pending</span>';
            } else if (status === 2) {
                statusBadge = '<span class="badge bg-primary">Accepted</span>';
            } else if (status === 3) {
                statusBadge = '<span class="badge bg-danger">Declined</span>';
            } else if (status === 4) {
                statusBadge = '<span class="badge bg-info text-black">Complete</span>';
            } else if (status === 5) {
                statusBadge = '<span class="badge bg-secondary">Archived</span>';
            } else {
                statusBadge = '<span class="badge bg-success">Accepted by priest</span>';
            }

            $('#sched_ids').val(info.event._def.extendedProps.schedule_id);
            $('#event-status').html(statusBadge);
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

            if (info.event._def.extendedProps.status === 4) {
                $('.modal-footer-detail').html(
                    '<button type="button" class="btn btn-success px-4" id="archive-btn" onclick="archiveSched(' +
                    info.event._def.extendedProps.schedule_id + ')">Archive</button>'
                );
            } else {
                $('.modal-footer-detail').html(
                    '<button type="button" class="btn btn-success px-4" onclick="UpdateBTN()" id="update-btn">Update</button><button type="button" class="btn btn-danger px-4" id="complete-btn" onclick="completeSched(' +
                    info.event._def.extendedProps.schedule_id + ')">Complete</button>'
                );
            }


            $('#event-details-modal').modal('show');
        }


    });

    calendar.render();

    function refreshEvents() {
        console.log("Refreshing events...");
        // Refetch events with updated data
        calendar.refetchEvents(); // This will reload the events based on current state of selectedIds
    }

    // Bind checkbox change to refresh the calendar
   
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

$(document).ready(function() {
    Calendar.init();
});
let selectedIds = ['<?=(Auth::user()->role === 'admin') ? "" : Auth::user()->id ?>'];
function getEvents(val='') {
    let ret = {};

    // Check the checkbox state and either add or remove the ID from the array
    const checkbox = $('#flexCheckChecked_' + val);  // Get the specific checkbox by ID
    const isChecked = checkbox.prop('checked');  // Check if it's checked

    // If the checkbox is checked, add its value to the array, else remove it
    if (isChecked) {
        // If it's not already in the array, add it
        if (!selectedIds.includes(val)) {
            selectedIds.push(val);
        }
    } else {
        // Remove it from the array if it's unchecked
        selectedIds = selectedIds.filter(id => id !== val);
    }

    // Log the selectedIds array to check if it updates correctly
    console.log('Selected IDs:', selectedIds);


    $.ajax({
        url: '/get-events',
        method: 'GET',
        data: {
            ARRAY: selectedIds
        },
        async: false,
        success: function(data) {
            console.log("Sched :::", data);

            if (typeof data === 'string') {
                try {
                    const parsedData = JSON.parse(data);
                    ret = parsedData.map(event => {
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
                ret = data.map(event => {
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

$('.flexCheckChecked').change(function() {
        console.log("Checkbox changed, refreshing events...");
        Calendar.init();
    });

function completeSched(sched_id) {
    $('#event-details-modal').modal('hide');
    $.ajax({
        url: '/completeSched',
        method: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            sched_id: sched_id
        },
        success: function(response) {
            console.log(response);

            message({
                title: 'Success!',
                message: response.message,
                icon: 'success'
            });
            setTimeout(() => {
                location.reload();
            }, 2000);


        },
        error: function(xhr) {
            message({
                title: 'Error!',
                message: xhr.responseJSON.error,
                icon: 'error'
            });

        }
    });
}

function archiveSched(sched_id) {
    $('#event-details-modal').modal('hide');
    $.ajax({
        url: '/archiveSched',
        method: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            sched_id: sched_id
        },
        success: function(response) {
            message({
                title: 'Success!',
                message: response.message,
                icon: 'success'
            });

            setTimeout(() => {
                location.reload();
            }, 2000);
        },
        error: function(xhr) {
            message({
                title: 'Error!',
                message: xhr.responseJSON.error,
                icon: 'error'
            });
        }
    });
}
// completeSched archiveSched

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

    var fl = true

    if (priestId == "") {
        alert("Please select priest!")
        fl = false
    }

    if (fl) {
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

                $('#modal-create-mass-sched').modal('hide');
                location.reload();


            },
            error: function(xhr, status, error) {
                alert(xhr.responseJSON.message);
            }
        });
    }


});
</script>
@endpush