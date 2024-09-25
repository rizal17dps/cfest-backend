<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Krs;
use App\Models\User;
use App\Models\Perwalian;
use App\Models\MahasiswaPT;
use App\Models\JadwalKuliah;
use App\Models\KrsTransaction;
use App\Models\MappingMahasiswa;
use App\Utils;
use App\ResponseFormater;

class KprsController extends Controller
{
    //
    public function selected(Request $request)
    {
        DB::beginTransaction();
        try {
            request()->validate([
                'krs_id' => ['required', 'integer'],
                'nim' => ['required', 'string'],
            ]);

            $cekNim = Utils::checkUser($request->nim);
            if (!$cekNim) {
                return ResponseFormater::success(204);
            }

            $cekJadwal = JadwalKuliah::find($request->krs_id);
            if (!$cekJadwal) {
                return ResponseFormater::success(204);
            }

            $userId = MahasiswaPT::where('nim', $request->nim)->first();

            $getWali = Perwalian::where('student_pt_id', $userId->id)
                ->where('status', 1)
                ->first();

            $insert = new Krs();
            $insert->course_schedule_id = $request->krs_id;
            $insert->student_id_id = $userId->id;
            $insert->lecturer_id = $getWali->lecture_id;
            $insert->status = 0;
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

    public function submit(Request $request)
    {
        DB::beginTransaction();
        try {
            request()->validate([
                'krs_id' => ['required', 'array', 'min:1'],
                'nim' => ['required', 'string'],
            ]);

            $cekNim = Utils::checkUser($request->nim);
            if (!$cekNim) {
                return ResponseFormater::success(204);
            }

            foreach ($request->krs_id as $data) {
                $cekJadwal = JadwalKuliah::find($data);
                if (!$cekJadwal) {
                    return ResponseFormater::success(204);
                }

                $userId = MahasiswaPT::where('nim', $request->nim)->first();

                $update = Krs::where('course_schedule_id', $data)
                    ->where('student_pt_id', $userId->id)
                    ->where('status', 0)
                    ->first();
                $update->status = 1;
                $update->save();
            }

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

    public function get($nim)
    {
        $cekNim = Utils::checkUser($request->nim);
        if (!$cekNim) {
            return ResponseFormater::success(204);
        }

        $userId = MahasiswaPT::where('nim', $nim)->first();

        $krs = Krs::where('student_pt_id', $userId->id)
            ->where('status', 0)
            ->get();
        if ($krs->isEmpty()) {
            return ResponseFormater::success(204);
        }

        $hasil = [];

        foreach ($krs as $data) {
            $result = JadwalKuliah::find($data->course_schedule_id);
            if (!$result) {
                return ResponseFormater::success(204);
            } else {
                array_push($hasil, [
                    'id' => $result->id,
                    'mk_name' => $result->matkul->name,
                    'room_name' => $result->ruangan->name,
                    'time_start' => $result->start_time,
                    'time_end' => $result->end_time,
                    'day' => $result->day,
                    'sks' => $result->matkul->sks,
                    'quota' => $result->capacity,
                    'academic_year' => $result->semester->tahun_ajar,
                ]);
            }
        }

        return ResponseFormater::success(200, $hasil, 'Success', $result->count());
    }

    public function acc(Request $request)
    {
        DB::beginTransaction();
        try {
            request()->validate([
                'krs_id' => ['required', 'array', 'min:1'],
                'nim' => ['required', 'string'],
                'lecture_id' => ['required', 'string'],
            ]);

            $cekNim = Utils::checkUser($request->nim);
            if (!$cekNim) {
                return ResponseFormater::success(204);
            }

            $userId = MahasiswaPT::where('nim', $nim)->first();

            $cekDosen = Utils::checkUser($request->lecture_id);
            if (!$cekDosen) {
                return ResponseFormater::success(204);
            }

            foreach ($request->krs_id as $data) {
                $cekJadwal = JadwalKuliah::find($data);
                if (!$cekJadwal) {
                    return ResponseFormater::success(204);
                }

                $update = Krs::where('course_schedule_id', $data)
                    ->where('student_pt_id', $userId->id)
                    ->where('status', 1)
                    ->first();
                $update->status = 2;
                $update->approved_by = $request->lecture_id;
                $update->approved_time = date('Y-m-d h:i:s');
                $update->save();
            }
            
            $insert = new KrsTransaction();
            $insert->student_pt_id = $userId->id;
            $insert->status = 0;
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

    public function accNim($nim)
    {
        $cekNim = Utils::checkUser($request->nim);
        if (!$cekNim) {
            return ResponseFormater::success(204);
        }

        $userId = MahasiswaPT::where('nim', $nim)->first();
        $prodi = MappingMahasiswa::where('student_pt_id', $userId->id)->first();

        $data = Krs::where('student_pt_id', $userId->id)->where('status', 2);
        $jumlahSks = $data->sum('sks');
        $krs = $data->get();
        if ($krs->isEmpty()) {
            return ResponseFormater::success(204);
        }

        $getWali = Perwalian::where('student_pt_id', $userId->id)
            ->where('status', 1)
            ->first();

        $hasil = [];
        $matkul = [];
        $total = 0;

        foreach ($krs as $data) {
            $result = JadwalKuliah::find($data->course_schedule_id);
            if (!$result) {
                return ResponseFormater::success(204);
            } else {
                $total = $total + $result->matkul->price;
                array_push($matkul, [
                    'mk_name' => $result->matkul->name,
                    'mk_code' => $result->matkul->code,
                    'mk_sks' => $result->matkul->sks,
                    'mk_sks' => $result->matkul->sks,
                ]);
            }
        }

        array_push($hasil, ['name' => $userId->name, 'nim' => $userId->nim, 'prody' => $prodi->prodi->name, 'sks' => $jumlahSks, 'lecture_name' => $getWali->dosen->name, 'matkul' => $matkul, 'total_price' => $total]);

        return ResponseFormater::success(200, $hasil, 'Success', $result->count());
    }
}
