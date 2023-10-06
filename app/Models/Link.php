<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    use HasFactory;

    protected $table = 'links';
    protected $fillable = ['title', 'destination', 'short_link'];
    protected $guarded = ['clicks'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function addClick(){
        $this->clicks += 1;
        $this->save();
    }
}
