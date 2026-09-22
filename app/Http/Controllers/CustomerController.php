<?php

namespace App\Http\Controllers;
use App\Models\Customer;
use App\Models\Layanan; 
use App\Models\Service;
use Illuminate\Http\Request;

class CustomerController extends Controller
{

    public function showHomeCustomer()
    {
    // Ambil data dari tabel layanan
    $services = Layanan::all();

    $data = [
        'title' => 'Home Customer',
        'services' => $services,
        'countService' => $services->count()
    ];

    return view('home-modern', $data);
    }

    // Management Customer
    public function showManagementCustomer(Request $request)
    {
        $search = $request->input('search');
        $query = Customer::query();

    if ($search) {
        $customers = $query->where('nama_customer', 'like', "%{$search}%")
            ->orWhere('id_customer', 'like', "%{$search}%")
            ->get();

        if ($customers->count() > 0) {
            $message = "Data ID/Nama customer '{$search}' berhasil ditemukan.";
            $alertType = 'success';
        } else {
            $message = "Tidak ada hasil untuk pencarian '{$search}'.";
            $alertType = 'warning';
        }
    } else {
        $customers = Customer::all();
        $message = null;
        $alertType = null;
    }

    $data = [
        'title'     => 'Manajemen Kelola Customer',
        'customers' => $customers,
        'message'   => $message,
        'alertType' => $alertType
    ];

    return view('management-customer', $data);
    }

    // Tambah customer
    // Tampilkan halaman tambah customer
    public function createCustomer()
    {
    $title = 'Tambah Customer';
    return view('create-customer', compact('title'));
    }

    public function store(Request $request)
{
    $request->validate([
        'nama_customer' => 'required|string|max:255',
        'no_telp_customer' => 'required|string|max:15',
        'alamat_customer' => 'required|string|max:255',
        'email_customer' => 'required|email|max:255',
    ]);

    $customer = new Customer();
    $customer->id_customer = Customer::generateCustomerId();
    $customer->nama_customer = $request->nama_customer;
    $customer->no_telp_customer = $request->no_telp_customer;
    $customer->alamat_customer = $request->alamat_customer;
    $customer->email_customer = $request->email_customer;
    $customer->save();

    return redirect()->route('management-customer')
                     ->with('success', 'Berhasil menambahkan data customer');
}

// Tampilkan halaman edit
public function edit($id_customer)
{
    $customer = Customer::findOrFail($id_customer);
    return view('edit-customer', compact('customer'))->with('title', 'Edit Customer');
}

// Update data customer
public function updateCustomer(Request $request, $id_customer)
{
    $request->validate([
        'nama_customer' => 'required|string|max:255',
        'no_telp_customer' => 'required|string|max:20',
        'alamat_customer' => 'required|string|max:255',
        'email_customer' => 'required|email|max:255',
    ]);

    $customer = Customer::findOrFail($id_customer);
    $customer->nama_customer = $request->nama_customer;
    $customer->no_telp_customer = $request->no_telp_customer;
    $customer->alamat_customer = $request->alamat_customer;
    $customer->email_customer = $request->email_customer;
    $customer->save();

    return redirect()->route('management-customer')
                     ->with(['message' => 'Customer berhasil diupdate!', 'alertType' => 'success']);
}

    // Hapus customer
    public function deleteCustomer($id_customer)
    {
    $customer = Customer::find($id_customer);
    $customer->delete();

    return back()->with('success', 'Berhasil menghapus data customer');
    }
}
