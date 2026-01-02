<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notasi | Learning Room</title>
    <link href="src/output.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        
        .video-container { position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; border-radius: 0.75rem; background: #000; }
        .video-container iframe { position: absolute; top: 0; left: 0; width: 100%; height: 100%; }
        
        .fade-in { animation: fadeIn 0.4s ease-out; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

        .sidebar-scroll::-webkit-scrollbar { width: 5px; }
        .sidebar-scroll::-webkit-scrollbar-track { background: transparent; }
        .sidebar-scroll::-webkit-scrollbar-thumb { background: #374151; border-radius: 10px; }
    </style>
    <?php
        include 'config/koneksi.php';
        
        if (!isset($_GET['id_course'])) { header("Location: course.php"); exit; }
        $id_course = $_GET['id_course'];

        if (!isset($_SESSION['id_user'])) { header("Location: login.php"); exit; }
        $id_user = $_SESSION['id_user'];

        // 1. Get Enrollment
        $checkEnroll = mysqli_query($conn, "SELECT * FROM db_notasi.tb_enrollments WHERE id_user = '$id_user' AND id_course = '$id_course'");
        $enrollment = mysqli_fetch_assoc($checkEnroll);
        
        if (!$enrollment) {
            echo "<script>alert('Access Denied. Please enroll first.'); window.location='course-detail.php?id_course=$id_course';</script>";
            exit;
        }
        $id_enroll = $enrollment['id_enroll'];
        $current_progress = $enrollment['progress_percentage'];
        
        // NEW: Check if course is officially finished
        $is_course_finished = ($enrollment['is_completed'] == 1);

        // 2. Fetch Course
        $queryCourse = mysqli_query($conn, "SELECT * FROM db_notasi.tb_courses WHERE id_course = '$id_course'");
        $course = mysqli_fetch_assoc($queryCourse);
        
        // 3. Fetch Modules
        $queryModules = mysqli_query($conn, "SELECT * FROM db_notasi.tb_modules WHERE id_course = '$id_course' ORDER BY `order` ASC");
        $modules = [];
        while($row = mysqli_fetch_assoc($queryModules)){
            $modules[] = $row;
        }
        $total_modules = count($modules);

        // 4. Completed Modules
        $completed_modules = [];
        $qComp = mysqli_query($conn, "SELECT id_module FROM db_notasi.tb_module_completions WHERE id_enroll = '$id_enroll' AND is_completed = 1");
        while($rowC = mysqli_fetch_assoc($qComp)) {
            $completed_modules[] = $rowC['id_module'];
        }
        
        function getYoutubeEmbedUrl($url) {
            $shortUrlRegex = '/youtu.be\/([a-zA-Z0-9_-]+)\??/i';
            $longUrlRegex = '/youtube.com\/((?:embed)|(?:watch))((?:\?v\=)|(?:\/))([a-zA-Z0-9_-]+)/i';
            if (preg_match($longUrlRegex, $url, $matches)) return "https://www.youtube.com/embed/" . $matches[3];
            if (preg_match($shortUrlRegex, $url, $matches)) return "https://www.youtube.com/embed/" . $matches[1];
            return $url;
        }
    ?>
</head>
<body class="dark bg-[#0b0f19] font-sans text-gray-300">
    
    <nav class="fixed w-full z-50 top-0 start-0 bg-[#0f1523] border-b border-gray-800 h-16 flex items-center shadow-md">
        <div class="w-full flex items-center justify-between px-6">
            <a href="dashboard-student.php" class="flex items-center text-gray-400 hover:text-white transition-colors group text-sm font-medium">
                <div class="w-8 h-8 rounded-full bg-gray-800 border border-gray-700 flex items-center justify-center mr-3 group-hover:border-gray-500 transition-colors">
                    <i class="fa-solid fa-chevron-left text-xs"></i>
                </div>
                Back to Dashboard
            </a>
            <span class="text-white font-semibold text-base hidden md:block tracking-wide"><?php echo htmlspecialchars($course['title']); ?></span>
            <div class="w-32 text-right">
                <span class="px-3 py-1 rounded-full bg-gray-800 border border-gray-700 text-xs font-bold text-[#708238]" id="status-text">
                    <?php echo ($current_progress == 100) ? 'Completed' : 'In Progress'; ?>
                </span>
            </div>
        </div>
    </nav>

    <aside class="fixed top-16 left-0 z-40 w-80 h-[calc(100vh-64px)] bg-[#0f1523] border-r border-gray-800 hidden md:block">
        <div class="h-full overflow-y-auto sidebar-scroll p-4 pb-20">
            <h5 class="text-gray-500 font-bold uppercase text-[11px] tracking-widest mb-4 px-2 mt-4">Course Modules</h5>
            <ul class="space-y-1">
                <?php foreach($modules as $index => $mod): 
                    $modId = $mod['id_modules'];
                    $is_completed = in_array($modId, $completed_modules);
                    $checkIconClass = $is_completed ? 'text-[#006D4C]' : 'text-gray-600';
                ?>
                <li>
                    <button onclick="jumpToModule(<?php echo $index; ?>)" 
                            id="sidebar-item-<?php echo $index; ?>"
                            class="sidebar-item flex items-center w-full p-3 rounded-lg hover:bg-[#1a2332] transition-all text-left group border border-transparent">
                        <div class="flex-shrink-0 mr-3">
                            <i class="fa-solid fa-circle-check text-lg <?php echo $checkIconClass; ?> sidebar-check-icon transition-colors" id="sidebar-icon-<?php echo $modId; ?>"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-[10px] text-gray-500 uppercase tracking-wide font-bold mb-0.5">Module <?php echo $mod['order']; ?></p>
                            <p class="text-sm font-medium text-gray-300 group-hover:text-white truncate"><?php echo htmlspecialchars($mod['title']); ?></p>
                        </div>
                    </button>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </aside>

    <main class="pt-24 pb-32 md:ml-80 p-4 md:p-10 min-h-screen">
        <div class="max-w-4xl mx-auto">
            <?php if($total_modules > 0): ?>
                <?php foreach($modules as $index => $mod): 
                    $isActive = ($index === 0) ? '' : 'hidden'; 
                    $modId = $mod['id_modules'];
                    $is_completed = in_array($modId, $completed_modules);
                    $checkedAttr = $is_completed ? 'checked' : '';
                    
                    // Logic to disable checkbox if course is finished
                    $disabledAttr = $is_course_finished ? 'disabled' : '';
                    $cursorClass = $is_course_finished ? 'cursor-not-allowed opacity-60' : 'cursor-pointer group-hover:bg-gray-800';
                    $hoverEffect = $is_course_finished ? '' : 'group-hover:bg-gray-800';
                ?>
                    <div id="module-<?php echo $index; ?>" class="module-step <?php echo $isActive; ?> fade-in">
                        
                        <div class="mb-8 text-center md:text-left">
                            <span class="text-[#006D4C] text-xs font-bold uppercase tracking-widest bg-[#006D4C]/10 px-3 py-1 rounded-full border border-[#006D4C]/20">
                                Module <?php echo $mod['order']; ?> of <?php echo $total_modules; ?>
                            </span>
                            <h1 class="text-3xl md:text-4xl font-bold text-white mt-4 leading-tight">
                                <?php echo htmlspecialchars($mod['title']); ?>
                            </h1>
                        </div>

                        <div class="bg-[#131b2c] rounded-2xl border border-gray-800 shadow-xl overflow-hidden mb-8">
                            <?php if(!empty($mod['content_url'])): ?>
                                <div class="p-1 bg-black/20">
                                    <div class="video-container shadow-lg">
                                        <iframe src="<?php echo getYoutubeEmbedUrl($mod['content_url']); ?>" title="Video Player" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <div class="p-8">
                                <div class="text-gray-300 text-base leading-7 font-light">
                                    <?php echo $mod['content_body']; ?>
                                </div>
                            </div>

                            <div class="bg-[#0f1523] border-t border-gray-800 p-6 flex justify-end">
                                <label class="<?php echo $cursorClass; ?> select-none group">
                                    <input type="checkbox" class="sr-only peer module-checkbox" 
                                           data-enroll="<?php echo $id_enroll; ?>" 
                                           data-module="<?php echo $modId; ?>"
                                           <?php echo $checkedAttr; ?>
                                           <?php echo $disabledAttr; ?>>
                                           
                                    <div class="flex items-center gap-3 px-5 py-3 rounded-lg border border-gray-600 text-gray-400 bg-transparent <?php echo $hoverEffect; ?> transition-all peer-checked:bg-[#006D4C] peer-checked:border-[#006D4C] peer-checked:text-white">
                                        <div class="w-5 h-5 border-2 border-current rounded flex items-center justify-center transition-all">
                                            <i class="fa-solid fa-check text-xs opacity-0 peer-checked:opacity-100"></i>
                                        </div>
                                        <span class="font-semibold text-sm label-text">
                                            <?php 
                                            if ($is_course_finished) {
                                                echo 'Course Completed';
                                            } else {
                                                echo $is_completed ? 'Completed' : 'Mark as Completed';
                                            }
                                            ?>
                                        </span>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="p-12 text-center text-gray-500 bg-[#131b2c] rounded-2xl border border-gray-800">
                    <p>No modules available.</p>
                </div>
            <?php endif; ?>
            
            <div class="h-20 w-full"></div> 

        </div>
    </main>

    <div class="fixed bottom-0 right-0 left-0 md:left-80 z-50 h-20 bg-[#0f1523] border-t border-gray-800 flex items-center shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.3)]">
        <div class="w-full max-w-4xl mx-auto px-6 flex items-center justify-between gap-8">
            
            <button id="btn-prev" class="w-32 px-4 py-2.5 rounded-lg border border-gray-600 text-gray-400 hover:text-white hover:bg-gray-800 font-medium text-sm transition-all disabled:opacity-0 disabled:pointer-events-none flex items-center justify-center gap-2">
                <i class="fa-solid fa-arrow-left"></i> Previous
            </button>

            <div class="flex-1 flex flex-col justify-center max-w-lg">
                <div class="flex justify-between text-xs font-semibold text-gray-400 mb-2 uppercase tracking-wide">
                    <span>Course Progress</span>
                    <span id="progress-text" class="text-[#006D4C]"><?php echo $current_progress; ?>%</span>
                </div>
                <div class="w-full bg-gray-800 rounded-full h-2 overflow-hidden">
                    <div id="progress-bar-fill" class="bg-gradient-to-r from-moss-light to-moss-dark h-full rounded-full transition-all duration-500 ease-out shadow-[0_0_10px_rgba(0,109,76,0.5)]" style="width: <?php echo $current_progress; ?>%"></div> 
                </div>
            </div>
            
            <button id="btn-next" class="w-36 px-4 py-2.5 rounded-lg bg-[#006D4C] hover:bg-[#005a3e] text-white font-bold text-sm shadow-lg transition-all flex items-center justify-center gap-2 transform active:scale-95">
                Next Lesson <i class="fa-solid fa-arrow-right"></i>
            </button>

        </div>
    </div>

    <script src="./node_modules/flowbite/dist/flowbite.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        let currentIndex = 0;
        const totalModules = <?php echo $total_modules; ?>;

        function updateUI() {
            $('.module-step').addClass('hidden');
            $('#module-' + currentIndex).removeClass('hidden');

            $('#btn-prev').prop('disabled', currentIndex === 0);
            if (currentIndex === 0) $('#btn-prev').addClass('hidden');
            else $('#btn-prev').removeClass('hidden');
            
            if (currentIndex === totalModules - 1) {
                $('#btn-next').html('Finish <i class="fa-solid fa-check ml-1"></i>');
            } else {
                $('#btn-next').html('Next Lesson <i class="fa-solid fa-arrow-right ml-1"></i>');
            }

            $('.sidebar-item').removeClass('bg-[#1a2332] border-l-4 border-[#006D4C]').addClass('border-transparent');
            $('#sidebar-item-' + currentIndex).addClass('bg-[#1a2332] border-l-4 border-[#006D4C]').removeClass('border-transparent');
            
            const activeItem = document.getElementById('sidebar-item-' + currentIndex);
            if(activeItem) activeItem.scrollIntoView({ behavior: 'smooth', block: 'nearest' });

            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function jumpToModule(index) {
            currentIndex = index;
            updateUI();
        }

        $(document).ready(function() {
            $('#btn-next').click(function() {
                if (currentIndex < totalModules - 1) {
                    currentIndex++;
                    updateUI();
                } else {
                    // FINISH LOGIC
                    var id_enroll = $('.module-checkbox').first().data('enroll');
                    var btn = $(this);
                    var originalText = btn.html();
                    btn.prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin"></i> Processing...');

                    $.ajax({
                        url: 'proses/prosesQuery.php',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            flag: 'finishCourse',
                            id_enroll: id_enroll
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                alert("Congratulations! Course Completed.");
                                window.location.href = 'certificate.php?id_enroll=' + id_enroll;
                            } else if (response.status === 'incomplete') {
                                alert("You cannot finish yet! Please mark all modules as completed first.");
                                btn.prop('disabled', false).html(originalText);
                            } else {
                                alert("Error: " + response.message);
                                btn.prop('disabled', false).html(originalText);
                            }
                        },
                        error: function() {
                            alert("System error: Could not verify progress.");
                            btn.prop('disabled', false).html(originalText);
                        }
                    });
                }
            });

            $('#btn-prev').click(function() {
                if (currentIndex > 0) {
                    currentIndex--;
                    updateUI();
                }
            });

            updateUI();

            $('.module-checkbox').on('change', function() {
                var checkbox = $(this);
                // Check if disabled by browser just in case
                if(checkbox.is(':disabled')) return;

                var isChecked = checkbox.prop('checked');
                var id_enroll = checkbox.data('enroll');
                var id_module = checkbox.data('module');
                var labelText = checkbox.parent().find('.label-text');

                labelText.text(isChecked ? 'Completed' : 'Mark as Completed');

                var sidebarIcon = $('#sidebar-icon-' + id_module);
                if(isChecked) sidebarIcon.removeClass('text-gray-600').addClass('text-[#006D4C]');
                else sidebarIcon.removeClass('text-[#006D4C]').addClass('text-gray-600');

                $.ajax({
                    url: 'proses/prosesQuery.php',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        flag: 'updateProgress', 
                        id_enroll: id_enroll,
                        id_module: id_module,
                        action: isChecked ? 'check' : 'uncheck'
                    },
                    success: function(response) {
                        if(response.status === 'success') {
                            var newPerc = response.new_percentage;
                            $('#progress-bar-fill').css('width', newPerc + '%');
                            $('#progress-text').text(newPerc + '%');
                            if(newPerc == 100) $('#status-text').text('Completed');
                            else $('#status-text').text('In Progress');
                        } else {
                            alert('Error: ' + response.message);
                            checkbox.prop('checked', !isChecked); 
                        }
                    },
                    error: function() {
                        alert('System error.');
                        checkbox.prop('checked', !isChecked);
                    }
                });
            });
        });
    </script>
</body>
</html>