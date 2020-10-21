import * as Component from './components';

export default [
    ...applyRules(
        ['guest'],
        [
            {
                path: '',
                component: Component.LayoutDefaultWrapper,
                redirect: {path: '/login'},
                children: [
                    {
                        path: '/login',
                        component: Component.LayoutLogin,
                        children: [{path: '', name: 'login', component: Component.Login}],
                    },
                    {
                        path: '/cadastrar',
                        component: Component.LayoutLogin,
                        children: [{path: '', name: 'cadastrar', component: Component.Cadastrar}],
                    },
                    {
                        path: '/reset-password',
                        component: Component.LayoutLogin,
                        children: [{path: '', name: 'resetar', component: Component.Resetar}],
                    },
                    {
                        path: '/password/reset/:token', component: Component.LayoutLogin, children:
                            [
                                {path: '', name: 'password-reset', component: Component.PasswordReset}
                            ]
                    },
                ],
            },
        ]
    ),

    ...applyRules(
        ['auth'],
        [
            {
                path: '',
                component: Component.LayoutDefault,
                children: [
                    {path: 'home', name: 'home', component: Component.Home},
                ],
            },
        ]
    ),
    {path: '*', component: Component.NotFound},
];

function applyRules(rules, routes) {
    for (let i in routes) {
        routes[i].meta = routes[i].meta || {};

        if (!routes[i].meta.rules) {
            routes[i].meta.rules = [];
        }
        routes[i].meta.rules.unshift(...rules);

        if (routes[i].children) {
            routes[i].children = applyRules(rules, routes[i].children);
        }
    }

    return routes;
}
