<template>
<Head title="Cash Loan" />
    <b-row class="dash-nft">
        <b-col xxl="9">
            <b-row class="g-3">
                <b-col xl="6">
                    <b-card no-body class="overflow-hidden">
                        <b-card-body class="bg-marketplace d-flex" style="height: 146px;">
                            <div class="flex-grow-1">
                                <h4 class="fs-18 lh-base fw-bold mb-0">Discover, Collect, Sell and Create <br> your
                                    own <span class="text-success">NFTs.</span> </h4>
                                <div class="d-flex gap-3 mt-4">
                                    <b-link href="" class="btn btn-primary">Discover Now </b-link>
                                    <b-link @click="create()" href="" class="btn btn-success">Create Your Own</b-link>
                                </div>
                            </div>
                            <img src="assets/images/bg-d.png" alt="" class="img-fluid" />
                        </b-card-body>
                    </b-card>
                </b-col>
                <b-col xl="3" md="6" v-for="(list,index) in breakdown" v-bind:key="index">
                    <b-card no-body class="card-height-80">
                        <b-card-body>
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm flex-shrink-0">
                                    <span :class="'avatar-title bg-soft-'+list.color+' rounded fs-3'">
                                        <i :class="list.icon+' text-'+list.color"></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1 ps-3">
                                    <h5 class="text-muted text-uppercase fs-13 mb-0">{{list.title}}</h5>
                                </div>
                            </div>
                            <div class="mt-2 pt-1">
                                <h4 class="fs-22 fw-semibold ff-secondary mb-0">
                                    {{formatMoney(list.total)}}
                                </h4>
                                <p class="mt-2 mb-0 text-muted">
                                    <b-badge :variant="'soft-'+list.color" :class="'text-'+list.color+' mb-0 me-1'"> 
                                         {{list.count}}  <i class="ri-user-3-line  align-middle"></i>
                                    </b-badge> <span class="fs-10">{{list.text}}</span>
                                </p>
                            </div>
                        </b-card-body>
                    </b-card>
                </b-col>
            </b-row>

            <b-row>
                <b-col xxl="12">
                    <b-card>
                        <b-card-body style="height: calc(100vh - 382px)">

                            <b-row class="g-2 mb-2 mt-n1">
                                <b-col lg>
                                    <div class="input-group mb-1">
                                        <span class="input-group-text"> <i class="ri-search-line search-icon"></i></span>
                                        <input type="text" v-model="keyword" placeholder="Search Loan" class="form-control" style="width: 50%;">
                                        <span @click="refresh" class="input-group-text" v-b-tooltip.hover title="Refresh" style="cursor: pointer;"> 
                                            <i class="bx bx-refresh search-icon"></i>
                                        </span>
                                        <b-button @click="create()" type="button" variant="primary">
                                            <i class="ri-add-circle-fill align-bottom me-1"></i> New Loan
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
                                            <th style="width: 15%;" class="text-center">Status</th>
                                            <th style="width: 15%;" class="text-center">Date Loan</th>
                                            <th style="width: 15%;" class="text-center">Date Paid</th>
                                            <th style="width: 10%;"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(list,index) in lists" v-bind:key="index">
                                            <td>{{index+1}}</td>
                                            <td><h5 class="fs-13 mb-0 text-dark">{{list.name.name}}</h5></td>
                                            <td class="text-center">{{formatMoney(list.amount)}}</td>
                                            <td class="text-center">
                                                <b-badge v-if="list.is_paid" variant="success">Paid</b-badge>
                                                <b-badge v-else variant="danger">Unpaid</b-badge>
                                            </td>
                                            <td class="text-center">{{list.created_at}}</td>
                                            <td class="text-center">{{(list.is_paid) ? list.updated_at : '-'}}</td>
                                            <td class="text-end">
                                                <b-button @click="edit(list)" variant="soft-warning" v-b-tooltip.hover title="Edit Loan" size="sm" class="edit-list me-1"><i class="ri-ball-pen-line"></i> </b-button>
                                                <b-button v-if="!is_paid" @click="pay(list)" variant="soft-primary" v-b-tooltip.hover title="Pay Now" size="sm" class="remove-list me-1"><i class="ri-hand-heart-fill align-bottom"></i></b-button>
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
                    <h6 class="text-muted mb-3 text-uppercase fw-semibold"> Top 5 Paid </h6>
                    <div class="table-responsive">
                        <table class="table table-nowrap align-middle mb-0">
                            <thead class="table-light">
                                <tr class="fs-11">
                                    <th style="width: 5%;">#</th>
                                    <th style="width: 45%;">Name</th>
                                    <th style="width: 25%;" class="text-center">Loan Count</th>
                                    <th style="width: 25%;" class="text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody class="fs-11">
                                <tr v-for="(list,index) in top.paid" v-bind:key="index">
                                    <td>{{index+1}}</td>
                                    <td><h5 class="fs-11 mb-0 text-dark">{{list.name.name}}</h5></td>
                                    <td class="text-center">{{list.paid_loan_count}}</td>
                                    <td class="text-end">{{formatMoney(list.paid_total_amount)}}</td>
                                    
                                </tr>
                            </tbody>
                        </table>
                    </div>


                    <h6 class="text-muted mt-4 mb-3 text-uppercase fw-semibold"> Top 5 Unpaid </h6>
                    <div class="table-responsive">
                        <table class="table table-nowrap align-middle mb-0">
                            <thead class="table-light">
                                <tr class="fs-11">
                                    <th style="width: 5%;">#</th>
                                    <th style="width: 45%;">Name</th>
                                    <th style="width: 25%;" class="text-center">Loan Count</th>
                                    <th style="width: 25%;" class="text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody class="fs-11">
                                <tr v-for="(list,index) in top.unpaid" v-bind:key="index">
                                    <td>{{index+1}}</td>
                                    <td><h5 class="fs-11 mb-0 text-dark">{{list.name.name}}</h5></td>
                                    <td class="text-center">{{list.unpaid_loan_count}}</td>
                                    <td class="text-end">{{formatMoney(list.unpaid_total_amount)}}</td>
                                    
                                </tr>
                            </tbody>
                        </table>
                    </div>
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
            return this.dropdowns.filter(x => x.is_loanable == 1);
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
            page_url = page_url || '/loans';
            axios.get(page_url, {
                params: {
                    keyword: this.keyword,
                    counts: parseInt(((window.innerHeight-550)/53)),
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