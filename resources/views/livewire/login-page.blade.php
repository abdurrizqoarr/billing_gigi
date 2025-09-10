<div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="w-full max-w-md p-8 bg-white shadow-2xl rounded-2xl">
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Login</h2>

        <form wire:submit.prevent="login" class="space-y-5">
            <!-- Username -->
            <div>
                <label class="block mb-1 text-sm font-medium text-gray-600">Username</label>
                <input type="text" wire:model="username"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                    wire:loading.attr="disabled" />
                @error('username')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label class="block mb-1 text-sm font-medium text-gray-600">Password</label>
                <input type="password" wire:model="password"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                    wire:loading.attr="disabled" />
                @error('password')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <!-- Button -->
            <button type="submit"
                class="w-full py-2 font-semibold text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 flex justify-center items-center"
                wire:loading.attr="disabled">

                <!-- Default text -->
                <span wire:loading.remove>Login</span>

                <!-- Loading state -->
                <span wire:loading.flex class="flex items-center">
                    <svg class="animate-spin h-5 w-5 mr-2 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z">
                        </path>
                    </svg>
                    Processing...
                </span>
            </button>
        </form>

    </div>
</div>
