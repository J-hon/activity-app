import React, { useState } from "react";
import Guest from "../../Layouts/Guest";
import { Link, useNavigate } from "react-router-dom";
import {useDispatch} from "react-redux";
import AuthService from "../../services/authService";
import { authActions } from "../../store/auth.module";
import { toast } from "react-toastify";

export default function Register() {

    const dispatch = useDispatch();
    const navigate = useNavigate();

    const [data, setData] = useState({
        name: "",
        email: "",
        password: "",
        password_confirmation: ""
    });

    const onHandleChange = e => {
        setData({...data, [e.target.name] : e.target.value });
    };

    const submit = e => {
        e.preventDefault();

        AuthService.register(data)
            .then(response => {
                dispatch(authActions.setAuth(response.data));
                navigate('/dashboard');
            })
            .catch(err => {
                toast.error(err.response.data.message, {
                    position: "bottom-right",
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
                <h1 className="text-3xl text-slate-800 font-bold mb-6">Registration</h1>
                <form onSubmit={submit}>
                    <div className="space-y-4">
                        <div>
                            <label htmlFor="name" className="block text-sm font-medium mb-1">
                                Name
                            </label>
                            <input onChange={ onHandleChange } name="name" type="text" className="pl-3 h-12 block w-full max-w-lg rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"/>
                        </div>

                        <div>
                            <label htmlFor="email" className="block text-sm font-medium mb-1">
                                Email
                            </label>
                            <input onChange={ onHandleChange } name="email" type="email" className="pl-3 h-12 block w-full max-w-lg rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"/>
                        </div>

                        <div>
                            <label htmlFor="password" className="block text-sm font-medium mb-1">
                                Password
                            </label>
                            <input onChange={ onHandleChange } name="password" type="password" className="pl-3 h-12 block w-full max-w-lg rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"/>
                        </div>

                        <div>
                            <label htmlFor="password_confirmation" className="block text-sm font-medium mb-1">
                                Password Confirmation
                            </label>
                            <input onChange={ onHandleChange } name="password_confirmation" type="password" className="pl-3 h-12 block w-full max-w-lg rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"/>
                        </div>
                    </div>

                    <div className="flex items-center justify-between mt-6">
                        <button className="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest transition ease-in-out duration-150 btn bg-indigo-500 active:bg-indigo-900 hover:bg-indigo-600 text-white">
                            Sign Up
                        </button>
                        <Link to="/" className="text-sm text-danger">Already have an account? <span className="underline">Login</span></Link>
                    </div>
                </form>
            </div>
        </Guest>
    );
}
