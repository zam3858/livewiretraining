<div>
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
</div>
