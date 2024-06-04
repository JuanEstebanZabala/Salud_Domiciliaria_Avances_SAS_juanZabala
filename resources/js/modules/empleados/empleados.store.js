import { defineStore } from 'pinia';
import { empleadosService } from './empleados.service'
import { useRouter } from "vue-router";

export const useEmpleadosStore = defineStore({
	id: 'empleados',
	state: () => ({
		empleados: [],        
		errors: [],
        router: useRouter(),
	}),
    getters:{
        getEmpleados: (state) => state.empleados       
    },
	actions: {
		async Action_get_empleados() {
			const data = await empleadosService.getEmpleados();
			
            if(data?.data?.data?.empleados) this.empleados = data.data.data.empleados;			
		},
        async Action_get_empleado(id) {
			const data = await empleadosService.getEmpleado(id);
            if(data?.data?.data?.empleados) this.empleados = data.data.data.empleados;
		},
        async Action_store_empleado(payload = {}) {
			console.log("store ",payload);
			const data = await empleadosService.storeEmpleados(payload);
			console.log("data.data.data.empleados ", data);
            if(data?.data?.data?.empleados) this.empleados = data.data.data.empleados;
		},
        async Action_put_empleado(id, payload = {}) {
			try {
				const response = await empleadosService.putEmpleado(id, payload);
				return response.data;
			} catch (error) {
				console.error('Error al actualizar empleado:', error);
				return { success: false, error: error.response ? error.response.data.message.text : 'Error desconocido' };
			}
		},
		async Action_delete_empleado(id) {
			const data = await empleadosService.deleteEmpleado(id);
            if(data?.data?.data?.empleados) this.empleados = data.data.data.empleados;
		}
		
	},
    persist: false

});