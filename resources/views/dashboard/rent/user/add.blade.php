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
                                        <label class="form-label" for="car_id">Car</label>
                                        <select class="form-select" id="car_id" name="car_id">
                                            <option value="">-- Select Car --</option>
                                            @foreach ($cars as $car)
                                            <option value="{{ $car->id }}">{{ $car->brand . " " . $car->model . " " .
                                                $car->type . " (" . $car->color . ") IDR " .
                                                number_format($car->price) . "/day"}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-1" id="preview"></div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="date_start">Date Start - End</label>
                                        <input type="text" id="date" name="date" class="form-control flatpickr-range"
                                            placeholder="YYYY-MM-DD to YYYY-MM-DD" />
                                        <input type="hidden" id="date_start" name="date_start" />
                                        <input type="hidden" id="date_end" name="date_end" />
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="date_start">Estimated Price</label>
                                        <input type="text" id="estimated_price" name="estimated_price"
                                            class="form-control" readonly />
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-1">
                                            <button type="submit" class="btn btn-primary" id="addnewrent">Rent a
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
<script src="/assets/vendors/js/pickers/pickadate/picker.js"></script>
<script src="/assets/vendors/js/pickers/pickadate/picker.date.js"></script>
<script src="/assets/vendors/js/pickers/pickadate/picker.time.js"></script>
<script src="/assets/vendors/js/pickers/pickadate/legacy.js"></script>
<script src="/assets/vendors/js/pickers/flatpickr/flatpickr.min.js"></script>
<script>
    $(document).ready(function() {
        $("#car_image_info").hide();
        $("#car_id").select2({
            
        });
        $("#date").flatpickr({
            mode: "range",
            dateFormat: "Y-m-d",
            minDate: "today",
            onChange: function(selectedDates, dateStr, instance) {
                var date_start = dateStr.split(" to ")[0];
                var date_end = dateStr.split(" to ")[1];
                $("#date_start").val(date_start);
                $("#date_end").val(date_end);
                calculate_estimated_price();
            }
        });
        show_car_image();
    });

    $("#addnewrent").click(function(e) {
        e.preventDefault();
        var date_start = $("#date_start").val();
        var date_end = $("#date_end").val();
        var car_id = $("#car_id").val();
        var user_id = '{{ auth()->user()->id }}';

        $.ajax({
            url: "{{ route('api.rent.store') }}",
            type: "POST",
            data: {
                _token: '{{ csrf_token() }}',
                date_start: date_start,
                date_end: date_end,
                car_id: car_id,
                user_id: user_id,
                _method: '{{ $menu === "rentUpdate" ? "PUT" : "POST" }}'
            },
            success: function(response) {
                Swal.fire({
                    title: "Success!",
                    text: "{{ ($menu === 'rentUpdate') ? 'Rent information updated successfully!' : 'New rent has been added!' }}",
                    icon: "success",
                    button: "OK",
                }).then(function() {
                    window.location.href = "{{ route('rent.index') }}";
                });
            },
            error: function(response) {
                Swal.fire({
                    title: "Error!",
                    text: "Something went wrong!",
                    icon: "error",
                    button: "OK",
                });
            }
        });
    });

    $("#date_start").change(function() {
        calculate_estimated_price();
    });

    $("#date_end").change(function() {
        calculate_estimated_price();
    });

    function calculate_estimated_price() {
        var date_start = $("#date_start").val();
        var date_end = $("#date_end").val();
        var car_id = $("#car_id").val();
        var user_id = '{{ auth()->user()->id }}';

        $.ajax({
            url: "{{ route('api.rent.calculate') }}",
            type: "POST",
            data: {
                _token: '{{ csrf_token() }}',
                date_start: date_start,
                date_end: date_end,
                car_id: car_id,
            },
            dataType: "json",
            success: function(response) {
                var formatter = new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                });
                var total_price = formatter.format(response.data.total_price);
                $("#estimated_price").val(total_price);
            },
        });
    }

    $("#car_id").change(function() {
        show_car_image();
    });

    function show_car_image() {
        var car_id = $("#car_id").val();

        $.ajax({
            url: "{{ route('api.car.show') }}/" + car_id,
            type: "GET",
            dataType: "json",
            success: function(response) {
                var preview = $("#preview");
                if (response.data.image.startsWith("http")) {
                    preview.html(
                        '<img src="' + response.data.image + '" class="img-fluid rounded" alt="Car Image" />'
                    );
                } else {
                    preview.html(
                    '<img src="{{ url('') }}/' + response.data.image + '" style="max-height: 300px;">');
                }
            },
        });
    }
</script>
@endpush

@push('styles')
<link rel="stylesheet" type="text/css" href="/assets/vendors/css/pickers/pickadate/pickadate.css">
<link rel="stylesheet" type="text/css" href="/assets/vendors/css/pickers/flatpickr/flatpickr.min.css">
<link rel="stylesheet" type="text/css" href="/assets/css/plugins/forms/pickers/form-pickadate.css">
@endpush