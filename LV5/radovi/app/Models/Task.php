<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
    'user_id',
    'naziv_rada',
    'naziv_rada_en',
    'zadatak_rada',
    'tip_studija',
    'accepted_student_id',
];

    public function nastavnik()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function applicants()
{
    return $this->belongsToMany(User::class, 'student_task', 'task_id', 'student_id')->withTimestamps();
}

public function acceptedStudent()
{
    return $this->belongsTo(User::class, 'accepted_student_id');
}
}