
<div class="text-white mx-auto w-full" x-data="articleAddFunction">

    <h1 class="text-xl">Add New Article</h1>
    
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
                    <input x-model="categoriesInput" name="category" @click="isSelected = true" @click.outside="isSelected = false" class="col-span-3 w-full border p-1 px-2 border-gray-100 block">
                    <span class="button bg-amber-600" @click="addCategories()">add</span>
                </div>
                <div class="bg-[#2b2a2a] border-2 border-[#383838] rounded p-2 flex flex-col absolute w-full mt-3 z-10" x-show="isSelected">
                    <span x-show="filteredAvailCategories.length <= 0">no category found</span>
                    <template x-for="(category, idx) in filteredAvailCategories" :key="category">
                        <span class="hover:bg-[#1b1b1b] p-1 px-2" x-text="category" @click="addThisCategory(idx)"></span>
                    </template>
                </div>
                <template x-if="displayedCategories.length > 0">                    
                    <div id="categories-selected" class="bg-[#2a2a2a] w-full mt-3 py-3 px-2 flex gap-2">
                        <template x-for="category in displayedCategories">
                            <span x-text="category" class="py-1 px-2 bg-gray-700 border border-gray-600 rounded"></span>
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
                <span class="bg-orange-500 button opacity-50 cursor-progress" wire:loading>loading...</span>
                <Button type="submit" class="bg-orange-500 button" @click="dispatchInputedData()" wire:loading.remove>Publish</Button>
                <Button class="bg-gray-500 button">Draft</Button>
            </div>
        </form>
    </div>
    @php
       var_dump($availCategories); 
    @endphp
</div>
@script
<script>
    Alpine.data("articleAddFunction", () => ({
        
        contents: "",
        categoriesInput: '',


        displayedCategories: [],
        selectedCategoriesKeys: [],
        selectedCategories: [],

        availCategoriesKeys: [],
        availCategoriesValues: [],

        isSelected: false,

        init() {
            $wire.on("status-message", (message) => {
                this.popupMessage(message[0], message[1])

                quill.setContents('');
                this.displayedCategories = []
                this.selectedCategoriesKeys = []
                this.selectedCategories = []

                this.availCategoriesValues = []
                this.availCategoriesKeys = []
                console.log(JSON.parse(JSON.stringify($wire.availCategories)))
                this.getAllCategories()

            })

            console.log(JSON.parse(JSON.stringify($wire.availCategories)))

            this.getAllCategories();
            
            let quill = new Quill('#editor', {
                theme: 'snow'
            });
            quill.on("text-change", (delta,oldDelta, source) => {
                this.contents = quill.getSemanticHTML()
            })
        },

        getAllCategories() {
            JSON.parse(JSON.stringify($wire.availCategories)).forEach(element => {
                this.availCategoriesValues.push(Object.values(element)[0])
                this.availCategoriesKeys.push(Object.keys(element)[0])
            });
        },

        dispatchInputedData(){
            // console.log(this.selectedCategories, this.selectedCategoriesKeys, this.displayedCategories)
            $wire.dispatchSelf('userInput', {"contents": this.contents.replaceAll("&nbsp;", " ").replaceAll(/style=".*"/ig, ""), "categories": this.selectedCategories, "availCategories": this.selectedCategoriesKeys});
            
        },

        get filteredAvailCategories() {
            return this.availCategoriesValues.filter(
                (data,idx) => data.startsWith(this.categoriesInput)
            )
        },

        addCategories() {
            let splittedWord = this.categoriesInput.split(" ")
            if(splittedWord.length > 0){
                for(word of splittedWord){
                    this.displayedCategories.push(word);
                    this.selectedCategories.push(word);
                } 
            } else{
                this.selectedCategories.push(splittedWord);
                this.displayedCategories.push(splittedWord);
            }

            this.categoriesInput = '';
        },

        addThisCategory(category){
            // console.log(this.availCategoriesValues[category])
            this.displayedCategories.push(this.availCategoriesValues[category]);
            this.selectedCategoriesKeys.push(this.availCategoriesKeys[category]);
            this.categoriesInput = '';
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