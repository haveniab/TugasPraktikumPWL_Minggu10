<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\Mahasiswa as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class mahasiswa extends Model //Definisi Model
{
    protected $table="mahasiswa"; // Eloquent akan membuat model mahasiswa menyimpan record di tabel mahasiswas
    public $timestamps= false; 
    protected $primaryKey = 'Nim'; // Memanggil isi DB Dengan primarykey

    // protected $table='mahasiswa';
    // protected $primaryKey = 'nim';
    
    protected $fillable = [
        'Nim',
        'Nama',
        'Foto_Profil',
        'Kelas',
        'Jurusan',
        'No_Handphone',
        'Email',
        'Tanggal_Lahir',
        ];

        public function kelas(){
            return $this->belongsTo(Kelas::class);
        }

        public function mahasiswamatakuliah(){
            return $this->hasMany(Mahasiswa_MataKuliah::class);
        }
};
