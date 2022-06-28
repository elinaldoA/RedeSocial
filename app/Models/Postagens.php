<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Postagens extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','title','place','image','description'
    ];
    public function user()
    {
      return $this->belongsTo(User::class);
    }
    public function postagens()
    {
      return $this->hasMany(Postagens::class);
    }
}
