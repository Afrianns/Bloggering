<div x-data="detailFunction">
    <section class="text-white my-5">
        <div class="flex justify-center items-center mt-10 mb-5">
            <div class="text-center">
                <h1 class="text-4xl font-bold">{{ $article->title }}</h1>
                <span class="text-gray-400">{{ $article->subtitle }}</span>
                <p class="text-gray-300 text-sm mt-5">By <a href="dashboard/detail/user/{{ $article->user->id }}" class="cursor-pointer hover:underline">{{ $article->user->name }}</a></p>
            </div>
        </div> 
        <div class="flex gap-x-2 text-xs justify-center">
            @foreach ($article->categories()->get() as $article_categories)
            <a href="/explore?category={{ $article_categories->name }}" class="bg-[#2d2b2b] py-1 px-4 rounded border border-[#272727]">{{ $article_categories->name }}</a>
            @endforeach
        </div>
        <div class="my-5 text-sm text-gray-300 leading-6">
            {!! $article->content !!}
        </div>
        <p class="text-gray-400 text-sm">{{ Carbon\Carbon::parse($article->created_at)->locale("id_ID")->isoFormat("d MMMM g - kk:hh") }}</p>
        <div class="mt-5 flex justify-between">
            <div class="flex justify-between mt-5">
                <a href="/dashboard" wire:navigate class="text-orange-600 hover:underline">Back</a>
            </div>
            <div class="flex gap-x-2">
                @php
                    $userVote = $article->isUserVote(Auth::user()->id);
                @endphp
                <div class="card w-fit flex gap-x-2 items-center hover:cursor-pointer" wire:click="upVote('{{ Auth::user()->id }}', '{{ $article->id }}')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 48 48"><path 
                        @class(["fill-red-500" => $userVote == 1, "fill-white" => $userVote == 0]) stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M5 24L24 6l19 18H31v18H17V24z"/></svg>
                    <p class="text-gray-400">{{ $article->votes()->count() }}</p>
                </div>
            @if ($article->user_id == Auth::user()->id)
                <div class="card flex gap-x-5">
                    <a href="/dashboard/detail/edit/{{ $article->id }}" class="text-[#b7fb2f] hover:underline">Edit</a>
                    <span class="text-[#ff2828]  cursor-pointer hover:underline" x-on:click="deleteArticle('{{$article->id}}')">Delete</span>
                </div>
                @endif
            </div>
        </div>
    </section>
    <h3 class="text-gray-100">All Comments</h3>
    <livewire:comments.comments :post_id="$article->id" :comments="$article">
    @script
    <script>
        Alpine.data("detailFunction", () => ({
            deleteArticle(uuid) {

                const swalWithBootstrapButtons = Swal.mixin({
                    });
                    swalWithBootstrapButtons.fire({
                        title: "Are you sure?",
                        text: "You won't be able to revert this!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonText: "Yes, delete it!",
                        cancelButtonText: "No, cancel!",
                        reverseButtons: true
                }).then((result) => {

                    if (result.isConfirmed) {
                        $wire.deleteArticle(uuid);
                    } else if (
                        /* Read more about handling dismissals below */
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        // swalWithBootstrapButtons.fire({
                        //     title: "Cancelled",
                        //     text: "Your imaginary file is safe :)",
                        //     icon: "error"
                        // });
                    }
                });
            }
        }))
    </script>
    @endscript
</div>
