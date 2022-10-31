import React from "react";

export default function Add(props){
    const { addToMovieList, id } = props;

    const handleClick = (e) => {
        addToMovieList(id);
    }

    return (
        <>
            <button onClick={ handleClick } className="relative flex items-center justify-center rounded-md border border-transparent bg-gray-100 py-2 px-8 text-sm font-medium text-gray-900 hover:bg-gray-200">
                Add to list
            </button>
        </>
    );
};
