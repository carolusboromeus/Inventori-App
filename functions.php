<?php
    //Koneksi ke Database
    $conn = mysqli_connect("localhost", "root", "", "db_inventori");

    //Import PHPMailer classes into the global namespace
    //These must be at the top of your script, not inside a function
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    if(isset($_SESSION["login"]))
    {
        $username = $_SESSION["username"];
        //cek username sudah ada atau belum
        $query=mysqli_query($conn, "SELECT * FROM tb_account WHERE username ='$username'");
        $row = mysqli_fetch_assoc($query);
        $id_user = $row["id"];
        $name_user = $row["name"];
        $type = $row["type"];
    }

    function forgot_password($data)
    {
        global $conn;

        $email = htmlspecialchars($data["email"]);

        $query = "SELECT id FROM tb_account WHERE email='$email'";
        $result = mysqli_query($conn,$query);

        if(mysqli_num_rows($result) > 0)
        {
            $row = mysqli_fetch_assoc($result);
            $id = $row["id"];

            //date exp
            $expFormat = mktime(date("H"), date("i"), date("s"), date("m") ,date("d")+1, date("Y"));
			$expDate = date("Y-m-d H:i:s",$expFormat);

            //token
            $key = md5(2418*2+(int)$email);
			$addKey = substr(md5(uniqid(rand(),1)),3,10);
			$key = $key . $addKey;

            // Insert Temp Table
            $query = "INSERT INTO tb_reset_token 
                            VALUES 
                            ('', '$id', '$key', '$expDate')
                        ";
            mysqli_query($conn, $query);

            $output='<p>Dear user,</p>';
            $output.='<p>Please click on the following link to reset your password.</p>';
            $output.='<p>-------------------------------------------------------------</p>';
            $output.='<p><a href="localhost/inventori/reset-password.php?key='.$key.'&id='.$id.'&action=reset" target="_blank">
            https://localhost/inventori/reset-password.php?key='.$key.'&id='.$id.'&action=reset</a></p>';		
            $output.='<p>-------------------------------------------------------------</p>';
            $output.='<p>Please be sure to copy the entire link into your browser.
            The link will expire after 1 day for security reason.</p>';
            $output.='<p>If you did not request this forgotten password email, no action 
            is needed, your password will not be reset. However, you may want to log into 
            your account and change your security password as someone may have guessed it.</p>';   	
            $output.='<p>Thanks,</p>';
            $output.='<p>LocalHost Team</p>';
            $body = $output; 
            $subject = "Password Recovery - LocalHost";

            //Load Composer's autoloader
            require 'assets/PHPMailer/src/Exception.php';
            require 'assets/PHPMailer/src/PHPMailer.php';
            require 'assets/PHPMailer/src/SMTP.php';

            //Create an instance; passing `true` enables exceptions
            $mail = new PHPMailer(true);
            try 
            {
                //$fromserver = "noreply@localhost.com"; 
                
                $mail->SMTPDebug = SMTP::DEBUG_SERVER;
                $mail->Host = "smtp.mail.yahoo.com"; // Enter your host here
                $mail->isSMTP();
                $mail->SMTPAuth = true;
                $mail->Username = "pertusrafael@yahoo.com"; // Enter your email here
                $mail->Password = "jmxualtoygtgsyry"; //Enter your password here
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port = 465;
                
                $mail->setFrom('pertusrafael@yahoo.com', 'LocalHost');
                $mail->addAddress($email);
                //$mail->Sender = $fromserver; // indicates ReturnPath header

                $mail->isHTML(true);
                $mail->Subject = $subject;
                $mail->Body = $body;
                
                if(!$mail->send())
                {
                    echo "Mailer Error: " . $mail->ErrorInfo;
                    return false;
                }
                else
                {
                    echo "<script> 
                            alert('Tolong verify email anda yang kami telah kirim!');
                            document.location.href = 'index.php';
                            </script>";
                }
            } 
            catch (Exception $e) 
            {
                echo "<script> alert('Message could not be sent. Mailer Error: {$mail->ErrorInfo}')</script>";
                return false;
            }
        }
        else
        {
            echo "<script> alert('Email Belum Terdaftar!')</script>";
            return false;
        }
    }

    function change_password($data)
    {
        global $conn;

        $n_password = mysqli_real_escape_string($conn, $data["new_password"]);
        $r_password = mysqli_real_escape_string($conn, $data["confirm_password"]);

        if($data["email"]!="")
        {
            $id = htmlspecialchars($data["email"]);

            if($n_password == $r_password)
            {
                // enkripsi password
                $n_password = password_hash($n_password, PASSWORD_DEFAULT);

                //$query insert data
                $query = "UPDATE tb_account SET
                    password = '$n_password'
                    WHERE id = '$id'
                ";
                mysqli_query($conn, $query);
                mysqli_query($conn,"DELETE FROM tb_reset_token WHERE email='$id'");
                
                return mysqli_affected_rows($conn);
            }
            else
            {
                echo "<script> alert('Password Tidak Sama!')</script>";
                return false;
            }
        }
        else
        {
            $username = $_SESSION["username"];
            // ambil data dari tial elemen dalam form
            $password = mysqli_real_escape_string($conn, $data["password"]);
            //cek username sudah ada atau belum
            $result = mysqli_query($conn, "SELECT password FROM tb_account WHERE username = '$username'");
            $row = mysqli_fetch_assoc($result);
            $o_password = $row["password"];

            if(password_verify($password, $o_password))
            {
                if(password_verify($n_password, $o_password))
                {
                    echo "<script> alert('Password Sudah Dipakai!')</script>";
                    return false;   
                }
                else
                {
                    if($n_password == $r_password)
                    {
                        // enkripsi password
                        $n_password = password_hash($n_password, PASSWORD_DEFAULT);

                        //$query insert data
                        $query = "UPDATE tb_account SET
                            password = '$n_password'
                            WHERE username = '$username'
                        ";
                        mysqli_query($conn, $query);

                        
                        return mysqli_affected_rows($conn);
                    }
                    else
                    {
                        echo "<script> alert('Password Tidak Sama!')</script>";
                        return false;
                    }
                }
            }
            else
            {
                echo "<script> alert('Password Salah!')</script>";
                return false;
            }

        }
    }

    function add_account($data)
    {
        global $conn; 

        // ambil data dari tial elemen dalam form
        $name = htmlspecialchars($data["name"]);
        $username = htmlspecialchars($data["username"]);
        $email = htmlspecialchars($data["email"]);
        $password = mysqli_real_escape_string($conn, $data["password"]);
        $type = htmlspecialchars($data["type"]);
        
        //cek username sudah ada atau belum
        $result = mysqli_query($conn, "SELECT username FROM tb_account WHERE username = '$username'");

        if(mysqli_fetch_assoc($result))
        {
            echo "<script> alert('Username Sudah Terdaftar!')</script>";
            return false;
        }
        else
        {
            //cek username sudah ada atau belum
            $result2 = mysqli_query($conn, "SELECT email FROM tb_account WHERE email = '$email'");
            if(mysqli_fetch_assoc($result2))
            {
                echo "<script> alert('Email Sudah Terdaftar!')</script>";
                return false;
            }
            else
            {
                // enkripsi password
                $password = password_hash($password, PASSWORD_DEFAULT);

                //$query insert data
                $query = "INSERT INTO tb_account 
                            VALUES 
                            ('', '$name', '$email', '$username', '$password', '$type' , CURRENT_TIMESTAMP)
                        ";
                mysqli_query($conn, $query);

                return mysqli_affected_rows($conn);
            }
        }
    }

    function update_account($data)
    {
        global $conn; 

        // ambil data dari tiap elemen dalam form
        //$id = $data["id"];
        $name = htmlspecialchars($data["name"]);
        $username = htmlspecialchars($data["username"]);
        $email = htmlspecialchars($data["email"]);
        $type = htmlspecialchars($data["type"]);
        //$password1 = mysqli_real_escape_string($conn, $data["password1"]);
        //$password2 = mysqli_real_escape_string($conn, $data["password2"]);

        $id = $_GET["id"];
        $query = mysqli_query($conn, "SELECT * FROM tb_account WHERE id ='$id'");
        //$row = mysqli_fetch_assoc($query);

        /*if(password_verify($password1, $row["password"]))
        {
            // enkripsi password
            $password2 = password_hash($password2, PASSWORD_DEFAULT);

            //query update data
            mysqli_query($conn, "UPDATE tb_user SET password = '$password2' WHERE id = $id");

            return mysqli_affected_rows($conn);
        }*/

        //$query update data
        $query = "UPDATE tb_account SET
                    name = '$name', 
                    email = '$email',
                    username = '$username', 
                    type = '$type'
                    WHERE id = $id
                ";
        mysqli_query($conn, $query);

        return mysqli_affected_rows($conn);  
    }

    function delete_account($data)
    {
        global $conn;

        $id = htmlspecialchars($data["id"]);
        $query = mysqli_query($conn, "SELECT * FROM tb_account WHERE id ='$id'");
        //$query delete data
        $query = "DELETE from tb_account WHERE id = $id";
        mysqli_query($conn, $query);

        return mysqli_affected_rows($conn);
    }

    function add_supplier($data)
    {
        global $conn, $id_user; 

        // ambil data dari tial elemen dalam form
        $name = htmlspecialchars($data["name"]);
        $address = htmlspecialchars($data["address"]);
        $telephone = htmlspecialchars($data["telephone"]);
        $description = htmlspecialchars($data["description"]);
        
        //cek supplier sudah ada atau belum
        $result = mysqli_query($conn, "SELECT name FROM tb_supplier WHERE name = '$name'");

        if(mysqli_fetch_assoc($result))
        {
            echo "<script> alert('Supplier Sudah Ada!')</script>";
            return false;
        }
        else
        {
            //$query insert data
            $query = "INSERT INTO tb_supplier 
                        VALUES 
                        ('', '$name','$address','$telephone','$description',CURRENT_TIMESTAMP, '$id_user')
                    ";
            mysqli_query($conn, $query);

            return mysqli_affected_rows($conn);
        }
    }

    function update_supplier($data)
    {
        global $conn, $id_user; 

        // ambil data dari tiap elemen dalam form
        //$id = $data["id"];
        $name = htmlspecialchars($data["name"]);
        $address = htmlspecialchars($data["address"]);
        $telephone = htmlspecialchars($data["telephone"]);
        $description = htmlspecialchars($data["description"]);

        $id = $_GET["id"];
        $query = mysqli_query($conn, "SELECT * FROM tb_supplier WHERE id ='$id'");
        //$row = mysqli_fetch_assoc($query);

        //$query update data
        $query = "UPDATE tb_supplier SET
                    name = '$name',
                    address = '$address',
                    telephone = '$telephone',
                    description = '$description',
                    user ='$id_user',
                    date = CURRENT_TIMESTAMP
                    WHERE id = $id
                ";
        mysqli_query($conn, $query);

        return mysqli_affected_rows($conn);  
    }

    function delete_supplier($data)
    {
        global $conn;

        $id = htmlspecialchars($data["id"]);
        $query = mysqli_query($conn, "SELECT * FROM tb_supplier WHERE id ='$id'");
        //$query delete data
        $query = "DELETE from tb_supplier WHERE id = $id";
        mysqli_query($conn, $query);

        return mysqli_affected_rows($conn);
    }

    function add_category($data)
    {
        global $conn, $id_user; 

        // ambil data dari tial elemen dalam form
        $category = htmlspecialchars($data["category"]);
        
        //cek categoy sudah ada atau belum
        $result = mysqli_query($conn, "SELECT category FROM tb_category WHERE category = '$category'");

        if(mysqli_fetch_assoc($result))
        {
            echo "<script> alert('Category Sudah Ada!')</script>";
            return false;
        }
        else
        {
            //$query insert data
            $query = "INSERT INTO tb_category 
                        VALUES 
                        ('', '$category', CURRENT_TIMESTAMP, '$id_user')
                    ";
            mysqli_query($conn, $query);

            return mysqli_affected_rows($conn);
        }
    }

    function update_category($data)
    {
        global $conn, $id_user; 

        // ambil data dari tiap elemen dalam form
        $category = htmlspecialchars($data["category"]);

        $id = $_GET["id"];

        //$query update data
        $query = "UPDATE tb_category SET
                    category = '$category',
                    user = '$id_user',
                    date = CURRENT_TIMESTAMP
                    WHERE id = $id
                ";
        mysqli_query($conn, $query);

        return mysqli_affected_rows($conn);  
    }

    function delete_category($data)
    {
        global $conn;

        $id = htmlspecialchars($data["id"]);
        $query = mysqli_query($conn, "SELECT * FROM tb_category WHERE id ='$id'");
        //$query delete data
        $query = "DELETE from tb_category WHERE id = $id";
        mysqli_query($conn, $query);

        return mysqli_affected_rows($conn);
    }

    function add_item($data)
    {
        global $conn, $id_user; 

        // ambil data dari tial elemen dalam form
        $name = htmlspecialchars($data["name"]);
        $category = htmlspecialchars($data["category"]);
        $description = htmlspecialchars($data["description"]);
        
        //cek item sudah ada atau belum
        $result = mysqli_query($conn, "SELECT * FROM tb_item WHERE name = '$name'");

        if(mysqli_fetch_assoc($result))
        {
            echo "<script> alert('Item Sudah Ada!')</script>";
            return false;
        }
        else
        {
            //$query insert data
            $query = "INSERT INTO tb_item VALUES 
                        ('', '$name', '$category', '$description', CURRENT_TIMESTAMP, '$id_user')
                    ";
            /*$query = "INSERT INTO tb_item(id, name, category, description, date, user)
                        SELECT '', '$name', id, '$description', CURRENT_TIMESTAMP, '$id_user'
                        FROM tb_category
                        WHERE category = '$category'
                    ";*/
            mysqli_query($conn, $query);

            return mysqli_affected_rows($conn);
        }
    }

    function update_item($data)
    {
        global $conn, $id_user; 

        // ambil data dari tiap elemen dalam form
        $name = htmlspecialchars($data["name"]);
        $category = htmlspecialchars($data["category"]);
        $description = htmlspecialchars($data["description"]);

        $id = $_GET["id"];

        //$query update data
        $query = "UPDATE tb_item
                    SET name = '$name',
                    category = '$category',
                    description = '$description',
                    date = CURRENT_TIMESTAMP,
                    user = '$id_user'
                    WHERE id = $id
                ";
        mysqli_query($conn, $query);

        return mysqli_affected_rows($conn);  
    }

    function delete_item($data)
    {
        global $conn;

        $id = htmlspecialchars($data["id"]);
        $query = mysqli_query($conn, "SELECT * FROM tb_item WHERE id ='$id'");
        //$query delete data
        $query = "DELETE from tb_item WHERE id = $id";
        mysqli_query($conn, $query);

        return mysqli_affected_rows($conn);
    }

    function add_stock($data)
    {
        global $conn, $id_user; 

        // ambil data dari tiap elemen dalam form
        $name = htmlspecialchars($data["name"]);
        $supplier = htmlspecialchars($data["supplier"]);

        //cek supplier sudah ada atau belum
        $result = mysqli_query($conn, "SELECT id FROM tb_supplier WHERE id = '$supplier'");
        if(mysqli_num_rows($result) <= 0)
        {
            echo "<script> alert('Supplier Tidak Ada!')</script>";
            return false;
        }
        
        //cek item sudah ada atau belum
        $result = mysqli_query($conn, "SELECT * FROM tb_stock WHERE item = '$name'");
        if($row = mysqli_fetch_assoc($result))
        {
            $s_supplier = $row["supplier"];

            //cek supplier sudah ada atau belum
            $result = mysqli_query($conn, "SELECT id FROM tb_stock WHERE '$supplier' = '$s_supplier'");

            if(mysqli_fetch_assoc($result))
            {
                echo "<script> alert('Item Sudah Ada!')</script>";
                return false;
            }
        }
        
        //$query insert data
        $query = "INSERT INTO tb_stock VALUES 
                ('', '$name','$supplier','0',CURRENT_TIMESTAMP, '$id_user')
                    ";
        mysqli_query($conn, $query);

        return mysqli_affected_rows($conn);
    }

    function update_stock($data)
    {
        global $conn, $id_user; 

        // ambil data dari tiap elemen dalam form
        $name = htmlspecialchars($data["name"]);
        $supplier = htmlspecialchars($data["supplier"]);

        $id = $_GET["id"];
        $query = mysqli_query($conn, "SELECT * FROM tb_stock WHERE id ='$id'");
        //$row = mysqli_fetch_assoc($query);

        //$query update data
        $query = "UPDATE tb_stock SET
                    item = '$name',
                    supplier = '$supplier',
                    date = CURRENT_TIMESTAMP,
                    user = '$id_user'
                    WHERE id = $id
                ";
        mysqli_query($conn, $query);

        return mysqli_affected_rows($conn);  
    }

    function delete_stock($data)
    {
        global $conn;

        $id = htmlspecialchars($data["id"]);
        $query = mysqli_query($conn, "SELECT * FROM tb_stock WHERE id ='$id'");
        //$query delete data
        $query = "DELETE from tb_stock WHERE id = $id";
        mysqli_query($conn, $query);

        return mysqli_affected_rows($conn);
    }

    //add out of stock
    function add_outstock($data)
    {
        global $conn, $id_user; 

        // ambil data dari tiap elemen dalam form
        $name = htmlspecialchars($data["name"]);
        $amount = htmlspecialchars($data["amount"]);
        $supplier = htmlspecialchars($data["supplier"]);
        $category = htmlspecialchars($data["category"]);
        $description = htmlspecialchars($data["description"]);

        //cek supplier sudah ada atau belum
        $result = mysqli_query($conn, "SELECT * FROM tb_supplier WHERE id = '$supplier'");

        if($row = mysqli_fetch_assoc($result))
        {
            //cek category sudah ada atau belum
            $result = mysqli_query($conn, "SELECT id FROM tb_category WHERE id = '$category'");

            if($row = mysqli_fetch_assoc($result))
            {

                //$query insert data
                $query = "INSERT INTO tb_outstock 
                            VALUES 
                            ('', '$name','$supplier','$amount','$description', CURRENT_TIMESTAMP, '$id_user')
                        ";
                mysqli_query($conn, $query);

                //cek stock sudah ada atau belum
                $result = mysqli_query($conn, "SELECT * FROM tb_stock WHERE item = '$name' AND supplier = '$supplier'");
                if($row = mysqli_fetch_assoc($result))
                {
                    $stock = $row["stock"];
                    $total = $stock - $amount;

                    //$query update data
                    $query = "UPDATE tb_stock SET
                                stock = '$total'
                                WHERE item = '$name' AND supplier = '$supplier'
                            ";       
                    mysqli_query($conn, $query);

                    return mysqli_affected_rows($conn);
                }
                else
                {
                    //$query insert data
                    $query = "INSERT INTO tb_stock 
                                VALUES 
                                ('','$name','$supplier','$amount',CURRENT_TIMESTAMP,'$id_user')
                            ";
                    mysqli_query($conn, $query);

                    return mysqli_affected_rows($conn);
                }
            }
            else
            {
                echo "<script> alert('Category Tidak Ada!')</script>";
                return false;
            }
        }
        else
        {
            echo "<script> alert('Supplier Tidak Ada!')</script>";
            return false;
        }
    }

    function update_outstock($data)
    {
        global $conn, $id_user; 

        // ambil data dari tiap elemen dalam form
        $name = htmlspecialchars($data["name"]);
        $amount = htmlspecialchars($data["amount"]);
        $supplier = htmlspecialchars($data["supplier"]);
        $category = htmlspecialchars($data["category"]);
        $description = htmlspecialchars($data["description"]);

        $id = $_GET["id"];
        //cek supplier sudah ada atau belum
        $result = mysqli_query($conn, "SELECT id FROM tb_supplier WHERE id = '$supplier'");

        if(mysqli_num_rows($result) > 0)
        {
            //cek category sudah ada atau belum
            $result = mysqli_query($conn, "SELECT id FROM tb_category WHERE id = '$category'");

            if(mysqli_num_rows($result) > 0)
            {
                //cek stock sudah ada atau belum
                $result = mysqli_query($conn, "SELECT * FROM tb_stock WHERE item = '$name' AND supplier = '$supplier'");
                if(mysqli_num_rows($result) > 0)
                {
                    $row = mysqli_fetch_assoc($result);
                    $stock = $row["stock"];

                    $query = mysqli_query($conn, "SELECT amount FROM tb_outstock WHERE id = '$id'");
                    $array = mysqli_fetch_assoc($query);
                    $s_amount = $array["amount"];

                    $save = $amount - $s_amount;
                    
                    $total = $stock - $save;

                    //$query update data
                    $query = "UPDATE tb_stock SET
                                stock = '$total'
                                WHERE item = '$name' AND supplier = '$supplier' 
                            ";       
                    mysqli_query($conn, $query);

                    //$query update data
                    $query = "UPDATE tb_outstock SET
                                amount = '$amount',
                                description ='$description',
                                user = '$id_user'
                                WHERE id = $id
                            ";
                    mysqli_query($conn, $query);

                    return mysqli_affected_rows($conn);
                }
                else
                {
                    echo "<script> alert('Stock Tidak Ada!')</script>";
                    return false;
                }
            }
            else
            {
                echo "<script> alert('Category Tidak Ada!')</script>";
                return false;
            }
        }
        else
        {
            echo "<script> alert('Supplier Tidak Ada!')</script>";
            return false;
        }  
    }

    //add incoming stock
    function add_incoming_stock($data)
    {
        global $conn, $id_user; 

        // ambil data dari tiap elemen dalam form
        $name = htmlspecialchars($data["name"]);
        $amount = htmlspecialchars($data["amount"]);
        $supplier = htmlspecialchars($data["supplier"]);
        $category = htmlspecialchars($data["category"]);
        $description = htmlspecialchars($data["description"]);

        //cek supplier sudah ada atau belum
        $result = mysqli_query($conn, "SELECT * FROM tb_supplier WHERE id = '$supplier'");

        if($row = mysqli_fetch_assoc($result))
        {
            //cek category sudah ada atau belum
            $result = mysqli_query($conn, "SELECT id FROM tb_category WHERE id = '$category'");

            if($row = mysqli_fetch_assoc($result))
            {

                //$query insert data
                $query = "INSERT INTO tb_incoming_stock 
                            VALUES 
                            ('', '$name','$supplier','$amount','$description', CURRENT_TIMESTAMP, '$id_user')
                        ";
                mysqli_query($conn, $query);

                //cek stock sudah ada atau belum
                $result = mysqli_query($conn, "SELECT * FROM tb_stock WHERE item = '$name' AND supplier = '$supplier'");
                if($row = mysqli_fetch_assoc($result))
                {
                    $stock = $row["stock"];
                    $total = $stock + $amount;

                    //$query update data
                    $query = "UPDATE tb_stock SET
                                stock = '$total'
                                WHERE item = '$name' AND supplier = '$supplier'
                            ";       
                    mysqli_query($conn, $query);

                    return mysqli_affected_rows($conn);
                }
                else
                {
                    //$query insert data
                    $query = "INSERT INTO tb_stock 
                                VALUES 
                                ('','$name','$supplier','$amount',CURRENT_TIMESTAMP,'$id_user')
                            ";
                    mysqli_query($conn, $query);

                    return mysqli_affected_rows($conn);
                }
            }
            else
            {
                echo "<script> alert('Category Tidak Ada!')</script>";
                return false;
            }
        }
        else
        {
            echo "<script> alert('Supplier Tidak Ada!')</script>";
            return false;
        }
    }

    function update_incoming_stock($data)
    {
        global $conn, $id_user; 

        // ambil data dari tiap elemen dalam form
        $name = htmlspecialchars($data["name"]);
        $amount = htmlspecialchars($data["amount"]);
        $supplier = htmlspecialchars($data["supplier"]);
        $category = htmlspecialchars($data["category"]);
        $description = htmlspecialchars($data["description"]);

        $id = $_GET["id"];
        //cek supplier sudah ada atau belum
        $result = mysqli_query($conn, "SELECT id FROM tb_supplier WHERE id = '$supplier'");

        if(mysqli_num_rows($result) > 0)
        {
            //cek category sudah ada atau belum
            $result = mysqli_query($conn, "SELECT id FROM tb_category WHERE id = '$category'");

            if(mysqli_num_rows($result) > 0)
            {
                //cek stock sudah ada atau belum
                $result = mysqli_query($conn, "SELECT * FROM tb_stock WHERE item = '$name' AND supplier = '$supplier'");
                if(mysqli_num_rows($result) > 0)
                {
                    $row = mysqli_fetch_assoc($result);
                    $stock = $row["stock"];

                    $query = mysqli_query($conn, "SELECT amount FROM tb_incoming_stock WHERE id = '$id'");
                    $array = mysqli_fetch_assoc($query);
                    $s_amount = $array["amount"];

                    $save = $amount - $s_amount;
                    
                    $total = $stock + $save;

                    //$query update data
                    $query = "UPDATE tb_stock SET
                                stock = '$total'
                                WHERE item = '$name' AND supplier = '$supplier' 
                            ";       
                    mysqli_query($conn, $query);

                    //$query update data
                    $query = "UPDATE tb_incoming_stock SET
                                amount = '$amount',
                                description ='$description',
                                user = '$id_user'
                                WHERE id = $id
                            ";
                    mysqli_query($conn, $query);

                    return mysqli_affected_rows($conn);
                }
                else
                {
                    echo "<script> alert('Stock Tidak Ada!')</script>";
                    return false;
                }
            }
            else
            {
                echo "<script> alert('Category Tidak Ada!')</script>";
                return false;
            }
        }
        else
        {
            echo "<script> alert('Supplier Tidak Ada!')</script>";
            return false;
        }
    }
?>