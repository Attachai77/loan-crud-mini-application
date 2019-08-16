<template>
  <div>

    <h3>Create Loans</h3>

    <form>

      <div class="form-group row">
        <label class="col-sm-2 col-form-label">Loan Amount : </label>
        <div class="col-sm-6 input-group">
          <input type="text" class="form-control"  aria-describedby="basic-addon1">
          <div class="input-group-prepend">
            <span class="input-group-text" id="basic-addon1">฿</span>
          </div>
        </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-2 col-form-label">Loan Term : </label>
        <div class="col-sm-6 input-group">
          <input type="text" class="form-control"  aria-describedby="basic-addon2">
          <div class="input-group-prepend">
            <span class="input-group-text" id="basic-addon2">Years</span>
          </div>
        </div>
      </div>
      
      <div class="form-group row">
        <div class="col-sm-6 offset-2">
          <button type="submit" class="btn btn-primary">Create</button>
          <button @click="$router.push('/')" type="button" class="btn btn-light">Back</button>
        </div>
      </div>
    </form>

  </div>
</template>