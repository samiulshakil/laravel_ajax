@extends('layouts.app')
@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css" rel="stylesheet" />
<style>
    .dropify-wrapper .dropify-message p {
        font-size: initial;
    }
    .required label:first-child::after{
        content: ' *';
        color: red;
        font-weight: bold;
    }
    .error {
        color: red;
    }

    .dataTables_length {
    padding-left: 1rem;
    }
    .dataTables_filter {
        padding-top: 1rem;
        padding-right: 1rem;
    }
    .dataTables_info {
        padding-left: 1rem;
        padding-bottom: 1rem;
    }
    .dataTables_paginate {
        padding-right: 1rem;
    }

</style>
@endpush
@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
                <div class="row">
                    <div class="col-md-6 d-flex align-items-center">
                        User Lists
                    </div>
                <div class="col-md-6">
                    <!-- Click to show Modal -->
                    <button onclick="showModal('Add New User','Save')" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#myModal">New User</button>
                </div>
            </div>
        </div>

        <div class="container mt-5">
            <div class="row">
                <div class="col-md-12 table-responsive">
                    <table class="align-middle mb-0 table table-borderless table-striped table-hover" id="dataTable">
                            <thead class="text-center">
                                <tr>
                                    <th>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="select_all" onchange="select_all()">
                                            <label class="custom-control-label" for="select_all"></label>
                                        </div>
                                    </th>
                                    <th>SL</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Role</th>
                                    <th>Email</th>
                                    <th>District</th>
                                    <th>Upazila</th>
                                    <th>Verified Email</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@include('modal.modal-lg')
@endsection
@push('js')
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script>
<script>
    let table;
    $(document).ready( function () {
        $('.dropify').dropify();

    table = $('#dataTable').DataTable({
            "processing": true, //Feature control the processing indicator
            "serverSide": true, //Feature control DataTable server side processing mode
            "order": [], //Initial no order
            "responsive": true, //Make table responsive in mobile device
            "bInfo": true, //TO show the total number of data
            "bFilter": false, //For datatable default search box show/hide
            "lengthMenu": [
                [5, 10, 15, 25, 50, 100, 1000, 10000, -1],
                [5, 10, 15, 25, 50, 100, 1000, 10000, "All"]
            ],
            "pageLength": 5, //number of data show per page
            "language": {
                processing: `<img src="{{asset('svg/table-loading.svg')}}" alt="Loading...."/>`,
                emptyTable: '<strong class="text-danger">No Data Found</strong>',
                infoEmpty: '',
                zeroRecords: '<strong class="text-danger">No Data Found</strong>'
            },
            "ajax": {
                "url": "{{route('user.list')}}",
                "type": "POST",
                "data": function (data) {
                    data._token = _token;
                }
            },
        });
    });


    function showModal(title, btnText) {
        $('#storeForm')[0].reset();
        $('#storeForm').find('.is-invalid').removeClass('is-invalid');
        $('#storeForm').find('.error').remove();
        $('#password, #password_confirmation').parent().removeClass('d-none');
        $('.dropify-clear').trigger('click');
        $('#myModal .modal-title').text(title);
        $('#myModal #saveBtn').text(btnText);
    }

        //form data store of users
        $(document).on('click', '#saveBtn', function () {
            let storeForm = document.getElementById('storeForm');
            let formData = new FormData(storeForm);
            let url = "{{route('user.store')}}";
            let id = $('#update_id').val();
            let method;
            if (id) {
                method = 'update';
            } else {
                method = 'add';
            }

            store_form_data(table, method, url, formData);
        });

        function store_form_data(table, method, url, formData) {
            $.ajax({
                url: url,
                type: "POST",
                data: formData,
                dataType: "JSON",
                contentType: false,
                processData: false,
                cache: false,
                success: function (data) {
                    $('#storeForm').find('.is-invalid').removeClass('is-invalid');
                    $('#storeForm').find('.error').remove();
                    if(data.status == false){
                        $.each(data.errors, function (key, value) {
                            $('#storeForm #' + key).addClass('is-invalid');
                            $('#storeForm #' + key).parent().append(
                                '<div class="error d-block">' + value + '</div>');
                        });
                    }else{
                        flashMessage(data.status, data.message);
                        if (data.status == 'success') {
                            if (method == 'update') {
                                table.ajax.reload(null, false);
                            } else {
                                table.ajax.reload();
                            }
                            $('#myModal').modal('hide');
                        }
                    }

                },
                error: function (xhr, ajaxOption, thrownError) {
                    console.log(thrownError + '\r\n' + xhr.statusText + '\r\n' + xhr.responseText);
                }
            });
        }

        //toaster notification 
        function flashMessage(status, message) {
                toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }

            switch (status) {
                case 'success':
                    toastr.success(message, 'SUCCESS');
                    break;
                case 'error':
                    toastr.error(message, 'ERROR');
                    break;
                case 'info':
                    toastr.info(message, 'INFORMARTION');
                    break;
                case 'warning':
                    toastr.warning(message, 'WARNING');
                    break;
            }
        }

    //edit users data
    $(document).on('click', '.edit_data', function () {
        let id = $(this).data('id');
        if (id) {
            $.ajax({
                    url: "{{route('user.edit')}}",
                    type: "POST",
                    data: {
                        id: id,
                        _token: _token
                    },
                    dataType: "JSON",
                    success: function (data) {
                        $('#password, #password_confirmation').parent().addClass('d-none'); 
                        $('#storeForm #update_id').val(data.user.id);
                        $('#storeForm #name').val(data.user.name);
                        $('#storeForm #email').val(data.user.email);
                        $('#storeForm #district_id').val(data.user.district_id);
                        upazilaList(data.user.district_id, 'storeForm');
                        setTimeout(() => {
                            $('#storeForm #upazila_id').val(data.user.upazila_id);
                        }, 1000);
                        $('#storeForm #address').val(data.user.address);
                        $('#storeForm #role_id').val(data.user.role_id);

                        if (data.user.avatar) {
                            let avatar = "{{asset('storage/user_image')}}/" + data.user.avatar;
                            $('#storeForm .dropify-preview').css('display', 'block');
                            $('#storeForm .dropify-render').html('<image src="' + avatar + '"/>');
                            $('#storeForm #old_avatar').val(data.user.avatar);
                        }else{
                            let avatar = "{{asset('svg/user.svg')}}" ;
                            $('#storeForm .dropify-preview').css('display', 'block');
                            $('#storeForm .dropify-render').html('<image src="' + avatar + '"/>');
                        }
                        
                        $("#myModal").modal('show');
                        $('#myModal .modal-title').html(
                            '<i class="fas fa-edit"></i> <span>Edit ' + data.user.name + '</span>');
                        $('#myModal #saveBtn').text('update');
                    },
                    error: function (xhr, ajaxOption, thrownError) {
                        console.log(thrownError + '\r\n' + xhr.statusText + '\r\n' + xhr.responseText);
                    }
                });
        }
    });


    //get upazila by dependenci select box
    function upazilaList(district_id, form) {
        if (district_id) {
            $.ajax({
                url: "{{route('upazila.list')}}",
                type: "POST",
                data: {
                    district_id: district_id,
                    _token: _token
                },
                dataType: "JSON",
                success: function (data) {
                    $('#upazila_id').html('');
                    $('#upazila_id').html(data);
                },
                error: function (xhr, ajaxOption, thrownError) {
                    console.log(thrownError + '\r\n' + xhr.statusText + '\r\n' + xhr.responseText);
                }
            });
        }

    }

</script>
@endpush
