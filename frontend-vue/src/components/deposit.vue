<template>
    <div class="container-deposit">
        <loading v-if="loading"></loading>
        <nav class="" role="navigation">
            <div class="nav-wrapper container">
                <a id="logo-container" @click="toStore" href="#" class="brand-logo left"
                    ><img src="/img/logo_epayco.png" style="width: 100%;"
                /></a>

                <ul class="right hide-on-med-and-down ">
                    <li>
                        <a href="#" data-target="nav-mobile"><i class="fas fa-bars"></i></a>
                    </li>
                </ul>

                <ul id="nav-mobile" class="sidenav">
                    <li>
                        <a href="#"><i class="fas fa-bars"></i></a>
                    </li>
                    <li @click="toStore">
                        <a href="#"><i class="fa fa-home"></i> Home</a>
                    </li>
                    <li @click="toDeposit">
                        <a href="#"><i class="fa fa-piggy-bank"></i> Depositar</a>
                    </li>
                </ul>
                <a href="#" data-target="nav-mobile" class="sidenav-trigger right"
                    ><i class="material-icons">menu</i></a
                >

                <a href="#" class="sidenav-mobil-ico right"><i class="fa fa-wallet"></i></a>
                <a href="#" @click="toDeposit" class="sidenav-mobil-ico right"><i class="fa fa-piggy-bank"></i></a>
            </div>
        </nav>

        <div class="section no-pad-bot" id="index-banner">
            <div class="container">
                <h1 class="header center product-title">Depositos</h1>

                <hr class="line" />

                <div class="row center">
                    <span class="lbl-sizes" style="font-size: 1.3em;">Tu Balance </span>
                    <a class="waves-effect waves-light btn-small btn-sizes green lighten-5" style="font-size: 1.5em;"
                        >$ {{ getBalance() }}</a
                    >
                </div>

                <div class="row left">
                    <span class="lbl-sizes">CANTIDAD A DEPOSITAR</span>
                    <div class="container-count right">
                        <input
                            placeholder="1"
                            value="100"
                            step="100"
                            id="countDep"
                            type="number"
                            class="validate"
                            min="100"
                            max="10000"
                            v-model="cantidad"
                        />
                    </div>
                </div>

                <div class="row left">
                    <span class="lbl-sizes">NUMERO DOCUMENTO</span>
                    <div class="container-count right">
                        <input id="doc" type="text" v-model="documento" />
                    </div>
                </div>

                <div class="row left">
                    <span class="lbl-sizes">TELEFONO</span>
                    <div class="container-count right">
                        <input id="cellphone" type="text" v-model="cellphone" />
                    </div>
                </div>

                <div class="row center">
                    <a class="waves-effect waves-light btn-large btn-sizes btn-add" @click="depositar">Depositar</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import loading from './loading.vue'
import Swal from 'sweetalert2'
import soapService from '../services/apisoap.js'
const jQuery = window.jQuery
export default {
    name: 'deposit',
    components: {
        loading,
    },
    props: {},
    mounted() {
        document.body.classList.add('withOut-bg')
        jQuery('.sidenav').sidenav()
        jQuery('.tabs').tabs()
        if (document.head.getElementsByTagName('link').csslogin !== undefined) {
            document.head.getElementsByTagName('link').csslogin.remove()
        }
        const self = this
        setTimeout(() => {
            self.loading = false
        }, 2000)
    },
    data: function() {
        return {
            loading: true,
            total: 0,
            cantidad: 0,
            documento: '',
            cellphone: '',
        }
    },
    methods: {
        toDeposit: function() {
            this.$parent.setPage('deposit')
        },
        toStore: function() {
            this.$parent.setPage('store')
        },
        getBalance() {
            return parseFloat(this.$parent.balance).toFixed(2)
        },
        async depositar() {
            if (this.documento != '' && this.cellphone != '' && this.cantidad != '') {
                const respDeposit = await soapService.sendDeposit(
                    this.$parent.wallet,
                    this.documento,
                    this.cellphone,
                    this.cantidad
                )
                console.log(respDeposit)
                if (respDeposit.transsaccion && respDeposit.transsaccion == true) {
                    this.documento = ''
                    this.cellphone = ''
                    this.cantidad = ''
                    this.$parent.setBalance(respDeposit.balance)
                    Swal.fire({
                        title: `Excelente deposito procesado`,
                        imageUrl: '/img/gold-bars.jpg',
                    })
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Lo Sentimos',
                        text: respDeposit.message,
                        footer: 'Porfavor verifique que todos los campos esten llenos correctamente',
                    })
                }
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Lo Sentimos',
                    text: 'No puedes dejar campos vacios ',
                    footer: 'Porfavor verifique que todos los campos esten llenos correctamente',
                })
            }
            return
        },
    },
}
</script>

<style scoped></style>
