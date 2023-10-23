<template>
<Head title="Trips" />
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
                                        <input type="text" v-model="keyword" placeholder="Search Trip" class="form-control" style="width: 50%;">
                                        <span @click="refresh" class="input-group-text" v-b-tooltip.hover title="Refresh" style="cursor: pointer;"> 
                                            <i class="bx bx-refresh search-icon"></i>
                                        </span>
                                        <b-button @click="create()" type="button" variant="primary">
                                            <i class="ri-add-circle-fill align-bottom me-1"></i> Create Trip
                                        </b-button>
                                    </div>
                                </b-col>
                            </b-row>

                            <div class="table-responsive">
                                <table class="table table-nowrap align-middle mb-0">
                                    <thead class="table-light">
                                        <tr class="fs-11">
                                            <th style="width: 5%;">#</th>
                                            <th style="width: 20%;">Code</th>
                                            <th style="width: 20%;" class="text-center">Boat</th>
                                            <th style="width: 20%;" class="text-center">Date</th>
                                            <th style="width: 15%;" class="text-center">Status</th>
                                            <th style="width: 10%;"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(list,index) in lists" v-bind:key="index">
                                            <td>{{index+1}}</td>
                                            <td>{{list.code}}</td>
                                            <td class="text-center">{{list.boat.name}}</td>
                                            <td class="text-center">{{list.date}}</td>
                                            <td class="text-center">
                                                <span v-if="list.is_completed" class="badge bg-success">Completed</span>
                                                <span class="badge bg-warning">
                                                    <span v-if="has_departed">Departed</span>
                                                    <span v-else>Waiting</span>
                                                </span>
                                            </td>
                                            <td class="text-end">
                                                <b-button @click="edit(list)" variant="soft-warning" v-b-tooltip.hover title="Edit Loan" size="sm" class="edit-list me-1"><i class="ri-ball-pen-line"></i> </b-button>
                                                <b-button @click="view(list)" variant="soft-primary" v-b-tooltip.hover title="View" size="sm" class="remove-list me-1"><i class="ri-eye-fill align-bottom"></i></b-button>
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
    <Create :boats="boats" @message="fetch()" ref="create"/>
    <View ref="view"/>
</template>
<script>
import View from './Modals/View.vue';
import Create from './Modals/Create.vue';
import Pagination from "@/Shared/Components/Pagination.vue";
export default {
    props: ['boats'],
    components : { Pagination, Create, View },
    data(){
        return {
            currentUrl: window.location.origin,
            lists: [],
            meta: {},
            links: {},
            keyword: null,
        }
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
            page_url = page_url || '/trips';
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
        view(){
            this.$refs.view.show();
        },
        formatMoney(value) {
            let val = (value/1).toFixed(2).replace(',', '.')
            return '₱'+val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        },
    }
}
</script>