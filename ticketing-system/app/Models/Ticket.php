<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    //
    use HasFactory;


    protected $guarded = [
        'user_id',

    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function category(){
        return $this->belongsTo(Category::class,'categories_id');
    }
    public function prioritylevel(){
        return $this->belongsTo(PriorityLevel::class,'priority_levels_id');
    }
    public function status(){
        return $this->belongsTo(Status::class,'statuses_id');
    }

}
