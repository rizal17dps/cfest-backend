<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request; 
use App\Models\JadwalKuliah;
use Yajra\DataTables\Facades\DataTables;

class HistoryController extends Controller
{
    //
    public function schedule(){
        $jadwal = JadwalKuliah::with(['course', 'lectures', 'rooms'])->select('course_schedules.*');
        return DataTables::of($jadwal)
            ->addColumn('name_mk', function ($row) {
                return $row->matkul ? $row->matkul->name : 'N/A';
            })
            ->addColumn('name_lecturer', function ($row) {
                return $row->dosen ? $row->dosen->name : 'N/A';
            })
            ->addColumn('name_room', function ($row) {
                return $row->ruangan ? $row->ruangan->name : 'N/A';
            })
            ->addColumn('name_mk', function ($row) {
                return $row->matkul ? $row->matkul->name : 'N/A';
            })
            ->make();
    }
}
