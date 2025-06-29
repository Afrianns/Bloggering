<div class="text-white mx-auto w-full" x-data="articleEditFunction">
    <h1 class="text-xl">Edit Article</h1>
    <div class="mx-auto card my-5">
        <form action="" class="text-gray-100 text-sm" wire:submit="save">
            <section class="my-3">
                <label for="title">Title</label>
                <input type="text" wire:model="title" class="border p-1 px-2 border-gray-100 block w-full"name="title" id="title">
                <div>@error('title') <p class="my-1 py-1 px-2 bg-red-500 rounded">{{ $message }}</p> @enderror</div>
            </section>
            <section class="my-3 relative">
                <label for="category">Category</label>
                <div class="grid grid-cols-4 items-center gap-2 w-full">
                    <input x-model="categoriesInput" name="category" @click="isSelected = true" @click.outside="isSelected = false" autocomplete="off" class="col-span-3 w-full border p-1 px-2 border-gray-100 block">
                    <span class="button bg-amber-600" @click="addCategories()">add</span>
                </div>
                <div class="bg-[#2b2a2a] border-2 border-[#383838] rounded p-2 flex flex-col absolute w-full mt-3 z-10" x-show="isSelected">
                    <span x-show="filteredAvailCategories.length <= 0">no category found</span>
                    <template x-for="(category, idx) in filteredAvailCategories" :key="idx">
                        <span class="hover:bg-[#1b1b1b] p-1 px-2" x-text="category" @click="addThisCategory(category)"></span>
                    </template>
                </div>
                <template x-if="displayedCategories.length > 0">                    
                    <div id="categories-selected" class="bg-[#2a2a2a] w-full mt-3 py-3 px-2 flex gap-2">
                        <template x-for="(category, idx) in displayedCategories">
                            <div class="py-1 px-2 bg-gray-700 border border-gray-600 rounded flex items-center gap-x-2">
                                <span x-text="category"></span>
                                <hr class="border-r h-full border-gray-600">
                                <span class="cursor-pointer hover:bg-gray-600 p-1 rounded" @click="removeCategory(idx)">x</span>
                            </div>
                        </template>
                    </div>
                </template>
            </section>
            <section class="my-3">
                <label for="text">Article</label>
                <div wire:ignore>
                    <div id="editor"></div>
                </div>
                <div>@error('contents') <p class="my-1 py-1 px-2 bg-red-500 rounded">{{ $message }}</p> @enderror</div>
            </section>
            <div class="flex items-center justify-between gap-x-3">
                <span class="border border-gray-600 border-dashed button opacity-50 cursor-progress" wire:loading>loading...</span>
                <Button class="bg-orange-500 button" @click="dispatchInputedData()" wire:loading.remove>Publish Article</Button>
                <Button class="bg-gray-500 button" @click="dispatchInputedDataDraft()" wire:loading.remove>Draft Article</Button>
            </div>
        </form>
    </div>
</div>
@script
<script>
    Alpine.data("articleEditFunction", () => ({
        
        contents: "",
        categoriesInput: '',

        displayedCategories: [],

        availCategoriesValues: [],

        isSelected: false,

        init() {
            
            this.displayedCategories = JSON.parse(JSON.stringify($wire.articleCategories));

            $wire.on("status-message", (message) => {
                this.popupMessage(message[0], message[1]);
            })

            JSON.parse(JSON.stringify($wire.availCategories)).forEach(element => {
                this.availCategoriesValues.push(Object.values(element)[0])
            });
            
            let quill = new Quill('#editor', {
                theme: 'snow'
            });


            quill.setContents(quill.clipboard.convert({
                html: "{!! $article->content !!}"
            }));

            this.contents = "{!! $article->content !!}"
            
            quill.on("text-change", (delta,oldDelta, source) => {
                this.contents = quill.root.innerHTML
            })
        },
        dispatchInputedData(){
            $wire.dispatchSelf('userInputEdit', 
                {
                    "contents": this.contents.replaceAll("&nbsp;", " ").replaceAll(/style=".*"/ig, ""), 
                    "categories": this.displayedCategories
                }
            );
        },

        dispatchInputedDataDraft(){
            $wire.dispatchSelf('userInputEdit', 
               {
                    "contents": this.contents.replaceAll("&nbsp;", " ").replaceAll(/style=".*"/ig, ""),
                    "categories": this.displayedCategories, 
                    "type": "draft"
                }
            );
        },
        get filteredAvailCategories() {

            return this.availCategoriesValues.filter((data,idx) => {
                    if(this.displayedCategories.indexOf(data) == -1) {
                        return data.startsWith(this.categoriesInput)
                    }
                    
                }
            )
        },

        addCategories() {
            let splittedWord = this.categoriesInput.split(" ")
            if(splittedWord.length > 0){
                for(word of splittedWord){
                    this.displayedCategories.push(word);
                } 
            } else{
                this.displayedCategories.push(splittedWord);
            }

            this.categoriesInput = '';
        },

        addThisCategory(category){
            let categoryID = this.availCategoriesValues.indexOf(category)
            
            this.displayedCategories.push(this.availCategoriesValues[categoryID]);

            this.categoriesInput = '';
        },

        removeCategory(idx) {
            this.displayedCategories.splice(idx, 1);
        },

        popupMessage(icon, title) {
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
                icon: icon,
                title: title
            });
        }

    }))
</script>
@endscript