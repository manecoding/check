<script setup>
import { computed, ref } from "@vue/reactivity";
import { onMounted, watch } from "vue";
import { useRouter, RouterLink } from "vue-router";
import axios from "axios";

const ITEM_PER_PAGE = 12;

let isFounded = ref(true);
let limitPage = ref(0);
let activePage = ref(1);

let lists = ref([]);
const searchTerm = ref("");

onMounted(async () => {
    getList();
});
const byPage = async (index) => {
    activePage.value = index;
};

const scrollToTop = () => {
    window.scrollTo({ top: 0, behavior: "smooth" });
};

watch(
    [activePage],
    () => {
        scrollToTop();
    },
    { immediate: true }
);
let itemByPage = computed(() => {
    let list = [];
    for (let index = 0; index < lists.value.length; index++) {
        if (
            index >= (activePage.value - 1) * ITEM_PER_PAGE &&
            index < activePage.value * ITEM_PER_PAGE
        )
            list.push(lists.value[index]);
    }
    return list;
});
const getList = async () => {
    const respone = await axios.get("/api/check_list");
    lists.value = respone.data.data;
    limitPage = respone.data.limit_page;
};
const search = async () => {
    if (searchTerm.value != "") {
        try {
            const response = await axios.get("/api/search_check_list/", {
                headers: {
                    Accept: "application/json",
                },
                params: {
                    name: searchTerm.value,
                },
            });
            lists.value = response.data.data;
            limitPage = response.data.limit_page;
            isFounded.value = true;
        } catch (err) {
            console.log(err);
            isFounded.value = false;
        }
    }
    if (searchTerm.value == "") {
        isFounded.value = true;
        getList();
    }
};

function setIcon(icon) {
    return "/icons/" + icon;
}

function Image(image) {
    return image;
}
</script>

