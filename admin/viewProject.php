<?php
session_start();
include 'sendWhatsapp.php';
include 'sendEmail.php';
include 'sendTelegram.php';
if ($_SESSION['status'] != "login") {
    header("location:../index.php?pesan=belum_login");
}
$conn = mysqli_connect("localhost", "root", "", "rnd_notif");
$result = mysqli_query($conn, "SELECT * FROM project");
//ambil data id dari url
$id = $_GET["id"];
$view = "SELECT p.project_name,e.name,c.email,c.whatsapp,c.telegram FROM project as p 
        RIGHT JOIN project_employees as pe ON p.id_project = pe.id_project 
        LEFT JOIN employee as e ON pe.id_emp = e.id_emp 
        LEFT JOIN contact as c ON c.id_contact=e.id_contact WHERE p.id_project = $id";
$result3 = mysqli_query($conn, $view);

$getEmail = "SELECT 
p.id_project,e.name as name, 
c.email as email, 
e.nip as nip, 
c.whatsapp as wa, 
c.telegram as tele 
FROM project as p 
        RIGHT JOIN project_employees as pe ON p.id_project = pe.id_project 
        LEFT JOIN employee as e ON pe.id_emp = e.id_emp 
        LEFT JOIN contact as c ON c.id_contact=e.id_contact WHERE p.id_project = $id";
$res = mysqli_query($conn, $getEmail);

function getData($column_name)
{
    global $getEmail, $conn, $id;
    $count = "SELECT COUNT(*) as cnt FROM project as p 
        RIGHT JOIN project_employees as pe ON p.id_project = pe.id_project 
        LEFT JOIN employee as e ON pe.id_emp = e.id_emp 
        LEFT JOIN contact as c ON c.id_contact=e.id_contact WHERE p.id_project = $id";
    $res = mysqli_query($conn, $getEmail);
    $rows = mysqli_query($conn, $count);
    $lg = mysqli_fetch_assoc($rows)['cnt'];
    $i = 0;
    $str = "";
    while ($row = mysqli_fetch_array($res)) {
        $str = $str . $row[$column_name];
        if ($i + 1 < (int)$lg) {
            $str = $str . ", ";
        }
        $i++;
    }
    return $str;
}

function getDataArray($column)
{
    global $conn, $getEmail;
    $data = array();
    $res = mysqli_query($conn, $getEmail);
    while ($row = mysqli_fetch_array($res)) {
        array_push($data, $row[$column]);
    }
    return $data;
}

