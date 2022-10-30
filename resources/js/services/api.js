import axios from "axios";

const instance = axios.create({
    baseURL: "http://movie-app.test/api/v1",
    headers: {
        "Content-Type": "application/json",
        "Accept"      : "application/json"
    },
});

export default instance;
