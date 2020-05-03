<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Auth;
use App\User;
use App\AdminMachine;
use App\Task;
use App\TaskDetail;
use Mail;
use Session;
use Redirect;
use DB;
use Carbon\Carbon;

class TaskDetailController extends Controller
{
    
    public function index(Request $request)
    {
        // dd($request->all());
           // $auth_id=Auth::id();
           $data=TaskDetail::orderBy('id','DESC');
           if(isset($request->machine_id) && !empty($request->machine_id))
           {
               $machine_id=$request->machine_id;
               $data=$data->where('machine_id',$machine_id);
           } 
           if(isset($request->show) && !empty($request->show))
           {
               $show=$request->show;
               $data=$data->paginate($show);
           }
           else
           {
               $data=$data->get();
           }
           return $data;
    }

   
    public function create()
    {
        //
    }

    
    public function store(Request $request)
    {
        //  dd($request->all());
         $auth_id=Auth::id();
         $response=array();
         $response['status']=false;
         $response['data'] ='';
         DB::beginTransaction();
         try {
         $create=TaskDetail::create(
             [
                 'admin_id' => $auth_id,
                 'machine_id'=> $request->machine_id,
                 'task_name'=> $request->task_name,
                 'target_type'=> $request->target_type,
                 'start_time'=> $request->start_time,
                 'end_time'=> $request->end_time,
                 'start_date'=> $request->start_date,
                 'end_date'=> $request->end_date,
                 'qunatity_produce'=> $request->qunatity_produce,
                 'qunatity_require'=> $request->qunatity_require,
                 'remark'=> $request->remark,
                 'status'=> $request->status,
             ]
         );
         DB::commit();
         $response['data']=TaskDetail::find($create->id);
         $response['status'] = true;
     } catch (\Exception $e) {
         $response['data']=$e->getMessage();
         $response['status'] = false;
         DB::rollback();
     }
         
     return response()->json($response);
    }

   
    public function show($id)
    {
        $data = TaskDetail::where('machine_id', $id)->get();
        return $data;
    }

   
    public function edit($id)
    {
        //
    }

   
    public function update(Request $request, $id)
    {
        // dd($request->all());
          $auth_id=Auth::id();
         $response=array();
         $response['status']=false;
         $response['data'] ='';
         DB::beginTransaction();
         try {
            TaskDetail::where('id', $id)
         ->update(
             [
                 'admin_id' => $auth_id,
                 'machine_id'=> $request->machine_id,
                 'task_name'=> $request->task_name,
                 'target_type'=> $request->target_type,
                 'start_time'=> $request->start_time,
                 'end_time'=> $request->end_time,
                 'start_date'=> $request->start_date,
                 'end_date'=> $request->end_date,
                 'qunatity_produce'=> $request->qunatity_produce,
                 'qunatity_require'=> $request->qunatity_require,
                 'remark'=> $request->remark,
                 'status'=> $request->status,
             ]
         );
         $response['data'] = TaskDetail::find($id);
         DB::commit();
         $response['status'] = true;
     } catch (\Exception $e) {
         $response['data']=$e->getMessage();
         $response['status'] = false;
         DB::rollback();
     }
         
     return response()->json($response);
    }

    
    public function destroy($id)
    {
        $response=array();
        $response['status']=false;
        $response['data']  = TaskDetail::find($id);
        if($response['data'])
        {
           
                $response['data']=$response['data']->delete();
                $response['status'] = true;
           
        }
        else
        {
            $response['data']="Data Not deleted";  
        }
        return response()->json($response);
    }

    public function getmachinetask($id)
    {
        $data = Task::where('machine_id',$id)->first();
        return $data;
    }
}
