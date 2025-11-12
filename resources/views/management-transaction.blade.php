@extends('layouts.admin-modern')

@section('content')
<div style="background: white; min-height: calc(100vh - 60px); padding: 30px;">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4" data-aos="fade-down">
        <div>
            <h2 style="font-size: 1.8rem; font-weight: 700; color: #1a2332; margin-bottom: 5px;">
                <i class="fas fa-receipt" style="color: #3b82f6; margin-right: 10px;"></i>Manajemen Transaksi
            </h2>
            <p style="color: #6c757d; margin: 0; font-size: 0.95rem;">Kelola data transaksi servis bengkel</p>
        </div>
        <a href="{{ route('transaction.create') }}" class="btn" style="background: linear-gradient(135deg, #3b82f6, #2563eb); color: white; border: none; border-radius: 10px; padding: 12px 25px; font-weight: 600; box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);">
            <i class="fas fa-plus me-2"></i>Tambah Transaksi
        </a>
    </div>

    <!-- Search & Alert Section -->
    <div class="row mb-4">
        <div class="col-md-6" data-aos="fade-right">
            <form action="{{ route('transaction') }}" method="GET">
                <div class="input-group" style="box-shadow: 0 2px 10px rgba(0,0,0,0.08); border-radius: 10px;">
                    <input type="text" name="search" class="form-control" placeholder="Cari ID Transaksi, Customer, atau Mekanik..." style="border: 2px solid #e5e7eb; border-right: none; border-radius: 10px 0 0 10px; padding: 12px 15px;" value="{{ request('search') }}">
                    <button class="btn" type="submit" style="background: linear-gradient(135deg, #3b82f6, #2563eb); color: white; border: none; border-radius: 0 10px 10px 0; padding: 12px 25px;">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" style="border-radius: 15px; border-left: 4px solid #10b981;" data-aos="fade-down">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if($message)
    <div class="alert alert-{{ $alertType }} alert-dismissible fade show" style="border-radius: 15px; border-left: 4px solid {{ $alertType == 'success' ? '#10b981' : '#f59e0b' }};" data-aos="fade-down">
        <i class="fas fa-{{ $alertType == 'success' ? 'check-circle' : 'exclamation-triangle' }} me-2"></i>{{ $message }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Table Card -->
    <div class="card" style="border: none; border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.08);" data-aos="fade-up">
        <div class="card-body" style="padding: 0;">
            @if($servis->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover" style="margin: 0;">
                    <thead style="background: #1a2332; color: white;">
                        <tr>
                            <th style="padding: 15px; border: none; font-weight: 600;">No</th>
                            <th style="padding: 15px; border: none; font-weight: 600;">ID Transaksi</th>
                            <th style="padding: 15px; border: none; font-weight: 600;">Tanggal</th>
                            <th style="padding: 15px; border: none; font-weight: 600;">Customer</th>
                            <th style="padding: 15px; border: none; font-weight: 600;">Motor</th>
                            <th style="padding: 15px; border: none; font-weight: 600;">Mekanik</th>
                            <th style="padding: 15px; border: none; font-weight: 600;">Staff</th>
                            <th style="padding: 15px; border: none; font-weight: 600;">Keluhan</th>
                            <th style="padding: 15px; border: none; font-weight: 600; text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($servis as $index => $item)
                        <tr style="border-bottom: 1px solid #f3f4f6;">
                            <td style="padding: 15px; vertical-align: middle;">
                                <span style="background: #f3f4f6; padding: 5px 12px; border-radius: 8px; font-weight: 600; color: #1a2332;">{{ $index + 1 }}</span>
                            </td>
                            <td style="padding: 15px; vertical-align: middle;">
                                <span style="color: #3b82f6; font-weight: 600;">{{ $item->id_servis }}</span>
                            </td>
                            <td style="padding: 15px; vertical-align: middle;">
                                <i class="fas fa-calendar me-2" style="color: #6c757d;"></i>{{ date('d/m/Y H:i', strtotime($item->tanggal_servis)) }}
                            </td>
                            <td style="padding: 15px; vertical-align: middle;">
                                <div>
                                    <div style="font-weight: 600; color: #1a2332;">{{ $item->motor->customer->nama_customer }}</div>
                                    <small style="color: #6c757d;"><i class="fas fa-phone me-1"></i>{{ $item->motor->customer->no_telp_customer }}</small>
                                </div>
                            </td>
                            <td style="padding: 15px; vertical-align: middle;">
                                <div>
                                    <div style="font-weight: 600; color: #1a2332;">{{ $item->motor->merk_motor }}</div>
                                    <small style="color: #6c757d;"><i class="fas fa-id-card me-1"></i>{{ $item->motor->no_plat_motor }}</small>
                                </div>
                            </td>
                            <td style="padding: 15px; vertical-align: middle;">
                                <span style="background: #dbeafe; color: #1e40af; padding: 5px 12px; border-radius: 8px; font-size: 0.85rem; font-weight: 600;">
                                    <i class="fas fa-user-cog me-1"></i>{{ $item->mechanic->mechanic_name }}
                                </span>
                            </td>
                            <td style="padding: 15px; vertical-align: middle;">
                                <span style="background: #fef3c7; color: #92400e; padding: 5px 12px; border-radius: 8px; font-size: 0.85rem; font-weight: 600;">
                                    <i class="fas fa-user-tie me-1"></i>{{ $item->staff->staff_name }}
                                </span>
                            </td>
                            <td style="padding: 15px; vertical-align: middle; max-width: 200px;">
                                <div style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="{{ $item->keluhan }}">
                                    {{ Str::limit($item->keluhan, 50) }}
                                </div>
                            </td>
                            <td style="padding: 15px; vertical-align: middle; text-align: center;">
                                <a href="{{ route('transaction.edit', $item->id_servis) }}" class="btn btn-sm" style="background: linear-gradient(135deg, #f59e0b, #d97706); color: white; border: none; border-radius: 8px; padding: 8px 15px; margin-right: 5px;">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-danger" style="border-radius: 8px; padding: 8px 15px;" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $item->id_servis }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <!-- Empty State -->
            <div style="text-align: center; padding: 60px 20px;">
                <i class="fas fa-receipt" style="font-size: 80px; color: #1a2332; opacity: 0.3; margin-bottom: 20px;"></i>
                <h5 style="color: #1a2332; font-weight: 600; margin-bottom: 10px;">Belum Ada Transaksi</h5>
                <p style="color: #6c757d; margin-bottom: 25px;">Mulai tambahkan transaksi servis baru</p>
                <a href="{{ route('transaction.create') }}" class="btn" style="background: linear-gradient(135deg, #3b82f6, #2563eb); color: white; border: none; border-radius: 10px; padding: 12px 25px; font-weight: 600;">
                    <i class="fas fa-plus me-2"></i>Tambah Transaksi Pertama
                </a>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Delete Modals (Outside Table) -->
@foreach ($servis as $item)
<div class="modal fade" id="deleteModal{{ $item->id_servis }}" tabindex="-1" aria-labelledby="deleteLabel{{ $item->id_servis }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 20px; border: none; box-shadow: 0 10px 40px rgba(0,0,0,0.2);">
            <div class="modal-header" style="border: none; padding: 30px 30px 0;">
                <h5 class="modal-title" id="deleteLabel{{ $item->id_servis }}" style="color: #1a2332; font-weight: 700;">
                    <i class="fas fa-exclamation-circle text-danger me-2"></i>Konfirmasi Hapus
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('transaction.delete', $item->id_servis) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body" style="padding: 20px 30px;">
                    <p style="color: #6c757d; margin: 0;">
                        Apakah Anda yakin ingin menghapus transaksi <strong style="color: #1a2332;">{{ $item->id_servis }}</strong>?
                    </p>
                    <p style="color: #ef4444; margin: 10px 0 0 0; font-size: 0.9rem;">
                        <i class="fas fa-info-circle me-1"></i>Data yang dihapus tidak dapat dikembalikan!
                    </p>
                </div>
                <div class="modal-footer" style="border: none; padding: 0 30px 30px;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 10px; padding: 10px 20px;">
                        <i class="fas fa-times me-2"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-danger" style="border-radius: 10px; padding: 10px 20px;">
                        <i class="fas fa-trash me-2"></i>Ya, Hapus
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
@endsection
