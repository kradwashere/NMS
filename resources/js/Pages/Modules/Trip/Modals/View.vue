<template>
    <b-modal v-model="showModal" title="View Trip" size="xl" header-class="p-3 bg-light" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>    
        
        <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Cancel</b-button>
            <b-button @click="create('ok')" variant="primary" :disabled="form.processing" block>Save</b-button>
        </template>
    </b-modal>
</template>
<script>
export default {
    data(){
        return {
            currentUrl: window.location.origin,
            showModal: false,
            form: {}
        }
    },
    methods : {
        show() {
            this.showModal = true;
        },
        hide(){
            this.showModal = false;
        },
    }
}
</script>
