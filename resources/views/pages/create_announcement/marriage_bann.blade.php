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
    <!-- BEGIN breadcrumb -->
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
        <li class="breadcrumb-item active">Create Announcement</li>
    </ol>
    <!-- END breadcrumb -->
    <!-- BEGIN page-header -->
    <h1 class="page-header">Create Announcement</h1>
    <!-- END page-header -->
    <div class="panel panel-inverse">
        <!-- BEGIN panel-body -->
        <div class="panel-body">
            <form id="announcement-form">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-10px">
                            <label class="form-label">Announcement type:</label>
                            <select class="form-select" id="announcement_type" name="announcement_type" required>
                                <option value="public">Public announcement</option>
                                <option value="marriage" selected>Marriage banns</option>
                                <option value="project">Project and financial</option>
                                <!-- <option value="mass">Mass schedules</option> -->
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
                                <option value="Unang Tawag">Unang Tawag</option>
                                <option value="Ikaduhang Tawag">Ikaduhang Tawag</option>
                                <option value="Ikatulong Tawag">Ikatulong Tawag</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Other input fields -->
                <div class="row">
                    <div class="col-6">
                        <div class="mb-10px">
                            <label class="form-label">Groom name:</label>
                            <input class="form-control" type="text" id="groom_name" name="groom_name"
                                placeholder="Enter groom's name" required>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-10px">
                            <label class="form-label">Bride name:</label>
                            <input class="form-control" type="text" id="bride_name" name="bride_name"
                                placeholder="Enter bride's name" required>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="mb-10px">
                            <label class="form-label">Groom age:</label>
                            <input class="form-control" type="number" id="groom_age" name="groom_age"
                                placeholder="Enter groom's age" required>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-10px">
                            <label class="form-label">Bride age:</label>
                            <input class="form-control" type="number" id="bride_age" name="bride_age"
                                placeholder="Enter bride's age" required>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="mb-10px">
                            <label class="form-label">Groom address:</label>
                            <input class="form-control" type="text" id="groom_address" name="groom_address"
                                placeholder="Enter groom's address" required>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-10px">
                            <label class="form-label">Bride address:</label>
                            <input class="form-control" type="text" id="bride_address" name="bride_address"
                                placeholder="Enter bride's address" required>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="mb-10px">
                            <label class="form-label">Groom parents' name:</label>
                            <input class="form-control" type="text" id="groom_parents" name="groom_parents"
                                placeholder="Enter groom's parents' names" required>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-10px">
                            <label class="form-label">Bride parents' name:</label>
                            <input class="form-control" type="text" id="bride_parents" name="bride_parents"
                                placeholder="Enter bride's parents' names" required>
                        </div>
                    </div>
                </div>

                <!-- Submit button -->
                <div class="pagination pagination-sm d-flex justify-content-end mt-3">
                    <button type="button" id="submit-announcement" class="btn btn-sm btn-success me-5px">Submit</button>
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

    // Validate input fields
    function validateInput(input) {
        const $input = $(input);
        const value = $input.val().trim();
        const fieldName = $input.attr('name');
        
        console.log(`Validating ${fieldName}: "${value}"`);
        
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
    $('#submit-announcement').click(function(e) {
        e.preventDefault();

        let isValid = true;
        const invalidFields = [];

        // Only validate the fields we know should be in the form
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
                url: "{{ route('marriage.store') }}",
                type: "POST",
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    message({
                        title: 'Success!',
                        message: 'Announcement created successfully!',
                        icon: 'success'
                    });
                    setTimeout(() => {
                        location.href = "{{ route('anouncements') }}";
                    }, 1500);
                },
                error: function(xhr) {
                    message({
                        title: 'Error!',
                        message: 'Error saving the announcement',
                        icon: 'error'
                    });
                    console.error('Error:', xhr.responseText);
                }
            });
        } else {
            message({
                title: 'Validation Error!',
                message: 'Please fill in the following required fields: ',
                icon: 'error'
            });
        }
    });
});
</script>
@endpush