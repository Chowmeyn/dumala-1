@extends('layouts.main')

@section('content')
<div class="row" style="margin-right: 18px !important; margin-left: 5px !important;">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
        <li class="breadcrumb-item active">Edit Announcement</li>
    </ol>

    <h1 class="page-header">Edit Announcement</h1>

    <div class="panel panel-inverse">
        <div class="panel-body">
            <input type="hidden" id="announcement_id" value="{{ $announcement->id }}">
            <input type="hidden" id="status" value="{{ $announcement->status }}">
            <div class="row">
                <div class="col-md-6">
                    <label class="form-label">Announcement type:</label>
                    <select class="form-select" id="announcement_type">
                        <!-- <option value="public" {{ $announcement->announcement_type == 'public' ? 'selected' : '' }}>Public announcement</option> -->
                        <!-- <option value="marriage" {{ $announcement->announcement_type == 'marriage' ? 'selected' : '' }}>Marriage banns</option> -->
                        <option value="project" {{ $announcement->announcement_type == 'project' ? 'selected' : '' }}>Project and financial</option>
                        <!-- <option value="mass" {{ $announcement->announcement_type == 'mass' ? 'selected' : '' }}>Mass schedules</option> -->
                    </select>
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-md-6">
                    <label class="form-label">Project name:</label>
                    <input class="form-control project_name" type="text" value="{{ $announcement->title }}">
                </div>
            </div>

            <div class="row">
                <div id="donor-list">
                    @foreach($donors as $donor)
                    <hr>
                    <div class="col-md-12 donor-entry">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label">Donor name:</label>
                                <input class="form-control donor_name" type="text" value="{{ $donor->donor_name }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Donated amount:</label>
                                <input class="form-control donated_amount" type="number" value="{{ $donor->donated_amount }}">
                            </div>
                            <div class="col-12 mt-4 text-center">
                                <a href="javascript:;" class="btn btn-danger remove-donor-btn btn-xs">
                                    <i class="fa fa-times"></i> Remove Donor
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="col-md-12">
                    <a href="javascript:;" id="add-donor-btn" class="btn btn-primary me-1 mb-1 mt-4 btn-xs">
                        <i class="fa fa-plus"></i> Add Donor
                    </a>
                </div>
            </div>

            <div class="pagination pagination-sm d-flex justify-content-end mt-3">
                <p class="mb-0 d-flex justify-content-end">
                    <a href="javascript:;" id="update-announcement-btn" class="btn btn-sm btn-success me-5px">Update Announcement</a>
                    <a href="/announcements" class="btn btn-sm btn-danger me-5px">Cancel</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$('#update-announcement-btn').click(function(e) {
    e.preventDefault();

    var announcementId = $('#announcement_id').val();
    var announcementType = $('#announcement_type').val();
    var projectName = $('.project_name').val();
    var donors = [];

    $('.donor-entry').each(function() {
        donors.push({
            donor_name: $(this).find('.donor_name').val(),
            donated_amount: $(this).find('.donated_amount').val()
        });
    });

    $.ajax({
        url: '/project_financial/' + announcementId,
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            announcement_type: announcementType,
            status: '<?=$announcement->status ?>',
            project_name: projectName,
            donors: donors
        },
        success: function(response) {
            alert(response.message);
            location.href = "/anouncements";
        },
        error: function(xhr) {
            alert('Error updating announcement: ' + xhr.responseText);
        }
    });
});

// Add donor entry
$('#add-donor-btn').click(function() {
    var newDonorEntry = $('.donor-entry:first').clone();
    newDonorEntry.find('input').val('');
    $('#donor-list').append('<hr>').append(newDonorEntry);
});

// Remove donor entry
$(document).on('click', '.remove-donor-btn', function() {
    var donorCount = $('.donor-entry').length;
    if (donorCount > 1) {
        $(this).closest('.donor-entry').prev('hr').remove();
        $(this).closest('.donor-entry').remove();
    } else {
        alert('Cannot remove the last donor!');
    }
});
</script>
@endpush
