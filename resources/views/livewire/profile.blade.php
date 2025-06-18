<div class="my-5 text-xl font-light text-gray-400">
    <div class="card mx-auto w-full text-center">
        <h1 class="text-white text-3xl">{{ $user->name }}</h1>
        <p class="text-sm">{{ $user->email }}</p>
        @if (Auth::user()->id == $user->id)
            <a href="#" class="hover:underline text-orange-500 text-sm">Edit</a>
        @endif
    </div>
    <div class="flex justify-between items-center mt-5">
        <h3 >All Articles</h3>

        <form action="" wire:submit="searchArticles" class="flex items-center gap-x-2 text-white">
            <input type="text" wire:model="search" class="border p-1 px-2 border-gray-100 block rounded"name="title" id="title">
            <div class="w-[100px] mx-auto">
                <button class="button bg-amber-600">
                    search
                </button>
            </div>
        </form>
    </div>
    @foreach ($articles as $article)
        <section class="card text-white my-5">
            <div class="flex justify-between items-center my-5">
                <div>
                    <h1>{{ $article->title }}</h1>
                    <span class="text-gray-400">{{ $article->subtitle }}</span>
                </div>
                <p class="text-gray-300 text-sm">{{ Carbon\Carbon::parse($article->created_at)->locale("id_ID")->isoFormat("d MMMM g - kk:hh") }}</p>
            </div> 
            <div class="flex gap-x-2 text-xs">
                @foreach ($article->categories()->get() as $article_categories)
                <span class="bg-[#2d2b2b] py-1 px-4 rounded border border-[#272727]">{{ $article_categories->name }}</span>
                @endforeach
            </div>
            <div class="my-5 text-sm">
                {!! Str::limit($article->content, 400); !!}
            </div>
            <div class="flex justify-between mt-5">
                <a href="/dashboard/detail/{{ $article->id }}" wire:navigate class="text-orange-600 hover:underline">Detail</a>
                @if ($article->user_id == Auth::user()->id)
                    <a href="/dashboard/detail/edit/{{ $article->id }}" class="text-[#b7fb2f] hover:underline">Edit</a>
                @endif
            </div>
        </section>
    @endforeach
    {{ $articles->links() }}
</div>
