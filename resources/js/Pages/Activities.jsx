import React, { useState } from "react";
import Guest from '../Layouts/Guest';
import Calendar from 'react-calendar';
import 'react-calendar/dist/Calendar.css';
import Modal from "../Components/Modal";

export default function Activities() {
    const [value, onChange]         = useState(new Date());
    const [modalOpen, setModalOpen] = useState(false);

    const [data, setData] = useState({
        title: "",
        description: "",
        due_date: value
    });

    const onHandleChange = e => {
        setData({...data, [e.target.name] : e.target.value });
    };

    const openModal = e => {
        setModalOpen(true);
        console.log(value);
    };

    const submit = e => {
        e.preventDefault();
    }

    const formatDate = (date) => {
        let d = new Date(date),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();

        if (month.length < 2)
            month = '0' + month;

        if (day.length < 2)
            day = '0' + day;

        return [year, month, day].join('-');
    }

    return (
        <>
            <Guest>
                <div className="bg-white">
                    <Modal id={Math.random()} modalOpen={modalOpen} setModalOpen={setModalOpen} title={`Create Activity`}>
                        <div className="max-w-sm mx-auto px-4 py-8">
                            <h1 className="text-3xl text-slate-800 font-bold mb-6">Create</h1>
                            <form onSubmit={submit}>
                                <div className="space-y-4">
                                    <div>
                                        <label htmlFor="name" className="block text-sm font-medium mb-1">
                                            Name
                                        </label>
                                        <input onChange={onHandleChange} name="title" type="text" className="pl-3 h-12 block w-full max-w-lg rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"/>
                                    </div>

                                    <div>
                                        <label htmlFor="password" className="block text-sm font-medium mb-1">
                                            Password
                                        </label>
                                        <textarea onChange={onHandleChange} name="description" id="description" cols="30" rows="10"></textarea>
                                    </div>
                                </div>

                                <div className="flex items-center justify-between mt-6">
                                    <button className="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest transition ease-in-out duration-150 btn bg-indigo-500 active:bg-indigo-900 hover:bg-indigo-600 text-white">
                                        Submit
                                    </button>
                                </div>
                            </form>
                        </div>
                    </Modal>

                    <button onClick={openModal}>
                        Open Modal
                    </button>

                    <Calendar
                        onChange={onChange}
                        value={value}
                    />

                    <div className="mx-auto max-w-2xl py-16 px-4 sm:py-24 sm:px-6 lg:max-w-7xl lg:px-8">
                        <h2 className="text-xl font-bold text-gray-900">Users</h2>
                    </div>
                </div>
            </Guest>
        </>
    );
};
