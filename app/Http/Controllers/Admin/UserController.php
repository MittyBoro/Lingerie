<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;

use App\Models\Admin\User;
use App\Http\Requests\Admin\UserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('admin.role:admin', ['except' => ['edit', 'update']]);
    }

    public function index(Request $request)
    {
        $users = User::filter($request->all())
                            ->with(['media'])
                            ->paginated();

        return Inertia::render('Users/Index', [
            'roles' => User::roleList(),
            'list' => $users,
        ]);
    }

    public function edit(User $user)
    {
        return Inertia::render('Users/Form', [
            'roles' => User::roleList(),
            'item' => $user->append('admin_avatar'),
        ]);
    }


    public function update(UserRequest $request, User $user)
    {
        $user->updateUser($request->validated());

        return back();
    }

    public function verify(User $user)
    {
        if (! $user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
        }

        return back();
    }


    public function destroy(User $user)
    {
        if ( $user->id == 1 )
            return back()->withErrors(['Нельзя удалить первого']);
        if ( $user->id == Auth::user()->id )
            return back()->withErrors(['Нельзя удалить себя']);

        $user->delete();

        return back();
    }
}
