import { defineStore } from 'pinia';
import { menuService } from './menu.service'
import { useRouter } from "vue-router";

export const useMenuStore = defineStore({
	id: 'menu',
	state: () => ({
		historias: [],
        pacientes: [],
		errors: [],
        router: useRouter(),
	}),
    getters:{
        getHistorias: (state) => state.historias,
        getPacientes: (state) => state.pacientes
    },
	actions: {
		async Action_get_historias(profile, id) {
			const data = await menuService.getHistorias(profile.toLowerCase(), id);
            if(data?.data?.data?.historias) this.historias = data.data.data.historias;
		},
        async Action_get_pacientes() {
			const data = await menuService.getPacientes();
            if(data?.data?.data?.pacientes) this.pacientes = data.data.data.pacientes;
		},
        async Action_store_historia(payload = {}) {
			const data = await menuService.storeHistoria(payload);
            if(data?.data?.data?.pacientes) this.pacientes = data.data.data.pacientes;
		},
        async Action_put_user(id, payload = {}) {
			await menuService.putUser(id, payload);
		}
	},
    persist: false

});
