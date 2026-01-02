<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notasi | Course Certificate</title>
    <link href="src/output.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <script src="https://unpkg.com/pdf-lib@1.17.1/dist/pdf-lib.min.js"></script>
    <script src="https://unpkg.com/@pdf-lib/fontkit@0.0.4"></script>
    <script src="https://unpkg.com/file-saver@2.0.5/dist/FileSaver.min.js"></script>

    <style>
        .font-serif { font-family: 'Playfair Display', serif; }
        .certificate-bg { background: radial-gradient(circle, #ffffff 40%, #f9f4e0 100%); }
        .text-gold { color: #D4AF37; }
        .border-gold { border-color: #D4AF37; }
    </style>

    <?php
        include 'config/koneksi.php';
        if (!isset($_GET['id_enroll'])) { header("Location: dashboard-student.php"); exit; }
        $id_enroll = $_GET['id_enroll'];
        $id_user = $_SESSION['id_user'];

        $queryEnroll = mysqli_query($conn, "SELECT * FROM db_notasi.tb_enrollments WHERE id_enroll = '$id_enroll' AND id_user = '$id_user'");
        $enrollment = mysqli_fetch_assoc($queryEnroll);

        if (!$enrollment || $enrollment['is_completed'] != 1) { 
            echo "<script>alert('Course not completed.'); window.location='course.php';</script>"; exit; 
        }
        $id_course = $enrollment['id_course'];

        $queryCert = mysqli_query($conn, "
            SELECT cert.certificate_code, cert.issued_at, student.name as student_name,
                   course.title as course_title, mentor.name as mentor_name
            FROM db_notasi.tb_certificates cert
            JOIN db_notasi.tb_user student ON cert.id_user = student.id_user
            JOIN db_notasi.tb_courses course ON cert.id_course = course.id_course
            JOIN db_notasi.tb_user mentor ON course.id_mentor = mentor.id_user
            WHERE cert.id_user = '$id_user' AND cert.id_course = '$id_course'
        ");
        $certData = mysqli_fetch_assoc($queryCert);
        if (!$certData) { echo "<script>window.history.back();</script>"; exit; }
        $issuedDate = date("F j, Y", strtotime($certData['issued_at']));
    ?>
</head>
<body class="bg-[#111827] min-h-screen flex flex-col items-center py-10">

    <div class="w-full max-w-4xl flex justify-between items-center mb-8 px-4">
        <a href="dashboard-student.php" class="text-gray-400 hover:text-white flex items-center gap-2 transition-colors">
            <div class="w-8 h-8 rounded-full bg-gray-800 flex items-center justify-center"><i class="fa-solid fa-arrow-left text-xs"></i></div>
            Back to Dashboard
        </a>
        <button id="downloadBtn" class="bg-[#006D4C] hover:bg-[#005a3e] text-white px-6 py-2.5 rounded-lg font-bold shadow-lg flex items-center gap-2 transition-transform transform active:scale-95">
            <i class="fa-solid fa-file-pdf"></i> Download Certificate PDF
        </button>
    </div>

    <div class="relative w-[1000px] h-[700px] bg-white shadow-2xl mx-auto overflow-hidden rounded-sm transform scale-[0.6] md:scale-[0.8] lg:scale-100 origin-top transition-transform">
        <div class="w-full h-full border-[12px] border-[#0f1523] relative p-1">
            <div class="w-full h-full border-[4px] border-gold certificate-bg relative z-10 p-12 text-center flex flex-col items-center justify-between">
                
                <div class="absolute top-0 left-0 w-24 h-24 border-t-[8px] border-l-[8px] border-gold m-2"></div>
                <div class="absolute top-0 right-0 w-24 h-24 border-t-[8px] border-r-[8px] border-gold m-2"></div>
                <div class="absolute bottom-0 left-0 w-24 h-24 border-b-[8px] border-l-[8px] border-gold m-2"></div>
                <div class="absolute bottom-0 right-0 w-24 h-24 border-b-[8px] border-r-[8px] border-gold m-2"></div>

                <div class="mt-8"><p class="text-sm tracking-[0.3em] uppercase text-gray-500 font-semibold">Online Music Learning Platform</p></div>
                
                <div>
                    <h1 class="font-serif text-6xl text-[#0f1523] font-bold mb-4">Certificate of Completion</h1>
                    <p class="text-xl text-gray-600 italic">This is to certify that</p>
                </div>

                <div class="w-full">
                    <h2 class="font-serif text-5xl text-gold font-bold pb-2 border-b-2 border-gray-300 inline-block min-w-[500px]">
                        <?php echo htmlspecialchars($certData['student_name']); ?>
                    </h2>
                </div>

                <div class="w-full">
                    <p class="text-lg text-gray-600 mb-2">Has successfully completed the course</p>
                    <h3 class="font-bold text-3xl text-[#0f1523] max-w-3xl mx-auto leading-tight"><?php echo htmlspecialchars($certData['course_title']); ?></h3>
                </div>

                <div class="w-full grid grid-cols-3 items-end mt-4 px-8 pb-4">
                    
                    <div class="text-left">
                        <div class="mb-4">
                            <p class="text-gray-500 text-xs font-bold uppercase tracking-wider mb-1">Issued Date</p>
                            <p class="text-xl font-bold text-[#0f1523] font-serif"><?php echo $issuedDate; ?></p>
                        </div>
                        <div>
                            <p class="text-gray-400 text-[10px] uppercase tracking-wider">Certificate ID</p>
                            <p class="text-xs font-mono text-gray-600"><?php echo htmlspecialchars($certData['certificate_code']); ?></p>
                        </div>
                    </div>

                    <div></div>

                    <div class="flex flex-col items-end justify-end h-full">
                        <div class="w-[220px] text-left">
                            <div class="font-serif italic text-3xl text-[#0f1523] mb-1 px-2 border-b border-gray-400 pb-1">
                                <?php echo htmlspecialchars($certData['mentor_name']); ?>
                            </div>
                            <p class="text-gray-500 text-xs font-bold uppercase tracking-wider pl-2">Course Mentor</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <p class="text-gray-500 text-sm mt-4 mb-10">Preview of your official certificate</p>

    <script>
        const { PDFDocument, rgb, StandardFonts } = PDFLib;

        document.getElementById('downloadBtn').addEventListener('click', async function() {
            const btn = this;
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Generating PDF...';
            btn.disabled = true;
            btn.classList.add('opacity-50', 'cursor-not-allowed');

            try {
                // 1. Init PDF
                const pdfDoc = await PDFDocument.create();
                const page = pdfDoc.addPage([842, 595]); // A4 Landscape
                const { width, height } = page.getSize();

                // 2. Embed Standard Fonts
                const fontSerifBold = await pdfDoc.embedFont(StandardFonts.TimesRomanBold);
                const fontSerifItalic = await pdfDoc.embedFont(StandardFonts.TimesRomanItalic);
                const fontSans = await pdfDoc.embedFont(StandardFonts.Helvetica);
                const fontSansBold = await pdfDoc.embedFont(StandardFonts.HelveticaBold);

                // Colors
                const cDark = rgb(0.06, 0.08, 0.14); // #0f1523
                const cGold = rgb(0.83, 0.69, 0.22); // #D4AF37
                const cGray = rgb(0.5, 0.5, 0.5);
                const cLightGray = rgb(0.8, 0.8, 0.8);

                // 3. Draw Background
                page.drawRectangle({ x: 0, y: 0, width: width, height: height, color: rgb(0.98, 0.96, 0.93) });

                // 4. Borders
                page.drawRectangle({ x: 20, y: 20, width: width - 40, height: height - 40, borderColor: cDark, borderWidth: 10 });
                page.drawRectangle({ x: 35, y: 35, width: width - 70, height: height - 70, borderColor: cGold, borderWidth: 3 });

                // 5. Corners
                const cw = 24; const ct = 8; const off = 45;
                // TL
                page.drawRectangle({ x: off, y: height-off-cw, width: ct, height: cw, color: cGold });
                page.drawRectangle({ x: off, y: height-off-ct, width: cw, height: ct, color: cGold });
                // TR
                page.drawRectangle({ x: width-off-ct, y: height-off-cw, width: ct, height: cw, color: cGold });
                page.drawRectangle({ x: width-off-cw, y: height-off-ct, width: cw, height: ct, color: cGold });
                // BL
                page.drawRectangle({ x: off, y: off, width: ct, height: cw, color: cGold });
                page.drawRectangle({ x: off, y: off, width: cw, height: ct, color: cGold });
                // BR
                page.drawRectangle({ x: width-off-ct, y: off, width: ct, height: cw, color: cGold });
                page.drawRectangle({ x: width-off-cw, y: off, width: cw, height: ct, color: cGold });

                // 6. Draw Text
                const drawCenter = (text, y, font, size, color) => {
                    const textWidth = font.widthOfTextAtSize(text, size);
                    page.drawText(text, { x: (width - textWidth) / 2, y: y, size: size, font: font, color: color });
                };

                // Header
                drawCenter('ONLINE MUSIC LEARNING PLATFORM', height - 120, fontSansBold, 9, cGray);
                drawCenter('Certificate of Completion', height - 180, fontSerifBold, 48, cDark);
                drawCenter('This is to certify that', height - 225, fontSerifItalic, 16, cGray);

                // Name
                const sName = "<?php echo $certData['student_name']; ?>";
                drawCenter(sName, height - 290, fontSerifBold, 42, cGold);
                const sNameW = fontSerifBold.widthOfTextAtSize(sName, 42);
                page.drawLine({ start: { x: (width-sNameW)/2 - 30, y: height-300 }, end: { x: (width+sNameW)/2 + 30, y: height-300 }, thickness: 1, color: cLightGray });

                // Course
                drawCenter('Has successfully completed the course', height - 350, fontSans, 14, cGray);
                drawCenter("<?php echo $certData['course_title']; ?>", height - 390, fontSansBold, 24, cDark);

                // --- FOOTER SECTION (LIFTED UP) ---
                // We move the baseline 'fy' UP to 110 (was 80).
                // This ensures the ID at (fy-35 = 75) is above the border (approx 69).
                const fy = 110;

                // Left: Date
                page.drawText('ISSUED DATE', { x: 80, y: fy + 15, size: 8, font: fontSansBold, color: cGray });
                page.drawText("<?php echo $issuedDate; ?>", { x: 80, y: fy, size: 12, font: fontSerifBold, color: cDark });
                
                // Left: ID (Stacked below date)
                page.drawText('CERTIFICATE ID', { x: 80, y: fy - 20, size: 8, font: fontSansBold, color: cGray });
                page.drawText("<?php echo $certData['certificate_code']; ?>", { x: 80, y: fy - 35, size: 10, font: fontSans, color: rgb(0.3,0.3,0.3) });


                // Right: Mentor (Left Aligned Block)
                // We define a fixed starting X for the mentor block
                const mentorBlockX = width - 250; 
                const mName = "<?php echo $certData['mentor_name']; ?>";

                // Name (Left aligned to block X)
                page.drawText(mName, { x: mentorBlockX, y: fy, size: 20, font: fontSerifItalic, color: cDark });
                
                // Line (Starts at block X, fixed width 200)
                page.drawLine({ start: { x: mentorBlockX, y: fy-5 }, end: { x: mentorBlockX + 200, y: fy-5 }, thickness: 1, color: cLightGray });
                
                // Label (Left aligned to block X)
                page.drawText('COURSE MENTOR', { x: mentorBlockX, y: fy-20, size: 8, font: fontSansBold, color: cGray });


                // 7. Save
                const pdfBytes = await pdfDoc.save();
                const blob = new Blob([pdfBytes], { type: "application/pdf" });
                saveAs(blob, "Notasi_Certificate_<?php echo $certData['certificate_code']; ?>.pdf");

                btn.innerHTML = originalText;
                btn.disabled = false;
                btn.classList.remove('opacity-50', 'cursor-not-allowed');

            } catch (error) {
                console.error("PDF Error:", error);
                alert("Failed to generate PDF.");
                btn.innerHTML = originalText;
                btn.disabled = false;
                btn.classList.remove('opacity-50', 'cursor-not-allowed');
            }
        });
    </script>
</body>
</html>