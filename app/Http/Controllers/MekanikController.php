<?php

namespace App\Http\Controllers;
use App\Models\Mechanic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class MekanikController extends Controller
{
    
    public function showManagementMechanic()
    {
        $data = [
            'title'     => 'Manajemen Mekanik',
            'mechanics'  => Mechanic::all()
        ];
        return view('management-mechanic', $data);
    }

    public function createMechanic(Request $request)
    {
        $mechanic = new Mechanic();

        $mechanic->mechanic_name = $request->mechanic_name;
        $mechanic->mechanic_phone = $request->mechanic_phone;

        if ($request->hasFile('mechanic_image')) {
            $file = $request->file('mechanic_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('img/mechanics'), $filename);
            $mechanic->mechanic_image = $filename;
        }

        $mechanic->save();

        return back()->with('success', 'Berhasil menambahkan data mekanik');
    }

    public function updateMechanic(Request $request, $id_mechanic)
    {
        $mechanic = Mechanic::find($id_mechanic);
        $mechanic->mechanic_name = $request->mechanic_name;
        $mechanic->mechanic_phone = $request->mechanic_phone;

        if ($request->hasFile('mechanic_image')) {
            $oldImagePath = public_path('img/mechanics/' . $mechanic->mechanic_image);
            if (File::exists($oldImagePath)) {
                File::delete($oldImagePath);
            }

            $file = $request->file('mechanic_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('img/mechanics'), $filename);
            $mechanic->mechanic_image = $filename;
        }

        $mechanic->save();

        return back()->with('success', 'Berhasil memperbarui data mekanik');
    }

    public function deleteMechanic($id_mechanic)
    {
        $mechanic = Mechanic::find($id_mechanic);

        if ($mechanic && $mechanic->mechanic_image) {
            $imagePath = public_path('img/mechanics/' . $mechanic->mechanic_image);
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }

        $mechanic->delete();

        return back()->with('success', 'Berhasil menghapus data mekanik');
    }
}
