
<template>
    <label class="switch">
        <input  type="checkbox" :checked="isChecked" @click="emitUpdateValue(etat)">
        <div class="slider round" :class="{ on: isChecked, off: !isChecked }"></div>
    </label>
</template>

<script>
export default {
    name: 'ToggleSwitch',
    data() {
        return {
            isChecked: this.etat,
            diseable: this.etat
        }
    },
    props: {
        etat: {
            type: Boolean,
            required: true,
        },
        id:{
            type: Number,
            required: true
        }
    },
    emits: ['update:etat'],
    methods: {
        emitUpdateValue(etat){
            this.$emit('update:etat', etat)
            console.log("Valeur"+ this.$props.id + " : " + this.$props.etat);
            console.log(etat);
        },
    },
}
</script>

<style scoped>
.switch {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 34px;
}

.switch input {
    display: none;
}

.slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    -webkit-transition: 0.4s;
    transition: 0.4s;
}

.slider:before {
    position: absolute;
    content: "";
    height: 26px;
    width: 26px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    -webkit-transition: 0.4s;
    transition: 0.4s;
}


input:checked+.slider {
    background-color: green;
}

input:focus+.slider {
    box-shadow: 0 0 1px green;
}

input:checked+.slider:before {
    -webkit-transform: translateX(26px);
    -ms-transform: translateX(26px);
    transform: translateX(26px);
}

input:disabled+.slider {
    background-color: green;
}

input:disabled+.slider:before {
    -webkit-transform: translateX(26px);
    -ms-transform: translateX(26px);
    transform: translateX(26px);
}

.slider.round {
    border-radius: 34px;
}

.slider.round:before {
    border-radius: 50%;
}

.on {
    background-color: green;
}

.on:before {
    -webkit-transform: translateX(26px);
    -ms-transform: translateX(26px);
    transform: translateX(26px);
}

.off {
    background-color: #ccc;
}

.off:before {
    -webkit-transform: translateX(4px);
    -ms-transform: translateX(4px);
    transform: translateX(4px);
}
</style>