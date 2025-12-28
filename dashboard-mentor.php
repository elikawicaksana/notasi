<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notasi | Admin List</title>
    <link href="src/output.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;  /* Firefox */
        }
    </style>
    <?php
        include 'config/koneksi.php';

        $limit = 5;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $start = ($page > 1) ? ($page * $limit) - $limit : 0;

        $queryTotal = mysqli_query($conn, "SELECT COUNT(*) as total FROM db_notasi.tb_user WHERE role = 'Admin'");
        $rowTotal = mysqli_fetch_assoc($queryTotal);
        $totalData = $rowTotal['total'];
        $totalPages = ceil($totalData / $limit);

        $queryAdmins = mysqli_query($conn, "SELECT * FROM db_notasi.tb_user WHERE role = 'Admin' ORDER BY id_user DESC LIMIT $start, $limit");
    ?>
</head>
<body class="dark bg-main-blue font-sans">
    <?php 
        include 'include/navbar-dashboard.php'; 
        include 'include/sidebar-mentor.php'; 
    ?>
    <div class="p-8 sm:ml-64 mt-14">
        <div class="p-4">
            <div class="w-full mb-24"> 
                
            </div>
        </div>
    </div>
    <script src="./node_modules/flowbite/dist/flowbite.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        var tableData=$('#tableData');

        tableData.on("click","#btnDel",function(){
    	var validasi=confirm("Are you sure you want to delete this user?");
    	if(validasi){
	    	var btn=$(this);
	    	var id_user=$(this).attr("data-id");
	    	// alert(id_user);
	    	var promise=$.ajax({
	    		url  : 'proses/prosesQuery.php',
	    		type : 'POST',
	    		dataType: 'json',
	    		cache   : false,
	    		data    : {
	    			flag  : "prosesHapusUser",
	    			id_user : id_user
	    		},
	    		success: function(data){
                    if(data.success == "sukses"){
                        alert("Successfully deleted data!");
                        location.reload(); 
                    } else {
                        alert("Failed to delete data.");
                    }
                }
	    	});
	    }else{
	    	alert("Be careful!");
	    }
    });
    </script>
</body>
</html>