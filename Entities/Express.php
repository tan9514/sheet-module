<?php
/**
 * Created By PhpStorm.
 * User: Li Ming
 * Date: 2021-08-23
 * Fun:
 */

namespace Modules\Sheet\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Schema;

class Express extends BaseModel
{
    use HasFactory;
    protected $table = "express";
}