<template>
    <b-modal v-model="showModal" title="Create Transportation" header-class="p-3 bg-light" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>    
        <b-form class="customform mb-2">
            <div class="row customerform">
                
                <div class="col-md-12 mt-4">
                   <div class="form-group">
                        <label>Name:</label>
                        <input type="text" class="form-control" v-model="name" style="text-transform: capitalize;">
                    </div>
                </div>
                <div class="col-md-12">
                    <label>Type: <span v-if="form.errors" v-text="form.errors.semester_id" class="haveerror"></span></label>
                    <multiselect v-model="type" id="ajax" label="name" track-by="id"
                        placeholder="Select Type" open-direction="bottom" :options="types"
                        :allow-empty="false"
                        :show-labels="false">
                    </multiselect> 
                </div>
            </div>
        </b-form>
        <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Cancel</b-button>
            <b-button @click="create('ok')" variant="primary" :disabled="form.processing" block>Save</b-button>
        </template>
    </b-modal>
</template>
<script>
import Multiselect from '@suadelabs/vue3-multiselect';
export default {
    components: { Multiselect },
    props: ['types'],
    data(){
        return {
            showModal: false,
            id: '',
            name: '',
            type: '',
            form: {},
            editable: false,
        }
    },

    methods : {
        show() {
            this.id = '';
            this.name = '';
            this.type = '';
            this.editable = false;
            this.showModal = true;
        },
        edit(data){
            this.id = data.id;
            this.name = data.name;
            this.type = data.type
            this.editable = true;
            this.showModal = true;
        },
        create(){
            this.form = this.$inertia.form({
                id: this.id,
                name: this.name,
                type_id: (this.type) ? this.type.id : '',
                editable: this.editable
            })

            this.form.post('/transportations',{
                preserveScroll: true,
                onSuccess: (response) => {
                    this.hide();
                },
            });
        },
        hide(){
            this.$emit('message',true);
            this.showModal = false;
        },
    }
}
</script>
<style>
.multiselect__single {
    font-size: 12px;
}
</style>
