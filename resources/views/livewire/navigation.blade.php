<header class="text-white w-full flex pb-5 py-10">
    <div class="flex justify-center gap-5 mx-auto items-center">
        <a href="/article/add" class="hover:underline cursor-pointer card" wire:navigate wire:current="font-bold underline">
            Add Article
        </a>
        <ul class="card w-fit flex gap-5"> 
            <li class="hover:underline cursor-pointer"><a href="/dashboard" wire:navigate wire:current="font-bold underline">Home</a></li>
            <li class="hover:underline cursor-pointer"><a href="/explore" wire:navigate wire:current="font-bold underline">Explore</a></li>
            <li class="hover:underline cursor-pointer"><a href="/profile/{{ Auth::user()->id }}" wire:navigate wire:current="font-bold underline">Profile</a></li>
            <hr class="border border-[#2a2a2a] h-full">
            <form action="{{ route('logout') }}" method="post">
                @csrf
                <button class="hover:underline cursor-pointer text-red-500">Logout</button>
            </form>
        </ul>
    </div>
</header>
