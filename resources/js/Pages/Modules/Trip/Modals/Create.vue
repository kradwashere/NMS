<template>
    <b-modal v-model="showModal" title="New Trip" header-class="p-3 bg-light" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>    
        <b-form class="customform mb-2">
            <div class="row customerform">
                
                <div class="col-md-12 mt-4">
                    <label>Boat: <span v-if="form.errors" v-text="form.errors.boat_id" class="haveerror"></span></label>
                    <multiselect v-model="trip.boat" id="ajax" label="name" track-by="id"
                        placeholder="Select Boat" open-direction="bottom" :options="boats"
                        :allow-empty="false"
                        :show-labels="false">
                    </multiselect> 
                </div>
                <div class="col-sm-12 mt-2">
                    <label>Date: <span v-if="form.errors" v-text="form.errors.date" class="haveerror"></span></label>
                    <date-picker
                        v-model:value="trip.date"
                        type="date" format="YYYY-MM-DD"
                        lang="en"
                        :disabled-date="disabledDate"
                        placeholder="Select Date"
                        >
                    </date-picker>
                </div>
                <div class="col-sm-12">
                    <hr class="text-muted"/>
                </div>
                <div class="col-md-12 mt-2">
                    <textarea v-model="trip.note" class="form-control" maxlength="225" rows="2" placeholder="Notes.."></textarea>
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
import DatePicker from 'vue-datepicker-next';
import 'vue-datepicker-next/index.css';
import Multiselect from '@suadelabs/vue3-multiselect';
export default {
    components: { Multiselect, DatePicker },
    props: ['boats'],
    data(){
        return {
            currentUrl: window.location.origin,
            showModal: false,
            editable: false,
            trip: {
                date: '',
                note: '',
                boat: ''
            },
            form: {}
        }
    },
    watch : {
        data: {
            deep: true,
            handler(val = null) {
                if(val != null && val !== ''){
                   
                }
            },
        },
    },
    computed: {
        data() {
            return this.$page.props.flash.data;
        },
    },
    methods : {
        show() {
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
                boat_id: this.trip.boat.id,
                date: (this.trip.date != '') ? new Date(this.trip.date).toLocaleDateString("af-ZA") : '',
                note: this.trip.note,
                editable: this.editable
            })

            this.form.post('/trips',{
                preserveScroll: true,
                onSuccess: (response) => {
                    this.hide();
                },
            });
        },
        hide(){
            this.showModal = false;
        },
        disabledDate(date) {
            return date < new Date();
        },
    }
}
</script>
<style>
.multiselect__single {
    font-size: 12px;
}
.dropdown-menu-lg {
    width: 95%;
}
</style>
