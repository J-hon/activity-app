import api from "./api";
import TokenService from "./token";

const API_URL = 'http://movie-app.test/api/v1';

class Auth {
    login({ email, password }) {
        return api
            .post(`${API_URL}/auth/login`, {
                email,
                password
            })
            .then((response) => {
                return response.data;
            });
    }

    register({ name, email, password, password_confirmation }) {
        return api
            .post(`${API_URL}/auth/signup`, {
                name,
                email,
                password,
                password_confirmation
            })
            .then((response) => {
                return response.data;
            });
    }

    logout() {
        return api
            .post(`${API_URL}/auth/logout`, {})
            .then((response) => {
                if (response.data.status) {
                    TokenService.removeUser();
                }

                return response.data;
            });

    }
}

export default new Auth();
