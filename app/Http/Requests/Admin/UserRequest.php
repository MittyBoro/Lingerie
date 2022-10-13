<?php

namespace App\Http\Requests\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

use Propaganistas\LaravelPhone\PhoneNumber;

class UserRequest extends AdminFormRequest
{

    public function authorize()
    {
        // первого редактирует только первый
        if ( $this->user->id == 1 && Auth::id() != $this->user->id ) {
            return false;
        }

        // нельзя менять свои права
        if ( $this->user->id == Auth::id() && ( $this->get('role') && $this->get('role') !== User::ROLE_ADMIN ) ) {
            return false;
        }

        // нельзя  «неадмину» повышатьдо админа
        if ( !Auth::user()->is_admin && $this->user->role == User::ROLE_ADMIN  ) {
            return false;
        }

        // нельзя «неадмину» редактировать других
        if ( $this->user->id != Auth::id() && !Auth::user()->is_admin  ) {
            return false;
        }

        return true;
    }

    public function rules()
    {
        $user = $this->user;

        if ( $this->get('password') ) {
            return $this->passwordRules($user);
        } else {
            return $this->editRules($user);
        }
    }

    public function editRules($user)
    {
        return [
            'name'       => 'nullable|string|min:3|max:225',
            'username'   => 'nullable|string|min:3|max:225|unique:users,username,'.$user->id,
            'email'     => 'email|min:3|max:225|unique:users,email,'.$user->id,
            'phone'     => 'nullable|phone:AUTO|unique:users,phone,'.$user->id,
            'role'       => Rule::in(User::ROLES),
            'admin_avatar'      => 'nullable',
            'admin_avatar.id'   => 'nullable|exists:media,id',
            'admin_avatar.file' => 'nullable|dimensions:min_width=100,min_height=100',
        ];
    }

    private function passwordRules($user)
    {
        $passwordRules = [
            'password'  => 'string|confirmed|min:6',
        ];

        if ( Auth::id() == $user->id )
        {
            $passwordRules += [
                'current_password' => ['required', function ($attribute, $value, $fail) use ($user) {
                    if (!Hash::check($value, $user->password))
                    {
                        return $fail('Неверный текущий пароль');
                    }
                }],
            ];
        }
        return $passwordRules;
    }

    public function getValidatorInstance()
    {
        $this->formatPhoneNumber();
        return parent::getValidatorInstance();
    }

    protected function formatPhoneNumber()
    {
        if ($this->phone)
            $this->merge(['phone' => PhoneNumber::make($this->phone)->formatE164()]);
    }
}
