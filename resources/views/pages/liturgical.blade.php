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
        <li class="breadcrumb-item active">Liturgical Services</li>
    </ol>
    <!-- END breadcrumb -->
    <!-- BEGIN page-header -->
    <h1 class="page-header">Liturgical Services <small></small></h1>




    <div class="panel panel-inverse">

        <!-- END panel-heading -->
        <!-- BEGIN panel-body -->
        <div class="panel-body">

            <a href="/liturgical/create" class="btn btn-primary btn-sm me-1 mb-2"><i
                    class="fas fa-lg fa-fw me-10px fa-plus"></i>Add Liturgical Service</a>
            <!--  -->
            <div class="input-group">
                <input type="text" id="search-input" class="form-control" placeholder="Search by Name or Role"
                    oninput="getList(this.value, 1)">
                <div class="input-group-text" style="background: #fdfeff !important;"><i class="fa fa-search"></i></div>
            </div>

            <table class="table table-hover">

                <tbody>
                    <!-- Populated by JavaScript -->
                </tbody>
            </table>

            <div>
                <div class="pagination pagination-sm d-flex justify-content-end">
                    <!-- Populated by JavaScript -->
                </div>
            </div>
        </div>

    </div>

</div>

<div class="modal fade" id="modal-dialog-decline">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Decline Request</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label" for="exampleInputEmail1">Refer Another Priest:</label>
                    <select class="form-select" id="priest-select">
                        <option value="" selected>Choose a priest</option>
                        @foreach(get_all_priest() as $priest)
                        <option value="{{ $priest->id }}">{{ $priest->name }}</option>
                        @endforeach

                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="editor-text">Add a reason:</label>
                    <textarea id="editor-text" name="editor-text"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <a href="javascript:;" class="btn btn-white" data-bs-dismiss="modal">Close</a>
                <a href="javascript:;" class="btn btn-success">Action</a>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modal-dialog-assign-to-priest">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Assign a priest</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body">
                <div class="widget-list rounded mb-4" data-id="widget">
                    <!-- BEGIN widget-list-item -->

                    @foreach(get_all_priest() as $priest)
                    <div class="widget-list-item">
                        <div class="widget-list-media">
                            <img src="{{ $priest->profile_image ?? '/assets/img/user/user-profile-icon.jpg'}}"
                                width="50" alt="" class="rounded">
                        </div>
                        <div class="widget-list-content">
                            <h4 class="widget-list-title">{{ $priest->prefix ? $priest->prefix.'.' : '' }}
                                {{ $priest->firstname }} {{ $priest->lastname }}</h4>
                        </div>
                        <div class="widget-list-action">
                            <a href="javascript:;" data-id="" onclick="onclickAssignPost({{ $priest->id }})"
                                class="btn btn-success btn-icon btn-circle btn-lg assign_post">
                                <i class="fa fa-add"> </i>
                            </a>
                        </div>
                    </div>
                    @endforeach

                    <!-- END widget-list-item -->
                </div>


            </div>
        </div>
    </div>
</div>
<!-- END row -->




@endsection

@push('scripts')

<script>
$('#liturgical').addClass('active');
let currentPage = 1;
getList();


/*
Template Name: Color Admin - Responsive Admin Dashboard Template build with Twitter Bootstrap 5
Version: 5.4.1
Author: Sean Ngu
Website: http://www.seantheme.com/color-admin/
*/

var handleCkeditor = function() {
    var elm = document.querySelector('#editor-text');
    ClassicEditor.create(elm, {
        toolbar: {
            items: [
                'bold',
                'italic',
                'undo',
                'redo'
                // The unwanted features (Link, BlockQuote, Insert Table, Image Upload) are omitted here
            ]
        }
    }).then(editor => {
        // Add the editor instance to a global variable to access it later
        window.editor = editor;
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
            // handleBootstrapWysihtml5();
        }
    };
}();

$(document).ready(function() {
    FormWysihtml.init();

    $(document).on('theme-reload', function() {
        $('.wysihtml5-sandbox, input[name="_wysihtml5_mode"], .wysihtml5-toolbar').remove();
        $('#wysihtml5').show();
        // handleBootstrapWysihtml5();/
    });
});
// Clear the CKEditor content
function clearEditorContent() {
    if (window.editor) {
        window.editor.setData(''); // Clears the editor content
    }
}

// Populate the CKEditor with data for editing
function populateEditorWithData(data) {
    if (window.editor) {
        window.editor.setData(data); // Sets the content to the editor
    }
}

