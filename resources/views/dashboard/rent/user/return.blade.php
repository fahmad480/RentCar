@extends('dashboard._layouts._app')

@section('content')
<main>
    <div class="max-w-screen-2xl mx-auto p-4 md:p-6 2xl:p-10">
        <!-- Breadcrumb Start -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
            <h2 class="font-semibold text-title-md2 text-black dark:text-white">{{ $title }}</h2>

            <nav>
                <ol class="flex items-center gap-2">
                    <li><a href="{{ route('dashboard') }}">Dashboard /</a></li>
                    <li>Rent /</li>
                    <li class="text-primary"><a href="{{ route('rent.return') }}" class="text-primary">{{ $title }}</a>
                    </li>
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
                    <form>
                        <div class="p-6.5">
                            <div class="mb-4.5">
                                <label class="mb-2.5 block text-black dark:text-white">
                                    Enter License Plate Number <span class="text-meta-1">*</span>
                                </label>
                                <input type="text" placeholder="Enter License Plate Number" id="license_plate"
                                    name="license_plate" class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium
                                outline-none transition focus:border-primary active:border-primary
                                disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark
                                dark:bg-form-input dark:focus:border-primary">
                            </div>

                            <button class="flex w-full justify-center rounded bg-primary p-3 font-medium text-gray"
                                id="returnCar">
                                Return the Car
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- ====== Table One End -->
        </div>
        <!-- ====== Table Section End -->
    </div>
</main>
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