<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produktif User Database</title>
    <link href="/css/userdbStyle.css" rel="stylesheet">
</head>
<body>
    <div class="navbar">
        <div class="logo">
            <a href="/">PDUDB</a>
        </div>
        <div class="space">
            <!-- Space -->
        </div>
        <div class="logout-link">
            <a href="logout" class="logout-btn"><button>Logout</button></a>
        </div>
    </div>
    <div class="info">
            <p>Halo <?=session()->get('user_name')?>, selamat datang di Produktif User Database</p>
    </div>
    <div class="main-layout">
        <div class="user-table">
            <h3>User Database</h3>
            <table id="userTable">
                <tr>
                    <th>Id</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>
            </table>
        </div>
        <div class="user-form">
            <h3>Tambah data user</h3>
            <label for="inputNama">Nama: </label>
            <input type="text" placeholder="Nama" name="inputNama" id="inputNama"><br>
            <label for="inputAlamat">Alamat: </label>
            <input type="text" placeholder="Alamat" name="inputAlamat" id="inputAlamat">
            <button id="addButton" class="add-btn">Tambah</button>
        </div>
    </div>
</body>
<script src="/js/userdb.js"></script>
</html>