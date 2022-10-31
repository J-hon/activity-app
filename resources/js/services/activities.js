import api from "./api";

const API_URL = 'http://activity-app.test/api/v1';

class Activities {
    add({ title, description, image, due_date, is_global, user_id }) {
        return api
            .post(`${API_URL}/activity`, {
                title,
                description,
                image,
                due_date,
                is_global,
                user_id
            })
            .then((response) => {
                return response.data;
            });
    }

    update({ id, title, description, image }) {
        return api
            .put(`${API_URL}/activity/${id}`, {
                title,
                description,
                image
            })
            .then((response) => {
                return response.data;
            });
    }

    get() {
        return api
            .get(`${API_URL}/activity`)
            .then((response) => {
                return response.data;
            });
    }

    delete(id) {
        return api
            .delete(`${API_URL}/activity/${id}`)
            .then((response) => {
                return response.data;
            });
    }
}

export default new Activities();
