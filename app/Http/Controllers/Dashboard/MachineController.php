<?php
namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Auth;
use App\User;
use App\AdminMachine;
use Mail;
use Session;
use Redirect;
use DB;
use Carbon\Carbon;

class MachineController extends Controller
{
    
    public function index()
    {
        // $auth_id=Auth::id();
        $admin=AdminMachine::get();
        $machine_id=array();
        $admin_id=array();
        foreach($admin as $item)
        {
            array_push($admin_id,$item['admin_id']);
            array_push($machine_id,$item['machine_id']);
        }
        $data=User::orderBy('id','DESC')
        ->whereIn('id',$machine_id)
        // ->whereIn('id',$admin_id)
        ->with('admin');

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
        // dd($request->all());
        $response=array();
        $response['status']=false;
        $response['data'] ='';
        DB::beginTransaction();
        try {
        $create=AdminMachine::create(
            [
                'admin_id' => $request->admin_id,
                'machine_id'=> $request->machine_id,
            ]
        );
        DB::commit();
        // $response['data']=AdminMachine::find($create->id);
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
        //
    }

  
    public function destroy($id)
    {
        $response=array();
        $response['status']=false;
        $response['data']  = AdminMachine::find($id);
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

    public function getunsignmachine()
    {
        $admin=AdminMachine::get();
        $machine_id=array();
        foreach($admin as $item)
        {
            array_push($machine_id,$item['machine_id']);
        }
        $data=User::orderBy('id','DESC')
        ->where('userType', 3)
        ->whereNotIn('id',$machine_id)
        ->get();
        return $data;
    }

    public function getunsigadmin()
    {
        
        $data=User::orderBy('id','DESC')
        ->where('userType', 2)
        ->get();
        return $data;
    }
}
