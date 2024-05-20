import { defineStore } from 'pinia';
import { authService } from './auth.service'
import { useRouter } from "vue-router";

export const useAuthStore = defineStore({
	id: 'auth',
	state: () => ({
		user: {},
        isAuthenticated: false,
		errors: [],
        router: useRouter(),
	}),
    getters:{
        getUser: (state) => state.user,
        getIsAuthenticated:(state) => state.isAuthenticated
    },
	actions: {
		async Action_Login(payload) {
			const data = await authService.Login(payload);
            if(data?.data?.data?.isAuthenticated) this.router.push({ name: "menu" });
		},
        async Action_Register(payload) {
			const data = await authService.Register(payload);
            await this.router.push({ name: "login" });
		},
        async Action_Logout() {
			await authService.Logout();
			this.Action_User();
            this.router.push({ name: "login" });
		},
        async Action_User() {
			const data = await authService.User();
            if(data?.data?.data?.isAuthenticated){
                this.isAuthenticated = data.data.data.isAuthenticated;
                this.user = data.data.data.user;
            }else {
                this.isAuthenticated = false;
                this.user = {};
            }
		}
	},
    persist:true

});