$getMessage = "SELECT * FROM formatmessage";
$exec = mysqli_query($conn, $getMessage);
if (!$exec) {
    die(mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>AdminLTE 3 | Dashboard</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="plugins/iCheck/flat/blue.css">
    <!-- Morris chart -->
    <link rel="stylesheet" href="plugins/morris/morris.css">
    <!-- jvectormap -->
    <link rel="stylesheet" href="plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <!-- Date Picker -->
    <link rel="stylesheet" href="plugins/datepicker/datepicker3.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker-bs3.css">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
        </nav>
        <!-- /.navbar -->
        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="index3.html" class="brand-link">
                <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">AdminLTE 3</span>
            </a>
            <!-- Sidebar -->
            <div class="sidebar">
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">
                            <?php echo $_SESSION['username'];
                            ?></a>
                    </div>
                </div>
            </div>
            <!-- /.sidebar -->
        </aside>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark">Detail Project</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="logout.php">Logout</a></li>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <hr>
            <div class="row">
                <div class="col-lg-8">
                    <table class="table table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Project</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Whatsapp</th>
                                <th scope="col">Telegram</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($result3)) : ?>
                                <tr>
                                    <td>
                                        <?= $row["project_name"]; ?>
                                    </td>
                                    <td>
                                        <?= $row["name"]; ?>
                                    </td>
                                    <td>
                                        <?= $row["email"]; ?>
                                    </td>
                                    <td>
                                        <?= $row["whatsapp"]; ?>
                                    </td>
                                    <td>
                                        <?= $row["telegram"]; ?>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
                <div class="col-4">
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <form method="POST">
                            <button type="submit" name="btn_email" id="btn_email" class="btn btn-danger">Email</button>
                            <?php
                            $ambilnip = "";
                            $ambilname = "";
                            $ambilemail = "";
                            if (isset($_POST['btn_email'])) {
                                $ambilnip = getData('nip');
                                $ambilname = getData('name');
                                $ambilemail = getData('email');
                                $mode = "Email";
                            }
                            ?>
                        </form>
                        <form method="POST">
                            <button type="submit" class="btn btn-success" name="btn_wa" id="btn_wa">Whatsapp</button>
                            <?php
                            $nip = "";
                            $nama = "";
                            $noWA = "";
                            if (isset($_POST['btn_wa'])) {
                                $nip = getData('nip');
                                $nama = getData('name');
                                $noWA = getData('wa');
                                $mode = "WhatsApp";
                            }
                            ?>
                        </form>
                        <form method="POST">
                            <button type="submit" class="btn btn-primary" name="btn_tele" id="btn_tele">Telegram</button>
                            <?php
                            $getnip = "";
                            $getnama = "";
                            $noTele = "";
                            if (isset($_POST['btn_tele'])) {
                                $getnip = getData('nip');
                                $getnama = getData('name');
                                $noTele = getData('tele');
                                $mode = "Telegram";
                            }
                            ?>
                        </form>

                    </div>
                </div>
            </div>
            <hr>
            <div class="col-lg-6">
                <form id="form-send-message" method="POST" action="">
                    <input type="text" id="mode" name="mode" value="<?php echo $mode ?>" hidden>

                    <div class="form-group">
                        <label>NIP</label>
                        <input id="nip" name="nip" type="text" class="form-control" readonly value="<?php if (empty($ambilnip) && empty($nip) && empty($getnip)) {
                                                                                                        echo "Empty";
                                                                                                    } else {
                                                                                                        if (!empty($ambilnip)) {
                                                                                                            echo $ambilnip;
                                                                                                        }
                                                                                                        if (!empty($nip)) {
                                                                                                            echo $nip;
                                                                                                        }
                                                                                                        if (!empty($getnip)) {
                                                                                                            echo $getnip;
                                                                                                        }
                                                                                                    } ?>">
                    </div>
                    <div class="form-group">
                        <label> Tujuan <?php echo (empty($mode)) ? "" : $mode; ?></label>
                        <input id="email" name="email" type="text" class="form-control" readonly value=" <?php if (empty($ambilnip) && empty($noWA) && empty($noTele)) {
                                                                                                                echo "Empty";
                                                                                                            } else {
                                                                                                                if (!empty($ambilemail)) {
                                                                                                                    echo $ambilemail;
                                                                                                                }
                                                                                                                if (!empty($noWA)) {
                                                                                                                    echo $noWA;
                                                                                                                }
                                                                                                                if (!empty($noTele)) {
                                                                                                                    echo $noTele;
                                                                                                                }
                                                                                                            } ?> ">

                    </div>
                    <div class="form-group">
                        <label>Name</label>
                        <input id="name" name="name" type="text" class="form-control" readonly value=" <?php if (empty($ambilname) && empty($nama) && empty($getnama)) {
                                                                                                            echo "Empty";
                                                                                                        } else {
                                                                                                            if (!empty($ambilname)) {
                                                                                                                echo $ambilname;
                                                                                                            }
                                                                                                            if (!empty($nama)) {
                                                                                                                echo $nama;
                                                                                                            }
                                                                                                            if (!empty($getnama)) {
                                                                                                                echo $getnama;
                                                                                                            }
                                                                                                        } ?> ">
                    </div>
                    <div class="form-group">
                        <label>Subject</label>
                        <input id="subject" name="subject" type="text" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Message</label>
                        <textarea id="body" name="body" class="form-control" readonly><?php if (mysqli_num_rows($exec) > 0) {
                                                                                            while ($rowData = mysqli_fetch_array($exec)) {
                                                                                                echo $rowData["message"];
                                                                                            }
                                                                                        } ?></textarea>
                    </div>
                    <!-- <button type="submit" name="submit" class="btn btn-primary">Send</button> -->
                    <?php
                    if (isset($_POST['send'])) {
                        $m = $_POST['mode'];
                        if ($m == "Email") {
                            kirimEmail();
                        } else if ($m == "WhatsApp") {
                            $tmp_nip = getDataArray('nip');
                            $tmp_nm = getDataArray('name');
                            $tmp_wa = getDataArray('wa');
                            for ($i=0; $i < sizeof($tmp_wa); $i++) { 
                                $ms = "\nNIP: ".$tmp_nip[$i]."\nNama: ".$tmp_nm[$i]."\n\n".$_POST['body'];
                                sendMessage($tmp_wa[$i], "$ms");
                            }
                        } else if ($m == "Telegram") {
                            # code...
                        } else {
                            echo " Not Selected";
                        }
                    } ?>
                    <button type="submit" name="send" id="send" class="btn btn-primary">SEND</button>

                </form><br>
            </div>

        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <strong>Copyright &copy; 2020 <a href="http://adminlte.io">AdminLTE.io</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 3.0.0-alpha
            </div>
        </footer>
        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Morris.js charts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="plugins/morris/morris.min.js"></script>
    <!-- Sparkline -->
    <script src="plugins/sparkline/jquery.sparkline.min.js"></script>
    <!-- jvectormap -->

    <!-- jQuery Knob Chart -->

    <!-- daterangepicker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
    <script src="plugins/daterangepicker/daterangepicker.js"></script>
    <!-- datepicker -->
    <script src="plugins/datepicker/bootstrap-datepicker.js"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
    <!-- Slimscroll -->
    <script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="plugins/fastclick/fastclick.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.js"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="dist/js/pages/dashboard.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>
</body>

</html>
<div class="modal" tabindex="-1" role="dialog" id="sendEmail">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="">
                    <div class="form-group">
                        <input type="text" readonly class="form-control" value="<?php
                                                                                while ($row = mysqli_fetch_assoc($res)) {
                                                                                    $hasil = $row["email"];
                                                                                    echo $hasil . ",";
                                                                                } ?>">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">Save changes</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>