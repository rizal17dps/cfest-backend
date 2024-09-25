<?php

namespace App\Http\Controllers\Api\Master;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Universitas;
use App\ResponseFormater;

class UniversitasController extends Controller
{
    //
    public function index() {
        $result = Universitas::orderBy('id', 'asc')->get();
        if($result->isEmpty()){
            return ResponseFormater::success(204);
        } else {
            return ResponseFormater::success(200, $result, 'Success', $result->count());
        }
    }

    public function get($id) {
        $result = Universitas::find($id);
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
                'nss' => ['required', 'string'],
                'nipsn' => ['required', 'string'],
                'nickname' => ['required', 'string'],
                'address' => ['required', 'string'],
                'neighborhood_unit' => ['required', 'string'],
                'community_unit' => ['required', 'string'],
                'sub_district' => ['required', 'string'],
                'district' => ['required', 'string'],
                'city' => ['required', 'string'],
                'province' => ['required', 'string'],
                'postal_code' => ['required', 'integer'],
                'latitude' => ['required', 'string'],
                'longtitude' => ['required', 'string'],
                'no_phone' => ['required', 'integer'],
                'email' => ['required', 'string'],
                'website' => ['required', 'string'],
                'educational_unit_status' => ['required', 'string'],
                'decree_educational_status' => ['required', 'string'],
                'date_decree_educational_status' => ['required', 'date_format:Y-m-d'],
                'fonding_date' => ['required', 'date_format:Y-m-d'],
                'code_registration' => ['required', 'string'],
            ]);

            $insert = new Universitas();
            $insert->name = $request->name;
            $insert->nss = $request->nss;
            $insert->nipsn = $request->nipsn;
            $insert->nickname = $request->nickname;
            $insert->address = $request->address;
            $insert->neighborhood_unit = $request->neighborhood_unit;
            $insert->community_unit = $request->community_unit;
            $insert->sub_district = $request->sub_district;
            $insert->city = $request->city;
            $insert->district = $request->district;
            $insert->province = $request->province;
            $insert->postal_code = $request->postal_code;
            $insert->latitude = $request->latitude;
            $insert->longtitude = $request->longtitude;
            $insert->no_phone = $request->no_phone;
            $insert->email = $request->email;
            $insert->website = $request->website;
            $insert->educational_unit_status = $request->educational_unit_status;
            $insert->decree_educational_status = $request->decree_educational_status;
            $insert->date_decree_educational_status = $request->date_decree_educational_status;
            $insert->fonding_date = $request->fonding_date;
            $insert->code_registration = $request->code_registration;
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
                'nss' => ['required', 'string'],
                'nipsn' => ['required', 'string'],
                'nickname' => ['required', 'string'],
                'address' => ['required', 'string'],
                'neighborhood_unit' => ['required', 'string'],
                'community_unit' => ['required', 'string'],
                'sub_district' => ['required', 'string'],
                'district' => ['required', 'string'],
                'city' => ['required', 'string'],
                'province' => ['required', 'string'],
                'postal_code' => ['required', 'integer'],
                'latitude' => ['required', 'string'],
                'longtitude' => ['required', 'string'],
                'no_phone' => ['required', 'integer'],
                'email' => ['required', 'string'],
                'website' => ['required', 'string'],
                'educational_unit_status' => ['required', 'string'],
                'decree_educational_status' => ['required', 'string'],
                'date_decree_educational_status' => ['required', 'date_format:Y-m-d'],
                'fonding_date' => ['required', 'date_format:Y-m-d'],
                'code_registration' => ['required', 'string'],
            ]);

            $update = Universitas::find($id);
            if(!$update){
                return ResponseFormater::success(204);
            }
            
            $update->name = $request->name;
            $update->nss = $request->nss;
            $update->nipsn = $request->nipsn;
            $update->nickname = $request->nickname;
            $update->address = $request->address;
            $update->neighborhood_unit = $request->neighborhood_unit;
            $update->community_unit = $request->community_unit;
            $update->sub_district = $request->sub_district;
            $update->city = $request->city;
            $update->district = $request->district;
            $update->province = $request->province;
            $update->postal_code = $request->postal_code;
            $update->latitude = $request->latitude;
            $update->longtitude = $request->longtitude;
            $update->no_phone = $request->no_phone;
            $update->email = $request->email;
            $update->website = $request->website;
            $update->educational_unit_status = $request->educational_unit_status;
            $update->decree_educational_status = $request->decree_educational_status;
            $update->date_decree_educational_status = $request->date_decree_educational_status;
            $update->fonding_date = $request->fonding_date;
            $update->code_registration = $request->code_registration;
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

            $update = Universitas::find($id);
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
