<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Resources\TaskBoardResource;

class Taskboard extends Model
{
    use HasFactory;


    protected $table = 'taskboard';
    use SoftDeletes;


    protected $fillable = [

        'user_id',
        'name'
    ];
    

    protected $dates = [
        'deleted_at',
        'created_at',
        'updated_at',
    
    ];
    public function setResource($data)
    {
        return new TaskBoardResource($data);
    }

    public function task(){
        return $this->hasmany(Task::class, 'taskboard_id','id');
    }

}
