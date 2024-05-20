<template>
    <div class="container" style="width: 100%">
        <div class="p-0 m-0">
            <div class="container rounded-top p-3 shadow" style="width: 100%; background-color: #0e2146">
                <h3 class="m-0 ml-3">
                    <b style="color: #ffffff !important">Crear historia</b>
                </h3>
            </div>
        </div>
        <div class="container rounded-bottom shadow p-3 pt-4 mb-5 bg-body-tertiary"
            style="width: 100%; background-color: #ffffff">
            <div class="container-fluid col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12 align-self-center">
                <form class="form-inline" @submit.prevent="confirm">
                    <div class="row">
                        <div class="col-12 col-lg-4 col-md-6 col-sm-6 col-xs-6 mt-lg-1 align-items-end">
                            <div class="form-group">
                                <label class="text-left ml-3">Paciente *</label>
                                <select type="" v-model="model.id_paciente" class="form-control" required
                                    title="paciente">
                                    <option disabled value="">selecionar un paciente</option>

                                    <option v-for="(paciente, i) in pacientes" :value="paciente.id" :key="i">
                                        {{ paciente.name }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-12">
                            <label for="fechaRegistro">Información*</label>
                            <textarea v-model="model.informacion_relevante" type="text" max="600" required
                                title="Información relevante del paciente" class="form-control"></textarea>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label for="fechaCreacion">Fecha registro*</label>
                            <input type="date" v-model="model.fecha" max="{{hoy}}" required class="form-control">
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label for="horaRegistro">Hora registro*</label>
                            <input v-model="model.hora" type="time" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="fechaRegistro">Antecedentes</label>
                            <input v-model="model.antecedentes" type="text" max="600" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="registro">Evaluación</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="tematica">concepto</label>
                            <input v-model="model.concepto" type="text" class="form-control">
                        </div>

                        <div class="form-group mt-3">
                            <input type="submit" name="submit" class="btn btn-primary mr-2"
                                style="background-color: #0e2146" value="crear">
                            <a class="btn btn-danger" href="index.php" style="background-color: #8b0000">Regresar </a>
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
const { pacientes } = storeToRefs(useMenuStore());
const { Action_get_pacientes, Action_store_historia } = useMenuStore();
const { user } = storeToRefs(useAuthStore());
const { Action_User } = useAuthStore();

const model = reactive({
    id_profesional: user.value.id,
    informacion_relevante: null,
    hora: null,
    fecha: null,
    consecutivo: null,
    estado: null,
    antecedentes: null,
    evaluacion: null,
    concepto: null,
    recomendaciones: null,
    id_paciente: null,
    estado: 'pendiente'
});

onBeforeMount(async () => {
    await Action_User();
    await Action_get_pacientes();
});

async function confirm() {
    await Action_store_historia(model);
}


</script>
