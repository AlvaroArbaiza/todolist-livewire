<?php

namespace App\Livewire;

use App\Models\User;

use Hash;
use Livewire\Component;
use Livewire\Attributes\Rule;
use Livewire\WithPagination;

class Clicker extends Component
{
    // Pagination
    use WithPagination;

    // Se la variabile è public possiamo usarla direttamente nel component
    public $count = 1;

    // validazione con #[Rule] attribute
    #[Rule('required', message: 'The name is required')]
    #[Rule('min:3', message: 'This name is too short')]
    #[Rule('max:50', message: 'This name is too large')]
    public $name = '';

    #[Rule('required', message: 'The email is required')]
    #[Rule('email:filter', message: 'A valid email must be entered')]
    #[Rule('unique:users', message: 'This email already exists')]
    public $email = '';

    #[Rule('required', message: 'The password is required')]
    #[Rule('min:5', message: 'The password must be longer than 5 characters')]
    public $password = '';

    public function createUser() {

        // validazione dati ricevuti
        $validated = $this->validate();

        // creazione user e salvataggio record nella tabella users
        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password'])
        ]);

        // reset i valori dopo aver creato il record
        $this->reset([
            'name',
            'email',
            'password'
        ]);

        // success
        session()->flash('success','Account registered successfully');
    }
 
    public function increment()
    {
        $this->count++;
    }
 
    public function decrement()
    {
        $this->count--;
    }

    // Declares a render() method that returns a Blade view. This Blade view will contain the HTML template for our component.
    public function render()
    {
        // pagination: x 3
        $users = User::paginate(3);

        return view('livewire.clicker', compact('users'));
    }
}
