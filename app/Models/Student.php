<?php

namespace App\Models;

use Attribute;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


//status: 1 = Good Standing; 2 = Probation;

class Student extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'title_id',
        'user_id',
        'user_type',
        'student_role_id',
        'reg_no',
        'matric_no',
        'fname',
        'mname',
        'lname',
        'email',
        'password',
        'username',
        'state_id',
        'country_id',
        'gender',
        'dob',
        'lga_name',
        'city',
        'religion',
        'marital_status',
        'address',
        'phone',
        'passport',
        'signature',
        'hobbies',
        'is_hostel'

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course_regs()
    {
        return $this->hasMany(CourseReg::class);
    }

    public function registration_process()
    {
        return $this->hasMany(RegistrationProcess::class);
    }

    public function waiver_student()
    {
        return $this->hasOne(WaiverStudent::class);
    }

    public function transfer_student()
    {
        return $this->hasOne(TransferStudent::class);
    }

    public function scholarship_student()
    {
        return $this->hasOne(ScholarshipStudent::class);
    }

    public function student_contact()
    {
        return $this->hasOne(StudentContact::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function getPassportBase64Attribute()
    {
        if ($this->passport && \Illuminate\Support\Facades\Storage::exists('public/' . $this->passport)) {
            $path = \Illuminate\Support\Facades\Storage::path('public/' . $this->passport);
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            return 'data:image/' . $type . ';base64,' . base64_encode($data);
        }
        return null;
    }

    public function remitas()
    {
        return $this->hasMany(Remita::class);
    }

    public function student_academic()
    {
        return $this->hasOne(StudentAcademic::class);
    }

    public function student_medical()
    {
        return $this->hasOne(StudentMedical::class);
    }

    public function student_wallet()
    {
        return $this->hasOne(StudentWallet::class);
    }

    public function result_correction()
    {
        return $this->hasMany(ResultCorrection::class);
    }

    public function correction_requests()
    {
        return $this->hasMany(CorrectionRequest::class);
    }

    public function auxiliary_staff()
    {
        return $this->hasMany(AuxiliaryStaff::class, 'user_id', 'user_id');
    }

    public function student_role()
    {
        return $this->belongsTo(StudentRole::class);
    }

/*     public function vuna_accomodation_history()
    {
        return $this->hasOne(VunaAccomodationHistory::class);
    } */

    public function vuna_accomodation_history()
    {
        return $this->hasMany(VunaAccomodationHistory::class);
    }

    public function tuition_fees()
    {
        return $this->hasMany(TuitionFee::class);
    }

    public function acceptance_fees()
    {
        return $this->hasMany(AcceptanceFee::class);
    }

    public function tuition_fee_pgs()
    {
        return $this->hasMany(TuitionFeePg::class);
    }

    public function other_fee_trans()
    {
        return $this->hasMany(OtherFeeTran::class);
    }

    public function summer_payment()
    {
        return $this->hasOne(SummerPayment::class);
    }

}
