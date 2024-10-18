<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Create New Supplier') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="mb-5 text-2xl font-bold">Create New Supplier</h2>
                    <x-auth-session-status class="mb-4" :status="session('success')" />
                    <form action="{{ route('supplier-store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div class="form-group">
                            <label for="name" class="block text-sm font-medium text-gray-700">Supplier Name</label>
                            <input type="text" id="name" name="name" class="block w-full p-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                        </div>
                        <div class="form-group">
                            <label for="contact" class="block text-sm font-medium text-gray-700">Contact</label>
                            <input type="text" id="contact" name="contact" class="block w-full p-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>
                        <div class="form-group">
                            <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                            <input type="text" id="address" name="address" class="block w-full p-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>
                        <button type="submit" class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
