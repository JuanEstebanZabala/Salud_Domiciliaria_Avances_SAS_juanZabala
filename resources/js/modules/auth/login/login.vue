<template>
    <div class="bg-stone-900 bg-opacity-90">
        <img src="aaabstract.png" alt="">
        <div class="h-screen flex items-center justify-center">
            <div class="bg-neutral-400 bg-opacity-30 backdrop-blur-lg px-10 py-10 rounded-md border">
                <form @submit.prevent="confirm">
                    <h2 class="text-3xl text-center mb-5 font-semibold text-blue-500">
                        Login
                    </h2>
                    <div class="flex items-center border-b mb-3">
                        <input type="text" placeholder="Identificación" v-model="model.document_number"
                            class="py-2 outline-none bg-inherit w-64"  required/>
                        <i class="ri-mail-line text-white"></i>
                    </div>
                    <div class="flex items-center border-b mb-3">
                        <input type="password" placeholder="Contraseña" v-model="model.password"
                            class="py-2 outline-none bg-inherit w-64" required/>
                        <i class="ri-lock-line text-white"></i>
                    </div>
                    <div class="flex items-center justify-between text-xs mb-6 ">
                        <div class="flex items-center gap-2   justify-between">
                            <el-radio-group v-model="model.profile_id">
                                <el-radio :value="3" class="text-white">Paciente</el-radio>
                                <el-radio  :value="2" class="text-white">Profesional</el-radio>
                            </el-radio-group>
                        </div>
                    </div>
                    <button
                        class="bg-white hover:bg-gray-400 rounded-md border text-black py-2 text-center mb-5 font-semibold d-grid col-10 mx-auto">
                        Login
                    </button>

                    <div class="text-sm text-center text-white">
                        No estás registrado?
                        <router-link :to="{ path: 'register' }" class="text-blue-500">
                            Registrarte
                        </router-link>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { onBeforeMount, reactive } from "vue";
import { storeToRefs } from "pinia";
import { useRouter } from "vue-router";
import { useAuthStore } from "../auth.store";
const { isAuthenticated } = storeToRefs(useAuthStore());
const { Action_Register, Action_Login, Action_User } = useAuthStore();

const props = defineProps({
    title: String,
    action: String,
    message: String,
    option: String,
    redirect: String,
});

const router = useRouter();

const model = reactive({
    document_number: "",
    password: "",
    profile_id: null

});



onBeforeMount(() => {
    console.log(isAuthenticated.value);
    if (isAuthenticated.value === true) {
        console.log("Authentication");
    }
});

function redirect(ruta) {
    router.push(ruta);
}

async function confirm() {
    if (
        model.document_number !== null &&
        model.document_number !== "" &&
        model.password !== null &&
        model.password !== "" &&
        model.profile_id !== null &&
        model.profile_id !== ""
    ) {
        await Action_Login(model);
        model.document_number = "";
        model.password = "";
        model.profile_id =null;
    } else {
        alert("Ingrese datos validos");
    }
}

</script>
