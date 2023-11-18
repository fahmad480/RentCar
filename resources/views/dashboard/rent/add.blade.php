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
                    <li class="text-primary"><a href="{{ route('rent.store') }}" class="text-primary">{{ $title }}</a>
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
                                    Select User <span class="text-meta-1">*</span>
                                </label>
                                <div class="relative z-20 bg-white dark:bg-form-input">
                                    <span class="absolute top-1/2 left-4 z-30 -translate-y-1/2">
                                        <i class="fi fi-rr-user"></i>
                                    </span>
                                    <select name="user_id" id="user_id"
                                        class="relative z-20 w-full appearance-none rounded border border-stroke bg-transparent py-3 px-12 outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input">
                                        @foreach($users as $u)
                                        <option value="{{ $u->id }}">{{ $u->name . " (" . $u->email . ")" }}</option>
                                        @endforeach
                                    </select>
                                    <span class="absolute top-1/2 right-4 z-10 -translate-y-1/2">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <g opacity="0.8">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M5.29289 8.29289C5.68342 7.90237 6.31658 7.90237 6.70711 8.29289L12 13.5858L17.2929 8.29289C17.6834 7.90237 18.3166 7.90237 18.7071 8.29289C19.0976 8.68342 19.0976 9.31658 18.7071 9.70711L12.7071 15.7071C12.3166 16.0976 11.6834 16.0976 11.2929 15.7071L5.29289 9.70711C4.90237 9.31658 4.90237 8.68342 5.29289 8.29289Z"
                                                    fill="#637381"></path>
                                            </g>
                                        </svg>
                                    </span>
                                </div>
                            </div>

                            <div class="mb-4.5">
                                <label class="mb-2.5 block text-black dark:text-white">
                                    Select Car <span class="text-meta-1">*</span>
                                </label>
                                <div class="relative z-20 bg-white dark:bg-form-input">
                                    <span class="absolute top-1/2 left-4 z-30 -translate-y-1/2">
                                        <i class="fi fi-rr-car-side"></i>
                                    </span>
                                    <select name="car_id" id="car_id"
                                        class="relative z-20 w-full appearance-none rounded border border-stroke bg-transparent py-3 px-12 outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input">
                                        @foreach($cars as $c)
                                        <option value="{{ $c->id }}">{{ $c->brand }} {{ $c->model }} {{ $c->type
                                            }} {{ $c->seat }} seats ({{ $c->year }}) | Rp {{ number_format($c->price, 0,
                                            ',', '.') }}/day</option>
                                        @endforeach
                                    </select>
                                    <span class="absolute top-1/2 right-4 z-10 -translate-y-1/2">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <g opacity="0.8">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M5.29289 8.29289C5.68342 7.90237 6.31658 7.90237 6.70711 8.29289L12 13.5858L17.2929 8.29289C17.6834 7.90237 18.3166 7.90237 18.7071 8.29289C19.0976 8.68342 19.0976 9.31658 18.7071 9.70711L12.7071 15.7071C12.3166 16.0976 11.6834 16.0976 11.2929 15.7071L5.29289 9.70711C4.90237 9.31658 4.90237 8.68342 5.29289 8.29289Z"
                                                    fill="#637381"></path>
                                            </g>
                                        </svg>
                                    </span>
                                </div>
                            </div>

                            <div class="mb-4.5" id="car_image_info">
                                <label class="mb-2.5 block text-black dark:text-white">
                                    Car Image
                                </label>
                                <div class="relative z-20 bg-white dark:bg-form-input">
                                    <center><img src="#" id="car_image" alt="Car Image" style="max-height: 250px;">
                                    </center>
                                </div>
                            </div>

                            <div class="mb-4.5">
                                <label class="block text-black dark:text-white">
                                    Date Start <span class="text-meta-1">*</span>
                                </label>
                                <div class="mt-2.5 relative">
                                    <input type="date" id="date_start" name="date_start"
                                        class="custom-input-date custom-input-date-1 w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary">
                                </div>
                            </div>

                            <div class="mb-4.5">
                                <label class="block text-black dark:text-white">
                                    Date End <span class="text-meta-1">*</span>
                                </label>
                                <div class="mt-2.5 relative">
                                    <input type="date" id="date_end" name="date_end"
                                        class="custom-input-date custom-input-date-1 w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary">
                                </div>
                            </div>

                            <div class="mb-4.5">
                                <label class="mb-2.5 block text-black dark:text-white">
                                    Estimated Price
                                </label>
                                <input type="text" placeholder="Estimated Price" id="estimated_price" readonly
                                    name="estimated_price" class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium
                                outline-none transition focus:border-primary active:border-primary
                                disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark
                                dark:bg-form-input dark:focus:border-primary">
                            </div>

                            <button class="flex w-full justify-center rounded bg-primary p-3 font-medium text-gray"
                                id="addnewrent">
                                {{ $menu === "rentUpdate" ? "Update Rent Information" : "Rent a Car" }}
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
    $(document).ready(function() {
        $("#car_image_info").hide();
        show_car_image();
    });

    $("#addnewrent").click(function(e) {
        e.preventDefault();
        var date_start = $("#date_start").val();
        var date_end = $("#date_end").val();
        var car_id = $("#car_id").val();
        var user_id = $("#user_id").val();

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
        var user_id = $("#user_id").val();

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
                $("#car_image_info").show();
                $("#car_image").attr("src", response.data.image);
            },
        });
    }
</script>
@endpush

@push('styles')
@endpush