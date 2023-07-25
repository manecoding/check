<script setup>
import { onMounted, ref, reactive } from "vue";
import { useRoute } from "vue-router";
import { RouterLink } from "vue-router";

let route = useRoute();
let member = ref();
let isChecked = ref(false);

onMounted(async () => {
    getList();
});

const getList = async () => {
    try {
        const response = await axios.get(
            "/api/detail_checked_list/1" + route.params.id
        );
        if (response.status == 200) member.value = response.data.data;
    } catch (err) {
        console.log(err);
    }
};
function setIcon(icon) {
    return "/icons/" + icon;
}
</script>
<template>
    <div
        class="w-full bg-white border-solid border-gray-300 border-b py-2 px-5 lg:px-10"
    >
        <div class="flex justify-between items-center">
            <div class="">
                <RouterLink to="/">
                    <img
                        :src="setIcon('back.svg')"
                        alt=""
                        class="w-[25px] h-[25px]"
                    />
                </RouterLink>
            </div>
            <h1 class="font-semibold text-xl lg:text-2xl text-black uppercase">
                Member profile
            </h1>
            <p></p>
        </div>
    </div>
    <div v-if="member" class="flex flex-col items-center p-4 gap-3">
        <h5 class="text-2xl font-bold tracking-tight text-black">
            {{ member.name }}
        </h5>
        <div class="flex items-center gap-2"></div>
        <div class="flex items-center gap-2"></div>
        <div
            class="flex items-center flex-col gap-3 w-full mt-3 bg-body p-5 rounded-md shadow-md"
        >
            <div class="flex flex-col justify-center items-center">
                <img
                    :src="setIcon('profession.svg')"
                    alt=""
                    class="w-[20px] h-[20px]"
                />
                <p class="font-normal text-gray-700">
                    {{ member.profession }}
                </p>
            </div>
            <div class="flex flex-col justify-center items-center">
                <img
                    :src="setIcon('company.svg')"
                    alt=""
                    class="w-[20px] h-[20px]"
                />
                <p class="font-normal text-gray-700 mb-2">
                    {{ member.company_name }}
                </p>
            </div>
            <div class="flex flex-col justify-center items-center">
                <img
                    :src="setIcon('phone.svg')"
                    alt=""
                    class="w-[20px] h-[20px]"
                />
                <p class="font-normal text-gray-700 mb-2">
                    {{ member.contact }}
                </p>
            </div>
            <div class="flex flex-col justify-center items-center">
                <img
                    :src="setIcon('email.svg')"
                    alt=""
                    class="w-[20px] h-[20px]"
                />
                <p class="font-normal text-gray-700 mb-2">{{ member.email }}</p>
            </div>
            <p class="font-normal text-gray-700 mb-2">
                <span class="font-semibold uppercase">Invited by: </span
                ><span>{{ member.invited_by }}</span>
            </p>
        </div>
        <div class="fixed mt-4 bottom-5 right-5">
            <RouterLink :to="'/payment/' + route.params.id">
                <button
                    class="inline-flex items-center justify-between gap-2 px-3 py-2 text-sm font-medium text-center text-white bg-primary rounded-lg focus:ring-4 focus:outline-none focus:ring-blue-300"
                >
                    <p class="font-bold">Check-in</p>
                    <img
                        :src="setIcon('check1.svg')"
                        alt=""
                        class="w-[20px] h-[20px]"
                    />
                </button>
            </RouterLink>
        </div>
    </div>
</template>
