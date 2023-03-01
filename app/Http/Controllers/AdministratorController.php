<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Course;
use App\Models\Account;
use App\Models\TeacherInfo;
use Spatie\Permission\Models\Role;
use App\Traits\DefaultSettingTraits;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\AdministratorStoreRequest;

class AdministratorController extends Controller
{

    use DefaultSettingTraits;

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('ms.administrator.index');
    }

    /**
     * @param  \Illuminate\Http\Request    $request
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = $this->roleName();

        return view('ms.administrator.create', compact('roles'));
    }

    /**
     * @param  \App\Http\Requests\AdministratorStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdministratorStoreRequest $request)
    {

        $user = User::query();

        $userData['name']     = $request->name;
        $userData['email']    = $request->email;
        $userData['phone_no'] = $request->phone_no;
        $userData['dob']      = $request->dob;
        $userData['gender']   = $request->gender;
        $userData['address']  = $request->address;
        $userData['password'] = Hash::make($request->password);

        $user = $user->create($userData);

        $teacherData['curriculum']     = $request->curriculum;
        $teacherData['institute']      = $request->institute;
        $teacherData['teaching_level'] = $request->teaching_level;
        $teacherData['user_id']        = $user->id;

        TeacherInfo::create($teacherData);

        $user->assignRole($request->user_role);

        $this->defaultSetting($user->id);

        return redirect()->route('administrator.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User            $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $administrator)
    {

        $roles = $this->roleName();

        if ($administrator->hasRole('Super Admin')) {

            return view('ms.administrator.super-admin-edit', compact('administrator', 'roles'));
        }

        $teacherInfo = TeacherInfo::where('user_id', $administrator->id)->get();

        return view('ms.administrator.edit', compact('administrator', 'teacherInfo', 'roles'));
    }

    public function roleName()
    {
        return Role::WhereNotIn('name', ['Student'])->get();
    }


    public function generatePayments()
    {
        $courses = Course::all(["id", "fee"]);

        foreach ($courses as $course) {
            $accountsCount = Account::whereMonth("month", Carbon::today())->where("course_id", $course->id)->count();

            if ($accountsCount === 0) {
                generate_payments($course);
            }
        }

        return redirect()->back()->with("success", "Generated All User Payments Successfully");
    }
}