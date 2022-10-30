class Token {
    getLocalAccessToken() {
        const user = JSON.parse(localStorage.getItem("user"));
        return user?.accessToken;
    }

    updateLocalAccessToken(token) {
        let user = JSON.parse(localStorage.getItem("user"));
        user.accessToken = token;
        user.isLoggedIn = true;
        localStorage.setItem("user", JSON.stringify(user));
    }

    getUser() {
        return JSON.parse(localStorage.getItem("user"));
    }

    getIsLoggedIn() {
        const user = JSON.parse(localStorage.getItem("user"));
        return user?.isLoggedIn;
    }

    setUser(user) {
        localStorage.setItem("user", JSON.stringify(user));
    }

    removeUser() {
        localStorage.removeItem("user");
    }
}

export default new Token();
