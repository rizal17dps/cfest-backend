<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\Krs;
use App\Models\Presensi;
use App\Models\Mahasiswa;
use App\Models\MahasiswaPT;
use App\Models\JadwalKuliah;
use App\Models\HistoryAttendance;
use App\Models\HistoryAttendanceLecture;
use App\Utils;
use App\ResponseFormater;

class PresensiController extends Controller
{
    //
    public function generate(Request $request)
    {
        DB::beginTransaction();
        try {
            request()->validate([
                'faculty_id' => ['required', 'integer'],
                'program_id' => ['required', 'integer'],
                'schedule_id' => ['required', 'integer'],
                'lecturer_id' => ['required', 'integer'],
                'duration_minutes' => ['required', 'integer'],
                'check_location' => ['required', 'integer'],
            ]);

            $data = [];

            $fileName = 'qrcode_' . time() . '.png';
            $path = 'qrcodes/' . $fileName;
            $code = substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 6);
            $qrCodeImage = QrCode::format('png')->size(300)->generate($code);
            Storage::disk('public')->put($path, $qrCodeImage);

            $start = time();
            $end = time() + ($request->duration_minutes * 60);
            $insert = new Presensi();
            $insert->faculty_id = $request->faculty_id;
            $insert->schedule_id = $request->schedule_id;
            $insert->lecturer_id = $request->lecturer_id;
            $insert->start = $start;
            $insert->end = $end;
            $insert->check = $request->check_location;
            $insert->path = $path;
            $insert->code = $code;
            $insert->save();

            $presensi_dosen = new HistoryAttendanceLecture();
            $presensi_dosen->schedule_id = $findDetail->schedule_id;
            $presensi_dosen->lecture_id = $request->schedule_id;
            $presensi_dosen->presensi_at = date('Y-m-d h:i:s');

            array_push($data, ['qr' => base64_encode($qrCodeImage), 'expired_time' => date('Y-m-d H:i:s', $end), 'code' => $code]);

            DB::commit();

            return ResponseFormater::success(200, $data, 'Success');
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollback();
            return ResponseFormater::error(400, $e->errors(), 'Please check the parameter');
        } catch (\Exception $e) {
            DB::rollback();
            return ResponseFormater::error(400, $e->getMessage(), 'Please check the parameter');
        }
    }

    public function scanQr(Request $request)
    {
        DB::beginTransaction();
        try {
            request()->validate([
                'id_session_attendance' => ['required', 'string'],
                'nim' => ['required', 'string'],
                'ip_address' => ['required', 'string'],
                'longitude' => ['required', 'string'],
                'latitude' => ['required', 'string'],
            ]);

            $data = [];
            $cekNim = Utils::checkUser($request->nim);
            if (!$cekNim) {
                return ResponseFormater::success(204);
            }

            $findDetail = Presensi::where('code', $request->id_session_attendance)->first();
            if (!$findDetail) {
                return ResponseFormater::success(204);
            }

            $userId = MahasiswaPT::where('nim', $request->nim)->first();

            $insert = new HistoryAttendance();
            $insert->schedule_id = $findDetail->schedule_id;
            $insert->student_pt_id = $userId->id;
            $insert->presensi_at = date('Y-m-d h:i:s');
            $insert->save();

            array_push($data, ['qr' => base64_encode($qrCodeImage), 'expired_time' => date('Y-m-d H:i:s', $end), 'code' => $code]);

            DB::commit();

            return ResponseFormater::success(200, $data, 'Success');
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollback();
            return ResponseFormater::error(400, $e->errors(), 'Please check the parameter');
        } catch (\Exception $e) {
            DB::rollback();
            return ResponseFormater::error(400, $e->getMessage(), 'Please check the parameter');
        }
    }

    public function historyBySchedulerId($id)
    {
        $histories = HistoryAttendance::where('schedule_id', $id)->get();
        if($histories->isEmpty()){
            return ResponseFormater::success(204);
        }

        $data = [];
        foreach($histories as $history) {
            $mahasiswa = Mahasiswa::find($history->student_pt_id);
            array_push($data, ['nim' => $mahasiswa->nim, 'name' => $mahasiswa->name]);
        }

        return ResponseFormater::success(200, $data, 'Success');
    }

    public function historyByNim($id)
    {
        $userId = MahasiswaPT::where('nim', $id)->first();
        // Krs
        $histories = HistoryAttendance::where('student_pt_id', $userId->id)->get();
        if($histories->isEmpty()){
            return ResponseFormater::success(204);
        }

        $data = [];
        foreach($histories as $history) {
            $mahasiswa = Mahasiswa::find($history->student_pt_id);
            array_push($data, ['nim' => $mahasiswa->nim, 'name' => $mahasiswa->name]);
        }
    }
}
