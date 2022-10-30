import React from "react";
import { Routes, Route } from "react-router-dom";
import Login from '../Pages/Auth/Login';
import Dashboard from '../Pages/Dashboard';
import Activities from '../Pages/Activities';
import Register from '../Pages/Auth/Register';
import MyMovies from '../Pages/MyMovies';
import PageNotFound from "../Pages/PageNotFound";
import { ToastContainer } from "react-toastify";
import RequireAuth from "../Middleware/auth";
import Guest from "../Middleware/guest";

export default function App() {
    return (
        <>
            <Routes>
                <Route path="/" index element={
                    // <Guest redirectTo="/dashboard">
                    <Guest>
                        {/*<Login />*/}
                        <Activities />
                    </Guest>
                } />
                <Route path="/register" element={
                    <Guest redirectTo="/dashboard">
                        <Register />
                    </Guest>
                } />
                <Route path="*" element={<PageNotFound />} />
                <Route
                    path="/dashboard"
                    element={
                        <RequireAuth redirectTo="/">
                            <Dashboard />
                        </RequireAuth>
                    }
                />
                <Route
                    path="/my-movies"
                    element={
                        <RequireAuth redirectTo="/">
                            <MyMovies />
                        </RequireAuth>
                    }
                />
            </Routes>

            <ToastContainer
                position="bottom-right"
                autoClose={5000}
                hideProgressBar={false}
                newestOnTop={false}
                closeOnClick
                rtl={false}
                pauseOnFocusLoss
                draggable
                pauseOnHover
                theme="light"
            />
        </>
    );
}
