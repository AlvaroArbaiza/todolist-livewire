{{-- wire:key è uno strumento di Livewire che tiene traccia delle modifiche in un elenco di elementi per applicare gli aggiornamenti in modo efficiente. --}}
<ul
    wire:key="{{ $todo->id }}" class="list-group list-group-horizontal rounded-0 bg-transparent"
>

    {{-- Checked --}}
    <li class="list-group-item d-flex align-items-center ps-0 pe-1 py-1 rounded-0 border-0 bg-transparent">

        {{-- Checkbox --}}
        <div class="form-check">
            @if ($todo->completed)
            
                <input
                    wire:click="toggle({{ $todo->id }})" class="form-check-input me-0 shadow-sm" type="checkbox" value=""  aria-label="..." checked
                />
            @else
                <input
                    wire:click="toggle({{ $todo->id }})" class="form-check-input me-0 shadow-sm" type="checkbox" value=""  aria-label="..."
                />
            @endif
            
        </div>
    </li>

    {{-- Name --}}
    <li class="list-group-item ps-1 pe-3 py-1 d-flex align-items-center flex-wrap flex-grow-1 border-0 bg-transparent">

        {{-- If Editing --}}
        @if ($editTodoID === $todo->id)
            <input
                wire:model="editName" class="form-control w-100" type="text" placeholder="To do.." aria-label=""
            >
            {{-- Error editName --}}
            @error('editName')
                <div class="w-100 text-danger ps-2 mt-1 mb-2">{{ $message }}</div>
            @enderror
        @else            
            <p class="lead fw-normal mb-0">
                {{ $todo->name }}
            </p>
        @endif
    </li>

    {{-- Deadline --}}
    @if ($todo->deadline)
        
    <li class="list-group-item px-3 py-1 d-flex align-items-center border-0 bg-transparent">
        <div
            class="py-2 px-3 me-2 border border-warning rounded-3 d-flex align-items-center bg-light">
            <p class="small mb-0">
                <a class="text-decoration-none" href="#!" data-mdb-toggle="tooltip" title="Due on date">
                    <svg class="me-2 text-warning" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-hourglass-split" viewBox="0 0 16 16">
                        <path d="M2.5 15a.5.5 0 1 1 0-1h1v-1a4.5 4.5 0 0 1 2.557-4.06c.29-.139.443-.377.443-.59v-.7c0-.213-.154-.451-.443-.59A4.5 4.5 0 0 1 3.5 3V2h-1a.5.5 0 0 1 0-1h11a.5.5 0 0 1 0 1h-1v1a4.5 4.5 0 0 1-2.557 4.06c-.29.139-.443.377-.443.59v.7c0 .213.154.451.443.59A4.5 4.5 0 0 1 12.5 13v1h1a.5.5 0 0 1 0 1h-11zm2-13v1c0 .537.12 1.045.337 1.5h6.326c.216-.455.337-.963.337-1.5V2h-7zm3 6.35c0 .701-.478 1.236-1.011 1.492A3.5 3.5 0 0 0 4.5 13s.866-1.299 3-1.48V8.35zm1 0v3.17c2.134.181 3 1.48 3 1.48a3.5 3.5 0 0 0-1.989-3.158C8.978 9.586 8.5 9.052 8.5 8.351z"/>
                    </svg>
                </a>
                {{ \Carbon\Carbon::parse($todo->deadline)->format('d M Y H:i')  }}
            </p>
        </div>
    </li>
    @endif

    {{-- Options --}}
    <li class="list-group-item ps-3 pe-0 py-1 rounded-0 border-0 bg-transparent">
        <div class="d-flex flex-row justify-content-end mb-2">

            {{-- Edit --}}
            <a 
                wire:click="edit({{ $todo->id }})" href="#" class="text-info text-decoration-none" data-mdb-toggle="tooltip" title="Edit todo"
            >
                <svg class="me-3" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                    <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"/>
                </svg>
            </a>

            {{-- Delete --}}
            <a 
                wire:click="delete({{ $todo->id }})" href="#" class="text-danger text-decoration-none" data-mdb-toggle="tooltip" title="Delete todo"
            >
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                    <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                </svg>
            </a>
        </div>
    
        {{-- Date --}}
        <div class="text-end text-muted">
            <a href="#" class="text-muted text-decoration-none" data-mdb-toggle="tooltip" title="Created date">
                <span class="small mb-0 d-flex align-items-center fw-semibold">
                    <svg class="me-2" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                    </svg>
                    {{ $todo->created_at->format('d M Y') }}
                </span>
            </a>
        </div>
    </li>
</ul>

{{-- If Editing --}}
@if ($editTodoID === $todo->id)
    <div class="ms-5 ps-1">

        {{-- Update Confirm --}}
        <button wire:click="update" type="button" class="btn btn-success btn-sm me-3">
            Update
        </button>

        {{-- Cancel Edit --}}
        <button wire:click="cancelEdit" type="button" class="btn btn-danger btn-sm">
            Cancel
        </button>
    </div>
@endif

<hr>