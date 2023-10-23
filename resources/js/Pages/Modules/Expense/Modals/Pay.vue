<template>
    <b-modal v-model="showModal" title="View Expense" header-class="p-3 bg-light" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>    
        <div class="modal-body">
            <div class="table-responsive table-card">
                <table class="table table-hover table-centered align-middle table-nowrap mb-2">
                    <tbody>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div>
                                        <h5 class="fs-14 my-1">{{selected.name.name}}</h5>
                                        <span class="text-muted">{{selected.name.subtype.name}}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="text-end">
                                <h5 class="fs-14 my-1 fw-normal">{{formatMoney(selected.amount)}}</h5>
                                <span class="text-muted">Amount</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
         <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Close</b-button>
            <!-- <b-button @click="create('ok')" variant="primary" :disabled="form.processing" block>Pay Now</b-button> -->
        </template>
    </b-modal>
</template>
<script>
export default {
    data(){
        return {
            currentUrl: window.location.origin,
            showModal: false,
            selected: { name: { subtype: '' }},
            form: {}
        }
    },
    methods : {
        show(data) {
            this.selected = data;
            console.log(data);
            this.showModal = true;
        },
        create(){
            this.form = this.$inertia.form({
                id: this.selected.id,
                is_paid: 1,
                editable: true
            })

            this.form.post('/loans',{
                preserveScroll: true,
                onSuccess: (response) => {
                    this.hide();
                },
            });
        },
        hide(){
            this.$emit('message',true);
            this.showModal = false;
        },
        formatMoney(value) {
            let val = (value/1).toFixed(2).replace(',', '.')
            return '₱'+val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        },
    }
}
</script>