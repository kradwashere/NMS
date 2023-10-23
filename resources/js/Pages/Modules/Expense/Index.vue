<template>
<Head title="Expenses" />
    <b-row class="dash-nft">
        <b-col xxl="9">
            <b-row>
                <b-col xxl="12">
                    <b-card>
                        <b-card-body style="height: calc(100vh - 212px)">

                            <b-row class="g-2 mb-2 mt-n1">
                                <b-col lg>
                                    <div class="input-group mb-1">
                                        <span class="input-group-text"> <i class="ri-search-line search-icon"></i></span>
                                        <input type="text" v-model="keyword" placeholder="Search Expense" class="form-control" style="width: 50%;">
                                        <span @click="refresh" class="input-group-text" v-b-tooltip.hover title="Refresh" style="cursor: pointer;"> 
                                            <i class="bx bx-refresh search-icon"></i>
                                        </span>
                                        <b-button @click="create()" type="button" variant="primary">
                                            <i class="ri-add-circle-fill align-bottom me-1"></i> New Expense
                                        </b-button>
                                    </div>
                                </b-col>
                            </b-row>

                            <div class="table-responsive">
                                <table class="table table-nowrap align-middle mb-0">
                                    <thead class="table-light">
                                        <tr class="fs-11">
                                            <th style="width: 5%;"></th>
                                            <th style="width: 25%;">Name</th>
                                            <th style="width: 15%;" class="text-center">Amount</th>
                                            <th style="width: 15%;" class="text-center">Date Created</th>
                                            <th style="width: 10%;"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(list,index) in lists" v-bind:key="index">
                                            <td>{{index+1}}</td>
                                            <td><h5 class="fs-13 mb-0 text-dark">{{list.name.name}}</h5></td>
                                            <td class="text-center">{{formatMoney(list.amount)}}</td>
                                            <td class="text-center">{{list.created_at}}</td>
                                            <td class="text-end">
                                                <b-button @click="edit(list)" variant="soft-warning" v-b-tooltip.hover title="Edit Loan" size="sm" class="edit-list me-1"><i class="ri-ball-pen-line"></i> </b-button>
                                                <b-button v-if="!is_paid" @click="pay(list)" variant="soft-primary" v-b-tooltip.hover title="View" size="sm" class="remove-list me-1"><i class="ri-eye-fill align-bottom"></i></b-button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <Pagination class="ms-2 me-2" v-if="meta" @fetch="fetch" :lists="lists.length" :links="links" :pagination="meta" />
                            </div>

                        </b-card-body>
                    </b-card>
                </b-col>
            </b-row>
        </b-col>

        <b-col xxl="3">
            <b-card>
                <b-card-body style="height: calc(100vh - 212px); overflow: auto;">
                    
                </b-card-body>
            </b-card>
        </b-col>
    </b-row>
    <Create :types="types" @message="fetch()" ref="create"/>
    <Pay ref="pay" @message="fetch()"/>
</template>
<script>
import Pay from './Modals/Pay.vue';
import Create from './Modals/Create.vue';
import Pagination from "@/Shared/Components/Pagination.vue";
export default {
    props: ['dropdowns','breakdown','top'],
    components : { Pagination, Create, Pay },
    data(){
        return {
            currentUrl: window.location.origin,
            lists: [],
            meta: {},
            links: {},
            keyword: null,
        }
    }, 
    computed: {
        types : function() {
            return this.dropdowns.filter(x => x.is_expense == 1);
        },
    },
    created(){
        this.fetch();
    },
    watch: {
        keyword(newVal){
            this.checkSearchStr(newVal);
        }
    },
    methods: {
        checkSearchStr: _.debounce(function(string) {
            this.fetch();
        }, 300),
        fetch(page_url) {
            page_url = page_url || '/expenses';
            axios.get(page_url, {
                params: {
                    keyword: this.keyword,
                    counts: parseInt(((window.innerHeight-380)/53)),
                    options: 'lists',
                }
            })
            .then(response => {
                this.lists = response.data.data;
                this.meta = response.data.meta;
                this.links = response.data.links;
            })
            .catch(err => console.log(err));
        },
        create(){
            this.$refs.create.show();
        },
        pay(data){
            this.$refs.pay.show(data);
        },
        formatMoney(value) {
            let val = (value/1).toFixed(2).replace(',', '.')
            return '₱'+val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        },
    }
}
</script>