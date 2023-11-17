<template>
    <b-modal v-model="showModal" title="New Sales" size="lg" header-class="p-3 bg-light" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>    
        <b-form class="customform mb-2">
            <div class="row customerform">
                
                <div class="col-md-8 mt-4">
                   <form class="app-search d-none d-md-block p-0 mb-2">
                        <div class="position-relative">
                            <input type="text" class="form-control" placeholder="Search Buyer" autocomplete="off" id="search-options1" />
                            <span class="mdi mdi-magnify search-widget-icon"></span>
                            <span class="mdi mdi-close-circle search-widget-icon search-widget-icon-close d-none" id="search-close-options1"></span>
                        </div>
                        <div class="dropdown-menu dropdown-menu-lg" id="search-dropdown1">
                            <SimpleBar data-simplebar
                                style="max-height: height: calc(100vh/2 - 326px)">
                                <div class="notification-list" v-if="names.length > 0">
                                    <b-link @click="select(list)"
                                        class="d-flex dropdown-item notify-item py-2"
                                        v-for="(list, index) of names" :key="index">
                                        <div class="flex-1">
                                            <h6 class="m-0">{{list.name}}</h6>
                                        </div>
                                    </b-link>
                                </div>
                                <div class="notification-list" v-else>
                                    <div class="d-grid gap-2">
                                        <button class="btn btn-primary btn-sm" @click="newName()"
                                            type="button" block="">
                                            <div class="btn-content">Add name</div>
                                        </button>
                                    </div>
                                </div>
                            </SimpleBar>
                        </div>
                    </form>
                    <template v-if="name">
                        <hr class="text-muted"/>
                        <ul class="list-unstyled mb-0 vstack  gap-3">
                            <li>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0"><img
                                            :src="currentUrl+'/images/avatars/avatar.jpg'"
                                            alt="" class="avatar-sm rounded"></div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="fs-14 mb-1">{{name.name}}</h6>
                                        <p class="text-muted mb-0">{{name.subtype.name}}</p>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </template>
                </div>
                <div class="col-md-4 mt-4">
                   <form class="app-search  p-0 mb-2">
                        <Amount @amount="amount" ref="testing" :readonly="true" style="padding-left: 10px;"/>
                    </form>
                </div>
                <div class="col-sm-12 mt-2">
                    <hr class="text-muted"/>
                </div>
                <div class="col-sm-12 mt-1">
                     <b-row class="mt-n3">
                        <div class="col-md-6">
                            <select v-model="carrier" style="width: 170px;" class="form-select form-select-sm mt-1">
                                <option :value="null" disabled>Select Carrier</option>
                                <option :value="carrier" v-for="(carrier,index) in carriers" v-bind:key="index">{{carrier.order}} trip</option>
                            </select>
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
                <table class="table align-middle mt-2">
                    <thead class="table-light fs-11">
                        <tr>
                            <th width="5%"></th>
                            <th class="text-center" width="10%">Qnty</th>
                            <th class="text-center" width="35%">Type</th>
                            <th class="text-center" width="25%">Amount</th>
                            <th class="text-center" width="25%">Total</th>
                        </tr>
                    </thead>
                </table>
                <table class="table table-borderless align-middle mt-n3">
                    <tbody>
                        <tr v-for="(tub, index) in carrier.sales" v-bind:key="'a-'+index" class="mb-n4" style="display: block;">
                            <td class="text-end" width="5%">
                                <b-button @click="rmv(index)" variant="soft-danger" v-b-tooltip.hover title="Remove" class="edit-list btn-sm mt-n2">
                                    <i class="ri-delete-bin-5-line align-bottom"></i> 
                                </b-button>
                            </td>
                            <td class="text-center" width="10%">
                                <input :style="(form.errors && form.errors[`tubs.${index}.quantity`]) ? 'color: red':''" type="text" class="form-control form-control-sm" v-model="tub.quantity" placeholder="Quantity" required>
                            </td>
                            <td class="text-center" width="35%">
                                <select :style="(form.errors && form.errors[`tubs.${index}.type`]) ? 'color: red':''" v-model="tub.type" class="form-select form-select-sm mt-n1">
                                    <option :value="null" disabled>Select fish</option>
                                    <option :value="type.id" v-for="(type,index) in selectedFishes" v-bind:key="index" :disabled="isTypeSelected(type.id)">{{type.name}}</option>
                                </select>
                            </td>
                            <td class="text-center" width="25%">
                                <Amount @amount="handleAmount" :index="index" :size="'form-control-sm'" ref="testing" :readonly="true"/>
                            </td>
                            <td width="25%" class="text-end">
                                <input type="text" readonly class="form-control form-control-sm" :value="formatMoney(carrier.sales[index].quantity * carrier.sales[index].amount)" placeholder="Amount" required>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </b-form>

        {{carrier}}
        <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Cancel</b-button>
            <b-button @click="create('ok')" variant="primary" :disabled="form.processing" block>Save</b-button>
        </template>
    </b-modal>
    <New :types="types" ref="new"/>
