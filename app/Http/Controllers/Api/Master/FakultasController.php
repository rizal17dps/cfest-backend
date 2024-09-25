<?php

namespace App\Http\Controllers\Api\Master;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Fakultas;
use App\ResponseFormater;

class FakultasController extends Controller
{
    //
    public function index() {
        $result = Fakultas::orderBy('id', 'asc')->get();
        if($result->isEmpty()){
            return ResponseFormater::success(204);
        } else {
            return ResponseFormater::success(200, $result, 'Success', $result->count());
        }
    }

    public function get($id) {
        $result = Fakultas::find($id);
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
                'name' => ['required', 'string'],
                'code' => ['required', 'string'],
                'description' => ['required', 'string'],
            ]);

            $insert = new Fakultas();
            $insert->collage_id = $request->collage_id;
            $insert->name = $request->name;
            $insert->code = $request->code;
            $insert->description = $request->description;
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
                'name' => ['required', 'string'],
                'code' => ['required', 'string'],
                'description' => ['required', 'string'],
            ]);

            $update = Fakultas::find($id);
            if(!$update){
                return ResponseFormater::success(204);
            }
            
            $update->collage_id = $request->collage_id;
            $update->name = $request->name;
            $update->code = $request->code;
            $update->description = $request->description;
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

            $update = Fakultas::find($id);
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
