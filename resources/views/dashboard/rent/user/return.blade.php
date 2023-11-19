@extends('dashboard._layouts._app')

@section('content')
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-start mb-0">{{ $title }}</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboards</a>
                                </li>
                                <li class="breadcrumb-item"><a href="#">Car</a>
                                </li>
                                <li class="breadcrumb-item active">Rent a Car
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form id="form" enctype="multipart/form-data">
                                <div class="col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="date_start">License Plate</label>
                                        <input type="text" id="license_plate" name="license_plate"
                                            placeholder="Enter License Plate" class="form-control" />
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-1">
                                            <button type="submit" class="btn btn-primary" id="returnCar">Return the
                                                car</button>
                                        </div>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $("#returnCar").click(function(e) {
        e.preventDefault();
        var license_plate = $("#license_plate").val();

        $.ajax({
            url: "{{ route('api.rent.return_plate') }}",
            type: "POST",
            data: {
                _token: '{{ csrf_token() }}',
                license_plate: license_plate,
                _method: 'PUT'
            },
            dataType: "json",
            success: function(response) {
                Swal.fire({
                    title: "Success!",
                    text: response.message,
                    icon: "success",
                    button: "OK",
                }).then(function() {
                    window.location.href = "{{ route('rent.index') }}";
                });
            },
            error: function(response) {
                Swal.fire({
                    title: "Error!",
                    text: response.responseJSON.message,
                    icon: "error",
                    button: "OK",
                });
            }
        });
    });
</script>
@endpush

@push('styles')
@endpush