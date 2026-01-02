<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notasi | Course</title>
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

        // 1. Fetch all PUBLISHED courses with Mentor Name and Module Count
        $query = "SELECT 
                    c.*, 
                    u.name AS mentor_name,
                    (SELECT COUNT(*) FROM db_notasi.tb_modules m WHERE m.id_course = c.id_course) as total_modules
                  FROM db_notasi.tb_courses c
                  JOIN db_notasi.tb_user u ON c.id_mentor = u.id_user
                  WHERE c.status = 'Published'
                  ORDER BY c.id_course DESC";
        
        $result = mysqli_query($conn, $query);

        // 2. Group courses by Category
        $coursesByCategory = [];
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $coursesByCategory[$row['category']][] = $row;
            }
        }
    ?>
</head>
<body class="dark bg-main-blue font-sans">
<?php include "include/navbar.php" ?>
<main class="pt-15">
    <div class="relative py-12 flex justify-center">
        <div class="absolute inset-0 flex items-center" aria-hidden="true">
            <div class="w-full border-t border-transparent bg-gradient-to-r from-moss-light to-moss-dark bg-origin-border h-[0.5px]"></div>
        </div>
        <div class="relative flex justify-center">
            <span class="text-5xl font-semibold bg-footer-bg tracking-wider px-6">
                <span class="text-white"> Our</span> <span class="bg-gradient-to-r from-moss-light to-moss-dark bg-clip-text text-transparent">Courses </span>
            </span>
        </div>
    </div>

    <section class="py-5 px-4 md:px-8 bg-main-blue relative">
        
        <?php 
        $sectionIndex = 1; // Counter for unique IDs for the carousels
        
        // Loop through each Category
        foreach ($coursesByCategory as $categoryName => $courses) { 
            $carouselId = "carousel-" . $sectionIndex; 
        ?>
            <div class="max-w-screen-xl mx-auto mb-16">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-white text-2xl font-semibold border-l-4 border-[#006D4C] pl-4">
                        <?php echo htmlspecialchars($categoryName); ?>
                    </h3>
                    <div class="flex gap-2">
                        <button onclick="document.getElementById('<?php echo $carouselId; ?>').scrollBy({left: -300, behavior: 'smooth'})" class="p-2 rounded-full border border-gray-600 hover:bg-[#006D4C] hover:border-[#006D4C] text-white transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                        </button>
                        <button onclick="document.getElementById('<?php echo $carouselId; ?>').scrollBy({left: 300, behavior: 'smooth'})" class="p-2 rounded-full border border-gray-600 hover:bg-[#006D4C] hover:border-[#006D4C] text-white transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </button>
                    </div>
                </div>

                <div id="<?php echo $carouselId; ?>" class="flex overflow-x-auto gap-5 pb-4 snap-x snap-mandatory scroll-smooth no-scrollbar">
                    
                    <?php foreach ($courses as $course) { 
                        // Handle thumbnail fallback
                        $thumbnail = !empty($course['thumbnail']) ? $course['thumbnail'] : 'dist/img/thumbnail.png';
                    ?>
                        <a href="course-detail.php?id_course=<?php echo $course['id_course']; ?>" class="block min-w-[280px] md:min-w-[320px] snap-center group relative rounded-xl overflow-hidden cursor-pointer bg-gray-900 border border-white/10 hover:border-[#006D4C] transition-all">
                            <img src="<?php echo $thumbnail; ?>" class="w-full h-48 object-cover opacity-80 group-hover:opacity-100 group-hover:scale-110 transition-all duration-500" alt="Thumbnail">
                            
                            <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent"></div>
                            
                            <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <div class="w-12 h-12 bg-[#006D4C] rounded-full flex items-center justify-center shadow-lg">
                                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                </div>
                            </div>

                            <div class="p-4 relative z-10">
                                <span class="text-xs font-semibold text-[#708238] uppercase tracking-wide">
                                    Coach <?php echo htmlspecialchars($course['mentor_name']); ?>
                                </span>
                                <h4 class="text-white text-lg font-bold mt-1 leading-snug group-hover:text-[#006D4C] transition-colors line-clamp-2">
                                    <?php echo htmlspecialchars($course['title']); ?>
                                </h4>
                                <p class="text-gray-400 text-xs mt-2">
                                    <?php echo $course['total_modules']; ?> Modules
                                </p>
                            </div>
                        </a>
                    <?php } ?>

                </div>
            </div>
        <?php 
            $sectionIndex++; // Increment for the next category ID
        } 
        
        // Show message if no courses found
        if (empty($coursesByCategory)) {
            echo '<div class="text-center text-gray-400 py-10">No published courses available yet.</div>';
        }
        ?>

    </section>
</main>

<footer class="bg-footer-bg">
    <div class="relative py-8">
        <div class="absolute inset-0 flex items-center" aria-hidden="true">
            <div class="w-full border-t border-transparent bg-gradient-to-r from-moss-light to-moss-dark bg-origin-border h-[0.5px]"></div>
        </div>
        <div class="relative flex justify-center">
            <span class="bg-footer-bg px-4">
                <span class="bg-gradient-to-r from-moss-light to-moss-dark bg-clip-text text-transparent text-md font-semibold uppercase tracking-wider">
                    Ketahui Lebih Banyak Tentang Kami
                </span>
            </span>
        </div>
    </div>
    <div class="mx-auto max-w-screen-xl px-4 pb-16 flex flex-col items-center text-center">
        <div class="mb-5">
            <img src="dist/img/logo.png" alt="Notasi Logo" class="h-14 mx-auto" />
        </div>
        <div class="space-y-3 text-sm text-white font-light">
            <a href="mailto:tanya@darinadapertama.com" class="hover:text-white transition-colors">
                tanya@darinadapertama.com
            </a>
            <p>
                Copyright © 2025 All rights reserved
            </p>
        </div>
    </div>
</footer>
<script src="./node_modules/flowbite/dist/flowbite.min.js"></script>
</body>
</html>