<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\School;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'profesor_id',
        'school_id',
        'subject',
        'class_days',
        'class_schedule',
        'school_period',
        'tolerance',
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function profesor()
    {
        return $this->belongsTo(User::class, 'profesor_id');
    }

    public function alumnos()
    {
        return $this->belongsToMany(User::class, 'group_user', 'group_id', 'user_id');
    }
}

