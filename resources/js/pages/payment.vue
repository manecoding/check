<script setup>
import { onMounted, ref } from "vue";
import { RouterLink, useRouter } from "vue-router";
import { useRoute } from "vue-router";
const payment = ref(["Cash", "Bank", "Other"]);

let isChecked = ref(false);
let route = useRoute();

onMounted(() => {
    form.value.payment_id = payment.value[0];
});
let form = ref({
    payment_id: "",
    remark: "",
});
function Image(image) {
    return "/image/" + image;
}
const updateCheck = () => {
    Swal.fire({
        html: `<span class="text-2xl">Are you</span> <span class="font-bold text-2xl"> sure</span><span class="text-2xl">?</span>`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, check it!",
        cancelButtonText: "No, cancel!",
        confirmButtonColor: "#0056b3c2",
        cancelButtonColor: "#d33",
        reverseButtons: true,
    }).then(async (result) => {
        if (result.isConfirmed) {
            const formData = new FormData();

            formData.append("id", route.params.id);
            formData.append("pay_by", form.value.payment_id);
            formData.append("remark", form.value.remark);
            formData.append("_method", "PUT");
            axios
                .post("/api/update_check_list", formData, {})
                .then((res) => {
                    if (res.data.success) {
                        Swal.fire({
                            toast: true,
                            position: "top",
                            showClass: {
                                icon: "animated heartBeat delay-1s",
                            },
                            icon: "success",
                            text: res.data.message,
                            showConfirmButton: false,
                            timer: 1000,
                        });
                        isChecked.value = true;
                    }
                })
                .catch((err) => {
                    console.log(err);
                });
        }
    });
};
function setIcon(icon) {
    return "/icons/" + icon;
}
</script>
<template>
    <div
        class="sticky z-50 top-0 w-full bg-white border-solid border-gray-300 border-b py-2 px-5 lg:px-10"
    >
        <div class="relative flex justify-center items-center">
            <div class="absolute left-0">
                <RouterLink to="/">
                    <img
                        :src="setIcon('back.svg')"
                        alt=""
                        class="w-[25px] h-[25px]"
                    />
                </RouterLink>
            </div>
            <h1 class="font-semibold text-xl lg:text-2xl text-black uppercase">
                Payment
            </h1>
        </div>
    </div>
    <div v-if="isChecked" class="h-[80vh] flex justify-center items-center">
        <h1>Thank you for check-in.</h1>
    </div>
    <div v-else class="p-5">
        <div class="flex flex-col sm:flex-row justify-center">
            <div class="">
                <img
                    :src="Image('qrcode.jpg')"
                    alt=""
                    class="w-[215px] mx-auto"
                />
            </div>
            <div>
                <select
                    name=""
                    id=""
                    class="w-full h-[36px] mt-4 text-[14px] cursor-pointer border-solid border border-gray-300 rounded-lg outline-none"
                    v-model="form.payment_id"
                >
                    <option v-for="(item, index) in payment">
                        {{ item }}
                    </option>
                </select>
                <div class="mt-3">
                    <textarea
                        v-model="form.remark"
                        name=""
                        id=""
                        placeholder="Write a note here..."
                        class="p-3 text-sm h-[150px] input w-full resize-none cursor-pointer border-solid border border-gray-300 rounded-lg outline-none"
                    ></textarea>
                </div>
            </div>
        </div>
        <div class="fixed mt-4 bottom-5 right-5">
            <button
                @click="updateCheck()"
                class="inline-flex items-center justify-between gap-2 px-3 py-2 text-sm font-medium text-center text-white bg-primary rounded-lg focus:ring-4 focus:outline-none focus:ring-blue-300"
            >
                <p class="font-bold">Check-in</p>
                <img
                    :src="setIcon('check1.svg')"
                    alt=""
                    class="w-[20px] h-[20px]"
                />
            </button>
        </div>
    </div>
</template>
