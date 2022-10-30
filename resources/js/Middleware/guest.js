import React from "react";
import TokenService from "../services/token";
import { Navigate } from "react-router-dom";

export default function Guest({ children, redirectTo }) {
    let isAuthenticated = TokenService.getIsLoggedIn();
    return !isAuthenticated ? children : <Navigate to={ redirectTo } />;
}
