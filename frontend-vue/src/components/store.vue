<template>
    <div class="container-store">
        <loading v-if="loading"></loading>
        <showCode v-if="displayCode" :code="dinamicToken" />
        <nav class="" role="navigation">
            <div class="nav-wrapper container">
                <a id="logo-container" href="#" class="brand-logo left"
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
                    <li @click="toDeposit">
                        <a href="#"><i class="fa fa-piggy-bank"></i> Depositar</a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-wallet"></i> Wallet</a>
                    </li>
                </ul>
                <a href="#" data-target="nav-mobile" class="sidenav-trigger right"
                    ><i class="material-icons">menu</i></a
                >

                <a href="#" class="sidenav-mobil-ico right"><i class="fa fa-wallet"></i></a>
                <a href="#" @click="toDeposit" class="sidenav-mobil-ico right"><i class="fa fa-piggy-bank"></i></a>

                <!--
                    <a href="#" class="sidenav-mobil-ico right"><i class="fas fa-shopping-bag"></i></a>
                    <a href="#" class="sidenav-mobil-ico right"><i class="fa fa-hand-holding-usd"></i></a>
                    <a href="#" class="sidenav-mobil-ico right"><i class="fa fa-coins"></i></a>
            --></div>
        </nav>

        <div class="section no-pad-bot" id="photo-main">
            <!-- <span>Photo</span> -->
            <img src="/img/gold100g.webp" style="width: 100%;" />
        </div>

        <div class="section no-pad-bot" id="index-banner">
            <div class="container">
                <h1 class="header center product-title">100g de Oro Fino Suisso <br />"100g Fine Gold Suisse"</h1>
                <div class="row center">
                    <h5 class="header col s12 light">
                        <i class="fas fa-star red-start"></i>
                        <i class="fas fa-star red-start"></i>
                        <i class="fas fa-star red-start"></i>
                        <i class="fas fa-star red-start"></i>
                        <i class="far fa-star red-start"></i> 4 de 5
                    </h5>
                    <label class="price">${{ getTotal() }}</label>
                </div>
                <hr class="line" />

                <div class="row center">
                    <span class="lbl-sizes" style="font-size: 1.3em;">Tu Balance </span>
                    <a class="waves-effect waves-light btn-small btn-sizes green lighten-5" style="font-size: 1.5em;"
                        >$ {{ getBalance() }}</a
                    >
                </div>

                <div class="row center">
                    <span class="lbl-sizes">CANTIDAD</span>
                    <div class="container-count">
                        <span class="icons-control lbl-sizes" @click="disminuirCantidad">-</span>
                        <input
                            placeholder="1"
                            value="1"
                            id="count"
                            type="number"
                            class="validate"
                            min="1"
                            max="100"
                            v-model="cantidad"
                        />
                        <span class="icons-control lbl-sizes" @click="aumentarCantidad">+</span>
                    </div>
                </div>

                <div class="row center">
                    <a class="waves-effect waves-light btn-large btn-sizes btn-add" @click="comprar">Comprar</a>
                </div>

                <hr class="line" />
                <div class="row left">
                    <h5 class="header title-descr">Descripci&oacute;n</h5>
                    <p class="txt-descr">
                        Lorem ipsum dolor sit, amet consectetur adipisicing elit. Iure reprehenderit aperiam distinctio
                        dolore animi ...
                    </p>
                    <a class="link-read-more" rel="#">Leer M&aacute;s</a>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row center">
                <h5 class="header title-descr left">
                    Tambi&eacute;n te podr&iacute;a gustar
                </h5>
                <div class="container-products-varius">
                    <div class="producto">
                        <div class="image-product"></div>
                        <h5 class="title-product">Product 1</h5>
                        <p class="price-product">$130</p>
                    </div>
                    <div class="producto">
                        <div class="image-product"></div>
                        <h5 class="title-product">Product 2</h5>
                        <p class="price-product">$130</p>
                    </div>
                    <div class="producto">
                        <div class="image-product"></div>
                        <h5 class="title-product">Product 3</h5>
                        <p class="price-product">$130</p>
                    </div>
                    <div class="producto">
                        <div class="image-product"></div>
                        <h5 class="title-product">Product 4</h5>
                        <p class="price-product">$130</p>
                    </div>
                </div>
            </div>
        </div>

        <footer class="footer-custom">
            <div class="row left">
                <p class="grey-text text-lighten-4 txt-copyright">
                    &copy; Copiright.
                </p>
            </div>
        </footer>
    </div>
