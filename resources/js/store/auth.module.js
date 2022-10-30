import { createSlice } from "@reduxjs/toolkit";
import TokenService from "../services/token";

const defaultUser = {
    id: null,
    name: null,
    email: null,
    isLoggedIn: false
}

const user = JSON.parse(localStorage.getItem('user'))
const initialState = user ?
     user  :
    { user: defaultUser };

const authSlice = createSlice({
    name: "auth",
    initialState: initialState,
    reducers: {
        setAuth(state, action) {
            let res = action.payload;
            TokenService.setUser(res.user);
            TokenService.updateLocalAccessToken(res.auth_token);
        },

        logout(state) {
            TokenService.removeUser();
        },
    },
});

export const authActions = authSlice.actions;

export default authSlice;
