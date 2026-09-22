@extends('layouts.admin-modern')

@section('content')
<div style="background: white; min-height: calc(100vh - 60px); padding: 40px 40px 80px; overflow-x: hidden;">
    <div class="text-center">
        <!-- Logo dengan efek 2D -->
        <div class="mb-4" style="position: relative; display: inline-block;" data-aos="zoom-in">
            <div style="width: 180px; height: 180px; background: linear-gradient(145deg, #ffffff, #f0f0f0); border-radius: 25px; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15), inset 0 1px 0 rgba(255, 255, 255, 0.6); display: flex; align-items: center; justify-content: center; margin: 0 auto; position: relative; overflow: hidden; animation: float-logo 3s ease-in-out infinite;">
                <!-- Shine effect -->
                <div style="position: absolute; top: -50%; left: -50%; width: 200%; height: 200%; background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.5), transparent); animation: shine 3s infinite;"></div>
                <!-- Pulse ring -->
                <div style="position: absolute; width: 100%; height: 100%; border-radius: 25px; border: 3px solid rgba(251, 191, 36, 0.3); animation: pulse-ring 2s infinite;"></div>
                <img src="{{ asset('img/logo.jpg') }}" alt="Logo Mizkev Garage" 
                     style="width: 140px; height: 140px; border-radius: 20px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2); position: relative; z-index: 1;">
            </div>
            <p style="color: #6c757d; font-size: 0.9rem; margin-top: 15px; font-weight: 500;"><br></p>
        </div>

        <h1 style="font-size: 2rem; font-weight: 700; color: #1a2332; margin-bottom: 10px; margin-top: 20px;" data-aos="fade-up">
            Selamat Datang, Admin!
        </h1>
        
        <p style="color: #6c757d; font-weight: 400; margin-bottom: 50px;" data-aos="fade-up" data-aos-delay="100">
            Sistem Bengkel <span style="color: #fbbf24; font-weight: 600;">Mizkev Garage</span>
        </p>

        <!-- Kartu Statistik dengan 3D Effect -->
        <div class="row justify-content-center g-4" style="max-width: 1100px; margin: 0 auto; padding: 0 20px;">
            <div class="col-md-3 col-sm-6" data-aos="flip-left" data-aos-delay="100">
                <div class="stat-card" onclick="showData('customer')" style="background: linear-gradient(145deg, #3b82f6, #2563eb); padding: 40px 25px; border-radius: 20px; color: white; box-shadow: 0 10px 30px rgba(59, 130, 246, 0.4), inset 0 2px 0 rgba(255, 255, 255, 0.3); transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); transform-style: preserve-3d; perspective: 1000px; position: relative; overflow: hidden; cursor: pointer;" onmouseover="this.style.transform='translateY(-15px) rotateX(10deg) scale(1.05)'; this.style.boxShadow='0 20px 50px rgba(59, 130, 246, 0.6), inset 0 2px 0 rgba(255, 255, 255, 0.4)'" onmouseout="this.style.transform='translateY(0) rotateX(0deg) scale(1)'; this.style.boxShadow='0 10px 30px rgba(59, 130, 246, 0.4), inset 0 2px 0 rgba(255, 255, 255, 0.3)'">
                    <!-- Animated background -->
                    <div style="position: absolute; top: -50%; right: -50%; width: 200%; height: 200%; background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%); animation: rotate-bg 10s linear infinite;"></div>
                    <p style="margin: 0 0 15px 0; font-size: 1rem; opacity: 0.95; font-weight: 600; text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2); position: relative; z-index: 1;">Total Customer</p>
                    <h3 style="font-size: 3rem; font-weight: 700; margin: 0; text-shadow: 0 4px 10px rgba(0, 0, 0, 0.3); position: relative; z-index: 1;">{{ $totalCustomers }}</h3>
                    <small style="position: relative; z-index: 1; opacity: 0.9;"><i class="bi bi-hand-index"></i> Klik untuk detail</small>
                </div>
            </div>

            <div class="col-md-3 col-sm-6" data-aos="flip-left" data-aos-delay="200">
                <div class="stat-card" onclick="showData('motor')" style="background: linear-gradient(145deg, #14b8a6, #0d9488); padding: 40px 25px; border-radius: 20px; color: white; box-shadow: 0 10px 30px rgba(20, 184, 166, 0.4), inset 0 2px 0 rgba(255, 255, 255, 0.3); transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); transform-style: preserve-3d; perspective: 1000px; position: relative; overflow: hidden; cursor: pointer;" onmouseover="this.style.transform='translateY(-15px) rotateX(10deg) scale(1.05)'; this.style.boxShadow='0 20px 50px rgba(20, 184, 166, 0.6), inset 0 2px 0 rgba(255, 255, 255, 0.4)'" onmouseout="this.style.transform='translateY(0) rotateX(0deg) scale(1)'; this.style.boxShadow='0 10px 30px rgba(20, 184, 166, 0.4), inset 0 2px 0 rgba(255, 255, 255, 0.3)'">
                    <div style="position: absolute; top: -50%; right: -50%; width: 200%; height: 200%; background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%); animation: rotate-bg 10s linear infinite;"></div>
                    <p style="margin: 0 0 15px 0; font-size: 1rem; opacity: 0.95; font-weight: 600; text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2); position: relative; z-index: 1;">Total Motor</p>
                    <h3 style="font-size: 3rem; font-weight: 700; margin: 0; text-shadow: 0 4px 10px rgba(0, 0, 0, 0.3); position: relative; z-index: 1;">{{ $totalMotors }}</h3>
                    <small style="position: relative; z-index: 1; opacity: 0.9;"><i class="bi bi-hand-index"></i> Klik untuk detail</small>
                </div>
            </div>

            <div class="col-md-3 col-sm-6" data-aos="flip-left" data-aos-delay="300">
                <div class="stat-card" onclick="showData('servis')" style="background: linear-gradient(145deg, #f59e0b, #d97706); padding: 40px 25px; border-radius: 20px; color: white; box-shadow: 0 10px 30px rgba(245, 158, 11, 0.4), inset 0 2px 0 rgba(255, 255, 255, 0.3); transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); transform-style: preserve-3d; perspective: 1000px; position: relative; overflow: hidden; cursor: pointer;" onmouseover="this.style.transform='translateY(-15px) rotateX(10deg) scale(1.05)'; this.style.boxShadow='0 20px 50px rgba(245, 158, 11, 0.6), inset 0 2px 0 rgba(255, 255, 255, 0.4)'" onmouseout="this.style.transform='translateY(0) rotateX(0deg) scale(1)'; this.style.boxShadow='0 10px 30px rgba(245, 158, 11, 0.4), inset 0 2px 0 rgba(255, 255, 255, 0.3)'">
                    <div style="position: absolute; top: -50%; right: -50%; width: 200%; height: 200%; background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%); animation: rotate-bg 10s linear infinite;"></div>
                    <p style="margin: 0 0 15px 0; font-size: 1rem; opacity: 0.95; font-weight: 600; text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2); position: relative; z-index: 1;">Total Servis</p>
                    <h3 style="font-size: 3rem; font-weight: 700; margin: 0; text-shadow: 0 4px 10px rgba(0, 0, 0, 0.3); position: relative; z-index: 1;">{{ $totalServis }}</h3>
                    <small style="position: relative; z-index: 1; opacity: 0.9;"><i class="bi bi-hand-index"></i> Klik untuk detail</small>
                </div>
            </div>

            <div class="col-md-3 col-sm-6" data-aos="flip-left" data-aos-delay="400">
                <div class="stat-card" onclick="showData('mechanic')" style="background: linear-gradient(145deg, #b45309, #92400e); padding: 40px 25px; border-radius: 20px; color: white; box-shadow: 0 10px 30px rgba(180, 83, 9, 0.4), inset 0 2px 0 rgba(255, 255, 255, 0.3); transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); transform-style: preserve-3d; perspective: 1000px; position: relative; overflow: hidden; cursor: pointer;" onmouseover="this.style.transform='translateY(-15px) rotateX(10deg) scale(1.05)'; this.style.boxShadow='0 20px 50px rgba(180, 83, 9, 0.6), inset 0 2px 0 rgba(255, 255, 255, 0.4)'" onmouseout="this.style.transform='translateY(0) rotateX(0deg) scale(1)'; this.style.boxShadow='0 10px 30px rgba(180, 83, 9, 0.4), inset 0 2px 0 rgba(255, 255, 255, 0.3)'">
                    <div style="position: absolute; top: -50%; right: -50%; width: 200%; height: 200%; background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%); animation: rotate-bg 10s linear infinite;"></div>
                    <p style="margin: 0 0 15px 0; font-size: 1rem; opacity: 0.95; font-weight: 600; text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2); position: relative; z-index: 1;">Total Mekanik</p>
                    <h3 style="font-size: 3rem; font-weight: 700; margin: 0; text-shadow: 0 4px 10px rgba(0, 0, 0, 0.3); position: relative; z-index: 1;">{{ $totalMechanics }}</h3>
                    <small style="position: relative; z-index: 1; opacity: 0.9;"><i class="bi bi-hand-index"></i> Klik untuk detail</small>
                </div>
            </div>
        </div>

        <!-- Area untuk menampilkan data detail -->
        <div id="detailDataSection" style="display: none; margin-top: 50px; max-width: 1200px; margin-left: auto; margin-right: auto; padding: 0 20px;">
            <div class="card shadow-lg" style="border-radius: 20px; border: none;">
                <div class="card-header d-flex justify-content-between align-items-center" style="background: linear-gradient(145deg, #1a2332, #2d3748); color: white; border-radius: 20px 20px 0 0; padding: 20px;">
                    <h5 class="mb-0" id="detailTitle" style="font-weight: 700;">Detail Data</h5>
                    <button class="btn btn-sm btn-light" onclick="hideData()" style="border-radius: 10px;">
                        <i class="bi bi-x-lg"></i> Tutup
                    </button>
                </div>
                <div class="card-body" style="padding: 30px;">
                    <div id="detailContent">
                        <!-- Data akan dimuat di sini -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<footer style="background: #1a2332; color: white; text-align: center; padding: 20px; margin-top: 50px;">
    <p style="margin: 0; font-size: 0.9rem;">© {{ date('Y') }} Mizkev Garage. All rights reserved.</p>
