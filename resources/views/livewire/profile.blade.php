<div class="my-5 text-xl font-light text-gray-400" x-data="profileFunction">
    <div class="card mx-auto w-full text-center">
        <h1 class="text-white text-3xl">{{ $user->name }}</h1>
        <p class="text-sm">{{ $user->email }}</p>
        <hr class="my-5">
        @if ($user->details)
            <div class="text-sm flex flex-col gap-y-4 mb-5">
                @if (trim($user->details->address) != '')
                    <div class="text-center flex justify-center items-center gap-x-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"><g fill="none" fill-rule="evenodd"><path d="m12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035q-.016-.005-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093q.019.005.029-.008l.004-.014l-.034-.614q-.005-.018-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z"/><path fill="currentColor" d="M12 2a9 9 0 0 1 9 9c0 3.074-1.676 5.59-3.442 7.395a20.4 20.4 0 0 1-2.876 2.416l-.426.29l-.2.133l-.377.24l-.336.205l-.416.242a1.87 1.87 0 0 1-1.854 0l-.416-.242l-.52-.32l-.192-.125l-.41-.273a20.6 20.6 0 0 1-3.093-2.566C4.676 16.589 3 14.074 3 11a9 9 0 0 1 9-9m0 2a7 7 0 0 0-7 7c0 2.322 1.272 4.36 2.871 5.996a18 18 0 0 0 2.222 1.91l.458.326q.222.155.427.288l.39.25l.343.209l.289.169l.455-.269l.367-.23q.293-.186.627-.417l.458-.326a18 18 0 0 0 2.222-1.91C17.728 15.361 19 13.322 19 11a7 7 0 0 0-7-7m0 3a4 4 0 1 1 0 8a4 4 0 0 1 0-8m0 2a2 2 0 1 0 0 4a2 2 0 0 0 0-4"/></g></svg>
                        <p>{{ $user->details->address }}</p>
                    </div>
                @endif
                @if (trim($user->details->description) != '')
                    <p class="text-gray-100">
                        {{ $user->details->description }}
                    </p>
                @endif
                <div class="flex justify-center items-center gap-x-5">
                    @foreach (json_decode($user->details->links) as $link)
                        @if (trim($link->url) != '')
                            <a href="{{ $link->url }}" target="_blank" class="cursor-pointer" title="{{ $link->icon }}">
                                <div x-html="svgIcons['{{$link->icon}}']"></div>    
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>
        @endif
        @if (Auth::user()->id == $user->id)
            <a href="/profile/edit/{{ $user->id }}" class="hover:underline text-orange-500 text-sm">Edit</a>
        @endif
    </div>
    <div class="flex justify-center gap-x-3 items-center my-5 text-sm">
        <a href="#" class="hover:underline">My Articles</a>
        <a href="#" class="hover:underline">Votes</a>
    </div>
    @if (count($articles) > 0)
        
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
    @else
        <div class="text-center text-gray-200 my-5 text-sm">
            <p>No Articles Found</p>
        </div>
    @endif

    @script
    <script>
        Alpine.data("profileFunction", () => ({

            svgIcons: {
                "Personal Site" : `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 14 14"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1"><path d="M7 13.5a6.5 6.5 0 1 0 0-13a6.5 6.5 0 0 0 0 13M.5 7h13"/><path d="M9.5 7A11.22 11.22 0 0 1 7 13.5A11.22 11.22 0 0 1 4.5 7A11.22 11.22 0 0 1 7 .5A11.22 11.22 0 0 1 9.5 7"/></g></svg>`,
                "Facebook": `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"><g fill="none"><g clip-path="url(#akarIconsFacebookFill0)"><path fill="currentColor" fill-rule="evenodd" d="M0 12.067C0 18.034 4.333 22.994 10 24v-8.667H7V12h3V9.333c0-3 1.933-4.666 4.667-4.666c.866 0 1.8.133 2.666.266V8H15.8c-1.467 0-1.8.733-1.8 1.667V12h3.2l-.533 3.333H14V24c5.667-1.006 10-5.966 10-11.933C24 5.43 18.6 0 12 0S0 5.43 0 12.067" clip-rule="evenodd"/></g><defs><clipPath id="akarIconsFacebookFill0"><path fill="#fff" d="M0 0h24v24H0z"/></clipPath></defs></g></svg>`, 
                "Instagram":`<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"><path fill="currentColor" fill-rule="evenodd" d="M7.465 1.066C8.638 1.012 9.012 1 12 1s3.362.013 4.534.066s1.972.24 2.672.511c.733.277 1.398.71 1.948 1.27c.56.549.992 1.213 1.268 1.947c.272.7.458 1.5.512 2.67C22.988 8.639 23 9.013 23 12s-.013 3.362-.066 4.535c-.053 1.17-.24 1.97-.512 2.67a5.4 5.4 0 0 1-1.268 1.949c-.55.56-1.215.992-1.948 1.268c-.7.272-1.5.458-2.67.512c-1.174.054-1.548.066-4.536.066s-3.362-.013-4.535-.066c-1.17-.053-1.97-.24-2.67-.512a5.4 5.4 0 0 1-1.949-1.268a5.4 5.4 0 0 1-1.269-1.948c-.271-.7-.457-1.5-.511-2.67C1.012 15.361 1 14.987 1 12s.013-3.362.066-4.534s.24-1.972.511-2.672a5.4 5.4 0 0 1 1.27-1.948a5.4 5.4 0 0 1 1.947-1.269c.7-.271 1.5-.457 2.67-.511m8.98 1.98c-1.16-.053-1.508-.064-4.445-.064s-3.285.011-4.445.064c-1.073.049-1.655.228-2.043.379c-.513.2-.88.437-1.265.822a3.4 3.4 0 0 0-.822 1.265c-.151.388-.33.97-.379 2.043c-.053 1.16-.064 1.508-.064 4.445s.011 3.285.064 4.445c.049 1.073.228 1.655.379 2.043c.176.477.457.91.822 1.265c.355.365.788.646 1.265.822c.388.151.97.33 2.043.379c1.16.053 1.507.064 4.445.064s3.285-.011 4.445-.064c1.073-.049 1.655-.228 2.043-.379c.513-.2.88-.437 1.265-.822c.365-.355.646-.788.822-1.265c.151-.388.33-.97.379-2.043c.053-1.16.064-1.508.064-4.445s-.011-3.285-.064-4.445c-.049-1.073-.228-1.655-.379-2.043c-.2-.513-.437-.88-.822-1.265a3.4 3.4 0 0 0-1.265-.822c-.388-.151-.97-.33-2.043-.379m-5.85 12.345a3.669 3.669 0 0 0 4-5.986a3.67 3.67 0 1 0-4 5.986M8.002 8.002a5.654 5.654 0 1 1 7.996 7.996a5.654 5.654 0 0 1-7.996-7.996m10.906-.814a1.337 1.337 0 1 0-1.89-1.89a1.337 1.337 0 0 0 1.89 1.89" clip-rule="evenodd"/></svg>`, 
                "Twitter":`<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"><path fill="currentColor" d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334q.002-.211-.006-.422A6.7 6.7 0 0 0 16 3.542a6.7 6.7 0 0 1-1.889.518a3.3 3.3 0 0 0 1.447-1.817a6.5 6.5 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.32 9.32 0 0 1-6.767-3.429a3.29 3.29 0 0 0 1.018 4.382A3.3 3.3 0 0 1 .64 6.575v.045a3.29 3.29 0 0 0 2.632 3.218a3.2 3.2 0 0 1-.865.115a3 3 0 0 1-.614-.057a3.28 3.28 0 0 0 3.067 2.277A6.6 6.6 0 0 1 .78 13.58a6 6 0 0 1-.78-.045A9.34 9.34 0 0 0 5.026 15"/></svg>`
            },
        }))
    </script>
    @endscript
</div>
