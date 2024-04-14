<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebTasks extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table ="web_tasks";
    public function webTasksSubmission(){
        return $this->hasMany(WebTasksSubmissions::class);
    }
    
}
