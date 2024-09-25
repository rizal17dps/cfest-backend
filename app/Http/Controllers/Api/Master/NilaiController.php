<?php

namespace App\Http\Controllers\Api\Master;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Nilai;
use App\Models\Grading;
use App\Models\Mahasiswa;
use App\Models\KelasKuliah;
use App\Models\KomponenNilai;

class NilaiController extends Controller
{
    //
    public function index()
    {
        $result = KomponenNilai::orderBy('id', 'asc')->get();
        if ($result->isEmpty()) {
            return ResponseFormater::success(204);
        } else {
            return ResponseFormater::success(200, $result, 'Success', $result->count());
        }
    }

    public function get($id)
    {
        $result = KomponenNilai::find($id);
        if (!$result) {
            return ResponseFormater::success(204);
        } else {
            return ResponseFormater::success(200, $result, 'Success', $result->count());
        }
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            request()->validate([
                'kelas_kuliah_id' => ['required', 'integer'],
                'tugas' => ['required', 'integer'],
                'presentasi' => ['required', 'integer'],
                'quiz' => ['required', 'integer'],
                'uts' => ['required', 'integer'],
                'uas' => ['required', 'integer'],
                'praktikum' => ['required', 'integer'],
                'kelompok' => ['required', 'integer'],
                'kehadiran' => ['required', 'integer'],
                'sikap' => ['required', 'integer'],
            ]);

            $insert = new KomponenNilai();
            $insert->kelas_kuliah_id = $request->kelas_kuliah_id;
            $insert->tugas = $request->tugas;
            $insert->presentasi = $request->presentasi;
            $insert->quiz = $request->quiz;
            $insert->uts = $request->uts;
            $insert->uas = $request->uas;
            $insert->praktikum = $request->praktikum;
            $insert->kelompok = $request->kelompok;
            $insert->kehadiran = $request->kehadiran;
            $insert->sikap = $request->sikap;
            $insert->save();

            DB::commit();

            return ResponseFormater::success(201, 'Create', 'Success');
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollback();
            return ResponseFormater::error(400, $e->errors(), 'Please check the parameter');
        } catch (\Exception $e) {
            DB::rollback();
            return ResponseFormater::error(400, $e->getMessage(), 'Please check the parameter');
        }
    }

    public function update($id, Request $request)
    {
        DB::beginTransaction();
        try {
            request()->validate([
                'kelas_kuliah_id' => ['required', 'integer'],
                'tugas' => ['required', 'integer'],
                'presentasi' => ['required', 'integer'],
                'quiz' => ['required', 'integer'],
                'uts' => ['required', 'integer'],
                'uas' => ['required', 'integer'],
                'praktikum' => ['required', 'integer'],
                'kelompok' => ['required', 'integer'],
                'kehadiran' => ['required', 'integer'],
                'sikap' => ['required', 'integer'],
            ]);

            $update = KomponenNilai::find($id);
            if (!$update) {
                return ResponseFormater::success(204);
            }
            $update->kelas_kuliah_id = $request->kelas_kuliah_id;
            $update->tugas = $request->tugas;
            $update->presentasi = $request->presentasi;
            $update->quiz = $request->quiz;
            $update->uts = $request->uts;
            $update->uas = $request->uas;
            $update->praktikum = $request->praktikum;
            $update->kelompok = $request->kelompok;
            $update->kehadiran = $request->kehadiran;
            $update->sikap = $request->sikap;
            $update->save();

            DB::commit();

            return ResponseFormater::success(200, 'Updated', 'Success');
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollback();
            return ResponseFormater::error(400, $e->errors(), 'Please check the parameter');
        } catch (\Exception $e) {
            DB::rollback();
            return ResponseFormater::error(400, $e->getMessage(), 'Please check the parameter');
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $update = KomponenNilai::find($id);
            if (!$update) {
                return ResponseFormater::success(204);
            }

            $update->delete();
            DB::commit();

            return ResponseFormater::success(200, 'Deleted', 'Success');
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollback();
            return ResponseFormater::error(400, $e->errors(), 'Please check the parameter');
        } catch (\Exception $e) {
            DB::rollback();
            return ResponseFormater::error(400, $e->getMessage(), 'Please check the parameter');
        }
    }

    public function createNilai($id = null)
    {
        DB::beginTransaction();
        try {
            request()->validate([
                'collage_id' => ['required', 'integer'],
                'jadwal_id' => ['required', 'integer'],
                'student_id' => ['required', 'integer'],
                'tugas' => ['required', 'integer'],
                'presentasi' => ['required', 'integer'],
                'quiz' => ['required', 'integer'],
                'uts' => ['required', 'integer'],
                'uas' => ['required', 'integer'],
                'praktikum' => ['required', 'integer'],
                'kelompok' => ['required', 'integer'],
                'kehadiran' => ['required', 'integer'],
                'sikap' => ['required', 'integer'],
            ]);

            $findGrade = Grading::where('collage_id', $request->collage_id)->first();
            $findKelasKuliah = KelasKuliah::where('course_id', $request->jadwal_id)
                ->select('id')
                ->first();
            $findKomponenNilai = KomponenNilai::where('kelas_kuliah_id', $findKelasKuliah->id);

            $nilaiTugas = $request->tugas * ($findKomponenNilai->tugas / 100);
            $nilaiPresentasi = $request->presentasi * ($findKomponenNilai->presentasi / 100);
            $nilaiQuiz = $request->quiz * ($findKomponenNilai->quiz / 100);
            $nilaiUts = $request->uts * ($findKomponenNilai->uts / 100);
            $nilaiUas = $request->uas * ($findKomponenNilai->uas / 100);
            $nilaiPraktikum = $request->praktikum * ($findKomponenNilai->praktikum / 100);
            $nilaiKelompok = $request->kelompok * ($findKomponenNilai->kelompok / 100);
            $nilaiKehadiran = $request->kehadiran * ($findKomponenNilai->kehadiran / 100);
            $nilaiSikap = $request->sikap * ($findKomponenNilai->sikap / 100);

            $total = $nilaiTugas + $nilaiPresentasi + $nilaiQuiz + $nilaiUts + $nilaiUas + $nilaiPraktikum + $nilaiKelompok + $nilaiKehadiran + $nilaiSikap;

            $grade = Grading::where('min', '<=', $total)->where('max', '>=', $total)->first();

            if ($id) {
                $insert = new Nilai();
            } else {
                $insert = Nilai::find($id);
            }

            $insert->course_id = $request->jadwal_id;
            $insert->student_id = $request->student_id;
            $insert->tugas = $nilaiTugas;
            $insert->presentasi = $nilaiPresentasi;
            $insert->quiz = $nilaiQuiz;
            $insert->uts = $nilaiUts;
            $insert->uas = $nilaiUas;
            $insert->praktikum = $nilaiPraktikum;
            $insert->kelompok = $nilaiKelompok;
            $insert->kehadiran = $nilaiKehadiran;
            $insert->sikap = $nilaiSikap;
            $insert->total = $total;
            $insert->grade = $grade->grade;
            $insert->save();

            DB::commit();

            return ResponseFormater::success(201, 'Create', 'Success');
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollback();
            return ResponseFormater::error(400, $e->errors(), 'Please check the parameter');
        } catch (\Exception $e) {
            DB::rollback();
            return ResponseFormater::error(400, $e->getMessage(), 'Please check the parameter');
        }
    }

    public function deleteNilai($id)
    {
        DB::beginTransaction();
        try{
            $update = Nilai::find($id);
            if(!$update){
                return ResponseFormater::success(204);
            }

            $update->delete();
            DB::commit();

            return ResponseFormater::success(200, 'Deleted', 'Success');
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollback();
            return ResponseFormater::error(400 ,$e->errors(), 'Please check the parameter');
        } catch(\Exception $e) {
            DB::rollback();
            return ResponseFormater::error(400, $e->getMessage(), 'Please check the parameter');
        }
    }

    public function viewByNim($course_id, $nim) {
        $userId = Mahasiswa::where('nim', $nim)->first();
        $result = Nilai::where('student_id', $userId->id)->where('course_id', $course_id)->first();
        if (!$result) {
            return ResponseFormater::success(204);
        } else {
            return ResponseFormater::success(200, $result, 'Success', $result->count());
        }
    }

    public function khs(){
        
    }
}
