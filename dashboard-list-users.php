<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notasi | Homepage</title>
    <link href="src/output.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <style>
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;  /* Firefox */
        }
    </style>
</head>
<body class="dark bg-main-blue font-sans">
    <nav class="fixed top-0 z-50 w-full bg-form-dark border-b border-default">
        <div class="px-3 py-3 lg:px-5 lg:pl-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center justify-start rtl:justify-end">
                    <button data-drawer-target="top-bar-sidebar" data-drawer-toggle="top-bar-sidebar" aria-controls="top-bar-sidebar" type="button" class="sm:hidden text-heading bg-transparent box-border border border-transparent hover:bg-neutral-secondary-medium focus:ring-4 focus:ring-neutral-tertiary font-medium leading-5 rounded-base text-sm p-2 focus:outline-none">
                        <span class="sr-only">Open sidebar</span>
                        <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M5 7h14M5 12h14M5 17h10"/>
                        </svg>
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
                            <div class="px-4 py-3 border-b border-default-medium" role="none">
                                <p class="text-sm font-medium text-heading" role="none">
                                    Neil Sims
                                </p>
                                <p class="text-sm text-body truncate" role="none">
                                    neil.sims@flowbite.com
                                </p>
                            </div>
                            <ul class="p-2 text-sm text-body font-medium" role="none">
                                <li>
                                    <a href="#" class="inline-flex items-center w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded" role="menuitem">Dashboard</a>
                                </li>
                                <li>
                                    <a href="#" class="inline-flex items-center w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded" role="menuitem">Settings</a>
                                </li>
                                <li>
                                    <a href="#" class="inline-flex items-center w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded" role="menuitem">Sign out</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <aside id="top-bar-sidebar" class="fixed top-0 left-0 z-40 w-64 h-full transition-transform -translate-x-full sm:translate-x-0" aria-label="Sidebar">
        <div class="h-full px-3 py-4 overflow-y-auto bg-form-dark border-e border-default">
            <a href="https://flowbite.com/" class="flex items-center ps-2.5 mb-5">
                <img src="https://flowbite.com/docs/images/logo.svg" class="h-6 me-3" alt="Flowbite Logo" />
                <span class="self-center text-lg text-heading font-semibold whitespace-nowrap">Flowbite</span>
            </a>
            <ul class="space-y-2 font-medium">
                <li>
                    <a href="#" class="flex items-center px-2 py-1.5 text-body rounded-base hover:bg-neutral-tertiary hover:text-[#708238] group">
                        <svg class="w-5 h-5 transition duration-75 group-hover:text-[#708238]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6.025A7.5 7.5 0 1 0 17.975 14H10V6.025Z"/><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.5 3c-.169 0-.334.014-.5.025V11h7.975c.011-.166.025-.331.025-.5A7.5 7.5 0 0 0 13.5 3Z"/></svg>
                        <span class="ms-3">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center px-2 py-1.5 text-body rounded-base hover:bg-neutral-tertiary hover:text-[#708238] group">
                        <svg class="shrink-0 w-5 h-5 transition duration-75 group-hover:text-[#708238]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v14M9 5v14M4 5h16a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1Z"/></svg>
                        <span class="flex-1 ms-3 whitespace-nowrap">Courses</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center px-2 py-1.5 text-body rounded-base hover:bg-neutral-tertiary hover:text-[#708238] group">
                        <svg class="shrink-0 w-5 h-5 transition duration-75 group-hover:text-[#708238]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 13h3.439a.991.991 0 0 1 .908.6 3.978 3.978 0 0 0 7.306 0 .99.99 0 0 1 .908-.6H20M4 13v6a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-6M4 13l2-9h12l2 9M9 7h6m-7 3h8"/></svg>
                        <span class="flex-1 ms-3 whitespace-nowrap">Mentor</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center px-2 py-1.5 text-body rounded-base hover:bg-neutral-tertiary hover:text-[#708238] group">
                        <svg class="shrink-0 w-5 h-5 transition duration-75 group-hover:text-[#708238]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M16 19h4a1 1 0 0 0 1-1v-1a3 3 0 0 0-3-3h-2m-2.236-4a3 3 0 1 0 0-4M3 18v-1a3 3 0 0 1 3-3h4a3 3 0 0 1 3 3v1a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1Zm8-10a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>
                        <span class="flex-1 ms-3 whitespace-nowrap">Users</span>
                    </a>
                </li>
                <li>
                    <a href="proses/logout.php" class="flex text-fg-danger items-center px-2 py-1.5 text-body rounded-base hover:bg-neutral-tertiary hover:text-[#708238] group">
                        <svg class="shrink-0 w-5 h-5 transition duration-75 group-hover:text-[#708238]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12H4m12 0-4 4m4-4-4-4m3-4h2a3 3 0 0 1 3 3v10a3 3 0 0 1-3 3h-2"/></svg>
                        <span class="flex-1 ms-3 whitespace-nowrap">Sign Out</span>
                    </a>
                </li>
            </ul>
        </div>
    </aside>
    <div class="p-8 sm:ml-64 mt-14">
        <div class="p-4">
            <div class="w-full mb-24"> 
                <div class="relative overflow-x-auto w-full bg-neutral-primary-soft shadow-xs rounded-base border border-default">
                    <div class="flex items-center justify-between flex-column flex-wrap md:flex-row space-y-4 md:space-y-0 p-4">
                        <div>
                        <button id="dropdownDefaultButton" data-dropdown-toggle="dropdown" class="inline-flex items-center justify-center text-body bg-neutral-secondary-medium box-border border border-default-medium hover:bg-neutral-tertiary-medium hover:text-heading focus:ring-4 focus:ring-neutral-tertiary shadow-xs font-medium leading-5 rounded-base text-sm px-3 py-2 focus:outline-none" type="button">
                            Action
                            <svg class="w-4 h-4 ms-1.5 -me-0.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7"/></svg>
                        </button>
                        <!-- Dropdown menu -->
                        <div id="dropdown" class="z-10 hidden bg-neutral-primary-medium border border-default-medium rounded-base shadow-lg w-32">
                            <ul class="p-2 text-sm text-body font-medium" aria-labelledby="dropdownDefaultButton">
                            <li>
                                <a href="#" class="inline-flex items-center w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded">Reward</a>
                            </li>
                            <li>
                                <a href="#" class="inline-flex items-center w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded">Promote</a>
                            </li>
                            <li>
                                <a href="#" class="inline-flex items-center w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded">Archive</a>
                            </li>
                            <li>
                                <a href="#" class="inline-flex items-center w-full p-2 text-fg-danger hover:bg-neutral-tertiary-medium rounded">Delete</a>
                            </li>
                            </ul>
                        </div>
                        </div>
                        <label for="input-group-1" class="sr-only">Search</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-body" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"/></svg>
                            </div>
                            <input type="text" id="input-group-1" class="block w-full max-w-96 ps-9 pe-3 py-2 bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand shadow-xs placeholder:text-body" placeholder="Search">
                        </div>
                    </div>
                    <table class="w-full text-sm text-left rtl:text-right text-body">
                        <thead class="text-sm text-body bg-neutral-secondary-medium border-b border-t border-default-medium">
                            <tr>
                                <th scope="col" class="p-4">
                                    <div class="flex items-center">
                                        <input id="table-checkbox-45" type="checkbox" value="" class="w-4 h-4 border border-default-medium rounded-xs bg-neutral-secondary-medium focus:ring-2 focus:ring-brand-soft">
                                        <label for="table-checkbox-45" class="sr-only">Table checkbox</label>
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-3 font-medium">
                                    Name
                                </th>
                                <th scope="col" class="px-6 py-3 font-medium">
                                    Position
                                </th>
                                <th scope="col" class="px-6 py-3 font-medium">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-3 font-medium">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="bg-neutral-primary-soft border-b border-default hover:bg-neutral-secondary-medium">
                                <td class="w-4 p-4">
                                    <div class="flex items-center">
                                        <input id="table-checkbox-46" type="checkbox" value="" class="w-4 h-4 border border-default-medium rounded-xs bg-neutral-secondary-medium focus:ring-2 focus:ring-brand-soft">
                                        <label for="table-checkbox-46" class="sr-only">Table checkbox</label>
                                    </div>
                                </td>
                                <th scope="row" class="flex items-center px-6 py-4 text-heading whitespace-nowrap">
                                    <img class="w-10 h-10 rounded-full" src="/docs/images/people/profile-picture-1.jpg" alt="Jese image">
                                    <div class="ps-3">
                                        <div class="text-base font-semibold">Neil Sims</div>
                                        <div class="font-normal text-body">neil.sims@flowbite.com</div>
                                    </div>  
                                </th>
                                <td class="px-6 py-4">
                                    React Developer
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="h-2.5 w-2.5 rounded-full bg-success me-2"></div> Online
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <a href="#" class="font-medium text-fg-brand hover:underline">Edit user</a>
                                </td>
                            </tr>
                            <tr class="bg-neutral-primary-soft border-b border-default hover:bg-neutral-secondary-medium">
                                <td class="w-4 p-4">
                                    <div class="flex items-center">
                                        <input id="table-checkbox-47" type="checkbox" value="" class="w-4 h-4 border border-default-medium rounded-xs bg-neutral-secondary-medium focus:ring-2 focus:ring-brand-soft">
                                        <label for="table-checkbox-47" class="sr-only">Table checkbox</label>
                                    </div>
                                </td>
                                <th scope="row" class="flex items-center px-6 py-4 font-medium text-heading whitespace-nowrap">
                                    <img class="w-10 h-10 rounded-full" src="/docs/images/people/profile-picture-3.jpg" alt="Jese image">
                                    <div class="ps-3">
                                        <div class="text-base font-semibold">Bonnie Green</div>
                                        <div class="font-normal text-body">bonnie@flowbite.com</div>
                                    </div>
                                </th>
                                <td class="px-6 py-4">
                                    Designer
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="h-2.5 w-2.5 rounded-full bg-danger me-2"></div> Online
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <a href="#" class="font-medium text-fg-brand hover:underline">Edit user</a>
                                </td>
                            </tr>
                            <tr class="bg-neutral-primary-soft border-b border-default hover:bg-neutral-secondary-medium">
                                <td class="w-4 p-4">
                                    <div class="flex items-center">
                                        <input id="table-checkbox-48" type="checkbox" value="" class="w-4 h-4 border border-default-medium rounded-xs bg-neutral-secondary-medium focus:ring-2 focus:ring-brand-soft">
                                        <label for="table-checkbox-48" class="sr-only">Table checkbox</label>
                                    </div>
                                </td>
                                <th scope="row" class="flex items-center px-6 py-4 font-medium text-heading whitespace-nowrap">
                                    <img class="w-10 h-10 rounded-full" src="/docs/images/people/profile-picture-2.jpg" alt="Jese image">
                                    <div class="ps-3">
                                        <div class="text-base font-semibold">Jese Leos</div>
                                        <div class="font-normal text-body">jese@flowbite.com</div>
                                    </div>
                                </th>
                                <td class="px-6 py-4">
                                    Vue JS Developer
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="h-2.5 w-2.5 rounded-full bg-success me-2"></div> Online
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <a href="#" class="font-medium text-fg-brand hover:underline">Edit user</a>
                                </td>
                            </tr>
                            <tr class="bg-neutral-primary-soft border-b border-default hover:bg-neutral-secondary-medium">
                                <td class="w-4 p-4">
                                    <div class="flex items-center">
                                        <input id="table-checkbox-49" type="checkbox" value="" class="w-4 h-4 border border-default-medium rounded-xs bg-neutral-secondary-medium focus:ring-2 focus:ring-brand-soft">
                                        <label for="table-checkbox-49" class="sr-only">Table checkbox</label>
                                    </div>
                                </td>
                                <th scope="row" class="flex items-center px-6 py-4 font-medium text-heading whitespace-nowrap">
                                    <img class="w-10 h-10 rounded-full" src="/docs/images/people/profile-picture-5.jpg" alt="Jese image">
                                    <div class="ps-3">
                                        <div class="text-base font-semibold">Thomas Lean</div>
                                        <div class="font-normal text-body">thames@flowbite.com</div>
                                    </div>
                                </th>
                                <td class="px-6 py-4">
                                    UI/UX Engineer
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="h-2.5 w-2.5 rounded-full bg-success me-2"></div> Online
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <a href="#" class="font-medium text-fg-brand hover:underline">Edit user</a>
                                </td>
                            </tr>
                            <tr class="bg-neutral-primary-soft hover:bg-neutral-secondary-medium">
                                <td class="w-4 p-4">
                                    <div class="flex items-center">
                                        <input id="table-checkbox-50" type="checkbox" value="" class="w-4 h-4 border border-default-medium rounded-xs bg-neutral-secondary-medium focus:ring-2 focus:ring-brand-soft">
                                        <label for="table-checkbox-50" class="sr-only">Table checkbox</label>
                                    </div>
                                </td>
                                <th scope="row" class="flex items-center px-6 py-4 font-medium text-heading whitespace-nowrap">
                                    <img class="w-10 h-10 rounded-full" src="/docs/images/people/profile-picture-4.jpg" alt="Jese image">
                                    <div class="ps-3">
                                        <div class="text-base font-semibold">Leslie Livingston</div>
                                        <div class="font-normal text-body">leslie@flowbite.com</div>
                                    </div>
                                </th>
                                <td class="px-6 py-4">
                                    SEO Specialist
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="h-2.5 w-2.5 rounded-full bg-danger me-2"></div> Offline
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <a href="#" class="font-medium text-fg-brand hover:underline">Edit user</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<script src="./node_modules/flowbite/dist/flowbite.min.js"></script>
</body>
</html>