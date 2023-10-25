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
    #[Rule('nullable')]
    #[Rule('date', message: 'Must be of type date.')]
    #[Rule('date_format:Y-m-d\TH:i', message: 'Invalid deadline format')]
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
                'deadline' => 'nullable|date|date_format:Y-m-d\TH:i'
            ]);
        } else {

            // validation name
            $validated = $this->validateOnly('name');
        }

        // create
        ToDo::create($validated);

        // reset: reset di variabili name e deadline
        $this->reset([
            'name',
            'deadline'
        ]);

        // success: messaggio creato quando viene creata una task
        session()->flash('success','Created!');

        // reset pagination: la paginazione torna in posizione quando si crea una task
        $this->resetPage();

        // cancelEdit: l'edit di una task aperta verrà chiusa 
        $this->cancelEdit();
    }

    // toggle: questo metodo trova l'ID dell'elemento, inverte il suo stato(completed), salva e aggiorna il record
    public function toggle($todoID) {
        $todo = ToDo::find($todoID);

        $todo->completed = !$todo->completed;
        $todo->save();
    }

    // edit: metodo che apre la possibilità di modificare il nome della task
    public function edit($todoID) {

        $this->editTodoID = $todoID;
        $this->editName = ToDo::find($todoID)->name;
    }

    // delete: metodo per la cancellazione della task
    public function delete($todoID) {

        // cancellazione della task risalendo dall'ID
        try {

            ToDo::findorFail($todoID)->delete();

        // In caso di errore comparira un messaggio error
        } catch(Exception $e) {
            // error
            session()->flash('error','Failed to delete todo!');
            return;
        }
    }

    // Cancel Edit: resetta le variabili per l'editing
    public function cancelEdit() {
        $this->reset('editTodoID','editName');
    }

    // Update: metodo che aggiorna il nome della task risalendo ad essa tramite l'ID
    public function update() {
        // validation editName
        $this->validateOnly('editName');

        ToDo::find($this->editTodoID)->update([
            'name' => $this->editName
        ]);

        // cancel editing
        $this->cancelEdit();
    }

    public function render()
    {

        // creazione query
        $query = ToDo::query();

        ///// filter: filtraggio tasks
        // se completed è false e la deadline è null
        if ($this->filter === 'active') {
            $todos = $query->where('completed', false)->whereNull('deadline')->get();

        // se completed è true
        } elseif ($this->filter === 'completed') {
            $todos = $query->where('completed', true)->get();

        // se deadline non è null
        } elseif ($this->filter === 'with_deadline') {
            $todos = $query->whereNotNull('deadline')->get();
        }


        ///// sort: ordine tasks
        // dal più recente
        if ($this->sort === 'latest') {
            $query->latest();

        // dall'ultimo creato
        } elseif ($this->sort === 'oldest') {
            $query->oldest();

        // dalla scadenza più recente
        } elseif ($this->sort === 'due_soonest') {
            $query->whereNotNull('deadline')->orderBy('deadline');

        // dalla scadenza più lontana
        } elseif ($this->sort === 'due_latest') {
            $query->whereNotNull('deadline')->orderByDesc('deadline');
        }

        // query per la ricerca: dove name è this->search e con una paginazione di 6 tasks per volta
        $todos = $query->where('name', 'like', "%{$this->search}%")->paginate(6);

        return view('livewire.todo-list', [
            'todos' => $todos
        ]);
    }
}
