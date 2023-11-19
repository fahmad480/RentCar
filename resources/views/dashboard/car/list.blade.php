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
                                <li class="breadcrumb-item active">Car List
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <!-- Basic table -->
            <section id="basic-datatable">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <table id="tbl_list" class="datatables-basic table" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Image</th>
                                            <th>Name</th>
                                            <th>License Plate</th>
                                            <th>Price</th>
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
            </section>
            <!--/ Basic table -->
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="/assets/vendors/js/tables/datatable/jquery.dataTables.min.js"></script>
<script src="/assets/vendors/js/tables/datatable/dataTables.bootstrap5.min.js"></script>
<script src="/assets/vendors/js/tables/datatable/dataTables.responsive.min.js"></script>
<script src="/assets/vendors/js/tables/datatable/responsive.bootstrap5.min.js"></script>
<script src="/assets/vendors/js/tables/datatable/datatables.checkboxes.min.js"></script>
<script src="/assets/vendors/js/tables/datatable/datatables.buttons.min.js"></script>
<script src="/assets/vendors/js/tables/datatable/jszip.min.js"></script>
<script src="/assets/vendors/js/tables/datatable/pdfmake.min.js"></script>
<script src="/assets/vendors/js/tables/datatable/vfs_fonts.js"></script>
<script src="/assets/vendors/js/tables/datatable/buttons.html5.min.js"></script>
<script src="/assets/vendors/js/tables/datatable/buttons.print.min.js"></script>
<script src="/assets/vendors/js/tables/datatable/dataTables.rowGroup.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
       $('#tbl_list').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ url()->current() }}',
            columns: [
                {data: 'id', name: 'id'},
                {data: 'image', name: 'image', render: function(data, type, full, meta){
                    return "<img src=\""+data+"\" style=\"max-width: 200px;\">";
                }},
                {
                    data: null,
                    name: 'brand',
                    render: function(data, type, full, meta){
                        return full.brand + ' ' + full.model + ' (' + full.year + ', ' + full.type + ')' + "<br/>" + full.seat + " seats";
                    }
                },
                {data: 'license_plate', name: 'license_plate'},
                {data: 'price', name: 'price', render: function(data, type, full, meta){
                    return "Rp. " + data + " / day";
                }},
                {data: 'status', name: 'status', render: function(data, type, full, meta){
                    if (data == "available") {
                        return "<span style=\"background-color: #3C50E0; color: #fff; padding: 3px 8px; border-radius: 4px; display: inline-block;\">Available</span>";
                    } else if(data == "unavailable") {
                        return "<span style=\"background-color: #e13c40; color: #fff; padding: 3px 8px; border-radius: 4px; display: inline-block;\">Not Available</span>";
                    }
                }},
                {data: null, name: 'action', orderable: false, searchable: false, render: function(data, type, full, meta){
                    return "<a href=\"#\" onClick=\"showCar('" + full.brand + "', '" + full.model + "', '" + full.type + "', '" + full.color + "', '" + full.year + "', '" + full.license_plate + "', '" + full.machine_number + "', '" + full.chasis_number + "', '" + full.seat + "', '" + full.price + "', '" + full.status + "')\" class=\"text-primary\"><i data-feather=\"eye\"></i></a>&nbsp;&nbsp;<a href=\"{{ route('car.update') }}/" + full.id + "\" class=\"text-primary\"> <i data-feather=\"edit\"></i></a>&nbsp;&nbsp;<a href=\"#\" onClick=\"deleteCar(" + full.id + ")\" class=\"text-primary\"> <i data-feather=\"trash\"></i></a>";
                }},
            ],
            drawCallback: function () {
                feather.replace();
            }
        });
    });

    function deleteCar(id) {
        Swal.fire({
            title: 'Are you sure want to delete this car?',
            text: 'This action cannot be undone!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('api.car.destroy') }}/" + id,
                    type: "DELETE",
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        Swal.fire({
                            title: 'Success!',
                            text: 'Car has been deleted!',
                            icon: 'success',
                            showCancelButton: false,
                            confirmButtonText: 'OK',
                        }).then(function() {
                            window.location.href = "{{ route('car.index') }}";
                        });
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Something went wrong!',
                            icon: 'error',
                            showCancelButton: false,
                            confirmButtonText: 'OK',
                        });
                    }
                });
            }
        });
    }

    function showCar(brand, model, type, color, year, license_plate, machine_number, chasis_number, seat, price, status) {
        Swal.fire({
            html: '<table class="modal-table">' +
                '    <tr>' +
                '        <td><b>Brand</b></td>' +
                '        <td>' + brand + '</td>' +
                '    </tr>' +
                '    <tr>' +
                '        <td><b>Model</b></td>' +
                '        <td>' + model + '</td>' +
                '    </tr>' +
                '    <tr>' +
                '        <td><b>Type</b></td>' +
                '        <td>' + type + '</td>' +
                '    </tr>' +
                '    <tr>' +
                '        <td><b>Color</b></td>' +
                '        <td>' + color + '</td>' +
                '    </tr>' +
                '    <tr>' +
                '        <td><b>Year</b></td>' +
                '        <td>' + year + '</td>' +
                '    </tr>' +
                '    <tr>' +
                '        <td><b>License Plate</b></td>' +
                '        <td>' + license_plate + '</td>' +
                '    </tr>' +
                '    <tr>' +
                '        <td><b>Machine Number</b></td>' +
                '        <td>' + machine_number + '</td>' +
                '    </tr>' +
                '    <tr>' +
                '        <td><b>Chassis Number</b></td>' +
                '        <td>' + chasis_number + '</td>' +
                '    </tr>' +
                '    <tr>' +
                '        <td><b>Seat</b></td>' +
                '        <td>' + seat + '</td>' +
                '    </tr>' +
                '    <tr>' +
                '        <td><b>Price per day</b></td>' +
                '        <td>' + price + '</td>' +
                '    </tr>' +
                '    <tr>' +
                '        <td><b>Status</b></td>' +
                '        <td>' + status + '</td>' +
                '    </tr>' +
                '</table>',
            showCloseButton: true,
            showConfirmButton: false,
        })
    }
</script>
@endpush

@push('styles')
<link rel="stylesheet" type="text/css" href="/assets/vendors/css/tables/datatable/dataTables.bootstrap5.min.css">
<link rel="stylesheet" type="text/css" href="/assets/vendors/css/tables/datatable/responsive.bootstrap5.min.css">
<link rel="stylesheet" type="text/css" href="/assets/vendors/css/tables/datatable/buttons.bootstrap5.min.css">
<link rel="stylesheet" type="text/css" href="/assets/vendors/css/tables/datatable/rowGroup.bootstrap5.min.css">
<style>
    .modal-table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    .modal-table td,
    .modal-table th {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
    }

    .modal-table tr:nth-child(even) {
        background-color: #dddddd;
    }
</style>
@endpush