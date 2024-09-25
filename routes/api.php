<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Master\JadwalKuliahController;
use App\Http\Controllers\Api\Master\PenghasilanController;
use App\Http\Controllers\Api\Master\UniversitasController;
use App\Http\Controllers\Api\Master\PendidikanController;
use App\Http\Controllers\Api\Master\MahasiswaController;
use App\Http\Controllers\Api\Master\PekerjaanController;
use App\Http\Controllers\Api\Master\PerwalianController;
use App\Http\Controllers\Api\Master\SemesterController;
use App\Http\Controllers\Api\Master\FakultasController;
use App\Http\Controllers\Api\Master\RuanganController;
use App\Http\Controllers\Api\Master\GradingController;
use App\Http\Controllers\Api\Master\MatkulController;
use App\Http\Controllers\Api\Master\AgamaController;
use App\Http\Controllers\Api\Master\DosenController;
use App\Http\Controllers\Api\Master\ProdiController;
use App\Http\Controllers\Api\Master\NilaiController;
use App\Http\Controllers\Api\PresensiController;
use App\Http\Controllers\Api\KprsController;
use App\Http\Controllers\Api\CutiController;
use App\Http\Controllers\Api\TugasControler;
use App\Http\Controllers\Api\KrsController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('check.jwt')->group(function () {
    Route::get('/protected1', function () {
        return response()->json(['message' => 'This route is protected']);
    });

    // Define a route group with prefix
    Route::middleware('admin')->group(function () {
        Route::prefix('cuti')->group(function () {
            Route::post('/approve', [CutiController::class, 'approveCuti'])->name('approve.cuti');
            Route::post('/reject', [CutiController::class, 'rejectCuti'])->name('reject.cuti');
        });

        Route::prefix('master')->group(function () {
            Route::prefix('pekerjaan')->group(function () {
                Route::get('/', [PekerjaanController::class, 'index'])->name('pekerjaan.index');
                Route::get('/{id}', [PekerjaanController::class, 'get'])->name('pekerjaan.get');
                Route::post('/', [PekerjaanController::class, 'store'])->name('pekerjaan.post');
                Route::put('/{id}', [PekerjaanController::class, 'update'])->name('pekerjaan.update');
                Route::delete('/{id}', [PekerjaanController::class, 'delete'])->name('pekerjaan.delete');
            });
    
            Route::prefix('agama')->group(function () {
                Route::get('/', [AgamaController::class, 'index'])->name('agama.index');
                Route::get('/{id}', [AgamaController::class, 'get'])->name('agama.get');
                Route::post('/', [AgamaController::class, 'store'])->name('agama.post');
                Route::put('/{id}', [AgamaController::class, 'update'])->name('agama.update');
                Route::delete('/{id}', [AgamaController::class, 'delete'])->name('agama.delete');
            });
    
            Route::prefix('penghasilan')->group(function () {
                Route::get('/', [PenghasilanController::class, 'index'])->name('penghasilan.index');
                Route::get('/{id}', [PenghasilanController::class, 'get'])->name('penghasilan.get');
                Route::post('/', [PenghasilanController::class, 'store'])->name('penghasilan.post');
                Route::put('/{id}', [PenghasilanController::class, 'update'])->name('penghasilan.update');
                Route::delete('/{id}', [PenghasilanController::class, 'delete'])->name('penghasilan.delete');
            });
    
            Route::prefix('pendidikan')->group(function () {
                Route::get('/', [PendidikanController::class, 'index'])->name('pendidikan.index');
                Route::get('/{id}', [PendidikanController::class, 'get'])->name('pendidikan.get');
                Route::post('/', [PendidikanController::class, 'store'])->name('pendidikan.post');
                Route::put('/{id}', [PendidikanController::class, 'update'])->name('pendidikan.update');
                Route::delete('/{id}', [PendidikanController::class, 'delete'])->name('pendidikan.delete');
            });
    
            Route::prefix('universitas')->group(function () {
                Route::get('/', [UniversitasController::class, 'index'])->name('universitas.index');
                Route::get('/{id}', [UniversitasController::class, 'get'])->name('universitas.get');
                Route::post('/', [UniversitasController::class, 'store'])->name('universitas.post');
                Route::put('/{id}', [UniversitasController::class, 'update'])->name('universitas.update');
                Route::delete('/{id}', [UniversitasController::class, 'delete'])->name('universitas.delete');
            });
    
            Route::prefix('mahasiswa')->group(function () {
                Route::get('/', [MahasiswaController::class, 'index'])->name('mahasiswa.index');
                Route::get('/{id}', [MahasiswaController::class, 'get'])->name('mahasiswa.get');
                Route::post('/', [MahasiswaController::class, 'store'])->name('mahasiswa.post');
                Route::put('/{id}', [MahasiswaController::class, 'update'])->name('mahasiswa.update');
                Route::delete('/{id}', [MahasiswaController::class, 'delete'])->name('mahasiswa.delete');
            });
    
            Route::prefix('fakultas')->group(function () {
                Route::get('/', [FakultasController::class, 'index'])->name('fakultas.index');
                Route::get('/{id}', [FakultasController::class, 'get'])->name('fakultas.get');
                Route::post('/', [FakultasController::class, 'store'])->name('fakultas.post');
                Route::put('/{id}', [FakultasController::class, 'update'])->name('fakultas.update');
                Route::delete('/{id}', [FakultasController::class, 'delete'])->name('fakultas.delete');
            });
    
            Route::prefix('dosen')->group(function () {
                Route::get('/', [DosenController::class, 'index'])->name('dosen.index');
                Route::get('/{id}', [DosenController::class, 'get'])->name('dosen.get');
                Route::post('/', [DosenController::class, 'store'])->name('dosen.post');
                Route::put('/{id}', [DosenController::class, 'update'])->name('dosen.update');
                Route::delete('/{id}', [DosenController::class, 'delete'])->name('dosen.delete');
            });
    
            Route::prefix('prodi')->group(function () {
                Route::get('/', [ProdiController::class, 'index'])->name('prodi.index');
                Route::get('/{id}', [ProdiController::class, 'get'])->name('prodi.get');
                Route::post('/', [ProdiController::class, 'store'])->name('prodi.post');
                Route::put('/{id}', [ProdiController::class, 'update'])->name('prodi.update');
                Route::delete('/{id}', [ProdiController::class, 'delete'])->name('prodi.delete');
            });
    
            Route::prefix('matkul')->group(function () {
                Route::get('/', [MatkulController::class, 'index'])->name('matkul.index');
                Route::get('/{id}', [MatkulController::class, 'get'])->name('matkul.get');
                Route::post('/', [MatkulController::class, 'store'])->name('matkul.post');
                Route::put('/{id}', [MatkulController::class, 'update'])->name('matkul.update');
                Route::delete('/{id}', [MatkulController::class, 'delete'])->name('matkul.delete');
            });
    
            Route::prefix('ruangan')->group(function () {
                Route::get('/', [RuanganController::class, 'index'])->name('ruangan.index');
                Route::get('/{id}', [RuanganController::class, 'get'])->name('ruangan.get');
                Route::post('/', [RuanganController::class, 'store'])->name('ruangan.post');
                Route::put('/{id}', [RuanganController::class, 'update'])->name('ruangan.update');
                Route::delete('/{id}', [RuanganController::class, 'delete'])->name('ruangan.delete');
            });
    
            Route::prefix('semester')->group(function () {
                Route::get('/', [SemesterController::class, 'index'])->name('semester.index');
                Route::get('/{id}', [SemesterController::class, 'get'])->name('semester.get');
                Route::post('/', [SemesterController::class, 'store'])->name('semester.post');
                Route::put('/{id}', [SemesterController::class, 'update'])->name('semester.update');
                Route::delete('/{id}', [SemesterController::class, 'delete'])->name('semester.delete');
            });
    
            Route::prefix('jadwal')->group(function () {
                Route::get('/', [JadwalKuliahController::class, 'index'])->name('jadwal.index');
                Route::get('/{id}', [JadwalKuliahController::class, 'get'])->name('jadwal.get');
                Route::post('/', [JadwalKuliahController::class, 'store'])->name('jadwal.post');
                Route::put('/{id}', [JadwalKuliahController::class, 'update'])->name('jadwal.update');
                Route::delete('/{id}', [JadwalKuliahController::class, 'delete'])->name('jadwal.delete');
            });
    
            Route::prefix('perwalian')->group(function () {
                Route::get('/', [PerwalianController::class, 'index'])->name('perwalian.index');
                Route::get('/{id}', [PerwalianController::class, 'get'])->name('perwalian.get');
                Route::post('/', [PerwalianController::class, 'store'])->name('perwalian.post');
                Route::put('/{id}', [PerwalianController::class, 'update'])->name('perwalian.update');
                Route::delete('/{id}', [PerwalianController::class, 'delete'])->name('perwalian.delete');
            });
    
            Route::prefix('grading')->group(function () {
                Route::get('/', [GradingController::class, 'index'])->name('grading.index');
                Route::get('/{id}', [GradingController::class, 'get'])->name('grading.get');
                Route::post('/', [GradingController::class, 'store'])->name('grading.post');
                Route::put('/{id}', [GradingController::class, 'update'])->name('grading.update');
                Route::delete('/{id}', [GradingController::class, 'delete'])->name('grading.delete');
            });
        });
    });

    Route::middleware('student')->group(function () {
        Route::prefix('krs')->group(function () {
            Route::post('/selected', [KrsController::class, 'selected'])->name('krs.selected');
            Route::post('/submit', [KrsController::class, 'submit'])->name('krs.submit');
            Route::get('/nim/{nim}', [KrsController::class, 'get'])->name('krs.nim');
            Route::post('/acc', [KrsController::class, 'acc'])->name('krs.acc');
            Route::get('/acc/{nim}', [KrsController::class, 'accNim'])->name('krs.accNim');
            Route::get('/pay', [KrsController::class, 'pay'])->name('krs.pay');
        });

        Route::prefix('krs')->group(function () {
            Route::post('/selected', [KprsController::class, 'selected'])->name('krs.selected');
            Route::post('/submit', [KprsController::class, 'submit'])->name('krs.submit');
            Route::get('/nim/{nim}', [KprsController::class, 'get'])->name('krs.nim');
            Route::post('/acc', [KprsController::class, 'acc'])->name('krs.acc');
            Route::get('/acc/{nim}', [KprsController::class, 'accNim'])->name('krs.accNim');
        });

        Route::prefix('attendance')->group(function () {
            Route::post('/scan-qr', [PresensiController::class, 'scanQr'])->name('scanQr');
        });
        
        Route::prefix('tugas')->group(function () {
            Route::post('/upload', [TugasControler::class, 'uploadTask'])->name('tugas.upload');
        });

        Route::prefix('cuti')->group(function () {
            Route::post('/', [CutiController::class, 'postCuti'])->name('create.cuti');
            Route::post('/cancel', [CutiController::class, 'cancelCuti'])->name('cancel.cuti');
            Route::get('/student', [CutiController::class, 'cancelCuti'])->name('cancel.cuti');
        });
    });

    Route::middleware('lecture')->group(function () {
        Route::prefix('generate')->group(function () {
            Route::post('/qr', [PresensiController::class, 'generate'])->name('qr.generate');
        });

        Route::prefix('jadwal')->group(function () {
            Route::get('/kuliah/{id}', [JadwalKuliahController::class, 'findJadwalByDosen'])->name('jadwal.dosen');
            Route::get('/matkul/{id}', [MatkulController::class, 'get'])->name('matkul.get');
        });

        Route::prefix('tugas')->group(function () {
            Route::post('/', [TugasControler::class, 'createTask'])->name('tugas.create');
            Route::put('/{id}/edit', [TugasControler::class, 'updateTask'])->name('tugas.edit');
            Route::delete('/{id}/upload', [TugasControler::class, 'deleteTask'])->name('tugas.delete');
        });

        Route::prefix('attendance')->group(function () {
            Route::get('/history/{id}', [PresensiController::class, 'historyBySchedulerId'])->name('history.scheduler');
        });

        Route::prefix('nilai')->group(function () {
            Route::get('/view_nim/{course_id}/{nim}', [NilaiController::class, 'viewByNim'])->name('nilai.view.nim');
        });
    });
});
