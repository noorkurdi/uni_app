<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\SubjectRequest;
use App\Models\Studentsubjects;
use Illuminate\Validation\Rules\Exists;
use League\CommonMark\Extension\Table\Table;

class SubjectsController extends Controller
{
    public function store(SubjectRequest $request){
         
        auth('user')->user()->programs()->syncWithoutDetaching($request->subjects_ids);
        return  response()->json(['message'=>'addes successfully']);
    
    }

    public function index(){
        
        return DB::table('users as u')->where('u.id',auth('user')->id())
        ->join('studentsubjects as s','s.user_id','=','u.id')
        ->join('programs as p','p.id','=','s.program_id')
        ->select('p.*')
        ->get();
    }

    public function toDayLectures(){
        $toDay=Carbon::now()->format('d');
       return DB::table('users as u')->where('u.id',auth('user')->id())
            ->join('studentsubjects as s','s.user_id','=','u.id')
            ->join('programs as p','p.id','=','s.program_id')
            ->whereDay('p.start_time',$toDay)
            ->select('p.*')
            ->get();
      
    }

    public function usersAttended(){
       $program=Program::whereId(request()->id);
       if($program)

          return  $program->withwherehas('usersAttended')->get();
          return response()->json(['error'=>'program not found'],422);
       
    }
     public function attendanceRegistration(){
     $studant=Studentsubjects::where('program_id',request()->subjectId)->where('user_id',auth('user')->id());
     if($studant->exists()){

         $studant->update([
             'is_attended'=>true,
             'updated_at'=>Carbon::now()
            ]);
            return response()->json(['message'=>'added sucesfully']);
        }
     return response()->json(['error'=>'program not found'],422);
    
   

   
       
    }
}
