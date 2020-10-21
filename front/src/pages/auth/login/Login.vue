<template>
    <div id="app">
        <v-app>
            <head>
                <link
                    rel="stylesheet"
                    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
                />
            </head>
            <div class="wrapper fadeInDown">
                <div id="formContent">
                    <!-- Icon -->
                    <div class="fadeIn first">
                        <v-avatar size="140">
                            <img :src="getAvatarLogo()" class="logo" alt="logo-transferencia"/>
                        </v-avatar>
                    </div>

                    <!-- Login Form -->
                    <v-form v-model="valid">
                        <input
                            type="email"
                            id="login"
                            :rules="emailRules"
                            class="fadeIn second"
                            name="email"
                            placeholder="E-mail"
                            v-model="form.email"
                        />
                        <input
                            type="password"
                            id="password"
                            class="fadeIn third"
                            name="login"
                            placeholder="Senha"
                            v-model="form.password"
                            :rules="passwordRules"
                        />
                        <br/>
                    </v-form>
                    <div class="text-center">
                        <v-row class="ma-2">
                            <v-col cols="12" sm="12" xl="12">
                                <v-btn block color="#43C86E" dark @click="login">
                                    Entrar
                                </v-btn>
                            </v-col>
                            <v-divider/>
                            <v-spacer/>
                            <v-col cols="12" sm="12" md="6" xl="6">
                                <v-card>
                                    <v-btn block color="#43C86E" dark @click="preencherComum">
                                        <v-icon dark left>face</v-icon>
                                        Usuário comum
                                    </v-btn>
                                </v-card>
                            </v-col>
                            <v-col cols="12" sm="12" md="6" xl="6">
                                <v-card>
                                    <v-btn block color="#43C86E" dark @click="preencherLojista">
                                        <v-icon dark left>store</v-icon>
                                        Usuário lojista
                                    </v-btn>
                                </v-card>
                            </v-col>
                        </v-row>
                    </div>
                    <!-- Remind Passowrd -->
                    <div class="formFooter">
                        <a style="color:#43C86E" class="underlineHover" @click="resetar()">Esqueceu Senha</a>
                    </div>
                    <div class="formFooter">
                        <a style="color:#43C86E" class="underlineHover" @click="cadastrar()">
                            <strong>Quero me cadastrar </strong>
                        </a>
                    </div>
                </div>
            </div>
        </v-app>
    </div>
</template>
<script>
import Form from 'vform';
import logo from '~/assets/logo.jpeg';

export default {
    data: () => ({
        select: null,
        valid: false,
        emailRules: [
            v => !!v || 'E-mail é obrigatório',
        ],
        passwordRules: [v => !!v || 'Senha é obrigatória'],
        email: '',
        form: new Form({
            email: '',
            password: '',
        }),
    }),
    methods: {
        cadastrar() {
            this.$router.push({name: 'cadastrar'});
        },
        resetar() {
            this.$router.push({name: 'resetar'});
        },
        reset() {
            this.$refs.form.reset();
        },
        async login() {
            if (!this.valid) {
                return;
            }
            const requestData = {
                grant_type: process.env.VUE_APP_GRANT_TYPE,
                client_id: process.env.VUE_APP_CLIENT_ID,
                client_secret: process.env.VUE_APP_CLIENT_SECRET,
                scope: '',
            };

            const data = Object.assign(requestData, {
                username: this.form.email,
                password: this.form.password,
            });

            await axios.post('/oauth/token', data).then(async res => {
                await this.$store.dispatch('auth/setToken', res.data);
                await this.$store.dispatch('auth/setCheck', true);
                await this.$store.dispatch('auth/fetchUser');
                const {name} = await this.$store.getters['auth/user'];
                notification.showInfoMsg(`Bem vindo, ${name}`);
                this.$router.push({name: 'home'});
            }).catch(err => {
                notification.showErrors({message: 'Credenciais inválidas'});
            });
        },
        preencherComum() {
            this.form.email = 'comum@user.com';
            this.form.password = '123456';
        },
        preencherLojista() {
            this.form.email = 'lojista@user.com';
            this.form.password = '123456';
        },
        getAvatarLogo() {
            return logo;
        },
    },
};
</script>
<style scoped>

.v-btn:not(.v-btn--round).v-size--default {
    height: 55px;
    min-width: 64px;
    padding: 0 16px;
    /* margin-top: 19%; */
}

html {
    font-size: 2.5em;
}

body {
    background-color: #ddd;
    padding: 25px;
    text-align: center;
}

/* Wrapper */
.icon-button {
    background-color: white;
    border-radius: 20px;
    cursor: pointer;
    display: inline-block;
    font-size: 1.3rem;
    height: 2.6rem;
    line-height: 2.6rem;
    margin: 0 5px;
    position: relative;
    text-align: center;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    width: 2.6rem;
}

