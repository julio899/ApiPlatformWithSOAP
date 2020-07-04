<template>
    <div class="container-loader">
        <div class="spinner">
            <div class="cube1"></div>
            <div class="cube2"></div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'loading',
}
</script>

<!-- Lo primero que se visualizara sera el loader y lo quitaremos cuando esten cargados sus componentes -->
<style scoped>
.container-loader {
    position: fixed;
    background-color: rgb(58, 48, 97, 0.5);
    width: 100%;
    height: 100%;
    color: #fff;
    text-align: center;
    z-index: 10;
}
.spinner {
    width: 70px;
    height: 70px;
    /* Centrado */
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    margin: auto;
}

.cube1,
.cube2 {
    background-color: #fff;
    width: 15px;
    height: 15px;
    position: absolute;
    top: 0;
    left: 0;

    -webkit-animation: sk-cubemove 1.8s infinite ease-in-out;
    animation: sk-cubemove 1.8s infinite ease-in-out;
}

.cube2 {
    -webkit-animation-delay: -0.9s;
    animation-delay: -0.9s;
}

@-webkit-keyframes sk-cubemove {
    25% {
        -webkit-transform: translateX(72px) rotate(-90deg) scale(0.5);
    }
    50% {
        -webkit-transform: translateX(70px) translateY(70px) rotate(-180deg);
    }
    75% {
        -webkit-transform: translateX(0px) translateY(70px) rotate(-270deg) scale(0.5);
    }
    100% {
        -webkit-transform: rotate(-360deg);
    }
}

@keyframes sk-cubemove {
    25% {
        transform: translateX(70px) rotate(-90deg) scale(0.5);
        -webkit-transform: translateX(70px) rotate(-90deg) scale(0.5);
    }
    50% {
        transform: translateX(70px) translateY(70px) rotate(-179deg);
        -webkit-transform: translateX(70px) translateY(70px) rotate(-179deg);
    }
    50.1% {
        transform: translateX(70px) translateY(70px) rotate(-180deg);
        -webkit-transform: translateX(70px) translateY(70px) rotate(-180deg);
    }
    75% {
        transform: translateX(0px) translateY(70px) rotate(-270deg) scale(0.5);
        -webkit-transform: translateX(0px) translateY(70px) rotate(-270deg) scale(0.5);
    }
    100% {
        transform: rotate(-360deg);
        -webkit-transform: rotate(-360deg);
    }
}
</style>
