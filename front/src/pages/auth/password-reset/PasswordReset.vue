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
                    <div class="fadeIn first">
                        <v-avatar size="140">
                            <img :src="getAvatarLogo()" alt="logo-minha-grana"/>
                        </v-avatar>
                    </div>
                    <v-layout wrap>
                        <v-flex xs12 md12 class="pl-10 pr-10">
                            <v-form ref="form" v-model="valid" lazy-validation>
                                <v-text-field
                                        type="password"
                                        v-model="userForm.password"
                                        :rules="passwordRules"
                                        label="Nova senha"
                                        required
                                ></v-text-field>

                                <v-text-field
                                        v-model="userForm.passwordConfirmed"
                                        :rules="passwordConfirmRules"
                                        label="Digite a Senha Novamente"
                                        type="password"
                                        :error-messages="passwordMatchError()"
                                        required
                                ></v-text-field>

                                <input
                                        type="button"
                                        @click="recuperarSenha"
                                        class="fadeIn fourth"
                                        value="Resetar"
                                />
                            </v-form>
                        </v-flex>
                    </v-layout>
                </div>
            </div>
        </v-app>
    </div>
</template>
<script>
    import userApi from '$api/User'
    import Form from 'vform'
    import logo from '~/assets/logo.jpeg'

    export default {
        data: () => ({
            valid: false,
            passwordRules: [v => !!v || 'Nova senha é obrigatória'],
            passwordConfirmRules: [
                v => !!v || 'Sua senha de confirmação é obrigatório',
            ],
            userForm: new Form({
                email: '',
                token: '',
                password: '',
                passwordConfirmed: '',
            }),
        }),
        methods: {
            async recuperarSenha() {
                const {status} = await userApi.resetarSenha(this.userForm)
                if (status === true) {
                    this.$router.push({name: 'login'})
                }
            },
            getAvatarLogo() {
                return logo
            },
            passwordMatchError() {
                return this.userForm.password === this.userForm.passwordConfirmed
                    ? ''
                    : 'Senhas devem ser iguais'
            },
        },
        beforeMount() {
            this.userForm.email = this.$route.query.email
            this.userForm.token = this.$route.params.token
        },

    }
