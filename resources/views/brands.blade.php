@extends('components.layouts.app')

@section('title','Brands')

@section('content')
<div class="max-w-4xl mx-auto">

    @if(session('success'))
    <div id="success-message" class="mb-4 bg-red-500 text-white p-3 rounded">
        {{ session('success') }}
    </div>

    <script>
        setTimeout(() => {
            const msg = document.getElementById('success-message');
            if(msg) {
                msg.style.transition = "opacity 0.5s ease";
                msg.style.opacity = 0;
                setTimeout(() => msg.remove(), 500);
            }
        }, 2000);
    </script>
@endif

    <div class="bg-black p-4 rounded shadow mb-6 border border-red-500">
        <h2 class="font-semibold text-red-500">Add Brand</h2>

        <form action="{{ route('brands.store') }}" method="POST" class="mt-3">
            @csrf
            <div class="text-white grid grid-cols-2 gap-3">
                <div>
                    <input name="name" placeholder="Brand name" class="w-full bg-black border p-2 rounded border-red-500" required>
                    @error('name')<div class="text-red-500 text-sm mt-1">{{ $message }}</div>@enderror
                </div>

                <div>
                    <input name="country" placeholder="Country (optional)" class="w-full bg-black black border p-2 rounded border-red-500">
                    @error('country')<div class="text-red-500 text-sm mt-1">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="mt-3">
                <button class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-800">Add Brand</button>
            </div>
        </form>
    </div>

    <div class="bg-black p-4 rounded shadow border border-red-500">
        <h2 class="font-semibold text-red-500 mb-3">Brands</h2>

        <table class="text-white bg-black w-full table-auto border-collapse">
            <thead>
                <tr class="text-left border border-red-500 bg-black text-white ">
                    <th class="px-3 py-2 border-b border-red-500">ID</th>
                    <th class="px-3 py-2 border-b border-red-500">Name</th>
                    <th class="px-3 py-2 border-b border-red-500">Country</th>
                    <th class="px-3 py-2 border-b border-red-500">Vehicles</th>
                    <th class="px-3 py-2 border-b border-red-500">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($brands as $b)
                <tr class="border border-red-500">
                    <td class="px-3 py-2">{{ $b->id }}</td>
                    <td class="px-3 py-2">{{ $b->name }}</td>
                    <td class="px-3 py-2">{{ $b->country ?? '-' }}</td>
                    <td class="px-3 py-2">{{ $b->vehicles_count }} vehicles</td>
                    <td class="px-3 py-2">
                        <button
                            class="px-2 py-1 text-sm bg-black text-white border border-white rounded hover:bg-black hover:text-red-500 hover:border-red-500 edit-brand-btn"
                            data-id="{{ $b->id }}"
                            data-name="{{ $b->name }}"
                            data-country="{{ $b->country }}"
                        >Edit</button>

                        <form action="{{ route('brands.destroy', $b) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="px-2 py-1 text-sm bg-black text-red-500 border border-red-500 rounded hover:bg-black hover:text-white hover:border-white delete-brand-btn">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- Edit Brand Modal --}}
<div id="edit-brand-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40">
    <div class="bg-black w-full max-w-md p-4 rounded border border-red-500">
        <h3 class="text-red-500 font-semibold mb-2">Edit Brand</h3>

        <form id="edit-brand-form" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-3">
                <div>
                    <label class="block text-sm text-white">Brand Name</label>
                    <input name="name" id="edit-brand-name" class="w-full bg-black text-white border p-2 rounded border-red-500" required>
                </div>

                <div>
                    <label class="block text-sm text-white">Country</label>
                    <input name="country" id="edit-brand-country" class="w-full bg-black text-white border p-2 rounded border-red-500">
                </div>

                <div class="flex justify-end gap-2 mt-3">
                    <button type="button" id="edit-brand-cancel" class="bg-black px-4 py-2 border border-white rounded text-white hover:text-red-700 hover:border-red-700">Cancel</button>
                    <button type="submit" class="border border-red-500 px-4 py-2 bg-black text-red-500 rounded hover:bg-black hover:text-white hover:border-white">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Edit Brand
    document.querySelectorAll('.edit-brand-btn').forEach(button => {
        button.addEventListener('click', () => {
            const id = button.dataset.id;
            document.getElementById('edit-brand-name').value = button.dataset.name;
            document.getElementById('edit-brand-country').value = button.dataset.country;

            const form = document.getElementById('edit-brand-form');
            form.action = `/brands/${id}`;

            const modal = document.getElementById('edit-brand-modal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        });
    });

    // Cancel edit brand
    document.getElementById('edit-brand-cancel').addEventListener('click', () => {
        const modal = document.getElementById('edit-brand-modal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    });

    // Delete brand confirmation
    document.querySelectorAll('.delete-brand-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            if (confirm('Are you sure you want to delete this brand?')) {
                btn.closest('form').submit();
            }
        });
    });

    // Click outside closes edit brand modal
    document.getElementById('edit-brand-modal').addEventListener('click', (e) => {
        if (e.target.id === 'edit-brand-modal') {
            e.currentTarget.classList.add('hidden');
            e.currentTarget.classList.remove('flex');
        }
    });
</script>
@endpush

@endsection
