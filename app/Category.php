<?php

namespace SmartBuss;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table='Categories';

    public $timestamps=false;
    protected $primaryKey='id';
    protected $fillable=[
        'name','image'
    ];
}
