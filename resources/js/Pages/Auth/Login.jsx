import React, { useState } from "react";
import Guest from "../../Layouts/Guest";
import { Link, useNavigate } from "react-router-dom";
import AuthService from "../../services/authService";
import { useDispatch } from "react-redux";
import { authActions } from "../../store/auth.module";
import { toast } from "react-toastify";

export default function Login() {
    const dispatch = useDispatch();
    const navigate = useNavigate();

    const [ data, setData ] = useState({
        email: "",
        password: ""
    });

    const onHandleChange = e => {
        setData({ ...data, [ e.target.name ] : e.target.value });
    };

    const submit = e => {
        e.preventDefault();

        AuthService.login(data)
            .then(response => {
                dispatch(authActions.setAuth(response.data));
                navigate('/dashboard');
            })
            .catch(err => {
                toast.error(err.response.data.message, {
                    position: "top-right",
                    autoClose: 5000,
                    hideProgressBar: false,
                    closeOnClick: true,
                    pauseOnHover: true,
                    draggable: true,
                    progress: undefined,
                    theme: "light"
                });
            });
    }

    return (
        <Guest>
            <div className="max-w-sm mx-auto px-4 py-8">
                <h1 className="text-3xl text-slate-800 font-bold mb-6">Login</h1>

                <form onSubmit={ submit }>
                    <div className="space-y-4">
                        <div>
                            <label htmlFor="email" className="block text-sm font-medium mb-1">
                                Email
                            </label>
                            <input onChange={ onHandleChange } type="email" name="email" className="pl-3 h-12 block w-full max-w-lg rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"/>
                        </div>

                        <div>
                            <label htmlFor="password" className="block text-sm font-medium mb-1">
                                Password
                            </label>
                            <input onChange={ onHandleChange } type="password" name="password" className="pl-3 h-12 block w-full max-w-lg rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"/>
                        </div>
                    </div>

                    <div className="flex items-center justify-between mt-6">
                        <button className="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest transition ease-in-out duration-150 btn bg-indigo-500 active:bg-indigo-900 hover:bg-indigo-600 text-white">
                            Sign In
                        </button>

                        <Link to="/register" className="text-sm text-danger">I don't have an account,
                            <span className="underline">Register</span>
                        </Link>
                    </div>
                </form>
            </div>
        </Guest>
    );
}
