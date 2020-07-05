<template>
    <div class="container-loader">
        <div class="code-container">Dinamic Code: {{ code }}</div>
    </div>
</template>

<script>
export default {
    name: 'showCode',
    props: {
        code: String,
    },
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
    z-index: 5;
}
.code-container {
    padding-top: 5px;
    font-size: 1.5em;
    background-color: rgba(0, 0, 0, 0.5);
}
</style>
