<script setup>
import { ref, onMounted } from "vue";
let open = ref(false);
let profile = ref({});

function handle(value) {
    open.value = value;
}
function setIcon(icon) {
    return "/icons/" + icon;
}
</script>

<template>
    <div
        class="sticky z-50 top-0 flex justify-between items-center w-full bg-red-500 border-solid border-gray-300 border-b py-3 px-5 lg:px-10"
    >
        <div class="flex items-center">
            <h1 class="font-semibold text-xl lg:text-2xl text-black">
                BNI SUPER <br />
                Mega Visitor's Day
            </h1>
        </div>
        <div class="relative">
            <input
                @keydown.enter="search()"
                v-model="searchTerm"
                type="text"
                name=""
                id=""
                placeholder="Search..."
                class="text-sm outline-none pl-10 w-full lg:w-[300px] h-[40px] rounded-md border-gray-300 border-solid border focus:border-current focus:ring-current"
            />
            <img
                :src="setIcon('search.svg')"
                alt=""
                class="absolute top-[50%] left-3 translate-y-[-50%] w-5 h-5"
            />
        </div>
    </div>
</template>
