<template>
    <!-- Botón para crear empleado -->
    <button @click="oncreate = !oncreate" v-if="!oncreate" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-4 my-2 rounded">
        Crear Empleado
    </button>

    <!-- Tabla de empleados -->
    <div class="overflow-x-auto shadow-md rounded" v-if="!oncreate">
        <table class="min-w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <!-- Cabecera de la tabla -->
            <thead class="text-xs text-white uppercase bg-blue-500 dark:bg-gray-700 dark:text-gray-400 rounded">
                <tr>
                    <th scope="col" class="p-4">
                        <div class="flex items-center">
                            <input id="checkbox-all-search" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="checkbox-all-search" class="sr-only">checkbox</label>
                        </div>
                    </th>
                    <th scope="col" class="px-4 py-2">Empleado</th>
                    <th scope="col" class="px-4 py-2">Cargo</th>
                    <th scope="col" class="px-4 py-2">Ubicación</th>
                    <th scope="col" class="px-4 py-2">Tipografía favorita</th>
                    <th scope="col" class="px-4 py-2">Acción</th>
                </tr>
            </thead>
            <!-- Cuerpo de la tabla -->
            <tbody>
                <!-- Fila de empleado -->
                <tr v-for="(empleado, index) in empleados" :key="empleado.id" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <!-- Checkbox -->
                    <td class="w-4 p-4">
                        <div class="flex items-center">
                            <input id="checkbox-table-search-1" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                        </div>
                    </td>
                    <!-- Datos del empleado -->
                    <td scope="row" class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                        <span v-if="formActualizar && idActualizar === index">
                            <!-- Formulario para actualizar -->
                            <input v-model="model.name" type="text" class="form-control" placeholder="nombre">
                            <input v-model="model.email" type="text" class="form-control" placeholder="email">
                        </span>
                        <span v-else class="inline-flex items-center">
                            <img class="w-7 h-7 rounded-full" :src="empleado.avatar" :alt="empleado.name + ' image'">
                            <div class="ps-3">
                                <div class="text-base font-semibold">{{ empleado.name }}</div>
                                <div class="font-normal text-gray-500">{{ empleado.email }}</div>
                            </div>
                        </span>
                    </td>
                    <!-- Cargo -->
                    <td class="px-4 py-2 md:pl-6 pr-1 md:py-4">
                        <span v-if="formActualizar && idActualizar === index">
                            <!-- Formulario para actualizar -->
                            <select v-model="model.role">
                                <option value="" disabled>Seleccione una opción</option>
                                <option value="Developer">Developer</option>
                                <option value="Designer">Designer</option>
                                <option value="Product Manager">Product Manager</option>
                            </select>
                        </span>
                        <div v-else>
                            <span :class="getRoleClass(empleado.role)">
                                {{ empleado.role }}
                            </span>
                        </div>
                    </td>
                    <!-- Ubicación -->
                    <td class="px-4 py-2 md:px-6 md:py-4 text-black">
                        <span v-if="formActualizar && idActualizar === index">
                            <input v-model="model.location" type="text" class="form-control" placeholder="ubicación">
                        </span>
                        <span v-else>
                            {{ empleado.location }}
                        </span>
                    </td>
                    <!-- Tipografía favorita -->
                    <td class="px-4 py-2 md:px-6 md:py-4 text-black">
                        <span v-if="formActualizar && idActualizar === index">
                            <input v-model="model.typography" type="text" class="form-control" placeholder="Tipografía">
                        </span>
                        <span v-else>
                            {{ empleado.typography }}
                        </span>
                    </td>
                    <!-- Acciones -->
                    <td class="px-4 py-2 md:px-6 md:py-4">
                        <span v-if="formActualizar && idActualizar === index">
                            <button @click="guardarActualizacion(empleado.id,index)" class="inline-block hover:text-green-700" title="guardar">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                    <path d="M9.97.97a.75.75 0 0 1 1.06 0l3 3a.75.75 0 0 1-1.06 1.06l-1.72-1.72v3.44h-1.5V3.31L8.03 5.03a.75.75 0 0 1-1.06-1.06l3-3ZM9.75 6.75v6a.75.75 0 0 0 1.5 0v-6h3a3 3 0 0 1 3 3v7.5a3 3 0 0 1-3 3h-7.5a3 3 0 0 1-3-3v-7.5a3 3 0 0 1 3-3h3Z" />
                                    <path d="M7.151 21.75a2.999 2.999 0 0 0 2.599 1.5h7.5a3 3 0 0 0 3-3v-7.5c0-1.11-.603-2.08-1.5-2.599v7.099a4.5 4.5 0 0 1-4.5 4.5H7.151Z" />
                                    </svg>
                            </button>
                        </span>
                        <span v-else>
                            <div class="inline-block">
                            <button @click="verFormActualizar(empleado,index)" class="hover:text-blue-700"  title="editar">
                                 <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                    </svg>
                            </button>
                            <button @click="borrarEmpleado(empleado.id,index)" class="hover:text-red-700" title="eliminar">
                               <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg>
                            </button>
                            </div>
                        </span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <!-- Formulario para crear empleado -->
    <formCrearEmpleado v-if="oncreate"></formCrearEmpleado>
