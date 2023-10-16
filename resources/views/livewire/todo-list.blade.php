{{-- To Do --}}
<div class="vh-100">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center h-100">
            <div class="col">
                <div class="card" id="todo">
                    <div class="card-body py-4 px-4 px-md-5">

                        {{-- error --}}
                        @if (session('error'))
                            
                            <div class="alert alert-danger" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif
        
                        {{-- HEADER --}}
                        @include('livewire.includes.header')
            
                        {{-- Create ToDo --}}
                        @include('livewire.includes.todo.create-todo')
            
                        <hr class="my-4">
            
                        <div class="d-flex justify-content-between align-items-center mb-4 pt-2 pb-3">

                            {{-- Search --}}
                            @include('livewire.includes.todo.search-todo')

                            <div class="d-flex justify-space-center align-items-center">

                                {{-- Filter --}}
                                <p class="small mb-0 me-2 text-muted">Filter</p>

                                {{-- select --}}
                                <select 
                                    wire:model.change="filter" class="select-input form-select"
                                >
                                    <option value="all">All</option>
                                    <option value="completed">Completed</option>
                                    <option value="active">Active</option>
                                    <option value="with_deadline">Has due date</option>
                                </select>
    
                                {{-- Sort --}}
                                <p class="small mb-0 ms-4 me-2 text-muted">Sort</p>

                                {{-- select --}}
                                <select 
                                    wire:model.change="sort"  class="select-input form-select"
                                >
                                    <option value="latest">Latest</option>
                                    <option value="oldest">Oldest</option>
                                    <option value="due_soonest">Due soonest</option>
                                    <option value="due_latest">Due latest</option>
                                </select>

                                <a style="color: #23af89;" data-mdb-toggle="tooltip" title="Ascending">
                                    <svg class="ms-2" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-sort-down-alt" viewBox="0 0 16 16">
                                        <path d="M3.5 3.5a.5.5 0 0 0-1 0v8.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L3.5 12.293V3.5zm4 .5a.5.5 0 0 1 0-1h1a.5.5 0 0 1 0 1h-1zm0 3a.5.5 0 0 1 0-1h3a.5.5 0 0 1 0 1h-3zm0 3a.5.5 0 0 1 0-1h5a.5.5 0 0 1 0 1h-5zM7 12.5a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 0-1h-7a.5.5 0 0 0-.5.5z"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
            
                        {{-- Todo Group --}}
                        @if(count($todos))
                            @foreach($todos as $todo)
                                @include('livewire.includes.todo.todo-group')
                            @endforeach

                            {{-- pagination --}}
                            <div class="mt-4">

                                {{ $todos->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>