<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EditReport extends Model
{
    use HasFactory;

    protected $table = 'edit_reports';

    protected $primaryKey = 'pk';

    protected $guarded = ['pk', 'created_at', 'updated_at'];
}
