<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\TugasKuliah;
use App\Models\TugasKuliahData;
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
                return ResponseFormater::success(200, 'Deleted', 'Success');
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
}
