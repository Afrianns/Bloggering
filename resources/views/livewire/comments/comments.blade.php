<div class="card my-5 text-gray-100" x-data="commentsFunction" x-init="loadData({{ $comments }})">
    <form action="" method="post" class="flex items-start gap-x-5" wire:submit="commenting">
        <textarea name="comment" id="comment" cols="20" rows="2" wire:model="comment" class="basis-[80%] border border-orange-50 rounded-md py-2 px-3"></textarea>
        <button class="button bg-orange-500 basis-[20%]">Post</button>
    </form>
    @foreach ($errors->all() as $error)
        <p class="my-1 py-1 px-2 bg-red-500 rounded">{{ $error }}</p>
    @endforeach
    
    <livewire:comments.comment :comments="$comments->comments()->get()">
    @script
    <script>
        Alpine.data("commentsFunction", () => ({

            init(){
                $wire.on("success", () => {
                    this.popupMessage("success", "successfully posted.")
                })
            },

            loadData(data){
                console.log(data)
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
        Alpine.data("commentFunction", () => ({
            
            replyText: [],
            comments: [],

            keys: {},



            initalData: [],

            init(){
                $wire.on("success", () => {
                    this.popupMessage("success", "successfully posted.")
                })

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
</div>