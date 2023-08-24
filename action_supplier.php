<?php
	session_start();
    
    if( !isset($_SESSION["login"]))
    {
        header("Location: index.php");
        exit;
    }

    require 'functions.php';

	if(isset($_GET['items'])){
		$s_name = $_GET['items'];
		$sSQL="SELECT tb_item.name AS item FROM tb_stock
		INNER JOIN tb_item ON tb_stock.item = tb_item.id WHERE tb_item.id = '$s_name'";
		$result=mysqli_query($conn, $sSQL);
		$row=mysqli_fetch_assoc($result);
		$item = $row['item'];

		$sSQL="SELECT tb_supplier.id, tb_supplier.name FROM tb_stock INNER JOIN tb_supplier ON tb_stock.supplier = tb_supplier.id 
		INNER JOIN tb_item ON tb_stock.item = tb_item.id WHERE tb_item.name = '$item'";
		$result=mysqli_query($conn, $sSQL);
		while($row=mysqli_fetch_assoc($result))
		{
			$id_supplier = $row['name'];
			$id = $row['id'];
			?>
				<option value="<?=$id?>"><?=$id_supplier?></option>
			<?php
		}
	}
?>