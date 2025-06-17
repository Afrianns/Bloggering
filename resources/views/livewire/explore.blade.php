<div class=" text-gray-100" x-data="exploreFunction" x-on:categories="showCate($event.detail)">
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
            <span class="cate-btn hover:opacity-60 cursor-pointer"
            :class="checkIfSame('{{$category->name}}') ? 'bg-[#2d2b2b]' : ''" 
            x-on:click="selectCategory('{{ $category->name }}')"
            >{{ $category->name }}</span>
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
                <span class="cate-btn bg-[#2d2b2b]">{{ $article_categories->name }}</span>
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
    <div class="w-full mx-auto text-center mb-5">
        {{ $articles->links() }}
    </div>

    @script
    <script>
        Alpine.data("exploreFunction", () => ({

            categoryFilter: '',

            selectedCategories: [],
            init(){
                console.log("pas")
                // $wire.dispatch('getCategories');
                // $wire.on("categories", (categories) => {
                //     console.log(categories)
                // })
            },

            getCategories(categories){
                // categories.forEach(category => {
                //     this.categories.push({
                //         name: category.name,
                //         class: ''
                //     })
                // });

                return categories;
                // console.log(categories)
            },

            checkIfSame(category){
                exist = false;
                console.log(this.selectedCategories)
                if(this.selectedCategories.length > 0){
                    this.selectedCategories.forEach(select => {
                        if(select == category){
                            exist = true;
                        }
                    });
                }
                return exist
            },


            selectCategory(category){
                
                let index = this.selectedCategories.indexOf(category);
                if(index == -1){
                    $wire.filterByCategory(category)
                    this.selectedCategories.push(category)
                } else{
                    $wire.filterByCategory("", index)
                    this.selectedCategories.splice(index, 1)
                }
                console.log(this.selectedCategories)
            },

            checkCategory(categories){
                if(this.categoryFilter != ''){
                    for (const category of JSON.parse(categories)) {
                        if(category.name == this.categoryFilter){
                            return true;
                        } 
                    }
                    return false;
                } else{
                    return true;
                }
            },

            showCate(data){
                console.log(data)
            }
        }))

    </script>
    @endscript
</div>
