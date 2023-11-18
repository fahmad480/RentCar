@extends('dashboard._layouts._app')

@section('content')
<main>
    <div class="max-w-screen-2xl mx-auto p-4 md:p-6 2xl:p-10">
        <!-- Breadcrumb Start -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
            <h2 class="font-semibold text-title-md2 text-black dark:text-white">Rent List</h2>

            <nav>
                <ol class="flex items-center gap-2">
                    <li><a href="{{ route('dashboard') }}">Dashboard /</a></li>
                    <li>Rent /</li>
                    <li class="text-primary"><a href="{{ route('rent.index') }}" class="text-primary">Rent List</a></li>
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
                                <th>Car</th>
                                <th>User</th>
                                <th>Date Start</th>
                                <th>Date End</th>
                                <th>Date Return</th>
                                <th>Total</th>
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
        var formatter = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
            });

       $('#tbl_list').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ url()->current() }}',
            columns: [
                {data: 'id', name: 'id'},
                {data: 'car', name: 'car'},
                {data: 'user', name: 'user'},
                {data: 'date_start', name: 'date_start'},
                {data: 'date_end', name: 'date_end'},
                {data: 'date_return', name: 'date_return'},
                {data: 'total_price', name: 'total', render: function(data, type, full, meta){
                    return formatter.format(data);
                }},
                {data: 'status', name: 'status', render: function(data, type, full, meta){
                    if(data == "in rental") {
                        return "<span style=\"background-color: #3dd8e0; color: #fff; padding: 3px 8px; border-radius: 4px; display: inline-block;\">In Rental</span>";
                    } else if(data == "returned") {
                        return "<span style=\"background-color: #39e346; color: #fff; padding: 3px 8px; border-radius: 4px; display: inline-block;\">Returned</span>";
                    }
                }},
                {data: null, name: 'action', orderable: false, searchable: false, render: function(data, type, full, meta){
                    $output = "<a href=\"javascript:void(0)\" onClick=\"showRent('" + full.car + "', '" + full.user + "', '" + full.date_start + "', '" + full.date_end + "', '" + full.date_return + "', '" + full.total_price + "', '" + full.status + "')\" class=\"hover:text-primary\" title=\"View Details\"><i class=\"fi fi-rr-eye\"></i></a>&nbsp;&nbsp;";
                    if (full.status == "in rental" && "{{ session('role') }}" == "admin") {
                        $output += "<a href=\"javascript:void(0)\" onClick=\"returnCar(" + full.id + ")\" class=\"hover:text-primary\"> <i class=\"fi fi-rr-car-garage\" title=\"Return the Car\"></i></a>&nbsp;&nbsp;";
                    }
                    return $output;
                }},
            ]
        });
    });

    @if(session('role') == 'admin')
    function returnCar(id) {
        Swal.fire({
            title: 'Are you sure this car has been returned by the user?',
            text: 'This action cannot be undone!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, return it!',
            cancelButtonText: 'No, cancel',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('api.rent.return') }}/" + id,
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        _method: "PUT",
                    },
                    success: function(response) {
                        Swal.fire({
                            title: 'Success!',
                            text: response.message,
                            icon: 'success',
                            showCancelButton: false,
                            confirmButtonText: 'OK',
                        }).then(function() {
                            window.location.href = "{{ route('rent.index') }}";
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
    @endif

    function showRent(car, user, date_start, date_end, date_return, total, status) {
        Swal.fire({
            html: '<table class="modal-table">' +
                '    <tr>' +
                '        <td><b>Car</b></td>' +
                '        <td>' + car + '</td>' +
                '    </tr>' +
                '    <tr>' +
                '        <td><b>User</b></td>' +
                '        <td>' + user + '</td>' +
                '    </tr>' +
                '    <tr>' +
                '        <td><b>Date Start</b></td>' +
                '        <td>' + date_start + '</td>' +
                '    </tr>' +
                '    <tr>' +
                '        <td><b>Date End</b></td>' +
                '        <td>' + date_end + '</td>' +
                '    </tr>' +
                '    <tr>' +
                '        <td><b>Date Return</b></td>' +
                '        <td>' + date_return + '</td>' +
                '    </tr>' +
                '    <tr>' +
                '        <td><b>Total</b></td>' +
                '        <td>' + total + '</td>' +
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