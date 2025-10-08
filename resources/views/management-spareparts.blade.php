@extends('admin')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mt-4 border-0">
            <div class="card-body">
                <h5 class="card-title"><strong>Manajemen Kelola Sparepart</strong></h5>
                <p class="card-text">Manajemen Data Sparepart.</p>
                <hr>
                {{-- Notifikasi sukses --}}
                @if(session()->has('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                {{-- Form Tambah Sparepart --}}
                <form method="POST" action="{{ route('spareparts.store') }}" class="mb-4">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label>Nama Sparepart</label>
                            <input type="text" name="nama_sparepart" class="form-control" required>
                        </div>
                        <div class="col-md-3">
                            <label>Stok</label>
                            <input type="number" name="stok_sparepart" class="form-control" required>
                        </div>
                        <div class="col-md-3">
                            <label>Harga (Rp)</label>
                            <input type="number" step="0.01" name="harga_sparepart" class="form-control" required>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn btn-success w-100">+ Tambah Sparepart</button>
                        </div>
                    </div>
                </form>

                {{-- Tabel Sparepart --}}
                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nama Sparepart</th>
                            <th>Stok</th>
                            <th>Harga</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($spareparts as $sparepart)
                            <tr>
                                <td>{{ $sparepart->id_sparepart }}</td>
                                <td>{{ $sparepart->nama_sparepart }}</td>
                                <td>{{ $sparepart->stok_sparepart }}</td>
                                <td>Rp{{ number_format($sparepart->harga_sparepart, 2, ',', '.') }}</td>
                                <td>
                                    <!-- Tombol Edit -->
                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#edit{{ $sparepart->id_sparepart }}">Edit</button>
    <div class="modal fade" id="edit{{ $sparepart->id_sparepart }}" tabindex="-1" aria-labelledby="editLabel{{ $sparepart->id_sparepart }}" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('spareparts.update', $sparepart->id_sparepart) }}" class="modal-content">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editLabel{{ $sparepart->id_sparepart }}">Edit Sparepart</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Nama Sparepart</label>
                        <input type="text" name="nama_sparepart" class="form-control" value="{{ $sparepart->nama_sparepart }}" required>
                    </div>
                    <div class="mb-3">
                        <label>Stok</label>
                        <input type="number" name="stok_sparepart" class="form-control" value="{{ $sparepart->stok_sparepart }}" required>
                    </div>
                    <div class="mb-3">
                        <label>Harga (Rp)</label>
                        <input type="number" step="0.01" name="harga_sparepart" class="form-control" value="{{ $sparepart->harga_sparepart }}" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
                                    <form action="{{ route('spareparts.destroy', $sparepart->id_sparepart) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus sparepart ini?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Belum ada data sparepart.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
@endsection
