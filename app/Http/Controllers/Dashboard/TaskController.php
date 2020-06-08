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
class TaskController extends Controller
{
    public function index(Request $request)
    {
         $auth_id=Auth::User();
         if($auth_id->userType==3)
         {
            $data=Task::where('machine_id',$auth_id->id)
            ->with('machine');
         }
         elseif($auth_id->userType==2)
         {
            $data=Task::where('admin_id',$auth_id->id)
            ->with('machine');
         }
         elseif($auth_id->userType==1)
         {
            $data=Task::with('machine');
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

        // dd($request->name);
        $auth_id=Auth::user();
        if($auth_id->userType == 1)
        {
            $admin = AdminMachine::where('machine_id', $request->machine_id)->first();
            $auth_id->id = $admin->admin_id;
        }
        $response=array();
        $response['status']=false;
        $response['data'] ='';
        DB::beginTransaction();
        try {
        $create=Task::create(
            [
                'admin_id' => $auth_id->id,
                'machine_id'=> $request->machine_id,
                'name'=> $request->name,
                'make'=> $request->make,
                'model'=> $request->model,
                'description'=> $request->description,
            ]
        );
        DB::commit();
        $response['data']=Task::with('machine')->find($create->id);
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
        //
    }

  
    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
          // dd($request->all());
          $response=array();
          $response['status']=false;
          $response['data'] ='';
          DB::beginTransaction();
          try {
            Task::where('id', $id)
          ->update(
              [
                'name'=> $request->name,
                'make'=> $request->make,
                'model'=> $request->model,
                'description'=> $request->description,
              ]
          );
          DB::commit();
          $response['data']=Task::with('machine')->find($id);
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
        $response['data']  = Task::find($id);
        if($response['data'])
        {
                TaskDetail::where('machine_id',$response['data']->machine_id)->delete();
                $response['data']=$response['data']->delete();
                $response['status'] = true;
           
        }
        else
        {
            $response['data']="Data Not deleted";  
        }
        return response()->json($response);
    }

    public function getunsignmachine()
    {
        $id = Auth::User();
        if($id->userType==2)
        {
            $admin=AdminMachine::where('admin_id',$id->id)->get();
        }
        else
        {
            $admin=AdminMachine::get();
        }
        
        $machine_id=array();
        foreach($admin as $item)
        {
            array_push($machine_id,$item['machine_id']);
        }
        $machine=Task::get();
        $machine_id2=array();
        foreach($machine as $item)
        {
            array_push($machine_id2,$item['machine_id']);
        }
        $data=User::orderBy('id','DESC')
        ->where('userType', 3)
        ->whereIn('id',$machine_id)
        ->whereNotIn('id',$machine_id2)
        ->get();
        return $data;
    }
}
