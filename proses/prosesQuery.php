<?php
    include '../config/koneksi.php';
    session_start();

    $flag=$_POST['flag'];

    if($flag=="prosesTambahUser"){
        // var_dump($_POST['name']);
        // var_dump($_POST['username']);
        // var_dump($_POST['passwd']);
        // var_dump($_POST['email']);
        // var_dump($_POST['role']);

        $options = [
            'cost' => 10,
        ];
        $password_hash = password_hash($_POST['password'],PASSWORD_DEFAULT,$options);
        // echo $password_hash;

        $insertUser=mysqli_query($conn,"INSERT INTO db_notasi.tb_user(`name`, username, passwd, email, `role`)
                                        VALUES
                                        ('".$_POST['name']."','".$_POST['username']."','".$password_hash."','".$_POST['email']."', '".$_POST['role']."')
                                       ")OR die(mysqli_error($conn));

        if($insertUser==true){
            echo "<script type='text/javascript'>\n";
            echo "alert('Successfully Add Data!');";
            echo "window.location = ('../dashboard.php');";
            echo "</script>";
        }else{
            echo "<script type='text/javascript'>\n";
            echo "alert('Sorry, there's an error in the system.');";
            echo "window.location = ('../add-new-user.php');";
            echo "</script>";
        }
    }elseif($flag=="prosesHapusUser"){
		$id_user=$_POST['id_user'];
		$delQuery=mysqli_query($conn,"DELETE FROM db_notasi.tb_user WHERE id_user='".$id_user."'") OR die(mysqli_error($conn));
		if($delQuery==true){
			$data['success']="sukses";
		}else{
			$data['success']="gagal";
		}
		echo json_encode($data);
	}
?>