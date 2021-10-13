<div>
    <h1>Pengguna</h1>
    <div class="p-4">
        <input type="hidden" name="user_id" wire:model="user_id">
        <div class="mb-3">
            <label for="name" class="form-label">Full Name</label>
            <input type="text" class="form-control" id="name"
                   wire:model="name"
            >
            @error('name') <span class="error">{{ $message }}</span> @enderror
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" class="form-control" id="email"
                   wire:model="email"
            >
            @error('email') <span class="error">{{ $message }}</span> @enderror
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password"
                   wire:model="password"
            >
            @error('password') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <input type="file" wire:model="photo" class="form-control-file">
            <div wire:loading wire:target="photo">Uploading File...</div>
            @error('photo') <span class="error">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="btn btn-primary"
                wire:click="saveUser"
        >Submit</button>

        <button class="btn btn-warning"
                wire:click="resetUser"
        >Reset</button>
    </div>
    @if(session('alert_message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('alert_message') }}
            {{--        <button type="button" class="btn-close" aria-label="Close"></button>--}}
        </div>
    @endif
    <hr>
    <div class="mb-3">
        <input type="text" class="form-control" id="search"
               wire:model.debounce.500ms="search"
               placeholder="Search"
        >
    </div>
    <table class="table table-striped table-compact" >
        <tr>
            <th>Avatar</th>
            <th>Name</th>
            <th>Email</th>
            <th></th>
        </tr>
        @foreach($users as $user)
            <tr>
                <td>
                    @if($user->photos)
                        <img src="{{ url('/storage/' . $user->photos) }}" alt="" style="width:100px" />
                    @endif
                </td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    <button class="btn btn-primary btn-sm"
                            wire:click="edit({{ $user->id }})"
                    >Edit
                    </button>

                    <button class="btn btn-danger btn-sm"
                            onclick="deleteUser({{$user->id}})"
                    >Delete
                    </button>

                    <button type="button" class="btn btn-primary btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#user_detail"
                            onclick="showUser('{{ $user->name }}', '{{ $user->email }}')"
                    >
                        View
                    </button>

                    @if($user->photos)
                        <button wire:click="getPhoto({{ $user->id }})"
                                class="btn btn-outline-primary btn-sm"
                        >Download Photo
                        </button>
                    @endif
                </td>
            </tr>
        @endforeach
    </table>

    {{ $users->links() }}

<!-- Button trigger modal -->


    <!-- Modal -->
    <div class="modal fade" id="user_detail" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">View User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table>
                        <tr>
                            <th>Name</th>
                            <td><span id="modal_name"></span></td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td><span id="modal_email"></span></td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    @section('scripts')
        <script>
            function showUser(name, email) {
                document.getElementById('modal_name').innerText = name;
                document.getElementById('modal_email').innerText = email;
            }

            function deleteUser(user_id) {
                if(confirm('Are you sure')) {
                    Livewire.first().delete(user_id)
                }
            }
        </script>
    @endsection
</div>
