<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Help extends Model
{
    protected $guarded = ['id'];
    protected $table ="helps";
    public $timestamps = false;


    public function user(){
        return $this->belongsTo(User::class);
    }
}
