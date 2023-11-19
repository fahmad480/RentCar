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
                                <li class="breadcrumb-item active">Add new Car
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
                                        <label class="form-label" for="brand">Brand Name</label>
                                        <input type="text" class="form-control" id="brand" name="brand"
                                            value="{{ @$car->brand }}" placeholder="Enter Brand Name">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="model">Brand Model</label>
                                        <input type="text" class="form-control" id="model" name="model"
                                            value="{{ @$car->model }}" placeholder="Enter Brand Model">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="type">Brand Type</label>
                                        <input type="text" class="form-control" id="type" name="type"
                                            value="{{ @$car->type }}" placeholder="Enter Brand Type">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="seat">Car Seat</label>
                                        <input type="text" class="form-control" id="seat" name="seat"
                                            value="{{ @$car->seat }}" placeholder="Enter Car Seat">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="license_plate">License Plate</label>
                                        <input type="text" class="form-control" id="license_plate" name="license_plate"
                                            value="{{ @$car->license_plate }}" placeholder="Enter License Plate">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="color">Car Color</label>
                                        <input type="text" class="form-control" id="color" name="color"
                                            value="{{ @$car->color }}" placeholder="Enter Car Color">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="year">Car Year</label>
                                        <input type="text" class="form-control" id="year" name="year"
                                            value="{{ @$car->year }}" placeholder="Enter Car Year">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="machine_number">Machine Number</label>
                                        <input type="text" class="form-control" id="machine_number"
                                            value="{{ @$car->machine_number }}" name="machine_number"
                                            placeholder="Enter Machine Number">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="chasis_number">Chasis Number</label>
                                        <input type="text" class="form-control" id="chasis_number" name="chasis_number"
                                            value="{{ @$car->chasis_number }}" placeholder="Enter Chasis Number">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="chasis_number">Car Image</label>
                                        <input type="file" class="hidden" id="image" name="image"
                                            accept="image/*"><br />
                                        <button type="button" id="select-files" class="btn btn-outline-primary"
                                            onclick="document.getElementById('image').click();">
                                            <i data-feather="file"></i> Click me to select files
                                        </button>
                                        <div class="mt-1" id="preview">
                                            @if (@$car->image)
                                            <img src="{{ asset($car->image) }}" class="img-thumbnail"
                                                style="max-height: 300px;">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="price">Price per Day</label>
                                        <input type="number" class="form-control" id="price" name="price"
                                            value="{{ @$car->price }}" placeholder="Enter Price per Day">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-1">
                                        <button type="submit" class="btn btn-primary" id="addnewcar">Add New
                                            Car</button>
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
    $(document).ready(function() {
        $("#image").change(function() {
            $('#preview').html("");
            var total_file = document.getElementById("image").files.length;
            for (var i = 0; i < total_file; i++) {
                $('#preview').append("<img src='" + URL.createObjectURL(event.target.files[i]) +
                    "' class='img-thumbnail' style='max-height: 300px;'>");
            }
        });

        $("#form").submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            formData.append('status', 'available');
            formData.append('_method', '{{ $menu === "carUpdate" ? "PUT" : "POST" }}');

            $.ajax({
                url: "{{ $menu === 'carUpdate' ? route('api.car.update', $car->id) : route('api.car.store')  }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    Swal.fire({
                        title: "Success!",
                        text: response.message,
                        icon: "success",
                        button: "OK",
                    }).then(function() {
                        window.location.href = "{{ route('car.index') }}";
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
    });
</script>
@endpush

@push('styles')
@endpush