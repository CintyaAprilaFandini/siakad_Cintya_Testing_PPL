<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\Mahasiswa as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model; //Model Eloquent
//use App\Models\Mahasiswa;
use App\Models\mataKuliah;
use App\Models\Mahasiswa_MataKuliah;

class Mahasiswa extends Model //definisi model
{
   protected $table='mahasiswa'; //eloquent akan membuat model mahasiswa menyimpan record di tabel mahasiswa
   protected $primaryKey='nim'; //memamnggil isi DB dengan primay key
   /** 
    * 
    *
    * @var array
    */
    protected $fillable=[
        'email',
        'nim',
        'nama',
        'kelas_id',
        'jurusan',
        'tanggalLahir',
        'alamat',
    ];
    public function kelas(){
        return $this->belongsTo(Kelas::class);
    }
    public function matakuliah(){
        return $this->belongsToMany(MataKuliah::class, 'mahasiswa_matakuliah', 'mahasiswa_id', 'matakuliah_id')
            ->withPivot('nilai');
    }
}