</template>



<script setup >
import { method } from 'lodash';
import { http } from '../../services/http.service';
import { onBeforeMount, ref, reactive  } from "vue";
import { storeToRefs } from "pinia";
import { useEmpleadosStore } from "./empleados.store";
import { useAuthStore } from "../auth/auth.store";
import formCrearEmpleado from "./formCrearEmpleado.vue";
import Swal from "sweetalert2"
const { empleados } = storeToRefs(useEmpleadosStore());
const { Action_get_empleados ,Action_put_empleado,Action_delete_empleado } = useEmpleadosStore();
const { user } = storeToRefs(useAuthStore());
const { Action_User } = useAuthStore();
let oncreate = ref(false);
let formActualizar = ref(false);
let idActualizar = ref(-1);

const model = reactive({
    name: '',
    email: '',
    role: '',
    location: '',
    typography: '',
    avatar: ''
});

onBeforeMount(async () => {
    await Action_User();
    await Action_get_empleados();
});

const verFormActualizar = (empleado,index) => {
    idActualizar.value = index;
    formActualizar.value = true;
    model.name = empleado.name;
    model.email = empleado.email;
    model.role = empleado.role;
    model.location = empleado.location;
    model.typography = empleado.typography;
    model.avatar = empleado.avatar;
};

const borrarEmpleado = (empleado_id,index) => {
    confirmar(empleado_id, index);
};

const guardarActualizacion = async (empleado_id,index) => {
    try {
        const response = await Action_put_empleado(empleado_id, model);
        if (response && response.message.type === 'success') {
            // Actualiza los datos del empleado en el estado local
            if (index !== -1) {
                empleados.value[index] = { ...empleados.value[index], ...model };
            }
             show_alerta('Empleado Editado', 'success');
            formActualizar.value = false;          
        } else {
            // Manejo de errores si la actualización no fue exitosa
            throw new Error(response.message.text || 'Error desconocido al actualizar el empleado.');
        }
    } catch (error) {
        console.error('Error al actualizar el empleado:', error);
        Swal.fire('Error', error.message, 'error');
    }
};

const getRoleClass = (role) => {
    switch (role) {
        case 'Developer':
            return 'bg-purple-300 text-white p-2 rounded-full';
        case 'Designer':
            return 'bg-blue-400 text-white p-2 rounded-full';
        case 'Product Manager':
            return 'bg-green-400 text-white p-1  rounded-full inline-block text-center';
        default:
            return '';
    }
};
 function show_alerta(mensaje,icono,foco=''){
    if (foco!='') {
        document.getElementById(foco).focus();
    }
    Swal.fire({
        title:mensaje,
        icon:icono,
        customClass: {confirmButton: 'btn btn-primary', popup:'animated zoomIn'},
        buttonsStyling:false
    });
}

 function confirmar(id,index){
    const swalWithBootrapButtons= Swal.mixin({
        customClass:{confirmButton: 'btn btn-success me-3', cancelButton:'btn btn-danger'}
        ,buttonsStyling:false
    });
    swalWithBootrapButtons.fire({
        title:'Desea eliminar el empleado?',
        text:'se perderá la información del empleado',
        icon:'question',
        showCancelButton:true,
        confirmButtonText:'Eliminar',
        cancelButtonText:'Cancelar'}).then(async (result)=>{
            if (result.isConfirmed) {
                  await Action_delete_empleado(id);
                empleados.value.splice(index, 1);
                show_alerta('Empleado eliminado', 'success');
            } else {
                show_alerta('operación cancelada', 'info');
            }
        })
}
</script>
