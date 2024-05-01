<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Jadwal') }}
            @if (Auth::user()->role === 'admin')
            <span class="ml-3 bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">Admin</span>
        @endif
        </h2>
    </x-slot>

    <section class="max-w-4xl mx-auto py-8">

<div class="container rounded-lg p-8 mx-auto">

    <form method="POST" action="{{ route('schedules.store') }}" class="max-w-md mx-auto bg-white shadow-md rounded-lg px-8 pt-6 pb-8 mb-4">
   

        @csrf

        <div class="mb-4">
            <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Title</label>
            <input type="text" id="title" name="title" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" value="{{ old('title') }}" required>
        </div>

        <div class="mb-4">
            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Description</label>
            <textarea id="description" name="description" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" rows="4">{{ old('description') }}</textarea>
        </div>

        <div class="mb-4">
            <label for="start_time" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Start Time</label>
            <input type="datetime-local" id="start_time" name="start_time" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" value="{{ old('start_time') }}" required>
        </div>

        <div class="mb-4">
            <label for="end_time" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">End Time</label>
            <input type="datetime-local" id="end_time" name="end_time" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" value="{{ old('end_time') }}" required>
        </div>

        <div class="mb-6">
            <label for="location" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Location</label>
            <input type="text" id="location" name="location" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" value="{{ old('location') }}">
        </div>

        <!-- add dropdown input for user name -->
        @if (Auth::user()->role === 'admin')
    <div class="mb-6">
        <div class="relative">
            <!-- Dropdown Trigger Button -->
            <button id="dropdownTrigger" type="button" class="w-full bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm px-3 py-2 text-left focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                <span id="selectedUserName" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ $selectedUserName ?? 'Select User' }}</span>
            </button>
            <!-- Dropdown Content (User List) -->
            <div id="dropdownContent" class="hidden absolute z-10 mt-2 py-2 w-full bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-lg">
                @foreach($users as $user)
                    <button type="button" class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600"
                            onclick="selectUser({{ $user->id }}, '{{ $user->name }}')">
                        {{ $user->name }}
                    </button>
                @endforeach
            </div>
        </div>
    </div>
    <input type="hidden" name="user_id" id="user_id" value="{{ old('user_id') }}">
@endif

<script>
    // JavaScript function to handle user selection
    function selectUser(userId, userName) {
        document.getElementById('user_id').value = userId;
        document.getElementById('selectedUserName').innerText = userName;
        // Hide dropdown content after selecting a user
        document.getElementById('dropdownContent').classList.add('hidden');
    }

    // JavaScript to toggle visibility of dropdown content
    document.getElementById('dropdownTrigger').addEventListener('click', function() {
        var dropdownContent = document.getElementById('dropdownContent');
        dropdownContent.classList.toggle('hidden');
    });
</script>



        <button type="submit" class="w-full bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-4 rounded-md focus:outline-none focus:shadow-outline">Add Schedule</button>
    </form>
</div> </section>
</x-app-layout>
