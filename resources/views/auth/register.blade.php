<!DOCTYPE html>
<html lang="pt-BR" class="h-full antialiased">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - Projeto Safe</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        // Ativa a estratégia de classes para o modo escuro no Tailwind
        tailwind.config = {
            darkMode: 'class',
        }
    </script>
    
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="h-full flex flex-col justify-center py-12 sm:px-6 lg:px-8 bg-gray-50 dark:bg-gray-950 text-gray-950 dark:text-white transition-colors duration-150">
    
    <div class="absolute top-4 right-4">
        <button id="theme-toggle" type="button" class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none rounded-xl text-sm p-2.5 ring-1 ring-gray-950/5 dark:ring-white/10 bg-white dark:bg-gray-900 shadow-sm transition">
            <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
            <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 17.95a1 1 0 011.414 0l.707.707a1 1 0 11-1.414 1.414l-.707-.707a1 1 0 010-1.414zm-3.536-6.95a1 1 0 100-2H3a1 1 0 100 2H1.515zM5.05 6.05a1 1 0 010-1.414l.707-.707a1 1 0 111.414 1.414l-.707.707a1 1 0 01-1.414 0z" fill-rule="evenodd" clip-rule="evenodd"></path></svg>
        </button>
    </div>

    <div class="sm:mx-auto sm:w-full sm:max-w-md text-center">
        <h2 class="text-2xl font-bold tracking-tight text-gray-950 dark:text-white">Criar Nova Conta</h2>
        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Projeto Safe</p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white dark:bg-gray-900 py-8 px-4 shadow-sm ring-1 ring-gray-950/5 dark:ring-white/10 sm:rounded-2xl sm:px-10">
            
            @if ($errors->any())
                <div class="mb-6 rounded-xl bg-red-50 dark:bg-red-950/50 p-4 text-sm text-red-600 dark:text-red-400 ring-1 ring-inset ring-red-600/20 dark:ring-red-500/20">
                    <ul class="list-disc pl-4 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register.submit') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-sm font-medium leading-6 text-gray-950 dark:text-gray-200">Nome Completo</label>
                    <div class="mt-2">
                        <input type="text" name="name" required value="{{ old('name') }}" 
                            class="block w-full rounded-lg border-0 py-2 px-3 text-gray-900 dark:text-white bg-white dark:bg-gray-800 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-amber-600 sm:text-sm sm:leading-6 transition duration-75">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium leading-6 text-gray-950 dark:text-gray-200">Endereço de E-mail</label>
                    <div class="mt-2">
                        <input type="email" name="email" required value="{{ old('email') }}" 
                            class="block w-full rounded-lg border-0 py-2 px-3 text-gray-900 dark:text-white bg-white dark:bg-gray-800 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-amber-600 sm:text-sm sm:leading-6 transition duration-75">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium leading-6 text-gray-950 dark:text-gray-200">Seu Cargo / Função</label>
                    <div class="mt-2">
                        <select name="role" required 
                            class="block w-full rounded-lg border-0 py-2 px-3 text-gray-900 dark:text-white bg-white dark:bg-gray-800 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 focus:ring-2 focus:ring-inset focus:ring-amber-600 sm:text-sm sm:leading-6 transition duration-75">
                            <option value="" disabled selected class="text-gray-400">Selecione uma opção...</option>
                            <option value="professor" {{ old('role') == 'professor' ? 'selected' : '' }}>Professor(a)</option>
                            <option value="portaria" {{ old('role') == 'portaria' ? 'selected' : '' }}>Portaria / Segurança</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium leading-6 text-gray-950 dark:text-gray-200">Senha</label>
                    <div class="mt-2">
                        <input type="password" name="password" required 
                            class="block w-full rounded-lg border-0 py-2 px-3 text-gray-900 dark:text-white bg-white dark:bg-gray-800 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-amber-600 sm:text-sm sm:leading-6 transition duration-75">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium leading-6 text-gray-950 dark:text-gray-200">Confirme a Senha</label>
                    <div class="mt-2">
                        <input type="password" name="password_confirmation" required 
                            class="block w-full rounded-lg border-0 py-2 px-3 text-gray-900 dark:text-white bg-white dark:bg-gray-800 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-amber-600 sm:text-sm sm:leading-6 transition duration-75">
                    </div>
                </div>

                <div>
                    <button type="submit" 
                        class="flex w-full justify-center rounded-lg bg-amber-600 px-3 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-amber-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-amber-600 transition duration-75 cursor-pointer">
                        Concluir Cadastro
                    </button>
                </div>
            </form>

            <div class="mt-6 text-center text-sm leading-6">
                <span class="text-gray-500 dark:text-gray-400">Já tem uma conta?</span>
                <a href="/admin/login" class="font-semibold text-amber-600 hover:text-amber-500 transition duration-75">
                    Entrar no sistema
                </a>
            </div>

        </div>
    </div>

    <script>
        const themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
        const themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

        // Define o ícone correto ao carregar a página baseado no estado atual
        if (document.documentElement.classList.contains('dark')) {
            themeToggleLightIcon.classList.remove('hidden');
        } else {
            themeToggleDarkIcon.classList.remove('hidden');
        }

        const themeToggleBtn = document.getElementById('theme-toggle');

        themeToggleBtn.addEventListener('click', function() {
            // Alterna os ícones visíveis
            themeToggleDarkIcon.classList.toggle('hidden');
            themeToggleLightIcon.classList.toggle('hidden');

            // Se foi definido manualmente no localStorage antes
            if (localStorage.getItem('theme')) {
                if (localStorage.getItem('theme') === 'light') {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('theme', 'dark');
                } else {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('theme', 'light');
                }
            // Se nunca foi definido, segue o padrão do sistema operacional
            } else {
                if (document.documentElement.classList.contains('dark')) {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('theme', 'light');
                } else {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('theme', 'dark');
                }
            }
        });
    </script>
</body>
</html>