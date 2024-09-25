<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Cuti;
use App\Models\Mahasiswa;
use App\Models\MahasiswaPT;
use App\ResponseFormater;
use App\Utils;

class CutiController extends Controller
{
    //
    public function postCuti(Request $request)
    {
        DB::beginTransaction();
        try {
            request()->validate([
                'nim' => ['required', 'string'],
                'prodi_id' => ['required', 'integer'],
                'alasan' => ['required', 'string'],
                'periode' => ['required', 'integer'],
                'file_pendukung' => ['required', 'file', 'mimes:doc,docx,pdf,jpg,jpeg,png', 'max:2048'],
            ]);

            $cekNim = Utils::checkUser($request->nim);
            if (!$cekNim) {
                return ResponseFormater::success(204);
            }

            $userId = MahasiswaPT::where('nim', $request->nim)->first();

            $file = $request->file('file_pendukung');
            $filename = time() . '.' . $file->getClientOriginalExtension();

            $filePath = 'cuti/' . $userId->id . '/' . $filename;

            $insert = new Cuti();
            $insert->prodi_id = $request->prodi_id;
            $insert->student_pt_id = $userId->id;
            $insert->semester_id = $request->periode;
            $insert->alasan = $request->alasan;
            $insert->realname = $file->getClientOriginalName();
            $insert->name = $filename;
            $insert->save();

            $disk = Storage::disk('s3');

            if ($disk->put($filePath, fopen($file, 'r+'))) {
                DB::commit();
                return ResponseFormater::success(200, 'Created', 'Success');
            }

            return ResponseFormater::success(500, 'Error Upload Document', 'Error');
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollback();
            return ResponseFormater::error(400, $e->errors(), 'Please check the parameter');
        } catch (\Exception $e) {
            DB::rollback();
            return ResponseFormater::error(400, $e->getMessage(), 'Please check the parameter');
        }
    }

    public function approveCuti(Request $request)
    {
        DB::beginTransaction();
        try {
            request()->validate([
                'cuti_id' => ['required', 'integer'],
                'biaya' => ['required', 'integer'],
                'notes' => ['required', 'string'],
            ]);

            $update = Cuti::where('id', $request->cuti_id)->where('status', 0)->first();
            if(!$update){
                return ResponseFormater::success(204);
            }
            $update->biaya = $request->biaya;
            $update->notes = $request->notes;
            $update->status = 1;
            $update->save();

            DB::commit();
            return ResponseFormater::success(200, 'Created', 'Success');
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollback();
            return ResponseFormater::error(400, $e->errors(), 'Please check the parameter');
        } catch (\Exception $e) {
            DB::rollback();
            return ResponseFormater::error(400, $e->getMessage(), 'Please check the parameter');
        }
    }

    public function rejectCuti(Request $request)
    {
        DB::beginTransaction();
        try {
            request()->validate([
                'cuti_id' => ['required', 'integer'],
                'notes' => ['required', 'string'],
            ]);

            $update = Cuti::where($request->cuti_id)->where('status', '0')->where()->first();
            if(!$update){
                return ResponseFormater::success(204);
            }
            $update->notes = $request->notes;
            $update->status = 3;
            $update->save();

            DB::commit();
            return ResponseFormater::success(200, 'Rejected', 'Success');
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollback();
            return ResponseFormater::error(400, $e->errors(), 'Please check the parameter');
        } catch (\Exception $e) {
            DB::rollback();
            return ResponseFormater::error(400, $e->getMessage(), 'Please check the parameter');
        }
    }

    public function cancelCuti(Request $request)
    {
        DB::beginTransaction();
        try {
            request()->validate([
                'cuti_id' => ['required', 'integer'],
            ]);

            $update = Cuti::where($request->cuti_id)->where('status', '0')->where()->first();
            if(!$update){
                return ResponseFormater::success(204);
            }
            $update->status = 2;
            $update->save();

            DB::commit();
            return ResponseFormater::success(200, 'Rejected', 'Success');
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollback();
            return ResponseFormater::error(400, $e->errors(), 'Please check the parameter');
        } catch (\Exception $e) {
            DB::rollback();
            return ResponseFormater::error(400, $e->getMessage(), 'Please check the parameter');
        }
    }

}
