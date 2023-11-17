<template>
    <b-modal v-model="showModal" :title="carrier.name.name+' Carrier ('+code+')'" hide-footer size="lg" header-class="p-3 bg-light" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>    
        <div class="row align-items-center g-3">
            <div class="col-md">
                <div>
                    <div class="hstack gap-3 flex-wrap">
                        <div>Trip : <span class="fw-medium">{{carrier.order}}</span></div>
                        <div class="vr"></div>
                        <div>Total : <span class="fw-medium">{{formatMoney(carrier.total)}}</span></div>
                        <div class="vr"></div>
                        <div>Sold : <span class="fw-medium">0 of {{totalCount(carrier.tubs)}} sold</span></div>
                        <div class="vr"></div>
                        <div>Date : <span class="fw-medium">{{carrier.created_at}}</span></div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 mt-n1">
                <hr class="text-muted"/>
            </div>
            <div class="col-sm-12 mt-0">
                <table class="table table-bordered align-middle">
                    <thead class="table-light fs-11">
                        <tr>
                            <th width="7%" class="text-center">#</th>
                            <th width="23%">Type</th>
                            <th class="text-center" width="19%">Quantity</th>
                            <th class="text-center" width="18%">Amount</th>
                            <th class="text-center" width="18%">Total</th>
                            <th class="text-center" width="15%">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="fs-12" v-for="(list, index) in carrier.tubs" v-bind:key="'a-'+index">
                            <td class="text-center">{{index+1}}</td>
                            <td>{{list.type.name}}</td>
                            <td class="text-center">{{list.sales.length}} of {{list.quantity}} available</td>
                            <td class="text-center">{{formatMoney(list.amount) }}</td>
                            <td class="text-center">{{formatMoney(list.quantity *list.amount)}}</td>
                            <td class="text-center">
                                <span v-if="list.is_sold" class="badge bg-danger">Soldout</span>
                                <span v-else class="badge bg-success">Available</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </b-modal>
</template>
<script>
export default {
    data(){
        return {
            currentUrl: window.location.origin,
            showModal: false,
            carrier: {name: '', tubs: []},
            code: ''
        }
    },
    methods : {
        show(carrier,code) {
            this.code = code;
            this.carrier = carrier;
            this.showModal = true;
        },
        amount(val){
            this.amount1 = val;
        },
        formatMoney(value) {
            let val = (value/1).toFixed(2).replace(',', '.')
            return '₱'+val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        },
        totalCount(lists) {
            return lists.reduce((total, item) => total + parseFloat(item.quantity), 0);
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
