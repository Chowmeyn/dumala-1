@extends('layouts.main')



@push('style-file')

@endpush

@push('script-file')

@endpush


@section('content')
<div class="row" style="margin-right: 18px !important; margin-left: 5px !important;">
    <!-- BEGIN breadcrumb -->
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
        <li class="breadcrumb-item active">Create Announcement</li>
    </ol>
    <!-- END breadcrumb -->
    <!-- BEGIN page-header -->
    <h1 class="page-header">Create Announcement <small></small></h1>
    <!-- END page-header -->
    <div class="panel panel-inverse">


        <!-- BEGIN panel-body -->
        <div class="panel-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-10px">
                        <label class="form-label">Announcement type:</label>
                        <select class="form-select" id="announcement_type" required>
                            <option value="public">Public announcement</option>
                            <option value="marriage">Marriage banns</option>
                            <option value="project" selected>Project and financial</option>
                            <!-- <option value="mass">Mass schedules</option> -->
                        </select>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-10px">
                        <label class="form-label">Project name:</label>
                        <input class="form-control project_name" type="text" placeholder="Enter project name" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div id="donor-list">
                    <hr>
                    <div class="col-md-12 donor-entry">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label">Donors name:</label>
                                <input class="form-control donor_name" type="text" placeholder="Enter donor name"
                                    required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Donated amount:</label>
                                <input class="form-control donated_amount" type="number"
                                    placeholder="Enter donated amount" required>
                            </div>
                            <div class="col-12 mt-4 text-center">
                                <a href="javascript:;" class="btn btn-danger remove-donor-btn btn-xs"
                                    style="border-radius: 50px !important" required>
                                    <i class="fa fa-times"></i> Remove Donor
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <a href="javascript:;" id="add-donor-btn" class="btn btn-primary me-1 mb-1 mt-4 btn-xs"
                        style="border-radius: 50px !important"><i class="fa fa-plus"></i> Add Donor</a>
                </div>
            </div>

            <div class="pagination pagination-sm d-flex justify-content-end mt-3">
                <p class="mb-0 d-flex justify-content-end">
                    <a href="javascript:;" id="save-donor-btn" type="submit"
                        class="btn btn-sm btn-success me-5px">Save</a>
                    <a href="/anouncements" class="btn btn-sm btn-danger me-5px">Cancel</a>
                </p>
            </div>
        </div>

    </div>

</div>
</div>
<!-- END row -->
@endsection

@push('scripts')

<script>
$('#announcements').addClass('active');

$(document).ready(function() {
    $('#announcement_type').change(function() {
        var selectedValue = $(this).val(); // Get the selected value
        console.log('Selected announcement type: ' + selectedValue);

        // Perform an action based on the selected value
        if (selectedValue === 'public') {
            location.href = "{{ route('public_announce') }}";
        } else if (selectedValue === 'marriage') {
            location.href = "{{ route('marriage_bann') }}";
        } else if (selectedValue === 'project') {
            location.href = "{{ route('project_financial') }}";
        } else if (selectedValue === 'mass') {
            location.href = "{{ route('public_announce') }}";
        }
    });
    // Validation function for form fields
    function validateInput(input) {
        if ($(input).val().trim() === "") {
            $(input).addClass('is-invalid'); // Add invalid class
            $(input).closest('.form-group').find('.invalid-feedback').show(); // Show feedback message
        } else {
            $(input).removeClass('is-invalid');
            $(input).closest('.form-group').find('.invalid-feedback').hide();
        }
    }

    // Validate fields on form submit
    $('#save-donor-btn').click(function(e) {
        e.preventDefault();

        var isValid = true;

        // Validate each input field
        $('.project_name, .donor_name, .donated_amount').each(function() {
            validateInput(this);
            if ($(this).hasClass('is-invalid')) {
                isValid = false; // If any input is invalid, set isValid to false
            }
        });

        if (isValid) {
            // Proceed with AJAX if all inputs are valid
            var announcementType = $('#announcement_type').val();
            var projectName = $('.project_name').val();
            var donors = [];

            $('.donor-entry').each(function() {
                var donorName = $(this).find('.donor_name').val();
                var donatedAmount = $(this).find('.donated_amount').val();
                donors.push({
                    donor_name: donorName,
                    donated_amount: donatedAmount
                });
            });

            // AJAX call to save donor data
            $.ajax({
                url: '{{ route("donors.store") }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    announcement_type: announcementType,
                    project_name: projectName,
                    donors: donors
                },
                success: function(response) {
                    alert('Donors saved successfully!');
                    location.href = "{{ route('anouncements') }}";
                },
                error: function(xhr, status, error) {
                    alert('Error saving donors: ' + xhr.responseText);
                }
            });
        }
    });

    // Validate on field blur (optional for immediate validation)
    $('.project_name, .donor_name, .donated_amount').on('blur', function() {
        validateInput(this);
    });

    // Remove 'is-invalid' class when the user starts typing
    $('.project_name, .donor_name, .donated_amount').on('input', function() {
        $(this).removeClass('is-invalid'); // Remove invalid class
        $(this).closest('.form-group').find('.invalid-feedback').hide(); // Hide error message
    });

    // Add new donor entry with validation
    $('#add-donor-btn').click(function() {
        var newDonorEntry = $('.donor-entry:first').clone();
        newDonorEntry.find('input').val(''); // Clear input fields
        $('#donor-list').append('<hr>').append(newDonorEntry);
    });

    // Remove donor entry
    $(document).on('click', '.remove-donor-btn', function() {
        var donorCount = $('.donor-entry').length;

        if (donorCount > 1) {
            $(this).closest('.donor-entry').prev('hr').remove(); // Remove previous <hr>
            $(this).closest('.donor-entry').remove();
        } else {
            alert('Cannot remove the last donor!');
        }
    });

    // Validation helper function to add invalid feedback
    function addErrorHtml(input) {
        var parentDiv = $(input).closest('.form-group');
        if (parentDiv.find('.invalid-feedback').length === 0) {
            parentDiv.append(`
                <div class="invalid-feedback">
                    <i class="far fa-times-circle"></i> Please enter a valid value.
                </div>
            `);
        }
    }

    // Add invalid feedback for each required input
    $('.project_name, .donor_name, .donated_amount').each(function() {
        addErrorHtml(this);
    });
});
</script>
@endpush