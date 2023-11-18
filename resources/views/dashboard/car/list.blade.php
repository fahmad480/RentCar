@extends('dashboard._layouts._app')

@section('content')
<main>
    <div class="max-w-screen-2xl mx-auto p-4 md:p-6 2xl:p-10">
        <!-- Breadcrumb Start -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
            <h2 class="font-semibold text-title-md2 text-black dark:text-white">Car List</h2>

            <nav>
                <ol class="flex items-center gap-2">
                    <li><a href="{{ route('dashboard') }}">Dashboard /</a></li>
                    <li>Car /</li>
                    <li class="text-primary"><a href="{{ route('car.index') }}" class="text-primary">Car List</a></li>
                </ol>
            </nav>
        </div>
        <!-- Breadcrumb End -->

        <!-- ====== Table Section Start -->
        <div class="flex flex-col gap-10">
            <!-- ====== Table One Start -->
            <div
                class="rounded-sm border border-stroke bg-white px-5 pt-6 pb-2.5 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5 xl:pb-1">

                <div class="flex flex-col">
                    <table id="tbl_list" class="table table-striped table-bordered" cellspacing="0" width="100%">
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
            <!-- ====== Table One End -->
        </div>
        <!-- ====== Table Section End -->
    </div>
</main>
@endsection

@push('scripts')
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
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
                name: 'name',
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
                    return "<a href=\"#\" onClick=\"showCar('" + full.brand + "', '" + full.model + "', '" + full.type + "', '" + full.color + "', '" + full.year + "', '" + full.license_plate + "', '" + full.machine_number + "', '" + full.chassis_number + "', '" + full.seat + "', '" + full.price + "', '" + full.status + "')\" class=\"hover:text-primary\"><i class=\"fi fi-rr-eye\"></i></a>&nbsp;&nbsp;<a href=\"{{ route('car.update') }}/" + full.id + "\" class=\"hover:text-primary\"> <i class=\"fi fi-rr-edit\"></i></a>&nbsp;&nbsp;<a href=\"#\" onClick=\"deleteCar(" + full.id + ")\" class=\"hover:text-primary\"> <i class=\"fi fi-rr-trash\"></i></a>";
                }},
            ]
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

    function showCar(brand, model, type, color, year, license_plate, machine_number, chassis_number, seat, price, status) {
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
                '        <td>' + chassis_number + '</td>' +
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
<style>
    /* Custom styling for search input */
    .dataTables_wrapper .dataTables_filter input {
        width: 300px;
        /* Sesuaikan lebar input sesuai kebutuhan Anda */
        padding: 5px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 14px;
    }

    /* Custom styling for select input (entries per page) */
    .dataTables_wrapper .dataTables_length select {
        width: 100px;
        /* Sesuaikan lebar input sesuai kebutuhan Anda */
        padding: 5px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 14px;
    }
</style>
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