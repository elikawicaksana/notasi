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

        $limit = 4;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $start = ($page > 1) ? ($page * $limit) - $limit : 0;

        if (!isset($_SESSION['id_user'])) {
            header("Location: login.php");
            exit;
        }
        $id_mentor = $_SESSION['id_user']; 

        $sql = "SELECT 
                    c.*, 
                    u.name AS mentor_name,
                    (SELECT COUNT(*) FROM db_notasi.tb_modules m WHERE m.id_course = c.id_course) AS total_modules,
                    (SELECT COUNT(*) FROM db_notasi.tb_enrollments e WHERE e.id_course = c.id_course) AS total_enrolled
                FROM db_notasi.tb_courses c
                JOIN db_notasi.tb_user u ON c.id_mentor = u.id_user
                WHERE c.id_mentor = '$id_mentor' AND c.`status`= 'Published'
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
                        <h2 class="text-2xl font-bold text-white">Published Post</h2>
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
                                            <div class="grid grid-cols-3 gap-2">
                                                <a href="course-detail.php?id=<?php echo $row['id_course']; ?>" 
                                                class="flex items-center justify-center px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md transition text-sm font-medium">
                                                    <i class="fa-solid fa-eye mr-1"></i> View
                                                </a>
                                                <a href="edit-course.php?id=<?php echo $row['id_course']; ?>" 
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
                    <?php 
                    } else {
                        echo '<div class="text-center p-10 text-gray-500 bg-[#111827] rounded-lg">You haven\'t published any courses yet.</div>';
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
            var validasi = confirm("Are you sure you want to delete this course?");
            if(validasi){
                var btn = $(this);
                var id_course = $(this).attr("data-id");
                
                // UNCOMMENT AND ADJUST THE AJAX BELOW WHEN READY
                /*
                $.ajax({
                   url  : 'proses/prosesQuery.php',
                   type : 'POST',
                   dataType: 'json',
                   data    : {
                       flag  : "prosesHapusCourse",
                       id_course : id_course
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
                */
               alert("Delete functionality ready for ID: " + id_course);
            }
        });
    </script>
</body>
</html>