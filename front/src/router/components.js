/* Layout */
export const LayoutDefaultWrapper = () => import('$layouts/DefaultWrapper');
export const LayoutDefault = () => import('$layouts/Default');
export const LayoutLogin = () => import('$layouts/Auth');

/* Auth */
export const Login = () => import('$pages/auth/login/Login');

/* Cadastrar */
export const Cadastrar = () => import('$pages/auth/cadastrar/Cadastrar');

/* Resetar Senha */
export const Resetar = () => import('$pages/auth/reset-senha/Resetar');

/* */
export const PasswordReset = () => import('$pages/auth/password-reset/PasswordReset');

/* Home */
export const Home = () => import('$pages/home/Home');

/* Erros */
export const NotFound = () => import('$pages/errors/404');
