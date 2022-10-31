import React from 'react';
import Header from '../Components/Header';

export default function Auth({children}) {
    return (
        <>
            <Header />
            <div className="flex h-screen overflow-hidden">
                <div className="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden">
                    <main>
                        <div className="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-5xl mx-auto">
                            { children }
                        </div>
                    </main>
                </div>
            </div>
        </>
    )
}
