<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\TugasAkhir;
use App\Models\TugasKuliah;
use App\Models\MahasiswaPT;
use App\Models\TugasKuliahData;
use App\Utils;
use App\ResponseFormater;

class TugasControler extends Controller
{
    //
    public function createTask(Request $request)
    {
        DB::beginTransaction();
        try {
            request()->validate([
                'kelas_kuliah_id' => ['required','integer'],
                'lecturer_id' => ['required', 'integer'],
                'start_date' => ['required', 'date'],
                'end_date' => ['required', 'date'],
                'description' => ['nullable', 'string'],
            ]);

            $insert = new TugasKuliah();
            $insert->kelas_kuliah_id = $request->kelas_kuliah_id;
            $insert->lecturer_id = $request->lecturer_id;
            $insert->start_date = $request->start_date;
            $insert->end_date = $request->end_date;
            $insert->description = $request->description;
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

    public function updateTask($id, Request $request)
    {
        DB::beginTransaction();
        try {
            request()->validate([
                'kelas_kuliah_id' => ['required','integer'],
                'lecturer_id' => ['required', 'integer'],
                'start_date' => ['required', 'date'],
                'end_date' => ['required', 'date'],
                'description' => ['nullable', 'string'],
            ]);

            $update = TugasKuliah::where('id', $id)->where('kelas_kuliah_id', $request->kelas_kuliah_id)->where('lecturer_id', $request->lecturer_id)->first();
            if (!$update) {
                return ResponseFormater::success(204);
            }
            $update->start_date = $request->start_date;
            $update->end_date = $request->end_date;
            $update->description = $request->description;
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

    public function deleteTask($id) {
        DB::beginTransaction();
        try{

            $update = TugasKuliah::find($id);
            if(!$update){
                return ResponseFormater::success(204);
            }

            $update->delete();
            $delete = TugasKuliahData::where('tugas_kuliah_id', $id)->delete();

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

    public function uploadTask(Request $request){
        DB::beginTransaction();
        try{

            request()->validate([
                'tugas_kuliah_id' => ['required','integer'],
                'student_id' => ['required', 'integer'],
                'file' => ['required', 'file', 'mimes:pdf', 'max:2048'],
            ]);

            $filename = time().'.pdf';

            $file = $request->file('file');

            $filePath = 'tugas/'. $request->student_id . '/' . $filename;

            $insert = new TugasKuliahData();
            $insert->tugas_kuliah_id = $request->tugas_kuliah_id;
            $insert->student_id = $request->student_id;
            $insert->realname = $file->getClientOriginalName();
            $insert->name = $filename;
            $insert->save();

            $disk = Storage::disk('s3');

            if ($disk->put($filePath, fopen($file, 'r+'))) {
                DB::commit();
                return ResponseFormater::success(201, 'Create', 'Success');
            } 

            return ResponseFormater::success(500, 'Error Upload Document', 'Error');

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollback();
            return ResponseFormater::error(400 ,$e->errors(), 'Please check the parameter');
        } catch(\Exception $e) {
            DB::rollback();
            return ResponseFormater::error(400, $e->getMessage(), 'Please check the parameter');
        }
    }

    public function createTugasAkhir(Request $request) {
        DB::beginTransaction();
        try {
            request()->validate([
                'name' => ['required','string'],
                'nim' => ['required', 'string'],
                'prody' => ['required', 'integer'],
                'judul' => ['required', 'strin'],
                'ringkasan' => ['nullable', 'string'],
                'document' => ['required', 'file', 'mimes:pdf', 'max:2048'],
            ]);

            $cekNim = Utils::checkUser($request->nim);
            if (!$cekNim) {
                return ResponseFormater::success(204);
            }

            $userId = MahasiswaPT::where('nim', $request->nim)->first();

            $filename = time().$request->nim.'.pdf';

            $file = $request->file('file');

            $filePath = 'tugas/'. $userId->student_id . '/' . $filename;


            $insert = new TugasAkhir();
            $insert->student_id = $userId->student_id;
            $insert->academic_program_id = $request->prody;
            $insert->title = $request->judul;
            $insert->summary = $request->ringkasan;
            $insert->status = 0;
            $insert->save();

            $disk = Storage::disk('s3');

            if ($disk->put($filePath, fopen($file, 'r+'))) {
                DB::commit();
                return ResponseFormater::success(201, 'Create', 'Success');
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

    public function listTugasAkhir(){
        
    }

    public function getTugasAkhir($id){
        $find = TugasAkhir::find($id);
        if($find){
            return ResponseFormater::success(200, $find, 'Success');
        }
        return ResponseFormater::success(204);
    }

    public function changeStatus(Request $request, $id){
       
        DB::beginTransaction();
        try {
            request()->validate([
                'status' => ['required','integer'],
                'lecture_id' => ['required','integer'],
            ]);

            $update = TugasAkhir::find($id);
            $update->status = $request->status;
            $update->lecture_id = $request->lecture_id;
            $update->save();

            return ResponseFormater::success(201, 'Create', 'Success');

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollback();
            return ResponseFormater::error(400, $e->errors(), 'Please check the parameter');
        } catch (\Exception $e) {
            DB::rollback();
            return ResponseFormater::error(400, $e->getMessage(), 'Please check the parameter');
        }
    }
}
