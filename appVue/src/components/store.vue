<template>
    <div class="container-store">
        <loading v-if="loading"></loading>

        <nav class="" role="navigation">
            <div class="nav-wrapper container">
                <a id="logo-container" href="#" class="brand-logo left">Logo</a>
                <ul class="right hide-on-med-and-down ">
                    <li>
                        <a href="#" data-target="nav-mobile"><i class="fas fa-bars"></i></a>
                    </li>
                </ul>

                <ul id="nav-mobile" class="sidenav">
                    <li>
                        <a href="#"><i class="fas fa-bars"></i></a>
                    </li>
                    <li>
                        <a href="#"><i class="fas fa-shopping-bag"></i> Shopping</a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-search"></i> Searchs</a>
                    </li>
                    <li>
                        <a href="#"><i class="far fa-heart"></i> Favorites</a>
                    </li>
                </ul>
                <a href="#" data-target="nav-mobile" class="sidenav-trigger right"
                    ><i class="material-icons">menu</i></a
                >
                <a href="#" class="sidenav-mobil-ico right"><i class="far fa-heart"></i></a>
                <a href="#" class="sidenav-mobil-ico right"><i class="fas fa-shopping-bag"></i></a>
                <a href="#" class="sidenav-mobil-ico right"><i class="fa fa-search"></i></a>
            </div>
        </nav>

        <div class="section no-pad-bot" id="photo-main">
            <span>Photo</span>
        </div>

        <div class="section no-pad-bot" id="index-banner">
            <div class="container">
                <h1 class="header center product-title">Pantalones para Dama <br />"The Sideswept Dhoti"</h1>
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

                <div class="row left">
                    <span class="lbl-sizes">TAMA&Ntilde;O</span>
                    <a class="waves-effect waves-light btn-small btn-sizes">S</a>
                    <a class="waves-effect waves-light btn-small btn-sizes">M</a>
                    <a class="waves-effect waves-light btn-small btn-sizes">L</a>
                    <a class="waves-effect waves-light btn-small btn-sizes">XL</a>
                    <a class="waves-effect waves-light btn-small btn-sizes">XXL</a>
                </div>

                <div class="row left">
                    <span class="lbl-sizes">KIT</span>
                    <a class="waves-effect waves-light btn-large btn-kit">HOME</a>
                    <a class="waves-effect waves-light btn-large btn-kit">AWAY</a>
                    <a class="waves-effect waves-light btn-large btn-kit">THIRD</a>
                </div>

                <div class="row left">
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
                    <a class="waves-effect waves-light btn-large btn-sizes btn-add">Agregar al Carrito</a>
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
const jQuery = window.jQuery
export default {
    components: {
        loading,
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
            price: 139.99,
            total: 0,
        }
    },
    methods: {
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
