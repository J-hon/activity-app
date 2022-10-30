import Login from '../pages/Auth/Login';
import Dashboard from '../pages/Dashboard';
import Register from '../pages/Auth/Register';
import MyMovies from '../pages/MyMovies';
import PageNotFound from '../pages/PageNotFound';

const routes = [
    {
        path: '/',
        exact: true,
        auth: true,
        component: Dashboard,
        fallback: Login,
    },
    {
        path: '/',
        exact: true,
        auth: false,
        component: Login,
    },
    {
        path: '/register',
        exact: true,
        auth: false,
        component: Register,
    },
    {
        path: '',
        exact: false,
        auth: false,
        component: MyMovies,
    },
    {
        path: '',
        exact: false,
        auth: false,
        component: PageNotFound,
    },
];

export default routes;
