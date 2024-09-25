<?php

namespace App\Http\Controllers\Api\Master;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Grading;
use App\ResponseFormater;

class GradingController extends Controller
{
    //
    public function index() {
        $result = Grading::orderBy('id', 'asc')->get();
        if($result->isEmpty()){
            return ResponseFormater::success(204);
        } else {
            return ResponseFormater::success(200, $result, 'Success', $result->count());
        }
    }

    public function get($id) {
        $result = Grading::find($id);
        if(!$result){
            return ResponseFormater::success(204);
        } else {
            return ResponseFormater::success(200, $result, 'Success', $result->count());
        }
    }

    public function store(Request $request) {
        DB::beginTransaction();
        try{
            request()->validate([
                'collage_id' => ['required', 'integer'],
                'min' => ['required', 'integer'],
                'max' => ['required', 'integer'],
                'grade' => ['required', 'string'],
                'bobot' => ['required', 'integer'],
            ]);

            $insert = new Grading();
            $insert->collage_id = $request->collage_id;
            $insert->min = $request->min;
            $insert->max = $request->max;
            $insert->grade = $request->grade;
            $insert->bobot = $request->bobot;
            $insert->save();
            
            DB::commit();

            return ResponseFormater::success(201, 'Create', 'Success');
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollback();
            return ResponseFormater::error(400 ,$e->errors(), 'Please check the parameter');
        } catch(\Exception $e) {
            DB::rollback();
            return ResponseFormater::error(400, $e->getMessage(), 'Please check the parameter');
        }
    }

    public function update($id, Request $request) {
        DB::beginTransaction();
        try{
            request()->validate([
                'collage_id' => ['required', 'integer'],
                'min' => ['required', 'integer'],
                'max' => ['required', 'integer'],
                'grade' => ['required', 'string'],
                'bobot' => ['required', 'integer'],
            ]);

            $update = Grading::find($id);
            if(!$update){
                return ResponseFormater::success(204);
            }
            
            $update->collage_id = $request->collage_id;
            $update->min = $request->min;
            $update->max = $request->max;
            $update->grade = $request->grade;
            $update->bobot = $request->bobot;
            $update->save();
            
            DB::commit();

            return ResponseFormater::success(200, 'Updated', 'Success');
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollback();
            return ResponseFormater::error(400 ,$e->errors(), 'Please check the parameter');
        } catch(\Exception $e) {
            DB::rollback();
            return ResponseFormater::error(400, $e->getMessage(), 'Please check the parameter');
        }
    }

    public function delete($id) {
        DB::beginTransaction();
        try{

            $update = Grading::find($id);
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
}
