import api from "./api";

const API_URL = 'http://activity-app.test/api/v1/user';

class Users {
    get() {
        return api
            .get(`${API_URL}`)
            .then((response) => {
                return response.data;
            });
    }

    getActivities(user_id) {
        return api
            .get(`${API_URL}/${user_id}/activities`)
            .then((response) => {
                return response.data;
            });
    }
}

export default new Users();
