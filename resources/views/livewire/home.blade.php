<div class="my-5">
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
            <p class="text-gray-300 text-sm">Written By <a href="dashboard/detail/user/{{ $article->user->id }}" class="cursor-pointer hover:underline">{{ $article->user->name }}</a></p>
            <div class="flex justify-between mt-5">
                <a href="/dashboard/detail/{{ $article->id }}" wire:navigate class="text-orange-600 hover:underline">Detail</a>
                @if ($article->user_id == Auth::user()->id)
                    <a href="/dashboard/detail/edit/{{ $article->id }}" class="text-[#b7fb2f] hover:underline">Edit</a>
                @endif
            </div>
        </section>
    @endforeach
    {{ $articles->links() }}

    @if (session("status-success"))
        @script
        <script>
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });
                Toast.fire({
                    icon: "success",
                    title: "{{ session('status-success') }}"
            });
            </script>
        @endscript
    @endif
</div>