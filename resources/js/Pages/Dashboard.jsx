import React, { useEffect, useState } from "react";
import Calendar from 'react-calendar';
import 'react-calendar/dist/Calendar.css';
import Modal from "../Components/Modal";
import UserService from "../services/users";
import ActivityService from "../services/activities";
import { toast } from "react-toastify";
import { Link } from "react-router-dom";
import Auth from "../Layouts/Auth";

export default function Dashboard() {
    const [value, onChange]           = useState(new Date());
    const [globalValue, onSetGlobal]  = useState(new Date());
    const [modalOpen, setModalOpen]   = useState(false);
    const [users, setUsers]           = useState([]);
    const [activities, setActivities] = useState([]);
    const [ trigger, setTrigger ]     = useState(false);

    const [data, setData] = useState({
        title: '',
        description: '',
        image: 'new file.jpg',
        due_date: value,
        is_global: true,
        user_id: null
    });

    useEffect(() => {
        UserService.get()
            .then(response => {
                setUsers(response.data.users);
            })
            .catch(err => {
                console.log(err.response.data);
            });

        ActivityService.get()
            .then(response => {
                setActivities(response.data);
            })
            .catch(err => {
                console.log(err.response.data);
            });
    }, [trigger]);

    const onHandleChange = e => {
        setData({...data, [e.target.name] : e.target.value });
    };

    const changeGlobal = value => {
        onSetGlobal(value);
    };

    const handleClick = value => {
        onChange(value);
        setModalOpen(!modalOpen);
        setData({...data, is_global : true, due_date: formatDate(value) });
    };

    const handleModal = (user_id) => {
        setModalOpen(!modalOpen);
        setData({...data, is_global : false, user_id : user_id, due_date: formatDate(value) });
    };

    const submit = e => {
        e.preventDefault();

        ActivityService.add(data)
            .then(response => {
                toast.success(response.message, {
                    position: "bottom-right",
                    autoClose: 3000,
                    hideProgressBar: false,
                    closeOnClick: true,
                    pauseOnHover: true,
                    draggable: true,
                    progress: undefined,
                    theme: "light",
                });
            })
            .catch(err => {
                toast.error(err.response.data.message, {
                    position: "bottom-right",
                    autoClose: 3000,
                    hideProgressBar: false,
                    closeOnClick: true,
                    pauseOnHover: true,
                    draggable: true,
                    progress: undefined,
                    theme: "light",
                });
            });

        setModalOpen(!modalOpen);
    }

    const edit = id => {
        ActivityService.update(id, data)
            .then(response => {
                setTrigger(prevState => !prevState);
            })
            .catch(err => {
                console.log(err.response.data.message);
            });
    }

    const formatDate = (date) => {
        let d = new Date(date),
            month = '' + (d.getMonth() + 1),
            day   = '' + d.getDate(),
            year  = d.getFullYear();

        if (month.length < 2)
            month = '0' + month;

        if (day.length < 2)
            day = '0' + day;

        return [year, month, day].join('-');
    }

    return (
        <>
            <Auth>
                <div className="bg-white">
                    <Modal id={Math.random()} modalOpen={modalOpen} setModalOpen={setModalOpen} title={`Create Activity`}>
                        <div className="max-w-sm px-10 py-8">
                            <form onSubmit={submit}>
                                <div className="space-y-4">
                                    <div>
                                        <label htmlFor="name" className="block text-sm font-medium mb-1">
                                            Title
                                        </label>
                                        <input onChange={onHandleChange}
                                               name="title"
                                               type="text"
                                               className="pl-3 h-12 block w-full max-w-lg rounded-md border border-gray-300
                                               shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                        />
                                    </div>

                                    <div>
                                        <label htmlFor="about" className="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                            Description
                                        </label>

                                        <div className="mt-1 sm:col-span-2 sm:mt-0">
                                            <textarea
                                                id="description"
                                                onChange={onHandleChange}
                                                name="description"
                                                rows={3}
                                                className="block w-full pl-3 max-w-lg rounded-md border border-gray-300 shadow-sm
                                                focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                            />
                                            <p className="mt-2 text-sm text-gray-500">Describe this activity.</p>
                                        </div>
                                    </div>
                                </div>

                                { !data.is_global &&
                                    (<div>
                                        <Calendar onChange={changeGlobal} value={globalValue} />
                                    </div>)
                                }

                                <div className="flex items-center justify-between mt-6">
                                    <button
                                        className="inline-flex items-center px-4 py-2 border border-transparent rounded-md
                                        font-semibold text-xs uppercase tracking-widest transition ease-in-out duration-150
                                        btn bg-indigo-500 active:bg-indigo-900 hover:bg-indigo-600 text-white">
                                        Submit
                                    </button>
                                </div>
                            </form>
                        </div>
                    </Modal>

                    <Calendar
                        onChange={handleClick}
                        value={value}
                    />

                    <div className="mx-auto max-w-2xl py-16 px-4 sm:py-24 sm:px-6 lg:max-w-7xl lg:px-8">
                        <h2 className="text-xl font-bold text-gray-900">Users</h2>
                        <table className="min-w-full divide-y divide-gray-300">
                            <thead className="bg-gray-50">
                                <tr>
                                    <th scope="col" className="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                                        S/N
                                    </th>
                                    <th scope="col" className="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                        Name
                                    </th>
                                    <th scope="col" className="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                        &nbsp;
                                    </th>
                                </tr>
                            </thead>

                            <tbody className="divide-y divide-gray-200 bg-white">
                                {users.map((person) => (
                                    <tr key={person.id}>
                                        <td className="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                            {person.id}
                                        </td>
                                        <td className="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                            <Link to={"/activities/" + person.id}>
                                                <ul>{person.name}</ul>
                                            </Link>
                                        </td>
                                        <td className="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                            <button onClick={ () => handleModal(person.id) } className="text-indigo-600 hover:text-indigo-900">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                     fill="currentColor" className="bi bi-calendar-fill"
                                                     viewBox="0 0 16 16">
                                                    <path
                                                        d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0
                                                        1-2-2V5h16V4H0V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5z" />
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>

                    <div className="overflow-x-auto mx-auto max-w-2xl py-16 px-4 sm:py-24 sm:px-6 lg:max-w-7xl lg:px-8">
                        <h2 className="text-xl font-bold text-gray-900">All Activities</h2>
                        <table className="min-w-full divide-y divide-gray-300">
                            <thead className="bg-gray-50">
                                <tr>
                                    <th scope="col" className="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                                        S/N
                                    </th>
                                    <th scope="col" className="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                        Title
                                    </th>
                                    <th scope="col" className="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                        Description
                                    </th>
                                    <th scope="col" className="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                        Image
                                    </th>
                                    <th scope="col" className="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                        &nbsp;
                                    </th>
                                </tr>
                            </thead>

                            <tbody className="divide-y divide-gray-200 bg-white">
                                {activities.map((activity) => (
                                    <tr key={activity.id}>
                                        <td className="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                            {activity.id}
                                        </td>
                                        <td className="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                            {activity.title}
                                        </td>
                                        <td className="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                            {activity.description}
                                        </td>
                                        <td className="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                            {activity.image}
                                        </td>
                                        <td className="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                            <button onClick={ () => edit(activity.id) } className="text-indigo-600 hover:text-indigo-900">
                                                Edit
                                            </button>
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>
                </div>
            </Auth>
        </>
    );
};
