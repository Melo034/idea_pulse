<div x-data="footerComponent()">
    <footer class="text-white bg-black px-4 py-5 max-w-screen-xl mx-auto md:px-8">
        <div class="max-w-lg sm:mx-auto sm:text-center">
            <h1> <span style="font-family: 'Elsie Swash Caps', serif; font-weight: 900; font-style: normal;"><span class="text-5xl text-rose-400">IdeaPulse</span></span></h1>
            <p class="leading-relaxed mt-2 text-[15px]">
                Ignite Your Creativity
            </p>
        </div>
        <ul class="items-center justify-center mt-8 space-y-5 sm:flex sm:space-x-4 sm:space-y-0">
            <template x-for="(item, idx) in footerNavs" :key="idx">
                <li class="hover:text-rose-600">
                    <a :href="item.href" x-text="item.name"></a>
                </li>
            </template>
        </ul>
        <div class="mt-8 items-center justify-between sm:flex">
            <div class="mt-4 sm:mt-0">
                &copy; 2024 IdeaPulse All rights reserved.
            </div>
            <div class="mt-6 sm:mt-0">
                <ul class="flex items-center mt-2 space-x-4">
                    <li class="flex items-center justify-center w-10 h-10 wow animate__animated animate__zoomIn">
                        <a href="https://www.facebook.com/melvin.kanu.140?mibextid=LQQJ4d" class="group flex justify-center rounded-md drop-shadow-xl gray-800  text-white font-semibold hover:translate-y-3 hover:rounded-[50%] transition-all duration-500 hover:rose-700 hover:to-rose-600">
                            <img src="./assets/icons8-facebook-48.png" alt="" class="w-10 h-10 bg-white rounded-lg">
                            <span class="absolute opacity-0 group-hover:opacity-100 group-hover:text-rose-600 group-hover:text-xs group-hover:-translate-y-6 duration-700">
                                Facebook
                            </span>
                        </a>
                    </li>

                    <li class="flex items-center justify-center w-10 h-10 wow animate__animated animate__zoomIn">
                        <a href="https://github.com/Melo034" class="group flex justify-center rounded-md drop-shadow-xl gray-800  text-white font-semibold hover:translate-y-3 hover:rounded-[50%] transition-all duration-500 hover:rose-700 hover:to-rose-600">
                            <img src="./assets/icons8-github-30.png" alt="" class="w-10 h-10 bg-white rounded-lg">
                            <span class="absolute opacity-0 group-hover:opacity-100 group-hover:text-rose-600 group-hover:text-xs group-hover:-translate-y-6 duration-700">
                                GitHub
                            </span>
                        </a>
                    </li>

                    <li class="flex items-center justify-center w-10 h-10 wow animate__animated animate__zoomIn">
                        <a href="https://www.instagram.com/melvinllllll" class="group flex justify-center rounded-md drop-shadow-xl gray-800  text-white font-semibold hover:translate-y-3 hover:rounded-[50%] transition-all duration-500 hover:rose-700 hover:to-rose-600">
                            <img src="./assets/icons8-instagram-48.png" alt="" class="w-10 h-10 bg-white rounded-lg">
                            <span class="absolute opacity-0 group-hover:opacity-100 group-hover:text-rose-600 group-hover:text-xs group-hover:-translate-y-6 duration-700">
                                Instagram
                            </span>
                        </a>
                    </li>

                    <li class="flex items-center justify-center w-10 h-10 wow animate__animated animate__zoomIn">
                        <a href="https://x.com/melsougly" class="group flex justify-center rounded-md drop-shadow-xl gray-800  text-white font-semibold hover:translate-y-3 hover:rounded-[50%] transition-all duration-500 hover:rose-700 hover:to-rose-600">
                            <img src="./assets/icons8-twitterx-50.png" alt="" class="w-10 h-10 bg-white rounded-lg">
                            <span class="absolute opacity-0 group-hover:opacity-100 group-hover:text-rose-600 group-hover:text-xs group-hover:-translate-y-6 duration-700">
                                X
                            </span>
                        </a>
                    </li>
                    <li class="flex items-center justify-center w-10 h-10 wow animate__animated animate__zoomIn">
                        <a href="https://wa.me/23234024642" class="group flex justify-center rounded-md drop-shadow-xl gray-800  text-white font-semibold hover:translate-y-3 hover:rounded-[50%] transition-all duration-500 hover:rose-700 hover:to-rose-600">
                            <img src="./assets/icons8-whatsapp-48.png" alt="" class="w-10 h-10 bg-white rounded-lg">
                            <span class="absolute opacity-0 group-hover:opacity-100 group-hover:text-rose-600 group-hover:text-xs group-hover:-translate-y-6 duration-700">
                                Whatsapp
                            </span>
                        </a>
                    </li>
                    <li class="flex items-center justify-center w-10 h-10 wow animate__animated animate__zoomIn">
                        <a href="https://www.linkedin.com/in/joseph-melvin-kanu-997b84210" class="group flex justify-center rounded-md drop-shadow-xl gray-800  text-white font-semibold hover:translate-y-3 hover:rounded-[50%] transition-all duration-500 hover:rose-700 hover:to-rose-600">
                            <img src="./assets/icons8-linkedin-48.png" alt="" class="w-10 h-10 bg-white rounded-lg">
                            <span class="absolute opacity-0 group-hover:opacity-100 group-hover:text-rose-600 group-hover:text-xs group-hover:-translate-y-6 duration-700">
                                Linkedln
                            </span>
                        </a>
                    </li>
                    <li class="flex items-center justify-center w-10 h-10 wow animate__animated animate__zoomIn">
                        <a href="javascript:void()" class="group flex justify-center rounded-md drop-shadow-xl gray-800  text-white font-semibold hover:translate-y-3 hover:rounded-[50%] transition-all duration-500 hover:rose-700 hover:to-rose-600">
                            <img src="./assets/icons8-discord-48.png" alt="" class="w-10 h-10 bg-white rounded-lg">
                            <span class="absolute opacity-0 group-hover:opacity-100 group-hover:text-rose-600 group-hover:text-xs group-hover:-translate-y-6 duration-700">
                                Discord
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </footer>
</div>
<style scoped>
    .svg-icon path,
    .svg-icon polygon,
    .svg-icon rect {
        fill: currentColor;
    }
</style>
<script>
    function footerComponent() {
        return {
            footerNavs: [{
                    href: "javascript:void()",
                    name: "About",
                },
                {
                    href: "javascript:void()",
                    name: "Support",
                },
            ],
        };
    }
</script>