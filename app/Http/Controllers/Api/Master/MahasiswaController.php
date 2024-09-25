<?php

namespace App\Http\Controllers\Api\Master;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Prodi;
use App\Models\Mahasiswa;
use App\Models\Universitas;
use App\Models\MahasiswaPT;
use App\ResponseFormater;

class MahasiswaController extends Controller
{
    //
    public function index() {
        $result = Mahasiswa::orderBy('id', 'asc')->get();
        if($result->isEmpty()){
            return ResponseFormater::success(204);
        } else {
            return ResponseFormater::success(200, $result, 'Success', $result->count());
        }
    }

    public function get($id) {
        $result = Mahasiswa::find($id);
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
                'religion_id' => ['required', 'integer'],
                'name' => ['required', 'string'],
                'gender' => ['required', 'string'],
                'nisn' => ['required', 'string'],
                'nip' => ['required', 'integer'],
                'place_of_birth' => ['required', 'string'],
                'date_of_birth' => ['required', 'date_format:Y-m-d'],
                'address' => ['required', 'string'],
                'neighborhood_unit' => ['required', 'string'],
                'community_unit' => ['required', 'string'],
                'sub_district' => ['required', 'string'],
                'district' => ['required', 'string'],
                'city' => ['required', 'string'],
                'province' => ['required', 'string'],
                'no_phone' => ['required', 'integer'],
                'no_phone_home' => ['nullable', 'integer'],
                'father_name' => ['required', 'string'],
                'father_birth_of_date' => ['required', 'date_format:Y-m-d'],
                'father_nip' => ['required', 'integer'],
                'father_master_of_education_id' => ['required', 'integer'],
                'father_master_of_work_id' => ['required', 'integer'],
                'father_master_of_income_id' => ['required', 'integer'],
                'mother_name' => ['required', 'string'],
                'mother_birth_of_date' => ['required', 'date_format:Y-m-d'],
                'mother_nip' => ['required', 'integer'],
                'mother_master_of_education_id' => ['required', 'integer'],
                'mother_master_of_work_id' => ['required', 'integer'],
                'mother_master_of_income_id' => ['required', 'integer'],
                'guardian_name' => ['required', 'string'],
                'guardian_birth_of_date' => ['required', 'date_format:Y-m-d'],
                'guardian_nip' => ['required', 'integer'],
                'guardian_master_of_education_id' => ['required', 'integer'],
                'guardian_master_of_work_id' => ['required', 'integer'],
                'guardian_master_of_income_id' => ['required', 'integer'],
            ]);

            $insert = new Mahasiswa();
            $insert->collage_id = $request->collage_id;
            $insert->religion_id = $request->religion_id;
            $insert->name = $request->name;
            $insert->gender = $request->gender;
            $insert->nisn = $request->nisn;
            $insert->nip = $request->nip;
            $insert->place_of_birth = $request->place_of_birth;
            $insert->date_of_birth = $request->date_of_birth;
            $insert->address = $request->address;
            $insert->neighborhood_unit = $request->neighborhood_unit;
            $insert->community_unit = $request->community_unit;
            $insert->sub_district = $request->sub_district;
            $insert->district = $request->district;
            $insert->city = $request->city;
            $insert->province = $request->province;
            $insert->no_phone = $request->no_phone;
            $insert->no_phone_home = $request->no_phone_home;
            $insert->father_name = $request->father_name;
            $insert->father_birth_of_date = $request->father_birth_of_date;
            $insert->father_nip = $request->father_nip;
            $insert->father_master_of_education_id = $request->father_master_of_education_id;
            $insert->father_master_of_work_id = $request->father_master_of_work_id;
            $insert->father_master_of_income_id = $request->father_master_of_income_id;
            $insert->mother_name = $request->mother_name;
            $insert->mother_birth_of_date = $request->mother_birth_of_date;
            $insert->mother_nip = $request->mother_nip;
            $insert->mother_master_of_education_id = $request->mother_master_of_education_id;
            $insert->mother_master_of_work_id = $request->mother_master_of_work_id;
            $insert->mother_master_of_income_id = $request->mother_master_of_income_id;
            $insert->guardian_name = $request->guardian_name;
            $insert->guardian_birth_of_date = $request->guardian_birth_of_date;
            $insert->guardian_nip = $request->guardian_nip;
            $insert->guardian_master_of_education_id = $request->guardian_master_of_education_id;
            $insert->guardian_master_of_work_id = $request->guardian_master_of_work_id;
            $insert->guardian_master_of_income_id = $request->guardian_master_of_income_id;
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
                'religion_id' => ['required', 'integer'],
                'name' => ['required', 'string'],
                'gender' => ['required', 'string'],
                'nisn' => ['required', 'string'],
                'nip' => ['required', 'integer'],
                'place_of_birth' => ['required', 'string'],
                'date_of_birth' => ['required', 'date_format:Y-m-d'],
                'address' => ['required', 'string'],
                'neighborhood_unit' => ['required', 'string'],
                'community_unit' => ['required', 'string'],
                'sub_district' => ['required', 'string'],
                'district' => ['required', 'string'],
                'city' => ['required', 'string'],
                'province' => ['required', 'string'],
                'no_phone' => ['required', 'integer'],
                'no_phone_home' => ['nullable', 'integer'],
                'father_name' => ['required', 'string'],
                'father_birth_of_date' => ['required', 'date_format:Y-m-d'],
                'father_nip' => ['required', 'integer'],
                'father_master_of_education_id' => ['required', 'integer'],
                'father_master_of_work_id' => ['required', 'integer'],
                'father_master_of_income_id' => ['required', 'integer'],
                'mother_name' => ['required', 'string'],
                'mother_birth_of_date' => ['required', 'date_format:Y-m-d'],
                'mother_nip' => ['required', 'integer'],
                'mother_master_of_education_id' => ['required', 'integer'],
                'mother_master_of_work_id' => ['required', 'integer'],
                'mother_master_of_income_id' => ['required', 'integer'],
                'guardian_name' => ['required', 'string'],
                'guardian_birth_of_date' => ['required', 'date_format:Y-m-d'],
                'guardian_nip' => ['required', 'integer'],
                'guardian_master_of_education_id' => ['required', 'integer'],
                'guardian_master_of_work_id' => ['required', 'integer'],
                'guardian_master_of_income_id' => ['required', 'integer'],
            ]);

            $update = Mahasiswa::find($id);
            if(!$update){
                return ResponseFormater::success(204);
            }
            
            $update->collage_id = $request->collage_id;
            $update->religion_id = $request->religion_id;
            $update->name = $request->name;
            $update->gender = $request->gender;
            $update->nisn = $request->nisn;
            $update->nip = $request->nip;
            $update->place_of_birth = $request->place_of_birth;
            $update->date_of_birth = $request->date_of_birth;
            $update->address = $request->address;
            $update->neighborhood_unit = $request->neighborhood_unit;
            $update->community_unit = $request->community_unit;
            $update->sub_district = $request->sub_district;
            $update->district = $request->district;
            $update->city = $request->city;
            $update->province = $request->province;
            $update->no_phone = $request->no_phone;
            $update->no_phone_home = $request->no_phone_home;
            $update->father_name = $request->father_name;
            $update->father_birth_of_date = $request->father_birth_of_date;
            $update->father_nip = $request->father_nip;
            $update->father_master_of_education_id = $request->father_master_of_education_id;
            $update->father_master_of_work_id = $request->father_master_of_work_id;
            $update->father_master_of_income_id = $request->father_master_of_income_id;
            $update->mother_name = $request->mother_name;
            $update->mother_birth_of_date = $request->mother_birth_of_date;
            $update->mother_nip = $request->mother_nip;
            $update->mother_master_of_education_id = $request->mother_master_of_education_id;
            $update->mother_master_of_work_id = $request->mother_master_of_work_id;
            $update->mother_master_of_income_id = $request->mother_master_of_income_id;
            $update->guardian_name = $request->guardian_name;
            $update->guardian_birth_of_date = $request->guardian_birth_of_date;
            $update->guardian_nip = $request->guardian_nip;
            $update->guardian_master_of_education_id = $request->guardian_master_of_education_id;
            $update->guardian_master_of_work_id = $request->guardian_master_of_work_id;
            $update->guardian_master_of_income_id = $request->guardian_master_of_income_id;
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

            $update = Mahasiswa::find($id);
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

    public function storeMahasiswaPT(Request $request){
        DB::beginTransaction();
        try{
            request()->validate([
                'collage_id' => ['required', 'integer'],
                'student_id' => ['required', 'integer'],
                'academic_program_id' => ['required', 'integer'],
                'nim' => ['required', 'varchar'],
                'tgl_masuk' => ['required', 'date_format:Y-m-d'],
                'status_keluar' => ['required', 'string'],
            ]);

            $insert = new MahasiswaPT();
            $insert->collage_id = $request->collage_id;
            $insert->academic_program_id = $request->academic_program_id;
            $insert->student_id = $request->student_id;
            $insert->nim = $request->nim;
            $insert->tgl_masuk = $request->tgl_masuk;
            $insert->status_keluar = $request->status_keluar;
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

    public function updateMahasiswaPT($id, Request $request){
        DB::beginTransaction();
        try{
            request()->validate([
                'collage_id' => ['required', 'integer'],
                'student_id' => ['required', 'integer'],
                'academic_program_id' => ['required', 'integer'],
                'nim' => ['required', 'varchar'],
                'tgl_masuk' => ['required', 'date_format:Y-m-d'],
                'status_keluar' => ['required', 'string'],
            ]);

            $update = MahasiswaPT::find($id);
            if(!$update){
                return ResponseFormater::success(204);
            }

            $update->collage_id = $request->collage_id;
            $update->academic_program_id = $request->academic_program_id;
            $update->student_id = $request->student_id;
            $update->nim = $request->nim;
            $update->tgl_masuk = $request->tgl_masuk;
            $update->status_keluar = $request->status_keluar;
            $update->save();
            
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

    public function deleteMahasiswaPT($id){
        DB::beginTransaction();
        try{
            $update = MahasiswaPT::find($id);
            if(!$update){
                return ResponseFormater::success(204);
            }
            
            $update->delete();
            
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

    public function getMahasiswaPT($id) {
        $result = MahasiswaPT::find($id);
        $data = [];
        if(!$result){
            return ResponseFormater::success(204);
        } else {
            $mahasiswa = Mahasiswa::find($result->student_id);
            $universitas = Universitas::find($result->collage_id);
            $prodi = Prodi::find($result->academic_program_id);

            array_push($data, ['mahasiswa_name' => $mahasiswa->name, 'universitas' => $universitas->name, 'program_studi' => $prodi->name]);
            return ResponseFormater::success(200, $data, 'Success', $result->count());
        }
    }

    public function indexMahasiswaPT() {
        $result = MahasiswaPT::orderBy('id', 'asc')->get();
        if($result->isEmpty()){
            return ResponseFormater::success(204);
        } else {
            return ResponseFormater::success(200, $result, 'Success', $result->count());
        }
    }
}
