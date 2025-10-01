@extends('admin')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mt-4 border-0">
           <form method="POST" action="{{ route('handle-create-order') }}" class="card-body">
                @csrf
                <h5 class="card-title"><strong>Buat Pesanan</strong></h5>
                <p class="card-text">Pilih pelanggan, motor, dan layanan.</p>
                <hr>

                @if (session()->has('success'))
                <div class="mt-4 alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

               <div class="border border-dark p-3">
                    <div class="col-12 mt-3">
                        <label for="">Pelanggan</label>
                        <select name="id_customer" id="id_customer" class="form-control" required>
                            <option value="">--Pilih Pelanggan--</option>
                            @foreach ($customers as $item)
                            <option value="{{ $item->id_customer }}">{{ $item-> nama_customer }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 mt-3">
                        <label for="">Motor</label>
                        <select name="id_motor" id="id_motor" class="form-control" required>
                            <option value="">--Pilih Motor--</option>
                            @foreach ($motors as $motor)
                            <option value="{{ $motor->id_motor }}">
                            {{ $motor->no_plat_motor }} - {{ $motor->merk_motor }}
                            </option>
                            @endforeach
                        </select>
                        </div>

                <div class="border border-dark mt-3 p-3">
                    <div class="col-12">
                        <label>Pilih Layanan</label>
                        <div class="form-check">
                            @foreach($services as $service)
                            <div class="mb-2">
                                <input class="form-check-input" type="checkbox" name="id_service[]" value="{{ $service->id_service }}" id="service_{{ $service->id_service }}">
                                <label for="service_{{ $service->id_service }}">
                                    {{ $service->service_name }} - Rp{{ number_format($service->service_price) }}
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-12 mt-3">
                        <label for="">Mekanik</label>
                        <select name="id_mechanic" required class="form-control">
                            <option value="">--</option>
                            @foreach ($mechanics as $item)
                            <option value="{{ $item->id_mechanic }}">{{ $item->mechanic_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mt-4 text-end">
                    <button class="btn btn-success px-5"><strong>SIMPAN</strong></button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
