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
use Session;
use Redirect;
use DB;
use Carbon\Carbon;

class PagesController extends Controller
{
  
    public function index()
    {
        $data = Pages::get();
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
       $find = Pages::where('user_role',$request->user_role)->get();
     
       if(isset($find) && count($find) > 0)
       {
        Pages::where('user_role',$request->user_role)
        ->update(
            [
                'production_overview'=> $request->production_overview,
                'manage_user'=> $request->manage_user,
                'checklist_or_create'=> $request->checklist_or_create,
                'scan_or_document'=> $request->scan_or_document,
                'setting'=> $request->setting,
            ]
        );

       }
       else
       {
        Pages::create(
            [
                'user_role'=> $request->user_role,
                'production_overview'=> $request->production_overview,
                'manage_user'=> $request->manage_user,
                'checklist_or_create'=> $request->checklist_or_create,
                'scan_or_document'=> $request->scan_or_document,
                'setting'=> $request->setting,
            ]
        );
       }
        
        DB::commit();
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
        $data = Pages::where('user_role', $id)->first();
        return $data;
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

    public function getAdminUser()
    {
        $data = User::where('userType',2)->get();
        return $data;
    }
}
