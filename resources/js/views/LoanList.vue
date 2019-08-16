<template>
  <div>
    <h3>All Loans</h3>
    <button @click="$router.push('add-loan')" class="btn btn-primary">Add New Loan</button>
    <br />
    <br />

    <table class="table table-striped">
      <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Loan Amount</th>
          <th scope="col">Loan Term</th>
          <th scope="col">Interest Rate</th>
          <th scope="col">Created at</th>
          <th scope="col">Edit</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th scope="row">1</th>
          <td>Mark</td>
          <td>Otto</td>
          <td>@mdo</td>
          <td>@mdo</td>
          <td>
            <button @click="$router.push('view-loan')" class="btn btn-info">View</button>
            <button @click="$router.push('edit-loan')" class="btn btn-success">Edit</button>
            <button class="btn btn-danger">Delete</button>
          </td>
        </tr>
        <tr>
          <th scope="row">1</th>
          <td>Mark</td>
          <td>Otto</td>
          <td>@mdo</td>
          <td>@mdo</td>
          <td>
            <button @click="$router.push('view-loan')" class="btn btn-info">View</button>
            <button @click="$router.push('edit-loan')" class="btn btn-success">Edit</button>
            <button class="btn btn-danger">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>