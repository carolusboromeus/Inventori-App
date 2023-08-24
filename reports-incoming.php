<?php
    session_start();
    
    if( !isset($_SESSION["login"]))
    {
        header("Location: index.php");
        exit;
    }

    if(isset($_POST["submit"]))
    {
        $s_date = $_POST["from"];
        $ss_date = $_POST["to"];
    }

    require 'functions.php';

    if($type == "Kasir")
    {
        header("Location: index.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Incoming Stock Reports - Admin Dashboard</title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <link rel="stylesheet" href="assets/vendors/simple-datatables/style.css">

    <link rel="stylesheet" href="assets/vendors/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="assets/vendors/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/app.css">
    <link rel="shortcut icon" href="assets/images/favicon.png" type="image/x-icon">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
</head>

<body>
    <div id="sidebar" class="active">
        <div class="sidebar-wrapper active">
            <div class="sidebar-header">
                <div class="d-flex justify-content-between">
                    <div class="logo">
                        <a href="dashboard.php"><img src="assets/images/logo/logo.png" alt="Logo" srcset=""></a>
                    </div>
                    <div class="toggler">
                        <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                    </div>
                </div>
            </div>
            <div class="sidebar-menu">
                <ul class="menu" id="navMenus">
                    <li class="sidebar-title">Menu</li>

                    <li class="sidebar-item">
                        <a href="dashboard.php" class="sidebar-link">
                            <i class="bi bi-grid-fill"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <?php
                        if($type != "Kasir")
                        {
                    ?>
                        <li class="sidebar-item">
                            <a href="suppliers.php" class="sidebar-link">
                                <i class="bi bi-truck-front-fill"></i>
                                <span>Suppliers</span>
                            </a>
                        </li>

                        <li class="sidebar-item has-sub">
                            <a href="#" class="sidebar-link">
                                <i class="bi bi-box-seam-fill"></i>
                                <span>Items</span>
                            </a>
                            <ul class="submenu">
                                <li class="submenu-item ">
                                    <a href="item-list.php">Item List</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href="item-category.php">Item Category</a>
                                </li>
                            </ul>
                        </li>
                    <?php    
                        }
                        
                        if($type == "Admin")
                        {
                    ?>    
                        <li class="sidebar-item has-sub">
                            <a href="#" class="sidebar-link">
                                <i class="bi bi-archive-fill"></i>
                                <span>Stock</span>
                            </a>
                            <ul class="submenu ">
                                <li class="submenu-item ">
                                    <a href="stock-item.php">Stock Item</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href="incoming-stock.php">Incoming Stock</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href="out-of-stock.php">Out of Stock</a>
                                </li>
                            </ul>
                        </li>
                    <?php    
                        }

                        if($type == "Gudang")
                        {
                    ?>
                        <li class="sidebar-item has-sub">
                            <a href="#" class="sidebar-link">
                                <i class="bi bi-archive-fill"></i>
                                <span>Stock</span>
                            </a>
                            <ul class="submenu ">
                                <li class="submenu-item ">
                                    <a href="stock-item.php">Stock Item</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href="incoming-stock.php">Incoming Stock</a>
                                </li>
                            </ul>
                        </li>
                    <?php    
                        }

                        if($type != "Kasir")
                        {
                    ?>
                        <li class="sidebar-item has-sub active">
                            <a href="#" class="sidebar-link">
                                <i class="bi bi-file-text-fill"></i>
                                <span>Reports</span>
                            </a>
                            <ul class="submenu">
                                <li class="submenu-item ">
                                    <a href="reports-incoming.php">Incoming Stock</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href="reports-out.php">Out of Stock</a>
                                </li>
                            </ul>
                        </li>
                    <?php    
                        }

                        if($type == "Kasir")
                        {
                    ?>
                        <li class="sidebar-item has-sub">
                            <a href="#" class="sidebar-link">
                                <i class="bi bi-archive-fill"></i>
                                <span>Stock</span>
                            </a>
                            <ul class="submenu ">
                                <li class="submenu-item ">
                                    <a href="stock-item.php">Stock Item</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href="out-of-stock.php">Out of Stock</a>
                                </li>
                            </ul>
                        </li>
                    <?php    
                        }

                        if($type == "Admin")
                        {
                    ?>
                        <li class="sidebar-item">
                            <a href="account-list.php" class="sidebar-link" onclick="active()">
                                <i class="bi bi-person-badge-fill"></i>
                                <span>Account</span>
                            </a>
                        </li>
                    <?php    
                        }
                    ?>
                    
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link" data-bs-toggle="modal" data-bs-target="#logoutModal">
                            <i class="bi bi-door-closed-fill"></i>
                            <span>Logout</span>
                        </a>
                    </li>
                </ul>
            </div>
            <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
        </div>
    </div>

    <div id="main">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header>

        <div class="page-heading">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 col-md-6 order-md-1 order-last">
                        <h3>Incoming Stock Reports</h3>
                        <p class="text-subtitle text-muted">For user to check incoming stock reports</p>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Incoming Stock Reports</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <section class="section">
                <div class="card">
                    <div class="card-header">
                        <div class="row g-3">
                            <div class="col-auto">
                                <form class="form form-horizontal" action="" method="POST" name="myForm" id="form-id">
                                    <!-- Basic Vertical form layout section start -->
                                    <div class="form-body">
                                        <div class="row g-3">
                                            <div class="col-auto">
                                                <div class="row">
                                                    <div class="col-auto">
                                                        <label>From:</label>
                                                    </div>
                                                    <div class="col-auto form-group">
                                                        <input type="date" id="from" class="form-control"
                                                            name="from" value="<?=$s_date?>" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <div class="row">
                                                    <div class="col-auto">
                                                        <label>To:</label>
                                                    </div>
                                                    <div class="col-auto form-group">
                                                        <input type="date" id="to" class="form-control"
                                                            name="to" value="<?=$ss_date?>" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <button type="submit" class="btn btn-primary me-1 mb-1" name="submit">Submit</button>
                                            </div>
                                            <div class="col-auto">
                                                <a href="#" class="btn btn-warning me-1 mb-1" id="print" onclick="printContent('examples')">Print</a>
                                            </div> 
                                        </div>
                                    </div>
                                    <!-- // Basic Vertical form layout section end -->
                                </form>
                            </div>
                            <div class="col-auto ms-auto">
                                <input id="txt_searchall" class="form-control" type="text" placeholder="Search..." autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div id="examples">
                        <h3 id="title"></h3>
                        <p id="text"></p>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Date</th>
                                    <th>Item Name</th>
                                    <th>Supplier</th>
                                    <th>Category</th>
                                    <th>Description</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    if(isset($_POST["submit"]))
                                    {
                                        $date1 = htmlspecialchars($_POST["from"]);
                                        $date2 = htmlspecialchars($_POST["to"]);
                                        $new_date1 = date("d/m/Y", strtotime($date1));
                                        $new_date2 = date("d/m/Y", strtotime($date2));

                                        $sSQL="";
                                        $sSQL="SELECT tb_incoming_stock.id, tb_item.name, tb_supplier.name AS supplier, tb_category.category, tb_incoming_stock.date, 
                                            tb_incoming_stock.description, tb_incoming_stock.amount FROM tb_incoming_stock 
                                            INNER JOIN tb_supplier ON tb_incoming_stock.supplier = tb_supplier.id
                                            INNER JOIN tb_item ON tb_incoming_stock.name = tb_item.id
                                            INNER JOIN tb_category ON tb_item.category = tb_category.id
                                            WHERE tb_incoming_stock.date BETWEEN '$date1'AND '$date2'+INTERVAL 1 DAY ORDER BY date";
                                        /*$sSQL="SELECT * FROM tb_incoming_stock ORDER BY date";*/
                                        $result=mysqli_query($conn, $sSQL);
                                        if (mysqli_num_rows($result) > 0) 
                                        {
                                            $no = 0;
                                            while ($row=mysqli_fetch_assoc($result))
                                            {
                                                $id = $row['id'];
                                                $description= $row['description'];
                                                $amount = $row['amount'];

                                                $s_date = $row['date'];
                                                $date = date("d M Y", strtotime($s_date));
                                                
                                                $name = $row['name'];
                                                $supplier = $row['supplier'];
                                                $category = $row['category'];
                                                $no = $no + 1;
                                ?>		
                                                <tr>
                                                    <td width="4%"><?php echo $no;?></td>
                                                    <td><?php echo $date;?></td>
                                                    <td><?php echo $name;?></td>
                                                    <td><?php echo $supplier;?></td>
                                                    <td><?php echo $category;?></td>
                                                    <td><?php echo $description;?></td>
                                                    <td><?php echo $amount;?></td>
                                                </tr>   
                                        <?php	   
                                            }
                                        } 
                                    }
                                    ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Ready to Leave?</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button type="cancel" class="btn btn-light-secondary me-1 mb-1" data-bs-dismiss="modal">Cancel</button>
                    <a href="logout.php"><button type="submit" name="logout" class="btn btn-primary me-1 mb-1">Logout</button></a>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>

    <script type='text/javascript'>
        var todayDate = new Date();
        var month = todayDate.getMonth()+1; //04 - current month
        var year = todayDate.getUTCFullYear(); //2021 - current year
        var tdate = todayDate.getDate(); // 27 - current date 
        if (month < 10) {
            month = "0" + month //'0' + 4 = 04
        }
        if (tdate < 10) {
            tdate = "0" + tdate;
        }
        var maxDate = year + "-" + month + "-" + tdate;
        document.getElementById("from").setAttribute("max", maxDate);
        document.getElementById("to").setAttribute("max", maxDate);
        var a = document.forms["myForm"]["to"].value;
        if(a == null || a == "")
        {
            document.getElementById("to").setAttribute("value", maxDate);
        }
    </script>
    <script type='text/javascript'> 
        function printContent(el) {
            var restorepage = document.body.innerHTML;
            $("#title").html("<br>Incoming Stock Reports");
            $("#text").html("Periode: <?=$new_date1?> - <?=$new_date2?><br>");
            var printcontent = document.getElementById(el).innerHTML;
            document.body.innerHTML = printcontent;
            window.print();
            document.body.innerHTML = restorepage;
        }
    </script>
    <script type='text/javascript'>
        $(document).ready(function()
        {
            // Search all columns
            $('#txt_searchall').keyup(function(){
                // Search Text
                var search = $(this).val();

                // Hide all table tbody rows
                $('table tbody tr').hide();

                // Count total search result
                var len = $('table tbody tr:not(.notfound) td:contains("'+search+'")').length;

                if(len > 0){
                // Searching text in columns and show match row
                $('table tbody tr:not(.notfound) td:contains("'+search+'")').each(function(){
                    $(this).closest('tr').show();
                });
                }else{
                $('.notfound').show();
                }
            });
        });

        // Case-insensitive searching (Note - remove the below script for Case sensitive search )
        $.expr[":"].contains = $.expr.createPseudo(function(arg) 
        {
            return function( elem ) {
                return $(elem).text().toUpperCase().indexOf(arg.toUpperCase()) >= 0;
            };
        });
    </script>
    <script src="assets/js/main.js"></script>
</body>

</html>