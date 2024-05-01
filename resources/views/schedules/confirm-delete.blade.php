<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Confirm Deletion') }}
        </h2>
    </x-slot>

    <section class="max-w-4xl mx-auto py-8">
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">

            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-4">Are you sure?</h2>
            <p class="text-gray-600 dark:text-gray-400 mb-6">You are about to delete the schedule: <span class="font-bold">{{ $schedule->title }}</span></p>

            <div class="flex justify-end space-x-4">
                <!-- Delete button with confirmation -->
                <form id="delete-form" method="POST" action="{{ route('schedules.delete', $schedule->id) }}" class="">
                @csrf
                @method('DELETE')
                <button
                    type="submit"
                    class="bg-red-600 hover:bg-red-700 text-white font-semibold px-4 py-2 rounded focus:outline-none focus:ring focus:ring-red-400"
                   
                >
                    Yes, Delete
                </button>
            </form>
               

                <!-- Cancel button -->
                <button
                    type="button"
                    class="bg-gray-300 dark:bg-gray-700 text-gray-800 dark:text-gray-300 font-semibold px-4 py-2 rounded focus:outline-none focus:ring"
                    onclick="window.history.back()"
                >
                    Cancel
                </button>
            </div>

            <!-- Delete form (hidden) -->
            
        </div>
    </section>
</x-app-layout>
