<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    @vite('resources/css/app.css')

</head>

<body class="bg-blue-200">
    <nav class="flex justify-end flex-wrap bg-gray-900 p-2">
        @auth
            <section class="flex justify-end lg:hidden">
                <button id="burguerMenu" class=" text-xl flex px-3 py-2 text-white  hover:border-white">
                    <svg class="fill-current h-6 w-6" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <title>Menu</title>
                        <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z" />
                    </svg>
                </button>
            </section>
            <section id="botonesMenu" class="w-full flex-grow lg:flex lg:items-center lg:w-auto hidden text-center">
                <article class="text-sm lg:flex-grow pb-8 sm:pb-8 lg:pb-0">
                    <a href="{{ route('home') }}"
                        class="block mt-4 lg:inline-block lg:mt-0 px-5 text-teal-200 mx-auto text-xl font-bold hover:underline hover:text-yellow-500 transform hover:scale-110">Volver
                        a Home
                    </a>
                    <a href="{{ route('purchases.index') }}"
                        class="block mt-4 lg:inline-block lg:mt-0 px-5 text-teal-200 mx-auto text-xl font-bold hover:underline hover:text-yellow-500 transform hover:scale-110">
                        Listado de Compras
                    </a>
                    <a href="{{ route('products.index') }}"
                        class="block mt-4 lg:inline-block lg:mt-0 px-5 text-teal-200 mx-auto text-xl font-bold hover:underline hover:text-yellow-500 transform hover:scale-110">
                        Listado de Productos
                    </a>
                </article>
                <!-- Settings Dropdown -->
                <div class="sm:flex sm:items-center sm:ms-6 ">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name }}</div>

                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </section>
        @else
            <section>
                <a href="{{ route('login') }}"
                    class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log
                    in</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}"
                        class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
            </section>
            @endif
        @endauth

    </nav>
    @yield('content')
    @vite('resources/js/app.js')

</body>

</html>
