<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SentPost extends Model
{
    use HasFactory;
    protected $fillable =[
        'post_id','email'
    ];

     /**
      * Get the user that owns the sentPost
      *
      * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
      */
     public function user()
     {
         return $this->belongsTo(Post::class);
     }
}
