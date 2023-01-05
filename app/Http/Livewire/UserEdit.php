<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class UserEdit extends Component
{
    public $user_id;
    public $name;
    public $email;
    public $password;
    public $selectedRole;

    public function mount(){
        $user = User::findOrFail($this->user_id);
        $this->name = $user->name;
        $this->email = $user->email;
        $this->password = $user->password;
        if (isset($user->roles) && count($user->roles) > 0) {
            $this->selectedRole = $user->roles['0']->name;
        }
    }
    protected $rules = [
        'name' =>'required',
        'email' =>'required|email',
        'password' =>'required|min:6',
        'selectedRole' =>'required'
    ];
    public function render()
    {
        $roles = Role::all();
        return view('livewire.user-edit',['roles' => $roles]);
    }

    public function userUpdate()
    {
        $this->validate();
        $user = User::with('roles')->findOrFail($this->user_id);

        $user->name = $this->name;
        $user->email = $this->email;
        $user->password = Hash::make($this->password);
        $user->save();

        if (isset($user->roles) && count($user->roles)){
            $user->removeRole($user->roles[0]->name);
        }

        $user->assignRole($this->selectedRole);
        flash()->addSuccess('User has been updated!');
        return redirect()->route('user.index');
    }
}
