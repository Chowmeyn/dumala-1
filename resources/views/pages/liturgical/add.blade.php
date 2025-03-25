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
        <li class="breadcrumb-item active">Add Liturgical Service</li>
    </ol>
    <!-- END breadcrumb -->
    <!-- BEGIN page-header -->
    <h1 class="page-header">Add Liturgical Service <small></small></h1>




    <div class="panel panel-inverse">

        <!-- END panel-heading -->
        <!-- BEGIN panel-body -->
        <div class="panel-body">

            <form action="/" method="POST" id="liturgicalForm">
                <fieldset>
                    <div class="mb-3">
                        <label class="form-label" for="liturgicalName">Liturgical Service Name:</label>
                        <input class="form-control" type="text" id="liturgicalName" name="title"
                            placeholder="Enter Liturgical Service Name" />
                    </div> 
                    <div class="mb-3">
                        <label class="form-label" for="exampleInputPassword1">Requirements</label>
                        <textarea class="form-control content_text" id="editor1" name="requirements"
                            style="border: 1px solid #d2d3d3" name="content" rows="3" ></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="liturgicalName">Stipend:</label>
                        <input class="form-control w-25" name="stipend" type="number" id="stipend"
                            placeholder="Enter Stipend" />
                    </div>

                    <!-- Button container -->
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary w-100px me-5px">Confirm</button>
                        <a href="/liturgical" class="btn btn-danger w-100px">Cancel</a>
                    </div>
                </fieldset>
            </form>
        </div>

    </div>

</div>


@endsection

@push('scripts')

<script>
$('#liturgical').addClass('active');


var handleBootstrapWysihtml5 = function() {
    "use strict";
    $('#wysihtml5').wysihtml5();
};

var handleCkeditor = function() {
    var elm = document.querySelector('#editor1');
    ClassicEditor.create(elm, {
        toolbar: {
            items: [
                'bold',
                'italic',
                'undo',
                'redo',
                'bulletedList', // Add this for bulleted list
                'numberedList' // Add this for numbered list
                // The unwanted features (Link, BlockQuote, Insert Table, Image Upload) are omitted here
            ]
        }
    }).catch(error => {
        console.error(error);
    });
};

var FormWysihtml = function() {
    "use strict";
    return {
        // Main function
        init: function() {
            handleCkeditor();
            handleBootstrapWysihtml5();
        }
    };
}();

$(document).ready(function() {
    FormWysihtml.init();

    $(document).on('theme-reload', function() {
        $('.wysihtml5-sandbox, input[name="_wysihtml5_mode"], .wysihtml5-toolbar').remove();
        $('#wysihtml5').show();
        handleBootstrapWysihtml5();
    });
});

$("#liturgicalForm").submit(function(e) {
    e.preventDefault(); // Prevent default form submission
    // liturgicalName, editor1, stipend
    var title = $('#liturgicalName').val()
    var requirements = $('.ck-editor__editable').html()
    var stipend = $('#stipend').val()
    $.ajax({
        url: "{{ route('liturgicals.store') }}",
        type: "POST",
        data: {
            title: title,
            requirements: requirements,
            stipend: stipend,
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            alert("Liturgical added successfully!");
            location.href="/liturgical"
 
        },
        error: function(xhr) {
            alert("Error: " + xhr.responseJSON.message);
        }
    });
});
</script>
@endpush