<template>
    <div>
        <h3>Edit Loan</h3>
        <validation-errors :errors="validationErrors" v-if="validationErrors"></validation-errors>
        <form @submit.prevent="updateLoan">

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Loan Amount : </label>
                <div class="col-sm-6 input-group">
                <input type="text" class="form-control" required v-model="loan.loan_amount" aria-describedby="loan-amount">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="loan-amount">฿</span>
                </div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Loan Term : </label>
                <div class="col-sm-6 input-group">
                <input type="text" class="form-control" required v-model="loan.loan_term"  aria-describedby="loan-term">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="loan-term">Years</span>
                </div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Interest Rate : </label>
                <div class="col-sm-6 input-group">
                <input type="text" class="form-control"  required v-model="loan.interest_rate"  aria-describedby="ir">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="ir">%</span>
                </div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Start Date : </label>
                <div class="col-sm-3">
                <select name="start_month" id="start_month" v-model="loan.start_month" class="form-control">
                    <option value='01'>Janaury</option>
                    <option value='02'>February</option>
                    <option value='03'>March</option>
                    <option value='04'>April</option>
                    <option value='05'>May</option>
                    <option value='06'>June</option>
                    <option value='07'>July</option>
                    <option value='08'>August</option>
                    <option value='09'>September</option>
                    <option value='10'>October</option>
                    <option value='11'>November</option>
                    <option value='12'>December</option>
                </select>
                </div>
                <div class="col-sm-3">
                <select name="start_year" id="start_year" class="form-control" v-model="loan.start_year">
                    <option  v-for="n in 34" :value="n+2016" v-bind:key="n">{{ n+2016 }}</option>
                </select>
                </div>
            </div>

            <br />
            <div class="form-group row">
                <div class="col-sm-6 offset-2">
                    <button class="btn btn-primary">Create</button>
                    <button @click="$router.push('/')" type="button" class="btn btn-light">Back</button>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
export default {

    data() {
        return {
            loan: {},
            validationErrors:''
        }
    },
    created() {
        let uri = `/api/loan/edit/${this.$route.params.id}`;
        this.axios.get(uri).then((response) => {
            this.loan = response.data;
            console.log(response.data);
            // console.log(this.$route.params.id);
        });
    },
    methods: {
        updateLoan() {
            let uri = `/api/loan/update/${this.$route.params.id}`;
            this.axios.post(uri, this.loan).then((response) => {
                this.flash('The loan has been updated successfully', 'info',{
                    timeout: 3000
                });
                this.$router.push({name: 'loans'});
                console.log(response);
            })
            .catch((error) => {
                if (error.response.status == 422){
                    this.validationErrors = error.response.data.errors;
                }
            });
        }
    }
}
</script>