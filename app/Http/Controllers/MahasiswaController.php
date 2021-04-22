<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\Mahasiswa_MataKuliah;
use Illuminate\Support\Facades\Storage;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $mahasiswas = Mahasiswa::all(); // Mengambil semua isi tabel
        // $mahasiswas = Mahasiswa::where([
            // Nomor2
    //     //     ['Nama', '!=', Null]
    //     // ])->orderBy("Nim", "asc")->paginate(5);
    //     // $posts = Mahasiswa::orderBy('Nim', 'desc')->paginate(6);

    //     // Nomor 3
    //     ['Nama', '!=', Null],
    //         [function ($query) use ($request) {
    //             if (($term = $request->term)) {
    //                 $query->orWhere('Nama', 'LIKE', '%' . $term . '%')->get();
    //             }
    //         }]
    //     ])
    //         ->orderBy("Nim", "asc")
    //         ->paginate(3);
    //     return view('mahasiswas.index', compact('mahasiswas'))
    //    ->with('i', (request()->input('page', 1) - 1) * 5);

    //fungsi eloquent menampilkan data menggunakan pagination
    if($request->has('search')){
        $mahasiswas = Mahasiswa::where('Nama', 'like', "%".$request->search."%")
            ->orWhere('Nim', $request->search)
            ->paginate(3);
    } else {
        // fungsi eloquent menampilkan data menggunakan pagination
        $mahasiswas = Mahasiswa::paginate(3);
     }
    return view('mahasiswas.index', compact('mahasiswas'));
     }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kelas = Kelas::all();
        return view('mahasiswas.create', compact('kelas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //melakukan validasi data
        $request->validate([
            'Nim' => 'required',
            'Nama' => 'required',
            'Foto_Profil' => 'required',
            'Kelas' => 'required',
            'Jurusan' => 'required',
            'No_Handphone' => 'required',
            'Email' => 'required',
            'Tanggal_Lahir' => 'required',
        ]);

        if ($request->file('image')) {
            $image_name = $request->file('image')->store('images', 'public');
        }

        //fungsi eloquent untuk menambah data
        $mahasiswa = new Mahasiswa;
        $mahasiswa->nim = $request->get('Nim');
        $mahasiswa->nama = $request->get('Nama');
        $mahasiswa->foto_profil = $image_name;
        $mahasiswa->kelas_id = $request->get('Kelas');
        $mahasiswa->jurusan = $request->get('Jurusan');
        $mahasiswa->no_handphone = $request->get('No_Handphone');
        $mahasiswa->email = $request->get('Email');
        $mahasiswa->tanggal_Lahir = $request->get('Tanggal_Lahir');
        $mahasiswa->save();

        $kelas = new Kelas;
        $kelas->id = $request->get('Kelas');

        //fungsi eloquent untuk menambah data dengan relasi belongsTo

        $mahasiswa->kelas()->associate($kelas);
        $mahasiswa->save();

        //fungsi eloquent untuk menambah data
        // Mahasiswa::create($request->all());

        //jika data berhasil ditambahkan, akan kembali ke halaman utama
        return redirect()->route('mahasiswas.index')
            ->with('success', 'Mahasiswa Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($Nim)
    {
         //menampilkan detail data dengan menemukan/berdasarkan Nim Mahasiswa
        //  $Mahasiswa = Mahasiswa::find($Nim);
        //  return view('mahasiswas.detail', compact('Mahasiswa'));

        //menampilkan detail data dengan menemukan/berdasarkan Nim Mahasiswa
        $Mahasiswa = Mahasiswa::with('kelas')->where('Nim' , $Nim)->first();
        return view('mahasiswas.detail', ['Mahasiswa' => $Mahasiswa]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($Nim)
    {
        // //menampilkan detail data dengan menemukan berdasarkan Nim Mahasiswa untuk diedit
        // $Mahasiswa = Mahasiswa::find($Nim);
        // return view('mahasiswas.edit', compact('Mahasiswa'));

        //menampilkan detail data dengan menemukan berdasarkan Nim Mahasiswa untuk diedit
        $mahasiswa=Mahasiswa::find($Nim);
        $kelas = Kelas::all();
        return view('mahasiswas.edit',compact('mahasiswa', 'kelas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $Nim)
    {
        //melakukan validasi data
        $request->validate([
            'Nim' => 'required',
            'Nama' => 'required',
            'image' => 'required',
            'Kelas' => 'required',
            'Jurusan' => 'required',
            'No_Handphone' => 'required',
            'Email' => 'required',
            'Tanggal_Lahir' => 'required',
        ]);
        
        $mahasiswa = Mahasiswa::with('kelas')->where('Nim' , $Nim)->first();
        if ($request->file('image') != null && $mahasiswa->foto_profil && file_exists(storage_path('app/public/' . $mahasiswa->foto_profil))) {
            Storage::delete(['public/'. $mahasiswa->foto_profil]);
            $image_name = $request->file('image')->store('image', 'public');
        } elseif ($request->file('image') != null) {
            $image_name = $request->file('image')->store('image', 'public');
        }
        else {
            $image_name = $mahasiswa->foto_profil;
        }
        $mahasiswa->nim = $request->get('Nim');
        $mahasiswa->nama = $request->get('Nama');
        $mahasiswa->foto_profil = $image_name;
        $mahasiswa->kelas_id = $request->get('Kelas');
        $mahasiswa->jurusan = $request->get('Jurusan');
        $mahasiswa->no_handphone = $request->get('No_Handphone');
        $mahasiswa->email = $request->get('Email');
        $mahasiswa->Tanggal_Lahir = $request->get('Tanggal_Lahir');
        $mahasiswa->save();

        $kelas = new Kelas;
        $kelas->id = $request->get('Kelas');
        //fungsi eloquent untuk mengupdate data inputan kita
        $mahasiswa->kelas()->associate($kelas);
        $mahasiswa->save();

        //jika data berhasil diupdate, akan kembali ke halaman utama
            return redirect()->route('mahasiswas.index')
            ->with('success', 'Mahasiswa Berhasil Diupdate');

        // //fungsi eloquent untuk mengupdate data inputan kita
        // Mahasiswa::find($Nim)->update($request->all());
        // //jika data berhasil diupdate, akan kembali ke halaman utama
        // return redirect()->route('mahasiswas.index')
        // ->with('success', 'Mahasiswa Berhasil Diupdate');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($Nim)
    {
        //fungsi eloquent untuk menghapus data
        Mahasiswa::find($Nim)->delete();
        return redirect()->route('mahasiswas.index')
        -> with('success', 'Mahasiswa Berhasil Dihapus');
    }

    public function nilai($Nim){
        $mahasiswa = Mahasiswa_MataKuliah::with('mahasiswa')
            ->where('mahasiswa_id', $Nim)
            ->first();
        $nilai = Mahasiswa_MataKuliah::with('matakuliah')
            ->where('mahasiswa_id', $Nim)
            ->get();
        return view('mahasiswas.nilai', compact('mahasiswa', 'nilai'));
    }
}
