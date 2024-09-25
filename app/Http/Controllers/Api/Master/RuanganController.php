<?php

namespace App\Http\Controllers\Api\Master;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Ruangan;
use App\ResponseFormater;

class RuanganController extends Controller
{
    //
    public function index() {
        $result = Ruangan::orderBy('id', 'asc')->get();
        if($result->isEmpty()){
            return ResponseFormater::success(204);
        } else {
            return ResponseFormater::success(200, $result, 'Success', $result->count());
        }
    }

    public function get($id) {
        $result = Ruangan::find($id);
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
                'collage_id' => ['required', 'integer'],
                'location' => ['required', 'string'],
                'capacity' => ['required', 'integer'],
                'description' => ['required', 'string'],
            ]);

            $insert = new Ruangan();
            $insert->name = $request->name;
            $insert->collage_id = $request->collage_id;
            $insert->location = $request->location;
            $insert->capacity = $request->capacity;
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
                'name' => ['required', 'string'],
                'collage_id' => ['required', 'integer'],
                'location' => ['required', 'string'],
                'capacity' => ['required', 'integer'],
                'description' => ['required', 'string'],
            ]);

            $update = Ruangan::find($id);
            if(!$update){
                return ResponseFormater::success(204);
            }
            
            $update->name = $request->name;
            $update->collage_id = $request->collage_id;
            $update->location = $request->location;
            $update->capacity = $request->capacity;
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

            $update = Ruangan::find($id);
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
