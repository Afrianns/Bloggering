<div class="my-5 text-gray-100" x-data="editProfileFunction">
    <h3 class="text-xl my-3 font-bold">Edit Profile</h3>
    <div class="card">
        <form action="" wire:submit="updateProfile" class="flex flex-col gap-y-2 my-5">
            <label for="name">Name</label>
            <input type="text" wire:model="name" class="border p-1 px-2 border-gray-100 block w-full"name="name" id="name">

            <div>@error('name') <p class="my-1 py-1 px-2 bg-red-500 rounded">{{ $message }}</p> @enderror</div>
            <label for="email">Email</label>
            <input type="text" wire:model="email" class="border p-1 px-2 border-gray-100 block w-full"name="email" id="email">
            
            <div>@error('email') <p class="my-1 py-1 px-2 bg-red-500 rounded">{{ $message }}</p> @enderror</div>

            <span class="bg-green-500 button opacity-50 cursor-progress mt-5" wire:loading>loading...</span>
            <button class="button bg-green-500 mt-5" wire:loading.remove>Update</button>
        </form>
    </div>
    <h3 class="text-xl my-3 font-bold">Profile Details (Optional)</h3>
    <div class="card" wire:submit="updateProfileDetails">
        <form action="" class="flex flex-col gap-y-2 my-5">
            <label for="address">Address</label>
            <input type="text" wire:model="address" class="border p-1 px-2 border-gray-100 block w-full"name="address" id="address" placeholder="type your location">

            <label for="description">Description</label>
            <input type="text" wire:model="description" class="border p-1 px-2 border-gray-100 block w-full"name="description" id="description" placeholder="type your profile description">
        
            <label for="link">Links</label>
            <template x-for="(link, id) in links">
                    <div class="flex gap-x-2 items-center relative">
                        <div x-html="linksIcon[link['icon']]"></div>
                        <input type="text" class="border p-1 px-2 border-gray-100 block w-full text-sm" 
                        :class="{'border-red-500 outline-red-600 focus:outline' : (!validateURL(link['url']) && link['url'] != '')}" name="link" id="link" x-model="link['url']" placeholder="E.g. http(s)://...">
                        <template x-if="!validateURL(link['url']) && link['url'] != ''">
                            <span class="absolute right-0 flex items-center gap-x-2" >
                                <p class="text-red-500 text-sm">Invalid URL</p>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"  class="mr-2" viewBox="0 0 20 20"><path class="fill-red-500" d="M2.93 17.07A10 10 0 1 1 17.07 2.93A10 10 0 0 1 2.93 17.07m12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32M9 5h2v6H9zm0 8h2v2H9z"/></svg>
                            </span>
                        </template>
                    </div>
            </template>

            <span class="bg-green-500 button opacity-50 cursor-progress mt-5" wire:loading>loading...</span>
            <button class="button bg-green-500 mt-5" @click="saveLinks()" wire:loading.remove>Update</button>
            
        </form>
        <a href="www.google.com">click</a>
    </div>
    @script
    <script>
        Alpine.data("editProfileFunction", () => ({

            linksIcon: {
                "Personal Site" : `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 14 14"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1"><path d="M7 13.5a6.5 6.5 0 1 0 0-13a6.5 6.5 0 0 0 0 13M.5 7h13"/><path d="M9.5 7A11.22 11.22 0 0 1 7 13.5A11.22 11.22 0 0 1 4.5 7A11.22 11.22 0 0 1 7 .5A11.22 11.22 0 0 1 9.5 7"/></g></svg>`,
                "Facebook": `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"><g fill="none"><g clip-path="url(#akarIconsFacebookFill0)"><path fill="currentColor" fill-rule="evenodd" d="M0 12.067C0 18.034 4.333 22.994 10 24v-8.667H7V12h3V9.333c0-3 1.933-4.666 4.667-4.666c.866 0 1.8.133 2.666.266V8H15.8c-1.467 0-1.8.733-1.8 1.667V12h3.2l-.533 3.333H14V24c5.667-1.006 10-5.966 10-11.933C24 5.43 18.6 0 12 0S0 5.43 0 12.067" clip-rule="evenodd"/></g><defs><clipPath id="akarIconsFacebookFill0"><path fill="#fff" d="M0 0h24v24H0z"/></clipPath></defs></g></svg>`, 
                "Instagram":`<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"><path fill="currentColor" fill-rule="evenodd" d="M7.465 1.066C8.638 1.012 9.012 1 12 1s3.362.013 4.534.066s1.972.24 2.672.511c.733.277 1.398.71 1.948 1.27c.56.549.992 1.213 1.268 1.947c.272.7.458 1.5.512 2.67C22.988 8.639 23 9.013 23 12s-.013 3.362-.066 4.535c-.053 1.17-.24 1.97-.512 2.67a5.4 5.4 0 0 1-1.268 1.949c-.55.56-1.215.992-1.948 1.268c-.7.272-1.5.458-2.67.512c-1.174.054-1.548.066-4.536.066s-3.362-.013-4.535-.066c-1.17-.053-1.97-.24-2.67-.512a5.4 5.4 0 0 1-1.949-1.268a5.4 5.4 0 0 1-1.269-1.948c-.271-.7-.457-1.5-.511-2.67C1.012 15.361 1 14.987 1 12s.013-3.362.066-4.534s.24-1.972.511-2.672a5.4 5.4 0 0 1 1.27-1.948a5.4 5.4 0 0 1 1.947-1.269c.7-.271 1.5-.457 2.67-.511m8.98 1.98c-1.16-.053-1.508-.064-4.445-.064s-3.285.011-4.445.064c-1.073.049-1.655.228-2.043.379c-.513.2-.88.437-1.265.822a3.4 3.4 0 0 0-.822 1.265c-.151.388-.33.97-.379 2.043c-.053 1.16-.064 1.508-.064 4.445s.011 3.285.064 4.445c.049 1.073.228 1.655.379 2.043c.176.477.457.91.822 1.265c.355.365.788.646 1.265.822c.388.151.97.33 2.043.379c1.16.053 1.507.064 4.445.064s3.285-.011 4.445-.064c1.073-.049 1.655-.228 2.043-.379c.513-.2.88-.437 1.265-.822c.365-.355.646-.788.822-1.265c.151-.388.33-.97.379-2.043c.053-1.16.064-1.508.064-4.445s-.011-3.285-.064-4.445c-.049-1.073-.228-1.655-.379-2.043c-.2-.513-.437-.88-.822-1.265a3.4 3.4 0 0 0-1.265-.822c-.388-.151-.97-.33-2.043-.379m-5.85 12.345a3.669 3.669 0 0 0 4-5.986a3.67 3.67 0 1 0-4 5.986M8.002 8.002a5.654 5.654 0 1 1 7.996 7.996a5.654 5.654 0 0 1-7.996-7.996m10.906-.814a1.337 1.337 0 1 0-1.89-1.89a1.337 1.337 0 0 0 1.89 1.89" clip-rule="evenodd"/></svg>`, 
                "Twitter":`<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"><path fill="currentColor" d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334q.002-.211-.006-.422A6.7 6.7 0 0 0 16 3.542a6.7 6.7 0 0 1-1.889.518a3.3 3.3 0 0 0 1.447-1.817a6.5 6.5 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.32 9.32 0 0 1-6.767-3.429a3.29 3.29 0 0 0 1.018 4.382A3.3 3.3 0 0 1 .64 6.575v.045a3.29 3.29 0 0 0 2.632 3.218a3.2 3.2 0 0 1-.865.115a3 3 0 0 1-.614-.057a3.28 3.28 0 0 0 3.067 2.277A6.6 6.6 0 0 1 .78 13.58a6 6 0 0 1-.78-.045A9.34 9.34 0 0 0 5.026 15"/></svg>`
            },

            links: [
                {"icon": "Personal Site", "url": ""}, 
                {"icon": "Facebook","url":""}, 
                {"icon": "Instagram", "url": ""}, 
                {"icon": "Twitter", "url": ""}
            ],

            init() {

                $wire.on("status-message", (message) => {
                    this.popupMessage(message[0], message[1]);
                })
            },

            saveLinks(){
                $wire.gettingLinks(this.links);
                console.log(this.links)
            },

            validateURL(url) {
                const regex = /(http(s)?):\/\/[a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&//=]*)/;
                return regex.test(url);
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
