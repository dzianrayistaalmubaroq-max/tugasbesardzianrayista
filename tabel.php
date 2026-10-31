<?php include "navbar.php"; 

 
?>  

<div class ="container">
    
    <div class="container">
  <div class="row align-items-start">
    <div class="col-2">
      <!-- One of three columns -->
    </div>

    <div class="col-8">

      <!-- awal card -->
        <div class="card">

        <div class="card-header">
          <b>Tabel</b>
        </div>

        <div class="card-body">

          <table class="table">
            <thead>
              <tr>
                <th>No</th>
                <th>Username</th>
                <th>Role</th>
                <th>Nama</th>
                <th>Aksi</th>
              </tr>
            </thead>

            <tbody>
              <tr>
                <th>1</th>
                <td>Akmal</td>
                <td>Siswa</td>
                <td>Akmal</td>
                <td>
                  <button class="btn btn-warning btn-sm">Edit</button>
                  <button class="btn btn-danger btn-sm">Hapus</button>
                </td>
              </tr>
            </tbody>

          </table>

        </div>
      </div>

      <!-- akhir card --> 

    </div>

    <div class="col-2">
      <!-- One of three columns -->
    </div>

  </div>
</div>
    
    
    
</div>

<?php include "script.php"; ?>