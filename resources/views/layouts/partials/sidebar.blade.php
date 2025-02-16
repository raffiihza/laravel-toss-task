<div class="w-64 bg-red-600 text-white flex flex-col h-screen overflow-y-auto p-6">
    <h2 class="text-2xl font-bold mb-6">EduTend</h2>

    <nav class="flex-1">
    <a href="{{ route('dashboard') }}" class="block py-2 px-4 hover:bg-red-700 rounded">Dashboard</a>
    <a href="{{ route('teacherattendances.index') }}" class="mt-2 block py-2 px-4 hover:bg-red-700 rounded">Absensi Guru</a>
    <a href="{{ route('teacherattendances.index') }}" class="mt-2 block py-2 px-4 hover:bg-red-700 rounded">Absensi Siswa</a>

        <!-- Dropdown Admin Menu -->
        @if(Auth::user()->role === 'Admin')
            <div class="mt-2">
                <button id="adminDropdownBtn" class="w-full text-left py-2 px-4 flex justify-between items-center hover:bg-red-700 rounded">
                    <span>Admin Menu</span>
                    <span id="adminIcon" class="transition duration-300">▼</span>
                </button>
                <div id="admin-menu" class="hidden">
                    <a href="{{ route('teachers.index') }}" class="block py-2 px-6 hover:bg-red-700">Guru</a>
                    <a href="{{ route('grades.index') }}" class="block py-2 px-6 hover:bg-red-700">Kelas</a>
                    <a href="{{ route('lessons.index') }}" class="block py-2 px-6 hover:bg-red-700">Mata Pelajaran</a>
                    <a href="{{ route('students.index') }}" class="block py-2 px-6 hover:bg-red-700">Siswa</a>
                </div>
            </div>
        @endif
    </nav>
</div>

<script>
document.getElementById("adminDropdownBtn").addEventListener("click", function() {
    let menu = document.getElementById("admin-menu");
    let icon = document.getElementById("adminIcon");
    menu.classList.toggle("hidden");
    icon.textContent = menu.classList.contains("hidden") ? "▼" : "▲";
});
</script>