@extends('components.auth.layouts.app')
 
@section('title', 'Register Page')
  
@section('content')
    <div class="text-white bg-[#272727] px-5 py-10 h-fit w-xl rounded m-auto">
        <h1 class="text-3xl font-bold">Register</h1>
        <form method="post">
            @if ($errors->any())
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li class="my-3 py-2 px-3 bg-red-500 text-red-950 rounded">{{ $error }}</li>
                        @endforeach
                    </ul>
            @endif

            @csrf
            <section class="my-3">
                <label for="name">Name</label>
                <input type="text" class="border p-1 px-2 rounded border-gray-300 block w-full" id="name" name="name">
            </section>

            <section class="my-3">
                <label for="email">Email</label>
                <input type="text" class="border p-1 px-2 rounded border-gray-300 block w-full" id="email" name="email">
            </section>
                
            <section class="my-3">
                <label for="password">Password</label>
                <input type="text" class="border p-1 px-2 rounded border-gray-300 block w-full"id="password" name="password">
            </section>

            <section class="my-3">
                <label for="repeat_password">Repeat Password</label>
                <input type="text" class="border p-1 px-2 rounded border-gray-300 block w-full"id="repeat_password" name="repeat_password">
            </section>

            <Button type="submit" class="bg-orange-500 py-2 mt-7 rounded text-center block w-full">Register</Button>
            <a href="{{ route('login') }}" class="text-orange-500 hover:underline block w-full mt-5 text-center">Login</a>
        </form>
    </div>
@endsection