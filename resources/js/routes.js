import Vue from 'vue'
import Router from 'vue-router'
import auth from './services/auth'

//login
import MainAuth from './components/layouts/MainAuth';
import MainBlank from './components/layouts/MainBlank';
import Login from './components/auth/Login';
import Register from './components/auth/Register';
//pages
import Main from './components/layouts/Main';
import Inicio from './components/pages/Inicio';

//admin
import MainAdmin from './components/layouts/MainAdmin';
import InicioAdmin from './components/admin/Inicio';
import Usuarios from './components/admin/Usuarios';
import InformacionDocente from './components/admin/InformacionDocente';


///Gestion
import RequerimientoSIGA from './components/admin/RequerimientoSIGA';
import EnviarCotizacion from './components/admin/EnviarCotizacion';
import RevisarCotizacion from './components/admin/RevisarCotizacion';
import CuadroComparativo from './components/admin/CuadroComparativo';
import Datos from './components/admin/Datos';
import Matricula from './components/admin/Matricula';
import Notas from './components/admin/Notas';
import Asistencia from './components/admin/Asistencia';

Vue.use(Router)

let routes = [
    // {
    //     path: '*', 
    //     redirect: '/inicio',
    // },

    {
        path: '/auth',
        meta: { requiresAuth: true },
        component: MainBlank,
        children: [
            { path: 'register', name: 'Register', component: Register },
        ]
    },

    {
        path: '/',
        component: MainBlank,
        redirect: '/inicio',
        children: [
            { path: 'login', name: 'Login', component: Login },

        ]
    },

    {
        path: '/',
        meta: { requiresAuthAdmin: true },
        component: Main,
        redirect: '/inicio',
        children: [
            { path: 'inicio', name: 'Inicio', component: Inicio },
        ]
    },


    {
        path: '/admin',
        component: MainAdmin,
        meta: { requiresAuthAdmin: true },
        redirect: '/admin/inicio',
        children: [
            { path: 'inicio', name: 'InicioAdmin', component: InicioAdmin },
            { path: 'usuarios', name: 'Usuarios', component: Usuarios },
            // { path: 'mensajes/:usuario_id/:nombre', name: 'Mensajes', component: Mensajes },
            { path: 'requerimientoSIGA', name: 'RequerimientoSIGA', component: RequerimientoSIGA },
            { path: 'enviarCotizacion', name: 'EnviarCotizacion', component: EnviarCotizacion },
            { path: 'revisarCotizacion', name: 'RevisarCotizacion', component: RevisarCotizacion },
            { path: 'CuadroComparativo', name: 'CuadroComparativo', component: CuadroComparativo },
        ]
    },
    
];

const router = new Router({
    mode: 'history', // history is production an validate app_url in .env
    //base: process.env.MIX_APP_URL,
    //base: __dirname,
	routes,
});

router.beforeEach((to, from, next) => {

    if (to.matched.some(m => m.meta.requiresAuthAdmin)) {
        return auth.check().then(response => {
            if (response) {
                return next()
            }
            return next({ path: '/login' })
        })
    }

    return next()
});

export default router;