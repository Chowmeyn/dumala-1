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
                                <option value="marriage" {{ $announcement->announcement_type == 'marriage' ? 'selected' : '' }}>Marriage banns</option>
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
                                <option value="Unang Tawag" {{ $marriage->marriage_bann == 'Unang Tawag' ? 'selected' : '' }}>Unang Tawag</option>
                                <option value="Ikaduhang Tawag" {{ $marriage->marriage_bann == 'Ikaduhang Tawag' ? 'selected' : '' }}>Ikaduhang Tawag</option>
                                <option value="Ikatulong Tawag" {{ $marriage->marriage_bann == 'Ikatulong Tawag' ? 'selected' : '' }}>Ikatulong Tawag</option>
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
                                @if($field == 'groom_age' || $field == 'bride_age')
                                    <input class="form-control" type="number" id="{{ $field }}" name="{{ $field }}"
                                        value="{{ $marriage->$field }}" min="1" max="120" required>
                                @else
                                    <input class="form-control" type="text" id="{{ $field }}" name="{{ $field }}"
                                        value="{{ $marriage->$field }}" required>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Submit button -->
                <div class="pagination pagination-sm d-flex justify-content-end mt-3">
                    <button type="button" id="update-announcement" class="btn btn-sm btn-primary me-5px">Update Announcement</button>
                    <a href="/anouncements" class="btn btn-sm btn-danger me-5px">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Define the required fields for marriage banns
    const requiredFields = [
        'announcement_type',
        'marriage_bann',
        'groom_name',
        'bride_name',
        'groom_age',
        'bride_age',
        'groom_address',
        'bride_address',
        'groom_parents',
        'bride_parents'
    ];

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
        const value = $input.val().trim();
        
        if ($input.prop('required') && value === "") {
            $input.addClass('is-invalid');
            if (!$input.next('.error').length) {
                $input.after('<div class="error" style="height: 20px;">This field is required</div>');
            }
            return false;
        } else {
            $input.removeClass('is-invalid');
            $input.next('.error').remove();
            return true;
        }
    }

    // On input change, validate and remove error class
    $('input, select').on('input change', function() {
        validateInput(this);
    });

    // Submit form using AJAX
    $('#update-announcement').click(function(e) {
        e.preventDefault();
        console.log('Update button clicked');

        let isValid = true;
        const invalidFields = [];

        // Validate all required fields
        requiredFields.forEach(fieldName => {
            const $field = $(`[name="${fieldName}"]`);
            if ($field.length && !validateInput($field)) {
                isValid = false;
                invalidFields.push(fieldName);
            }
        });

        console.log('Form validation result:', {
            isValid: isValid,
            invalidFields: invalidFields
        });

        if (isValid) {
            const formData = $('#announcement-form').serialize();
            console.log('Submitting form data:', formData);

            $.ajax({
                url: "{{ route('marriage.update', $announcement->id) }}",
                type: "POST",
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    alert('Announcement updated successfully!');
                    location.href = "{{ route('anouncements') }}";
                },
                error: function(xhr) {
                    console.error('Error:', xhr.responseText);
                    alert('Error updating the announcement');
                }
            });
        } else {
            alert('Please fill in all required fields: ' + invalidFields.join(', '));
        }
    });
});
</script>
@endpush