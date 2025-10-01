<?php

namespace App\Http\Controllers;
use App\Models\Customer;
use App\Models\Layanan; 
use App\Models\Service;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function showHome()
    {
        $data = [
            'title'     => 'Beranda',
            'services'  => Layanan::all(),
            'countService' => Layanan::count(),
        ];

        return view('home', $data);
    }

    // Management Customer
    public function showManagementCustomer()
    {
    $data = [
        'title'     => 'Manajemen Customer',
        'customers' => Customer::all()
    ];
    return view('management-customer', $data);
    }

    // Tambah customer
    public function createCustomer(Request $request)
    {
    $customer = new Customer();

    $customer->nama_customer = $request->nama_customer;
    $customer->no_telp_customer = $request->no_telp_customer;
    $customer->alamat_customer = $request->alamat_customer;
    $customer->email_customer = $request->email_customer;

    $customer->save();

    return back()->with('success', 'Berhasil menambahkan data customer');
    }

    // Update customer
    public function updateCustomer(Request $request, $id_customer)
    {
    $customer = Customer::find($id_customer);

    $customer->nama_customer = $request->nama_customer;
    $customer->no_telp_customer = $request->no_telp_customer;
    $customer->alamat_customer = $request->alamat_customer;
    $customer->email_customer = $request->email_customer;

    $customer->save();

    return back()->with('success', 'Berhasil memperbarui data customer');
    }

    // Hapus customer
    public function deleteCustomer($id_customer)
    {
    $customer = Customer::find($id_customer);
    $customer->delete();

    return back()->with('success', 'Berhasil menghapus data customer');
    }

     public function showCreateOrder()
    {
        $data = [
            'title'     => 'Buat Pesanan',
            'customers' => Customer::all(),
            'motors'    => Motor::all(), 
            'services'  => Service::all(),
            'mechanics' => Mechanic::all()
        ];
        return view('create-order', $data); // view baru: resources/views/order/create.blade.php
    }
   
}
