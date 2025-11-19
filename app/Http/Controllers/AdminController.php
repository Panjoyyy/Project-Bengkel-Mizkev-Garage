<?php

namespace App\Http\Controllers;

use App\Models\Mechanic;
use App\Models\Customer; 
use App\Models\Motor; 
use App\Models\Layanan;
use App\Models\Staff;
use App\Models\Servis;
use App\Models\Transaksi;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AdminController extends Controller
{

     public function showCreateOrder()
    {
        // gather collections and totals for the dashboard view
        $customers = Customer::all();
        $motors = Motor::all();
        $servis = Servis::all();
        $mechanics = Mechanic::all();

        $data = [
            'title'           => 'Buat Pesanan',
            'customers'       => $customers,
            'motors'          => $motors,
            'services'        => Layanan::all(),
            'mechanics'       => $mechanics,
            'staffs'          => Staff::all(),
            'servis'          => $servis,
            // totals used by the Blade view
            'totalCustomers'  => $customers->count(),
            'totalMotors'     => $motors->count(),
            'totalServis'     => $servis->count(),
            'totalMechanics'  => $mechanics->count(),
        ];
        return view('create-order', $data); // view baru: resources/views/order/create.blade.php
    }


    public function showTransaction()
    {
        $data = [
            'title'     => 'Pesanan & Transaksi',
            'Servis'    =>  Transaksi::with(['servis', 'mechanic'])->get()
        ];

        return view('management-servis', $data);
    }
}
