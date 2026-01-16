<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Control extends Model
{
    use HasFactory;

    /**
     * ชื่อตารางในฐานข้อมูล (Optional: ปกติ Laravel จะเดาถูกว่าเป็น controls แต่ใส่ไว้เพื่อความชัวร์)
     */
    protected $table = 'controls';

    /**
     * กำหนด Primary Key เป็น 'pk' (ค่าเริ่มต้นคือ 'id')
     */
    protected $primaryKey = 'pk';

    /**
     * ปิดการใช้งาน timestamps (created_at, updated_at)
     * เพราะใน Migration เราเอาออกไปแล้ว
     */
    public $timestamps = false;

    /**
     * รายชื่อคอลัมน์ที่อนุญาตให้เพิ่มข้อมูลได้ (Mass Assignment)
     * จำเป็นมากสำหรับการ Import ข้อมูลเข้าฐานข้อมูล
     */
    protected $fillable = [
        'NO',
        'ID',
        'REG',
        'CWT',
        'PROVINCE',
        'AMP',
        'DISTRICT',
        'TAM',
        'SUB_DIST',
        'MUN',
        'VIL',
        'EA',
        'YR',
        'STREET',
        'SOI',
        'BUILDING',
        'ADD_NO',
        'ECON_ACT',
        'TYPE',
        'INVEST',
        'E_MAIL',
        'TEL_NO',
        'FAX_NO',
        'WEB_SITE',
        'TSIC_CODE',
        'SIZE12',
        'TITLE',
        'FIRSTNAME',
        'LASTNAME',
        'EST_NAME',
        'ADD_NO_2',
        'EST_TITLE_2',
        'FIRSTNAME_2',
        'LASTNAME_2',
        'EST_NAME_2',
        'STREET_2',
        'BLK_2',
        'BUILDING_2',
        'SUB_DIST_2',
        'DISTRICT_2',
        'PROVINCE_2',
    ];
}
