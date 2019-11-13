<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class token_model extends Model
{
    protected $table='token';
    protected $fillable=[
        'token'
    ];
    public function user(){
        return $this->belongsTo('App\User','id');
    }
}
