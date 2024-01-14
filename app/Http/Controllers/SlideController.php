<?php

namespace App\Http\Controllers;

use App\Models\Slide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SlideController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.slide.index')->with([
            'slides' => Slide::all(),
            'title' => 'Slide'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.slide.slide-baru')->with([
            'title' => 'Slide'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validasi = $request->validate([
            'judul' => 'required|max:50',
            'gambar' => 'image|file|max:1024',
            'kutipan' => 'required|max:255' 
        ],[
            'judul.required'   => 'Headline harus diisi',
            'judul.max'        => 'Maximal 50 karakter',
            'gambar.image'     => 'File yang anda upload bukan gambar',
            'gambar.max'       => 'Maximal ukuran gambar 1 MB',
            'kutipan.required' => 'Kutipan harus diisi',
            'kutipan.max'      => 'Maximal 255 karakter' 
        ]);

        if ($request->file('gambar')) {
            $nama_gambar = $request->file('gambar')->hashName();
            $request->file('gambar')->move(public_path('images'), $nama_gambar);
            $validasi['gambar'] = $nama_gambar;
        }

        Slide::create($validasi);

        return back()->with('info', 'Slide baru berhasil disimpan');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $slideEdit = Slide::where('id', $id)->first();
        return view('dashboard.slide.slide-edit')->with([
            'title' => 'Slide',
            'data'  => $slideEdit
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validasi = $request->validate([
            'judul' => 'required|max:50',
            'gambar' => 'image|file|max:1024',
            'kutipan' => 'required|max:255' 
        ],[
            'judul.required'   => 'Headline harus diisi',
            'judul.max'        => 'Maximal 50 karakter',
            'gambar.image'     => 'File yang anda upload bukan gambar',
            'gambar.max'       => 'Maximal ukuran gambar 1 MB',
            'kutipan.required' => 'Kutipan harus diisi',
            'kutipan.max'      => 'Maximal 255 karakter' 
        ]);
        // cek gambar
        if ($request->file('gambar')) {
            if ($request->gambarLama) {
                File::delete(public_path('images/' . $request->gambarLama));
            }
            $nama_gambar = $request->file('gambar')->hashName();
            $request->file('gambar')->move(public_path('images'), $nama_gambar);
            $validasi['gambar'] = $nama_gambar;
        }

        Slide::where('id', $id)->update($validasi);

        return redirect('/dashboard/slide')->with('info', 'Slide berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Slide::where('id', $id)->first();

        if ($data->gambar) {
            File::delete(public_path('images/').$data->gambar);
        }

        Slide::where('id', $id)->delete();

        return back()->with('info', 'Slide berhasil dihapus');
    }
}
