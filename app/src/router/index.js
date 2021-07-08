import { createRouter, createWebHistory } from "vue-router";
import Home from "../views/Home.vue";

const routes = [{
        path: "/",
        name: "Home",
        component: Home,
    },
    {
        path: "/about",
        name: "About",

        // route level code-splitting
        // this generates a separate chunk (about.[hash].js) for this route
        // which is lazy-loaded when the route is visited.
        component: () =>
            import ( /* webpackChunkName: "about" */ "../views/About.vue"),
    },
    {
        path: "/Booking",
        name: "Booking",
        beforeEnter: (to, from, next) => {
            if (sessionStorage.getItem("userId") === null) {
                next({
                    path: "/sign",
                });
            } else {
                next();
            }
        },
        // route level code-splitting
        // this generates a separate chunk (about.[hash].js) for this route
        // which is lazy-loaded when the route is visited.
        component: () =>
            import ( /* webpackChunkName: "Booking" */ "../views/Booking.vue"),
    },
    {
        path: "/Dashboard",
        name: "Dashboard",
        beforeEnter: (to, from, next) => {
            if (sessionStorage.getItem("userId") === null) {
                next({
                    path: "/sign",
                });
            } else {
                next();
            }
        },
        // route level code-splitting
        // this generates a separate chunk (about.[hash].js) for this route
        // which is lazy-loaded when the route is visited.
        component: () =>
            import ( /* webpackChunkName: "Dashboard" */ "../views/Dashboard.vue"),
    },
    {
        path: "/Sign",
        name: "Sign",
        // route level code-splitting
        // this generates a separate chunk (about.[hash].js) for this route
        // which is lazy-loaded when the route is visited.
        component: () =>
            import ( /* webpackChunkName: "Dashboard" */ "../views/Sign.vue"),
    },
];

const router = createRouter({
    history: createWebHistory(process.env.BASE_URL),
    routes,
});

export default router;