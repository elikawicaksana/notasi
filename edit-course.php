<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notasi | Edit Course</title>
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

        $id_course = $_GET['id_course'];
        $id_mentor = $_SESSION['id_user'];

        $queryCourse = mysqli_query($conn, "SELECT * FROM db_notasi.tb_courses WHERE id_course = '$id_course' AND id_mentor = '$id_mentor'");
        $course = mysqli_fetch_assoc($queryCourse);

        if (!$course) {
            echo "<script>alert('Course not found or access denied.'); ... </script>";
        }

        $queryModules = mysqli_query($conn, "SELECT * FROM db_notasi.tb_modules WHERE id_course = '$id_course' ORDER BY `order` ASC");
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
                
                <form action="proses/prosesQuery.php" method="post" enctype="multipart/form-data" autocomplete="off">
                    <input type="hidden" name="flag" value="prosesEditCourse">
                    <input type="hidden" name="id_course" value="<?php echo $course['id_course']; ?>">
                    <input type="hidden" name="id_mentor" value="<?php echo $id_mentor; ?>">
                    <input type="hidden" name="old_thumbnail" value="<?php echo $course['thumbnail']; ?>">

                    <div class="relative overflow-hidden w-full bg-neutral-primary-soft shadow-xs rounded-md border border-default p-6 mb-6">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-xl font-bold text-heading">1. Edit Course Information</h2>
                        </div>
                        
                        <div class="grid gap-4 mb-4 grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="col-span-2">
                                <label for="title" class="block mb-2 text-sm font-medium text-heading">Course Title</label>
                                <input type="text" name="title" id="title" value="<?php echo htmlspecialchars($course['title']); ?>" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-md focus:border-[#708238] focus:ring-1 focus:ring-[#708238] block w-full p-2.5 placeholder:text-body" required>
                            </div>

                            <div class="w-full">
                                <label for="category" class="block mb-2 text-sm font-medium text-heading">Category</label>
                                <select id="category" name="category" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-md focus:border-[#708238] focus:ring-1 focus:ring-[#708238] block w-full p-2.5" required>
                                    <option value="Menemukan Dasar Suaramu" <?php if($course['category'] == 'Menemukan Dasar Suaramu') echo 'selected'; ?>>Menemukan Dasar Suaramu</option>
                                    <option value="Pernapasan & Kontrol Udara" <?php if($course['category'] == 'Pernapasan & Kontrol Udara') echo 'selected'; ?>>Pernapasan & Kontrol Udara</option>
                                    <option value="Pitch, Intonasi & Kontrol Nada" <?php if($course['category'] == 'Pitch, Intonasi & Kontrol Nada') echo 'selected'; ?>>Pitch, Intonasi & Kontrol Nada</option>
                                </select>
                            </div>

                            <div class="w-full">
                                <label for="status" class="block mb-2 text-sm font-medium text-heading">Status</label>
                                <select id="status" name="status" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-md focus:border-[#708238] focus:ring-1 focus:ring-[#708238] block w-full p-2.5">
                                    <option value="Draft" <?php if($course['status'] == 'Draft') echo 'selected'; ?>>Draft (Hidden)</option>
                                    <option value="Published" <?php if($course['status'] == 'Published') echo 'selected'; ?>>Published (Visible)</option>
                                </select>
                            </div>

                            <div class="col-span-2">
                                <label class="block mb-2 text-sm font-medium text-heading" for="thumbnail">Course Thumbnail</label>
                                <?php if(!empty($course['thumbnail'])): ?>
                                    <div class="mb-2">
                                        <img src="<?php echo $course['thumbnail']; ?>" alt="Current Thumbnail" class="h-32 rounded-md object-cover border border-gray-700">
                                        <p class="text-xs text-gray-500 mt-1">Current Image. Upload new one to replace.</p>
                                    </div>
                                <?php endif; ?>
                                <input class="cursor-pointer bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-md focus:border-[#708238] focus:ring-1 focus:ring-[#708238] block w-full shadow-xs placeholder:text-body" id="thumbnail" name="thumbnail" type="file" accept="image/*">
                            </div>

                            <div class="col-span-2">
                                <label for="desc" class="block mb-2 text-sm font-medium text-heading">Description</label>
                                <textarea id="desc" name="desc" rows="4" class="block p-2.5 w-full text-sm text-heading bg-neutral-secondary-medium rounded-md border border-default-medium focus:border-[#708238] focus:ring-1 focus:ring-[#708238] placeholder:text-body" required><?php echo htmlspecialchars($course['desc']); ?></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="relative overflow-hidden w-full bg-neutral-primary-soft shadow-xs rounded-md border border-default p-6 mb-6">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-xl font-bold text-heading">2. Edit Course Modules</h2>
                            <button type="button" id="addModuleBtn" class="text-white bg-[#708238] hover:bg-[#006D4C] font-medium rounded-md text-sm px-4 py-2 transition-all shadow-xs">
                                <i class="fa-solid fa-plus mr-1"></i> Add Module
                            </button>
                        </div>

                        <div id="moduleContainer" class="space-y-4">
                            <?php 
                            $i = 0;
                            while($mod = mysqli_fetch_assoc($queryModules)) { 
                                $modNum = $i + 1;
                            ?>
                                <div class="module-item p-5 border border-gray-700 rounded-md bg-[#111827] relative transition-all">
                                    <div class="flex justify-between items-center mb-4 pb-2 border-b border-gray-700">
                                        <h4 class="text-[#708238] font-bold text-sm uppercase tracking-wide">Module <?php echo $modNum; ?></h4>
                                        <button type="button" class="text-red-500 hover:text-red-400 text-xs font-medium remove-btn flex items-center">
                                            <i class="fa-solid fa-trash mr-1"></i> Remove
                                        </button>
                                    </div>
                                    <div class="grid grid-cols-1 gap-4">
                                        <div>
                                            <label class="block mb-2 text-xs font-medium text-gray-400">Module Title</label>
                                            <input type="text" name="modules[<?php echo $i; ?>][title]" value="<?php echo htmlspecialchars($mod['title']); ?>" class="bg-gray-800 border border-gray-600 text-white text-sm rounded-md block w-full p-2.5 focus:border-[#708238] focus:ring-1 focus:ring-[#708238]" required>
                                        </div>
                                        <div>
                                            <label class="block mb-2 text-xs font-medium text-gray-400">Video URL (Optional)</label>
                                            <input type="text" name="modules[<?php echo $i; ?>][link]" value="<?php echo htmlspecialchars($mod['content_url']); ?>" class="bg-gray-800 border border-gray-600 text-white text-sm rounded-md block w-full p-2.5 focus:border-[#708238] focus:ring-1 focus:ring-[#708238]">
                                        </div>
                                        <div class="relative">
                                            <label class="block mb-2 text-xs font-medium text-gray-400">Reading Material / Content</label>
                                            <div class="w-full border border-b-0 border-gray-600 rounded-t-md bg-gray-700 flex items-center px-3 py-2 space-x-2">
                                                <button type="button" class="numbering-btn p-1.5 text-gray-300 rounded-md cursor-pointer hover:text-white hover:bg-gray-600 transition-colors" title="Add Numbered List">
                                                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6h8m-8 6h8m-8 6h8M4 16a2 2 0 1 1 3.321 1.5L4 20h5M4 5l2-1v6m-2 0h4"/></svg>
                                                </button>
                                                <div class="relative emoji-wrapper">
                                                    <button type="button" class="emoji-btn p-1.5 text-gray-300 rounded-md cursor-pointer hover:text-white hover:bg-gray-600 transition-colors" title="Add Emoji">
                                                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 9h.01M8.99 9H9m12 3a9 9 0 1 1-18 0 9 9 0 0 1 18 0ZM6.6 13a5.5 5.5 0 0 0 10.81 0H6.6Z"/></svg>
                                                    </button>
                                                    <div class="emoji-picker hidden absolute z-50 top-full left-0 mt-2 w-64 bg-gray-800 border border-gray-600 rounded-md shadow-xl p-2 grid grid-cols-6 gap-1"></div>
                                                </div>
                                            </div>
                                            <textarea name="modules[<?php echo $i; ?>][content]" rows="6" class="content-area block w-full px-4 py-2 text-sm text-white bg-gray-800 border border-gray-600 rounded-b-md focus:ring-0 placeholder:text-gray-400" required><?php echo htmlspecialchars($mod['content_body']); ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            <?php 
                                $i++;
                            } 
                            ?>
                        </div>
                    </div>

                    <div class="flex items-center space-x-4">
                        <button type="submit" class="inline-flex items-center text-white bg-[#708238] hover:bg-[#006D4C] box-border border border-transparent focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-md text-sm px-6 py-3 focus:outline-none transition-all">
                            <i class="fa-solid fa-save mr-2"></i> Update Course
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    
    <script src="./node_modules/flowbite/dist/flowbite.min.js"></script>
    <script>
        const commonEmojis = ['😀', '😂', '😍', '🔥', '👍', '👎', '💡', '🎵', '🎤', '🎹', '🎸', '⭐', '✅', '❌', '🚀', '📝'];
        
        // Initialize emoji pickers for existing modules
        document.querySelectorAll('.emoji-picker').forEach(el => {
            el.innerHTML = commonEmojis.map(e => `<button type="button" class="emoji-option text-xl hover:bg-gray-700 rounded-md p-1 transition-colors">${e}</button>`).join('');
        });

        function updateModuleIndexes() {
            const modules = document.querySelectorAll('.module-item');
            modules.forEach((module, index) => {
                const newNum = index + 1;
                const title = module.querySelector('h4');
                title.textContent = `Module ${newNum}`;
                const inputs = module.querySelectorAll('input, textarea, select');
                inputs.forEach(input => {
                    const name = input.getAttribute('name');
                    if (name) {
                        const newName = name.replace(/modules\[\d+\]/, `modules[${index}]`);
                        input.setAttribute('name', newName);
                    }
                });
            });
        }

        function createModuleHTML(index, moduleNum) {
            return `
                <div class="module-item p-5 border border-gray-700 rounded-md bg-[#111827] relative transition-all">
                    <div class="flex justify-between items-center mb-4 pb-2 border-b border-gray-700">
                        <h4 class="text-[#708238] font-bold text-sm uppercase tracking-wide">Module ${moduleNum}</h4>
                        <button type="button" class="text-red-500 hover:text-red-400 text-xs font-medium remove-btn flex items-center">
                            <i class="fa-solid fa-trash mr-1"></i> Remove
                        </button>
                    </div>
                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label class="block mb-2 text-xs font-medium text-gray-400">Module Title</label>
                            <input type="text" name="modules[${index}][title]" class="bg-gray-800 border border-gray-600 text-white text-sm rounded-md block w-full p-2.5 focus:border-[#708238] focus:ring-1 focus:ring-[#708238]" placeholder="e.g. Introduction" required>
                        </div>
                        <div>
                            <label class="block mb-2 text-xs font-medium text-gray-400">Video URL (Optional)</label>
                            <input type="text" name="modules[${index}][link]" class="bg-gray-800 border border-gray-600 text-white text-sm rounded-md block w-full p-2.5 focus:border-[#708238] focus:ring-1 focus:ring-[#708238]" placeholder="https://www.youtube.com/embed/...">
                        </div>
                        <div class="relative">
                            <label class="block mb-2 text-xs font-medium text-gray-400">Reading Material / Content</label>
                            <div class="w-full border border-b-0 border-gray-600 rounded-t-md bg-gray-700 flex items-center px-3 py-2 space-x-2">
                                <button type="button" class="numbering-btn p-1.5 text-gray-300 rounded-md cursor-pointer hover:text-white hover:bg-gray-600 transition-colors" title="Add Numbered List">
                                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6h8m-8 6h8m-8 6h8M4 16a2 2 0 1 1 3.321 1.5L4 20h5M4 5l2-1v6m-2 0h4"/></svg>
                                </button>
                                <div class="relative emoji-wrapper">
                                    <button type="button" class="emoji-btn p-1.5 text-gray-300 rounded-md cursor-pointer hover:text-white hover:bg-gray-600 transition-colors" title="Add Emoji">
                                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 9h.01M8.99 9H9m12 3a9 9 0 1 1-18 0 9 9 0 0 1 18 0ZM6.6 13a5.5 5.5 0 0 0 10.81 0H6.6Z"/></svg>
                                    </button>
                                    <div class="emoji-picker hidden absolute z-50 top-full left-0 mt-2 w-64 bg-gray-800 border border-gray-600 rounded-md shadow-xl p-2 grid grid-cols-6 gap-1">
                                        ${commonEmojis.map(e => `<button type="button" class="emoji-option text-xl hover:bg-gray-700 rounded-md p-1 transition-colors">${e}</button>`).join('')}
                                    </div>
                                </div>
                            </div>
                            <textarea name="modules[${index}][content]" rows="6" class="content-area block w-full px-4 py-2 text-sm text-white bg-gray-800 border border-gray-600 rounded-b-md focus:ring-0 placeholder:text-gray-400" placeholder="Write module content..." required></textarea>
                        </div>
                    </div>
                </div>
            `;
        }

        document.getElementById('addModuleBtn').addEventListener('click', function() {
            var container = document.getElementById('moduleContainer');
            var index = container.querySelectorAll('.module-item').length; 
            var moduleNum = index + 1;
            container.insertAdjacentHTML('beforeend', createModuleHTML(index, moduleNum));
        });

        document.getElementById('moduleContainer').addEventListener('click', function(e) {
            if (e.target.closest('.remove-btn')) {
                if(document.querySelectorAll('.module-item').length > 1){
                    e.target.closest('.module-item').remove();
                    updateModuleIndexes(); 
                } else {
                    alert("Course must have at least one module.");
                }
            }
            if (e.target.closest('.numbering-btn')) {
                const wrapper = e.target.closest('.relative');
                const textarea = wrapper.querySelector('.content-area');
                const start = textarea.selectionStart;
                const text = textarea.value;
                const beforeCursor = text.substring(0, start);
                const afterCursor = text.substring(textarea.selectionEnd, text.length);
                const lines = beforeCursor.split('\n');
                let prevLine = lines.length > 1 ? lines[lines.length - 2] : null;
                let nextNum = 1;
                if (prevLine !== null) {
                    const match = prevLine.match(/^(\d+)\.\s/);
                    if (match) { nextNum = parseInt(match[1]) + 1; }
                }
                const prefix = (start > 0 && text[start-1] !== '\n') ? `\n${nextNum}. ` : `${nextNum}. `;
                textarea.value = beforeCursor + prefix + afterCursor;
                textarea.focus();
                const newPos = start + prefix.length;
                textarea.selectionStart = textarea.selectionEnd = newPos;
            }
            if (e.target.closest('.emoji-btn')) {
                const wrapper = e.target.closest('.emoji-wrapper');
                const picker = wrapper.querySelector('.emoji-picker');
                document.querySelectorAll('.emoji-picker').forEach(el => {
                    if (el !== picker) el.classList.add('hidden');
                });
                picker.classList.toggle('hidden');
                e.stopPropagation();
            }
            if (e.target.closest('.emoji-option')) {
                const emoji = e.target.closest('.emoji-option').innerText;
                const moduleItem = e.target.closest('.module-item');
                const textarea = moduleItem.querySelector('.content-area');
                const picker = e.target.closest('.emoji-picker');
                const start = textarea.selectionStart;
                const end = textarea.selectionEnd;
                const text = textarea.value;
                textarea.value = text.substring(0, start) + emoji + text.substring(end);
                textarea.focus();
                textarea.selectionStart = textarea.selectionEnd = start + emoji.length;
                picker.classList.add('hidden');
            }
        });

        document.addEventListener('click', function(e) {
            if (!e.target.closest('.emoji-wrapper')) {
                document.querySelectorAll('.emoji-picker').forEach(el => el.classList.add('hidden'));
            }
        });
    </script>
</body>
</html>