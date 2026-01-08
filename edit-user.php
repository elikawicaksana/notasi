<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notasi | Edit User Information</title>
    <link href="src/output.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="icon" type="image/png" href="dist/img/favicon-96x96.png" sizes="96x96" />
    <link rel="shortcut icon" href="dist/img/favicon.ico" />
    <style>
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;  
            scrollbar-width: none; 
        }
    </style>
    <?php
        include 'config/koneksi.php';

        if (!isset($_SESSION['id_user'])) {
            echo "<script type='text/javascript'>\n";
            echo "alert('Please login first!');";
            echo "window.location = ('index.php');";
            echo "</script>";
        }

        if($_SESSION['role']!='Admin'){
            echo "<script type='text/javascript'>\n";
            echo "alert('You are not an admin!');";
            echo "window.location = ('index.php');";
            echo "</script>";
        }

        $queryUser=mysqli_query($conn,"SELECT * FROM db_notasi.tb_user 
                                      WHERE id_user='".$_GET['id_user']."'
                                     ") OR die(mysqli_error($conn)); 
	    $fetchUser=mysqli_fetch_array($queryUser);
    ?>
</head>
<body class="dark bg-main-blue font-sans">
    <?php 
        include 'include/navbar-dashboard.php';
        include 'include/sidebar.php'; 
    ?>
    <div class="p-8 sm:ml-64 mt-14">
        <div class="p-4">
            <div class="w-full mb-24"> 
                <div class="relative overflow-hidden w-full bg-neutral-primary-soft shadow-xs rounded-base border border-default p-6">
                    <h2 class="mb-6 text-xl font-bold text-heading">Edit <?php echo $fetchUser['name']; ?>'s Information</h2>
                    <form action="proses/prosesQuery.php" method="post" autocomplete="off" enctype="multipart/form-data">
                        <input type="hidden" name="flag" value="prosesEditUser">
                        <input type="hidden" name="id_user" value="<?php echo $_GET['id_user']?>">
                        <input type="hidden" name="fotoLama" value="<?php echo $fetchUser['foto'] ?>">
                        <div class="grid gap-4 mb-4 grid-cols-2 gap-6 mb-5">
                            <div class="w-full">
                                <label for="student-name" class="block mb-2 text-sm font-medium text-heading">Name</label>
                                <input type="text" name="name" id="name" value="<?php echo $fetchUser['name']; ?>" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-md focus:ring-brand focus:border-brand block w-full p-2.5 placeholder:text-body" placeholder="Type full name" required="">
                            </div>
                            <div class="w-full">
                                <label for="username" class="block mb-2 text-sm font-medium text-heading">Username</label>
                                <input type="text" name="username" id="username" value="<?php echo $fetchUser['username']; ?>" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-md focus:ring-brand focus:border-brand block w-full p-2.5 placeholder:text-body" placeholder="Type username" required="">
                            </div>
                            <div class="w-full">
                                <label for="email" class="block mb-2 text-sm font-medium text-heading">Email</label>
                                <input type="email" name="email" id="email" value="<?php echo $fetchUser['email']; ?>" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-md focus:ring-brand focus:border-brand block w-full p-2.5 placeholder:text-body" placeholder="Type email" required="">
                            </div>
                            <div class="w-full">
                                <label for="role" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Role</label>
                                <select id="role" name="role" class="bg-gray-200 border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                    <option disabled selected>Select Role</option>
                                    <option value="Admin" <?php if($fetchUser['role']=="Admin"){echo "selected";} ?>>Admin</option>
                                    <option value="Mentor" <?php if($fetchUser['role']=="Mentor"){echo "selected";} ?>>Mentor</option>
                                    <option value="Student" <?php if($fetchUser['role']=="Student"){echo "selected";} ?>>Student</option>
                                </select>
                            </div>
                            <div class="col-span-2">
                                <label class="block mb-2.5 text-sm font-medium text-heading" for="file_input">Upload Profile Picture</label>
                                <input class="cursor-pointer bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full shadow-xs placeholder:text-body" id="foto" name="foto" type="file" accept="image/*">
                            </div>
                        </div>
                        <button type="submit" class="inline-flex items-center text-white bg-[#708238] hover:bg-[#006D4C] box-border border border-transparent focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none">
                            Edit User
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="./node_modules/flowbite/dist/flowbite.min.js"></script>
</body>
</html>