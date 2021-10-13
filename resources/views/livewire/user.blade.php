<div>
    <h1>Pengguna</h1>

    <livewire:user-form user_id="{{ $user_id }}" />

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
                            wire:click="$emit('editUser',{{ $user->id }})"
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
                    //Livewire.emit('deleteUser', user_id)
                    Livewire.all()[0].delete(user_id)
                }
            }
        </script>
    @endsection
</div>
