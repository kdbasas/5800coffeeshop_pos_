<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    
    protected $table = 'employees';
    protected $primaryKey = 'employee_id';
    protected $fillable = [
        'employee_image', 'first_name', 'middle_name', 'last_name', 'suffix_name',
        'email','password', 'phone', 'address', 'gender_id', 'role',
    ];
    
    protected $appends = [
        'image_path',
    ];

    public function getImagePathAttribute()
    {
        return $this->employee_image ? asset('storage/' . $this->employee_image) : null;
    }

    public function gender()
    {
        return $this->belongsTo(Gender::class, 'gender_id');
    }
}    