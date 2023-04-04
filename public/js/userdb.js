const userTable = document.getElementById("userTable");
const addButton = document.getElementById("addButton");

getUpdatedData()

function getUpdatedData(){
    fetch('http://localhost/userdb')
    .then((response) => response.json())
    .then((data) => updateTable(data['data']))
    .catch(error => console.error(error));
}

function updateTable(data){
    userTable.innerHTML = ` 
    <tr>
        <th>Id</th>
        <th>Nama</th>
        <th>Alamat</th>
    </tr>
    `;

    const rows = data.map(item => `
      <tr>
        <td>${item.id}</td>
        <td>${item.nama}</td>
        <td>${item.alamat}</td>
        <td>
        <button class="edit-btn" onclick="editRow(this)">Edit</button>
        <button class="delete-btn" onclick="deleteRow(this)">Delete</button>
        </td>
      </tr>
    `).join('');
  
    userTable.innerHTML += rows;
  }

  addButton.addEventListener("click", addUser);

  function addUser(){
    let inputNama = document.getElementById("inputNama");
    let inputAlamat = document.getElementById("inputAlamat");
    const data = {
        nama: inputNama.value,
        alamat: inputAlamat.value
      };
      inputNama.value = "";
      inputAlamat.value = "";
      fetch('http://localhost/userdb', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
      })
      .then(response => response.json())
      .then(data => getUpdatedData())
      .catch(error => console.error(error));
  }

  function editRow(button) {
    // Get the table row element
    const row = button.parentNode.parentNode;
    
    // Get the table cells
    const nameCell = row.cells[1];
    const alamatCell = row.cells[2];
    const actionCell = row.cells[3];
    
    // Get the current values
    let name = nameCell.innerHTML;
    let alamat = alamatCell.innerHTML;
    
    // Replace the cells with input fields
    nameCell.innerHTML = '<input type="text" value="' + name + '" + name="Editnama">';
    alamatCell.innerHTML = '<input type="text" value="' + alamat + '" + name="Editalamat">';
    
    // Change the edit button to confirm edit
    button.innerHTML = 'Confirm Edit';
    button.onclick = function() { confirmEdit(button) };
    
    // Change the delete button to cancel edit
    let deleteBtn = actionCell.getElementsByClassName('delete-btn')[0];
    deleteBtn.innerHTML = 'Cancel Edit';
    deleteBtn.onclick = function() { cancelEdit(row, name, alamat) };
  }
  
  function confirmEdit(button) {
    // Get the table row element
    const row = button.parentNode.parentNode;
    
    // Get the input fields
    const nameInput = row.cells[1].getElementsByTagName('input')[0];
    const alamatInput = row.cells[2].getElementsByTagName('input')[0];
    
    // Get the new values
    let name = nameInput.value;
    let alamat = alamatInput.value;
    
    // Replace the input fields with the new values
    row.cells[1].innerHTML = name;
    row.cells[2].innerHTML = alamat;

    sendEditRequest(button, name, alamat)
    
    // Change the confirm edit button back to edit
    button.innerHTML = 'Edit';
    button.onclick = function() { editRow(button) };
    
    // Change the cancel edit button back to delete
    let deleteBtn = row.cells[3].getElementsByClassName('delete-btn')[0];
    deleteBtn.innerHTML = 'Delete';
    deleteBtn.onclick = function() { deleteRow(deleteBtn) };
  }

  function sendEditRequest(button, nama, alamat){
    const id = getID(button);

    const data = {
        nama: nama,
        alamat: alamat
      };
      
      fetch(`http://localhost/userdb/${id}`, {
        method: 'PUT',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
      })
      .then(response => response.json())
      .then(data => getUpdatedData())
      .catch(error => console.error(error));
  }
  
  function cancelEdit(row, name, alamat) {
    // Replace the input fields with the original values
    row.cells[1].innerHTML = name;
    row.cells[2].innerHTML = alamat;
    
    // Change the cancel edit button back to delete
    let deleteBtn = row.cells[3].getElementsByClassName('delete-btn')[0];
    deleteBtn.innerHTML = 'Delete';
    deleteBtn.onclick = function() { deleteRow(deleteBtn) };
    
    // Change the confirm edit button back to edit
    let editBtn = row.cells[3].getElementsByClassName('edit-btn')[0];
    editBtn.innerHTML = 'Edit';
    editBtn.onclick = function() { editRow(editBtn) };
  }

  function deleteRow(button) {
    // Get the table row element
    const row = button.parentNode.parentNode;
    const actionCell = row.cells[3];

    // Change the edit button to confirm edit
    let editBtn = actionCell.getElementsByClassName('edit-btn')[0];
    editBtn.innerHTML = 'Confirm delete';
    editBtn.style.backgroundColor = '#F32A10';
    editBtn.onclick = function() { confirmDelete(button, row) };
    
    // Change the delete button to cancel edit

    button.innerHTML = 'Cancel Delete';
    button.style.backgroundColor = '#e2b513';
    button.onclick = function() { cancelDelete(button, row) };
  }

  function cancelDelete(button, row){
    const actionCell = row.cells[3];
    let editBtn = actionCell.getElementsByClassName('edit-btn')[0];
    editBtn.innerHTML = 'Edit';
    editBtn.style.backgroundColor = '#e2b513';
    editBtn.onclick = function() { editRow(editBtn) };
    
    // Change the delete button to cancel edit

    button.innerHTML = 'Delete';
    button.style.backgroundColor = '#F32A10';
    button.onclick = function() { deleteRow(button, row) };
  }

  function getID(button){
    const row = button.parentNode.parentNode;
    const id = row.cells[0].textContent;
    return id;
  }

  function confirmDelete(button, row){
    const id = getID(button);
    row.remove();
    fetch(`http://localhost/userdb/${id}`, {
    method: 'DELETE',
    headers: {
        'Content-Type': 'application/json'
    }
    })
    .then(response => {
    console.log('Success:', response);
    })
    .catch(error => {
    console.error('Error:', error);
    });
  }

