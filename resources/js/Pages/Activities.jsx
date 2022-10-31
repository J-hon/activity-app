import React, {useEffect, useState} from "react";
import ActivityService from "../services/activities";
import UserService from "../services/users";
import Auth from "../Layouts/Auth";
import { useParams } from "react-router-dom";

export default function Activities() {
    const params                        = useParams();
    const [ activities, setActivities ] = useState([]);
    const [ trigger, setTrigger ]       = useState(false);

    useEffect(() => {
        UserService.getActivities(params.id)
            .then(response => {
                setActivities(response.data);
            })
            .catch(err => {
                console.log(err.response.data);
            });
    }, [ trigger ]);

    const classNames = (...classes) => { return classes.filter(Boolean).join(' ') };

    const deleteActivity = id => {
        ActivityService.delete(id)
            .then(response => {
                setTrigger(prevState => !prevState);
            })
            .catch(err => {
                console.log(err.response.data.message);
            });
    }

    return (
        <>
            <Auth>
                <div className="overflow-x-auto px-4 sm:px-6 lg:px-8">
                    <div className="sm:flex sm:items-center">
                        <div className="sm:flex-auto">
                            <h1 className="text-xl font-semibold text-gray-900">Users</h1>
                            <p className="mt-2 text-sm text-gray-700">
                                A list of user's activities
                            </p>
                        </div>
                    </div>

                    <div className="mt-8 flex flex-col">
                        <div className="-my-2 -mx-4 sm:-mx-6 lg:-mx-8">
                            <div className="inline-block min-w-full py-2 align-middle">
                                <div className="shadow-sm ring-1 ring-black ring-opacity-5">
                                    <table className="min-w-full border-separate" style={{ borderSpacing: 0 }}>
                                        <thead className="bg-gray-50">
                                        <tr>
                                            <th
                                                scope="col"
                                                className="sticky top-0 z-10 border-b border-gray-300 bg-gray-50 bg-opacity-75 py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 backdrop-blur backdrop-filter sm:pl-6 lg:pl-8"
                                            >
                                                SN
                                            </th>
                                            <th
                                                scope="col"
                                                className="sticky top-0 z-10 hidden border-b border-gray-300 bg-gray-50 bg-opacity-75 px-3 py-3.5 text-left text-sm font-semibold text-gray-900 backdrop-blur backdrop-filter sm:table-cell"
                                            >
                                                Title
                                            </th>
                                            <th
                                                scope="col"
                                                className="sticky top-0 z-10 hidden border-b border-gray-300 bg-gray-50 bg-opacity-75 px-3 py-3.5 text-left text-sm font-semibold text-gray-900 backdrop-blur backdrop-filter lg:table-cell"
                                            >
                                                Description
                                            </th>

                                            <th
                                                scope="col"
                                                className="sticky top-0 z-10 border-b border-gray-300 bg-gray-50 bg-opacity-75 py-3.5 pr-4 pl-3 backdrop-blur backdrop-filter sm:pr-6 lg:pr-8"
                                            >
                                                <span className="sr-only">Edit</span>
                                            </th>
                                        </tr>
                                        </thead>

                                        <tbody className="bg-white">
                                        { activities.map((activity, activityIdx) => (
                                            <tr key={activity.id}>
                                                <td
                                                    className={classNames(
                                                        activityIdx !== activity.length - 1 ? 'border-b border-gray-200' : '',
                                                        'whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6 lg:pl-8'
                                                    )}
                                                >
                                                    {activity.id}
                                                </td>
                                                <td
                                                    className={classNames(
                                                        activityIdx !== activity.length - 1 ? 'border-b border-gray-200' : '',
                                                        'whitespace-nowrap px-3 py-4 text-sm text-gray-500 hidden sm:table-cell'
                                                    )}
                                                >
                                                    {activity.description}
                                                </td>
                                                <td
                                                    className={classNames(
                                                        activityIdx !== activity.length - 1 ? 'border-b border-gray-200' : '',
                                                        'whitespace-nowrap px-3 py-4 text-sm text-gray-500 hidden lg:table-cell'
                                                    )}
                                                >
                                                    {activity.image}
                                                </td>
                                                <td
                                                    className={classNames(
                                                        activityIdx !== activity.length - 1 ? 'border-b border-gray-200' : '',
                                                        'relative whitespace-nowrap py-4 pr-4 pl-3 text-right text-sm font-medium sm:pr-6 lg:pr-8'
                                                    )}
                                                >
                                                    <button
                                                        onClick={ () => deleteActivity(activity.id) }
                                                        type="button"
                                                        className="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2
                                                    text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2
                                                    focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto"
                                                    >
                                                        Edit
                                                    </button>

                                                    &nbsp;

                                                    <button
                                                        onClick={ () => deleteActivity(activity.id) }
                                                        type="button"
                                                        className="inline-flex items-center justify-center rounded-md border border-transparent bg-slate-900 px-4 py-2
                                                    text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2
                                                    focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto"
                                                    >
                                                        Delete
                                                    </button>
                                                </td>
                                            </tr>
                                        ))}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </Auth>
        </>
    );
};
