import { http } from '../../services/http.service';

class EmpleadosService {

    constructor() {

    }

    async getEmpleado(id) {
        return await  http.get(`api/empleados/${id}`);
    }

    async getEmpleados() {
        return await  http.get('api/empleados');
    }

    async storeEmpleados(payload) {
        console.log("service ", payload);
        return await  http.post('api/empleados', payload);
    }

    async putEmpleado(id, payload) {
        return await http.put(`api/empleados/${id}`, payload);
    }
    async deleteEmpleado(id) {
        return await http.delete(`api/empleados/${id}`);
    }
}

const empleadosService = new EmpleadosService();
export { empleadosService };
