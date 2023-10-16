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

    // deadline
    public $deadline;

    // search
    public $search;

    // filter
    public $filter = 'all';

    // sort
    public $sort = 'latest';

    public $editTodoID;

    #[Rule('required', message: 'The name is required')]
    #[Rule('min:3', message: 'This name is too short')]
    public $editName;

    // create
    public function create() {

        // Verifica se $deadline è impostata
        if ($this->deadline) {
            $validated = $this->validate([
                'name' => 'required|min:3', 
                'deadline' => 'date'
            ]);
        } else {

            // validation name
            $validated = $this->validateOnly('name');
        }

        // create
        ToDo::create($validated);

        // reset
        $this->reset([
            'name',
            'deadline'
        ]);

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

        $query = ToDo::query();

        // filter
        if ($this->filter === 'active') {
            $todos = $query->where('completed', false)->whereNull('deadline')->get();

        } elseif ($this->filter === 'completed') {
            $todos = $query->where('completed', true)->get();

        } elseif ($this->filter === 'with_deadline') {
            $todos = $query->whereNotNull('deadline')->get();
        }

        // sort
        if ($this->sort === 'latest') {
            $query->latest();
        } elseif ($this->sort === 'oldest') {
            $query->oldest();
        } elseif ($this->sort === 'due_soonest') {
            $query->whereNotNull('deadline')->orderBy('deadline');
        } elseif ($this->sort === 'due_latest') {
            $query->whereNotNull('deadline')->orderByDesc('deadline');
        }

        $todos = $query->where('name', 'like', "%{$this->search}%")->paginate(6);

        return view('livewire.todo-list', [
            'todos' => $todos
        ]);
    }
}
