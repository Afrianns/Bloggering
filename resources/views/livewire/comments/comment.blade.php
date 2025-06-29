<div @class(['ml-5' => $margin]) x-data="commentFunction">
    @foreach ($comments as $key => $comment)
        <div class="my-5" wire:key="{{ $key }}">
           @if ($comment->trashed() && $comment->replies()->count() > 0)
            <div class="border border-gray-500 rounded-md py-3 px-5 flex items-center gap-x-2">
                <p class="text-gray-600">Deleted Comment</p>
            </div>
           @endif
           
           @if(!$comment->trashed())
            @if ($comment->user->id === Auth::user()->id)
                <div class="flex ml-auto mb-2">
                    <span class="text-[#ff2828] cursor-pointer hover:underline ml-auto" x-on:click="deleteComment('{{$comment->id}}')">Delete</span>
                </div>
           @endif
            <div class="border border-gray-500 rounded-md py-3 px-5 flex items-center gap-x-2">
                <section class="basis-[5%]">
                    @php
                       $votedUp = Auth::user()->isVoted($comment->id, true); 
                       $votedDown = Auth::user()->isVoted($comment->id, false); 
                    @endphp
                    <div class="flex gap-y-1 w-5 flex-col items-center">
                        <span  @class(["p-1 border-gray-900 cursor-pointer","bg-red-500" => $votedUp == 1, "bg-gray-700" => $votedUp == 0]) wire:click="VoteUporDown({{ $comment->id }}, true)">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"><path fill="currentColor" d="M3 19h18a1.002 1.002 0 0 0 .823-1.569l-9-13c-.373-.539-1.271-.539-1.645 0l-9 13A.999.999 0 0 0 3 19"/></svg>
                        </span>
                        <p>{{ $comment->votesCount($comment->id) }}</p>
                        <span  @class(["p-1 border-gray-900 cursor-pointer rotate-180","bg-red-500" => $votedDown == 1, "bg-gray-700" => $votedDown == 0]) wire:click="VoteUporDown({{ $comment->id }}, false)">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"><path fill="currentColor" d="M3 19h18a1.002 1.002 0 0 0 .823-1.569l-9-13c-.373-.539-1.271-.539-1.645 0l-9 13A.999.999 0 0 0 3 19"/></svg>
                        </span>
                    </div>
                </section>
                <section class="basis-[95%]">
                    <div class="my-1 flex justify-between items-center">
                        <section class="leading-4">
                            <div class="flex gap-x-2 items-center">
                                <h3>{{ $comment->user->name }}</h3>
                                @if ($comment->user->id == $ownerUserIdArticle)
                                    <p class="text-[8px] px-2 border border-gray-400 rounded-sm">OP</p>
                                @endif
                            </div>
                            <span class="text-gray-400 text-xs">{{ $comment->user->email }}</span>
                        </section>
                        @php
                            $createdAt = Carbon\Carbon::parse($comment->created_at)->locale("id_ID")->isoFormat("d MMMM g - kk:hh");
                            $updatedAt = Carbon\Carbon::parse($comment->updated_at)->locale("id_ID")->isoFormat("d MMMM g - kk:hh");
                        @endphp
                        <div class="flex text-xs items-center gap-x-2">
                            @if ($createdAt != $updatedAt)
                                <span class="text-gray-400">(Edited)</span>
                            @endif
                            <p class="text-gray-200 text-sm">{{ $createdAt }}</p>
                        </div>
                    </div>

                    <div class="flex justify-between items-start">
                        <div class="my-2" x-show="!ListIsEdit['{{ $comment->id }}']">
                            {{ $comment->comment }}
                        </div>
                        @if ($comment->user->id === Auth::user()->id)
                            <form wire:submit="editComment({{$comment->id}}, '{{ $comment->post_id }}', {{ $comment->comment }})" method="post" class="w-full flex justify-between items-start" x-show="ListIsEdit['{{ $comment->id }}']">
                                <input type="text" name="comment" wire:model="editedComment.{{ $key }}.{{ $comment->id }}" id="comment" class="basis-[90%] border border-gray-200 rounded-sm p-2"></input>
                                <button class="text-green-500 hover:underline cursor-pointer" x-on:click="editComment('{{ $comment->comment }}', {{ $comment->id }}, false)">Done</button>
                            </form>
                            <p class="text-green-500 hover:underline cursor-pointer" x-show="!ListIsEdit['{{ $comment->id }}']" x-on:click="editComment('{{ $comment->comment }}', {{ $comment->id }}, true)">Edit</p>
                        @endif
                    </div>
                </section>
            </div>
            
            <form action=""class="flex items-start gap-x-3 mt-2" wire:submit="replying({{ $comment->id }}, '{{ $comment->post_id }}')">
                <input name="reply" id="reply" wire:model="reply.{{ $comment->id }}" class="basis-[90%] border border-gray-200 rounded-sm p-2"></textarea>
                
                <Button type="submit" class="button basis-[10%] bg-amber-500">reply</Button>
            </form>
           <div class="mt-3">
               @error("reply.$comment->id")
               <p class="my-1 py-1 px-2 bg-red-500 rounded">{{ $message }}</p>
               @enderror
            </div>
           @endif 
            <livewire:comments.comment :comments="$comment->replies()->get()" :margin="true" :ownerUserIdArticle="$ownerUserIdArticle">
        </div>
    @endforeach
    @script
    <script>
        Alpine.data("commentFunction", () => ({
            
            replyText: [],
            comments: [],

            keys: {},

            voteCount: 0,

            initalData: [],

            ListIsEdit: {},
            
            editComment(comment, idx, value){
                this.ListIsEdit[idx] = value;
            },

            deleteComment(commentID){

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
                        console.log(commentID);
                        $wire.deleteComment(commentID);
                    } else if (
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                    }
                });
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
            },
        }))
    </script>
    @endscript
</div>
