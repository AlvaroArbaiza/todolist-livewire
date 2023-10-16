<?php

namespace App\Livewire;

use Exception;
use Livewire\Component;
use Livewire\Attributes\Rule;
use Livewire\WithPagination;

use App\Models\ToDo;


class TodoList extends Component
{
    // Pagination
    use WithPagination;

    // validazione con #[Rule] attribute
    #[Rule('required', message: 'The name is required')]
    #[Rule('min:3', message: 'This name is too short')]
    public $name = '';

    public $search;

    public $editTodoID;

    #[Rule('required', message: 'The name is required')]
    #[Rule('min:3', message: 'This name is too short')]
    public $editName;

    // create
    public function create() {

        // validation name
        $validated = $this->validateOnly('name');

        // create
        ToDo::create($validated);

        // reset
        $this->reset('name');

        // success
        session()->flash('success','Created!');

        // reset pagination
        $this->resetPage();

        // cancelEdit
        $this->cancelEdit();
    }

    // toggle: questo metodo trova l'ID dell'elemento, inverte il suo stato(completed) e salva
    public function toggle($todoID) {
        $todo = ToDo::find($todoID);

        $todo->completed = !$todo->completed;
        $todo->save();
    }

    // edit
    public function edit($todoID) {

        $this->editTodoID = $todoID;
        $this->editName = ToDo::find($todoID)->name;
    }

    // delete
    public function delete($todoID) {

        try {

            ToDo::findorFail($todoID)->delete();
        } catch(Exception $e) {
            // error
            session()->flash('error','Failed to delete todo!');
            return;
        }
    }

    // Cancel Edit
    public function cancelEdit() {
        $this->reset('editTodoID','editName');
    }

    // Update
    public function update() {
        // validation editName
        $this->validateOnly('editName');

        ToDo::find($this->editTodoID)->update([
            'name' => $this->editName
        ]);

        $this->cancelEdit();
    }

    public function render()
    {
        return view('livewire.todo-list', [
            'todos' => ToDo::latest()->where('name','like',"%".$this->search."%")->paginate(6)
        ]);
    }
}
