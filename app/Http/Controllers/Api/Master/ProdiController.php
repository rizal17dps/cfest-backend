<?php

namespace App\Http\Controllers\Api\Master;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Prodi;
use App\ResponseFormater;

class ProdiController extends Controller
{
    //
    public function index() {
        $result = Prodi::orderBy('id', 'asc')->get();
        if($result->isEmpty()){
            return ResponseFormater::success(204);
        } else {
            return ResponseFormater::success(200, $result, 'Success', $result->count());
        }
    }

    public function get($id) {
        $result = Prodi::find($id);
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
                'name' => ['required', 'string'],
                'faculty_id' => ['required', 'integer'],
                'code' => ['required', 'string'],
                'status' => ['required', 'boolean'],
                'master_of_education_id' => ['required', 'integer'],
            ]);

            $insert = new Prodi();
            $insert->name = $request->name;
            $insert->faculty_id = $request->faculty_id;
            $insert->code = $request->code;
            $insert->status = $request->status;
            $insert->master_of_education_id = $request->master_of_education_id;
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
                'name' => ['required', 'string'],
                'faculty_id' => ['required', 'integer'],
                'code' => ['required', 'string'],
                'status' => ['required', 'boolean'],
                'master_of_education_id' => ['required', 'integer'],
            ]);

            $update = Prodi::find($id);
            if(!$update){
                return ResponseFormater::success(204);
            }
            
            $update->name = $request->name;
            $update->faculty_id = $request->faculty_id;
            $update->code = $request->code;
            $update->status = $request->status;
            $update->master_of_education_id = $request->master_of_education_id;
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

            $update = Prodi::find($id);
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
