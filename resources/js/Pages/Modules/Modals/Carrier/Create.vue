<template>
    <b-modal v-model="showModal" title="New Carrier" size="lg" header-class="p-3 bg-light" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>    
        <b-form class="customform mb-2">
            <div class="row customerform">
                
                <div class="col-md-12 mt-0">
                    <label>Carrier: <span v-if="form.errors" v-text="form.errors.carrier_id" class="haveerror"></span></label>
                    <multiselect v-model="carrier.carrier" id="ajax" label="name" track-by="id"
                        placeholder="Select Carrier" open-direction="bottom" :options="carriers"
                        :allow-empty="false"
                        :show-labels="false">
                    </multiselect> 
                </div>
                <div class="col-sm-12 mt-2">
                    <hr class="text-muted"/>
                </div>
               
                <div class="col-sm-12 mt-1">
                     <b-row class="mt-n3">
                        <div class="col-md-6">
                            <div class="page-title-left mt-2">
                                <ol class="breadcrumb m-0 fs-13">
                                    <li class="breadcrumb-item text-primary fw-semibold">List of Tubs</li>
                                </ol>
                            </div> 
                        </div>
                        <div class="col-md-6">
                            <div class="hstack float-end gap-2 mt-4 mt-sm-0">
                                <button @click="add()" class="btn btn-primary btn-sm btn-label mt-1" type="button">
                                    <div class="btn-content"><i class="ri-add-circle-fill label-icon align-middle fs-12 me-2"></i>Add Tub</div>
                                </button>
                            </div>
                        </div>
                    </b-row>
                </div>
                <div class="col-sm-12 mt-n2">
                    <hr class="text-muted"/>
                </div>
                <div class="col-sm-12 mt-n2">
                    <div class="row">
                         <div class="col-sm-12 mt-n2">

                         <table class="table align-middle mt-2">
                            <thead class="table-light fs-11">
                               <tr>
                                    <th width="5%"></th>
                                    <th class="text-center" width="35%">Type</th>
                                    <th class="text-center" width="10%">Qnty</th>
                                    <th class="text-center" width="25%">Amount</th>
                                    <th class="text-center" width="25%">Total</th>
                                </tr>
                            </thead>
                         </table>
                         <table class="table table-borderless align-middle mt-n3">
                            <tbody>
                                <tr v-for="(tub, index) in carrier.tubs" v-bind:key="'a-'+index" class="mb-n4" style="display: block;">
                                    <td class="text-end" width="5%">
                                        <b-button @click="rmv(index)" variant="soft-danger" v-b-tooltip.hover title="Remove" class="edit-list btn-sm mt-n2">
                                            <i class="ri-delete-bin-5-line align-bottom"></i> 
                                        </b-button>
                                    </td>
                                    <td class="text-center" width="35%">
                                        <select @change="check('type',index)" :style="(form.errors && form.errors[`tubs.${index}.type`]) ? 'color: red':''" v-model="tub.type" class="form-select form-select-sm mt-n1">
                                            <option :value="null" disabled>Select fish</option>
                                            <option :value="type.id" v-for="(type,index) in selectedFishes" v-bind:key="index" :disabled="isTypeSelected(type.id)">{{type.name}}</option>
                                        </select>
                                    </td>
                                    <td class="text-center" width="10%">
                                        <input @change="check('quantity',index)" :style="(form.errors && form.errors[`tubs.${index}.quantity`]) ? 'color: red':''" type="text" class="form-control form-control-sm" v-model="tub.quantity" placeholder="Quantity" required>
                                    </td>
                                    <td class="text-center" width="25%">
                                        <Amount @change="check('amount',index)" :style="(form.errors && form.errors[`tubs.${index}.amount`]) ? 'color: red':''" @amount="handleAmount" :index="index" :size="'form-control-sm'" ref="testing" :readonly="false"/>
                                        <!-- <input type="text" class="form-control form-control-sm" v-model="tub.amount" placeholder="Amount" required> -->
                                    </td>
                                    <td width="25%" class="text-end">
                                        <input type="text" readonly class="form-control form-control-sm" :value="formatMoney(carrier.tubs[index].quantity * carrier.tubs[index].amount)" placeholder="Amount" required>
                                    </td>
                                </tr>
                            </tbody>
                         </table>
                         </div>
                    </div>
                </div>

                <!-- <div class="col-sm-12">
                    <hr class="text-muted"/>
                </div>
               
                <div class="col-md-12 mt-2">
                    <textarea v-model="carrier.note" class="form-control" maxlength="225" rows="2" placeholder="Notes.."></textarea>
                </div> -->
            </div>
        </b-form>
        <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Cancel</b-button>
            <b-button @click="create('ok')" variant="primary" :disabled="form.processing" block>Save</b-button>
        </template>
    </b-modal>
</template>
<script>
import Amount from "@/Shared/Components/Amount.vue";
import DatePicker from 'vue-datepicker-next';
import 'vue-datepicker-next/index.css';
import Multiselect from '@suadelabs/vue3-multiselect';
export default {
    components: { Multiselect, DatePicker, Amount },
    props: ['carriers','fishes'],
    data(){
        return {
            currentUrl: window.location.origin,
            showModal: false,
            editable: false,
            carrier: {
                carrier: '',
                note: '',
                trip: '',
                tubs: [{type: null,quantity: 0,amount: 0}]
            },
            form: {},
            selectedFishes: this.fishes
        }
    },
    methods : {
        show(trip) {
            this.showModal = true;
            this.carrier.trip = trip;
        },
        edit(data){
            this.id = data.id;
            this.carrier = data.name;
            this.type = data.type
            this.editable = true;
            this.showModal = true;
        },
        create(){
            this.form = this.$inertia.form({
                id: this.id,
                trip_id: this.carrier.trip.id,
                carrier_id: this.carrier.carrier.id,
                total: this.totalAmount(),
                tubs: this.carrier.tubs,
                editable: this.editable
            })

            this.form.post('/carriers',{
                preserveScroll: true,
                onSuccess: (response) => {
                    this.hide();
                },
            });
        },
        hide(){
            this.showModal = false;
        },
        add(){
            this.carrier.tubs.push({type: null,amount: 0,quantity: 0})
        },
        rmv(index){
            this.carrier.tubs.splice(index,1);
        },
        handleAmount(val){
            this.carrier.tubs[val[1]].amount = val[0].replace('₱ ', '').replace(/,/g, '');
        },
        formatMoney(value) {
            let val = (value/1).toFixed(2).replace(',', '.')
            return '₱'+val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        },
        isTypeSelected(typeId) {
            return this.carrier.tubs.slice(0, -1).some(item => item.type === typeId);
        },
        check(data,index){
            if(this.form.errors){
                if(data == 'type'){
                    this.form.errors[`tubs.${index}.type`] = '';
                }else if(data == 'quantity'){
                    this.form.errors[`tubs.${index}.quantity`] = '';
                }else{
                    this.form.errors[`tubs.${index}.amount`] = '';
                }
            }
        },
        totalAmount() {
            return this.carrier.tubs.reduce((total, item) => total + parseFloat((item.amount*item.quantity)), 0);
        }
    }
}
</script>
<style>
.multiselect__single {
    font-size: 12px;
}
.multiselect__tags {
    border: 0;
    min-height: 37px;
    height: 37px;
} 
.dropdown-menu-lg {
    width: 95%;
}
td input {
    text-align: center;
}
</style>
