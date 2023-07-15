<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Year;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProgramRequest;
use App\Http\Resources\StudentRegisterationResourse;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Support\Facades\Storage;

class ProgramController extends Controller
{

        public function all_programs(){
            return response()->json(['data'=>Program::all()]);
        }
     public function programs($id){
        $progaram=Program::where('year_id',$id)->get();
        if($progaram)
            return $progaram;
        return response()->json(['error'=>'year id not vaild'],422);
        
    }
    public function getYears(){
        return Year::all();
    }

    public function uploadFile(ProgramRequest $request){

           
         $files=Storage::disk('public')->allFiles('programFile');
         if(count($files))
            Storage::disk('public')->delete('programFile/program.pdf');
             
        $request->file('file')->storeAs('programFile','program.pdf','public');
    }
    public function subjects(){
        return response()->json([Program::select('id','subject_name','day')->get()]);
    }
    public function download(){
        return Storage::disk('public')->download('programFile/program.pdf');
    }
    public function todayLectures(){
        // dd('asd');
           return Program::select('id','subject_name','professore_name','start_time','end_time','place','day')
           
           ->where('day',request()->day)
           ->get();
        
    }
    public function index(){
       return Year::with('programs:id,day,year_id,subject_name,professore_name,start_time,end_time,place')->get();
    }
    public function store(ProgramRequest $request){
       
            foreach($request->programs as $program){
                Program::create([

                    "year_id"=>$request->year_id,
                    "subject_name"=>$program['subject_name'],
                    "professore_name"=>$program['professore_name'],
                    "start_time"=>$program['start_time'],
                    "end_time"=>$program['end_time'],
                    "place"=>$program['place'],
                    "day"=>$program['day'],
                ]);
            }
            return response()->json(['message'=>'created success'],201);
    }
    public function subjects_registration(){
        return  DB::table('programs as p')->join('studentsubjects as s','s.program_id','=','p.id')
        ->select('p.*')
        ->get();  
    }

    public function student_registration(){
       $program=Program::find(request()->subjectId);
       if($program)
        return  StudentRegisterationResourse::collection($program->usersAttended);
        return response()->json(['error'=>'subjectId not found'],422);
       
    }
    public function destroy(Request $request){
        $program=Program::find($request->id);
        if($program){
            $program->delete();
            return response()->json(['data'=>'program deleted sucessfully']);
        }
        return response()->json(['error'=>'program  not found'],422);

    }   
    public function edit(ProgramRequest $request){
        $program=Program::find($request->id);
        if($program){
            $program->update([
                'year_id'=>$request->year_id,
                'subject_name'=>$request->subject_name,
                'professore_name'=>$request->professore_name,
                'start_time'=>$request->start_time,
                'end_time'=>$request->end_time,
                'place'=>$request->place,
                'day'=>$request->day,
            ]);
            return response()->json(['data'=>'program deleted sucessfully']);
        }
        return response()->json(['error'=>'program  not found'],422);

    }   
}
