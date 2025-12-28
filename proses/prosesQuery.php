<?php
    include '../config/koneksi.php';

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
	}elseif($flag=="prosesEditUser"){
        // var_dump($_POST['id_user']);
        // var_dump($_POST['name']);
        // var_dump($_POST['username']);
        // var_dump($_POST['email']);
        // var_dump($_POST['role']);
        // var_dump($_POST['fotoLama']);
        // var_dump($_POST['foto']);

        $foto=$_POST['fotoLama'];
        if($_FILES['foto']['tmp_name']!=""){
            $folder= "dist/img";
            $tmp_name=$_FILES['foto']["tmp_name"];
            $img_name=$_FILES['foto']['name'];
            $foto=$folder."/".date('Ymd-His')."USER-".$img_name;
            move_uploaded_file($tmp_name,"../".$foto);
        }
        $editQuery=mysqli_query($conn,"UPDATE db_notasi.tb_user
                                        SET `name`='".$_POST['name']."',username='".$_POST['username']."',email='".$_POST['email']."',role='".$_POST['role']."',foto='".$foto."' WHERE id_user='".$_POST['id_user']."' 
                                    ") OR die(mysqli_error($conn));
        if($editQuery==true){
            echo "<script type='text/javascript'>\n";
            echo "alert('Successfully edit user information');";
            echo "window.location = ('../edit-user.php?id_user=".$_POST['id_user']."');";
            echo "</script>";
        }else{
            echo "<script type='text/javascript'>\n";
            echo "alert('Failed to edit user information');";
            echo "window.location = ('../edit-user.php?id_user=".$_POST['id_user']."');";
            echo "</script>";
        }
    }elseif($flag=="prosesHapusCourse"){
        $id_course = $_POST['id_course'];
        $id_mentor = $_SESSION['id_user'];

        $checkOwner = mysqli_query($conn, "SELECT id_mentor FROM db_notasi.tb_courses WHERE id_course='".$id_course."'");
        $owner = mysqli_fetch_assoc($checkOwner);
        
        if($owner && $owner['id_mentor'] == $id_mentor) {
            mysqli_begin_transaction($conn);
            
            try {
                $delCertificates = mysqli_query($conn, "DELETE FROM db_notasi.tb_certificates WHERE id_course='".$id_course."'");
                if(!$delCertificates) throw new Exception("Failed to delete certificates");

                $delModuleCompletions = mysqli_query($conn, "DELETE db_notasi.tb_module_completions FROM db_notasi.tb_module_completions 
                                                            INNER JOIN db_notasi.tb_enrollments ON db_notasi.tb_module_completions.id_enroll = db_notasi.tb_enrollments.id_enroll 
                                                            WHERE db_notasi.tb_enrollments.id_course='".$id_course."'");
                if(!$delModuleCompletions) throw new Exception("Failed to delete module completions");

                $delEnrollments = mysqli_query($conn, "DELETE FROM db_notasi.tb_enrollments WHERE id_course='".$id_course."'");
                if(!$delEnrollments) throw new Exception("Failed to delete enrollments");

                $delModules = mysqli_query($conn, "DELETE FROM db_notasi.tb_modules WHERE id_course='".$id_course."'");
                if(!$delModules) throw new Exception("Failed to delete modules");

                $delCourse = mysqli_query($conn, "DELETE FROM db_notasi.tb_courses WHERE id_course='".$id_course."'");
                if(!$delCourse) throw new Exception("Failed to delete course");

                mysqli_commit($conn);
                $data['success'] = "sukses";
                $data['message'] = "Course and all related data deleted successfully";
                
            } catch (Exception $e) {
                mysqli_rollback($conn);
                $data['success'] = "gagal";
                $data['message'] = $e->getMessage();
            }
        } else {
            $data['success'] = "unauthorized";
            $data['message'] = "You don't have permission to delete this course";
        }
        
        echo json_encode($data);
    }
?>