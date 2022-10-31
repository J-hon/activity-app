import React from "react";
import { Routes, Route } from "react-router-dom";
import Login from '../Pages/Auth/Login';
import Dashboard from '../Pages/Dashboard';
import Register from '../Pages/Auth/Register';
import Activities from '../Pages/Activities';
import PageNotFound from "../Pages/PageNotFound";
import { ToastContainer } from "react-toastify";
import RequireAuth from "../Middleware/auth";
import Guest from "../Middleware/guest";

export default function App() {
    return (
        <>
            <Routes>
                <Route path="/" index element={
                    <Guest redirectTo="/dashboard">
                        <Login />
                        <Dashboard />
                    </Guest>
                } />
                <Route
                    path="/register"
                    element={
                        <Guest redirectTo="/dashboard">
                            <Register />
                        </Guest>
                    }
                />
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
                    path="/activities/:id"
                    element={
                        <RequireAuth redirectTo="/">
                            <Activities />
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