<template>
    <div class="">
        <div
            class="sticky z-50 top-0 flex justify-between items-center w-full bg-red-500 border-solid border-gray-300 border-b py-3 px-5 lg:px-10"
        >
            <div class="flex items-center">
                <h1 class="font-semibold text-xl lg:text-2xl text-white">
                    BNI SUPER<br />
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

        <div
            class="bg-white relative border-solid border-t border-b border-gray-200 border-t-gray-300 px-5 lg:px-10"
        >
            <div
                class="grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 mt-5 w-full pb-2 overflow-x-auto overflow-y-none scroll-smooth scrollbar-thin scrollbar-track-gray-200 scrollbar-track-rounded-xl scrollbar-thumb-current scrollbar-thumb-rounded-xl"
            >
                <!-- loop item -->
                <div
                    v-if="isFounded"
                    v-for="(item, index) in itemByPage"
                    class="relative"
                >
                    <div
                        class="flex justify-between gap-2 p-3 bg-[#f5e5e5] border border-gray-200 rounded-lg shadow"
                    >
                        <div class="">
                            <h5
                                class="uppercase text-2xl font-bold tracking-tight text-gray-900"
                            >
                                {{ item.name }}
                            </h5>
                            <div class="flex items-center gap-2">
                                <img
                                    :src="setIcon('company.svg')"
                                    alt=""
                                    class="w-[20px] h-[20px]"
                                />
                                <p class="font-bold text-gray-700 text-md">
                                    {{ item.company_name }}
                                </p>
                            </div>
                            <div class="flex items-center gap-2">
                                <img
                                    :src="setIcon('profession.svg')"
                                    alt=""
                                    class="w-[20px] h-[20px]"
                                />
                                <p class="font-bold text-gray-700">
                                    {{ item.profession }}
                                </p>
                            </div>

                            <div class="flex items-center gap-2">
                                <img
                                    :src="setIcon('email.svg')"
                                    alt=""
                                    class="w-[20px] h-[20px]"
                                />
                                <p class="font-bold text-gray-700">
                                    {{ item.email }}
                                </p>
                            </div>
                            <div class="flex items-center gap-2">
                                <img
                                    :src="setIcon('phone.svg')"
                                    alt=""
                                    class="w-[20px] h-[20px]"
                                />
                                <p class="font-bold text-gray-700">
                                    {{ item.contact }}
                                </p>
                            </div>
                        </div>
                        <!-- <div class="w-6 h-6"> -->
                        <!-- <RouterLink :to="'/detail/' + item.id"> -->
                        <!-- <img
                                    :src="setIcon('next.svg')"
                                    alt=""
                                    class="w-full h-full"
                                /> -->
                        <!-- </RouterLink> -->
                        <!-- </div> -->
                        <RouterLink
                            :to="'/payment/' + item.id"
                            class="absolute top-5 right-5"
                        >
                            <button
                                class="inline-flex items-center justify-between gap-2 px-3 py-2 text-sm font-medium text-center text-white bg-red-500 rounded-lg focus:ring-4 focus:outline-none focus:ring-blue-300"
                            >
                                <p class="font-bold">Check-in</p>
                                <img
                                    :src="setIcon('check1.svg')"
                                    alt=""
                                    class="w-[20px] h-[20px]"
                                />
                            </button>
                        </RouterLink>
                        <div class="absolute top-[60px] right-5">
                            <span class="font-semibold uppercase">by: </span>
                            <span>{{ item.invited_by }}</span>
                        </div>
                    </div>
                </div>
                <div v-else>
                    <h1 class="font-semibold text-lg">List not found</h1>
                </div>
            </div>

            <div
                class="flex items-center justify-between border-t border-gray-200 bg-white px-2 py-3 sm:px-2 mb-7"
            >
                <div class="flex flex-1 justify-between sm:hidden">
                    <button
                        @click="
                            activePage =
                                activePage > 1 ? activePage - 1 : activePage
                        "
                        class="relative inline-flex items-center rounded-md border border-gray-300 bg-white border-solid px-4 py-2 text-sm font-medium text-gray-700 hover:bg-body cursor-pointer"
                    >
                        Previous
                    </button>
                    <button
                        @click="
                            activePage =
                                activePage < limitPage
                                    ? activePage + 1
                                    : activePage
                        "
                        class="relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white border-solid px-4 py-2 text-sm font-medium text-gray-700 hover:bg-body cursor-pointer"
                    >
                        Next
                    </button>
                </div>

                <div
                    class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between"
                >
                    <div>
                        <p class="text-sm text-gray-700">
                            Showing
                            <span class="font-medium">{{
                                lists.length > 0
                                    ? (activePage - 1) * ITEM_PER_PAGE + 1
                                    : 0
                            }}</span>
                            to
                            <span class="font-medium">{{
                                lists.length -
                                    (activePage - 1) * ITEM_PER_PAGE >
                                ITEM_PER_PAGE
                                    ? activePage * ITEM_PER_PAGE
                                    : lists.length
                            }}</span>
                            of
                            <span class="font-medium">{{ lists.length }}</span>
                            results
                        </p>
                    </div>
                    <div>
                        <nav
                            class="flex gap-2 rounded-md"
                            aria-label="Pagination"
                        >
                            <button
                                @click="
                                    activePage =
                                        activePage > 1
                                            ? activePage - 1
                                            : activePage
                                "
                                class="relative cursor-pointer inline-flex items-center rounded-l-md bg-white px-2 py-2 text-sm font-medium text-gray-500 hover:bg-gray-50 focus:z-20"
                            >
                                <span class="sr-only">Previous</span>
                                <img
                                    :src="setIcon('left.svg')"
                                    alt=""
                                    class="h-4 w-4"
                                />
                            </button>

                            <button
                                v-for="(item, index) in limitPage"
                                @click="byPage(index + 1)"
                                :class="
                                    index + 1 == activePage
                                        ? 'bg-primary border-primary text-white hover:bg-primary'
                                        : 'border-gray-300 text-gray-500 bg-white hover:bg-gray-50'
                                "
                                class="relative rounded-md cursor-pointer inline-flex items-center border-solid border px-3 py-1 text-sm font-medium focus:z-20"
                            >
                                {{ index + 1 }}
                            </button>

                            <button
                                @click="
                                    activePage =
                                        activePage < limitPage
                                            ? activePage + 1
                                            : activePage
                                "
                                class="relative cursor-pointer inline-flex items-center rounded-r-md bg-white px-2 py-2 text-sm font-medium text-gray-500 hover:bg-gray-50 focus:z-20"
                            >
                                <span class="sr-only">Next</span>
                                <img
                                    :src="setIcon('right.svg')"
                                    alt=""
                                    class="h-4 w-4"
                                />
                            </button>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
