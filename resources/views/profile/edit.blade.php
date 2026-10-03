@extends('layouts.admin')

@section('content')

<div class="space-y-6">

    {{-- HEADER --}}
    <div>
        <h1 class="text-2xl font-bold text-slate-800">
            Profil Administrator
        </h1>

        <p class="mt-1 text-sm text-slate-500">
            Kelola username dan password akun administrator.
        </p>
    </div>


    {{-- PESAN BERHASIL --}}
    @if (session('status') === 'profile-updated')
        <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
            Username administrator berhasil diperbarui.
        </div>
    @endif

    @if (session('status') === 'password-updated')
        <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
            Password administrator berhasil diperbarui.
        </div>
    @endif


    {{-- ERROR --}}
    @if ($errors->any())
        <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3">

            <div class="flex gap-3">

                <i class='bx bx-error-circle text-xl text-red-600'></i>

                <div>

                    <p class="font-semibold text-red-700">
                        Periksa kembali data yang dimasukkan.
                    </p>

                    <ul class="mt-1 list-disc pl-5 text-sm text-red-600">

                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach

                    </ul>

                </div>

            </div>

        </div>
    @endif


    {{-- USERNAME --}}
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        <div class="border-b border-slate-200 px-5 py-4 sm:px-6">

            <div class="flex items-center gap-3">

                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50">
                    <i class='bx bx-user text-xl text-blue-600'></i>
                </div>

                <div>

                    <h2 class="font-semibold text-slate-800">
                        Username Administrator
                    </h2>

                    <p class="text-sm text-slate-500">
                        Username digunakan untuk masuk ke halaman administrator.
                    </p>

                </div>

            </div>

        </div>


        <div class="p-5 sm:p-6">

            <form
                method="post"
                action="{{ route('profile.update') }}"
                class="space-y-5"
            >

                @csrf
                @method('patch')


                <div>

                    <label
                        for="username"
                        class="mb-2 block text-sm font-medium text-slate-700"
                    >
                        Username
                    </label>

                    <input
                        id="username"
                        name="username"
                        type="text"
                        value="{{ old('username', $user->username) }}"
                        required
                        autocomplete="username"
                        class="block w-full rounded-xl border-slate-300 px-4 py-3 text-sm shadow-sm
                               focus:border-blue-500 focus:ring-blue-500"
                    >

                    @error('username')
                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Name tetap dikirim karena masih diwajibkan ProfileUpdateRequest --}}
                <input
                    type="hidden"
                    name="name"
                    value="{{ $user->name }}"
                >


                <div class="flex justify-end">

                    <button
                        type="submit"
                        class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700"
                    >

                        <i class='bx bx-save text-lg'></i>

                        Simpan Username

                    </button>

                </div>

            </form>

        </div>

    </div>


    {{-- PASSWORD --}}
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        <div class="border-b border-slate-200 px-5 py-4 sm:px-6">

            <div class="flex items-center gap-3">

                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-50">
                    <i class='bx bx-lock-alt text-xl text-amber-600'></i>
                </div>

                <div>

                    <h2 class="font-semibold text-slate-800">
                        Ubah Password
                    </h2>

                    <p class="text-sm text-slate-500">
                        Gunakan password yang kuat untuk menjaga keamanan akun.
                    </p>

                </div>

            </div>

        </div>


        <div class="p-5 sm:p-6">

            <form
                method="post"
                action="{{ route('password.update') }}"
                class="space-y-5"
            >

                @csrf
                @method('put')


                {{-- PASSWORD LAMA --}}
                <div>

                    <label
                        for="update_password_current_password"
                        class="mb-2 block text-sm font-medium text-slate-700"
                    >
                        Password Saat Ini
                    </label>

                    <input
                        id="update_password_current_password"
                        name="current_password"
                        type="password"
                        required
                        autocomplete="current-password"
                        class="block w-full rounded-xl border-slate-300 px-4 py-3 text-sm shadow-sm
                               focus:border-blue-500 focus:ring-blue-500"
                    >

                    @if ($errors->updatePassword->get('current_password'))

                        @foreach ($errors->updatePassword->get('current_password') as $error)

                            <p class="mt-2 text-sm text-red-600">
                                {{ $error }}
                            </p>

                        @endforeach

                    @endif

                </div>


                {{-- PASSWORD BARU --}}
                <div>

                    <label
                        for="update_password_password"
                        class="mb-2 block text-sm font-medium text-slate-700"
                    >
                        Password Baru
                    </label>

                    <input
                        id="update_password_password"
                        name="password"
                        type="password"
                        required
                        autocomplete="new-password"
                        class="block w-full rounded-xl border-slate-300 px-4 py-3 text-sm shadow-sm
                               focus:border-blue-500 focus:ring-blue-500"
                    >

                    @if ($errors->updatePassword->get('password'))

                        @foreach ($errors->updatePassword->get('password') as $error)

                            <p class="mt-2 text-sm text-red-600">
                                {{ $error }}
                            </p>

                        @endforeach

                    @endif

                </div>


                {{-- KONFIRMASI PASSWORD --}}
                <div>

                    <label
                        for="update_password_password_confirmation"
                        class="mb-2 block text-sm font-medium text-slate-700"
                    >
                        Konfirmasi Password Baru
                    </label>

                    <input
                        id="update_password_password_confirmation"
                        name="password_confirmation"
                        type="password"
                        required
                        autocomplete="new-password"
                        class="block w-full rounded-xl border-slate-300 px-4 py-3 text-sm shadow-sm
                               focus:border-blue-500 focus:ring-blue-500"
                    >

                    @if ($errors->updatePassword->get('password_confirmation'))

                        @foreach ($errors->updatePassword->get('password_confirmation') as $error)

                            <p class="mt-2 text-sm text-red-600">
                                {{ $error }}
                            </p>

                        @endforeach

                    @endif

                </div>


                <div class="flex justify-end">

                    <button
                        type="submit"
                        class="inline-flex items-center gap-2 rounded-xl bg-slate-800 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-slate-900"
                    >

                        <i class='bx bx-key text-lg'></i>

                        Ubah Password

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection