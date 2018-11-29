<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Consumption extends Model
{
    // Table Name
    protected $table = 'consumption';
    // Primary Key
    public $primaryKey = 'id';
    // Timestamps
    public $timestamps = true;
 }