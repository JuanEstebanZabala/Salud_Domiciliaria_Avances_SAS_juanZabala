<template>
    <div class="container" style="width: 100%">
        <div class="p-0 m-0">
            <div class="container rounded-top p-3 shadow" style="width: 100%; background-color: #0e2146">
                <h3 class="m-0 ml-3">
                    <b style="color: #ffffff !important">Editar tus datos</b>
                </h3>
            </div>
        </div>
        <div class="container rounded-bottom shadow p-3 pt-4 mb-5 bg-body-tertiary"
            style="width: 100%; background-color: #ffffff">
            <div class="container-fluid col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12 align-self-center">
                <form role="form" @submit.prevent="confirm">
                    <div class="row" style="width: 100%; margin: 0 auto">
                        <div class="col-12 col-lg-4 col-md-6 col-sm-6 col-xs-6 align-items-end">
                            <div class="form-floating pb-4 mt-3">
                                <input v-model="model.name" type="text" class="form-control" placeholder="" />
                                <label class="input-control" for="ConNom">Nombre </label>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4 col-md-6 col-sm-6 col-xs-6 align-items-end">
                            <div class="form-floating pb-4 mt-3">
                                <input v-model="model.email" type="text" class="form-control" autocomplete="off" placeholder="" />
                                <label class="input-control" for="ConNom">Email </label>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4 col-md-6 col-sm-6 col-xs-6 align-items-end">
                            <div class="form-floating pb-4 mt-3">
                                <input v-model="model.cell_phone" type="text" placeholder="" class="form-control"  autocomplete="off"
                                    title="" />
                                <label class="input-control" for="ConCod">Celular</label>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4 col-md-6 col-sm-6 col-xs-6 align-items-end">
                            <div class="form-floating pb-4 mt-3">
                                <input v-model="model.location" type="text" placeholder="" class="form-control"  autocomplete="off"
                                    title="" />
                                <label class="input-control" for="ConCod" tittle="ciudad/dirección">Ubicación</label>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4 col-md-6 col-sm-6 col-xs-6 align-items-end">
                            <div class="form-floating pb-4 mt-3">
                                <input v-model="model.password" type="password" placeholder="" class="form-control"  autocomplete="off"
                                    title="" />
                                <label class="input-control" tittle="ciudad/dirección">Contraseña*</label>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4 col-md-6 col-sm-6 col-xs-6 align-items-end">
                            <div class="form-floating pb-4 mt-3">
                                <input v-model="model.password_confirmation" type="password" placeholder="" class="form-control"  autocomplete="off"
                                    title="" />
                                <label class="input-control" 
                                    tittle="ciudad/dirección">Confirmación*</label>
                            </div>

                        </div>
                        <div class="container mb-3 ml-2 p-2">
                            <button type="submit" id="Boton" class="btn btn-primary m-2"
                                style="background-color: #0e2146">
                                Aceptar
                            </button>
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
import { useMenuStore } from "../menu/menu.store";
import { useAuthStore } from "../auth/auth.store";
const { Action_put_user} = useMenuStore();
const { user } = storeToRefs(useAuthStore());
const { Action_User } = useAuthStore();

const model = reactive({
    name: user.value.name,
    email: user.value.email,
    cell_phone: user.value.cell_phone,
    location: user.value.location,
    password: null,
    password_confirmation: null
});

onBeforeMount(async () => {
    await Action_User();
    await Action_get_pacientes();
});

async function confirm() {
    await Action_put_user(user.value.id, model);
}


</script>