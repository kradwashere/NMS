<template>
    <b-modal v-model="showModal" title="New Expense" header-class="p-3 bg-light" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>    
        <b-form class="customform mb-2">
            <div class="row customerform">
                
                <div class="col-md-12 mt-4">
                   <form class="app-search d-none d-md-block p-0 mb-2">
                        <div class="position-relative">
                            <input type="text" class="form-control" placeholder="Search Expense" autocomplete="off" id="search-options" />
                            <span class="mdi mdi-magnify search-widget-icon"></span>
                            <span class="mdi mdi-close-circle search-widget-icon search-widget-icon-close d-none" id="search-close-options"></span>
                        </div>
                        <div class="dropdown-menu dropdown-menu-lg" id="search-dropdown">
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
                <div class="col-sm-12">
                    <hr class="text-muted"/>
                </div>
                <div class="col-md-12">
                    <div class="form-group mt-2">
                        <label>Amount: <span v-if="form.errors" v-text="form.errors.amount" class="haveerror"></span></label>
                        <Amount @amount="amount" ref="testing" :readonly="false"/>
                    </div>
                </div>
                <div class="col-md-12 mt-2">
                    <textarea v-model="note" class="form-control" maxlength="225" rows="2" placeholder="Notes.."></textarea>
                </div>
            </div>
        </b-form>
        <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Cancel</b-button>
            <b-button @click="create('ok')" variant="primary" :disabled="form.processing" block>Save</b-button>
        </template>
    </b-modal>
    <New :types="types" ref="new"/>
</template>
<script>
import New from '../Modals/New.vue';
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
            money: {
                decimal: '.',
                thousands: ',',
                prefix: '₱ ',
                precision: 2,
                masked: false
            },
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
        show() {
            this.id = '';
            this.name = '';
            this.amount1 = '';
            this.type = '';
            this.amount(0);
            this.editable = false;
            this.showModal = true;
        },
        set(trip) {
            this.id = '';
            this.name = '';
            this.amount1 = '';
            this.type = '';
            this.amount(0);
            this.trip = trip;
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
            var searchInput = document.getElementById("search-options");
            searchInput.value = '';
            this.$refs.testing.empty();
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
                    type: 'Expense'
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
        isCustomDropdown() {
            var searchOptions = document.getElementById("search-close-options");
            var dropdown = document.getElementById("search-dropdown");
            var searchInput = document.getElementById("search-options");

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
                if (e.target.getAttribute("id") !== "search-options") {
                    dropdown.classList.remove("show");
                    searchOptions.classList.add("d-none");
                }
            });
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
