<div class="bg-white shadow-md px-6 py-3 flex justify-between items-center">
    <h1 class="text-xl font-semibold text-gray-700">@yield('title')</h1>
   
    <!-- Dropdown Profile -->
    <div class="relative" id="dropdown-container">
        <button id="dropdown-button" class="flex items-center space-x-2 bg-gray-200 px-4 py-2 rounded-lg">
            <span class="font-medium">{{ Auth::user()->name }}</span>
            <span class="text-gray-500">({{ Auth::user()->role }})</span>
        </button>
        <div id="dropdown-menu" class="absolute right-0 mt-2 w-40 bg-white shadow-md rounded-lg hidden">
            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-200">Profile</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="block w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-200">Logout</button>
            </form>
        </div>
    </div>
</div>
@section("scripts")
<script>
document.addEventListener('DOMContentLoaded', function() {
    const dropdownButton = document.getElementById('dropdown-button');
    const dropdownMenu = document.getElementById('dropdown-menu');
    const dropdownContainer = document.getElementById('dropdown-container');
    
    // Toggle dropdown when button is clicked
    dropdownButton.addEventListener('click', function(event) {
        event.stopPropagation(); // Prevent this click from being detected by the document listener
        dropdownMenu.classList.toggle('hidden');
    });
    
    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        if (!dropdownContainer.contains(event.target) && !dropdownMenu.classList.contains('hidden')) {
            dropdownMenu.classList.add('hidden');
        }
    });
});
</script>
@endsection