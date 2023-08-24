<?php
	session_start();
    
    if( !isset($_SESSION["login"]))
    {
        header("Location: index.php");
        exit;
    }

    require 'functions.php';

	if(isset($_GET['items']) && isset($_GET['supplier'])){
		$s_name = $_GET['items'];
		$s_supplier = $_GET['supplier'];

		$sSQL="SELECT tb_item.name AS item FROM tb_stock
		INNER JOIN tb_item ON tb_stock.item = tb_item.id WHERE tb_item.id = '$s_name'";
		$result=mysqli_query($conn, $sSQL);
		$row=mysqli_fetch_assoc($result);
		$item = $row['item'];

		$sSQL="SELECT tb_category.id, tb_category.category FROM tb_category 
			INNER JOIN tb_item ON tb_item.category = tb_category.id
			INNER JOIN tb_supplier
			WHERE tb_item.name = '$item' AND tb_supplier.id = '$s_supplier'";
		
		$result=mysqli_query($conn, $sSQL);

		while($row=mysqli_fetch_assoc($result))
		{
			$category = $row["category"];
			$id = $row["id"];
			?>
				<option value="<?=$id?>"><?=$category?></option>
			<?php
		}
		return true;
	}

	if(isset($_GET['items'])){
		$s_name = $_GET['items'];
		
		//$s_supplier = $_GET['supplier'];

		$sSQL="SELECT tb_category.id, tb_category.category FROM tb_category 
			INNER JOIN tb_item ON tb_item.category = tb_category.id
			WHERE tb_item.id = '$s_name'";
		
		$result=mysqli_query($conn, $sSQL);

		while($row=mysqli_fetch_assoc($result))
		{
			$category = $row["category"];
			$id = $row["id"];
			?>
				<option value="<?=$id?>"><?=$category?></option>
			<?php
		}
	}
?>