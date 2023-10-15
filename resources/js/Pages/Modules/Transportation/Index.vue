<template>
<Head title="Transportations" />
<b-row class="g-3">
    <b-col xxl="4">
        <b-card no-body>
            <b-card-body style="height: calc(100vh - 180px)">

            </b-card-body>
        </b-card>
    </b-col>

    <b-col xxl="8" order-xxl="0" class="order-first">
        <b-row class="g-3">
            <b-col lg="4" md="6" v-for="(item, index) of counts" :key="index">
                <b-card no-body>
                    <b-card-body>
                        <div class="d-flex align-items-center">
                            <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-light text-primary rounded-circle fs-3">
                                    <i :class="`${item.icon} align-middle`"></i>
                                </span>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <p class="text-uppercase fw-semibold fs-12 text-muted mb-1">
                                    {{ item.name }}S
                                </p>
                                <h4 class="mb-0">
                                    <span class="counter-value">{{ item.names_count }}</span>
                                </h4>
                            </div>
                        </div>
                    </b-card-body>
                </b-card>
            </b-col>
        </b-row>

        <b-row>
            <b-col xl="12">
                <b-card no-body>
                    <b-card-body style="height: calc(100vh - 284px)">
                        
                        <b-row class="g-2 mb-2 mt-n1">
                            <b-col lg>
                                <div class="input-group mb-1">
                                    <span class="input-group-text"> <i class="ri-search-line search-icon"></i></span>
                                    <input type="text" v-model="keyword" placeholder="Search Transportation" class="form-control" style="width: 50%;">
                                    <select v-model="type" @change="fetch()" class="form-select" id="inputGroupSelect02" style="width: 50px;">
                                        <option :value="null" selected>Select Type</option>
                                        <option :value="list.id" v-for="list in counts" v-bind:key="list.id">{{list.name}}</option>
                                    </select>
                                    <span @click="refresh" class="input-group-text" v-b-tooltip.hover title="Refresh" style="cursor: pointer;"> 
                                        <i class="bx bx-refresh search-icon"></i>
                                    </span>
                                    <b-button @click="create()" type="button" variant="primary">
                                        <i class="ri-add-circle-fill align-bottom me-1"></i> Create
                                    </b-button>
                                </div>
                            </b-col>
                        </b-row>

                        <div class="table-responsive">
                            <table class="table table-nowrap align-middle mb-0">
                                <thead class="table-light">
                                    <tr class="fs-11">
                                        <th style="width: 5%;"></th>
                                        <th style="width: 55%;">Name</th>
                                        <th style="width: 15%;" class="text-center">Type</th>
                                        <th style="width: 15%;" class="text-center">Status</th>
                                        <th style="width: 10%;"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(list,index) in lists" v-bind:key="index">
                                        <td>
                                            {{index+1}}
                                        </td>
                                        <td>
                                            <h5 class="fs-13 mb-0 text-dark">{{list.name}}</h5>
                                        </td>
                                        <td class="text-center">
                                           {{list.type.name}}
                                        </td>
                                        <td class="text-center">
                                           <b-badge v-if="list.is_active" variant="success">Active</b-badge>
                                           <b-badge v-else variant="danger">Inactive</b-badge>
                                        </td>
                                        <td class="text-end">
                                            <b-button @click="edit(list)" variant="soft-primary" v-b-tooltip.hover title="Edit Transportation" size="sm" class="edit-list me-1"><i class="ri-ball-pen-line"></i> </b-button>
                                            <b-button variant="soft-warning" v-b-tooltip.hover title="Update Status" size="sm" class="remove-list me-1"><i class="ri-heart-fill align-bottom"></i></b-button>
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
</b-row>
<Create @message="fetch()" :types="counts" ref="create"/>
</template>
<script>
import Create from './Modals/Create.vue';
import Pagination from "@/Shared/Components/Pagination.vue";
export default {
    components : { Pagination, Create },
    props: ['counts'],
    data(){
        return {
            currentUrl: window.location.origin,
            lists: [],
            meta: {},
            links: {},
            keyword: null,
            type: null
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
            page_url = page_url || '/transportations';
            axios.get(page_url, {
                params: {
                    keyword: this.keyword,
                    type: this.type,
                    counts: parseInt(((window.innerHeight-450)/53)),
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
        edit(data){
            this.$refs.create.edit(data);
        },
        refresh(){
            this.type = null;
            this.keyword = null;
            this.fetch();
        }
    }
}
</script>