/* Circle */
.icon-button span {
    border-radius: 0;
    display: block;
    height: 0;
    left: 50%;
    margin: 0;
    position: absolute;
    top: 50%;
    -webkit-transition: all 0.3s;
    -moz-transition: all 0.3s;
    -o-transition: all 0.3s;
    transition: all 0.3s;
    width: 0;
}

.icon-button:hover span {
    width: 2.6rem;
    height: 2.6rem;
    border-radius: 20px;
    margin: -1.3rem;
}

/* Icons */
.icon-button i {
    background: none;
    color: white;
    height: 2.6rem;
    left: 0;
    line-height: 2.6rem;
    position: absolute;
    top: 0;
    -webkit-transition: all 0.3s;
    -moz-transition: all 0.3s;
    -o-transition: all 0.3s;
    transition: all 0.3s;
    width: 2.6rem;
    z-index: 10;
}

.twitter {
    background-color: rgba(64, 153, 255, 0.7);
}

.facebook {
    background-color: rgba(80, 122, 189, 0.7);
}

.google-plus {
    background-color: rgba(219, 90, 60, 0.7);
}

/*HOVER*/

.facebook span {
    background-color: rgba(80, 122, 189, 0.7);
}

.google-plus span {
    background-color: rgba(219, 90, 60, 0.7);
}

.icon-button:hover .icon-facebook,
.icon-button:hover .icon-google-plus,
.icon-button:hover .fa-youtube,
.icon-button:hover .fa-pinterest {
    color: white;
}

@media all and (max-width: 680px) {
    input[type='button'] {
        width: 1.6rem;
        height: 1.6rem;
        border-radius: 1.6rem;
        margin: -0.8rem;
    }

    .icon-button:hover span {
        width: 1.6rem;
        height: 1.6rem;
        border-radius: 1.6rem;
        margin: -0.8rem;
    }

    /* Icons */
    .icon-button i {
        height: 1.6rem;
        line-height: 1.6rem;
        width: 1.6rem;
    }

    body {
        padding: 10px;
    }

    .pinterest {
        display: none;
    }
}

/*inicio */
html {
    font-size: 20px;
}

body {
    background-color: #01995a;
    padding: 50px;
    text-align: center;
}

/* Wrapper */

/* Style all font awesome icons */

/* BASIC */

html {
    background-color: #01995a;
}

body {
    font-family: 'Poppins', sans-serif;
    height: 100vh;
}

a {
    color: #92badd;
    display: inline-block;
    text-decoration: none;
    font-weight: 400;
}

h2 {
    text-align: center;
    font-size: 16px;
    font-weight: 600;
    text-transform: uppercase;
    display: inline-block;
    margin: 40px 8px 10px 8px;
    color: #cccccc;
}

/* STRUCTURE */

.wrapper {
    display: flex;
    align-items: center;
    flex-direction: column;
    justify-content: center;
    width: 100%;
    min-height: 100%;
    padding: 20px;
    background-color: #01995a;
}

#formContent {
    -webkit-border-radius: 10px 10px 10px 10px;
    border-radius: 10px 10px 10px 10px;
    background: #fff;
    padding: 30px;
    width: 90%;
    max-width: 500px;
    position: relative;
    padding: 0px;
    -webkit-box-shadow: 0 30px 60px 0 rgba(0, 0, 0, 0.3);
    box-shadow: 0 30px 60px 0 rgba(0, 0, 0, 0.3);
    text-align: center;
}

.formFooter {
    background-color: #f6f6f6;
    border-top: 1px solid #dce8f1;
    padding: 25px;
    text-align: center;
    -webkit-border-radius: 0 0 10px 10px;
    border-radius: 0 0 10px 10px;
}

/* TABS */

h2.inactive {
    color: #cccccc;
}

h2.active {
    color: #0d0d0d;
    border-bottom: 2px solid #5fbae9;
}

/* FORM TYPOGRAPHY*/

input[type='button'],
input[type='submit'],
input[type='reset'] {
    background-color: #01995a;
    border: none;
    color: white;
    padding: 15px 80px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    text-transform: uppercase;
    font-size: 13px;
    width: 470px;
    -webkit-box-shadow: 0 10px 30px 0 rgba(95, 186, 233, 0.4);
    box-shadow: 0 10px 30px 0 rgba(95, 186, 233, 0.4);
    -webkit-border-radius: 5px 5px 5px 5px;
    border-radius: 5px 5px 5px 5px;
    margin: 5px 20px 40px 20px;
    -webkit-transition: all 0.3s ease-in-out;
    -moz-transition: all 0.3s ease-in-out;
    -ms-transition: all 0.3s ease-in-out;
    -o-transition: all 0.3s ease-in-out;
    transition: all 0.3s ease-in-out;
}

