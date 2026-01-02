<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notasi | My Ongoing Courses</title>
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
            echo "<script>alert('Please login first!'); window.location = ('index.php');</script>";
            exit;
        }

        if($_SESSION['role'] != 'Student'){
            echo "<script>alert('You are not authorized!'); window.location = ('dashboard.php');</script>";
            exit;
        }

        $id_user = $_SESSION['id_user'];

        $limit = 4; 
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $start = ($page > 1) ? ($page * $limit) - $limit : 0;

        $queryTotal = mysqli_query($conn, "SELECT COUNT(*) as total FROM db_notasi.tb_enrollments WHERE id_user = '$id_user' AND is_completed = 0");
        $rowTotal = mysqli_fetch_assoc($queryTotal);
        $totalData = $rowTotal['total'];
        $totalPages = ceil($totalData / $limit);

        $sql = "SELECT 
                    e.id_enroll,
                    e.enrolled_at,
                    e.progress_percentage, 
                    c.id_course,
                    c.title,
                    c.thumbnail,
                    c.category,
                    m.name AS mentor_name,
                    (SELECT COUNT(*) FROM db_notasi.tb_modules md WHERE md.id_course = c.id_course) AS total_modules
                FROM db_notasi.tb_enrollments e
                JOIN db_notasi.tb_courses c ON e.id_course = c.id_course
                JOIN db_notasi.tb_user m ON c.id_mentor = m.id_user
                WHERE e.id_user = '$id_user' AND e.is_completed = 0
                ORDER BY e.enrolled_at DESC 
                LIMIT $start, $limit";

        $queryCourses = mysqli_query($conn, $sql) OR die(mysqli_error($conn));
    ?>