</template>
<script>
import New from './New.vue';
import Amount from "@/Shared/Components/Amount.vue";
import { SimpleBar } from "simplebar-vue3";
import Multiselect from '@suadelabs/vue3-multiselect';
export default {
    components: { Multiselect, SimpleBar, Amount, New },
    props: ['types'],
    data(){
        return {
            currentUrl: window.location.origin,
            showModal: false,
            id: '',
            name: '',
            trip: '',
            type: '',
            note: '',
            amount1: '',
            form: {},
            names: [],
            editable: false,
            carrier: {
                carrier: null,
                tubs: [{type: null,quantity: 0,amount: 0}],
                sales: [{type: null,quantity: 0,amount: 0}]
            },
            carriers: []
        }
    },
    watch : {
        data: {
            deep: true,
            handler(val = null) {
                if(val != null && val !== ''){
                    if(this.status == 'name'){
                        this.name = val.data;
                    }else{

                    }
                }
            },
        },
    },
    computed: {
        data() {
            return this.$page.props.flash.data;
        },
    },
    mounted() {
        this.isCustomDropdown();
    },
    methods : {
        show(carriers) {
            if(carriers.length > 0){
                this.carriers = carriers;
                this.carrier = this.carriers[this.carriers.length-1];
            }
            this.id = '';
            this.name = '';
            this.amount1 = '';
            this.type = '';
            this.amount(0);
            this.editable = false;
            this.showModal = true;
        },

        create(){
            this.status = 'create';
            this.form = this.$inertia.form({
                id: this.id,
                name_id: this.name.id,
                trip_id: this.trip.id,
                amount: this.amount1,
                note: this.note,
                editable: this.editable
            })

            this.form.post('/expenses',{
                preserveScroll: true,
                onSuccess: (response) => {
                    this.hide();
                },
            });
        },
        hide(){
            this.$emit('message',true);
            var searchInput = document.getElementById("search-options1");
            searchInput.value = '';
            // this.$refs.testing.empty();
            this.showModal = false;
        },
        checkSearchStr: _.debounce(function (string) {
            this.keyword = string;
            this.fetch();
        }, 300),
        fetch(page_url) {
            page_url = page_url || '/names';
            axios.get(page_url, {
                params: {
                    keyword: this.keyword,
                    options: 'search',
                    type: 'Buyer'
                }
            })
            .then(response => {
                if (response) {
                    this.names = response.data.data;
                }
            })
            .catch(err => console.log(err));
        },
        newName(){
            this.status = 'name';
            this.$refs.new.show(this.keyword);
        },
        select(data){
            this.name = data;
            this.type = data.subtype;
        },
        amount(val){
            this.amount1 = val;
        },
        add(){
            this.carrier.sales.push({type: null,amount: 0,quantity: 0})
        },
        rmv(index){
            this.carrier.sales.splice(index,1);
        },
        isCustomDropdown() {
            var searchOptions = document.getElementById("search-close-options1");
            var dropdown = document.getElementById("search-dropdown1");
            var searchInput = document.getElementById("search-options1");

            searchInput.addEventListener("focus", () => {
                var inputLength = searchInput.value.length;
                if (inputLength > 0) {
                    dropdown.classList.add("show");
                    searchOptions.classList.remove("d-none");
                } else {
                    dropdown.classList.remove("show");
                    searchOptions.classList.add("d-none");
                }
            });

            searchInput.addEventListener("keyup", () => {
                var inputLength = searchInput.value.length;
                if (inputLength > 0) {
                    dropdown.classList.add("show");
                    searchOptions.classList.remove("d-none");
                    this.checkSearchStr(searchInput.value);
                } else {
                    dropdown.classList.remove("show");
                    searchOptions.classList.add("d-none");
                }
            });

            searchOptions.addEventListener("click", () => {
                searchInput.value = "";
                dropdown.classList.remove("show");
                searchOptions.classList.add("d-none");
            });

            document.body.addEventListener("click", (e) => {
                if (e.target.getAttribute("id") !== "search-options1") {
                    dropdown.classList.remove("show");
                    searchOptions.classList.add("d-none");
                }
            });
        },
          formatMoney(value) {
            let val = (value/1).toFixed(2).replace(',', '.')
            return '₱'+val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        },
        isTypeSelected(typeId) {
            return this.carrier.tubs.slice(0, -1).some(item => item.type === typeId);
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