input[type='button']:hover,
input[type='submit']:hover,
input[type='button']:active,
input[type='submit']:active,
input[type='reset']:active {
    -moz-transform: scale(0.95);
    -webkit-transform: scale(0.95);
    -o-transform: scale(0.95);
    -ms-transform: scale(0.95);
    transform: scale(0.95);
}

input[type='email'] {
    background-color: #f6f6f6;
    border: none;
    color: #0d0d0d;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 5px;
    width: 85%;
    border: 2px solid #f6f6f6;
    -webkit-transition: all 0.5s ease-in-out;
    -moz-transition: all 0.5s ease-in-out;
    -ms-transition: all 0.5s ease-in-out;
    -o-transition: all 0.5s ease-in-out;
    transition: all 0.5s ease-in-out;
    -webkit-border-radius: 5px 5px 5px 5px;
    border-radius: 5px 5px 5px 5px;
}

input[type='password'] {
    background-color: #f6f6f6;
    border: none;
    color: #0d0d0d;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 5px;
    width: 85%;
    border: 2px solid #f6f6f6;
    -webkit-transition: all 0.5s ease-in-out;
    -moz-transition: all 0.5s ease-in-out;
    -ms-transition: all 0.5s ease-in-out;
    -o-transition: all 0.5s ease-in-out;
    transition: all 0.5s ease-in-out;
    -webkit-border-radius: 5px 5px 5px 5px;
    border-radius: 5px 5px 5px 5px;
}

input[type='text'] {
    background-color: #f6f6f6;
    border: none;
    color: #0d0d0d;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 5px;
    width: 85%;
    border: 2px solid #f6f6f6;
    -webkit-transition: all 0.5s ease-in-out;
    -moz-transition: all 0.5s ease-in-out;
    -ms-transition: all 0.5s ease-in-out;
    -o-transition: all 0.5s ease-in-out;
    transition: all 0.5s ease-in-out;
    -webkit-border-radius: 5px 5px 5px 5px;
    border-radius: 5px 5px 5px 5px;
}

input[type='text']:focus {
    background-color: #fff;
    border-bottom: 2px solid #5fbae9;
}

input[type='text']:placeholder {
    color: #cccccc;
}

/* ANIMATIONS */

/* Simple CSS3 Fade-in-down Animation */
.fadeInDown {
    -webkit-animation-name: fadeInDown;
    animation-name: fadeInDown;
    -webkit-animation-duration: 1s;
    animation-duration: 1s;
    -webkit-animation-fill-mode: both;
    animation-fill-mode: both;
}

@-webkit-keyframes fadeInDown {
    0% {
        opacity: 0;
        -webkit-transform: translate3d(0, -100%, 0);
        transform: translate3d(0, -100%, 0);
    }
    100% {
        opacity: 1;
        -webkit-transform: none;
        transform: none;
    }
}

@keyframes fadeInDown {
    0% {
        opacity: 0;
        -webkit-transform: translate3d(0, -100%, 0);
        transform: translate3d(0, -100%, 0);
    }
    100% {
        opacity: 1;
        -webkit-transform: none;
        transform: none;
    }
}

/* Simple CSS3 Fade-in Animation */
@-webkit-keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

@-moz-keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

.fadeIn {
    opacity: 0;
    -webkit-animation: fadeIn ease-in 1;
    -moz-animation: fadeIn ease-in 1;
    animation: fadeIn ease-in 1;

    -webkit-animation-fill-mode: forwards;
    -moz-animation-fill-mode: forwards;
    animation-fill-mode: forwards;

    -webkit-animation-duration: 1s;
    -moz-animation-duration: 1s;
    animation-duration: 1s;
}

.fadeIn.first {
    -webkit-animation-delay: 0.4s;
    -moz-animation-delay: 0.4s;
    animation-delay: 0.4s;
}

.fadeIn.second {
    -webkit-animation-delay: 0.6s;
    -moz-animation-delay: 0.6s;
    animation-delay: 0.6s;
}

.fadeIn.third {
    -webkit-animation-delay: 0.8s;
    -moz-animation-delay: 0.8s;
    animation-delay: 0.8s;
}

.fadeIn.fourth {
    -webkit-animation-delay: 1s;
    -moz-animation-delay: 1s;
    animation-delay: 1s;
}

/* Simple CSS3 Fade-in Animation */
.underlineHover:after {
    display: block;
    left: 0;
    bottom: -10px;
    width: 0;
    height: 2px;
    background-color: #56baed;
    content: '';
    transition: width 0.2s;
}

.underlineHover:hover {
    color: #0d0d0d;
}

.underlineHover:hover:after {
    width: 100%;
}

/* OTHERS */

*:focus {
    outline: none;
}

#icon {
    width: 60%;
}

* {
    box-sizing: border-box;
}

.logo {
    padding-top: 10px;
}
</style>
