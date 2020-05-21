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

        
        $today = Carbon::now()->format('Y-m-d');
        $response['admin'] = User::where('userType',2)->count();
        $response['machine'] = User::where('userType',3)->count();

        $machine=User::where('userType',3)->get(); 
            $machine_id=array();
            foreach($machine as $item)
            {
                array_push($machine_id,$item['id']);
            }  
        $response['daily']=TaskDetail::wherein('machine_id', $machine_id)
        ->where('target_type', 'daily')
        ->where('start_date', $today)
        ->with('machine')
        ->get();

        $week = Carbon::now()->subDays(7)->format('Y-m-d');
        $response['week'] = TaskDetail::where('target_type', 'weekly')
            ->where('start_date','>=', $week)
            ->with('machine')
            ->get();
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
