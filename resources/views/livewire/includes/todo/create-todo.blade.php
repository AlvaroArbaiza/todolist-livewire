<div class="pb-2">

    {{-- success --}}
    @if (session('success'))
        
        <div class="container">
            
            <div class="alert alert-success d-flex align-items-center" role="alert">
                <svg class="me-2" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                </svg>
                <div>
                    {{session('success')}}
                </div>
            </div>
        </div>
    @endif

    {{-- card --}}
    <div class="card shadow-sm">

        {{-- card body --}}
        <div class="card-body">
            <form class="d-flex flex-row align-items-center">

                {{-- Add new --}}
                <input wire:model="name" type="text" class="form-control form-control-lg" id="name" placeholder="Add new...">

                {{-- Set due date --}}
                <a href="#!" data-mdb-toggle="tooltip" title="Set due date">
                    <svg data-mdb-toggle="tooltip" title="Set due date" class="me-1" xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-calendar-check" viewBox="0 0 16 16">
                        <path d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                        <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
                    </svg>
                </a>
                
                <input 
                    wire:model="deadline" class="form-control me-2" type="datetime-local"  placeholder="Deadline (optional)" id="deadline"
                >

                {{-- Add button --}}
                <div>
                    <button wire:click.prevent="create" type="button" class="btn btn-primary px-4 shadow">
                        Add                                    
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Error Name --}}
    @error('name')
        <div class="text-danger ps-2 mt-2">{{ $message }}</div>
    @enderror
</div>