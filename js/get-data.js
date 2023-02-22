
let currentPage = 1;

const searchItem = document.querySelector('#search input');
const searchByItem = document.querySelector('#search-by select');
const orderItem = document.querySelector('#order select');
const orderByItem = document.querySelector('#order-by select');
const getDataContainer = document.querySelector('#get-data');

window.onload = ()=>{
  renderPagination(currentPage);
  fetchEmployees();
}

searchItem.onkeyup = search;
searchByItem.onchange = search;
orderItem.onchange = search;
orderByItem.onchange = search;

function search(){

  if(searchItem.value.trim() === ''){
    document.getElementById('pagination').style.display = 'block';
    fetchEmployees();
  }else{
    document.getElementById('pagination').style.display = 'none';
    employeesData = {
      search: searchItem.value,
      searchBy: searchByItem.value,
      order: orderItem.value,
      orderBy: orderByItem.value
    }
    fetchEmployees(employeesData);
  }  
}

function getPage(){

  const pagLinks = document.querySelectorAll('.page-link');
  pagLinks.forEach(link => {
    link.onclick = (e)=>{
      if(e.target.textContent.toLowerCase() === 'first'){
        renderPagination(1);
        fetchEmployees();
      }else{
        if(e.target.textContent.toLowerCase() === 'last'){
          renderPagination(5);
          fetchEmployees();
        }else{
          if(e.target.textContent >= 1 && e.target.textContent <= 5){
            renderPagination(e.target.textContent);
            fetchEmployees();
          }else{
            alert('Esa página no está disponible');
          }
        }
      }
    };
  });
}

function fetchEmployees(employeesData){

  if(!employeesData){
    fetch(`api/get-employees.php?page=${currentPage}&&order=${orderItem.value}&&orderBy=${orderByItem.value}`)
      .then(res => res.json())
      .then(data => {
        if(data.length === 0){
          getDataContainer.innerHTML = 'Any results';    
        }else{
          const $tableFragment = renderTable(data);
          getDataContainer.innerHTML = '';
          getDataContainer.appendChild($tableFragment);
          getPage();
        }
      });
      
  }else{
    options = {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(employeesData)
    }
    fetch(`api/search-employees.php`, options)
      .then(res => res.json())
      .then(data => {
        if(data.length === 0){
          getDataContainer.innerHTML = 'Any results';    
        }else{
          const $tableFragment = renderTable(data);
          getDataContainer.innerHTML = '';
          getDataContainer.appendChild($tableFragment);
        }
      });
  }
}

function renderPagination(page){
  let $pagination = document.querySelector('#pagination');
  let $fragment = document.createDocumentFragment();
  $fragment =
  `
    <ul class="pagination">
  `
  if(page > 1 && page < 5){
    $fragment += 
    `
      <li class="page-item">
          <a class="page-link">First</a>
      </li>
        <li class="page-item"><a class="page-link">${parseInt(page)-1}</a></li>
        <li class="page-item"><a style='color: red' class="page-link">${parseInt(page)}</a></li>
        <li class="page-item"><a class="page-link">${parseInt(page)+1}</a></li>
      <li class="page-item">
        <a class="page-link">Last</a>
      </li>
    `;
  }else{
    if(page <= 1){
      
      $fragment += 
      `
          <li class="page-item"><a style='color: red' class="page-link">${parseInt(page)}</a></li>
          <li class="page-item"><a class="page-link">${parseInt(page)+1}</a></li>
          <li class="page-item"><a class="page-link">${parseInt(page)+2}</a></li>
        <li class="page-item">
          <a class="page-link">Last</a>
        </li>
      `;
    }else{
      $fragment += 
        `
        <li class="page-item">
          <a class="page-link">First</a>
        </li>
          <li class="page-item"><a class="page-link">${parseInt(page)-2}</a></li>
          <li class="page-item"><a class="page-link">${parseInt(page)-1}</a></li>
          <li class="page-item"><a style='color: red' class="page-link">${parseInt(page)}</a></li>
      `;
    }
  }
  $fragment += 
  `
    </ul>`

  $pagination.innerHTML = $fragment;
  currentPage = page;
}

function renderTable(data){

  $fragment = document.createDocumentFragment();

  // Creamos la tabla
  const $table = document.createElement('table');

  // Añadimos clases de bootstrap
  $table.classList.add('table');

  // Obtenemos las propiedades de los datos
  const properties = Object.getOwnPropertyNames(data[0]);

  // Creamos encabezado
  const $thead = document.createElement('thead');
  $thead.classList.add('table-dark');

  // Creamos una fila
  const $tr = document.createElement('tr');

  // Añadimos las propiedades de los datos a la fila
  properties.forEach(item=>{
    // Creamos una columna por cada propiedad
    const $th = document.createElement('th');
    // Añadimos el valor de la propiedad a la columna
    $th.textContent = item;
    // Añadimos la columna a la fila
    $tr.appendChild($th);
  });

  // Añadimos el encabezado a la tabla
  $thead.appendChild($tr);
  $table.appendChild($thead);

  // Iteramos los datos para añadirlos a la tabla
  data.forEach(item=>{

    // Creamos cuerpo
    const $tbody = document.createElement('tbody');

    // Creamos una fila
    const $tr = document.createElement('tr');

    // Iteramos las propiedades
    properties.forEach(prop=>{

      // Creamos una columna por cada propiedad
      const $td = document.createElement('td');

      // Añadimos el valor de la propiedad a la columna
      $td.textContent = item[prop].toString();

      // Añadimos la columna a la fila
      $tr.appendChild($td);

    });

    // Añadimos la fila a la tabla
    $tbody.appendChild($tr);
    $table.appendChild($tbody);
    
  });

  // Añadimos la tabla al fragmento
  $fragment.appendChild($table);

  // Retornamos el fragmento
  return $fragment;

}