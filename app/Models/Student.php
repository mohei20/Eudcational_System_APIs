<?php

namespace App\Models;

use App\Models\ClassRoom;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Student extends Authenticatable implements JWTSubject
{
    use HasFactory,  HasApiTokens, Notifiable;
    protected $guarded = [];



    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function classRoom()
    {
        return $this->belongsToMany(ClassRoom::class, 'classroom_student')->withPivot('status')->withTimestamps();
    }

    public function attendance()
    {
        return $this->hasMany(Attendance::class, 'student_id');
    }


    public function yearNameFormat($name)
    {
        switch ($name) {
            case 1:
                return "الصف الاول الثانوى";
            case 2:
                return  "الصف الثانى الثانوى";
            case 3:
                return  "الصف الثالث الثانوى";
            default:
                break;
        }
    }

    public function divisionNameFormat($name)
    {

        switch ($name) {
            case '1':
                $name = "عام";
                break;
            case '2':
                $name =  "علمي";
                break;
            case '3':
                $name = "ادبي";
                break;
            case '4':
                $name = "علمي رياضه";
                break;
            case '5':
                $name =  "علمي علوم";
                break;
            default:
                break;
        }
        return $name;
    }


    public function FormatStatusAttendance($val)
    {
        switch ($val) {
            case '0':
                return "غايب";
            case '1':
                return "حاضر";
            case '2':
                return "حضور ودفع المال";
            default:
                break;
        }
    }

}

