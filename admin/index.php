<?php
include 'header.php';
include 'sidebar.php';
?>

  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        
  <?php
$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';

// Memuat halaman sesuai pilihan
switch ($page) {
    case 'artikel':
        include 'pages/form-artikel.php';
        break;
    case 'banner':
        include 'pages/form-banner.php';
        break;
    case 'produk':
        include 'pages/banner.php';
        break;
    default:
        include 'pages/dashboard.php';
        break;
}
  ?>


      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2024 <a href="https://shabatprinting.com">Shabat Printing</a>.</strong>
    All rights reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
 <?php
 include 'footer.php'
 ?>