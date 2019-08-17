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

        <h3>Repayment Schedules</h3>         
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Payment No.</th>
                <th>Date</th>
                <th>Payment Amount</th>
                <th>Email</th>
                <th>Principal</th>
                <th>Balance</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>John</td>
                <td>Doe</td>
                <td>com</td>
                <td>com</td>
                <td>com</td>
                <td>com</td>
            </tr>
            </tbody>
        </table>


    </div>
</template>

<script>
    export default {

      data() {
        return {
          loan: {}
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
            this.$router.push({name: 'loans'});
            console.log(response);
          });
        }
      }
    }
</script>