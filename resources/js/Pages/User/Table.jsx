import React, { useState } from 'react';
import { Link } from 'react-router-dom';


export default function Table(props) {
    const { data, columns, options, filters }   = props;
    const [actionModalOpen, setActionModalOpen] = useState(false);
    const [localColumns, setLocalColumns]       = useState(columns);

    console.log(data);

    const Columns = () => {
        return (
            localColumns?.length &&
            (
                localColumns?.map((column, index) => (
                    <th key={index} scope="col" className='pl-6 py-3.5 pr-3 text-left text-sm font-bold'>
                        <a href="#" className="group inline-flex">
                            { column?.label }
                        </a>
                    </th>
                )
            ))
        )
    }

    // Update condition for presentation purpose
    const Component = ({ item, column, index }) => {
        const value = item[column?.column]

        console.log('hello')

        if (column?.type === 'action' && value) {
            return (
                <div className="whitespace-nowrap py-4 pl-3 pr-2  pl-0 text-right text-sm font-medium sm:pr-2">
                    { options.view && (
                        <Link
                            href={ route(options?.view, value) }
                            className="text-secondary-600 hover:text-secondary-900">
                            View
                        </Link>
                    ) }

                    {!options.view && (
                        <Link
                            href="#"
                            className="text-secondary-600 hover:text-secondary-900"
                        >
                            No action
                        </Link>
                    )}
                </div>
            )
        }

        if (column?.type === 'number') {
            return value
        }

        return value || '-'
    }

    const Rows = ({ data }) => {
        return (
            localColumns.length &&
            localColumns.map(
                (column, index) => (
                        <td
                        >
                            {data[column?.column]}
                        </td>
                    )
            )
        )
    }

    return (
        <div className="relative">
            <div className="col-span-full rounded-lg border border-slate-200 bg-white shadow-lg">
                <div>
                    {/* Table */}
                    <div className="overflow-x-auto">
                        <table className="w-full table-auto">
                            {/* Table header */}
                            <thead className="rounded-sm bg-slate-50 text-xs text-slate-400">
                                <tr>
                                    <Columns />
                                </tr>
                            </thead>
                            {/* Table body */}
                            <tbody className="divide-y divide-slate-100 text-sm">
                            {data?.data?.length > 0 ? (
                                data?.data?.map((d) => (
                                    <tr
                                        key={d.id}
                                        className='bg-gray-50'
                                    >
                                        <Rows data={d} />
                                    </tr>
                                ))
                            ) :  (
                                <tr>
                                    <td className="p-3 py-8 flex justify-center items-center" colSpan="8">
                                        <span>No data available</span>
                                    </td>
                                </tr>)}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    )
}
