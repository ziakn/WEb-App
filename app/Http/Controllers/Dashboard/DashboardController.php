<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Auth;
use App\User;
use App\AdminMachine;
use App\Task;
use App\Pages;
use Mail;
use App\PageUser;
use App\TaskDetail;
use Session;
use Redirect;
use DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response=array();
        $user = Auth::user();
        if($user->userType==1)
        {
                $today = Carbon::now()->subDays(30)->format('Y-m-d');
                $response['admin'] = User::where('userType',2)->count();
                $response['machine'] = User::where('userType',3)->count();

                $machine=User::where('userType',3)->get(); 
                    $machine_id=array();
                    foreach($machine as $item)
                    {
                        array_push($machine_id,$item['id']);
                    }  
                $response['daily'] = TaskDetail::wherein('machine_id', $machine_id)
                ->where('target_type', 'daily')
                ->where('start_date','>', Carbon::now()->subDays(30)->format('Y-m-d'))
                ->with('machine')
                ->get();

                $week = Carbon::now()->subDays(7)->format('Y-m-d');
                $response['week'] = TaskDetail::where('target_type', 'weekly')
                ->where('start_date','>=', Carbon::now()->subDays(30)->format('Y-m-d'))
                ->with('machine')
                ->get();

                // $response['daily'] = TaskDetail::wherein('machine_id', $machine_id)
                // ->where('target_type', 'daily')
                // ->where('start_date','>', Carbon::now()->subDays(30)->format('Y-m-d'))
                // ->with('machine')
                // ->get();

                // $week = Carbon::now()->subDays(7)->format('Y-m-d');
                // $response['week'] = TaskDetail::where('target_type', 'weekly')
                // ->where('start_date','>=', Carbon::now()->subDays(30)->format('Y-m-d'))
                // ->with('machine')
                // ->get();
                $response['newAdmin'] = User::orderBy('id','DESC')->where('userType',2)->limit(5)->get();
                $response['newMachine'] = User::orderBy('id','DESC')->where('userType',3)->limit(5)->get();
        }

        elseif($user->userType==2)
        {
            $today = Carbon::now()->format('Y-m-d');
            $machine=AdminMachine::where('admin_id',$user->id)->get(); 
                $machine_id=array();
                foreach($machine as $item)
                {
                    array_push($machine_id,$item['id']);
                }  
            $response['machine'] = User::wherein('id',$machine_id)->count();

            $response['daily']=TaskDetail::wherein('machine_id', $machine_id)
            ->where('target_type', 'daily')
            ->where('start_date', $today)
            ->with('machine')
            ->get();

            $week = Carbon::now()->subDays(7)->format('Y-m-d');
            $response['week'] = TaskDetail::wherein('machine_id', $machine_id)
                ->where('target_type', 'weekly')
                ->where('start_date','>=', $week)
                ->with('machine')
                ->get();
        }

        elseif($user->userType==3)
        {

            $today = Carbon::now()->format('Y-m-d');
            $response['admin'] = User::where('userType',2)->count();
            $response['machine'] = User::where('userType',3)->count();

            $machine=User::where('userType',3)->get(); 
                $machine_id=array();
                foreach($machine as $item)
                {
                    array_push($machine_id,$item['id']);
                }  
            $response['daily']=TaskDetail::where('machine_id', $user->id)
            ->where('target_type', 'daily')
            ->with('machine')
            ->count();

            $week = Carbon::now()->subDays(7)->format('Y-m-d');
            $response['week'] = TaskDetail::where('machine_id', $user->id)
                ->where('target_type', 'weekly')
                ->with('machine')
                ->count();
        } 

        return $response;
    }

    
    
    public function create()
    {
        //
    }

    
    public function store(Request $request)
    {
        //
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
        //
    }
    

    public  function getSuperAdminMachine()
    {
        $user = Auth::user();
        if($user->userType==1)
        {
        $data = User::where('userType',3)->get();
        return $data;
        }
        elseif($user->userType==2)
        {
            $machine=AdminMachine::where('admin_id',$user->id)->get(); 
                $machine_id=array();
                foreach($machine as $item)
                {
                    array_push($machine_id,$item['machine_id']);
                }  
                return $data = User::wherein('id',$machine_id)->get();
            
        }

        elseif($user->userType==3)
        {
            return $data = User::find($user->id);
        }
    }

    public function getSuperAdminMachineDataDaily($id)
    {
        $data = TaskDetail::where('machine_id', $id)
                ->where('target_type', 'daily')
                ->where('start_date','>', Carbon::now()->subDays(30)->format('Y-m-d'))
                ->with('machine')
                ->get();

        return $data;
    }

    public function getSuperAdminMachineDataWeekly($id)
    {
        $data = TaskDetail::where('machine_id', $id)
                ->where('target_type', 'weekly')
                ->where('start_date','>', Carbon::now()->subDays(90)->format('Y-m-d'))
                ->with('machine')
                ->get();

        return $data;
    }


    public function getSuperAdminMachineDataMonthly($id)
    {
        $data = TaskDetail::where('machine_id', $id)
                ->where('target_type', 'monthly')
                ->where('start_date','>', Carbon::now()->subDays(365)->format('Y-m-d'))
                ->with('machine')
                ->get();

        return $data;
    }

    public  function getsubAdminMachine()
    {
        $data = User::where('userType',3)->get();
        return $data;
    }

    public function getSubAdminMachineDataDaily($id)
    {
        $data = TaskDetail::where('machine_id', $id)
                ->where('target_type', 'daily')
                ->where('start_date','>', Carbon::now()->subDays(30)->format('Y-m-d'))
                ->with('machine')
                ->get();

        return $data;
    }

    public function getSubAdminMachineDataWeekly($id)
    {
        $data = TaskDetail::where('machine_id', $id)
                ->where('target_type', 'weekly')
                ->where('start_date','>', Carbon::now()->subDays(90)->format('Y-m-d'))
                ->with('machine')
                ->get();

        return $data;
    }


    public function getSubAdminMachineDataMonthly($id)
    {
        $data = TaskDetail::where('machine_id', $id)
                ->where('target_type', 'monthly')
                ->where('start_date','>', Carbon::now()->subDays(365)->format('Y-m-d'))
                ->with('machine')
                ->get();

        return $data;
    }

    public function getMachineAdminMachineDataDaily($id)
    {
        $data = TaskDetail::where('machine_id', $id)
                ->where('target_type', 'daily')
                ->where('start_date','>', Carbon::now()->subDays(30)->format('Y-m-d'))
                ->with('machine')
                ->get();

        return $data;
    }

    public function getMachineAdminMachineDataWeekly($id)
    {
        $data = TaskDetail::where('machine_id', $id)
                ->where('target_type', 'weekly')
                ->where('start_date','>', Carbon::now()->subDays(90)->format('Y-m-d'))
                ->with('machine')
                ->get();

        return $data;
    }


    public function getMachineAdminMachineDataMonthly($id)
    {
        $data = TaskDetail::where('machine_id', $id)
                ->where('target_type', 'monthly')
                ->where('start_date','>', Carbon::now()->subDays(365)->format('Y-m-d'))
                ->with('machine')
                ->get();

        return $data;
    }
}
