import api from "./api";

const API_URL = 'http://movie-app.test/api/v1';

class Movies {
    get() {
        return api
            .get(`${API_URL}/movies`)
            .then((response) => {
                return response.data;
            });
    }

    getMyList() {
        return api
            .get(`${API_URL}/user/movies`)
            .then((response) => {
                return response.data;
            });
    }

    add(id) {
        return api
            .post(`${API_URL}/user/movies/add`, {
                movie_id: id
            }).then((response) => {
                return response.data;
            });
    }

    remove(id) {
        return api
            .delete(`${API_URL}/user/movies/remove/${id}`)
            .then((response) => {
                return response.data;
            });
    }
}

export default new Movies();
