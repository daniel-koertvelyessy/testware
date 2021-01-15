<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        'user_id'
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
                $profile->ma_vorname = (isset($request->employee['first_name'])) ? $request->employee['first_name'] : NULL;
                $profile->ma_name_2 = (isset($request->employee['name_2'])) ? $request->employee['name_2'] : NULL;
                $profile->ma_geburtsdatum = (isset($request->employee['date_birth'])) ? $request->employee['date_birth'] : NULL;
                $profile->ma_nummer = (isset($request->employee['employee_number'])) ? $request->employee['employee_number'] : NULL;
                $profile->ma_eingetreten = (isset($request->employee['date_entry'])) ? $request->employee['date_entry'] : date('Y-m-d');
                $profile->ma_ausgetreten = (isset($request->employee['date_leave'])) ? $request->employee['date_leave'] : NULL;
                $profile->ma_telefon = (isset($request->employee['phone'])) ? $request->employee['phone'] : NULL;
                $profile->ma_mobil = (isset($request->employee['mobile'])) ? $request->employee['mobile'] : NULL;
                $profile->ma_fax = (isset($request->employee['fax'])) ? $request->employee['fax'] : NULL;
                $profile->ma_com_1 = (isset($request->employee['com_1'])) ? $request->employee['com_1'] : NULL;
                $profile->ma_com_2 = (isset($request->employee['com_2'])) ? $request->employee['com_2'] : NULL;
                $profile->save();
                return $profile->id;
            } else {
                return $employee->id;
            }
        } elseif (isset($request->employee_id)) {
            return (Profile::find($request->employee_id)) ? $request->employee_id : NULL;
        }
        return NULL;
    }

    public function addProfileData($data)
    : int
    {
        if (isset($data['name'])) {
            $employee = Profile::where('ma_name', $data['name'])->first();
            if (!$employee) {
                $profile = new Profile();
                $profile->ma_name = $data['name'];
                $profile->ma_vorname = (isset($data['first_name'])) ? $data['first_name'] : NULL;
                $profile->ma_name_2 = (isset($data['name_2'])) ? $data['name_2'] : NULL;
                $profile->ma_geburtsdatum = (isset($data['date_birth'])) ? $data['date_birth'] : NULL;
                $profile->ma_nummer = (isset($data['employee_number'])) ? $data['employee_number'] : NULL;
                $profile->ma_eingetreten = (isset($data['date_entry'])) ? $data['date_entry'] : date('Y-m-d');
                $profile->ma_ausgetreten = (isset($data['date_leave'])) ? $data['date_leave'] : NULL;
                $profile->ma_telefon = (isset($data['phone'])) ? $data['phone'] : NULL;
                $profile->ma_mobil = (isset($data['mobile'])) ? $data['mobile'] : NULL;
                $profile->ma_fax = (isset($data['fax'])) ? $data['fax'] : NULL;
                $profile->ma_com_1 = (isset($data['com_1'])) ? $data['com_1'] : NULL;
                $profile->ma_com_2 = (isset($data['com_2'])) ? $data['com_2'] : NULL;
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
}
