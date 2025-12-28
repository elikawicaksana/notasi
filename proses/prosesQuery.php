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
    } elseif ($flag == "prosesTambahCourse") {

        // 1. Enable Error Reporting
        mysqli_report(MYSQLI_REPORT_OFF);
        
        if (empty($_POST)) {
            die("Error: No data received. Check PHP post_max_size.");
        }

        // 2. Session Check
        if (!isset($_SESSION['id_user'])) {
            die("Error: Session expired. Please login again.");
        }

        $id_mentor = $_SESSION['id_user'];
        $title     = mysqli_real_escape_string($conn, $_POST['title']);
        $category  = mysqli_real_escape_string($conn, $_POST['category']);
        $status    = mysqli_real_escape_string($conn, $_POST['status']);
        $desc      = mysqli_real_escape_string($conn, $_POST['desc']); 

        // 3. Image Upload
        $db_thumbnail_path = "";
        $server_upload_path = "";
        
        if (isset($_FILES['thumbnail']['tmp_name']) && $_FILES['thumbnail']['tmp_name'] != "") {
            $file_tmp    = $_FILES['thumbnail']['tmp_name'];
            $file_name   = $_FILES['thumbnail']['name'];
            $file_ext    = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
            $allowed_ext = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

            if (in_array($file_ext, $allowed_ext)) {
                $clean_filename = date('Ymd-His') . '-' . uniqid() . '.' . $file_ext;
                $server_upload_path = '../dist/img/' . $clean_filename;
                $db_thumbnail_path  = 'dist/img/' . $clean_filename;

                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }

                if (!move_uploaded_file($file_tmp, $server_upload_path)) {
                    die("Error: Failed to move file to $server_upload_path");
                }
            } else {
                die("Error: Invalid file format.");
            }
        }

        // 4. Transaction
        mysqli_begin_transaction($conn);

        try {
            // A. Insert Course
            $sqlCourse = "INSERT INTO db_notasi.tb_courses (title, id_mentor, thumbnail, category, `desc`, `status`, created_at) 
                          VALUES ('$title', '$id_mentor', '$db_thumbnail_path', '$category', '$desc', '$status', CURRENT_TIMESTAMP())";
            
            if (!mysqli_query($conn, $sqlCourse)) {
                throw new Exception("Error saving course: " . mysqli_error($conn));
            }

            $new_course_id = mysqli_insert_id($conn);

            // B. Insert Modules (Now with ORDER)
            if (isset($_POST['modules']) && is_array($_POST['modules'])) {
                
                // $index starts at 0, so we use it to calculate order
                foreach ($_POST['modules'] as $index => $module) {
                    
                    $modTitle   = mysqli_real_escape_string($conn, $module['title']);
                    $modLink    = mysqli_real_escape_string($conn, $module['link']);
                    $modContent = mysqli_real_escape_string($conn, $module['content']);
                    
                    // Determine Order (Index + 1)
                    $orderVal = $index + 1;

                    // Note: `order` is a reserved word, must use backticks ``
                    $sqlModule = "INSERT INTO db_notasi.tb_modules (id_course, title, content_url, content_body, `order`) 
                                  VALUES ('$new_course_id', '$modTitle', '$modLink', '$modContent', '$orderVal')";

                    if (!mysqli_query($conn, $sqlModule)) {
                        throw new Exception("Error saving module #$orderVal: " . mysqli_error($conn));
                    }
                }
            }

            mysqli_commit($conn);
            
            echo "<script>
                    alert('Course and Modules successfully saved!'); 
                    window.location = ('../mentor-add-course.php'); 
                  </script>";

        } catch (Exception $e) {
            mysqli_rollback($conn);
            
            if (!empty($thumbnail_path) && file_exists('../dist/img/' . $thumbnail_path)) {
                unlink('../dist/img/' . $thumbnail_path);
            }

            // Safe Error Output
            $safeError = json_encode($e->getMessage());
            echo "<script>
                    alert('Transaction Failed: ' + $safeError); 
                    window.history.back();
                  </script>";
        }
    }elseif ($flag == "prosesEditCourse") {
        mysqli_report(MYSQLI_REPORT_OFF);

        if (empty($_POST)) die("Error: No data.");
        if (!isset($_SESSION['id_user'])) die("Error: Session expired.");

        $id_mentor = $_SESSION['id_user'];
        $id_course = $_POST['id_course'];
        $title     = mysqli_real_escape_string($conn, $_POST['title']);
        $category  = mysqli_real_escape_string($conn, $_POST['category']);
        $status    = mysqli_real_escape_string($conn, $_POST['status']);
        $desc      = mysqli_real_escape_string($conn, $_POST['desc']); 
        $old_thumb = $_POST['old_thumbnail'];

        // Ownership Check
        $check = mysqli_query($conn, "SELECT id_mentor FROM db_notasi.tb_courses WHERE id_course='$id_course'");
        $owner = mysqli_fetch_assoc($check);
        if (!$owner || $owner['id_mentor'] != $id_mentor) die("Error: Unauthorized.");

        // Image Logic
        $db_thumbnail_path = $old_thumb;
        $server_upload_path = "";

        if (isset($_FILES['thumbnail']['tmp_name']) && $_FILES['thumbnail']['tmp_name'] != "") {
            $file_ext = strtolower(pathinfo($_FILES['thumbnail']['name'], PATHINFO_EXTENSION));
            if (in_array($file_ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                $clean_filename = date('Ymd-His') . '-' . uniqid() . '.' . $file_ext;
                
                $upload_dir = '../dist/img/'; // DEFINED HERE
                $server_upload_path = $upload_dir . $clean_filename;
                $db_thumbnail_path  = 'dist/img/' . $clean_filename;

                if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
                
                if (!move_uploaded_file($_FILES['thumbnail']['tmp_name'], $server_upload_path)) {
                    die("Error: Failed to upload image.");
                }
            } else {
                die("Error: Invalid format.");
            }
        }

        mysqli_begin_transaction($conn);
        try {
            // Update Course - REMOVED 'updated_at' because your DB doesn't have it
            $sqlCourse = "UPDATE db_notasi.tb_courses 
                          SET title='$title', category='$category', `desc`='$desc', `status`='$status', thumbnail='$db_thumbnail_path'
                          WHERE id_course='$id_course'";
            
            if (!mysqli_query($conn, $sqlCourse)) throw new Exception(mysqli_error($conn));

            // Sync Modules: Delete Old -> Insert New
            if (!mysqli_query($conn, "DELETE FROM db_notasi.tb_modules WHERE id_course='$id_course'")) {
                throw new Exception(mysqli_error($conn));
            }

            if (isset($_POST['modules']) && is_array($_POST['modules'])) {
                foreach ($_POST['modules'] as $index => $module) {
                    $mTitle   = mysqli_real_escape_string($conn, $module['title']);
                    $mLink    = mysqli_real_escape_string($conn, $module['link']);
                    $mContent = mysqli_real_escape_string($conn, $module['content']);
                    $order    = $index + 1;

                    $sqlMod = "INSERT INTO db_notasi.tb_modules (id_course, title, content_url, content_body, `order`) 
                               VALUES ('$id_course', '$mTitle', '$mLink', '$mContent', '$order')";
                    
                    if (!mysqli_query($conn, $sqlMod)) throw new Exception(mysqli_error($conn));
                }
            }

            mysqli_commit($conn);
            
            // Cleanup old image if replaced
            if ($server_upload_path != "" && $old_thumb != "" && file_exists('../' . $old_thumb) && strpos($old_thumb, 'default') === false) {
                unlink('../' . $old_thumb);
            }

            echo "<script>alert('Course updated!'); window.location='../mentor-published-list.php';</script>";

        } catch (Exception $e) {
            mysqli_rollback($conn);
            if (!empty($server_upload_path) && file_exists($server_upload_path)) unlink($server_upload_path);
            echo "<script>alert('Update Failed: " . addslashes($e->getMessage()) . "'); window.history.back();</script>";
        }
    }
?>