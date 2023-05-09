<template>
    <div class="popup">
        <div class="popup-inner">
            <slot />
            <h3>Récompense : {{ label }}</h3>
            <img :src="require(`../../images/` + imageRec)" :alt="imageRec" style="height: 80%;">
            <a href="/home"><button style="left: 30%;" class="popup-close" @click="TogglePopup()">Ok</button></a>
        </div>
    </div>
</template>


<script>
export default {

    props: {
        TogglePopup: {
            type: Function,
            required: true
        },
        imageRec: {
            type: String,
            required: true
        },
        label: {
            type: String,
            required: true
        }
    }
}
</script>
<style>
.popup {
    position: fixed;
    top: 0;
    left: 0;
    bottom: 0;
    right: 0;
    z-index: 99;
    background-color: rgb(0, 0, 0, 0.2);
    display: flex;
    align-items: center;
    justify-content: center;
}
.popup-inner {
    padding: 120px;
    background: #FFF;
}
</style>