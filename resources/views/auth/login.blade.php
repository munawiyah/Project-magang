<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Masuk Petugas & Administrator - Diskominfo Kab. Tangerang</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-slate-100 min-h-screen flex items-center justify-center p-4 sm:p-6">

    <div class="max-w-xl w-full bg-white rounded-3xl shadow-2xl border border-slate-100 overflow-hidden transition-all duration-300">
        
        <!-- Header Utama Instansi -->
        <div class="bg-gradient-to-r from-blue-950 via-blue-900 to-indigo-950 text-white p-7 text-center relative">
            <div class="inline-flex p-3 rounded-2xl bg-white/10 mb-3 backdrop-blur-md shadow-inner border border-white/10">
                <svg class="w-8 h-8 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
            </div>
            <h1 class="text-2xl font-black tracking-tight">Portal Masuk Petugas</h1>
            <p class="text-xs text-blue-200 mt-1 font-medium">Sistem Informasi & Pendataan Sekolah Terpadu</p>
            <p class="text-[10px] text-amber-300/90 font-bold uppercase tracking-widest mt-1">Diskominfo Pemerintah Kabupaten Tangerang</p>
        </div>

        <!-- 2 Pilihan Login: Tab Admin Sistem (CMS) vs Admin Data (Operator) -->
        <div class="p-6 sm:p-8">
            <div class="mb-6">
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2.5 text-center">
                    Pilih Portal Hak Akses Petugas:
                </label>
                <div class="grid grid-cols-2 gap-3 p-1.5 bg-slate-100 rounded-2xl border border-slate-200">
                    
                    <!-- Tab 1: Admin Sistem (CMS) -->
                    <button type="button" id="tab-cms" onclick="selectRole('admin_sistem')"
                            class="flex flex-col items-center justify-center py-3.5 px-3 rounded-xl transition-all duration-200 text-center font-bold text-xs sm:text-sm">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="w-2 h-2 rounded-full bg-blue-600" id="indicator-cms"></span>
                            <span class="text-sm">🖥️ Admin Sistem</span>
                        </div>
                        <span class="text-[10px] text-slate-500 font-normal">CMS & Konten Web</span>
                    </button>

                    <!-- Tab 2: Admin Data (Operator) -->
                    <button type="button" id="tab-data" onclick="selectRole('admin_data')"
                            class="flex flex-col items-center justify-center py-3.5 px-3 rounded-xl transition-all duration-200 text-center font-bold text-xs sm:text-sm">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="w-2 h-2 rounded-full bg-emerald-600" id="indicator-data"></span>
                            <span class="text-sm">📊 Admin Data</span>
                        </div>
                        <span class="text-[10px] text-slate-500 font-normal">Operator Data Siswa</span>
                    </button>
                </div>
            </div>

            <!-- Banner Penjelasan Role Terpilih & Tombol Login 1-Klik -->
            <div id="role-badge-box" class="mb-6 p-4 rounded-2xl border transition-all duration-200">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div>
                        <div class="flex items-center gap-2">
                            <span id="role-badge" class="px-2.5 py-0.5 rounded-full text-[11px] font-bold uppercase tracking-wider"></span>
                            <span id="role-title" class="font-extrabold text-slate-800 text-sm"></span>
                        </div>
                        <p id="role-desc" class="text-xs text-slate-600 mt-1"></p>
                    </div>

                    <!-- Tombol 1-Klik Masuk Otomatis Demo -->
                    <button type="button" id="btn-quick-login" onclick="quickLogin()"
                            class="inline-flex items-center justify-center gap-1.5 px-3.5 py-2.5 rounded-xl font-bold text-xs text-white shadow-md hover:opacity-90 active:scale-95 transition whitespace-nowrap">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        <span>1-Klik Masuk Demo</span>
                    </button>
                </div>
            </div>

            @if ($errors->any())
                <div class="mb-5 p-4 rounded-2xl bg-red-50 border border-red-200 text-xs text-red-700">
                    <div class="flex items-center gap-2 font-bold mb-1">
                        <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        <span>Gagal Masuk</span>
                    </div>
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="mb-5 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-xs text-emerald-800 font-medium flex items-center gap-2">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <!-- Form Manual -->
            <form id="form-login" action="{{ route('login.post') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <div class="flex justify-between items-center mb-1.5">
                        <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                            Alamat Email Dinas
                        </label>
                        <button type="button" onclick="fillSelectedCredentials()" class="text-[11px] text-blue-700 hover:underline font-semibold">
                            Isi Email Akun Demo
                        </button>
                    </div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/></svg>
                        </div>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                               placeholder="nama@tangerangkab.go.id"
                               class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-600 text-sm transition">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Kata Sandi
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        </div>
                        <input type="password" id="password" name="password" required
                               placeholder="••••••••"
                               class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-600 text-sm transition">
                    </div>
                </div>

                <div class="flex items-center justify-between text-xs pt-1">
                    <label class="flex items-center gap-2 cursor-pointer text-slate-600 font-medium">
                        <input type="checkbox" name="remember" class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                        <span>Ingat saya di perangkat ini</span>
                    </label>
                </div>

                <button type="submit" id="btn-submit"
                        class="w-full py-3.5 px-4 bg-blue-900 hover:bg-blue-800 text-white rounded-xl font-bold text-sm shadow-lg shadow-blue-950/20 transition duration-200 flex items-center justify-center gap-2">
                    <span>Masuk ke Sistem</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </button>
            </form>

            <!-- Opsi Tambahan: Superadmin & Kembali ke Beranda -->
            <div class="mt-7 pt-5 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-slate-500">
                <button type="button" onclick="selectRole('superadmin')" class="hover:text-blue-900 font-semibold flex items-center gap-1">
                    <span>👑 Masuk sebagai Superadmin</span>
                </button>
                <a href="{{ route('landing') }}" class="font-semibold text-slate-500 hover:text-blue-900 transition flex items-center gap-1">
                    &larr; Beranda Publik
                </a>
            </div>
        </div>
    </div>

    <!-- Script Pengubah Role & Quick Auto-Fill / Auto-Login -->
    <script>
        const roles = {
            admin_sistem: {
                title: "Portal Admin Sistem (CMS)",
                badge: "CMS Content Lead",
                desc: "Wewenang: Kelola teks portal, slider hero, pengumuman, visi-misi, dan galeri kegiatan sekolah.",
                email: "cms@tangerangkab.go.id",
                password: "password123",
                theme: "blue",
                boxClass: "bg-blue-50/70 border-blue-200 text-blue-900",
                badgeClass: "bg-blue-100 text-blue-800 border border-blue-300",
                btnQuickClass: "bg-blue-700 hover:bg-blue-800 shadow-blue-700/30",
                btnSubmitClass: "bg-blue-900 hover:bg-blue-800 shadow-blue-950/20"
            },
            admin_data: {
                title: "Portal Admin Data (Operator)",
                badge: "School Data Operator",
                desc: "Wewenang: Kelola master data peserta didik (siswa), guru, kelas rombel, jurusan, serta import & export CSV.",
                email: "operator@tangerangkab.go.id",
                password: "password123",
                theme: "emerald",
                boxClass: "bg-emerald-50/70 border-emerald-200 text-emerald-900",
                badgeClass: "bg-emerald-100 text-emerald-800 border border-emerald-300",
                btnQuickClass: "bg-emerald-700 hover:bg-emerald-800 shadow-emerald-700/30",
                btnSubmitClass: "bg-emerald-800 hover:bg-emerald-700 shadow-emerald-950/20"
            },
            superadmin: {
                title: "Portal Super Administrator",
                badge: "Full System Access",
                desc: "Wewenang: Akses penuh tanpa batas ke modul CMS, Data Operator, dan konfigurasi master.",
                email: "superadmin@tangerangkab.go.id",
                password: "password123",
                theme: "amber",
                boxClass: "bg-amber-50/70 border-amber-200 text-amber-900",
                badgeClass: "bg-amber-100 text-amber-800 border border-amber-300",
                btnQuickClass: "bg-amber-600 hover:bg-amber-700 shadow-amber-600/30",
                btnSubmitClass: "bg-slate-900 hover:bg-slate-800 shadow-slate-950/20"
            }
        };

        let currentRole = "{{ $activeRole ?? 'admin_sistem' }}";

        function selectRole(roleKey) {
            currentRole = roleKey;
            const r = roles[roleKey] || roles.admin_sistem;

            // Update Tabs Appearance
            const tabCms = document.getElementById('tab-cms');
            const tabData = document.getElementById('tab-data');

            if (roleKey === 'admin_sistem') {
                tabCms.className = "flex flex-col items-center justify-center py-3.5 px-3 rounded-xl transition-all duration-200 text-center font-bold text-xs sm:text-sm bg-white text-blue-900 shadow-md border border-blue-200";
                tabData.className = "flex flex-col items-center justify-center py-3.5 px-3 rounded-xl transition-all duration-200 text-center font-bold text-xs sm:text-sm text-slate-500 hover:text-slate-700 hover:bg-white/50";
            } else if (roleKey === 'admin_data') {
                tabCms.className = "flex flex-col items-center justify-center py-3.5 px-3 rounded-xl transition-all duration-200 text-center font-bold text-xs sm:text-sm text-slate-500 hover:text-slate-700 hover:bg-white/50";
                tabData.className = "flex flex-col items-center justify-center py-3.5 px-3 rounded-xl transition-all duration-200 text-center font-bold text-xs sm:text-sm bg-white text-emerald-900 shadow-md border border-emerald-200";
            } else {
                tabCms.className = "flex flex-col items-center justify-center py-3.5 px-3 rounded-xl transition-all duration-200 text-center font-bold text-xs sm:text-sm text-slate-500 hover:text-slate-700 hover:bg-white/50";
                tabData.className = "flex flex-col items-center justify-center py-3.5 px-3 rounded-xl transition-all duration-200 text-center font-bold text-xs sm:text-sm text-slate-500 hover:text-slate-700 hover:bg-white/50";
            }

            // Update Badge & Info Box
            const box = document.getElementById('role-badge-box');
            box.className = "mb-6 p-4 rounded-2xl border transition-all duration-200 " + r.boxClass;

            const badge = document.getElementById('role-badge');
            badge.innerText = r.badge;
            badge.className = "px-2.5 py-0.5 rounded-full text-[11px] font-bold uppercase tracking-wider " + r.badgeClass;

            document.getElementById('role-title').innerText = r.title;
            document.getElementById('role-desc').innerText = r.desc;

            // Update Quick Button
            const btnQuick = document.getElementById('btn-quick-login');
            btnQuick.className = "inline-flex items-center justify-center gap-1.5 px-3.5 py-2.5 rounded-xl font-bold text-xs text-white shadow-md hover:opacity-90 active:scale-95 transition whitespace-nowrap " + r.btnQuickClass;

            // Update Submit Button
            const btnSubmit = document.getElementById('btn-submit');
            btnSubmit.className = "w-full py-3.5 px-4 text-white rounded-xl font-bold text-sm shadow-lg transition duration-200 flex items-center justify-center gap-2 " + r.btnSubmitClass;

            // Optional auto-fill email placeholder/hint
            const emailInput = document.getElementById('email');
            emailInput.placeholder = r.email;
        }

        function fillSelectedCredentials() {
            const r = roles[currentRole] || roles.admin_sistem;
            document.getElementById('email').value = r.email;
            document.getElementById('password').value = r.password;
        }

        function quickLogin() {
            fillSelectedCredentials();
            document.getElementById('form-login').submit();
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function () {
            selectRole(currentRole);
        });
    </script>

</body>
</html>
