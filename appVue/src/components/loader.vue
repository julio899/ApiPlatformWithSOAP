<template>
    <div class="container-loader">
        <div class="loader"></div>
    </div>
</template>

<script>
export default {
    name: 'loader',
    props: {
        datos: Object,
    },
    mounted() {
        let self = this
        setTimeout(function() {
            self.$parent.setLoad(false)
        }, 3000)
    },
}
</script>

<!-- Lo primero que se visualizara sera el loader y lo quitaremos cuando esten cargados sus componentes -->
<style scoped>
.container-loader {
    position: fixed;
    background-color: rgb(58, 48, 97);
    width: 100%;
    height: 100%;
    color: #fff;
    text-align: center;
}

.loader {
    border: 7px solid #f3f3f3; /* Light grey */
    border-top: 5px solid #2fcec5; /* Blue */
    border-radius: 50%;
    width: 10em;
    height: 10em;
    animation: spin 2s linear infinite;
    /* centrando */
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    margin: auto;
}

@keyframes spin {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
}
</style>
