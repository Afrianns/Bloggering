<div class="ml-{{ $margin }}" x-data="commentFunction" >
    @foreach ($comments as $key => $comment)

        <div class="my-5" wire:key="item-{{ $comment->id }}">
            <div class="border border-gray-500 rounded-md py-3 px-5 flex items-center gap-x-2">
                <section class="basis-[5%]">
                    <div class="flex gap-y-2 w-5 flex-col items-center">
                        <span class="p-1 bg-gray-700 border-gray-900 hover:bg-gray-800 cursor-pointer"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24"><path d="M4   14h4v7a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-7h4a1.001 1.001 0 0 0 .781-1.625l-8-10c-.381-.475-1.181-.   475-1.562 0l-8 10A1.001 1.001 0 0 0 4 14"/></svg></span>
                        <span class="p-1 bg-gray-700 border-gray-900 hover:bg-gray-800 rotate-180 cursor-pointer"><svg  xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" ><path d="M4   14h4v7a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-7h4a1.001 1.001 0 0 0 .781-1.625l-8-10c-.381-.475-1.181-.   475-1.562 0l-8 10A1.001 1.001 0 0 0 4 14"/></svg></span>
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
                
                {{-- <span class="bg-amber-500 button opacity-50 cursor-progress basis-[10%]" wire:loading>loading...</span> --}}
                <Button type="submit" class="button basis-[10%] bg-amber-500">reply</Button>
            </form>
           <div class="mt-3">
               @error("reply.$comment->id")
               <p class="my-1 py-1 px-2 bg-red-500 rounded">{{ $message }}</p>
               @enderror
            </div> 
            <livewire:comments.comment :comments="$comment->replies()->get()" :margin="5" >
        </div>
    @endforeach
</div>
