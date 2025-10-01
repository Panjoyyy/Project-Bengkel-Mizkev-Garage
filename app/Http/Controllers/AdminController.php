<?php

namespace App\Http\Controllers;

use App\Models\Mechanic;
use App\Models\Customer; 
use App\Models\Motor; 
use App\Models\Order;
use App\Models\Layanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AdminController extends Controller
{

     public function showCreateOrder()
    {
        $data = [
            'title'     => 'Buat Pesanan',
            'customers' => Customer::all(),
            'motors'    => Motor::all(), 
            'services'  => Layanan::all(),
            'mechanics' => Mechanic::all()
        ];
        return view('create-order', $data); // view baru: resources/views/order/create.blade.php
    }

    public function createOrder(Request $request)
    {
        $request->validate([
            'id_customer' => 'required',
            'id_motor'    => 'required',
            'id_service'  => 'required|array',
            'id_mechanic' => 'required'
        ]);

        foreach ($request->id_service as $serviceId) {
            Order::create([
                'id_customer'   => $request->id_customer,
                'id_motor'      => $request->id_motor,
                'id_service'    => $serviceId,
                'id_mechanic'   => $request->id_mechanic,
                'transaction_id'=> 'MG176-' . time()
            ]);
        }

        return redirect()->route('transaction')->with('success', 'Pesanan berhasil disimpan');
    }

    public function showTransaction()
    {
        $data = [
            'title'     => 'Pesanan & Transaksi',
            'orders'    =>  Order::with(['service', 'mechanic'])->get()
        ];

        return view('transaction', $data);
    }
}
