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
                    <li>Car /</li>
                    <li class="text-primary"><a href="{{ route('car.store') }}" class="text-primary">{{ $title }}</a>
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
                            <div class="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                <div class="w-full xl:w-1/4">
                                    <label class="mb-2.5 block text-black dark:text-white">
                                        Brand Name <span class="text-meta-1">*</span>
                                    </label>
                                    <input type="text" placeholder="Enter car brand name" id="brand" name="brand"
                                        required autofocus value="{{ ($menu === "carUpdate") ? $car->brand :
                                    old('brand') }}"
                                    class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5
                                    font-medium outline-none transition focus:border-primary active:border-primary
                                    disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark
                                    dark:bg-form-input dark:focus:border-primary">
                                </div>

                                <div class="w-full xl:w-1/4">
                                    <label class="mb-2.5 block text-black dark:text-white">
                                        Model <span class="text-meta-1">*</span>
                                    </label>
                                    <input type="text" placeholder="Enter car model" id="model" name="model" required
                                        value="{{ ($menu === "carUpdate") ? $car->model : old('model') }}"
                                    class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5
                                    font-medium outline-none transition focus:border-primary active:border-primary
                                    disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark
                                    dark:bg-form-input dark:focus:border-primary">
                                </div>

                                <div class="w-full xl:w-1/4">
                                    <label class="mb-2.5 block text-black dark:text-white">
                                        Type <span class="text-meta-1">*</span>
                                    </label>
                                    <input type="text" placeholder="Enter car type" id="type" name="type" required
                                        value="{{ ($menu === "carUpdate") ? $car->type : old('type') }}"
                                    class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5
                                    font-medium outline-none transition focus:border-primary active:border-primary
                                    disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark
                                    dark:bg-form-input dark:focus:border-primary">
                                </div>

                                <div class="w-full xl:w-1/4">
                                    <label class="mb-2.5 block text-black dark:text-white">
                                        Seat <span class="text-meta-1">*</span>
                                    </label>
                                    <input type="text" placeholder="Enter car seat" id="seat" name="seat" required
                                        value="{{ ($menu === "carUpdate") ? $car->seat : old('seat') }}"
                                    class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5
                                    font-medium outline-none transition focus:border-primary active:border-primary
                                    disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark
                                    dark:bg-form-input dark:focus:border-primary">
                                </div>
                            </div>

                            <div class="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                <div class="w-full xl:w-1/3">
                                    <label class="mb-2.5 block text-black dark:text-white">
                                        License Plate <span class="text-meta-1">*</span>
                                    </label>
                                    <input type="text" placeholder="Enter car license plate" id="license_plate" required
                                        value="{{ ($menu === "carUpdate") ? $car->license_plate : old('license_plate')
                                    }}"
                                    name="license_plate"
                                    class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5
                                    font-medium outline-none transition focus:border-primary active:border-primary
                                    disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark
                                    dark:bg-form-input dark:focus:border-primary">
                                </div>

                                <div class="w-full xl:w-1/3">
                                    <label class="mb-2.5 block text-black dark:text-white">
                                        Color <span class="text-meta-1">*</span>
                                    </label>
                                    <input type="text" placeholder="Enter car color" id="color" name="color" required
                                        value="{{ ($menu === "carUpdate") ? $car->color : old('color') }}"
                                    class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5
                                    font-medium outline-none transition focus:border-primary active:border-primary
                                    disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark
                                    dark:bg-form-input dark:focus:border-primary">
                                </div>

                                <div class="w-full xl:w-1/3">
                                    <label class="mb-2.5 block text-black dark:text-white">
                                        Year <span class="text-meta-1">*</span>
                                    </label>
                                    <input type="text" placeholder="Enter car year" id="year" name="year" required
                                        value="{{ ($menu === "carUpdate") ? $car->year : old('year') }}"
                                    class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5
                                    font-medium outline-none transition focus:border-primary active:border-primary
                                    disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark
                                    dark:bg-form-input dark:focus:border-primary">
                                </div>
                            </div>

                            <div class="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                <div class="w-full xl:w-1/2">
                                    <label class="mb-2.5 block text-black dark:text-white">
                                        Machine Number <span class="text-meta-1">*</span>
                                    </label>
                                    <input type="text" placeholder="Enter car brand machine number" id="machine_number"
                                        required name="machine_number" value="{{ ($menu === "carUpdate") ?
                                        $car->machine_number : old('machine_number') }}"
                                    class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5
                                    font-medium outline-none transition focus:border-primary active:border-primary
                                    disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark
                                    dark:bg-form-input dark:focus:border-primary">
                                </div>

                                <div class="w-full xl:w-1/2">
                                    <label class="mb-2.5 block text-black dark:text-white">
                                        Chasis Number <span class="text-meta-1">*</span>
                                    </label>
                                    <input type="text" placeholder="Enter car chasis number" id="chasis_number" required
                                        name="chasis_number" value="{{ ($menu === "carUpdate") ? $car->chassis_number :
                                    old('chasis_number') }}"
                                    class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5
                                    font-medium outline-none transition focus:border-primary active:border-primary
                                    disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark
                                    dark:bg-form-input dark:focus:border-primary">
                                </div>
                            </div>

                            <div class="mb-4.5">
                                <label class="mb-2.5 block text-black dark:text-white">
                                    Image URL <span class="text-meta-1">*</span>
                                </label>
                                <input type="text" placeholder="Enter car image URL" id="image" name="image" required
                                    value="{{ ($menu === "carUpdate") ? $car->image : old('image') }}"
                                class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium
                                outline-none transition focus:border-primary active:border-primary
                                disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark
                                dark:bg-form-input dark:focus:border-primary">
                            </div>

                            <div class="mb-4.5">
                                <label class="mb-2.5 block text-black dark:text-white">
                                    Price per Day <span class="text-meta-1">*</span>
                                </label>
                                <input type="text" placeholder="Enter car price per day" id="price" name="price"
                                    required value="{{ ($menu === "carUpdate") ? $car->price : old('price') }}"
                                class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium
                                outline-none transition focus:border-primary active:border-primary
                                disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark
                                dark:bg-form-input dark:focus:border-primary">
                            </div>

                            <button class="flex w-full justify-center rounded bg-primary p-3 font-medium text-gray"
                                id="addnewcar">
                                {{ $menu === "carUpdate" ? "Update Car" : "Add New Car" }}
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
    $("#addnewcar").click(function(e) {
    e.preventDefault();
    var brand = $("#brand").val();
    var model = $("#model").val();
    var type = $("#type").val();
    var seat = $("#seat").val();
    var license_plate = $("#license_plate").val();
    var color = $("#color").val();
    var year = $("#year").val();
    var machine_number = $("#machine_number").val();
    var chasis_number = $("#chasis_number").val();
    var image = $("#image").val();
    var price = $("#price").val();

    $.ajax({
        url: "{{ $menu === 'carUpdate' ? route('api.car.update', $car->id) : route('api.car.store')  }}",
        type: "POST",
        data: {
            _token: '{{ csrf_token() }}',
            brand: brand,
            model: model,
            type: type,
            seat: seat,
            license_plate: license_plate,
            color: color,
            year: year,
            machine_number: machine_number,
            chassis_number: chasis_number,
            image: image,
            price: price,
            status: 'available',
            _method: '{{ $menu === "carUpdate" ? "PUT" : "POST" }}'
        },
        success: function(response) {
            Swal.fire({
                title: "Success!",
                text: "{{ ($menu === 'carUpdate') ? 'Car updated successfully!' : 'New car has been added!' }}",
                icon: "success",
                button: "OK",
            }).then(function() {
                window.location.href = "{{ route('car.index') }}";
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
</script>
@endpush

@push('styles')
@endpush