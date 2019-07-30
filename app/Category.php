<?php

namespace SmartBuss;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table='Category';

    protected $timestamps=false;
    protected $primaryKey='id';
    protected $fillable=[
        'name','image'
    ];
}
