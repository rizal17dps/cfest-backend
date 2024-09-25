<?php

namespace App\Http\Controllers\Api\Master;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\JadwalKuliah;
use App\ResponseFormater;

class JadwalKuliahController extends Controller
{
    //
    public function index()
    {
        $result = JadwalKuliah::orderBy('id', 'asc')->get();
        $data = [];
        if ($result->isEmpty()) {
            return ResponseFormater::success(204);
        } else {
            foreach ($result as $hasil) {
                array_push($data, [
                    'id' => $hasil->id, 
                    'mk_name' => $hasil->matkul->name, 
                    'room_name' => $hasil->ruangan->name, 
                    'time_start' => $hasil->start_time,
                    'time_end' => $hasil->end_time,
                    'day' => $hasil->day,
                    'sks' => $hasil->matkul->sks,
                    'quota' => $hasil->capacity,
                    'academic_year' => $hasil->semester->tahun_ajar,
                ]);
            }

            return ResponseFormater::success(200, $data, 'Success', $result->count());
        }
    }

    public function get($id)
    {
        $result = JadwalKuliah::find($id);

        if (!$result) {
            return ResponseFormater::success(204);
        } else {
            array_push($data, [
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
            return ResponseFormater::success(200, $data, 'Success', $result->count());
        }
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            request()->validate([
                'collage_id' => ['required', 'integer'],
                'faculty_id' => ['required', 'integer'],
                'academic_id' => ['required', 'integer'],
                'room_id' => ['required', 'integer'],
                'lecture_id' => ['required', 'integer'],
                'course_id' => ['required', 'integer'],
                'semester_id' => ['required', 'integer'],
                'day' => ['required', 'string'],
                'start_time' => ['required', 'date_format:H:i'],
                'end_time' => ['required', 'date_format:H:i', 'after:start_time'],
                'capacity' => ['required', 'integer'],
            ]);

            $insert = new JadwalKuliah();
            $insert->collage_id = $request->collage_id;
            $insert->faculty_id = $request->faculty_id;
            $insert->academic_id = $request->academic_id;
            $insert->room_id = $request->room_id;
            $insert->lecture_id = $request->lecture_id;
            $insert->course_id = $request->course_id;
            $insert->semester_id = $request->semester_id;
            $insert->day = $request->day;
            $insert->start_time = $request->start_time;
            $insert->end_time = $request->end_time;
            $insert->capacity = $request->capacity;
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
                'collage_id' => ['required', 'integer'],
                'faculty_id' => ['required', 'integer'],
                'academic_id' => ['required', 'integer'],
                'room_id' => ['required', 'integer'],
                'lecture_id' => ['required', 'integer'],
                'course_id' => ['required', 'integer'],
                'semester_id' => ['required', 'integer'],
                'day' => ['required', 'string'],
                'start_time' => ['required', 'date_format:H:i'],
                'end_time' => ['required', 'date_format:H:i', 'after:start_time'],
                'capacity' => ['required', 'integer'],
            ]);

            $update = JadwalKuliah::find($id);
            if (!$update) {
                return ResponseFormater::success(204);
            }

            $update->name = $request->name;
            $update->collage_id = $request->collage_id;
            $update->faculty_id = $request->faculty_id;
            $update->academic_id = $request->academic_id;
            $update->room_id = $request->room_id;
            $update->lecture_id = $request->lecture_id;
            $update->course_id = $request->course_id;
            $update->semester_id = $request->semester_id;
            $update->day = $request->day;
            $update->start_time = $request->start_time;
            $update->end_time = $request->end_time;
            $update->capacity = $request->capacity;
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
            $update = JadwalKuliah::find($id);
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

    public function findJadwalByDosen($id){
        $results = JadwalKuliah::where('lecture_id', $id)->get();

        $data = [];
        if ($results->isEmpty()) {
            return ResponseFormater::success(204);
        } else {
            foreach($results as $result) {
                array_push($data, [
                    'id' => $result->id, 
                    'course_id' => $result->course_id, 
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
            
            return ResponseFormater::success(200, $data, 'Success', $result->count());
        }
    }
}