</script>
<style scoped>
    html {
        font-size: 20px;
    }

    body {
        background-color: #ccc;
        padding: 50px;
        text-align: center;
    }

    /* Wrapper */
    .icon-button {
        background-color: white;
        border-radius: 3.6rem;
        cursor: pointer;
        display: inline-block;
        font-size: 2rem;
        height: 3.6rem;
        line-height: 3.6rem;
        margin: 0 5px;
        position: relative;
        text-align: center;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        width: 3.6rem;
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
        width: 3.6rem;
        height: 3.6rem;
        border-radius: 3.6rem;
        margin: -1.8rem;
    }

    .twitter span {
        background-color: #4099ff;
    }

    .facebook span {
        background-color: #3b5998;
    }

    .google-plus span {
        background-color: #db5a3c;
    }

    /* Icons */
    .icon-button i {
        background: none;
        color: white;
        height: 3.6rem;
        left: 0;
        line-height: 3.6rem;
        position: absolute;
        top: 0;
        -webkit-transition: all 0.3s;
        -moz-transition: all 0.3s;
        -o-transition: all 0.3s;
        transition: all 0.3s;
        width: 3.6rem;
        z-index: 10;
    }

    .icon-button .icon-twitter {
        color: #4099ff;
    }

    .icon-button .icon-facebook {
        color: #3b5998;
    }

    .icon-button .icon-google-plus {
        color: #db5a3c;
    }

    .icon-button:hover .icon-twitter,
    .icon-button:hover .icon-facebook,
    .icon-button:hover .icon-google-plus {
        color: white;
    }

    /* Style all font awesome icons */

    /* BASIC */

    html {
        background-color: #2b985e;
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
        max-width: 450px;
        position: relative;
        padding: 0px;
        -webkit-box-shadow: 0 30px 60px 0 rgba(0, 0, 0, 0.3);
        box-shadow: 0 30px 60px 0 rgba(0, 0, 0, 0.3);
        text-align: center;
    }

    #formFooter {
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
        background-color: #01995a;
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
</style>
<style lang="sass" scoped>
    // Fonts
    $mainFont: 'Raleway', sans-serif
    $subFont: 'Montserrat', sans-serif

    // Color Scheme
    $primaryColor: #f95959
    $secondaryColor: #f7edd5
    $inputColor: #bbbbbb


    // General Style
    body
        font-family: $subFont
        background: $secondaryColor

    .container
        max-width: 900px

    a
        display: inline-block
        text-decoration: none

    input
        outline: none !important

    h1
        text-align: center
        text-transform: uppercase
        margin-bottom: 40px
        font-weight: 700

    section#formHolder
        padding: 50px 0


    // Brand Area
    .brand
        padding: 20px
        background: url(https://goo.gl/A0ynht)
        background-size: cover
        background-position: center center
        color: #fff
        min-height: 540px
        position: relative
        box-shadow: 3px 3px 10px rgba(0, 0, 0, 0.3)
        transition: all 0.6s cubic-bezier(1.000, -0.375, 0.285, 0.995)
        z-index: 9999

        &.active
            width: 100%

        &::before
            content: ''
            display: block
            width: 100%
            height: 100%
            position: absolute
            top: 0
            left: 0
            background: #14dc3f
            z-index: -1

        a.logo
            color: $primaryColor
            font-size: 20px
            font-weight: 700
            text-decoration: none
            line-height: 1em

            span
                font-size: 30px
                color: #fff
                transform: translateX(-5px)
                display: inline-block

        .heading
            position: absolute
            top: 50%
            left: 50%
            transform: translate(-50%, -50%)
            text-align: center
            transition: all 0.6s

            &.active
                top: 100px
                left: 100px
                transform: translate(0)

            h2
                font-size: 70px
                font-weight: 700
                text-transform: uppercase
                margin-bottom: 0

            p
                font-size: 15px
                font-weight: 300
                text-transform: uppercase
                letter-spacing: 2px
                white-space: 4px
                font-family: $mainFont

        .success-msg
            width: 100%
            text-align: center
            position: absolute
            top: 50%
            left: 50%
            transform: translate(-50%, -50%)
            margin-top: 60px

            p
                font-size: 25px
                font-weight: 400
                font-family: $mainFont

            a
                font-size: 12px
                text-transform: uppercase
                padding: 8px 30px
                background: $primaryColor
                text-decoration: none
                color: #fff
                border-radius: 30px

            p, a
                transition: all 0.9s
                transform: translateY(20px)
                opacity: 0

                &.active
                    transform: translateY(0)
                    opacity: 1


    // Form Area
    .form
        position: relative

        .form-peice
            background: #fff
            min-height: 480px
            margin-top: 30px
            box-shadow: 3px 3px 10px rgba(0, 0, 0, 0.2)
            color: $inputColor
            padding: 30px 0 60px
            transition: all 0.9s cubic-bezier(1.000, -0.375, 0.285, 0.995)
            position: absolute
            top: 0
            left: -30%
            width: 130%
            overflow: hidden

            &.switched
                transform: translateX(-100%)
                width: 100%
                left: 0

        form
            padding: 0 40px
            margin: 0
            width: 70%
            position: absolute
            top: 50%
            left: 60%
            transform: translate(-50%, -50%)


            .form-group
                margin-bottom: 5px
                position: relative

                &.hasError
                    input
                        border-color: $primaryColor !important

                    label
                        color: $primaryColor !important

            label
                font-size: 12px
                font-weight: 400
                text-transform: uppercase
                font-family: $subFont
                transform: translateY(40px)
                transition: all 0.4s
                cursor: text
                z-index: -1

                &.active
                    transform: translateY(10px)
                    font-size: 10px

                &.fontSwitch
                    font-family: $mainFont !important
                    font-weight: 600

            input:not([type=submit])
                background: none
                outline: none
                border: none
                display: block
                padding: 10px 0
                width: 100%
                border-bottom: 1px solid #eee
                color: #444
                font-size: 15px
                font-family: $subFont
                z-index: 1

                &.hasError
                    border-color: $primaryColor

            span.error
                color: $primaryColor
                font-family: $subFont
                font-size: 12px
                position: absolute
                bottom: -20px
                right: 0
                display: none

            input[type=password]
                color: $primaryColor

            .CTA
                margin-top: 30px

                input
                    font-size: 12px
                    text-transform: uppercase
                    padding: 5px 30px
                    background: $primaryColor
                    color: #fff
                    border-radius: 30px
                    margin-right: 20px
                    border: none
                    font-family: $subFont

                a.switch
                    font-size: 13px
                    font-weight: 400
                    font-family: $subFont
                    color: $inputColor
                    text-decoration: underline
                    transition: all 0.3s

                    &:hover
                        color: $primaryColor


    footer
        text-align: center

        p
            color: #777

            a, a:focus
                color: #b8b09f
                transition: all .3s
                text-decoration: none !important

                &:hover
                    color: $primaryColor


    @media (max-width: 768px)
        .container
            overflow: hidden
        section#formHolder
            padding: 0

            div.brand
                min-height: 200px !important

                &.active
                    min-height: 100vh !important

                .heading.active
                    top: 200px
                    left: 50%
                    transform: translate(-50%, -50%)

                .success-msg
                    p
                        font-size: 16px

                    a
                        padding: 5px 30px
                        font-size: 10px


            .form
                width: 80vw
                min-height: 500px
                margin-left: 10vw

                .form-peice
                    margin: 0
                    top: 0
                    left: 0
                    width: 100% !important
                    transition: all .5s ease-in-out

                    &.switched
                        transform: translateY(-100%)
                        width: 100%
                        left: 0

                    > form
                        width: 100% !important
                        padding: 60px
                        left: 50%

    @media (max-width: 480px)
        section#formHolder .form
            width: 100vw
            margin-left: 0

        h2
            font-size: 50px !important</style
</

style

>
