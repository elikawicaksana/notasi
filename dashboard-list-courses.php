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

        if($_SESSION['role']!='Admin'){
            echo "<script type='text/javascript'>\n";
            echo "alert('You are not an admin!');";
            echo "window.location = ('index.php');";
            echo "</script>";
        }

        $limit = 5;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $start = ($page > 1) ? ($page * $limit) - $limit : 0;

        $queryTotal = mysqli_query($conn, "SELECT COUNT(*) as total FROM db_notasi.tb_courses");
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
                ORDER BY c.id_course DESC 
                LIMIT $start, $limit";

        $queryCourses = mysqli_query($conn, $sql) OR die(mysqli_error($conn));
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
                            <h2 class="text-2xl font-semibold text-heading">Courses List</h2>
                            <p class="text-[#708238] font-medium">Manage Your Content</p>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left rtl:text-right text-body" id="tableData">
                            <thead class="text-sm text-body bg-neutral-secondary-medium border-b border-default-medium">
                                <tr>
                                    <th scope="col" class="px-6 py-3 font-medium">Title</th>
                                    <th scope="col" class="px-6 py-3 font-medium">Mentor</th>
                                    <th scope="col" class="px-6 py-3 font-medium">Status</th>
                                    <th scope="col" class="px-6 py-3 font-medium text-center">Modules Total</th>
                                    <th scope="col" class="px-6 py-3 font-medium text-center">Enrolled Stats</th>
                                    <th scope="col" class="px-6 py-3 font-medium">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    if(mysqli_num_rows($queryCourses) > 0){
                                        while($row = mysqli_fetch_assoc($queryCourses)) {
                                            $idCourse = $row['id_course'];
                                            $thumbnail = !empty($row['thumbnail']) ? $row['thumbnail'] : "dist/img/thumbnail.png"; 
                                            $statusColor = ($row['status'] == 'Published') ? 'bg-main-green text-white' : 'bg-yellow-600 text-white';
                                ?>
                                <tr class="bg-neutral-primary-soft border-b border-default hover:bg-neutral-secondary-medium transition-colors duration-200">
                                    <th scope="row" class="flex items-center px-6 py-4 text-heading whitespace-nowrap">
                                        <img class="w-12 h-8 object-cover rounded-sm ring-1 ring-gray-700" src="<?= $thumbnail ?>" alt="<?= $row['title'] ?>">
                                        <div class="ps-3">
                                            <div class="text-base font-semibold text-white max-w-xs truncate" title="<?= $row['title'] ?>"><?= $row['title'] ?></div>
                                        </div>  
                                    </th>
                                    <td class="px-6 py-4 text-gray-300">
                                        <div class="flex items-center">
                                            <p>
                                                <i class="fa-solid fa-chalkboard-user mr-2 text-gray-500"></i><?= $row['mentor_name'] ?>
                                            </p>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-xs font-medium px-2.5 py-0.5 rounded border border-white/10 <?= $statusColor ?>">
                                            <?= $row['status'] ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="text-gray-300 font-semibold bg-gray-700 px-3 py-1 rounded-full text-xs">
                                            <?= $row['total_modules'] ?> Modules
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="text-[#8FA348] font-semibold bg-[#708238]/20 border border-[#708238] px-3 py-1 rounded text-xs">
                                            <i class="fa-solid fa-users mr-1"></i> <?= $row['total_enrolled'] ?> Students
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <a href="view-course.php?id_course=<?= $idCourse ?>" class="font-medium text-blue-400 hover:text-fg-brand hover:underline transition-colors">View</a> | 
                                        <button id="btnDel" class="font-medium text-fg-danger hover:text-danger hover:underline transition-colors" data-id="<?= $idCourse ?>">Delete</button>
                                    </td>
                                </tr>
                                <?php 
                                        } 
                                    } else { 
                                ?>
                                    <tr>
                                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                            Belum ada data course.
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <nav class="flex flex-col md:flex-row justify-between items-center space-y-3 md:space-y-0 p-4 border-t border-default-medium">
                        <span class="text-sm font-normal text-gray-400">
                            Showing <span class="font-semibold text-white"><?= ($totalData > 0) ? $start + 1 : 0 ?></span> 
                            to <span class="font-semibold text-white"><?= min($start + $limit, $totalData) ?></span> 
                            of <span class="font-semibold text-white"><?= $totalData ?></span> entries
                        </span>
                        
                        <ul class="inline-flex items-center -space-x-px md:space-x-0 gap-2 text-sm h-8">
                            <li>
                                <?php if($page > 1): ?>
                                    <a href="?page=<?= $page - 1 ?>" class="flex items-center justify-center px-3 h-9 text-gray-400 bg-transparent border border-gray-600 rounded-lg hover:bg-gray-700 hover:text-white">
                                        <i class="fa-solid fa-chevron-left"></i>
                                    </a>
                                <?php else: ?>
                                    <span class="flex items-center justify-center px-3 h-9 text-gray-600 bg-transparent border border-gray-800 rounded-lg cursor-not-allowed opacity-50">
                                        <i class="fa-solid fa-chevron-left"></i>
                                    </span>
                                <?php endif; ?>
                            </li>
                            <?php for($i = 1; $i <= $totalPages; $i++): ?>
                                <li>
                                    <?php if($i == $page): ?>
                                        <span class="flex items-center justify-center px-3 h-9 text-white bg-gradient-to-br from-[#708238] to-[#506028] border border-[#708238] rounded-lg shadow-lg font-bold transform scale-105">
                                            <?= $i ?>
                                        </span>
                                    <?php else: ?>
                                        <a href="?page=<?= $i ?>" class="flex items-center justify-center px-3 h-9 text-gray-400 bg-transparent border border-gray-600 rounded-lg hover:bg-gray-700 hover:text-white">
                                            <?= $i ?>
                                        </a>
                                    <?php endif; ?>
                                </li>
                            <?php endfor; ?>
                            <li>
                                <?php if($page < $totalPages): ?>
                                    <a href="?page=<?= $page + 1 ?>" class="flex items-center justify-center px-3 h-9 text-gray-400 bg-transparent border border-gray-600 rounded-lg hover:bg-gray-700 hover:text-white">
                                        <i class="fa-solid fa-chevron-right"></i>
                                    </a>
                                <?php else: ?>
                                    <span class="flex items-center justify-center px-3 h-9 text-gray-600 bg-transparent border border-gray-800 rounded-lg cursor-not-allowed opacity-50">
                                        <i class="fa-solid fa-chevron-right"></i>
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
                var id_course=$(this).attr("data-id");
                alert(id_course);   
                // var promise=$.ajax({
                //     url  : 'proses/prosesQuery.php',
                //     type : 'POST',
                //     dataType: 'json',
                //     cache   : false,
                //     data    : {
                //         flag  : "prosesHapusCourse",
                //         id_course : id_course
                //     },
                //     success: function(data){
                //         if(data.success == "sukses"){
                //             alert("Successfully deleted data!");
                //             location.reload(); 
                //         } else {
                //             alert("Failed to delete data.");
                //         }
                //     }
                // });
            }else{
                alert("Be careful!");
            }
        });
    </script>
</body>
</html>