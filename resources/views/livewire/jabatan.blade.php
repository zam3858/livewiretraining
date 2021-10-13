<div>
    <h1>Jabatan</h1>
    <div class="p-4">
        <input type="hidden" name="jabatan_id" wire:model="jabatan_id">
        <div class="mb-3">
            <label for="code" class="form-label">Code</label>
            <input type="text" class="form-control" id="code"
                   wire:model.debounce.500ms="code"
            >
            @error('code') <span class="error">{{ $message }}</span> @enderror
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name"
                   wire:model.debounce.500ms="name"
            >
            @error('name') <span class="error">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="btn btn-primary"
                wire:click="saveJabatan"
        >Submit</button>

        <button class="btn btn-warning"
                wire:click="resetJabatan"
        >Reset</button>
    </div>
    @if(session('alert_message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('alert_message') }}
            {{--        <button type="button" class="btn-close" aria-label="Close"></button>--}}
        </div>
    @endif

    <table class="table table-striped table-compact">
        <tr>
            <th>Code</th>
            <th>Name</th>
            <th></th>
        </tr>
        @foreach($jabatans as $jabatan)
            <tr>
                <td>{{ $jabatan->code }}</td>
                <td>{{ $jabatan->name }}</td>
                <td>
                    <button class="btn btn-primary btn-sm"
                            wire:click="edit({{ $jabatan->id }})"
                    >Edit</button>

                    <button class="btn btn-danger btn-sm"
                            wire:click="delete({{ $jabatan->id }})"
                    >Delete</button>
                </td>
            </tr>
        @endforeach
    </table>

    {{ $jabatans->links() }}
</div>
