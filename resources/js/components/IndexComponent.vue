<template>
    <div>
        <h3>All Loans</h3>
        <router-link :to="{ name: 'create' }" class="btn btn-primary">Add New Loan</router-link>
        <br/><br/>

        <table class="table table-hover table-striped">
            <thead>
            <tr>
                <th>ID</th>
                <th>Loan Amount</th>
                <th>Loan Term</th>
                <th>Interest Rate</th>
                <th>Created at</th>
                <th>Edit</th>
            </tr>
            </thead>
            <tbody>
                <tr v-for="loan in loans" :key="loan.id">
                    <td>{{ loan.id }}</td>
                    <td>{{ loan.loan_amount }}</td>
                    <td>{{ loan.loan_term }}</td>
                    <td>{{ loan.interest_rate }}</td>
                    <td>{{ loan.created_at }}</td>
                    <td>
                        <router-link :to="{name: 'view', params: { id: loan.id }}" class="btn btn-info">View</router-link>
                        <router-link :to="{name: 'edit', params: { id: loan.id }}" class="btn btn-success">Edit</router-link>
                        <button class="btn btn-danger" @click.prevent="deletePost(loan.id)">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    data() {
        return {
            loans: []
        }
    },
    created() {
        let uri = '/api/loans';
        this.axios.get(uri).then(response => {
            this.loans = response.data.data;
            console.log(response.data);
        });
    },
    methods: {
        deletePost(id)
        {
            let uri = `/api/loan/delete/${id}`;
            this.axios.delete(uri).then(response => {
                this.loans.splice(this.loans.indexOf(id), 1);
            });
        }
    }
}
</script>