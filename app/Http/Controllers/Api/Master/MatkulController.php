<?php

namespace App\Http\Controllers\Api\Master;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Matkul;
use App\ResponseFormater;

class MatkulController extends Controller
{
    //
    public function index() {
        $result = Matkul::orderBy('id', 'asc')->get();
        if($result->isEmpty()){
            return ResponseFormater::success(204);
        } else {
            return ResponseFormater::success(200, $result, 'Success', $result->count());
        }
    }

    public function get($id) {
        $result = Matkul::find($id);
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
                'academic_id' => ['required', 'integer'],
                'code' => ['required', 'string'],
                'sks' => ['required', 'integer'],
                'type' => ['required', 'string'],
                'price' => ['required', 'string'],
            ]);

            $insert = new Matkul();
            $insert->academic_id = $request->academic_id;
            $insert->code = $request->code;
            $insert->name = $request->name;
            $insert->sks = $request->sks;
            $insert->type = $request->type;
            $insert->price = $request->price;
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
                'academic_id' => ['required', 'integer'],
                'code' => ['required', 'string'],
                'sks' => ['required', 'integer'],
                'type' => ['required', 'string'],
                'price' => ['required', 'string'],
            ]);

            $update = Matkul::find($id);
            if(!$update){
                return ResponseFormater::success(204);
            }
            $update->academic_id = $request->academic_id;
            $update->code = $request->code;
            $update->name = $request->name;
            $update->sks = $request->sks;
            $update->type = $request->type;
            $update->price = $request->price;
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

            $update = Matkul::find($id);
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
