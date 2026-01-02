<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notasi | Mentor List</title>
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
        include "config/koneksi.php";

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

        $limit = 5; 
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $start = ($page > 1) ? ($page * $limit) - $limit : 0;

        $queryTotal = mysqli_query($conn, "SELECT COUNT(*) as total FROM db_notasi.tb_user WHERE role = 'Mentor'");
        $rowTotal = mysqli_fetch_assoc($queryTotal);
        $totalData = $rowTotal['total'];
        $totalPages = ceil($totalData / $limit);
        $queryMentors = mysqli_query($conn, "SELECT * FROM db_notasi.tb_user WHERE role = 'Mentor' ORDER BY id_user DESC LIMIT $start, $limit");
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
                <div class="relative overflow-hidden w-full bg-neutral-primary-soft shadow-xs rounded-base border border-default">
                    
                    <div class="flex flex-col md:flex-row items-center justify-between space-y-4 md:space-y-0 p-4 border-b border-default-medium">
                        <div class="w-full md:w-auto">
                            <h2 class="text-2xl font-semibold text-heading">Mentors List</h2>
                            <p class="text-[#708238] font-medium">Active Members</p>
                        </div>
                        
                        <div class="flex flex-col md:flex-row items-center w-full md:w-auto space-y-2 md:space-y-0 md:space-x-3">
                            <div class="relative w-full md:w-auto">
                                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-body" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"/></svg>
                                </div>
                                <input type="text" id="simple-search" class="block w-full max-w-96 ps-9 pe-3 py-2 bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand shadow-xs placeholder:text-body" placeholder="Search Mentor...">
                            </div>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left rtl:text-right text-body" id="tableData">
                            <thead class="text-sm text-body bg-neutral-secondary-medium border-b border-default-medium">
                                <tr>
                                    <th scope="col" class="px-6 py-3 font-medium">Name</th>
                                    <th scope="col" class="px-6 py-3 font-medium">Username</th>
                                    <th scope="col" class="px-6 py-3 font-medium">Course Stats</th>
                                    <th scope="col" class="px-6 py-3 font-medium">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    // LOOP DATA DARI DATABASE
                                    if(mysqli_num_rows($queryMentors) > 0){
                                        while($row = mysqli_fetch_assoc($queryMentors)) {
                                            $idUser = $row['id_user'];
                                            // Fallback foto profile
                                            $foto = !empty($row['foto']) ? $row['foto'] : "https://flowbite.com/docs/images/people/profile-picture-5.jpg";
                                            
                                            // Query Hitung Draft
                                            $qEnroll = mysqli_query($conn, "SELECT COUNT(*) as jml FROM db_notasi.tb_courses WHERE id_mentor = '$idUser' AND  `status`='Draft' ");
                                            $jmlEnroll = mysqli_fetch_assoc($qEnroll)['jml'];

                                            // Query Hitung Published
                                            $qComplete = mysqli_query($conn, "SELECT COUNT(*) as jml FROM db_notasi.tb_courses WHERE id_mentor = '$idUser' AND `status`='Published' ");
                                            $jmlComplete = mysqli_fetch_assoc($qComplete)['jml'];
                                ?>
                                <tr class="bg-neutral-primary-soft border-b border-default hover:bg-neutral-secondary-medium transition-colors duration-200">
                                    
                                    <th scope="row" class="flex items-center px-6 py-4 text-heading whitespace-nowrap">
                                        <img class="w-10 h-10 rounded-full ring-2 ring-gray-700" src="<?= $foto ?>" alt="<?= $row['name'] ?>">
                                        <div class="ps-3">
                                            <div class="text-base font-semibold text-white"><?= $row['name'] ?></div>
                                            <div class="font-normal text-gray-400"><?= $row['email'] ?></div>
                                        </div>  
                                    </th>
                                    
                                    <td class="px-6 py-4 text-gray-300">
                                        @<?= $row['username'] ?>
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="flex flex-col space-y-1">
                                            <span class="text-xs font-medium px-2.5 py-0.5 rounded bg-danger text-gray-300 border border-gray-600 w-fit">
                                                Draft: <?= $jmlEnroll ?>
                                            </span>
                                            <span class="text-xs font-medium px-2.5 py-0.5 rounded bg-[#708238]/20 text-[#8FA348] border border-[#708238] w-fit">
                                                Published: <?= $jmlComplete ?>
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <a href="edit-user.php?id_user=<?= $idUser ?>" class="font-medium text-[#708238] hover:text-[#8FA348] hover:underline transition-colors">Edit</a> |
                                        <button id="btnDel" data-id=<?= $idUser ?> class="font-medium text-fg-danger hover:text-danger hover:underline transition-colors">Delete</button>
                                    </td>
                                </tr>
                                <?php 
                                        } // End While
                                    } else { 
                                ?>
                                    <tr>
                                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                            Belum ada data Mentor.
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>

                    <nav class="flex flex-col md:flex-row justify-between items-center space-y-3 md:space-y-0 p-4 border-t border-default-medium" aria-label="Table navigation">
                        
                        <span class="text-sm font-normal text-gray-400">
                            Showing <span class="font-semibold text-white"><?= ($totalData > 0) ? $start + 1 : 0 ?></span> 
                            to <span class="font-semibold text-white"><?= min($start + $limit, $totalData) ?></span> 
                            of <span class="font-semibold text-white"><?= $totalData ?></span> entries
                        </span>
                        
                        <ul class="inline-flex items-center -space-x-px md:space-x-0 gap-2 text-sm h-8">
                            
                            <li>
                                <?php if($page > 1): ?>
                                    <a href="?page=<?= $page - 1 ?>" class="flex items-center justify-center px-3 h-9 leading-tight text-gray-400 bg-transparent border border-gray-600 rounded-lg hover:bg-gray-700 hover:text-white transition-all">
                                        <span class="sr-only">Previous</span>
                                        <svg class="w-2.5 h-2.5 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/>
                                        </svg>
                                    </a>
                                <?php else: ?>
                                    <span class="flex items-center justify-center px-3 h-9 leading-tight text-gray-600 bg-transparent border border-gray-800 rounded-lg cursor-not-allowed opacity-50">
                                        <svg class="w-2.5 h-2.5 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/>
                                        </svg>
                                    </span>
                                <?php endif; ?>
                            </li>

                            <?php for($i = 1; $i <= $totalPages; $i++): ?>
                                <li>
                                    <?php if($i == $page): ?>
                                        <span class="flex items-center justify-center px-3 h-9 text-white bg-gradient-to-br from-[#708238] to-[#506028] border border-[#708238] rounded-lg shadow-[0_4px_10px_rgba(112,130,56,0.4)] font-bold transform scale-105">
                                            <?= $i ?>
                                        </span>
                                    <?php else: ?>
                                        <a href="?page=<?= $i ?>" class="flex items-center justify-center px-3 h-9 leading-tight text-gray-400 bg-transparent border border-gray-600 rounded-lg hover:bg-gray-700 hover:text-white hover:border-gray-500 transition-all">
                                            <?= $i ?>
                                        </a>
                                    <?php endif; ?>
                                </li>
                            <?php endfor; ?>

                            <li>
                                <?php if($page < $totalPages): ?>
                                    <a href="?page=<?= $page + 1 ?>" class="flex items-center justify-center px-3 h-9 leading-tight text-gray-400 bg-transparent border border-gray-600 rounded-lg hover:bg-gray-700 hover:text-white transition-all">
                                        <span class="sr-only">Next</span>
                                        <svg class="w-2.5 h-2.5 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                                        </svg>
                                    </a>
                                <?php else: ?>
                                    <span class="flex items-center justify-center px-3 h-9 leading-tight text-gray-600 bg-transparent border border-gray-800 rounded-lg cursor-not-allowed opacity-50">
                                        <svg class="w-2.5 h-2.5 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                                        </svg>
                                    </span>
                                <?php endif; ?>
                            </li>

                        </ul>
                    </nav>

                </div>
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