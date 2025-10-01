@extends('admin')

@section('content')
<div class="row">
    <div class="col-12 d-flex justify-content-between">
        <div class="">        
            <h5 class="card-title"><strong>{{ $title }}</strong></h5>
            <p class="card-text">Manajemen data-data layanan.</p>
        </div>
        
    </div>
</div>

<div class="row my-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Pelanggan</th>
                                <th>Nomor Telepon</th>
                                <th>Alamat</th>
                                <th>Tipe Motor</th>
                                <th>Plat Nomor</th>
                                <th>Layanan</th>
                                <th>Mekanik</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $item)
                            
                            
                            <tr style="vertical-align: middle">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->customer_name }}</td>
                                <td>{{ $item->customer_phone }}</td>
                                <td>{{ $item->customer_address }}</td>
                                <td>{{ $item->motor_type }}</td>
                                <td>{{ $item->license_plate }}</td>
                                <td>{{ $item->service->service_name  }} <strong class="text-success">[ Rp {{ number_format($item->service->service_price, 0, ',', '.') }} ]</strong></td>
                                <td>{{ $item->mechanic->mechanic_name }}</td>
                            </tr>
                            @endforeach
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection