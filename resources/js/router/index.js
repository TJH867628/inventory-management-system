import { createRouter, createWebHistory } from 'vue-router';
import Login from '../views/Login.vue';
import NotFound from '../views/Not Found.vue';
import NotAuthorized from '../views/Not Authorized.vue';
import Dashboard from '../views/Dashboard.vue';
const routes = [
    {
        path: '/',
        name: 'root',
        redirect: to => {
            const token = localStorage.getItem('token');
            const user = JSON.parse(localStorage.getItem('user') || '{}');
            
            if (!token) {
                return { name: 'login' };
            }

            // Redirect based on user role
            switch (user.role) {
                case 'Admin':
                    return { name: 'admin-dashboard' };
                case 'Inventory':
                    return { name: 'inventory-dashboard' };
                case 'Sales':
                    return { name: 'sales-dashboard' };
                default:
                    return { name: 'login' };
            }
        }
    },
    { 
        path: '/login',
        name: 'login',
        component: Login,
        beforeEnter: (to, from, next) => {
            const token = localStorage.getItem('token');
            const user = JSON.parse(localStorage.getItem('user') || '{}');
        
            if (token) {
                // Redirect user based on their role
                switch (user.role) {
                    case 'Admin':
                        next({ name: 'admin-dashboard' });
                        break;
                    case 'Inventory':
                        next({ name: 'inventory-dashboard' });
                        break;
                    case 'Sales':
                        next({ name: 'sales-dashboard' });
                        break;
                    default:
                        next({ name: 'login' }); // Fallback if role is missing
                }
            } else {
                next(); // Allow access to login page if not authenticated
            }
        }
    },
    { 
        path: '/admin/dashboard',
        name: 'admin-dashboard',
        component: Dashboard,
        meta: { requiresAuth: true, role: 'Admin' }
    },
    { 
        path: '/inventory/dashboard',
        name: 'inventory-dashboard',
        component: Dashboard,
        meta: { requiresAuth: true, role: 'Inventory' }
    },
    { 
        path: '/sales/dashboard',
        name: 'sales-dashboard',
        component: Dashboard,
        meta: { requiresAuth: true, role: 'Sales' }
    },
    { 
        path: '/not-authorized',
        name: 'not-authorized',
        component: NotAuthorized 
    },
    { 
        path: '/:pathMatch(.*)*',
        name: 'not-found',
        component: NotFound 
    },
    {
        path: '/test',
        name: 'test',
        component: () => import('../components/page-loading-spinner.vue')
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

// Global navigation guard
router.beforeEach((to, from, next) => {
    const token = localStorage.getItem('token');
    const user = JSON.parse(localStorage.getItem('user') || '{}');

    // Check if route requires authentication
    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (!token) {
            next({ name: 'login' });
        } else if (to.meta.role && to.meta.role !== user.role) {
            next({ name: 'not-authorized' });
        } else {
            next();
        }
    } else {
        next();
    }
});

export default router;