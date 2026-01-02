<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notasi | Course List</title>
    <link href="src/output.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
    <?php
        include 'config/koneksi.php';

        if (!isset($_SESSION['id_user'])) {
            echo "<script type='text/javascript'>\n";
            echo "alert('Please login first!');";
            echo "window.location = ('index.php');";
            echo "</script>";
        }

        if($_SESSION['role']!='Mentor'){
            echo "<script type='text/javascript'>\n";
            echo "alert('You are not a mentor!');";
            echo "window.location = ('index.php');";
            echo "</script>";
        }

        $limit = 4;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $start = ($page > 1) ? ($page * $limit) - $limit : 0;
        
        $id_mentor = $_SESSION['id_user'];

        // Count total Draft courses for this mentor
        $queryTotal = mysqli_query($conn, "SELECT COUNT(*) as total FROM db_notasi.tb_courses WHERE id_mentor = '$id_mentor' AND `status`= 'Draft'");
        $rowTotal = mysqli_fetch_assoc($queryTotal);
        $totalData = $rowTotal['total'];
        $totalPages = ceil($totalData / $limit);

        $sql = "SELECT 
                    c.*, 
                    u.name AS mentor_name,
                    (SELECT COUNT(*) FROM db_notasi.tb_modules m WHERE m.id_course = c.id_course) AS total_modules,
                    (SELECT COUNT(*) FROM db_notasi.tb_enrollments e WHERE e.id_course = c.id_course) AS total_enrolled
                FROM db_notasi.tb_courses c
                JOIN db_notasi.tb_user u ON c.id_mentor = u.id_user
                WHERE c.id_mentor = '$id_mentor' AND c.`status`= 'Draft'
                ORDER BY c.id_course DESC 
                LIMIT $start, $limit";

        $queryCourses = mysqli_query($conn, $sql) OR die(mysqli_error($conn));
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
               <div class="w-full mb-24">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-white">Draft Post</h2>
                    </div>
                    <?php
                    if (mysqli_num_rows($queryCourses) > 0) {
                    ?>
                        <div id="courseContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                            <?php while ($row = mysqli_fetch_array($queryCourses)) { 
                                $banner = !empty($row['thumbnail']) ? $row['thumbnail'] : "dist/img/thumbnail.png";
                            ?>
                                <div class="bg-[#111827] rounded-xl overflow-hidden shadow-lg border border-gray-800 flex flex-col h-full">
                                    <div class="relative h-48 overflow-hidden group">
                                        <img src="<?php echo $banner; ?>" alt="Course Banner" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                                    </div>
                                    <div class="p-5 flex flex-col flex-grow">
                                        <p class="text-[#708238] text-xs font-semibold mb-1 uppercase tracking-wide">
                                            <?php echo htmlspecialchars($row['mentor_name']); ?>
                                        </p>
                                        <h3 class="text-white text-lg font-bold leading-tight mb-3 line-clamp-2">
                                            <?php echo htmlspecialchars($row['title']); ?>
                                        </h3>
                                        <div class="mb-3">
                                            <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-medium bg-gray-800 text-gray-400 border border-gray-700">
                                                <i class="fa-solid fa-tag text-[10px] text-gray-500"></i>
                                                <?php echo htmlspecialchars($row['category']); ?>
                                            </span>
                                        </div>
                                        <div class="flex items-center text-gray-400 text-sm mb-4">
                                            <i class="fa-solid fa-layer-group text-gray-500 mr-2"></i>
                                            <span><?php echo htmlspecialchars($row['total_modules']); ?> Modules</span>
                                        </div>
                                        <div class="mt-auto">
                                            <div class="flex items-center text-gray-300 mb-4">
                                                <i class="fa-solid fa-users mr-2"></i>
                                                <div>
                                                    <span class="text-xl font-bold text-white">
                                                        <?php echo number_format($row['total_enrolled']); ?>
                                                    </span>
                                                    <span class="text-xs text-gray-500 ml-1">Students</span>
                                                </div>
                                            </div>
                                            <div class="grid grid-cols-2 gap-2">
                                                <a href="edit-course.php?id_course=<?php echo $row['id_course']; ?>" 
                                                class="flex items-center justify-center px-3 py-2 bg-yellow-400 hover:bg-yellow-500 text-gray-900 rounded-md transition text-sm font-bold">
                                                    <i class="fa-solid fa-pen-to-square mr-1"></i> Edit
                                                </a>
                                                <button data-id="<?php echo $row['id_course']; ?>" 
                                                        class="btnDel flex items-center justify-center px-3 py-2 bg-red-500 hover:bg-red-600 text-white rounded-md transition text-sm font-medium">
                                                    <i class="fa-solid fa-trash mr-1"></i> Del
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <!-- Pagination Controls -->
                        <?php if($totalPages > 1): ?>
                            <nav class="flex flex-col md:flex-row justify-between items-center mt-8 space-y-3 md:space-y-0" aria-label="Course pagination">
                                
                                <!-- Showing info -->
                                <span class="text-sm font-normal text-gray-400">
                                    Showing <span class="font-semibold text-white"><?= ($totalData > 0) ? $start + 1 : 0 ?></span> 
                                    to <span class="font-semibold text-white"><?= min($start + $limit, $totalData) ?></span> 
                                    of <span class="font-semibold text-white"><?= $totalData ?></span> courses
                                </span>
                                
                                <!-- Page buttons -->
                                <ul class="inline-flex items-center gap-2 text-sm h-8">
                                    
                                    <!-- Previous Button -->
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

                                    <!-- Page Numbers -->
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

                                    <!-- Next Button -->
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
                        <?php endif; ?>
                        
                    <?php 
                    } else {
                        echo '<div class="text-center p-10 text-gray-500 bg-[#111827] rounded-lg">You don\'t have any draft yet.</div>';
                    } 
                    ?>
                </div>
            </div>
        </div>
    </div>
    <script src="./node_modules/flowbite/dist/flowbite.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        var container = $('#courseContainer');
        container.on("click", ".btnDel", function(){
            var validasi = confirm("WARNING: This will permanently delete the course and ALL related data including:\n\n• All course modules\n• All student enrollments\n• All student progress\n• All certificates\n\nThis action CANNOT be undone!\n\nAre you sure you want to continue?");
            if(validasi){
                var btn = $(this);
                var id_course = $(this).attr("data-id");            
                $.ajax({
                    url  : 'proses/prosesQuery.php',
                    type : 'POST',
                    dataType: 'json',
                    cache   : false,
                    data    : {
                        flag  : "prosesHapusCourse",
                        id_course : id_course
                    },
                    success: function(data){
                        if(data.success == "sukses"){
                            alert(data.message);
                            location.reload(); 
                        } else if(data.success == "unauthorized"){
                            alert(data.message);
                        } else {
                            alert(data.message);
                        }
                    },
                    error: function(xhr, status, error){
                        alert("An error occurred: " + error);
                    }
                });
            }
        });
    </script>
</body>
</html>