</template>

<script>
import loading from './loading.vue'
import Swal from 'sweetalert2'
import showCode from './showCode.vue'
import soapService from '../services/apisoap.js'
const jQuery = window.jQuery
export default {
    components: {
        loading,
        showCode,
    },
    name: 'store',
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
            cantidad: 1,
            price: 174.99,
            total: 0,
            displayCode: false,
            dinamicToken: 1411,
        }
    },
    methods: {
        toDeposit: function() {
            this.$parent.setPage('deposit')
        },
        comprar: async function() {
            this.loading = true

            if (parseFloat(this.getBalance()) < parseFloat(this.getTotal())) {
                Swal.fire({
                    icon: 'error',
                    title: 'Lo Sentimos',
                    text: 'Balance Insuficiente tienes $ ' + this.getBalance(),
                    footer: 'necesitas tener almenos un Balance de $' + this.getTotal(),
                })
            } else {
                const confirmacionCompra = Swal.mixin({
                    customClass: {
                        confirmButton: 'waves-effect waves-light btn-small btn-sizes btn-add green',
                        cancelButton: 'waves-effect waves-light btn-small btn-sizes btn-add',
                    },
                    buttonsStyling: false,
                })

                // Buscamos el codigo antes de mostrarlo
                this.dinamicToken = (await soapService.getCode(this.$parent.wallet)).toString()
                // const self = this;

                confirmacionCompra
                    .fire({
                        title: 'Esta seguro de confirmar la compra de $ ' + this.getTotal() + '?',
                        text: 'Despues de validado su codigo no se podra revertir!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Si, Comprarlo !',
                        cancelButtonText: 'No, quiero Cancelar!',
                        reverseButtons: true,
                    })
                    .then(result => {
                        if (result.value) {
                            this.displayCode = true
                            // /////////////
                            Swal.fire({
                                title: 'Ingrese 6 dig del token de confirmacion',
                                input: 'text',
                                inputAttributes: {
                                    autocapitalize: 'off',
                                },
                                showCancelButton: true,
                                confirmButtonText: 'Validar',
                                showLoaderOnConfirm: true,
                                preConfirm: async codeInput => {
                                    console.log(this.$parent.wallet, codeInput, this.getTotal())
                                    const transsaction = await soapService.sendTranssaction(
                                        this.$parent.wallet,
                                        codeInput,
                                        this.getTotal()
                                    )
                                    return transsaction
                                },
                                allowOutsideClick: () => !Swal.isLoading(),
                            }).then(result => {
                                this.displayCode = false
                                console.log(result, result.value.balance)
                                if (result.value.balance) {
                                    this.$parent.setBalance(result.value.balance)
                                    Swal.fire({
                                        title: `Excelente compra procesada satisfactoriamente`,
                                        imageUrl: '/img/gold-bars.jpg', //result.value.avatar_url,
                                    })
                                } else {
                                    if (result.value.message) {
                                        confirmacionCompra.fire('Operacion Cancelada', result.value.message, 'error')
                                    } else {
                                        confirmacionCompra.fire('Operacion Cancelada', 'ha ocurrido un error', 'error')
                                    }
                                }
                            })

                            /**/
                        } else if (
                            /* Read more about handling dismissals below */
                            result.dismiss === Swal.DismissReason.cancel
                        ) {
                            confirmacionCompra.fire('Cancelado', 'Operacion Anulada', 'error')
                        }
                    })
            }

            this.loading = false
        },
        showCode() {},
        getBalance() {
            return parseFloat(this.$parent.balance).toFixed(2)
        },
        getTotal() {
            this.total = parseFloat(this.price * this.cantidad).toFixed(2)
            return this.total
        },
        disminuirCantidad: function() {
            if (this.cantidad > 1) {
                this.cantidad--
            }
        },
        aumentarCantidad: function() {
            this.cantidad++
        },
    },
}
</script>
<style>
.withOut-bg {
    background: #fff !important;
}
</style>
