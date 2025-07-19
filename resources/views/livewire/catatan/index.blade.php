<div class="relative mb-6 w-full">
    <flux:heading size="xl" level="1">{{ __('Catatan') }}</flux:heading>
    <flux:subheading size="lg" class="mb-6">{{ __('Manage your Catatan') }}</flux:subheading>
    <flux:separator variant="subtle" />

    <flux:modal.trigger name="create-catatan">
        <flux:button class="mt-3">Create Catatan</flux:button>
    </flux:modal.trigger>

    @if (session()->has('success'))
    <div
        x-data="{ show: true }"
        x-show="show"
        x-init="setTimeout(() => { show = false }, 3000)"
        class="fixed top-5 right-5 bg-green-600 text-white text-sm p-4 rounded-lg shadow-lg z-50"
        role="alert">
        <p>{{ session('success') }}</p>
    </div>
    @endif

    <livewire:catatan.create />
    <livewire:catatan.edit />

    <!-- Tabel Catatan -->
    <div class="mt-8 overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 rounded-lg shadow-md overflow-hidden">
            <thead class="bg-gray-50 text-gray-700 text-sm uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-3 text-left">#</th>
                    <th class="px-6 py-3 text-left">Judul</th>
                    <th class="px-6 py-3 text-left">Isi</th>
                    <th class="px-6 py-3 text-left">Dibuat</th>
                    <th class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @forelse ($catatans as $index => $catatan)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $catatans->firstItem() + $index }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 flex items-center space-x-3">
                        <img class="w-8 h-8 rounded-full object-cover" src="https://ui-avatars.com/api/?name={{ urlencode($catatan->judul) }}" alt="Avatar">
                        <span>{{ $catatan->judul }}</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ \Illuminate\Support\Str::limit($catatan->isi, 50) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">{{ $catatan->created_at->diffForHumans() }}</td>
                    <td class="px-6 py-4 text-center space-x-2">
                        <flux:button size="sm" variant="primary" wire:click="edit({{ $catatan->id }})">Edit</flux:button>
                        <flux:button size="sm" variant="danger" wire:click="delete({{ $catatan->id }})">Hapus</flux:button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">Belum ada catatan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $catatans->links() }}
        </div>

        <flux:modal name="delete-catatan" class="min-w-[22rem]">
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg">Delete catatan?</flux:heading>

                    <flux:text class="mt-2">
                        <p>You're about to delete this catatan.</p>
                        <p>This action cannot be reversed.</p>
                    </flux:text>
                </div>

                <div class="flex gap-2">
                    <flux:spacer />

                    <flux:modal.close>
                        <flux:button variant="ghost">Cancel</flux:button>
                    </flux:modal.close>

                    <flux:button type="submit" variant="danger" wire:click="deleteCatatan">Delete catatan</flux:button>
                </div>
            </div>
        </flux:modal>
    </div>
</div>