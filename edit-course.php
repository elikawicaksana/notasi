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
    <style>
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
    <?php
        include 'config/koneksi.php';
        
        // Ambil ID dari URL (edit-course.php?id=...)
        $id_course = $_GET['id'];

        // Query Ambil Data Course
        $queryCourse = mysqli_query($conn, "SELECT * FROM db_notasi.tb_courses WHERE id_course='$id_course'") 
                       OR die(mysqli_error($conn)); 
        $fetchCourse = mysqli_fetch_array($queryCourse);
    ?>
</head>
<body class="dark bg-main-blue font-sans">
    
    <nav class="fixed top-0 z-50 w-full bg-form-dark border-b border-default">
        <div class="px-3 py-3 lg:px-5 lg:pl-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center justify-start rtl:justify-end">
                    <button data-drawer-target="top-bar-sidebar" data-drawer-toggle="top-bar-sidebar" aria-controls="top-bar-sidebar" type="button" class="sm:hidden text-heading bg-transparent box-border border border-transparent hover:bg-neutral-secondary-medium focus:ring-4 focus:ring-neutral-tertiary font-medium leading-5 rounded-base text-sm p-2 focus:outline-none">
                        <span class="sr-only">Open sidebar</span>
                        <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M5 7h14M5 12h14M5 17h10"/></svg>
                    </button>
                    <a href="index.html" class="flex ms-2 md:me-24">
                        <img src="dist/img/logo.png" class="h-8 me-3" alt="Notasi Logo" />
                    </a>
                </div>
                <div class="flex items-center">
                    <div class="flex items-center ms-3">
                        <div>
                            <button type="button" class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600" aria-expanded="false" data-dropdown-toggle="dropdown-user">
                                <span class="sr-only">Open user menu</span>
                                <img class="w-8 h-8 rounded-full" src="https://flowbite.com/docs/images/people/profile-picture-5.jpg" alt="user photo">
                            </button>
                        </div>
                        <div class="z-50 hidden bg-neutral-primary-medium border border-default-medium rounded-base shadow-lg w-44" id="dropdown-user">
                            <ul class="p-2 text-sm text-body font-medium">
                                <li><a href="#" class="inline-flex items-center w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded">Dashboard</a></li>
                                <li><a href="#" class="inline-flex items-center w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded">Sign out</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    
    <?php include 'include/sidebar.php'; ?>
    
    <div class="p-8 sm:ml-64 mt-14">
        <div class="p-4">
            <div class="w-full mb-24"> 
                <div class="relative overflow-hidden w-full bg-neutral-primary-soft shadow-xs rounded-base border border-default p-6">
                    
                    <h2 class="mb-6 text-xl font-bold text-heading">Edit Course: <?php echo $fetchCourse['title']; ?></h2>
                    
                    <form action="proses/prosesQuery.php" method="post" enctype="multipart/form-data" autocomplete="off">
                        
                        <input type="hidden" name="flag" value="prosesEditCourse">
                        <input type="hidden" name="id_course" value="<?php echo $fetchCourse['id_course']; ?>">
                        <input type="hidden" name="thumbLama" value="<?php echo $fetchCourse['thumbnail']; ?>">

                        <div class="grid gap-4 mb-4 grid-cols-2 gap-6 mb-5">
                            
                            <div class="col-span-2">
                                <label for="title" class="block mb-2 text-sm font-medium text-heading">Course Title</label>
                                <input type="text" name="title" id="title" value="<?php echo $fetchCourse['title']; ?>" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-md focus:ring-brand focus:border-brand block w-full p-2.5 placeholder:text-body" placeholder="e.g. Teknik Vokal Dasar" required>
                            </div>

                            <div class="w-full">
                                <label for="status" class="block mb-2 text-sm font-medium text-heading">Status</label>
                                <select id="status" name="status" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-md focus:ring-brand focus:border-brand block w-full p-2.5">
                                    <option value="Draft" <?php if($fetchCourse['status']=="Draft") echo "selected"; ?>>Draft</option>
                                    <option value="Published" <?php if($fetchCourse['status']=="Published") echo "selected"; ?>>Published</option>
                                </select>
                            </div>

                            <div class="w-full">
                                <label class="block mb-2 text-sm font-medium text-heading" for="thumbnail">Course Thumbnail</label>
                                <input class="cursor-pointer bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-md focus:ring-brand focus:border-brand block w-full shadow-xs placeholder:text-body" id="thumbnail" name="thumbnail" type="file" accept="image/*">
                                <p class="mt-1 text-xs text-gray-500">Leave empty to keep current thumbnail.</p>
                            </div>

                            <div class="col-span-2">
                                <label for="desc" class="block mb-2 text-sm font-medium text-heading">Description</label>
                                <textarea id="desc" name="desc" rows="6" class="block p-2.5 w-full text-sm text-heading bg-neutral-secondary-medium rounded-md border border-default-medium focus:ring-brand focus:border-brand placeholder:text-body" placeholder="Write course description here..."><?php echo $fetchCourse['desc']; ?></textarea>
                            </div>

                        </div>
                        
                        <button type="submit" class="inline-flex items-center text-white bg-[#708238] hover:bg-[#006D4C] box-border border border-transparent focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none">
                            Save Changes
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <script src="./node_modules/flowbite/dist/flowbite.min.js"></script>
</body>
</html>