function getList(search = '', page = 1) {
    currentPage = page; // Update current page 
    $.ajax({
        url: '/list-liturgical',
        method: 'GET',
        dataType: 'json',
        data: {
            search: search,
            page: page
        },
        success: function(response) {
            const {
                data,
                total,
                current_page,
                per_page
            } = response;
            const tbody = $('table.table tbody');
            tbody.empty();

            if (data.length === 0) {
                tbody.append(`
                    <tr>
                        <td colspan="3" class="text-center">No data available.</td>
                    </tr>
                `);
                return;
            }

            // Populate table rows
            data.forEach((item, index) => {
                const rowId = `detailsRow${index + 1}`;
                tbody.append(`
                    <!-- Main Row -->
                    <tr data-bs-toggle="collapse" data-bs-target="#${rowId}" aria-expanded="false" aria-controls="${rowId}">
                        <td width="50%" style="padding-top: 20px;padding-left: 60px;"><strong>${item.title}</strong></td>
                        <td width="50%" style="padding-top: 20px; text-align: right;">
                       <a href="/liturgicals/${item.id}/edit" title="Edit" style="color: #007bff;"><i class="fas fa-lg fa-fw me-10px fa-pencil"></i></a>
                       <a href="#" onclick="deleteLit(${item.id})" title="Delete" style="color: #dc3545;"><i class="fas fa-lg fa-fw me-10px fa-trash-can"></i></a>
                        </td>
                        
                    </tr>
                    <!-- Collapsible Content -->
                    <tr id="${rowId}" class="collapse fade">
                        <td colspan="4">
                            <div class="p-1 bg-light">
                                <div class="d-flex p-1">
                                    <div class="flex-1">
                                       
                                        <div class="row">
                                            <div class="col-3" style="margin-left: 40px;">
                                                <strong>Requirements:</strong>
                                            </div>
                                            <div class="col-8" >
                                                ${item.requirements}
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-3" style="margin-left: 40px;">
                                                 <strong>Fee:</strong>
                                            </div>
                                            <div class="col-8 " style="padding-left: 30px;">
                                                 ${item.stipend}
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                `);
            });

            // Update pagination
            updatePagination(total, current_page, per_page);
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error:', error);
            const tbody = $('table.table tbody');
            tbody.empty();
            tbody.append(`
                <tr>
                    <td colspan="3" class="text-center">An error occurred while fetching data.</td>
                </tr>
            `);
        }
    });
}

function deleteLit(id) {

    if (confirm("Are you sure you want to delete this record?")) {
        $.ajax({
            url: "/liturgicals/" + id,
            type: "DELETE",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                alert("Liturgical Service deleted successfully!");
                location.reload();
            },
            error: function(xhr) {
                alert("Error: " + xhr.responseJSON.message);
            }
        });
    }
}


function onclickDecline(id) {

    $('#modal-dialog-decline').modal('show');
    clearEditorContent();

    $('#priest-select').val('');


}

function onclickAssignToPriest(id) {

    $('#modal-dialog-assign-to-priest').modal('show');
    $('.assign_post').attr('data-id', id);


}

function onclickAssignPost(id) {
    console.log(id);


    $.ajax({
        url: `/assign_priest`,
        method: 'POST',
        dataType: 'json',
        data: {
            user_id: id,
            sched_id: $('.assign_post').attr('data-id')
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {

            if (response.status == 1) {
                $('#modal-dialog-assign-to-priest').modal('hide');
                message({
                    title: 'Success!',
                    message: response.message,
                    icon: 'success'
                });
                getList();
            } else {
                message({
                    title: 'Error!',
                    message: response.message,
                    icon: 'error'
                });
            }

        },
        error: function(xhr, status, error) {
            console.error('Error updating user:', error);
        }
    });


}


function updatePagination(total, currentPage, perPage) {
    const pagination = $('.pagination');
    const totalPages = Math.ceil(total / perPage);

    pagination.empty();
    if (totalPages === 0) return;

    pagination.append(`
        <div class="page-item ${currentPage === 1 ? 'disabled' : ''}">
            <a href="javascript:;" class="page-link" onclick="getList($('#search-input').val(), ${currentPage - 1})">«</a>
        </div>
    `);

    for (let i = 1; i <= totalPages; i++) {
        pagination.append(`
            <div class="page-item ${currentPage === i ? 'active' : ''}">
                <a href="javascript:;" class="page-link" onclick="getList($('#search-input').val(), ${i})">${i}</a>
            </div>
        `);
    }

    pagination.append(`
        <div class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
            <a href="javascript:;" class="page-link" onclick="getList($('#search-input').val(), ${currentPage + 1})">»</a>
        </div>
    `);
}
</script>
@endpush