@extends('layouts.main')

@push('style-file')
<style>
.is-invalid {
    border-color: red;
}

.error {
    color: red;
}
</style>
@endpush

@section('content')
<div class="row" style="margin-right: 18px !important; margin-left: 5px !important;">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
        <li class="breadcrumb-item active">Edit Announcement</li>
    </ol>
    <h1 class="page-header">Edit Announcement</h1>
    <div class="panel panel-inverse">
        <div class="panel-body">
            <form id="announcement-form">
                @csrf
                <input type="hidden" name="id" value="{{ $announcement->id }}">
                <input type="hidden" name="status" value="{{ $announcement->status }}">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-10px">
                            <label class="form-label">Announcement type:</label>
                            <select class="form-select" id="announcement_type" name="announcement_type" required>
                                <option value="public" {{ $announcement->announcement_type == 'public' ? 'selected' : '' }}>Public announcement</option>
                                <option value="marriage" {{ $announcement->announcement_type == 'marriage' ? 'selected' : '' }}>Marriage banns</option>
                                <option value="project" {{ $announcement->announcement_type == 'project' ? 'selected' : '' }}>Project and financial</option>
                                <option value="mass" {{ $announcement->announcement_type == 'mass' ? 'selected' : '' }}>Mass schedules</option>
                            </select>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-10px">
                            <label class="form-label">Marriage bann:</label>
                            <select class="form-select" id="marriage_bann" name="marriage_bann" required>
                                <option value="Unang Tawag" {{ $announcement->marriage_bann == 'Unang Tawag' ? 'selected' : '' }}>Unang Tawag</option>
                                <option value="Ikaduhang Tawag" {{ $announcement->marriage_bann == 'Ikaduhang Tawag' ? 'selected' : '' }}>Ikaduhang Tawag</option>
                                <option value="Ikatulong Tawag" {{ $announcement->marriage_bann == 'Ikatulong Tawag' ? 'selected' : '' }}>Ikatulong Tawag</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Other input fields -->
                <div class="row">
                    @php
                        $fields = [
                            'groom_name', 'bride_name', 'groom_age', 'bride_age',
                            'groom_address', 'bride_address', 'groom_parents', 'bride_parents'
                        ];
                    @endphp
                    @foreach ($fields as $field)
                        <div class="col-6">
                            <div class="mb-10px">
                                <label class="form-label">{{ ucwords(str_replace('_', ' ', $field)) }}:</label>
                                <input class="form-control" type="text" id="{{ $field }}" name="{{ $field }}"
                                    value="{{ $announcement->$field }}" required>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Submit button -->
                <div class="pagination pagination-sm d-flex justify-content-end mt-3">
                    <button type="button" id="update-announcement" class="btn btn-sm btn-primary me-5px">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#announcement_type').change(function() {
        var selectedValue = $(this).val();

        const routes = {
            public: "{{ route('public_announce') }}",
            marriage: "{{ route('marriage_bann') }}",
            project: "{{ route('project_financial') }}",
            mass: "{{ route('public_announce') }}"
        };

        if (routes[selectedValue]) {
            location.href = routes[selectedValue];
        }
    });
    // Validate input fields
    function validateInput(input) {
        const $input = $(input);
        if ($input.prop('required') && $input.val().trim() === "") {
            $input.addClass('is-invalid');
            return false;
        } else {
            $input.removeClass('is-invalid');
            return true;
        }
    }

    $('input, select').on('input change', function() {
        validateInput(this);
    });

    $('#update-announcement').click(function(e) {
        e.preventDefault();

        let isValid = true;
        $('input, select').each(function() {
            if (!validateInput(this)) {
                isValid = false;
            }
        });

        if (isValid) {
            $.ajax({
                url: "{{ route('marriage.update', $announcement->id) }}",
                type: "POST",
                data: $('#announcement-form').serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function() {
                    alert('Announcement updated successfully!');
                    location.href = "{{ route('anouncements') }}";
                },
                error: function() {
                    alert('Error updating the announcement');
                }
            });
        }
    });
});
</script>
@endpush