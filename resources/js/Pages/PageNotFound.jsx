import React from "react";
import { Link } from "react-router-dom";

export default function PageNotFound() {
    return (
        <>
            <div className="min-h-full bg-white px-4 py-16 sm:px-6 sm:py-24 md:grid md:place-items-center lg:px-8">
                <div className="mx-auto max-w-max">
                    <main className="sm:flex">
                        <div className="py-16">
                            <div className="text-center">
                                <p className="text-base font-semibold text-indigo-600">404</p>
                                <h1 className="mt-2 text-4xl font-bold tracking-tight text-gray-900 sm:text-5xl">Page not found.</h1>
                                <p className="mt-2 text-base text-gray-500">Sorry, we couldn’t find the page you’re looking for.</p>
                                <div className="mt-6">
                                    <Link to="/dashboard" className="text-base font-medium text-indigo-600 hover:text-indigo-500">
                                        Go back home
                                        <span aria-hidden="true"> &rarr;</span>
                                    </Link>
                                </div>
                            </div>
                        </div>
                    </main>
                </div>
            </div>
        </>
    );
};
