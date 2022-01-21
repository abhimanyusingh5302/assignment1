<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Taskboard;
use App\Http\Resources\TaskBoardResource;
use App\Http\Request\TaskRequest;
use App\Http\Request\TaskupdateRequest;
use App\Http\Request\TaskdeleteRequest;
use Illuminate\Support\Facades\Auth;

class TaskBoardController extends Controller
{




    private $board;

    public function __construct(Taskboard $board)
    {
        $this->board=$board;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result=[];
        $user=Auth::user();
       $data=$this->board->where('user_id',$user->id)->get();
       
       if ($data->count() > 0 ) {
            foreach($data as $d){
               $data1=[
                   'id'=>$d->id,
                   'name'=>$d->name,
               ];
               array_push($result,$data1);
            }
        $return_data['data']=$result;
        $return_data['message']="Response successfully";
        $return_data['status']=200;
        return $return_data;
       }
       $return_data['message']='Data not found';
       $return_data['status']=404;
       return $return_data;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(TaskRequest $request)
    {
        if ($request) {
            $user=Auth::user();
            $board=$this->board->create([
                'user_id'=>$user->id,
                'name'=>$request->name
            ]);
            $return_data['data']=new  TaskBoardResource($board);
            $return_data['message']="Response successfully";
            $return_data['status']=200;
            return $return_data;
          
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(TaskupdateRequest $request)
    {
       $user=Auth::user();
       if(isset($user)){
       $data=$this->board->where('id',$request->id)->first();
       if(isset($data)){
       $data->name=$request->name;
       $data->save();
       $return_data['data']=new  TaskBoardResource($data);
       $return_data['message']="Response successfully";
       $return_data['status']=200;
       return $return_data;
       
       }else{
        $return_data['message']="Data not found";
        $return_data['status']=404;
       }
    }
   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(TaskdeleteRequest $request)
    {
        
        $data=$this->board->where('id',$request->id)->delete();

            $return_data['message']="Response successfully";
            $return_data['status']=200;
            return $return_data;
        
    }
}
