<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebTasksSubmissions extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table ="web_task_submissions";
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function tasks(){
        return $this->belongsTo(WebTasks::class,'task_id');
    }
    
}
