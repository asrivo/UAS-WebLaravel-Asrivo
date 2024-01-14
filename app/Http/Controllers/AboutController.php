<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AboutController extends Controller
{
    public function index(){
        $lang_url  = public_path('admin/devicon.json');
        $lang_data = file_get_contents($lang_url);
        $lang_data = json_decode($lang_data, true);
        $lang      = array_column($lang_data, 'name');
        $lang      = '"' . implode('","', $lang) . '"';

        return view('dashboard.index')->with([
            'title' => 'About',
            'source' => $lang
        ]);
    }

    public function update(Request $request){
        $validasi = $request->validate([
            'foto'  => 'image|file|max:1024',
            'name'  => 'required',
            'email' => 'required|email',
            'telpon' => 'required|numeric',
            'alamat' => 'required',
            'keahlian' => 'required',
            'word' => 'required'    
        ],[
            'foto.image' => 'file yang anda upload bukan gambar',
            'foto.max'   => 'maximal ukuran gambar 1MB',
            'name.required' => 'Nama penulis harus ada',
            'email.required' => 'Email penulis harus ada',
            'email.email' => 'Masukkan email yang valid',
            'telpon.required' => 'No telpon harus ada',
            'telpon.numeric' => 'No telpon harus berupa angka',
            'alamat.required' => 'Alamat harus ada',
            'keahlian.required' => 'Keahlian harus ada',
            'word.required' => 'Word harus ada'
        ]);
        
        if ($request->file('foto')) {
            if ($request->fotoLama) {
                File::delete(public_path('images/') . $request->fotoLama);
            }
            $nama_foto = $request->file('foto')->hashName();
            $request->file('foto')->move(public_path('images'), $nama_foto);
            $validasi['foto'] = $nama_foto;
        }

        User::where('id', auth()->user()->id)->update($validasi);

        return back()->with('info', 'Profile penulis telah diperbarui');
    }
        

        
    
}
