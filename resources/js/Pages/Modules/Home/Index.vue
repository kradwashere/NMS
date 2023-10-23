<template>
    <Head title="Dashboard" />
    <PageHeader :title="title" :items="items" />
    <b-row>
        <b-col xxl="12">
            <b-card>
                <b-card-body style="height: 180px;">
                    <template v-if="trip">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <h4>{{trip.code}}</h4>
                                <div class="hstack gap-3 flex-wrap">
                                    <div><a class="text-primary d-block" href="#" target="_self">{{trip.boat.name}}</a></div>
                                    <div class="vr"></div>
                                    <div class="text-muted"> Date : <span class="text-body fw-medium">{{trip.date}}</span></div>
                                    <div class="vr"></div>
                                    <div class="text-muted"> Status : <span class="text-body fw-medium">26 Mar, 2021</span></div>
                                </div>
                            </div>
                            <div class="flex-shrink-0">
                                <div>
                                    <button class="btn btn-light"><i class="ri-pencil-fill align-bottom"></i></button>
                                </div>
                            </div>
                        </div>
                        <hr class="text-muted"/>
                        <div class="row mt-4">
                            <div class="col-sm-6 col-lg-3">
                                <div class="p-2 border border-dashed rounded">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm me-2">
                                            <div class="avatar-title rounded bg-transparent text-success fs-24"><i
                                                    class="ri-money-dollar-circle-fill"></i></div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <p class="text-muted mb-1">Total Expenses :</p>
                                            <h5 class="mb-0">$120.40</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <div class="p-2 border border-dashed rounded">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm me-2">
                                            <div class="avatar-title rounded bg-transparent text-success fs-24"><i
                                                    class="ri-file-copy-2-fill"></i></div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <p class="text-muted mb-1">No. of Orders :</p>
                                            <h5 class="mb-0">2,234</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <div class="p-2 border border-dashed rounded">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm me-2">
                                            <div class="avatar-title rounded bg-transparent text-success fs-24"><i class="ri-stack-fill"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <p class="text-muted mb-1">Available Stocks :</p>
                                            <h5 class="mb-0">1,230</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <div class="p-2 border border-dashed rounded">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm me-2">
                                            <div class="avatar-title rounded bg-transparent text-success fs-24"><i
                                                    class="ri-inbox-archive-fill"></i></div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <p class="text-muted mb-1">Total Revenue :</p>
                                            <h5 class="mb-0">$60,645</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                    <template v-else>
                    </template>
                </b-card-body>
            </b-card>
        </b-col>

        <b-col class="col-md-4">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h5 class="card-title mb-0 flex-grow-1">Expenses</h5>
                    <div>
                        <button class="btn btn-soft-primary btn-sm" type="button">
                            <div @click="expense()" class="btn-content"> Add Expense </div>
                        </button>
                    </div>
                </div>
                <div class="card-body" style="height: calc(100vh - 530px)">
                    <div class="table-responsive table-card">
                        <table class="table align-middle table-centered table-nowrap mb-1">
                            <thead class="text-muted table-light fs-11">
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="30%">Expense</th>
                                    <th width="28%" class="text-center">Date</th>
                                    <th width="28%" class="text-center">Amount</th>
                                    <th width="9%"></th>
                                </tr>
                            </thead>
                        </table>
                         <table class="table align-middle table-centered table-nowrap">
                            <tbody>
                                <tr v-for="(list,index) in trip.expenses" v-bind:key="index" class="fs-11">
                                    <td width="5%">{{index + 1}}</td>
                                    <td width="30%">
                                        <h5 class="fs-12 mb-0 text-dark">{{list.name.name}}</h5>
                                        <p class="fs-11 text-muted mb-0">{{list.name.subtype.name}}</p>

                                    </td>
                                    <td width="28%" class="text-center">{{list.created_at}}</td>
                                    <td width="28%" class="text-center">{{formatMoney(list.amount)}} </td>
                                    <td width="9%">
                                        <button class="btn btn-soft-primary btn-sm ms-0 mt-0 me-9 mb-0" type="button">
                                            <div class="btn-content"><i class="ri-eye-fill align-bottom"></i></div>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                         </table>
                    </div>
                </div>
            </div>
        </b-col>

        <b-col class="col-md-4">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h5 class="card-title mb-0 flex-grow-1">Carriers</h5>
                    <div>
                        <button class="btn btn-soft-primary btn-sm" type="button">
                            <div @click="carrier()" class="btn-content"> Create Carrier </div>
                        </button>
                    </div>
                </div>
                <div class="card-body" style="height: calc(100vh - 530px)">
                    <div class="table-responsive table-card">
                       
                    </div>
                </div>
            </div>
        </b-col>

        <b-col class="col-md-4">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h5 class="card-title mb-0 flex-grow-1">Sold</h5>
                    <div>
                        <button class="btn btn-soft-primary btn-sm" type="button">
                            <div class="btn-content"> View all </div>
                        </button>
                    </div>
                </div>
                <div class="card-body" style="height: calc(100vh - 530px)">
                    <div class="table-responsive table-card">
                        
                    </div>
                </div>
            </div>
        </b-col>
    </b-row>
    <Expense :types="types" ref="expense"/>
    <Carrier :fishes="fishes" :carriers="carriers" ref="carrier"/>
</template>
<script>
import Carrier from '../Trip/Modals/Carrier.vue';
import Expense from '../Expense/Modals/Create.vue';
import PageHeader from "@/Shared/Components/PageHeader.vue";
export default {
    components: { PageHeader, Expense, Carrier },
    props: ['trip','dropdowns','carriers','fishes'],
    data() {
        return {
            title: "Dashboard",
            items: [{text: "View",href: "/"},{ text: "Dasboard",active: true},
            ],
        };
    },
    computed: {
        types : function() {
            return this.dropdowns.filter(x => x.is_expense == 1);
        },
    },
    methods: {
        expense(){
            this.$refs.expense.set(this.trip);
        },
        carrier(){
            this.$refs.carrier.show(this.trip);
        },
        formatMoney(value) {
            let val = (value/1).toFixed(2).replace(',', '.')
            return '₱'+val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        },
    }
}
</script>
