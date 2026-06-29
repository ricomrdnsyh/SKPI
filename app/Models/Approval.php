<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Approval extends Model
{
    protected $table = 'approvals';
    protected $primaryKey = 'id_approval';
    public $timestamps = false;

    protected $fillable = [
        'approvable_type',
        'approvable_id',
        'role',
        'user_id',
        'status',
        'notes',
    ];
}
