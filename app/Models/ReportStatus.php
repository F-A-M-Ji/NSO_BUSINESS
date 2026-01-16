<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportStatus extends Model
{
    use HasFactory;

    protected $table = 'reports_status';

    protected $primaryKey = 'pk';
    public $timestamps = false;
    protected $fillable = [
        'ID',
        'REG',
        'CWT',
        'NO',
        'YR',
        'isSend',
        'isApprove',
        'send_time',
        'approve_time',
        'isWrong',
        'messages',
    ];

    // บอก Laravel ว่าฟิลด์ไหนเป็นวันที่ (เพื่อให้แปลงเป็น Carbon Object อัตโนมัติ)
    protected $casts = [
        'send_time' => 'datetime',
        'approve_time' => 'datetime',
    ];
}