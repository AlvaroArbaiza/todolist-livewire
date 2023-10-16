<div>
    {{-- <h1>{{ $count }}</h1>
 
    <button wire:click="increment">+</button>

    <button wire:click="decrement">-</button> --}}

    {{-- errori --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- success --}}
    @if (session('success'))
        
        <div class="container">
            
            <div class="alert alert-success d-flex align-items-center" role="alert">
                <svg xmlns="http://www.w3.org/2000/svg" class="d-none">
                    <symbol id="check-circle-fill" viewBox="0 0 16 16">
                      <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                    </symbol>
                </svg>
                <svg class="bi flex-shrink-0 me-2" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
                <div>
                    {{session('success')}}
                </div>
            </div>
        </div>
    @endif
    
    <form wire:submit="createUser" action="" class="mt-5">

        {{-- Name --}}
        <div class="mb-3">

            <input wire:model="name" type="text" placeholder="Name">
            @error('name')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        {{-- Email --}}
        <div class="mb-3">

            <input wire:model="email" type="email" placeholder="Email">
            @error('email')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        {{-- Password --}}
        <div class="mb-3">

            <input wire:model="password" type="password" placeholder="Password">
            @error('password')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>


        <button>Create user</button>
    </form>

    @if (count($users))
        
        <ul class="mt-3">
            @foreach ($users as $user)
                <li>{{ $user->name }}</li>
            @endforeach
        </ul>

        {{-- pagination --}}
        {{ $users->links() }}
    @endif

    
</div>
