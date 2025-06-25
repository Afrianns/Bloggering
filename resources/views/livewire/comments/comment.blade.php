<div @class(['ml-5' => $margin]) x-data="commentFunction">
    @foreach ($comments as $key => $comment)
        <div class="my-5">
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
                            <h3>{{ $comment->user->name }}</h3>
                            <span class="text-gray-400 text-xs">{{ $comment->user->email }}</span>
                        </section>
                        <p class="text-gray-400 text-sm">{{ Carbon\Carbon::parse($comment->created_at)->locale("id_ID")->isoFormat("d MMMM g - kk:hh") }}</p>
                    </div>

                    <div class="my-2">
                        {{ $comment->comment }}
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
            <livewire:comments.comment :comments="$comment->replies()->get()" :margin="true" >
        </div>
    @endforeach
</div>
