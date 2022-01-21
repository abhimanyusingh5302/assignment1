<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Http\Resources\TaskResource;
use App\Http\Request\TaskRequest;
use App\Http\Request\TaskupdateRequest;
use App\Http\Request\TaskdeleteRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Taskboard;

class TaskController extends Controller
{




    private $task;

    public function __construct(Task $task)
    {
        $this->task=$task;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result=[];
        $maintask=[];
        $final_data = [];
        $user=Auth::user();
        $board=Taskboard::with('task')->where('user_id',$user->id)->get();
        $task=$this->task->get();
      
       if ($board->count() > 0 ) {
            foreach ($board as $d) {
                    $data1=[
                   'id'=>$d->id,
                   'name'=>$d->name,  
               ];
                    $result[$d->id] = $data1;
            }
            foreach ($task as $t){ 
                    $data2=[
                        'id'=>$t->id,
                        "name"=>$t->name,
                        'taskboard_id'=>$t->taskboard_id,
                    ];
                    $maintask[$t->taskboard_id][] = $data2;
            }
            foreach($result as $res){
                $final_data[$res['id']]['id'] = $res['id'];
                $final_data[$res['id']]['name'] = $res['name'];
                if(array_key_exists($res['id'], $maintask)){
                    $final_data[$res['id']]['tasks'] = $maintask[$res['id']];
                }
            }
        $return_data['data']= array_values($final_data);
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
        $task_board=Taskboard::find($request->task_board_id);
      
        if(isset($task_board)){
            $board=$this->task->create([
                        'taskboard_id'=>$task_board->id,
                        'name'=>$request->name
                    ]);
                    $return_data['data']=new  TaskResource($board);
                    $return_data['message']="Response successfully";
                    $return_data['status']=200;
                    return $return_data;

        }else{
            $return_data['message']="task_board_id Not found";
            $return_data['status']=404;
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
       $data=$this->task->where('id',$request->id)->first();
       if(isset($data)){
       $data->name=$request->name;
       $data->save();
       $return_data['data']=new  TaskResource($data);
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
        
        $data=$this->task->where('id',$request->id)->delete();

            $return_data['message']="Response successfully";
            $return_data['status']=200;
            return $return_data;
        
    }
}
