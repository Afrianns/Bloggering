<div class=" text-gray-100">
    <h1 class="text-2xl my-5 font-bold text-gray-400 text-center">Explore</h1>
    <div class="flex flex-col mx-auto"> 
        <form action="" wire:submit="searching">
            <input type="text" wire:model="search" class="border p-1 px-2 w-2/3 mx-auto border-gray-100 block h-12 py-1 rounded"name="title" id="title">
            <div class="w-[100px] mx-auto">
                <button class="button bg-amber-600 mt-5">
                    search
                </button>
            </div>
        </form>
    </div>
    <p class="text-gray-400 text-sm mt-5 text-center">Search by Categories</p>
    <div class="flex gap-x-2 text-xs justify-center m-3 mb-10">
        @foreach ($categories as $category)
        <span class="bg-[#2d2b2b] py-1 px-4 rounded border border-[#272727]">{{ $category->name }}</span>
        @endforeach
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
    {{-- @if ($this->getTotalSearchedArticles > 1 ||$this->getTotalSearchedArticles == null && $articles->count() < $this->countTotalArticles)
    <div class="w-full mx-auto text-center mb-5">
        <button class="text-green-500 hover:underline cursor-pointer" wire:click="loadMoreArticles">Load More</button>
        </div>
    @endif --}}
</div>
