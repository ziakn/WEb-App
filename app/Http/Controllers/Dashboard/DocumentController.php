<?php
namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Auth;
use App\User;
use App\Document;
use Mail;
use Session;
use Redirect;
use DB;
use Carbon\Carbon;
class DocumentController extends Controller
{
    
    public function index(Request $request)
    {
        // $auth_id=Auth::id();
        $id = Auth::User();
        if($id->userType==2)
        {
            $data=Document::where('admin_id',$id->id);
        }
        else
        {
            $data=Document::orderBy('id','DESC');
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
        $auth_id=Auth::id();
        $response=array();
        $response['status']=false;
        $response['data'] ='';
        DB::beginTransaction();
        try {
        if($request->hasFile('document'))
        {
            $request->document->store('public/uploads/document');
            $document_src= '/storage/uploads/document/'.$request->document->hashName();
            
        }
        $create=Document::create(
            [
                'admin_id' => $auth_id,
                'title'=> $request->title,
                'barcode'=> $request->barcode,
                'description'=> $request->description,
                'file_src'=> $document_src,
            ]
        );
        DB::commit();
        $response['data']=Document::find($create->id);
        $response['status'] = true;
    } catch (\Exception $e) {
        $response['data']=$e->getMessage();
        $response['status'] = false;
        DB::rollback();
    }
        
    return response()->json($response);
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
        // dd($request->all());
        $response=array();
        $response['status']=false;
        $response['data'] ='';
        DB::beginTransaction();
        try {
            $document_src= $request->file_src;
        if($request->hasFile('document'))
        {
            $request->document->store('public/uploads/document');
            $document_src= '/storage/uploads/document/'.$request->document->hashName();
            
        }
        Document::where('id', $id)
        ->update(
            [
                'title'=> $request->title,
                'barcode'=> $request->barcode,
                'description'=> $request->description,
                'file_src'=> $document_src,
            ]
        );
        DB::commit();
        $response['data']=Document::find($id);
        $response['status'] = true;
    } catch (\Exception $e) {
        $response['data']=$e->getMessage();
        $response['status'] = false;
        DB::rollback();
    }
        
    return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $response=array();
        $response['status']=false;
        $response['data']  = Document::find($id);
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
}
