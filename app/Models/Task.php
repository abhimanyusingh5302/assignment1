<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Resources\TaskResource;

class Task extends Model
{
    use HasFactory;


    protected $table = 'tasks';
    use SoftDeletes;


    protected $fillable = [

        'taskboard_id',
        'name'
    ];
    

    protected $dates = [
        'deleted_at',
        'created_at',
        'updated_at',
    
    ];
    public function setResource($data)
    {
        return new TaskResource($data);
    }
}
