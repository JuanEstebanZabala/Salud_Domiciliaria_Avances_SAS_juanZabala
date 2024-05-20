import { http } from '../../services/http.service';

class AuthService {

    constructor() {

    }

    async Register(payload) {
        return await  http.post('api/register', payload)
    }

    async Login(payload) {
        return await http.post('api/login', payload)
    }

    async User() {
        return await http.get('api/user')
    }

    async Logout() {
        return await http.post('api/logout')
    }
}

const authService = new AuthService();
export { authService };
