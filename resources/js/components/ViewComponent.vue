<template>
    <div>
        <div class="row">
            <div class="col-12">
                <h3>Loan Details</h3>
            </div>
            <div class="col-2"><b>ID :</b></div>
            <div class="col-10">{{ loan.id }}</div>

            <div class="col-2"><b>Loan Amount :</b></div>
            <div class="col-10">{{ loan.loan_amount }}</div>

            <div class="col-2"><b>Loan Term :</b></div>
            <div class="col-10">{{ loan.loan_term }}</div>

            <div class="col-2"><b>Interest Rate :</b></div>
            <div class="col-10">{{ loan.interest_rate }}</div>

            <div class="col-2"><b>Created at :</b></div>
            <div class="col-10">{{ loan.created_at }}</div>
        </div><br>
        <button @click="$router.push('/')" type="button" class="btn btn-light">Back</button>
        <br><br>

        <h3>Repayment Schedules</h3>         
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Payment No.</th>
                <th>Date</th>
                <th>Payment Amount</th>
                <th>Principal</th>
                <th>Interest</th>
                <th>Balance</th>
            </tr>
            </thead>
            <tbody>
                <tr v-for="schedule in PaymentSchedules" :key="schedule.id">
                    <td>{{ schedule.id }}</td>
                    <td>{{ schedule.date }}</td>
                    <td>{{ schedule.payment_amount }}</td>
                    <td>{{ schedule.principal }}</td>
                    <td>{{ schedule.interest }}</td>
                    <td>{{ schedule.balance }}</td>
                </tr>
            </tbody>
        </table>


    </div>
</template>

<script>
export default {

    data() {
        return {
            loan: {},
            PaymentSchedules: {}
        }
    },
    created() {
        let uri = `/api/loan/edit/${this.$route.params.id}`;
        this.axios.get(uri).then((response) => {
            this.loan = response.data;
            // console.log(response.data);
            // console.log(this.$route.params.id);
        });

        let uriGetSchedule = `/api/loan/getPaymentSchedule/${this.$route.params.id}`;
        this.axios.get(uriGetSchedule).then(response => {
            this.PaymentSchedules = response.data.data;
            console.log(response.data);
        });
    }
}
</script>