<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Masuk Admin - e-APBDesa</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .login-shell {
            background:
                radial-gradient(circle at 18% 18%, rgba(96,165,250,.22), transparent 28%),
                radial-gradient(circle at 84% 78%, rgba(56,189,248,.16), transparent 25%),
                #020617;
        }

        .login-panel {
            background: linear-gradient(145deg, #0f172a, #172554);
        }

        .login-glow {
            box-shadow: 0 24px 70px rgba(2,6,23,.35);
        }
    </style>
</head>

<body class="login-shell min-h-screen text-slate-800">

    <main class="mx-auto flex min-h-screen max-w-7xl items-center p-4 sm:p-8 lg:p-12">

        <div class="login-glow grid w-full overflow-hidden rounded-[2rem] border border-white/10 bg-white lg:grid-cols-[1.1fr_.9fr]">

            {{-- PANEL KIRI --}}
            <section class="login-panel relative overflow-hidden px-7 py-10 text-white sm:px-12 lg:min-h-[680px] lg:py-16">

                <div class="absolute -right-28 -top-28 h-72 w-72 rounded-full bg-blue-400/15 blur-2xl"></div>

                <div class="relative flex h-full flex-col">

                    <a
                        href="{{ route('home') }}"
                        class="inline-flex items-center gap-3 self-start rounded-2xl text-white focus:outline-none focus:ring-2 focus:ring-blue-300"
                    >
                        <span class="flex h-12 w-12 items-center justify-center rounded-xl border border-white/20 bg-white/10 text-2xl">
                            <i class='bx bx-bar-chart-alt-2'></i>
                        </span>

                        <span>
                            <span class="block text-xl font-bold tracking-tight">
                                e-APBDesa
                            </span>

                            <span class="block text-[10px] font-semibold uppercase tracking-[.16em] text-blue-200">
                                Sistem Publikasi APBDesa
                            </span>
                        </span>
                    </a>


                    <div class="my-auto max-w-lg pt-16 lg:pt-0">

                        <p class="text-sm font-semibold uppercase tracking-[.2em] text-blue-200">
                            Desa Sumber Jaya
                        </p>

                        <h1 class="mt-4 text-4xl font-bold leading-tight sm:text-5xl">
                            Transparansi anggaran yang mudah diakses.
                        </h1>

                        <p class="mt-6 max-w-md text-sm leading-7 text-slate-300 sm:text-base">
                            e-APBDesa membantu pengelola desa menyiapkan publikasi APBDesa yang informatif, akurat, dan terbuka bagi masyarakat.
                        </p>

                    </div>


                    <div class="mt-12 flex items-center gap-3 text-sm text-slate-300">
                        <i class='bx bx-shield-quarter text-xl text-blue-300'></i>

                        <span>
                            Akses khusus administrator dan pengelola publikasi.
                        </span>
                    </div>

                </div>

            </section>


            {{-- PANEL KANAN --}}
            <section class="flex items-center bg-slate-50 px-5 py-10 sm:px-12 lg:px-14">

                <div class="mx-auto w-full max-w-md">

                    <div class="mb-8 lg:hidden">
                        <p class="text-sm font-semibold text-blue-700">
                            e-APBDesa · Desa Sumber Jaya
                        </p>
                    </div>


                    <div class="mb-8">

                        <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-100 text-2xl text-blue-700">
                            <i class='bx bx-lock-alt'></i>
                        </span>

                        <h2 class="mt-5 text-3xl font-bold tracking-tight text-slate-900">
                            Masuk ke Admin
                        </h2>

                        <p class="mt-2 text-sm leading-6 text-slate-500">
                            Kelola publikasi APBDesa Desa Sumber Jaya.
                        </p>

                    </div>


                    <x-auth-session-status
                        class="mb-5 rounded-xl border border-blue-200 bg-blue-50 px-4 py-3 text-sm text-blue-800"
                        :status="session('status')"
                    />


                    {{-- FORM LOGIN --}}
                    <form
                        method="POST"
                        action="{{ route('login') }}"
                        class="space-y-5"
                        x-data="{ showPassword: false }"
                    >

                        @csrf


                        {{-- USERNAME --}}
                        <div>

                            <label
                                for="username"
                                class="mb-2 block text-sm font-semibold text-slate-700"
                            >
                                Username
                            </label>

                            <div class="relative">

                                <i class='bx bx-user pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-xl text-slate-400'></i>

                                <input
                                    id="username"
                                    name="username"
                                    type="text"
                                    value="{{ old('username') }}"
                                    required
                                    autofocus
                                    autocomplete="username"
                                    placeholder="Masukkan username"
                                    class="w-full rounded-xl border border-slate-300 bg-white py-3.5 pl-12 pr-4 text-sm text-slate-900 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-blue-600 focus:ring-4 focus:ring-blue-100"
                                >

                            </div>

                            <x-input-error
                                :messages="$errors->get('username')"
                                class="mt-2 text-sm"
                            />

                        </div>


                        {{-- PASSWORD --}}
                        <div>

                            <label
                                for="password"
                                class="mb-2 block text-sm font-semibold text-slate-700"
                            >
                                Kata Sandi
                            </label>

                            <div class="relative">

                                <i class='bx bx-lock-alt pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-xl text-slate-400'></i>

                                <input
                                    id="password"
                                    name="password"
                                    :type="showPassword ? 'text' : 'password'"
                                    required
                                    autocomplete="current-password"
                                    placeholder="Masukkan kata sandi"
                                    class="w-full rounded-xl border border-slate-300 bg-white py-3.5 pl-12 pr-12 text-sm text-slate-900 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-blue-600 focus:ring-4 focus:ring-blue-100"
                                >

                                <button
                                    type="button"
                                    @click="showPassword = !showPassword"
                                    class="absolute right-3 top-1/2 flex -translate-y-1/2 rounded-lg p-2 text-slate-400 transition hover:bg-slate-100 hover:text-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    :aria-label="showPassword ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi'"
                                >
                                    <i
                                        class='bx text-xl'
                                        :class="showPassword ? 'bx-hide' : 'bx-show'"
                                    ></i>
                                </button>

                            </div>

                            <x-input-error
                                :messages="$errors->get('password')"
                                class="mt-2 text-sm"
                            />

                        </div>


                        {{-- REMEMBER + LUPA PASSWORD --}}
                        <div class="flex flex-wrap items-center justify-between gap-3">

                            <label
                                for="remember"
                                class="inline-flex cursor-pointer items-center gap-2 text-sm text-slate-600"
                            >
                                <input
                                    id="remember"
                                    name="remember"
                                    type="checkbox"
                                    class="h-4 w-4 rounded border-slate-300 text-blue-700 focus:ring-blue-600"
                                >

                                <span>
                                    Ingat saya
                                </span>
                            </label>


                            @if (Route::has('password.request'))

                                <a
                                    href="{{ route('password.request') }}"
                                    class="text-sm font-semibold text-blue-700 hover:text-blue-800 focus:outline-none focus:underline"
                                >
                                    Lupa kata sandi?
                                </a>

                            @endif

                        </div>


                        {{-- BUTTON --}}
                        <button
                            type="submit"
                            class="flex w-full items-center justify-center gap-2 rounded-xl bg-blue-700 px-5 py-3.5 text-sm font-bold tracking-wide text-white shadow-lg shadow-blue-700/20 transition hover:-translate-y-0.5 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-200 disabled:cursor-not-allowed disabled:opacity-60"
                        >
                            <span>MASUK</span>

                            <i class='bx bx-right-arrow-alt text-xl'></i>
                        </button>

                    </form>

                </div>

            </section>

        </div>

    </main>

</body>
</html>