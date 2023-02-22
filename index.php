<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
  <title>Mario Gijon</title>
</head>
<body>
  <div class="container mt-5">
    <h2 class="text-center text-primary">Employee table</h2>
  </div>
  <div class="container mt-5">
    <div class="row">
      <div class="form-group col-8" id='search'>
        <label>Search</label>
        <input type="text" class="form-control">
      </div>
      <div class="form-group col-4" id="search-by">
        <label>By</label>
        <select class="form-control">
          <option value="employee_id">employee_id</option>
          <option value="first_name">first_name</option>
          <option value="last_name">last_name</option>
          <option value="dni">dni</option>
        </select>
      </div>
      <div class="form-group col-6 my-5" id="order">
        <label for="exampleFormControlSelect1">Order by</label>
        <select class="form-control" id="order">
          <option value="employee_id">employee_id</option>
          <option value="first_name">first_name</option>
          <option value="last_name">last_name</option>
          <option value="dni">dni</option>
        </select>
      </div>
      <div class="form-group col-6 my-5" id="order-by">
        <label for="exampleFormControlSelect1">ASC/DESC</label>
        <select class="form-control" id="exampleFormControlSelect1">
          <option value="ASC">ASC</option>
          <option value="DESC">DESC</option>
        </select>
      </div>
      <div class="col-12 d-flex flex-column">
          <div id="get-data">
            
          </div>
          <nav aria-label="Page navigation" id="pagination" class="align-self-center">

          </nav>
      </div>
    </div>
  </div>

  <script src="js/get-data.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
    integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
  </script>
</body>
</html>