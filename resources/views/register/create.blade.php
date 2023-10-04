<x-layout>
    <h1 class="my-16 text-center text-4xl font-medium text-slate-600">Register your own account</h1>


    <x-card class="py-8 px-16">
        <form action="{{route('register.store')}}" method="POST">
            @csrf

            <div class="mb-8">
                <x-label for="name">Name</x-label>
                <x-text-input name="name"/>
            </div>

            <div class="mb-8">
                <x-label for="email">E-mail</x-label>
                <x-text-input name="email" type="email"/>
            </div>

            <div class="mb-8">
                <x-label for="password">Password</x-label>
                <x-text-input type="password" name="password"/>
            </div>

            <div class="mb-8">
                <x-label for="password_confirmation">Retyped password</x-label>
                <x-text-input type="password" name="password_confirmation"/>
            </div>

            <x-button class="w-full bg-green-50">Register</x-button>
        </form>
    </x-card>
</x-layout>
