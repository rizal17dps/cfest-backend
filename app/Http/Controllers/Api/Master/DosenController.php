<?php

namespace App\Http\Controllers\Api\Master;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Dosen;
use App\ResponseFormater;

class DosenController extends Controller
{
    //
    public function index() {
        $result = Dosen::orderBy('id', 'asc')->get();
        if($result->isEmpty()){
            return ResponseFormater::success(204);
        } else {
            return ResponseFormater::success(200, $result, 'Success', $result->count());
        }
    }

    public function get($id) {
        $result = Dosen::find($id);
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
                'nidn' => ['required', 'string'],
                'gender' => ['required', 'string'],
                'religion_id' => ['required', 'integer'],
                'date_birth' => ['required', 'date_format:Y-m-d']
            ]);

            $insert = new Dosen();
            $insert->name = $request->name;
            $insert->nidn = $request->nidn;
            $insert->gender = $request->gender;
            $insert->religion_id = $request->religion_id;
            $insert->date_birth = $request->date_birth;
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
                'nidn' => ['required', 'string'],
                'gender' => ['required', 'string'],
                'religion_id' => ['required', 'integer'],
                'date_birth' => ['required', 'date_format:Y-m-d']
            ]);

            $update = Dosen::find($id);
            if(!$update){
                return ResponseFormater::success(204);
            }
            $update->name = $request->name;
            $update->nidn = $request->nidn;
            $update->gender = $request->gender;
            $update->religion_id = $request->religion_id;
            $update->date_birth = $request->date_birth;
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

            $update = Dosen::find($id);
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
