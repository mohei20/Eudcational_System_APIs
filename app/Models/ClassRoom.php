<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClassRoom extends Model
{
    const WAITING = '0';
    const REQISTERED = '3';

    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'prerequisite_exam',
        'status',
        'registration_deadline',
        'start_date',
        'max_capacity',
        'min_grade',
        'min_selected',
        'branch_id',
        'subject_id',
        'teacher_id'
    ];

    public function student()
    {
        return $this->belongsToMany(Student::class, 'classroom_student')->withPivot('status')->withTimestamps();
    }

    public function attendance()
    {
        return $this->hasMany(Attendance::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function exams()
    {
        return $this->hasMany(Appointment::class);
    }

    public function scopeStatus($query)
    {
        return $query->where('status', '1');
    }

    public function scopeBranchId($query, $branchId)
    {
        return $query->where('branch_id', $branchId);
    }

    public function scopeTeacherId($query, $teacherId)
    {
        return $query->where('teacher_id', $teacherId);
    }

    public function scopeSubjectId($query, $subjectId)
    {
        return $query->where('subject_id', $subjectId);
    }

}
