@extends('components.layouts.app')

@section('title','Brands')

@section('content')
<div class="max-w-5xl mx-auto">


    <div class="flex gap-6">

        {{-- Add Brand --}}
        <div class="text-white w-full lg:w-1/3 bg-black p-4 rounded shadow border border-red-500">
            <h2 class="font-semibold text-red-500 mb-3">Add Brand</h2>

            <form action="{{ route('brands.store') }}" method="POST">
                @csrf
                <div class="space-y-3">
                    <div>
                        <label class="block text-sm text-white">Brand Name</label>
                        <input name="name" value="{{ old('name') }}" class="w-full bg-black border p-2 rounded border-red-500" required>
                        @error('name')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
                    </div>

                    <div class="pt-2">
                        <button class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-800">
                            Add Brand
                        </button>
                    </div>
                </div>
            </form>
        </div>

        {{-- Brand Table --}}
        <div class="w-full bg-black p-4 rounded shadow border border-red-500">
            <h2 class="font-semibold text-red-500 mb-3">Brands</h2>

            <table class="w-full table-auto border-collapse text-white">
                <thead>
                    <tr class="bg-black border border-red-500 text-left text-white">
                        <th class="px-3 py-2 border-b border-red-500">ID</th>
                        <th class="px-3 py-2 border-b border-red-500">Brand Name</th>
                        <th class="px-3 py-2 border-b border-red-500">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($brands as $b)
                    <tr class="border border-red-500 text-white bg-black">
                        <td class="px-3 py-2">{{ $b->id }}</td>
                        <td class="px-3 py-2">{{ $b->name }}</td>
                        <td class="px-3 py-2">

                            {{-- Edit --}}
                            <button
                                class="px-2 py-1 text-sm bg-black text-white border border-white rounded hover:bg-black hover:text-red-500 hover:border-red-500 edit-brand-btn"
                                data-id="{{ $b->id }}"
                                data-name="{{ $b->name }}"
                            >Edit</button>

                            {{-- Delete --}}
                            <form action="{{ route('brands.destroy', $b) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="button"
                                    class="delete-btn px-2 py-1 text-sm bg-black text-red-500 border border-red-500 rounded hover:bg-black hover:text-white hover:border-white">
                                    Delete
                                </button>
                            </form>

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>

{{-- Edit Brand Modal --}}
<div id="edit-brand-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40">
    <div class="bg-black w-full max-w-md p-4 rounded border border-red-500">
        <h3 class="font-semibold mb-2 text-red-500">Edit Brand</h3>

        <form id="edit-brand-form" method="POST">
            @csrf
            @method('PUT')
            <div class="space-y-3">
                <div>
                    <label class="block text-sm text-white">Brand Name</label>
                    <input id="edit-brand-name" name="name"
                        class="w-full bg-black border text-white p-2 rounded border-red-500" required>
                </div>
            </div>

            <div class="mt-3 flex justify-end gap-2">
                <button type="button" id="edit-brand-cancel"
                    class="px-4 py-2 border rounded text-white hover:text-red-700 hover:border-red-700">
                    Cancel
                </button>

                <button type="submit"
                    class="px-4 py-2 border border-red-500 text-red-500 rounded hover:text-white hover:border-white">
                    Save
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Edit
    document.querySelectorAll('.edit-brand-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            document.getElementById('edit-brand-name').value = btn.dataset.name;
            document.getElementById('edit-brand-form').action = `/brands/${btn.dataset.id}`;
            const modal = document.getElementById('edit-brand-modal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        });
    });

    // Cancel Edit
    document.getElementById('edit-brand-cancel').addEventListener('click', () => {
        const modal = document.getElementById('edit-brand-modal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    });

    // Delete
    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            if(confirm('Are you sure you want to delete this brand?')) {
                btn.closest('form').submit();
            }
        });
    });

    // Close modal on background click
    document.getElementById('edit-brand-modal').addEventListener('click', (e) => {
        if(e.target.id === 'edit-brand-modal') {
            e.target.classList.add('hidden');
            e.target.classList.remove('flex');
        }
    });
});
</script>
@endpush
@endsection
