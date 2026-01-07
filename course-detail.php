<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notasi | Course Detail</title>
    <link href="src/output.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="icon" type="image/png" href="dist/img/favicon-96x96.png" sizes="96x96" />
    <link rel="shortcut icon" href="dist/img/favicon.ico" />
    <style>
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        .video-container { position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; max-width: 100%; border-radius: 0.5rem; }
        .video-container iframe { position: absolute; top: 0; left: 0; width: 100%; height: 100%; }
        
        /* Disable hover effect if locked */
        .cursor-locked { cursor: not-allowed; opacity: 0.7; }
    </style>
    <?php
        include 'config/koneksi.php';
        
        if (!isset($_GET['id_course'])) {
            header("Location: course.php");
            exit;
        }
        $id_course = $_GET['id_course'];

        // 1. Fetch Course Info
        $queryCourse = mysqli_query($conn, "SELECT c.*, u.name as mentor_name 
                                            FROM db_notasi.tb_courses c
                                            JOIN db_notasi.tb_user u ON c.id_mentor = u.id_user
                                            WHERE c.id_course = '$id_course'");
        $course = mysqli_fetch_assoc($queryCourse);

        if (!$course) {
            echo "<script>alert('Course not found!'); window.location='course.php';</script>";
            exit;
        }

        // 2. Fetch Modules
        $queryModules = mysqli_query($conn, "SELECT * FROM db_notasi.tb_modules WHERE id_course = '$id_course' ORDER BY `order` ASC");

        // 3. Check Enrollment
        $is_enrolled = false;
        $is_logged_in = isset($_SESSION['id_user']);
        
        if ($is_logged_in) {
            $id_user = $_SESSION['id_user'];
            $checkEnroll = mysqli_query($conn, "SELECT id_enroll FROM db_notasi.tb_enrollments WHERE id_user = '$id_user' AND id_course = '$id_course'");
            if (mysqli_num_rows($checkEnroll) > 0) {
                $is_enrolled = true;
            }
        }
        
        // Helper for YouTube
        function getYoutubeEmbedUrl($url) {
            $shortUrlRegex = '/youtu.be\/([a-zA-Z0-9_-]+)\??/i';
            $longUrlRegex = '/youtube.com\/((?:embed)|(?:watch))((?:\?v\=)|(?:\/))([a-zA-Z0-9_-]+)/i';
            if (preg_match($longUrlRegex, $url, $matches)) return "https://www.youtube.com/embed/" . $matches[3];
            if (preg_match($shortUrlRegex, $url, $matches)) return "https://www.youtube.com/embed/" . $matches[1];
            return $url;
        }
    ?>
</head>
<body class="dark bg-main-blue font-sans">
    <?php include 'include/navbar.php'; ?>
    <main class="pt-15 pb-32">
        <div class="relative w-full h-[400px] overflow-hidden">
            <?php $banner = !empty($course['thumbnail']) ? $course['thumbnail'] : "dist/img/thumbnail.png"; ?>
            <img src="<?php echo $banner; ?>" class="absolute inset-0 w-full h-full object-cover" alt="Course Banner">
            
            <div class="absolute inset-0 bg-black/40"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-main-blue via-main-blue/80 to-transparent"></div>
            
            <div class="absolute bottom-0 left-0 w-full p-8 max-w-screen-xl mx-auto">
                <span class="inline-block px-3 py-1 mb-4 text-xs font-semibold tracking-wider text-white uppercase bg-[#006D4C] rounded-md">
                    <?php echo htmlspecialchars($course['category']); ?>
                </span>
                <h1 class="text-4xl md:text-6xl font-bold text-white mb-2 leading-tight">
                    <?php echo htmlspecialchars($course['title']); ?>
                </h1>
            </div>
        </div>

        <div class="max-w-screen-xl mx-auto px-4 md:px-8 mt-8">
            <div class="mb-10">
                <h3 class="text-xl font-bold text-white mb-3">Description</h3>
                <p class="text-gray-300 text-md leading-relaxed max-w-6xl">
                    <?php echo nl2br(htmlspecialchars($course['desc'])); ?>
                </p>
                <div class="flex gap-8 mt-6 border-t border-gray-700 pt-4">
                    <div>
                        <span class="block text-xs text-gray-500 uppercase">Mentor</span>
                        <span class="text-white font-medium"><?php echo htmlspecialchars($course['mentor_name']); ?></span>
                    </div>
                    <div>
                        <span class="block text-xs text-gray-500 uppercase">Total Modules</span>
                        <span class="text-white font-medium"><?php echo mysqli_num_rows($queryModules); ?> Modules</span>
                    </div>
                </div>
            </div>

            <div class="mb-12">
                <div class="flex justify-between items-end mb-4">
                    <h3 class="text-xl font-bold text-white">Course Curriculum</h3>
                    <?php if(!$is_enrolled): ?>
                        <span class="text-xs text-yellow-500 font-medium"><i class="fa-solid fa-lock mr-1"></i> Content Locked</span>
                    <?php endif; ?>
                </div>

                <div id="accordion-flush" data-accordion="collapse" data-active-classes="bg-gray-800 text-white" data-inactive-classes="text-gray-400">
                    <?php 
                    if(mysqli_num_rows($queryModules) > 0) {
                        $i = 1;
                        while($mod = mysqli_fetch_assoc($queryModules)) { 
                            $headerId = "accordion-flush-heading-" . $i;
                            $bodyId = "accordion-flush-body-" . $i;
                            
                            // IF enrolled: standard behavior. IF NOT: disable pointer events & visual change
                            $targetAttr = $is_enrolled ? "data-accordion-target='#$bodyId'" : "";
                            $cursorClass = $is_enrolled ? "cursor-pointer hover:bg-gray-800" : "cursor-locked bg-gray-900";
                            $icon = $is_enrolled ? '<svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/></svg>' : '<i class="fa-solid fa-lock text-gray-500 text-sm"></i>';
                    ?>
                        <h2 id="<?php echo $headerId; ?>">
                            <button type="button" class="flex items-center justify-between w-full py-5 font-medium rtl:text-right border-b border-gray-700 gap-3 px-4 transition-colors <?php echo $cursorClass; ?> text-gray-400" <?php echo $targetAttr; ?> aria-expanded="false" aria-controls="<?php echo $bodyId; ?>">
                                <span class="text-left flex items-center">
                                    <span class="text-[#708238] font-bold mr-2 text-sm">Module <?php echo $mod['order']; ?>:</span> 
                                    <span class="text-white"><?php echo htmlspecialchars($mod['title']); ?></span>
                                </span>
                                <?php echo $icon; ?>
                            </button>
                        </h2>
                        
                        <div id="<?php echo $bodyId; ?>" class="hidden" aria-labelledby="<?php echo $headerId; ?>">
                            <div class="p-5 border-b border-gray-700 bg-[#151f32]">
                                <div class="mb-6 text-gray-300 text-sm leading-relaxed">
                                    <?php echo nl2br(htmlspecialchars($mod['content_body'])); ?>
                                </div>
                                <?php if(!empty($mod['content_url'])): ?>
                                    <div class="mb-6">
                                        <div class="video-container shadow-lg">
                                            <iframe src="<?php echo getYoutubeEmbedUrl($mod['content_url']); ?>" title="Video Player" allowfullscreen></iframe>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php 
                            $i++;
                        } 
                    } else {
                        echo '<p class="text-gray-400 italic">No modules available.</p>';
                    }
                    ?>
                </div>
            </div>

        </div>
    </main>

    <div class="fixed bottom-0 left-0 z-50 w-full h-20 bg-[#1f2937] border-t border-gray-700 flex items-center justify-between px-4 md:px-12 shadow-2xl">
        <div class="flex items-center">
            <span class="text-gray-400 text-xs md:text-sm mr-4 hidden md:block">Status</span>
            <span class="text-white text-xs font-bold uppercase tracking-wide">
                <?php echo $is_enrolled ? '<span class="text-green-400"><i class="fa-solid fa-check-circle mr-1"></i> Enrolled</span>' : '<span class="text-yellow-500"><i class="fa-solid fa-lock mr-1"></i> Not Enrolled</span>'; ?>
            </span>
        </div>
        
        <div class="flex gap-4">
            <a href="course.php" class="px-4 py-2 text-sm font-medium text-white bg-gray-700 hover:bg-gray-600 rounded-md transition-colors flex items-center">
                Back
            </a>

            <?php if(!$is_logged_in): ?>
                <a href="login.php" class="px-6 py-2 text-sm font-bold text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-500 hover:to-blue-600 rounded-md shadow-lg transform hover:scale-105 transition-all flex items-center">
                    <i class="fa-solid fa-right-to-bracket mr-2"></i> Login to Enroll
                </a>

            <?php elseif($is_enrolled): ?>
                <a href="course-learning.php?id_course=<?php echo $id_course; ?>" class="px-6 py-2 text-sm font-bold text-white bg-gradient-to-r from-[#708238] to-[#556b2f] hover:from-[#85964d] hover:to-[#708238] rounded-md shadow-lg transform hover:scale-105 transition-all flex items-center">
                    <i class="fa-solid fa-play mr-2"></i> Continue Learning
                </a>

            <?php else: ?>
                <form action="proses/prosesQuery.php" method="POST">
                    <input type="hidden" name="flag" value="prosesEnroll">
                    <input type="hidden" name="id_course" value="<?php echo $id_course; ?>">
                    <button type="submit" class="px-6 py-2 text-sm font-bold text-white bg-gradient-to-r from-[#006D4C] to-[#005a3e] hover:from-[#00855c] hover:to-[#006D4C] rounded-md shadow-lg transform hover:scale-105 transition-all flex items-center">
                        <i class="fa-solid fa-user-plus mr-2"></i> Enroll Now
                    </button>
                </form>
            <?php endif; ?>
        </div>
    </div>

    <script src="./node_modules/flowbite/dist/flowbite.min.js"></script>
</body>
</html>