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

            loadData(data){
                console.log(data)
            }
        }))
        Alpine.data("commentFunction", () => ({
            
            replyText: [],
            comments: [],

            replyError: '',

            keys: {},

            initalData: [],

            init(){
                $wire.on("error", () => {
                    this.replyError = "reply cannot be empty";
                    // console.log()
                })
            },

            // reply(key,comment_id, post_id){
            //     $wire.replying(key, comment_id, post_id, this.replyText[key])
            //     console.log(key, comment_id, post_id, this.replyText[key])
            // }

            showReply(key) {
                for (const key in this.keys) {
                    this.keys[key] = false;
                }
                
                this.keys[key] = true;

                console.log(this.keys)
            },

            // isExist(commentID){
            //     console.log("is here", commentID)
            //     for (const key in this.keys) {
            //         if(commentID == key){
            //             return true;
            //         } else{
            //             return false;
            //         }
            //     //    console./log(key, commentID, this.keys);
            //     }
                
            //     // return (key == this.key);
            // }
        }))
    </script>
    @endscript
</div>