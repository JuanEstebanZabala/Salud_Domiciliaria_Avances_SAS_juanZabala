import { http } from '../../services/http.service';

class MenuService {

    constructor() {

    }

    async getHistorias(profile, id) {
        return await  http.get(`api/historia/${profile}/${id}`);
    }

    async getPacientes() {
        return await  http.get('api/pacientes');
    }

    async storeHistoria(payload) {
        return await  http.post('api/historia', payload);
    }

    async putUser(id, payload) {
        return await http.put(`api/users/${id}`, payload);
    }
}

const menuService = new MenuService();
export { menuService };
