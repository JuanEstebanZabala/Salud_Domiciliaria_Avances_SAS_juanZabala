<template>
    <layout>       
       
    </layout>
     <div class="rounded bg-gray-200 p-3 md:w-9/12 sm:w-full m-4 shadow-xl content-center mx-auto">
            <editar>
            </editar>
            <button id="Boton" class="btn btn-danger m-3 float-right" @click="logout" style="background-color: #8B0000">
            Cerrar sesión
        </button>
        </div>
         
</template>
<script setup>
import layout from '../../components/layout.vue';
import editar from './editar.vue';
import { storeToRefs } from "pinia";
import { useAuthStore } from "../auth/auth.store";
const { user } = storeToRefs(useAuthStore());
const { Action_Logout } = useAuthStore();

async function logout() {
    await Action_Logout();
}
</script>
