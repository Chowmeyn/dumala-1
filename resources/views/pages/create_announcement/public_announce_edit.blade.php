@extends('layouts.main')

@push('style-file')
<!-- Include any required CSS here -->
@endpush

@push('script-file')
<!-- Include any additional JS libraries here if necessary -->
@endpush

@section('content')
<div class="row" style="margin-right: 18px !important; margin-left: 5px !important;">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
        <li class="breadcrumb-item active">Edit Announcement</li>
    </ol>

    <h1 class="page-header">Edit Announcement <small></small></h1>

    <div class="panel panel-inverse">
        <div class="panel-body">
            <form id="announcement-form">
                @csrf
                <input type="hidden" name="announcement_id" id="announcement_id" value="{{ $announcement->id }}">
                <input type="hidden" name="status" id="status" value="{{ $announcement->status }}">

                <div class="row">
                    <div class="col-md-6 mb-10px">
                        <label class="form-label">Announcement type:</label>
                        <select class="form-select" id="announcement_type" name="announcement_type">
                            <option value="public" {{ $announcement->announcement_type == 'public' ? 'selected' : '' }}>Public announcement</option>
                            <option value="marriage" {{ $announcement->announcement_type == 'marriage' ? 'selected' : '' }}>Marriage banns</option>
                            <option value="project" {{ $announcement->announcement_type == 'project' ? 'selected' : '' }}>Project and financial</option>
                            <option value="mass" {{ $announcement->announcement_type == 'mass' ? 'selected' : '' }}>Mass schedules</option>
                        </select>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-md-6 mb-10px">
                        <label class="form-label">Title:</label>
                        <input class="form-control" type="text" id="title" name="title" placeholder="Title..." value="{{ $announcement->title }}">
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Content:</label>
                        <textarea class="form-control content_text" id="editor1" style="border: 1px solid #d2d3d3"
                            name="content" rows="3" placeholder="Content...">{{ $announcement->content }}</textarea>
                    </div>
                </div>

                <div class="pagination pagination-sm d-flex justify-content-end mt-3">
                    <button type="submit" class="btn btn-sm btn-success me-5px">Update Announcement</button>
                    <a href="/anouncements" class="btn btn-sm btn-danger me-5px">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$('#announcements').addClass('active');

$(document).ready(function() {
    // Initialize CKEditor
    let editorInstance;
    ClassicEditor.create(document.querySelector('#editor1')).then(editor => {
        editorInstance = editor;
    }).catch(error => {
        console.error(error);
    });

    // Validate form fields and submit via AJAX
    $('#announcement-form').on('submit', function(e) {
        e.preventDefault(); // Prevent default form submission

        let title = $('#title').val().trim();
        let content = editorInstance.getData();
        let announcementType = $('#announcement_type').val();
        let announcementId = $('#announcement_id').val();
        let status = $('#status').val();

        // Remove previous validation errors
        $('.is-invalid').removeClass('is-invalid');

        // Simple validation
        let isValid = true;
        if (title === '') {
            message({
                    title: 'Error!',
                    message: "Title should not be empty!",
                    icon: 'error'
                });
            $('#title').addClass('is-invalid');
            isValid = false;
        }
        if (content.trim() === '') {
            message({
                    title: 'Error!',
                    message: "Content should not be empty!",
                    icon: 'error'
                });
            $('.content_text').addClass('is-invalid');
            isValid = false;
        }

        if (!isValid) return;

        $.ajax({
            url: "{{ route('public_announce.update', ['id' => $announcement->id]) }}",
            type: 'POST', 
            data: {
                _token: '{{ csrf_token() }}', // CSRF token for security
                title: title,
                content: content,
                announcement_type: announcementType,
                status: status,
                // _method: 'PUT' // Laravel requires _method for PUT requests
            },
            success: function(response) {
                alert('Announcement updated successfully!');
                window.location.href = "/anouncements"; // Redirect to announcements page
            },
            error: function(xhr) {
                alert('An error occurred while updating the announcement.');
                console.error('Error:', xhr.responseText);
            }
        });
    });

    // Remove validation error on input
    $('#title, .content_text').on('input', function() {
        $(this).removeClass('is-invalid');
    });
});
</script>
@endpush
