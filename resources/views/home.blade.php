@extends('general')

@section('content')
<div class="row bg-dark p-3">
  <div class="col-lg-3 justify-content-between">
    <h5 class="text-light">Terdapat {{ $countService }} layanan</h5>
  </div> 
</div>

<div class="row my-3 p-3 text-decoration-none" style="row-gap: 15px;">
  @foreach ($services as $item)
  <div class="col-lg-3 justify-content-between">
    <div class="card rounded-0">
      <div class="card-body bg-secondary-subtle p-0" style="height: 25vh;">
        <img src="{{ asset('img/layanan/'.$item->foto_layanan) }}" class="w-100 h-100 object-fit-cover">
      </div>
      <div class="card-footer">
        <h4>{{ $item->nama_layanan }}</h4>
        <i class="text-secondary">
          <i class="bi bi-geo-alt"></i>
          {{ $item->lokasi_layanan }}
        </i>

        <p>
          {{ $item->deskripsi_layanan }}
        </p>

        <h5 class="text-end text-success">
          <strong>Rp {{ number_format($item->harga_layanan, 0, ',', '.') }}</strong>
        </h5>
      </div>
    </div>
  </div>
  @endforeach
</div>
@endsection
