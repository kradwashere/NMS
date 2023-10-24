<template>
    <Head title="Dashboard" />
    <PageHeader :title="title" :items="items" />
    <b-row>
        <b-col xxl="12">
            <b-card>
                <b-card-body style="height: 80px;">
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
                    </template>
                    <template v-else>
                    </template>
                </b-card-body>
            </b-card>
        </b-col>

        <b-col class="col-md-4">
             <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-light text-primary rounded-circle fs-3">
                                <i class="ri-hand-coin-fill align-middle"></i>
                            </span>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="text-uppercase fw-semibold fs-12 text-muted mb-1">Total Expenses</p>
                            <h4 class="mb-0">{{formatMoney(total(trip.expenses))}}</h4>
                        </div>
                        <div class="flex-shrink-0 align-self-end">
                            <span class="badge bg-success-subtle text-success">
                                <i class="ri-arrow-up-s-fill align-middle me-1"></i> 6.24 %
                            </span>
                        </div>
                    </div>
                </div>
            </div>
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
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-light text-primary rounded-circle fs-3">
                                <i class="ri-wallet-3-fill align-middle"></i>
                            </span>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="text-uppercase fw-semibold fs-12 text-muted mb-1">Merchandise Inventory</p>
                            <h4 class="mb-0">{{formatMoney(total(trip.carriers))}}</h4>
                        </div>
                        <div class="flex-shrink-0 align-self-end">
                            <span class="badge bg-success-subtle text-success">
                                <i class="ri-arrow-up-s-fill align-middle me-1"></i> 6.24 %
                            </span>
                        </div>
                    </div>
                </div>
            </div>
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
                        <table class="table align-middle table-centered table-nowrap">
                             <thead class="text-muted table-light fs-11">
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="30%">Carrier</th>
                                    <th width="28%" class="text-center">Tubs</th>
                                    <th width="28%" class="text-center">Total</th>
                                    <th width="9%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(list,index) in trip.carriers" v-bind:key="index" class="fs-11">
                                    <td>{{index + 1}}</td>
                                    <td>
                                        <h5 class="fs-12 mb-0 text-dark">{{list.name.name}}</h5>
                                        <p class="fs-11 text-muted mb-0">{{list.order}} trip</p>

                                    </td>
                                    <td class="text-center">0 of {{totalCount(list.tubs)}} sold</td>
                                    <td class="text-center">{{formatMoney(list.total)}} </td>
                                    <td>
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
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-light text-primary rounded-circle fs-3">
                                <i class="ri-shopping-cart-2-fill align-middle"></i>
                            </span>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="text-uppercase fw-semibold fs-12 text-muted mb-1">Total Sold</p>
                            <h4 class="mb-0"> $ <span class="counter-value">2390.68</span></h4>
                        </div>
                        <div class="flex-shrink-0 align-self-end">
                            <span class="badge bg-success-subtle text-success">
                                <i class="ri-arrow-up-s-fill align-middle me-1"></i> 6.24 %
                            </span>
                        </div>
                    </div>
                </div>
            </div>
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
        totalCount(lists) {
            return lists.reduce((total, item) => total + parseFloat(item.quantity), 0);
        },
        total(lists) {
            return lists.reduce((total, item) => {
                const amount = parseFloat((item.amount) ? item.amount : item.total);
                const quantity = item.quantity ? parseInt(item.quantity) : 1; 
                return total + (amount * quantity);
            }, 0);
        }
    }
}
</script>
