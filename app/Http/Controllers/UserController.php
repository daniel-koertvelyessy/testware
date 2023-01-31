<?php

    namespace App\Http\Controllers;

    use App\AnforderungControlItem;
    use App\EquipmentInstruction;
    use App\EquipmentQualifiedUser;
    use App\ProductInstructedUser;
    use App\ProductQualifiedUser;
    use App\User;
    use Illuminate\Auth\Access\AuthorizationException;
    use Illuminate\Contracts\Foundation\Application;
    use Illuminate\Contracts\View\Factory;
    use Illuminate\Contracts\View\View;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Http\Request;
    use Illuminate\Http\Response;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Str;
    use Illuminate\Validation\Rule;
    use Illuminate\Validation\Rules\Password;


    class UserController extends Controller
    {

        public function __construct()
        {
            $this->middleware('auth');
        }

        /**
         * Display a listing of the resource.
         *
         * @return Application|Factory|View
         */
        public function index()
        {
            /*
            ** if a restoring of deleted useres is prefered exchange this section with the simple return
            if (Auth::user()->isSysAdmin()) {
                $userList = User::with('roles')->withTrashed()->sortable()->paginate(15);
            } else {
                $userList = User::with('roles')->sortable()->paginate(15);
            }*/
            return view('admin.user.index',
                ['userList' => User::with('roles')->sortable()->paginate(15)]
            );
        }

        /**
         * Display a listing of the resource.
         *
         * @return Application|Factory|View
         */
        public function ldap()
        {
            return view('admin.user.ldap', ['userList' => User::with('roles')->sortable()->paginate(15)]);
        }

        /**
         * Show the form for creating a new resource.
         */
        public function create(Request $request)
        {
            if (Auth::user()->isSysAdmin()) {
                return view('admin.user.create');
            } else {
                $request->session()->flash('status',
                    __('Sie haben keine Berechtigung Benutzer anzulegen!'));
                return redirect()->route('user.index',
                    ['userList' => User::with('roles')->sortable()->paginate(15)]);
            }
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param Request $request
         *
         * @return RedirectResponse
         */
        public function store(Request $request): RedirectResponse
        {
            $this->validateUser();
            (new User)->addNew($request);
            return redirect()->route('user.index',
                ['users' => User::with('roles')->get()]);

        }


        private function validateNewPassword()
        {
            return request()->validate([
                'setpassword'          => [
                    'required',
                    'string',
                    'confirmed',
                    Password::default(),
                ],
                'setpassword_confirmation' => [
                    'required',
                    'string'
                ]
            ]);

        }
        /**
         * @return array
         */
        private function validateUser(): array
        {
            return request()->validate([
                'username'          => [
                    'bail',
                    'string',
                    'required',
                    'max:255',
                    Rule::unique('users')->ignore(\request('id'))
                ],
                'email'             => [
                    'bail',
                    'required',
                    'email',
                    'max:255',
                    Rule::unique('users')->ignore(\request('id'))
                ],
                'email_verified_at' => '',
                'password'          => [
                    'required',
                    'string',
                    'confirmed',
                    Password::default(),
                ],
                'api_token'         => 'nullable',
                'name'              => 'nullable',
                'role_id'           => 'nullable',
                'signature'         => 'nullable',
            ], [
                'username.required' => __('Ihr Anzeigename ist notwendig'),
                'username.unique'   => __('Der Anzeigename ist bereits vergeben'),
                'email.required'    => __('Die E-Mail Adress ist notwendig!'),
                'email.unique'      => __('Die E-Mail Adress ist bereits in Benutzung'),
            ]);
        }


        /**
         * Display the specified resource.
         *
         * @param User $user
         *
         * @return Application|Factory|View
         */
        public function show(User $user)
        {
            return view('admin.user.show', [
                'user'  => $user,
                'roles' => $user->roles,
                'isCurrentUser' => Auth::user()->id === $user->id,
                'isSysAdmin' => Auth::user()->isSysAdmin()
            ]);
        }

        /**
         * Show the form for editing the specified resource.
         *
         * @param User $user
         *
         * @return Response
         */
        public function edit(User $user)
        {
            //
        }

        /**
         * Update the specified resource in storage.
         *
         * @param Request $request
         * @param User $user
         *
         * @return RedirectResponse
         */
        public function update(Request $request, User $user)
        {

            if(Auth::user()->id === $user->id || Auth::user()->isSysAdmin()) {
                $user->update($this->validateUser());
                $request->session()->flash('status',
                    __('Ihr Konto wurde aktualisiert!'));
            } else {
                $request->session()->flash('status',
                    __('Sie haben keine Berechtigung zum Ändern der Benutzerdaten!'));
            }
            return back();
        }

        /**
         * Update user from systems view.
         *
         * @param Request $request
         *
         * @return RedirectResponse
         */
        public function updatedata(Request $request): RedirectResponse
        {
            if(Auth::user()->id == $request->id || Auth::user()->isSysAdmin()) {
                $msg = ((new User)->updateData($request))
                    ? __('Die Benutzerdaten wurden aktualisiert!')
                    : __('Fehler!');

            } else {
                $msg = __('Sie haben keine Berechtigung zum Ändern der Benutzerdaten!');
            }
            $request->session()->flash('status', ['header'=>'Erfolg','body'=>$msg]);
            return back();
        }


        /**
         * Remove the specified resource from storage.
         *
         * @param User $user
         *
         * @return RedirectResponse
         */
        public function destroy(Request $request): RedirectResponse
        {
            $user_id = $request->id;
            ProductInstructedUser::where('product_instruction_trainee_id',
                $user_id)->delete();
            ProductQualifiedUser::where('user_id', $user_id)->delete();
            EquipmentInstruction::where('equipment_instruction_trainee_id',
                $user_id)->delete();
            EquipmentQualifiedUser::where('user_id', $user_id)->delete();


            if (User::find($user_id)->delete()) {
                request()->session()->flash('status',
                    __('Der Benutzer wurde gelöscht!'));
            }
            return redirect()->route('user.index');
        }

        /**
         * Show the form for editing the specified resource.
         *
         * @param int $user
         *
         * @return RedirectResponse
         */
        public function restore(int $id): RedirectResponse
        {
            if (Auth::user()->isSysAdmin()) {
                $user = User::withTrashed()->where('id', $id)->first();
                if ($user->restore()) {
                    request()->session()->flash('status',
                        __('Der Benutzer wurde wiederhergestellt!'));
                    return redirect()->route('user.show', $user);
                }
            }
            return back();
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param Request $request
         *
         * @return RedirectResponse
         * @throws AuthorizationException
         */
        public function revokerole(Request $request): RedirectResponse
        {
            $this->authorize('isAdmin', Auth()->user());
            User::find($request->user_id)->roles()->detach($request->role_id);
            return back();
        }

        /**
         * Add Role to user
         *
         * @param Request $request
         *
         * @return RedirectResponse
         * @throws AuthorizationException
         */
        public function grantrole(Request $request): RedirectResponse
        {
            $this->authorize('isAdmin', Auth()->user());
            User::find($request->user_id)->roles()->sync($request->roleuser);
            return back();
        }

        /**
         * Revoke user as SysAdmin
         *
         * @param User $user
         *
         * @return RedirectResponse
         * @throws AuthorizationException
         */
        public function revokeSysAdmin(User $user): RedirectResponse
        {
            $this->authorize('isAdmin', Auth()->user());
            $user->role_id = 0;
            $user->update();
            return back();
        }

        /**
         * Revoke user as SysAdmin
         *
         * @param User $user
         *
         * @return RedirectResponse
         * @throws AuthorizationException
         */
        public function grantSysAdmin(User $user): RedirectResponse
        {
            $this->authorize('isAdmin', Auth()->user());
            $user->role_id = 1;
            $user->update();
            return back();
        }

        public function addTokenToUser(User $user): RedirectResponse
        {
            $user->api_token = Str::random(80);
            $user->save();
            session()->flash('status',
                __('Ein Token wurde erfolgreich zugewiesen!'));
            return redirect()->back();
        }


        public function resetPassword(Request $request): RedirectResponse
        {
            $this->validateNewPassword();
            if(Auth::user()->id === $request->id || Auth::user()->isSysAdmin()) {
                if (isset($request->setpassword) && $request->setpassword_confirmation === $request->setpassword) {
                    (new User)->updatePassword($request->setpassword, Auth::user());
                    session()->flash('status', __('Passwort wurde aktualisiert!'));
                }
            } else{
                session()->flash('status', __('Sie haben keine Berechtigung!'));
            }

            return back();
        }

        public function setPassword(Request $request): RedirectResponse
        {
            $this->validateNewPassword();
            if (isset($request->setpassword) && $request->setpassword_confirmation === $request->setpassword) {
               (new User)->updatePassword($request->setpassword, User::find($request->id));
                session()->flash('status', __('Passwort wurde jetzt aktualisiert!'));
            }
            return back();
        }

        public function setMsgRead(Request $request)
        {
            auth()->user()->unreadNotifications->markAsRead();
            return back();
        }

        public function checkUserEmailAddressExists(Request $request): array
        {
            return ['exists' => User::where('email', $request->term)->count() > 0];
        }

        public function checkUserUserNameExists(Request $request): array
        {
            return [
                'exists' => User::where('username', $request->term)->count() > 0
            ];
        }
    }
