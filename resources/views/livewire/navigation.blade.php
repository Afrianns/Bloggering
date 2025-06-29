<header class="text-white w-full flex pb-5 py-10" >
    <div class="flex justify-between gap-5 mx-auto items-center w-full" x-data="notificationFunction" x-init="broadcasted('{{ Auth::user()->id }}', {{ $notifications }})">
        <a href="/article/add" class="hover:underline cursor-pointer card" wire:navigate wire:current="font-bold underline">
            Add Article
        </a>
        <ul class="card w-fit flex gap-5 h-fit"> 
            <li class="hover:underline cursor-pointer"><a href="/dashboard" wire:navigate wire:current="font-bold underline">Home</a></li>
            <li class="hover:underline cursor-pointer"><a href="/explore" wire:navigate wire:current="font-bold underline">Explore</a></li>
            <li class="hover:underline cursor-pointer"><a href="/profile/{{ Auth::user()->id }}" wire:navigate wire:current="font-bold underline">Profile</a></li>
            <hr class="border border-[#2a2a2a] h-6">
            <div class="relative">
                <span class="cursor-pointer relative" x-on:click="showNotif()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 512 512"><path fill="currentColor" d="M440.08 341.31c-1.66-2-3.29-4-4.89-5.93c-22-26.61-35.31-42.67-35.31-118c0-39-9.33-71-27.72-95c-13.56-17.73-31.89-31.18-56.05-41.12a3 3 0 0 1-.82-.67C306.6 51.49 282.82 32 256 32s-50.59 19.49-59.28 48.56a3.1 3.1 0 0 1-.81.65c-56.38 23.21-83.78 67.74-83.78 136.14c0 75.36-13.29 91.42-35.31 118c-1.6 1.93-3.23 3.89-4.89 5.93a35.16 35.16 0 0 0-4.65 37.62c6.17 13 19.32 21.07 34.33 21.07H410.5c14.94 0 28-8.06 34.19-21a35.17 35.17 0 0 0-4.61-37.66M256 480a80.06 80.06 0 0 0 70.44-42.13a4 4 0 0 0-3.54-5.87H189.12a4 4 0 0 0-3.55 5.87A80.06 80.06 0 0 0 256 480"/></svg>
                    <span class="w-2 h-2 bg-red-500 rounded-full z-10 absolute top-1 right-0.5" x-show="notifications.length > 0"></span>
                </span>
                <div class="card py-3 absolute -left-10 top-12 w-[250px] max-h-[400px] overflow-y-auto" x-cloak x-show="notif" @click.outside="notif = false" x-cloak>
                    <div class="flex justify-between items-center">
                        <p class="text-sm text-gray-200">Notification</p>
                        <span class="text-xs underline cursor-pointer text-blue-400" x-show="notifications.length > 0" wire:click="removeAllNotification()">Remove all</span>
                    </div>
                    <ul>
                        <template x-for="notification in notifications">
                            <li class="my-2 text-gray-200 border-t  border-[#545454]">
                                <p class="text-xs mt-2">
                                    <a :href="setLink(notification.user_liked_id, 'profile')" class="underline" x-text="notification.user_liked_name"></a>
                                     like your 
                                    <a :href="setLink(notification.article_liked_id, 'article')" class="underline" x-text="notification.article_liked_name"></a>
                                     article
                                </p>
                            </li>
                        </template>
                    </ul>
                </div>
            </div>
        </ul>
        <form action="{{ route('logout') }}" method="post" class="card w-fit">
            @csrf
            <button class="hover:underline cursor-pointer text-red-500">Logout</button>
        </form>
    </div>
    @script
    <script>
        Alpine.data("notificationFunction", () => ({

            notif: false,

            userId: '',

            notifications: [],

            broadcasted(id, notification = []) {

                if(notification.length > 0){
                    this.notifications.push(...notification)
                } else{
                    this.notifications = []
                }

                Echo.private(`App.Models.User.${id}`)
                    .notification((notification) => {
                        this.notifications.push(notification);
                        console.log(this.notifications)
                    });
            },

            showNotif(){
                this.notif = !this.notif
            },

            setLink(id, type){
                if(type == "profile"){
                    return `/profile/${id}`
                } else{
                    return `/dashboard/detail/${id}`
                }
            }
        }))

    </script>
    @endscript
</header>