</head>
<body class="dark bg-main-blue font-sans">  
    <?php 
        include 'include/navbar-dashboard.php'; 
        include 'include/sidebar-student.php'; 
    ?>
    <div class="p-8 sm:ml-64 mt-14">
        <div class="p-4">
            <div class="w-full mb-24"> 
               <div class="w-full mb-24">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h2 class="text-2xl font-bold text-white">My Ongoing Courses</h2>
                            <p class="text-gray-400 text-sm mt-1">Pick up where you left off and keep learning.</p>
                        </div>
                    </div>

                    <?php
                    if (mysqli_num_rows($queryCourses) > 0) {
                    ?>
                        <div id="courseContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                            <?php while ($row = mysqli_fetch_array($queryCourses)) { 
                                $banner = !empty($row['thumbnail']) ? $row['thumbnail'] : "dist/img/thumbnail.png";
                                $progress = $row['progress_percentage'];
                            ?>
                                <div class="bg-[#111827] rounded-xl overflow-hidden shadow-lg border border-gray-800 flex flex-col h-full hover:border-gray-600 transition-all">
                                    <div class="relative h-48 overflow-hidden group">
                                        <img src="<?php echo $banner; ?>" alt="Course Banner" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                                        
                                        <div class="absolute top-3 right-3">
                                            <span class="bg-blue-600 text-white text-[10px] font-bold px-2 py-1 rounded-full shadow-md">
                                                <i class="fa-solid fa-spinner fa-spin mr-1"></i> IN PROGRESS
                                            </span>
                                        </div>
                                    </div>
                                    <div class="p-5 flex flex-col flex-grow">
                                        <div class="flex justify-between items-start mb-2">
                                            <p class="text-[#708238] text-xs font-semibold uppercase tracking-wide">
                                                Mentor: <?php echo htmlspecialchars($row['mentor_name']); ?>
                                            </p>
                                        </div>
                                        
                                        <h3 class="text-white text-lg font-bold leading-tight mb-3 line-clamp-2">
                                            <?php echo htmlspecialchars($row['title']); ?>
                                        </h3>
                                        
                                        <div class="mb-4">
                                            <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-medium bg-gray-800 text-gray-400 border border-gray-700">
                                                <i class="fa-solid fa-tag text-[10px] text-gray-500"></i>
                                                <?php echo htmlspecialchars($row['category']); ?>
                                            </span>
                                        </div>

                                        <div class="mb-4">
                                            <div class="flex justify-between text-xs text-gray-400 mb-1">
                                                <span>Progress</span>
                                                <span class="text-white font-bold"><?php echo $progress; ?>%</span>
                                            </div>
                                            <div class="w-full bg-gray-700 rounded-full h-2.5">
                                                <div class="bg-gradient-to-r from-moss-light to-moss-dark h-2.5 rounded-full" style="width: <?php echo $progress; ?>%"></div>
                                            </div>
                                        </div>

                                        <div class="flex items-center text-gray-400 text-sm mb-4">
                                            <i class="fa-solid fa-layer-group text-gray-500 mr-2"></i>
                                            <span><?php echo htmlspecialchars($row['total_modules']); ?> Modules</span>
                                        </div>

                                        <div class="mt-auto pt-4 border-t border-gray-800">
                                            <a href="course-learning.php?id_course=<?php echo $row['id_course']; ?>" class="flex items-center justify-center w-full px-4 py-2.5 bg-[#708238] hover:bg-[#5a6b2d] text-white rounded-lg transition text-sm font-bold shadow-lg">
                                                Continue Learning <i class="fa-solid fa-arrow-right ml-2"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>

                        <?php if($totalPages > 1): ?>
                            <nav class="flex flex-col md:flex-row justify-between items-center mt-8 space-y-3 md:space-y-0">
                                <span class="text-sm font-normal text-gray-400">
                                    Showing <span class="font-semibold text-white"><?= ($totalData > 0) ? $start + 1 : 0 ?></span> 
                                    to <span class="font-semibold text-white"><?= min($start + $limit, $totalData) ?></span> 
                                    of <span class="font-semibold text-white"><?= $totalData ?></span> courses
                                </span>
                                <ul class="inline-flex items-center gap-2 text-sm h-8">
                                    <li>
                                        <?php if($page > 1): ?>
                                            <a href="?page=<?= $page - 1 ?>" class="flex items-center justify-center px-3 h-9 text-gray-400 border border-gray-600 rounded-lg hover:bg-gray-700 hover:text-white">
                                                <i class="fa-solid fa-chevron-left"></i>
                                            </a>
                                        <?php else: ?>
                                            <span class="flex items-center justify-center px-3 h-9 text-gray-600 border border-gray-800 rounded-lg cursor-not-allowed opacity-50">
                                                <i class="fa-solid fa-chevron-left"></i>
                                            </span>
                                        <?php endif; ?>
                                    </li>

                                    <?php for($i = 1; $i <= $totalPages; $i++): ?>
                                        <li>
                                            <?php if($i == $page): ?>
                                                <span class="flex items-center justify-center px-3 h-9 text-white bg-[#708238] border border-[#708238] rounded-lg font-bold">
                                                    <?= $i ?>
                                                </span>
                                            <?php else: ?>
                                                <a href="?page=<?= $i ?>" class="flex items-center justify-center px-3 h-9 text-gray-400 border border-gray-600 rounded-lg hover:bg-gray-700 hover:text-white">
                                                    <?= $i ?>
                                                </a>
                                            <?php endif; ?>
                                        </li>
                                    <?php endfor; ?>

                                    <li>
                                        <?php if($page < $totalPages): ?>
                                            <a href="?page=<?= $page + 1 ?>" class="flex items-center justify-center px-3 h-9 text-gray-400 border border-gray-600 rounded-lg hover:bg-gray-700 hover:text-white">
                                                <i class="fa-solid fa-chevron-right"></i>
                                            </a>
                                        <?php else: ?>
                                            <span class="flex items-center justify-center px-3 h-9 text-gray-600 border border-gray-800 rounded-lg cursor-not-allowed opacity-50">
                                                <i class="fa-solid fa-chevron-right"></i>
                                            </span>
                                        <?php endif; ?>
                                    </li>
                                </ul>
                            </nav>
                        <?php endif; ?>
                        
                    <?php 
                    } else {
                        echo '
                        <div class="flex flex-col items-center justify-center p-16 text-gray-500 bg-[#111827] rounded-xl border border-dashed border-gray-700">
                            <i class="fa-solid fa-book-open text-4xl mb-4 text-gray-600"></i>
                            <p class="text-lg font-medium text-gray-400">You don\'t have any ongoing courses.</p>
                            <a href="course.php" class="mt-4 px-4 py-2 bg-[#708238] hover:bg-[#5a6b2d] text-white rounded-lg transition">
                                Explore Courses
                            </a>
                        </div>';
                    } 
                    ?>
                </div>
            </div>
        </div>
    </div>
    <script src="./node_modules/flowbite/dist/flowbite.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</body>
</html>