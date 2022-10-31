const options = () => {
    return {
        edit: false,
        view: ''
    }
}


const columns = () => {
    return [
        {
            label: 'id',
            type: 'number',
            column: 'id'
        },
        {
            label: 'Name',
            type: 'text',
            column: 'name'
        },
        {
            label: 'Actions',
            type: 'text',
            column: ''
        }
    ]
}

export { options, columns }
