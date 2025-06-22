@extends('components.auth.layouts.app')
 
@section('title', 'Login Page')
  
@section('content')
    {{-- <div class="flex justify-center items-center h-full bg-amber-50"> --}}
        <div class="text-white bg-[#272727] px-5 py-10 h-fit w-xl m-auto rounded">
            @if (session("message"))
                <div class="bg-red-500 py-3 px-5 rounded-md mb-5">
                    <p class="text-red-200 font-bold">{{ session("message") }}</p>
                </div>
            @endif
            <h1 class="text-3xl font-bold">Login</h1>
            
            <form method="post">
                @if ($errors->any())
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li class="my-3 py-2 px-3 bg-red-500 text-red-950 rounded">{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
                
                @csrf
                <section class="my-3 ">
                    <label for="email">Email</label>
                    <input type="text" class="border p-1 px-2 rounded border-gray-300 block w-full" id="email" name="email">
                </section>
                    
                <section class="my-3">
                    <label for="password">Password</label>
                    <input type="text" class="border p-1 px-2 rounded border-gray-300 block w-full"id="password" name="password">
                </section>
            
                <Button type="submit" class="bg-orange-500 py-2 mt-7 rounded text-center block w-full">Login</Button>
                <a href="{{route('register')}}" class="text-orange-500 hover:underline block w-full mt-5 text-center">Register</a>
            </form>
        </div>
@endsection