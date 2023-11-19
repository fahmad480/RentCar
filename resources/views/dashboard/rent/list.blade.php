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
                                <li class="breadcrumb-item"><a href="#">Rent</a>
                                </li>
                                <li class="breadcrumb-item active">Rent List
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
                    $output = "<a href=\"javascript:void(0)\" onClick=\"showRent('" + full.car + "', '" + full.user + "', '" + full.date_start + "', '" + full.date_end + "', '" + full.date_return + "', '" + full.total_price + "', '" + full.status + "')\" class=\"text-primary\" title=\"View Details\"><i data-feather=\"eye\"></i></a>&nbsp;&nbsp;";
                    if (full.status == "in rental" && "{{ session('role') }}" == "admin") {
                        $output += "<a href=\"javascript:void(0)\" onClick=\"returnCar(" + full.id + ")\" class=\"text-primary\"> <i data-feather=\"corner-down-left\" title=\"Return the Car\"></i></a>&nbsp;&nbsp;";
                    }
                    return $output;
                }},
            ],
            drawCallback: function () {
                feather.replace();
            }
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