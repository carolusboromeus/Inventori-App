<?php
    session_start();
    
    if( !isset($_SESSION["login"]))
    {
        header("Location: index.php");
        exit;
    }

    require 'functions.php';

    if(isset($_POST["change"]))
    {
        // cek apakah data berhasil di ubah atau tidak
        if(change_password($_POST) > 0)
        {
            echo "
                <script>
                    alert('Password berhasil diubah!');
                    document.location.href = 'dashboard.php';
                </script>
            ";
        }
        else
        {
            echo "
                <script>
                    alert('Password gagal diubah!');
                </script>
            ";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Admin Dashboard</title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/vendors/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/vendors/iconly/bold.css">
    <link rel="stylesheet" href="assets/vendors/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="assets/vendors/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/app.css">
    <link rel="shortcut icon" href="assets/images/favicon.png" type="image/x-icon">
</head>
<style>
    .field-icon 
    {
        float: right;
        margin-left: -25px;
        margin-top: -32px;
        position: relative;
        z-index: 2;
    }
</style>

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

                    <li class="sidebar-item active">
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
                        <li class="sidebar-item  has-sub">
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
                        <li class="sidebar-item  has-sub">
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
                        <li class="sidebar-item  has-sub">
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
                        <li class="sidebar-item  has-sub">
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
            <h3>Dashboard</h3>
        </div>
        <div class="page-content">
            <section class="row">
                <div class="col-12 col-lg-9">
                    <div class="row">
                        <div class="col-6 col-lg-3 col-md-6">
                            <div class="card">
                                <div class="card-body px-3 py-4-5">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="stats-icon green">
                                                <i class="iconly-boldPaper"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <h6 class="text-muted font-semibold">Item Stock</h6>
                                            <?php 
                                                $query=mysqli_query($conn, "SELECT SUM(stock) AS stock FROM tb_stock");
                                                $row = mysqli_fetch_assoc($query);
                                                $t_stock = $row["stock"];
                                            ?>
                                            <h6 class="font-extrabold mb-0"><?=$t_stock?></h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-lg-3 col-md-6">
                            <div class="card">
                                <div class="card-body px-3 py-4-5">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="stats-icon blue">
                                                <i class="iconly-boldPaper-Plus"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <h6 class="text-muted font-semibold">Incoming Stock</h6>
                                            <?php 
                                                $query=mysqli_query($conn, "SELECT SUM(amount) AS amount FROM tb_incoming_stock");
                                                $row = mysqli_fetch_assoc($query);
                                                $t_incoming = $row["amount"];
                                            ?>
                                            <h6 class="font-extrabold mb-0"><?=$t_incoming?></h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-lg-3 col-md-6">
                            <div class="card">
                                <div class="card-body px-3 py-4-5">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="stats-icon red">
                                                <i class="iconly-boldPaper-Negative"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <h6 class="text-muted font-semibold">Out of Stock</h6>
                                            <?php 
                                                $query=mysqli_query($conn, "SELECT SUM(amount) AS amount FROM tb_outstock");
                                                $row = mysqli_fetch_assoc($query);
                                                $t_out = $row["amount"];
                                            ?>
                                            <h6 class="font-extrabold mb-0"><?=$t_out?></h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-xl-8">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Item Stock</h4>
                                </div>
                                <div class="card-body">
                                    <div id="stock-item"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-xl-4">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Stock Timeline</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-7">
                                            <div class="d-flex align-items-center">
                                                <svg class="bi text-success" width="32" height="32" fill="blue"
                                                    style="width:10px">
                                                    <use
                                                        xlink:href="assets/vendors/bootstrap-icons/bootstrap-icons.svg#circle-fill" />
                                                </svg>
                                                <h5 class="mb-0 ms-3">Incoming Stock</h5>
                                            </div>
                                        </div>
                                        <div class="col-5 d-flex justify-content-end">
                                            <h5 class="mb-0"><?=$t_incoming?></h5>
                                        </div>
                                        <div class="col-12">
                                            <div id="chart-incoming-stock">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="d-flex align-items-center">
                                                <svg class="bi text-danger" width="32" height="32" fill="blue"
                                                    style="width:10px">
                                                    <use
                                                        xlink:href="assets/vendors/bootstrap-icons/bootstrap-icons.svg#circle-fill" />
                                                </svg>
                                                <h5 class="mb-0 ms-3">Out of Stock</h5>
                                            </div>
                                        </div>
                                        <div class="col-6 d-flex justify-content-end">
                                            <h5 class="mb-0"><?=$t_out?></h5>
                                        </div>
                                        <div class="col-12">
                                            <div id="chart-out-of-stock"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-3">
                    <div class="card">
                        <div class="card-body py-4 px-5">
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-xl">
                                    <img src="assets/images/faces/1.jpg" alt="Face 1">
                                </div>
                                <div class="ms-3 name">
                                    <?php ?>
                                    <h5 class="font-bold"><?=$name_user?></h5>
                                    <h6 class="text-muted mb-0">@<?=$username?></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h4>Change Password</h4>
                        </div>
                        <div class="card-content" style="padding-top: 10px;">
                            <form class="form form-vertical" action="" method="POST">
                                <div class="form-group">
                                    <label for="password">Current Password</label>
                                    <input type="password" class="form-control" id="password"
                                        placeholder="Current Password" name="password" autocomplete="off" required>
                                </div>
                                <div class="form-group">
                                    <label for="new password">New Password</label>
                                    <input type="password" class="form-control" id="new password"
                                        placeholder="New Password" name="new_password" autocomplete="off" required>
                                </div>
                                <div class="form-group">
                                    <label for="confirm password">Retype New Password</label>
                                    <input type="password" id="confirm password" class="form-control" 
                                        placeholder="Retype New Password" name="confirm_password" autocomplete="off" required>
                                </div>
                                <div class="form-check">
                                    <div class="checkbox">
                                        <input type="checkbox" class="form-check-input" id="showpassword">
                                        <label for="showpassword" onclick="ShowPassword()">Show Password</label>
                                    </div>
                                </div>
                                <div class="px-4">
                                    <button class="btn btn-block btn-light-primary font-bold mt-3" name="change">Change Password</button>
                                </div>
                            </form>
                        </div>
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
    <script src="assets/vendors/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendors/bootstrap/js/bootstrap.min.js"></script>
 
    <script src="assets/vendors/apexcharts/apexcharts.js"></script>
    <script src="assets/js/pages/showpassword.js"></script>
    <!--<script src="assets/js/pages/chart.js"></script>-->
    <?php 
        $sSQL="";
        $sSQL="SELECT tb_item.name, tb_stock.stock FROM tb_stock RIGHT JOIN tb_item ON tb_stock.item = tb_item.id order by tb_item.name";
        $result=mysqli_query($conn, $sSQL);

        if (mysqli_num_rows($result) > 0)
        {
            $s_items ="";
            $s_stock ="";
            $a_items = array();
            $a_stock = array();

            while ($row=mysqli_fetch_assoc($result))
            {
                $no = 0;
                $items = $row["name"];
                $stock = $row["stock"];
                
                $no = array_search($items,$a_items);
                if($no !== false)
                {
                    $total = $a_stock[$no] + $stock;
                    $a_stock[$no] = $total;
                }
                else
                {
                    $a_items[] = $items;
                    $a_stock[] = $stock;
                }
            }
        }

        //echo array_search("Gel Pen Joyko GP-265",$a_items);
        //echo print_r($a_items);

        $sSQL="SELECT date, amount FROM tb_incoming_stock";
        $result=mysqli_query($conn, $sSQL);

        if (mysqli_num_rows($result) > 0)
        {
            $a_i_amount = array();
            $a_i_date = array();

            while ($row=mysqli_fetch_assoc($result))
            {
                $sec = strtotime($row["date"]); 
                $newdate = date ("Y-m-d H:i:s", $sec);  
                $a_i_amount[] = $row["amount"];
                $a_i_date[] = $row["date"];
            }
        }

        $sSQL="SELECT date, amount FROM tb_outstock";
        $result=mysqli_query($conn, $sSQL);

        if (mysqli_num_rows($result) > 0)
        {
            $a_o_amount = array();
            $a_o_date = array();

            while ($row=mysqli_fetch_assoc($result))
            {
                $sec = strtotime($row["date"]); 
                $newdate = date ("Y-m-d H:i:s", $sec);  
                $a_o_amount[] = $row["amount"];
                $a_o_date[] = $row["date"];
            }
        }
    ?>
    <script>
        //Setup Block
        const items = <?php echo json_encode($a_items);?>;
        const stock = <?php echo json_encode($a_stock);?>;

        const i_date = <?php echo json_encode($a_i_date);?>;
        const i_amount = <?php echo json_encode($a_i_amount);?>;

        const o_date = <?php echo json_encode($a_o_date);?>;
        const o_amount = <?php echo json_encode($a_o_amount);?>;

        var optionsStockItem = {
            annotations: {
                position: 'back'
            },
            dataLabels: {
                enabled:false
            },
            chart: {
                type: 'bar',
                height: 450
            },
            fill: {
                opacity:1
            },
            plotOptions: {
            },
            series: [{
                name: 'stock',
                data: stock
            }],
            colors: [
            function({ value, seriesIndex, w }) {
                if (value <= 20) 
                {
                    return '#FF0000'
                } 
                else if (value > 20 && value < 40)
                {
                    return '#ffa500'
                }
                else if (value >= 40)
                {
                    return '#435ebe'
                }
            }
            ],
            xaxis: {
                categories: items,
            },
            plotOptions: {
                bar: {
                horizontal: true
                }
            }
        }

        var optionsIncomingStock = {
            series: [{
                name: 'incoming stock',
                data: i_amount
            }],
            chart: {
                height: 200,
                type: 'area',
                toolbar: {
                    show:true,
                    tools: {
                        download:false,
                        selection:false,
                        zoom:true,
                        zoomin:true,
                        zoomout:true,
                        pan:false,
                        reset:true,
                    }
                },
            },
            colors: ['#5350e9'],
            stroke: {
                width: 2,
            },
            grid: {
                show:false,
            },
            dataLabels: {
                enabled: false
            },
            xaxis: {
                type: 'date',
                categories: i_date,
                axisBorder: {
                    show:false
                },
                axisTicks: {
                    show:false
                },
                labels: {
                    show:false,
                }
            },
            show:false,
            yaxis: {
                labels: {
                    show:false,
                },
            },
            tooltip: {
                x: {
                    format: 'dd/MM/yy HH:mm'
                },
            },
            colors: ['#008b75']
        };

        var optionsOutofStock = {
            series: [{
                name: 'out of stock',
                data: o_amount
            }],
            chart: {
                height: 200,
                type: 'area',
                toolbar: {
                    show:true,
                    tools: {
                        download:false,
                        selection:false,
                        zoom:true,
                        zoomin:true,
                        zoomout:true,
                        pan:false,
                        reset:true,
                    }
                },
            },
            colors: ['#5350e9'],
            stroke: {
                width: 2,
            },
            grid: {
                show:false,
            },
            dataLabels: {
                enabled: false
            },
            xaxis: {
                type: 'date',
                categories: o_date,
                axisBorder: {
                    show:false
                },
                axisTicks: {
                    show:false
                },
                labels: {
                    show:false,
                }
            },
            show:false,
            yaxis: {
                labels: {
                    show:false,
                },
            },
            tooltip: {
                x: {
                    format: 'dd/MM/yy HH:mm'
                },
            },
            colors: ['#dc3545']
        };

        let optionsAmerica = {
            ...optionsIncomingStock,
            colors: ['#008b75'],
        }
        let optionsIndonesia = {
            ...optionsIncomingStock,
            colors: ['#dc3545'],
        }

        var chartStockItem = new ApexCharts(document.querySelector("#stock-item"), optionsStockItem);
        var chartIncomingStock = new ApexCharts(document.querySelector("#chart-incoming-stock"), optionsIncomingStock);
        var chartOutofStock = new ApexCharts(document.querySelector("#chart-out-of-stock"), optionsOutofStock);

        chartOutofStock.render();
        chartIncomingStock.render();
        chartStockItem.render();
    </script>

    <script src="assets/js/main.js"></script>
</body>
</html>