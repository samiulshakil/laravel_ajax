@extends('layouts.app')
@push('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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
                    <button class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#myModal">New User</button>
                </div>
            </div>
        </div>

        <div class="container mt-5">
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered">
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script>
<script>
    $(document).ready(function() {
        $('.js-example-basic-single').select2();
        $('.dropify').dropify();

        $("#myModal").on("show.bs.modal", function(event) {

            // Get the button that triggered the modal
            var button = $(event.relatedTarget);

            // Extract value from the custom data-* attribute
            var titleData = button.data("title");

            // Change modal title
            $(this).find(".modal-title").text(titleData);

            $('#myModal #saveBtn').text('save');
            $('#myModal .modal-title').text('Add New User');

        $(document).on('change','#district_id', function(event) {
         //get upazila by dependenci select box
        let district_id = $('#district_id').val();
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

    });

    //form data store of users
    $(document).on('click', '#saveBtn', function () {
        let storeForm = document.getElementById('storeForm');
        let formData = new FormData(storeForm);
        let url = "{{route('users.store')}}";

        store_form_data(formData, url);
    });

    function store_form_data(formData, url) {
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
                if(data.status == false){
                    $.each(data.errors, function (key, value) {
                        $('#storeForm #' + key).addClass('is-invalid');
                    });
                }else{
                    $("#myModal").modal('hide');
                    $('#storeForm')[0].reset();
                }

            },
            error: function (xhr, ajaxOption, thrownError) {
                console.log(thrownError + '\r\n' + xhr.statusText + '\r\n' + xhr.responseText);
            }
        });
    }

});


    });

</script>
@endpush
