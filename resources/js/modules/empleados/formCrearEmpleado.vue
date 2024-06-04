<template>
    <div class="container" style="width: 100%">
        <div class="p-0 m-0">
            <div class="container rounded-top p-3 shadow" style="width: 100%; background-color: #0e2146">
                <h3 class="m-0 ml-3">
                    <b style="color: #ffffff !important">Crear Empleado</b>
                </h3>
            </div>
        </div>
        <div class="container rounded-bottom shadow p-3 pt-4 mb-5 bg-body-tertiary"
            style="width: 100%; background-color: #ffffff">
            <div class="container-fluid col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12 align-self-center">
                <form class="form-inline" @submit.prevent="confirm">
                    <div class="row">                       
                        <div class="form-group col-12 col-xs-12 col-sm-6 col-md-6 col-lg-4 p-1">
                            <label for="fechaCreacion">Nombre*</label>
                            <input type="text" v-model="model.name"  required class="form-control">
                        </div>
                         <div class="form-group col-12  col-xs-12 col-sm-6 col-md-6 col-lg-4 p-1">
                            <label for="fechaCreacion">email*</label>
                            <input type="email" v-model="model.email"  required class="form-control">
                        </div>
                        <div class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-4 p-1">
                            <div class="form-group">
                                <label class="text-left ml-3">Cargo *</label>
                                <select  v-model="model.role" class="form-control" required title="cargo">
                                    <option value="" disabled>selecione una opción</option>
                                    <option value="Developer" >Developer</option>
                                    <option value="Designer" >Designer</option>
                                    <option value="Product Manager" >Product Manager</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-12 col-md-6 p-1">
                            <label for="horaRegistro">Ubicación*</label>
                            <input v-model="model.location" type="text" required class="form-control">
                        </div>
                        <div class="form-group col-12 col-md-6 p-1">
                            <label for="horaRegistro">Tipografía favorita*</label>
                            <input v-model="model.typography" type="text" required class="form-control">
                        </div>
                        <div class="form-group mt-3">
                            <input type="submit" name="submit" class="btn btn-primary mr-2"
                                style="background-color: #0e2146" value="crear">
                            <a class="btn btn-danger" href="/empleados " style="background-color: #8b0000">Regresar</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
<script setup>
import { onBeforeMount, reactive } from "vue";
import { storeToRefs } from "pinia";
import { useEmpleadosStore } from "./empleados.store";
import { useAuthStore } from "../auth/auth.store";
const { empleados } = storeToRefs(useEmpleadosStore());
const { Action_get_empleados ,Action_store_empleado } = useEmpleadosStore();
const { user } = storeToRefs(useAuthStore());
const { Action_User } = useAuthStore();

const model = reactive({
    name: null,
    email: null,
    role: "",
    location: null,
    typography: null,
    avatar:"https://cdn-icons-png.flaticon.com/128/1144/1144760.png"
});

onBeforeMount(async () => {
    await Action_User();    
});

async function confirm() {
    await Action_store_empleado(model)
        .then(() => {
            // Restablecer el modelo después de crear el empleado
            Object.assign(model, {
                name: null,
                email: null,
                role: "",
                location: null,
                typography: null,
                avatar: "https://cdn-icons-png.flaticon.com/128/1144/1144760.png"
            });
        })       
}


</script>