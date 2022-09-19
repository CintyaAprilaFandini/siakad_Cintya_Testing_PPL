<?php
namespace App\Http\Controllers; 
use App\Models\Mahasiswa; 
use App\Models\Kelas;
use App\Models\mataKuliah;
use App\Models\Mahasiswa_MataKuliah;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\DB;
use PDF;


class MahasiswaController extends Controller
{
 /**
 * Display a listing of the resource.
 *
 * @return \Illuminate\Http\Response
 */
// public function index()
 //{
 //fungsi eloquent menampilkan data menggunakan pagination
 //$mahasiswa = Mahasiswa::all(); // Mengambil semua isi tabel
 //$paginate = Mahasiswa::orderBy('id_mahasiswa', 'asc')->paginate(3);
 //return view('mahasiswa.index', ['mahasiswa' => $mahasiswa,'paginate'=>$paginate]);
 //}
 public function index()
    {
        //$data = Mahasiswa::paginate(4);
        //return view('mahasiswa.index',compact('data'));
        //yang semula mahasiswa::all, diubah menjadi with() yang menyatakan relasi
        $mahasiswa = Mahasiswa::with('kelas')->get();
        $paginate = Mahasiswa::OrderBy('nim', 'asc')->paginate(3);
        return view('mahasiswa.index',['mahasiswa' =>$mahasiswa, 'paginate'=>$paginate]);
    }

 public function create()
 {
    $kelas = Kelas::all(); //mendapatkan ddata dari tabel kelas
    return view('mahasiswa.create', ['kelas' => $kelas]);
 }

 public function store(Request $request)
 {
 //melakukan validasi data
 $request->validate([
'Email' => 'required',
 'Nim' => 'required',
 'Nama' => 'required',
 'Kelas' => 'required',
 'Jurusan' => 'required',
 'TanggalLahir' => 'required',
 'Alamat' => 'required'
 ]);

 $mahasiswa = new Mahasiswa;
 $mahasiswa->email = $request->get('Email');
 $mahasiswa->nim = $request->get('Nim');
 $mahasiswa->nama = $request->get('Nama');
 $mahasiswa->jurusan = $request->get('Jurusan');
 $mahasiswa->tanggalLahir = $request->get('TanggalLahir');
 $mahasiswa->alamat = $request->get('Alamat');
//  $mahasiswa->save();

 $kelas = new Kelas;
 $kelas->id = $request->get('Kelas');

 $mahasiswa->kelas()->associate($kelas);
 $mahasiswa->save();
 //dd($request->all());
 //fungsi eloquent untuk menambah data
//  Mahasiswa::create($request->all());
 //jika data berhasil ditambahkan, akan kembali ke halaman utama
 return redirect()->route('mahasiswa.index')
 ->with('success', 'Mahasiswa Berhasil Ditambahkan');
 }

 public function show($nim)
 {
 //menampilkan detail data dengan menemukan/berdasarkan Nim Mahasiswa
 //$Mahasiswa = Mahasiswa::where('nim', $nim)->first();
 //return view('mahasiswa.detail', compact('Mahasiswa'));

 //menampilkan detail data berdasarkan nim mahasiswa
 //code sebelum dibuat relasi --> $mahasiswa = mahasiswa::find($Nim);
 $mahasiswa = Mahasiswa::With('kelas')->where('nim', $nim)->first();
 return view('mahasiswa.detail', ['Mahasiswa' => $mahasiswa]);
 }

 public function edit($nim)
 {
//menampilkan detail data dengan menemukan berdasarkan Nim Mahasiswa untuk diedit
 // $Mahasiswa = DB::table('mahasiswa')->where('nim', $nim)->first();
 // return view('mahasiswa.edit', compact('Mahasiswa'));

 //menampilkan detail data dengan menemukan berdasarkan nim mahasiswa untuk diedit
 $mahasiswa = Mahasiswa::with('kelas')->where('nim', $nim)->first();
 $kelas = Kelas::all(); //mendapatkan data dari tabel kelas
 return view('mahasiswa.edit', compact('mahasiswa', 'kelas'));
 }

 public function update(Request $request, $nim)
 {
//melakukan validasi data
 $request->validate([
'Email' =>'required',
 'Nim' => 'required',
 'Nama' => 'required',
 'Kelas' => 'required',
 'Jurusan' => 'required',
 'TanggalLahir' => 'required',
 'Alamat' => 'required'
 ]);
//fungsi eloquent untuk mengupdate data inputan kita
// Mahasiswa::where('nim', $nim)
//  ->update([
// 'email' =>$request->Email,
//  'nim'=>$request->Nim,
//  'nama'=>$request->Nama,
//  'kelas'=>$request->Kelas,
//  'jurusan'=>$request->Jurusan,
//  'tanggalLahir'=>$request-> TanggalLahir,
//  'alamat'=>$request->Alamat,
//  ]);

$mahasiswa = Mahasiswa::with('kelas')->where('nim', $nim)->first();
 $mahasiswa->email = $request->get('Email');
 $mahasiswa->nim = $request->get('Nim');
 $mahasiswa->nama = $request->get('Nama');
 $mahasiswa->jurusan = $request->get('Jurusan');
 $mahasiswa->tanggalLahir = $request->get('TanggalLahir');
 $mahasiswa->alamat = $request->get('Alamat');
//  $mahasiswa->save();

 $kelas = new Kelas;
 $kelas->id = $request->get('Kelas');

 $mahasiswa->kelas()->associate($kelas);
 $mahasiswa->save();

 if($mahasiswa->image && file_exists( storage_path('app/public/' . $mahasiswa->image))){
    Storage::delete('public/' . $mahasiswa->image);
}
$photo_name = $request->file('image')->store('images','public');
$mahasiswa->foto = $photo_name;

//jika data berhasil diupdate, akan kembali ke halaman utama
 return redirect()->route('mahasiswa.index')
 ->with('success', 'Mahasiswa Berhasil Diupdate');
 }
 
 public function destroy( $nim)
 {
//fungsi eloquent untuk menghapus data
 Mahasiswa::where('nim', $nim)->delete();
 return redirect()->route('mahasiswa.index')
 -> with('success', 'Mahasiswa Berhasil Dihapus');
 }
 
 public function nilai($nim){
    $nilai = Mahasiswa::with('kelas', 'matakuliah')->find($nim);
    return view('mahasiswa.nilai',compact('nilai'));
}

 public function search(Request $request){
            // // Get the search value from the request
            // $search = $request->input('search');
            // //dd($search);
            // // Search in the title and body columns from the posts table
            // $data = Mahasiswa::where('nim', 'LIKE', "%{$search}%")
            //     ->orWhere('nama', 'LIKE', "%{$search}%")
            //     ->paginate();
        
            // // Return the search view with the resluts compacted
            // return view('mahasiswa.search', compact('data'));
            $keyword = $request->search;

        $mahasiswa = Mahasiswa::where('nama', 'like', "%" . $keyword . "%")->paginate(5);
        return view('mahasiswa.cari', compact('mahasiswa'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
        }
        public function cetak_khs($nim){
            $mahasiswa = Mahasiswa::find($nim);
    
            $pdf= PDF::loadview('mahasiswa.khs_pdf', ['mahasiswa' => $mahasiswa]);
            return $pdf->stream();
        }
}; 