<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class Profile extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'id',
        'created_at',
        'updated_at',
        'deleted_at',
        'ma_nummer',
        'ma_name',
        'ma_name_2',
        'ma_vorname',
        'ma_geburtsdatum',
        'ma_eingetreten',
        'ma_ausgetreten',
        'ma_telefon',
        'ma_mobil',
        'ma_fax',
        'ma_com_1',
        'ma_com_2',
        'group_id',
        'user_id',
        'ma_email'
    ];

    public function User()
    {
        return $this->belongsTo(User::class);
    }

    public function Location()
    {
        return $this->hasMany(Location::class);
    }

    public function building()
    {
        return $this->belongsTo(Building::class);
    }

    public function path()
    {
        return route('profile.show', $this);
    }

    public function fullName()
    {
        return $this->ma_vorname . ' ' . $this->ma_name ;
    }

    public function instructedOnEquipment()
    {
        return $this->hasMany(EquipmentInstruction::class,'equipment_instruction_trainee_id');

    }

    public function isQualified($id)
    : bool
    {
        return EquipmentQualifiedUser::where([
                [
                    'user_id',
                    $this->id
                ],
                [
                    'equipment_id',
                    $id
                ]
            ])->count() > 0;
    }
    public function isInstructed($id)
    : bool
    {
        return EquipmentInstruction::where([
                [
                    'equipment_instruction_trainee_id',
                    $this->id
                ],
                [
                    'equipment_id',
                    $id
                ]
            ])->count() > 0;
    }

    public function getNextEmployeeNumber()
    {
        $em = DB::table('profiles')->orderBy('ma_nummer', 'desc')->first();
        return (is_integer($em->ma_nummer)) ? $em->ma_nummer + 1 : $em->ma_nummer . '_1';
    }

    public function addProfile(Request $request)
    {
        if (isset($request->employee) && isset($request->employee['name'])) {
            $employee = Profile::where('ma_name', $request->employee['name'])->first();
            if (!$employee) {
                $request->validate([
                    'employee.name'            => 'required|max:100',
                    'employee.first_name'      => '',
                    'employee.name_2'          => '',
                    'employee.date_birth'      => 'date_format:Y-m-d',
                    'employee.employee_number' => 'max:100',
                    'employee.date_entry'      => 'date_format:Y-m-d',
                    'employee.date_leave'      => 'nullable|date_format:Y-m-d',
                    'employee.phone'           => '',
                    'employee.mobile'          => '',
                    'employee.fax'             => '',
                    'employee.com_1'           => '',
                    'employee.com_2'           => '',
                ]);
                $profile = new Profile();
                $profile->ma_name = $request->employee['name'];
                $profile->ma_vorname = (isset($request->employee['first_name'])) ? $request->employee['first_name'] : null;
                $profile->ma_name_2 = (isset($request->employee['name_2'])) ? $request->employee['name_2'] : null;
                $profile->ma_geburtsdatum = (isset($request->employee['date_birth'])) ? $request->employee['date_birth'] : null;
                $profile->ma_nummer = (isset($request->employee['employee_number'])) ? $request->employee['employee_number'] : null;
                $profile->ma_eingetreten = (isset($request->employee['date_entry'])) ? $request->employee['date_entry'] : date('Y-m-d');
                $profile->ma_ausgetreten = (isset($request->employee['date_leave'])) ? $request->employee['date_leave'] : null;
                $profile->ma_telefon = (isset($request->employee['phone'])) ? $request->employee['phone'] : null;
                $profile->ma_mobil = (isset($request->employee['mobile'])) ? $request->employee['mobile'] : null;
                $profile->ma_fax = (isset($request->employee['fax'])) ? $request->employee['fax'] : null;
                $profile->ma_com_1 = (isset($request->employee['com_1'])) ? $request->employee['com_1'] : null;
                $profile->ma_com_2 = (isset($request->employee['com_2'])) ? $request->employee['com_2'] : null;
                $profile->save();
                return $profile->id;
            } else {
                return $employee->id;
            }
        } elseif (isset($request->employee_id)) {
            return (Profile::find($request->employee_id)) ? $request->employee_id : null;
        }
        return null;
    }

    public function addProfileData($data)
    : int
    {
        if (isset($data['name'])) {
            $employee = Profile::where('ma_name', $data['name'])->first();
            if (!$employee) {
                $profile = new Profile();
                $profile->ma_name = $data['name'];
                $profile->ma_vorname = (isset($data['first_name'])) ? $data['first_name'] : null;
                $profile->ma_name_2 = (isset($data['name_2'])) ? $data['name_2'] : null;
                $profile->ma_geburtsdatum = (isset($data['date_birth'])) ? $data['date_birth'] : null;
                $profile->ma_nummer = (isset($data['employee_number'])) ? $data['employee_number'] : null;
                $profile->ma_eingetreten = (isset($data['date_entry'])) ? $data['date_entry'] : date('Y-m-d');
                $profile->ma_ausgetreten = (isset($data['date_leave'])) ? $data['date_leave'] : null;
                $profile->ma_telefon = (isset($data['phone'])) ? $data['phone'] : null;
                $profile->ma_mobil = (isset($data['mobile'])) ? $data['mobile'] : null;
                $profile->ma_fax = (isset($data['fax'])) ? $data['fax'] : null;
                $profile->ma_com_1 = (isset($data['com_1'])) ? $data['com_1'] : null;
                $profile->ma_com_2 = (isset($data['com_2'])) ? $data['com_2'] : null;
                $profile->save();
                return $profile->id;
            } else {
                return $employee->id;
            }
        } elseif (isset($data['profile_id'])) {
            return (Profile::find($data['profile_id'])) ? $data['profile_id'] : 0;
        }
        return 0;
    }

    public function addNew(Request $request)
    {
        $this->ma_name = $request->ma_name;
        $this->ma_vorname = $request->ma_vorname ?? null;
        $this->ma_geburtsdatum = $request->ma_geburtsdatum ?? null;
        $this->ma_nummer = $request->ma_nummer ?? null;
        $this->ma_eingetreten = $request->ma_eingetreten ?? date('Y-m-d');
        $this->ma_telefon = $request->ma_telefon ?? null;
        $this->user_id = $request->user_id ?? Auth::user()->id;

        $this->save();

        return $this->id;
    }

    public function removeEmployee(Request $request)
    {
        return Profile::destroy($request->id) ;
    }

    /**
     * @return array
     */
    public function validateProfile()
    : array
    {
        return request()->validate([
            'ma_nummer'       => [
                'bail',
                'max:100',
                Rule::unique('profiles')->ignore(\request('id'))
            ],
            'ma_vorname'      => 'max:100',
            'user_id'         => 'nullable|interger',
            'ma_name'         => 'bail|max:100|required',
            'ma_name_2'       => '',
            'ma_geburtsdatum' => '',
            'ma_eingetreten'  => '',
            'ma_ausgetreten'  => '',
            'ma_telefon'      => '',
            'ma_mobil'        => '',
            'ma_fax'          => '',
            'ma_com_1'        => '',
            'ma_com_2'        => '',
            'group_id'        => '',
        ]);
    }

    public function getEntry(array $employee)
    {

        if (isset($employee['id'])) {
            $getEmployee = Profile::find($employee['id']);
            return $getEmployee->id;
        }

        $getEmployee = Profile::where([
            ['ma_vorname' , $employee['first_name'] ],
            ['ma_name' , $employee['last_name'] ],
        ])->first();
        return $getEmployee->id;
    }

}
