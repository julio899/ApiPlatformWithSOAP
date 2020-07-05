<template>
    <div class="container-login">
        <loading v-if="loading"></loading>
        <nav class="" role="navigation">
            <div class="nav-wrapper container">
                <a id="logo-container" href="#" class="brand-logo left"></a>
                <ul class="right hide-on-med-and-down">
                    <li>
                        <a href="#"><i class="fas fa-bars"></i></a>
                    </li>
                </ul>
                <ul class="right hide-on-med-and-down">
                    <li>
                        <a href="#"><i class="fas fa-shopping-bag"></i></a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-search"></i></a>
                    </li>
                    <li>
                        <a href="#"><i class="far fa-heart"></i></a>
                    </li>
                </ul>

                <ul id="nav-mobile" class="sidenav">
                    <li><a href="#Inicio">Inicio</a></li>
                    <li><a href="#Servicios">Servicios</a></li>
                    <li>
                        <a href="#Terminos">T&eacute;rminos y Condiciones</a>
                    </li>
                </ul>
                <a href="#" data-target="nav-mobile" class="sidenav-trigger right">
                    <img src="img/menu.svg" alt="back" />
                </a>
            </div>
        </nav>

        <div class="section no-pad-bot" id="logo-main">
            <div class="container">
                <div class="row center container-logo">
                    <!--  <img src="img/r-logo.svg" alt="R logo" /> -->
                </div>

                <div v-if="isLoged" class="row center alert-success-custom animate__animated animate__bounceIn">
                    <p>Success</p>
                    <img src="img/success.svg" />
                </div>
            </div>
        </div>

        <div v-if="!isLoged" class="section no-pad-bot" id="index-banner">
            <div class="container">
                <div class="row center">
                    <div class="card">
                        <div class="card-tabs">
                            <ul class="tabs tabs-fixed-width">
                                <li
                                    :class="{
                                        tab: true,
                                        'tab-ingreso': true,
                                        animate__animated: true,
                                        animate__fadeInUp: tabIngActive,
                                    }"
                                    @click="activated('ingreso')"
                                >
                                    <a href="#ingreso" class="tab-lbl">Ingreso</a>
                                </li>
                                <li
                                    :class="{
                                        tab: true,
                                        'tab-registro': true,
                                        animate__animated: true,
                                        act: tabRegActive,
                                        animate__fadeInUp: tabRegActive,
                                        des: tabRegActive == false,
                                    }"
                                    @click="activated('registro')"
                                >
                                    <a class="tab-lbl" href="#registro">Registro</a>
                                </li>
                                <li class="indicator" style="left: 22px; right: 267px;"></li>
                            </ul>
                        </div>
                        <div
                            class="card-content grey lighten-4"
                            style="background-color: #3A3061!important;color: #fff;"
                        >
                            <div id="ingreso" class="active">
                                <form action="#" autocomplete="off">
                                    <div class="row">
                                        <label for="email-app" class="left clave">Email</label>
                                        <input
                                            id="email-app"
                                            type="email"
                                            autocomplete="false"
                                            v-model="user"
                                            class="validate txtInputs"
                                        />
                                    </div>
                                    <div class="row">
                                        <label for="password-app" class="left clave">Contrase&ntilde;a</label>
                                        <input
                                            id="password-app"
                                            type="password"
                                            v-model="pass"
                                            autocomplete="false"
                                            class="validate txtInputs"
                                        />

                                        <label for="password-app" class="lbl-requerido right"
                                            ><img src="img/requerido.svg" alt="Requerido img" /> Nro Documento de
                                            Identidad</label
                                        >
                                    </div>
                                </form>

                                <div class="row">
                                    <!-- Switch -->
                                    <div class="switch">
                                        <label class="lbl-newsletter">
                                            <input type="checkbox" />
                                            <span class="lever"></span>
                                            Suscribirse al Newsletter
                                        </label>
                                    </div>
                                </div>

                                <div class="row center">
                                    <a
                                        @click="makeLogin"
                                        :class="{
                                            'waves-effect': true,
                                            'waves-light': true,
                                            'btn-large': true,
                                            'btn-add': true,
                                            'btn-ingreso': true,
                                            animate__animated: true,
                                            animate__rubberBand: actionLogin,
                                        }"
                                        >Ingreso</a
                                    >
                                </div>

                                <div class="row center">
                                    <label class="lbl-newsletter">Olvido Contrase&ntilde;a</label>
                                </div>
                            </div>

                            <div id="registro" class="" style="display: none;">
                                <div class="row">
                                    <label for="name" class="left clave">Nombre</label>
                                    <input id="name" v-model="nameReg" type="text" class="validate txtInputs" />
                                    <label class="lbl-requerido right"
                                        ><img src="img/requerido.svg" alt="Requerido img" /> REQUERIDO</label
                                    >
                                </div>
                                <div class="row">
                                    <label for="apellido" apellido class="left clave">Apellido</label>
                                    <input id="apellido" v-model="apellidoReg" type="text" class="validate txtInputs" />
                                </div>
                                <div class="row">
                                    <label for="email2" class="left clave">Email</label>
                                    <input id="email2" v-model="emailReg" type="email" class="validate txtInputs" />
                                </div>
                                <div class="row">
                                    <label for="document" class="left clave">Nro Documento de Identidad</label>
                                    <input id="document" type="text" class="validate txtInputs" v-model="numDocument" />
                                </div>
                                <div class="row">
                                    <label for="cellphone" class="left clave">Nro de Tel&eacute;fono</label>
                                    <input id="cellphone" type="text" class="validate txtInputs" v-model="cellphone" />
                                </div>
                                <div class="row center">
                                    <a
                                        @click="makeRegister"
                                        :class="{
                                            'waves-effect': true,
                                            animate__animated: true,
                                            animate__rubberBand: actionRegister,
                                            'waves-light': true,
                                            'btn-large': true,
                                            'btn-add': true,
                                            'btn-ingreso': true,
                                        }"
                                        >Registro</a
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import loading from './loading.vue'
import soapService from '../services/apisoap.js'
import Swal from 'sweetalert2'
const jQuery = window.jQuery
export default {
    components: {
        loading,
    },
    name: 'login',
    props: {
        datos: Object,
    },
    data: function() {
        return {
            user: '',
            pass: '',
            tabRegActive: false,
            tabIngActive: true,
            actionLogin: false,
            actionRegister: false,
            loading: false,
            isLoged: false,
            nameReg: '',
            apellidoReg: '',
            emailReg: '',
            numDocument: '',
            cuentasStorage: [],
            cellphone: '',
        }
    },
    mounted() {
        // Verificando si no hay data previa o existen cuentas alamacenadas
        const cuentasLocalStorage = window.localStorage
        if (!cuentasLocalStorage.getItem('cuentas')) {
            cuentasLocalStorage.setItem('cuentas', JSON.stringify([]))
        }
        this.cuentasStorage = JSON.parse(cuentasLocalStorage.getItem('cuentas'))
        // ============================================
        // Registrando Eventos en tabs para vista Login
        // ============================================
        // Cuando clickeamos en tab-registro
        document.getElementsByClassName('tab-registro')[0].addEventListener('click', function() {
            document.getElementsByClassName('tab-registro')[0].classList.add('act')
            document.getElementsByClassName('tab-ingreso')[0].classList.add('des')
        })
        // Cuando clickeamos en tab-ingreso
        document.getElementsByClassName('tab-ingreso')[0].addEventListener('click', function() {
            document.getElementsByClassName('tab-registro')[0].classList.remove('act')
            document.getElementsByClassName('tab-ingreso')[0].classList.remove('des')
        })

        jQuery('.sidenav').sidenav()
        jQuery('.tabs').tabs()
    },
    methods: {
        activated: function(tabName) {
            if (tabName == 'registro') {
                this.tabRegActive = !this.tabRegActive
            }
            if (tabName == 'ingreso') {
                this.tabIngActive = !this.tabIngActive
            }
        },
        makeLogin: async function() {
            this.actionLogin = !this.actionLogin
            this.loading = true

            const xmlDoc = await soapService.loginAccount({
                email: this.user,
                document: this.pass,
            })
            // empty data
            if (this.user == '' || this.pass == '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Lo Sentimos',
                    text: 'No puede dejar campos vacios',
                })
            }

            console.log(xmlDoc)
            if (
                xmlDoc.getElementsByTagName('response') &&
                xmlDoc.getElementsByTagName('error').length > 0 &&
                xmlDoc.getElementsByTagName('error')[0] !== undefined &&
                xmlDoc.getElementsByTagName('error')[0].textContent == 'false' &&
                xmlDoc.getElementsByTagName('code').length > 0 &&
                xmlDoc.getElementsByTagName('code')[0] !== undefined &&
                xmlDoc.getElementsByTagName('code')[0].textContent == '200'
            ) {
                // Success

                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    onOpen: toast => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    },
                })

                Toast.fire({
                    icon: 'success',
                    title: 'Autenticado Exitosamente',
                })

                this.isLoged = true

                const self = this
                setTimeout(() => {
                    self.$parent.setPage('store')
                }, 1510)
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Lo Sentimos',
                    text: 'Usuario o Clave Invalidos!',
                })
            }

            this.loading = false
        },
        makeRegister: async function() {
            this.actionRegister = !this.actionRegister
            this.loading = true
            let error = true
            let messageError = ''

            if (this.nameReg.trim() == '') {
                messageError = 'El Nombre es requerido'
            } else if (this.apellidoReg.trim() == '') {
                messageError = 'El Apellido es requerido'
            } else if (this.emailReg.trim() == '') {
                messageError = 'El email es requerido'
            } else if (this.numDocument.trim() == '') {
                messageError = 'El Numero de Documento es requerido'
            } else if (this.cellphone.trim() == '') {
                messageError = 'El Numero de telefono es requerido'
            } else {
                error = false
            }

            console.log(error, messageError)

            if (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Lo Sentimos',
                    text: messageError,
                })

                this.loading = false
                return false
            }

            console.log(' ==== registro de cuenta === ')

            const xmlDoc = await soapService.registerAccount({
                name: this.nameReg,
                lastName: this.apellidoReg,
                email: this.emailReg,
                document: this.numDocument,
                cellphone: this.cellphone,
            })

            if (
                xmlDoc.getElementsByTagName('response') &&
                xmlDoc.getElementsByTagName('error').length > 0 &&
                xmlDoc.getElementsByTagName('error')[0] !== undefined &&
                xmlDoc.getElementsByTagName('error')[0].textContent == 'true'
            ) {
                Swal.fire({
                    position: 'center-end',
                    icon: 'error',
                    title: xmlDoc.getElementsByTagName('message')[0].textContent,
                    showConfirmButton: false,
                    timer: 1500,
                    showClass: {
                        popup: 'animate__animated animate__bounceIn',
                    },
                    hideClass: {
                        popup: 'animate__animated animate__bounceOut',
                    },
                })
                this.loading = false
            } else {
                this.nameReg = ''
                this.apellidoReg = ''
                this.emailReg = ''
                this.numDocument = ''
                this.cellphone = ''

                console.log(xmlDoc)
                Swal.fire({
                    position: 'center-end',
                    icon: 'success',
                    title: xmlDoc.getElementsByTagName('message')[0].textContent,
                    showConfirmButton: false,
                    timer: 1500,
                    showClass: {
                        popup: 'animate__animated animate__bounceIn',
                    },
                    hideClass: {
                        popup: 'animate__animated animate__bounceOut',
                    },
                })

                this.loading = false
            }

            return true
        },
    },
}
</script>

<style scoped>
.txtInputs {
    text-transform: none !important;
    color: #fff !important;
}
.alert-success-custom > p {
    color: #392f63;
    font-size: 20px;
    padding-top: 5%;
    min-height: 320px;
}

.alert-success-custom > img {
    /* Centrado */
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    margin: auto;
}
.alert-success-custom {
    text-align: center;
    color: #392f63;
    background: #37d0c8;
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    margin: 50% 5%;
    z-index: 5;
}
</style>