</footer>

<style>
@keyframes shine {
    0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
    100% { transform: translateX(100%) translateY(100%) rotate(45deg); }
}

@keyframes float-logo {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
}

@keyframes pulse-ring {
    0% { transform: scale(1); opacity: 0.5; }
    50% { transform: scale(1.1); opacity: 0.3; }
    100% { transform: scale(1); opacity: 0.5; }
}

@keyframes rotate-bg {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.table-responsive {
    max-height: 500px;
    overflow-y: auto;
    border-radius: 10px;
}

.table-responsive::-webkit-scrollbar {
    width: 8px;
}

.table-responsive::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

.table-responsive::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 10px;
}

.table-responsive::-webkit-scrollbar-thumb:hover {
    background: #555;
}
</style>

<script>
// Data dari PHP ke JavaScript
const dataCustomers = @json($customers);
const dataMotors = @json($motors);
const dataServis = @json($servis);
const dataMechanics = @json($mechanics);

console.log('Dashboard loaded');
console.log('Total Customers:', dataCustomers.length);
console.log('Total Motors:', dataMotors.length);
console.log('Total Servis:', dataServis.length);
console.log('Total Mechanics:', dataMechanics.length);

function showData(type) {
    console.log('showData called with type:', type);
    const detailSection = document.getElementById('detailDataSection');
    const detailTitle = document.getElementById('detailTitle');
    const detailContent = document.getElementById('detailContent');
    
    // Tampilkan section
    detailSection.style.display = 'block';
    
    // Scroll ke section detail
    setTimeout(() => {
        detailSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }, 100);
    
    // Loading state
    detailContent.innerHTML = '<div class="text-center py-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>';
    
    let title = '';
    let tableHtml = '';
    
    switch(type) {
        case 'customer':
            title = 'Data Customer';
            let customerRows = '';
            if (dataCustomers.length > 0) {
                dataCustomers.forEach((customer, index) => {
                    customerRows += `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${customer.id_customer}</td>
                            <td>${customer.nama_customer}</td>
                            <td>${customer.email_customer || '-'}</td>
                            <td>${customer.no_telp_customer || '-'}</td>
                            <td>${customer.alamat_customer || '-'}</td>
                        </tr>
                    `;
                });
            } else {
                customerRows = '<tr><td colspan="6" class="text-center">Tidak ada data customer</td></tr>';
            }
            
            tableHtml = `
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead style="background: linear-gradient(145deg, #3b82f6, #2563eb); color: white;">
                            <tr>
                                <th>No</th>
                                <th>ID Customer</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>No. Telepon</th>
                                <th>Alamat</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${customerRows}
                        </tbody>
                    </table>
                </div>
            `;
            break;
            
        case 'motor':
            title = 'Data Motor';
            let motorRows = '';
            if (dataMotors.length > 0) {
                dataMotors.forEach((motor, index) => {
                    motorRows += `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${motor.id_motor}</td>
                            <td>${motor.customer ? motor.customer.nama_customer : '-'}</td>
                            <td>${motor.merk_motor}</td>
                            <td>${motor.warna_motor}</td>
                            <td>${motor.no_plat_motor}</td>
                            <td>${motor.tahun_motor}</td>
                        </tr>
                    `;
                });
            } else {
                motorRows = '<tr><td colspan="7" class="text-center">Tidak ada data motor</td></tr>';
            }
            
            tableHtml = `
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead style="background: linear-gradient(145deg, #14b8a6, #0d9488); color: white;">
                            <tr>
                                <th>No</th>
                                <th>ID Motor</th>
                                <th>Pemilik</th>
                                <th>Merk</th>
                                <th>Warna</th>
                                <th>Plat Nomor</th>
                                <th>Tahun</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${motorRows}
                        </tbody>
                    </table>
                </div>
            `;
            break;
            
        case 'servis':
            title = 'Data Servis';
            let servisRows = '';
            if (dataServis.length > 0) {
                dataServis.forEach((s, index) => {
                    const customerName = s.motor && s.motor.customer ? s.motor.customer.nama_customer : '-';
                    const motorInfo = s.motor ? `${s.motor.merk_motor} (${s.motor.no_plat_motor})` : '-';
                    const mechanicName = s.mechanic ? s.mechanic.mechanic_name : '-';
                    const keluhan = s.keluhan.length > 50 ? s.keluhan.substring(0, 50) + '...' : s.keluhan;
                    const tanggal = new Date(s.tanggal_servis).toLocaleDateString('id-ID');
                    
                    servisRows += `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${s.id_servis}</td>
                            <td>${customerName}</td>
                            <td>${motorInfo}</td>
                            <td>${mechanicName}</td>
                            <td>${keluhan}</td>
                            <td>${tanggal}</td>
                        </tr>
                    `;
                });
            } else {
                servisRows = '<tr><td colspan="7" class="text-center">Tidak ada data servis</td></tr>';
            }
            
            tableHtml = `
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead style="background: linear-gradient(145deg, #f59e0b, #d97706); color: white;">
                            <tr>
                                <th>No</th>
                                <th>ID Servis</th>
                                <th>Customer</th>
                                <th>Motor</th>
                                <th>Mekanik</th>
                                <th>Keluhan</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${servisRows}
                        </tbody>
                    </table>
                </div>
            `;
            break;
            
        case 'mechanic':
            title = 'Data Mekanik';
            let mechanicRows = '';
            if (dataMechanics.length > 0) {
                dataMechanics.forEach((mechanic, index) => {
                    mechanicRows += `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${mechanic.id_mechanic}</td>
                            <td>${mechanic.mechanic_name}</td>
                            <td>${mechanic.mechanic_phone || '-'}</td>
                        </tr>
                    `;
                });
            } else {
                mechanicRows = '<tr><td colspan="6" class="text-center">Tidak ada data mekanik</td></tr>';
            }
            
            tableHtml = `
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead style="background: linear-gradient(145deg, #b45309, #92400e); color: white;">
                            <tr>
                                <th>No</th>
                                <th>ID Mekanik</th>
                                <th>Nama</th>
                                <th>No. Telepon</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${mechanicRows}
                        </tbody>
                    </table>
                </div>
            `;
            break;
    }
    
    detailTitle.textContent = title;
    
    // Simulasi loading
    setTimeout(() => {
        detailContent.innerHTML = tableHtml;
    }, 300);
}

function hideData() {
    const detailSection = document.getElementById('detailDataSection');
    detailSection.style.display = 'none';
    window.scrollTo({ top: 0, behavior: 'smooth' });
}
</script>
@endsection
