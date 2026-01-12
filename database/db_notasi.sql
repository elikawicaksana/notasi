/*
SQLyog Ultimate v13.1.1 (64 bit)
MySQL - 8.0.30 : Database - db_notasi
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`db_notasi` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;

USE `db_notasi`;

/*Table structure for table `tb_certificates` */

DROP TABLE IF EXISTS `tb_certificates`;

CREATE TABLE `tb_certificates` (
  `id_certificate` int NOT NULL AUTO_INCREMENT,
  `id_user` int DEFAULT NULL,
  `id_course` int DEFAULT NULL,
  `certificate_code` varchar(255) DEFAULT NULL,
  `issued_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_certificate`),
  KEY `id_course` (`id_course`),
  KEY `id_user` (`id_user`),
  CONSTRAINT `tb_certificates_ibfk_1` FOREIGN KEY (`id_course`) REFERENCES `tb_courses` (`id_course`),
  CONSTRAINT `tb_certificates_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `tb_user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `tb_certificates` */

insert  into `tb_certificates`(`id_certificate`,`id_user`,`id_course`,`certificate_code`,`issued_at`) values 
(4,5,23,'NOTASI-20260108-43208358','2026-01-08 13:37:24'),
(5,5,27,'NOTASI-20260108-07238BEE','2026-01-08 15:00:42'),
(6,5,17,'NOTASI-20260108-C39908F0','2026-01-08 19:27:50');

/*Table structure for table `tb_courses` */

DROP TABLE IF EXISTS `tb_courses`;

CREATE TABLE `tb_courses` (
  `id_course` int NOT NULL AUTO_INCREMENT,
  `id_mentor` int DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `category` enum('Menemukan Dasar Suaramu','Pernapasan & Kontrol Udara','Pitch, Intonasi & Kontrol Nada','Dinamika, Artikulasi & Rasa Bernyanyi') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `desc` text,
  `thumbnail` text,
  `status` enum('Draft','Published') DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_course`),
  KEY `id_mentor` (`id_mentor`),
  CONSTRAINT `tb_courses_ibfk_1` FOREIGN KEY (`id_mentor`) REFERENCES `tb_user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `tb_courses` */

insert  into `tb_courses`(`id_course`,`id_mentor`,`title`,`category`,`desc`,`thumbnail`,`status`,`created_at`) values 
(16,2,'Suaramu Itu Alat Musik','Menemukan Dasar Suaramu','Course ini memperkenalkan konsep pitch dan tinggi-rendah nada. Perserta diajak memahami bahwa ketepatan nada bukan bakat semata, tertapi keterampilan yang bisa dilatih secara bertahap.','dist/img/20260106-141029-695ca75521578.png','Draft','2026-01-06 13:40:49'),
(17,2,'Cara Kerja Suara Manusia','Menemukan Dasar Suaramu','Fokus utama course ini adalah melatih pendengaran. Peserta belajar mendengar nada dengan lebih sadar agar suara bisa mengikuti pitch yang tepat secara alami.','dist/img/20260106-142242-695caa322e036.png','Published','2026-01-06 14:20:36'),
(18,2,'Kesalahan Umum Saat Bernyanyi','Menemukan Dasar Suaramu','Course ini membantu peserta menjaga kestabilan nada dari awal hingga akhir. Intonasi yang baik membuat suara terdengar lebih matang dan nyaman didengar.','dist/img/20260106-143137-695cac49d06c5.png','Draft','2026-01-06 14:29:49'),
(19,2,' Postur & Relaksasi Tubuh','Menemukan Dasar Suaramu','Peserta mempelajari cara berpindah nada dengan lebih halus dan terarah. Course ini menekankan pentingnya mendengar nada tujuan sebelum berpindah agar nyanyian terdengar mengalir dan tidak ragu.','dist/img/20260106-143742-695cadb622eec.png','Published','2026-01-06 14:37:42'),
(20,2,'Mengenali Karakter Suara Sendiri','Menemukan Dasar Suaramu','Peserta diajak mengenal dan menerima karakter suara pribadinya. Course ini membantu membangun rasa nyaman saat bernyanyi tanpa membandingkan diri dengna orang lain, sehingga suara bisa digunakan secara lebih natural dan percaya diri.','dist/img/20260106-144554-695cafa221ec4.png','Draft','2026-01-06 14:45:54'),
(21,2,'Fondasi Bernyanyi','Menemukan Dasar Suaramu','Course penutup ini merangkum seluruh pembelajaran pada Materi 1: Tujuannya adalah menguatkan fondasi vokal sebelum peserta melangkah ke teknik pernapasan dan kontrol suara yang lebih spesifik di materi selanjutnya.','dist/img/20260106-145649-695cb2310a7c3.png','Published','2026-01-06 14:52:00'),
(22,13,'Napas sebagai Energi Suara','Pernapasan & Kontrol Udara','Course ini memperkenalkan napas sebagai sumber energi utama dalam bernyanyi. Peserta belajar memahami peran napas dalam menopang suara agar tidak cepat habis dan terasa lebih stabil.','dist/img/20260106-151647-695cb6dff28a3.png','Draft','2026-01-06 15:02:09'),
(23,13,'Pernapasan Diafragma yang Benar','Pernapasan & Kontrol Udara','Peserta mempelajari teknik pernapasan diafragma sebagai dasar bernyanyi yang sehat. Course ini membantu membedakan pernapasan dada dan diafragma, serta membangun napas yang lebih dalam, rileks, dan efisiensi.','dist/img/20260106-152531-695cb8eb45672.png','Published','2026-01-06 15:16:35'),
(24,13,'Mengontrol Aliran Udara Saat Bernyanyi ','Pernapasan & Kontrol Udara','Course ini fokus pada cara mengatur aliran udara agar tidak keluar terlalu cepat. Dengan kontrol udara agar tidak keluar terlalu cepat.Dengan kontrol udara yang baik, suara menjadi lebih rata, stabil, dan aman digunakan dalam waktu lama.','dist/img/20260106-153816-695cbbe836020.png','Draft','2026-01-06 15:23:18'),
(25,13,'Napas Stabil untuk Bernyanyi Lebih Percaya Diri ','Pernapasan & Kontrol Udara','Course ini menghubungkan teknik napas dengan kepercayaan diri saat bernyayi. Peserta belajar membangun kebiasaan napas yang stabil agar suara terdengar lebih yakin dan konsisten.','dist/img/20260106-153838-695cbbfebd068.png','Published','2026-01-06 15:33:19'),
(26,14,'Mengenal Pitch & Nada dalam Bernyanyi ','Pitch, Intonasi & Kontrol Nada','Course ini memperkenalkan konsep pitch dan tinggi-rendah nada. Peserta diajak memahami bahwa ketepatan nada bukan bakat semata, tetapi keterampilan yang bisa dilatih secara bertahap.','dist/img/20260106-154843-695cbe5b8c877.png','Draft','2026-01-06 15:48:43'),
(27,14,'Melatih Telinga agar Nada Lebih Akurat ','Pitch, Intonasi & Kontrol Nada','Fokus utama course ini adalah melatih pendengaran. Peserta belajar mendengar nada dengan lebih sadar agar suara bisa mengikuti pitch yang tepat secara alami.','dist/img/20260106-161018-695cc36a9e30b.png','Published','2026-01-06 15:53:56'),
(28,14,'Mengontrol Intonasi agar Tidak Goyang ','Pitch, Intonasi & Kontrol Nada','Course ini membantu peserta menjaga kestabilan nada dari awal hingga akhir. Intonasi yang baik membuat suara terdengar lebih matang dan nyaman didengar','dist/img/20260106-160254-695cc1aecb258.png','Draft','2026-01-06 16:02:54'),
(29,14,'Perpindahan Nada yang Halus','Pitch, Intonasi & Kontrol Nada','Peserta mempelajari cara berpindah nada dengan lebih halus dan terarah. Course ini menekankan pentingnya mendengar nada tujuan sebelum berpindah agar nyanyian terdengar mengalir dan tidak ragu.','dist/img/20260106-160850-695cc312c1432.png','Published','2026-01-06 16:08:50');

/*Table structure for table `tb_enrollments` */

DROP TABLE IF EXISTS `tb_enrollments`;

CREATE TABLE `tb_enrollments` (
  `id_enroll` int NOT NULL AUTO_INCREMENT,
  `id_user` int DEFAULT NULL,
  `id_course` int DEFAULT NULL,
  `progress_percentage` int DEFAULT NULL,
  `is_completed` tinyint(1) DEFAULT '0',
  `enrolled_at` timestamp NULL DEFAULT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_enroll`),
  KEY `id_user` (`id_user`),
  KEY `id_course` (`id_course`),
  CONSTRAINT `tb_enrollments_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `tb_user` (`id_user`),
  CONSTRAINT `tb_enrollments_ibfk_2` FOREIGN KEY (`id_course`) REFERENCES `tb_courses` (`id_course`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `tb_enrollments` */

insert  into `tb_enrollments`(`id_enroll`,`id_user`,`id_course`,`progress_percentage`,`is_completed`,`enrolled_at`,`completed_at`) values 
(9,5,29,0,0,'2026-01-07 20:37:51',NULL),
(10,5,19,0,0,'2026-01-07 20:37:58',NULL),
(11,5,17,100,1,'2026-01-07 20:38:13','2026-01-08 19:30:21'),
(12,5,23,100,1,'2026-01-07 20:38:24','2026-01-08 13:37:24'),
(13,5,27,100,1,'2026-01-07 20:38:32','2026-01-08 15:00:42'),
(14,5,21,50,0,'2026-01-08 14:59:13',NULL);

/*Table structure for table `tb_module_completions` */

DROP TABLE IF EXISTS `tb_module_completions`;

CREATE TABLE `tb_module_completions` (
  `id_completion` int NOT NULL AUTO_INCREMENT,
  `id_enroll` int DEFAULT NULL,
  `id_module` int DEFAULT NULL,
  `is_completed` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id_completion`),
  KEY `id_enroll` (`id_enroll`),
  KEY `id_module` (`id_module`),
  CONSTRAINT `tb_module_completions_ibfk_1` FOREIGN KEY (`id_enroll`) REFERENCES `tb_enrollments` (`id_enroll`),
  CONSTRAINT `tb_module_completions_ibfk_2` FOREIGN KEY (`id_module`) REFERENCES `tb_modules` (`id_modules`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `tb_module_completions` */

insert  into `tb_module_completions`(`id_completion`,`id_enroll`,`id_module`,`is_completed`) values 
(21,12,97,1),
(22,12,98,1),
(23,12,99,1),
(24,12,100,1),
(25,12,101,1),
(26,14,70,1),
(27,14,71,0),
(28,13,136,1),
(29,13,139,1),
(30,13,137,1),
(31,13,138,1),
(32,13,140,1),
(33,11,39,1),
(34,11,40,1),
(35,11,41,1),
(36,11,42,1),
(37,11,43,1),
(38,11,44,1);

/*Table structure for table `tb_modules` */

DROP TABLE IF EXISTS `tb_modules`;

CREATE TABLE `tb_modules` (
  `id_modules` int NOT NULL AUTO_INCREMENT,
  `id_course` int DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content_url` text,
  `content_body` text,
  `order` int DEFAULT NULL,
  PRIMARY KEY (`id_modules`)
) ENGINE=InnoDB AUTO_INCREMENT=141 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `tb_modules` */

insert  into `tb_modules`(`id_modules`,`id_course`,`title`,`content_url`,`content_body`,`order`) values 
(28,16,'Suara Bukan Sekadar Bunyi','','Banyak orang merasa tidak nyaman dengan suara mereka sendiri. Ada yang bilang suaranya tipis, ada yang merasa fals, ada juga yang langsung menyerah karena merasa “nggak berbakat”. Padahal, sebelum bicara soal bagus atau tidak, hal pertama yang perlu dipahami adalah: suara bukan sekadar bunyi yang keluar dari mulut. \r\n\r\nSuara adalah hasil kerja sama tubuh. Cara kamu bernapas, posisi tubuh, sampai ketegangan kecil di leher atau bahu bisa memengaruhi bagaimana suara terdengar. Itu sebabnya dua orang yang menyanyikan nada yang sama bisa terdengar sangat berbeda. Bukan karena salah satunya jelek, tapi karena cara tubuh mereka bekerja berbeda. \r\n\r\nDi tahap awal belajar vokal, kamu tidak dituntut untuk langsung bisa bernyanyi dengan sempurna. Yang jauh lebih penting adalah membangun kesadaran bahwa suara bisa dipelajari, diarahkan, dan dilatih. Kalau kamu mulai melihat suara sebagai alat musik yang hidup, proses belajar akan terasa lebih masuk akal dan tidak lagi menakutkan. ',1),
(29,16,'Bagaimana Suara Dihasilkan oleh Tubuh ','https://youtu.be/JfJESsC-T4w?si=HpuwjVQOHY13DlQq','Sebelum suara terdengar keluar, ada proses panjang yang terjadi di dalam tubuh. Udara ditarik masuk ke paru-paru, lalu dikeluarkan secara terkontrol hingga menggetarkan pita suara. Getaran ini kemudian diperkuat oleh ruang-ruang di dalam tubuh seperti rongga mulut dan hidung, yang memberi warna khas pada suara setiap orang. \r\n\r\n? Di video ini, kamu akan melihat proses tersebut dijelaskan secara sederhana. \r\nTujuannya bukan supaya kamu hafal anatomi, tapi supaya kamu sadar bahwa suara tidak seharusnya dipaksa. Kalau satu bagian tubuh bekerja terlalu keras, hasilnya justru suara terdengar tegang dan tidak stabil. ',2),
(30,16,'Kenapa Banyak Orang Tidak Suka dengan Suaranya Sendiri','','Alasan paling umum orang membenci suaranya sendiri adalah karena mereka mendengarnya dari rekaman. Suara di rekaman terdengar asing karena berbeda dengan suara yang kita dengar di kepala sendiri. Hal ini normal dan dialami hampir semua orang, termasuk penyanyi profesional. \r\n\r\nMasalahnya, banyak orang langsung menyimpulkan bahwa suara mereka buruk, tanpa memberi kesempatan untuk belajar dan beradaptasi. Padahal, ketidaknyamanan itu bukan tanda kegagalan, melainkan tanda bahwa telinga dan otak sedang menyesuaikan diri. \r\n\r\nDi bab ini, kamu diajak untuk berhenti menghakimi suara terlalu cepat. Suara yang belum terlatih bukan suara yang jelek—hanya suara yang belum diarahkan. ',3),
(31,16,'Teknik Vokal Itu Membantu, Bukan Mengubah Suara','https://youtu.be/xOrHYEm6rrs?si=R4-_OoFsvg_ROsYm','Salah satu ketakutan terbesar pemula adalah kehilangan “suara asli” mereka. Padahal, teknik vokal tidak bertujuan mengubah karakter suara. Justru sebaliknya, teknik vokal membantu suara aslimu terdengar lebih jelas, lebih stabil, dan lebih nyaman digunakan. \r\n\r\n? Video ini akan membantu kamu memahami bahwa teknik bukan soal meniru orang lain, tapi soal menemukan cara paling sehat untuk menggunakan suara sendiri.',4),
(32,16,' Kesimpulan — Suaramu Layak Dilatih','','Setelah mempelajari course ini, hal terpenting yang perlu kamu bawa adalah kesadaran bahwa suara bukan sesuatu yang statis. Suara bisa berkembang seiring pemahaman dan latihan yang tepat. Tidak ada suara yang “tidak bisa”, yang ada hanyalah suara yang belum dilatih dengan cara yang benar. \r\n\r\nCourse ini menjadi pondasi awal sebelum kamu masuk ke teknik-teknik vokal yang lebih spesifik. Dengan mindset yang lebih terbuka dan pemahaman dasar yang kuat, proses belajar selanjutnya akan terasa jauh lebih ringan.',5),
(39,17,'Suara Tidak Datang dari Tenggorokan','','Banyak orang berpikir suara berasal dari tenggorokan. Padahal, tenggorokan hanyalah “jalan lewat”, bukan sumber utama suara. Suara terbentuk dari kerja sama banyak bagian tubuh: paru-paru, diafragma, pita suara, hingga rongga mulut dan hidung. Kalau satu bagian bekerja terlalu keras, suara jadi cepat lelah. \r\n\r\nKetika seseorang bernyanyi dengan fokus di tenggorokan, biasanya suara terasa ditekan, cepat serak, dan sulit dikontrol. Inilah alasan kenapa memahami cara kerja suara itu penting sejak awal. Dengan tahu bahwa suara adalah hasil kerja seluruh tubuh, peserta bisa mulai bernyanyi dengan lebih santai dan aman. ',1),
(40,17,'Peran Napas dalam Menghasilkan Suara','https://youtu.be/z4I0Rumg2oA?si=HdMAwv_sVfPRlZRO ','Napas adalah bahan bakar utama suara. Tanpa aliran udara yang stabil, suara akan terdengar goyah, lemah, atau bahkan putus-putus. Saat bernyanyi, napas tidak boleh keluar sembarangan, tapi harus diatur agar bisa menopang nada. \r\n\r\nDi video ini, peserta akan mulai menyadari bahwa bernyanyi bukan soal seberapa keras suara keluar, tapi seberapa baik napas mendukung suara tersebut. Ini akan menjadi dasar penting untuk materi pernapasan di course berikutnya. ',2),
(41,17,'Pita Suara: Kecil tapi Penting','','Pita suara adalah dua lipatan kecil di dalam laring yang bergetar saat udara melewatinya. Getaran inilah yang menghasilkan bunyi. Semakin tegang pita suara, semakin tinggi nada yang dihasilkan. Sebaliknya, pita suara yang terlalu tegang justru bisa membuat suara terdengar keras tapi tidak nyaman. \r\n\r\nPenting untuk dipahami bahwa pita suara tidak boleh dipaksa. Jika dipaksa terus-menerus, risikonya bukan hanya suara serak, tapi juga cedera jangka panjang. Dengan mengenal fungsi pita suara, peserta akan lebih berhati-hati dan belajar menghargai batas kemampuan suaranya sendiri.',3),
(42,17,'Resonansi: Kenapa Suara Bisa Terdengar Bulat','','Resonansi adalah proses di mana suara diperkuat oleh ruang-ruang di dalam tubuh, seperti rongga mulut, hidung, dan dada. Inilah yang membuat suara setiap orang terdengar unik dan memiliki “warna” masing-masing. \r\n\r\nTanpa resonansi yang baik, suara terdengar tipis dan datar meskipun nadanya benar. Dengan resonansi, suara bisa terdengar lebih penuh tanpa harus bernyanyi keras. Di tahap ini, peserta tidak dituntut untuk menguasai resonansi, tapi cukup memahami bahwa suara indah bukan soal teriak, melainkan soal arah suara.',4),
(43,17,'Kesalahan Umum Saat Menggunakan Suara','https://youtu.be/Vamn0HFFa7M?si=O30IGiv-z1eD3wyr','Banyak pemula melakukan kesalahan tanpa sadar, seperti mengangkat bahu saat bernapas, menegang di leher, atau memaksa nada tinggi. Kesalahan-kesalahan kecil ini lama-lama bisa membuat suara terasa “nggak enak” dan bikin nyanyi jadi nggak nyaman. \r\n\r\nVideo ini membantu peserta mengenali kebiasaan buruk tersebut sejak dini, sehingga bisa dihindari sebelum menjadi kebiasaan jangka panjang.',5),
(44,17,' Kesimpulan: Suara adalah Kerja Tim Tubuh ','','Bernyanyi bukan hanya soal suara yang keluar, tapi tentang bagaimana tubuh bekerja secara seimbang. Napas, pita suara, dan resonansi harus saling mendukung, bukan saling memaksa. Ketika satu bagian bekerja terlalu keras, bagian lain akan kelelahan. \r\n\r\nDengan memahami cara kerja suara manusia, peserta kini punya bekal penting untuk melangkah ke teknik vokal berikutnya. Di course selanjutnya, kita akan mulai masuk ke pernapasan yang benar untuk bernyanyi, agar suara bisa lebih kuat, stabil, dan nyaman digunakan.',6),
(51,18,'Merasa Suara Jelek Sejak Awal','','Salah satu kesalahan terbesar dalam bernyanyi justru bukan teknis, tapi mental. Banyak orang sudah memutuskan sejak awal bahwa suaranya buruk, fals, atau tidak cocok untuk bernyanyi. Pikiran ini bikin tubuh otomatis tegang, napas pendek, dan suara jadi makin tidak stabil. \r\n\r\nPadahal, suara adalah alat yang bisa dilatih. Ketika seseorang bernyanyi sambil terus menghakimi dirinya sendiri, tubuh tidak pernah benar-benar rileks. Course ini mengajak peserta untuk menyadari bahwa proses belajar vokal dimulai dari berhenti membenci suara sendiri. ',1),
(52,18,' Bernyanyi Terlalu Keras dan Memaksa','https://youtu.be/SgvPRGHzyw4?si=znBi0ppSJXlHGRdb','Banyak orang berpikir bernyanyi dengan kuat berarti bernyanyi dengan baik. Akhirnya suara ditekan, volume dipaksa naik, dan tenggorokan bekerja terlalu keras. Hasilnya mungkin terdengar “kencang”, tapi tidak nyaman dan cepat membuat suara lelah. \r\n\r\nDi video ini, peserta akan melihat kenapa suara keras belum tentu suara yang benar, dan bagaimana tekanan berlebihan justru membuat kualitas suara menurun. ',2),
(53,18,'Napas yang Terlalu Pendek','','Kesalahan umum lainnya adalah bernapas terlalu dangkal. Banyak penyanyi pemula mengambil napas cepat dan pendek, lalu langsung menghabiskannya di awal kalimat lagu. Akibatnya, nada akhir sering terdengar lemah atau tidak sampai. \r\n\r\nNapas yang pendek membuat tubuh panik dan suara kehilangan kontrol. Dengan menyadari kebiasaan ini, peserta mulai memahami bahwa masalah suara sering kali berawal dari cara bernapas, bukan dari nada yang salah.',3),
(54,18,'Tubuh yang Tegang Saat Bernyanyi','','Ketegangan di bahu, leher, dan rahang sering dianggap hal sepele, padahal sangat memengaruhi suara. Tubuh yang tegang menghambat aliran udara dan membuat pita suara bekerja lebih berat dari seharusnya. \r\n\r\nBernyanyi seharusnya terasa ringan, bukan seperti mengangkat beban. Bab ini membantu peserta lebih sadar dengan kondisi tubuhnya sendiri saat bernyanyi, sehingga bisa mulai membedakan mana usaha yang sehat dan mana yang berlebihan.',4),
(55,18,'Terlalu Meniru Penyanyi Lain','https://youtu.be/Px6V6m5V4iY?si=0N3A5JOZBgxeMaAE','Meniru penyanyi favorit itu wajar, tapi jika dilakukan terus-menerus tanpa mengenal suara sendiri, justru bisa menjadi masalah. Banyak orang memaksa warna suara, gaya, bahkan nada yang sebenarnya tidak nyaman bagi tubuhnya. \r\n\r\nVideo ini membahas kenapa setiap suara itu unik dan kenapa memaksakan karakter orang lain justru membuat suara terdengar tidak natural',5),
(56,18,'Kesimpulan: Kesalahan Bisa Jadi Titik Awal','','Setiap kesalahan dalam bernyanyi sebenarnya adalah petunjuk. Dari napas yang pendek, tubuh yang tegang, hingga kebiasaan memaksa suara, semuanya bisa diperbaiki jika disadari lebih dulu. Tidak ada suara yang “rusak”, yang ada hanya kebiasaan yang belum tepat. \r\n\r\nDengan memahami kesalahan umum ini, peserta sekarang punya bekal penting untuk memperbaiki teknik secara bertahap. Di course selanjutnya, kita akan mulai membangun fondasi tubuh dan postur yang benar, agar suara bisa keluar lebih bebas dan stabil. ',6),
(57,19,'Tubuh adalah Pondasi Suara','','Saat bernyanyi, tubuh bekerja seperti fondasi sebuah bangunan. Kalau fondasinya tidak stabil, suara akan sulit dikontrol meskipun teknik lain sudah dipelajari. Postur tubuh memengaruhi aliran napas, posisi leher, hingga kebebasan pita suara dalam bergetar. \r\n\r\nBernyanyi dengan postur yang salah sering membuat suara terasa berat dan cepat lelah. Tanpa disadari, tubuh yang membungkuk atau kaku memaksa tenggorokan bekerja lebih keras. Karena itu, sebelum berbicara soal teknik lanjutan, tubuh perlu dipersiapkan terlebih dahulu.',1),
(58,19,'Postur Ideal Saat Bernyanyi','https://youtu.be/RnBodWefP40?si=7PSFoGDCoYkCCvQa','Postur bernyanyi yang baik bukan berarti berdiri kaku seperti patung. Postur yang ideal justru terasa seimbang dan rileks: tubuh tegak, bahu tidak terangkat, dan kepala berada di posisi netral. \r\n\r\nDi video ini, peserta akan melihat contoh postur yang benar dan kesalahan postur yang sering dilakukan tanpa sadar. Postur yang tepat membantu napas mengalir lebih lancar dan membuat suara keluar lebih natural. ',2),
(59,19,'Ketegangan yang Sering Tidak Disadari ','','Banyak ketegangan terjadi tanpa kita sadari, terutama di area bahu, leher, dan rahang. Ketegangan ini sering muncul karena rasa gugup, kurang percaya diri, atau kebiasaan sehari-hari. Saat bagian-bagian ini tegang, suara akan sulit keluar dengan bebas. \r\n\r\nBab ini membantu peserta lebih peka terhadap sinyal tubuhnya sendiri. Dengan menyadari bagian mana yang sering menegang, peserta bisa mulai belajar melepaskan ketegangan tersebut sebelum bernyanyi. ',3),
(60,19,' Relaksasi Sebelum dan Saat Bernyanyi ','https://youtu.be/2euowIWIvRc?si=qkVlZ9kgqMfVX0_o','Relaksasi bukan berarti malas atau kurang tenaga. Justru, tubuh yang rileks memungkinkan suara keluar dengan lebih efisien. Banyak penyanyi profesional melakukan relaksasi ringan sebelum bernyanyi untuk menghindari suara tertekan. \r\n\r\nVideo ini memperlihatkan cara sederhana untuk membuat tubuh lebih siap bernyanyi tanpa latihan yang rumit. Fokusnya bukan pada hasil instan, tapi kenyamanan jangka panjang. ',4),
(61,19,'Postur Saat Duduk dan Aktivitas Sehari-hari ','','Bernyanyi tidak selalu dilakukan sambil berdiri. Banyak orang bernyanyi sambil duduk atau bahkan saat beraktivitas sehari-hari. Postur duduk yang salah juga bisa memengaruhi kualitas suara, terutama jika tubuh membungkuk atau bahu terangkat. \r\n\r\nBab ini membantu peserta memahami bahwa kebiasaan tubuh di luar sesi latihan juga berpengaruh pada suara. Dengan postur yang lebih sadar, kualitas vokal bisa meningkat secara perlahan tanpa disadari. ',5),
(62,19,'Kesimpulan: Tubuh Rileks, Suara Mengalir','','Postur dan relaksasi adalah dasar penting agar suara bisa keluar dengan bebas. Tubuh yang seimbang dan tidak tegang membantu napas bekerja optimal dan mengurangi tekanan pada pita suara. Tanpa postur yang baik, teknik vokal lain akan terasa lebih sulit diterapkan. \r\n\r\nSetelah menyelesaikan course ini, peserta diharapkan lebih sadar terhadap tubuhnya sendiri saat bernyanyi. Course selanjutnya akan membantu peserta mengenali karakter suara pribadi, agar bernyanyi terasa lebih natural dan percaya diri. ',6),
(63,20,'Setiap Suara Itu Unik','','Tidak ada dua suara manusia yang benar-benar sama. Bahkan saudara kembar pun memiliki karakter vokal yang berbeda. Perbedaan ini muncul dari bentuk tubuh, pita suara, hingga cara bernapas masing-masing orang. Karena itu, membandingkan suara sendiri dengan orang lain hanya akan membuat proses belajar terasa berat. \r\n\r\nBernyanyi bukan tentang menjadi seperti penyanyi tertentu, tapi tentang menemukan cara terbaik menggunakan suara sendiri. Saat seseorang mulai menerima bahwa suaranya unik, proses belajar vokal akan terasa lebih ringan dan menyenangkan. ',1),
(64,20,'Warna Suara dan Rasa Nyaman ','','Setiap suara memiliki warna atau karakter, seperti terang, gelap, ringan, atau tebal. Warna suara ini tidak salah dan tidak perlu diubah. Yang terpenting adalah menemukan area suara yang terasa paling nyaman saat bernyanyi. \r\n\r\nBanyak orang memaksakan diri bernyanyi di wilayah nada yang sebenarnya tidak cocok, sehingga suara terasa berat atau tegang. Dengan mengenali rasa nyaman dalam bernyanyi, peserta bisa mulai membangun kepercayaan diri terhadap suaranya sendiri. ',2),
(65,20,'Range Suara Bukan Segalanya','https://youtu.be/sn-9s-Ou8OM?si=-N-rxlhbCfLKO0No','Sering kali orang merasa suara mereka “jelek” hanya karena tidak bisa mencapai nada tinggi tertentu. Padahal, kemampuan bernyanyi tidak hanya ditentukan oleh tinggi rendahnya nada, tetapi oleh kontrol, kenyamanan, dan ekspresi. \r\n\r\nVideo ini membantu memahami bahwa setiap orang memiliki batas suara yang berbeda, dan itu sepenuhnya normal. ',3),
(66,20,'Berhenti Memaksakan Gaya Orang Lain','','Meniru gaya penyanyi lain sering dilakukan tanpa sadar. Nada dipaksakan, warna suara diubah, bahkan cara bernyanyi dibuat tidak natural. Hal ini justru membuat suara terasa asing di tubuh sendiri. \r\n\r\nMulai lah bernyanyi dengan jujur pada suaranya sendiri. Saat gaya bernyanyi selaras dengan karakter suara, hasilnya akan terdengar lebih tulus dan nyaman. ',4),
(67,20,'Kesimpulan: Suara Asli Adalah Kekuatan ','','Mengenali karakter suara adalah langkah penting untuk bernyanyi dengan percaya diri. Suara yang nyaman digunakan akan lebih mudah dikontrol dan jauh lebih aman untuk jangka panjang. Tidak perlu menjadi suara orang lain untuk terdengar baik. \r\n\r\nTerimalah dan pahami suara pribadinya sebelum melangkah ke tahap berikutnya. ',5),
(70,21,'Merangkum Perjalanan Materi 1 ','','Pada Materi 1, peserta telah mempelajari dasar-dasar penting dalam bernyanyi: memahami cara kerja suara, mengenali kesalahan umum, memperbaiki postur tubuh, hingga menerima karakter suara sendiri. Semua ini bukan bertujuan membuat suara langsung sempurna, tetapi membangun fondasi yang sehat. \r\n\r\nFondasi ini sangat penting agar latihan vokal selanjutnya tidak terasa berat atau membingungkan. Tanpa dasar yang kuat, teknik lanjutan justru bisa menjadi beban bagi suara. ',1),
(71,21,'Kesiapan Masuk Materi Selanjutnya ','','Setelah memahami dasar vokal, tubuh, dan karakter suara, peserta kini berada di tahap yang tepat untuk mempelajari teknik yang lebih spesifik. Materi selanjutnya akan mulai fokus pada pernapasan yang lebih terkontrol dan penggunaan suara yang lebih stabil. \r\n\r\nProses belajar vokal adalah perjalanan, bukan perlombaan. Dengan fondasi yang sudah dibangun di Materi 1, peserta siap melangkah lebih jauh dengan lebih percaya diri. ',2),
(82,22,'Napas Bukan Sekadar Tarik Udara','','Banyak orang mengira bernyanyi hanya membutuhkan napas yang banyak. Padahal, dalam vokal, napas bukan sekadar udara yang masuk ke tubuh, melainkan energi utama yang menggerakkan suara. Tanpa pengelolaan napas yang baik, suara akan terdengar tidak stabil, cepat habis, dan sulit dikontrol meskipun nadanya tepat. \r\n\r\nSaat bernyanyi, napas harus digunakan secara sadar. Artinya, kita memahami kapan harus mengambil napas, bagaimana menghematnya, dan bagaimana melepaskannya bersama suara. Kesadaran ini membuat suara terasa lebih ringan dan tidak memaksa tenggorokan. ',1),
(83,22,'Kenapa Suara Cepat Habis Saat Bernyanyi ','','Suara yang cepat habis sering kali bukan disebabkan oleh kurangnya napas, tetapi karena udara keluar terlalu cepat. Banyak orang menghabiskan napas di awal kalimat lagu sehingga bagian akhir terdengar lemah atau terputus. \r\n\r\nSelain itu, kebiasaan bernapas dangkal juga membuat suara tidak memiliki penopang yang cukup. Dengan memahami penyebab ini, peserta dapat mulai menyadari bahwa masalah bernyanyi sering kali berawal dari cara bernapas, bukan dari kualitas suara itu sendiri ',2),
(84,22,'Hubungan Napas dan Kontrol Suara ','https://youtu.be/RPutp6Ogp4s?si=4uAgnVOi0VagzPn6v','Napas dan suara harus bekerja sebagai satu kesatuan. Ketika aliran napas tidak stabil, suara akan ikut terdengar goyah. Video ini membantu peserta memahami bagaimana napas yang terkontrol dapat menopang suara agar tetap stabil saat bernyanyi. ',3),
(85,22,'Bernapas dengan Tenang, Bukan Menahan ','','Mengontrol napas bukan berarti menahannya dengan keras. Napas yang ditahan justru membuat tubuh tegang dan suara sulit keluar. Bernapas untuk bernyanyi seharusnya terasa tenang dan mengalir secara alami. \r\n\r\nKetika napas dilepaskan sedikit demi sedikit bersama suara, tubuh menjadi lebih rileks dan kontrol suara terasa lebih mudah. Ini adalah dasar penting sebelum mempelajari teknik pernapasan yang lebih spesifik. ',4),
(86,22,'Kesimpulan — Napas adalah Pondasi Suara','','Napas merupakan pondasi utama dalam bernyanyi. Bukan soal seberapa banyak udara yang diambil, tetapi bagaimana udara tersebut dikelola untuk menopang suara. Dengan napas yang sadar dan stabil, suara dapat terdengar lebih nyaman dan aman digunakan. \r\n\r\nSetelah menyelesaikan course ini, peserta siap melanjutkan ke pembahasan pernapasan diafragma pada course berikutnya. ',5),
(97,23,'Mengenal Diafragma sebagai Penopang Napas','','Diafragma adalah otot utama yang berperan besar dalam pernapasan saat bernyanyi. Letaknya berada di bawah paru-paru dan bekerja seperti pompa yang membantu udara masuk dan keluar secara lebih terkontrol. Saat diafragma digunakan dengan baik, napas terasa lebih dalam tanpa membuat dada atau bahu ikut terangkat. \r\n\r\nBanyak orang sebenarnya sudah menggunakan diafragma dalam kehidupan sehari-hari, seperti saat menguap atau tertawa. Namun, saat bernyanyi, kebiasaan ini sering hilang karena gugup atau terlalu fokus pada suara. Dengan memahami peran diafragma, peserta dapat mulai bernapas dengan lebih alami dan efisien. ',1),
(98,23,'Pernapasan Dada vs Pernapasan Diafragma','','Pernapasan dada ditandai dengan bahu yang terangkat dan napas yang cepat habis. Cara bernapas ini kurang efektif untuk bernyanyi karena udara tidak bertahan lama dan suara mudah kehilangan tenaga. Sebaliknya, pernapasan diafragma membuat bagian perut bergerak lebih aktif, sementara tubuh bagian atas tetap rileks. \r\n\r\nPerbedaan ini penting disadari agar peserta bisa mengenali kebiasaan bernapasnya sendiri. Dengan pernapasan diafragma, suara mendapat penopang yang lebih stabil tanpa perlu usaha berlebihan dari tenggorokan. ',2),
(99,23,'Merasakan Napas Masuk Lebih Dalam ','https://youtu.be/G2_db6MSkm0?si=JT4da0WL0WTD2rFo','Bab ini membantu peserta mulai merasakan langsung pernapasan diafragma. Fokusnya bukan pada hasil cepat, tetapi pada kesadaran tubuh saat udara masuk dan keluar. ',3),
(100,23,'Kesalahan Umum Saat Belajar Napas Diafragma ','','Kesalahan yang sering terjadi adalah menarik napas terlalu kuat hingga tubuh menjadi tegang. Ada juga yang mendorong perut secara berlebihan, sehingga pernapasan terasa tidak alami. Padahal, napas diafragma seharusnya terasa nyaman dan mengalir. \r\n\r\nBab ini membantu peserta memahami bahwa tujuan utama pernapasan diafragma bukan menunjukkan gerakan tertentu, tetapi menciptakan napas yang stabil dan santai untuk mendukung suara. ',4),
(101,23,'Kesimpulan: Napas Lebih Dalam, Suara Lebih Stabil ','','Pernapasan diafragma memberikan dasar yang kuat untuk bernyanyi dengan nyaman dan aman. Dengan napas yang lebih dalam dan terkontrol, suara dapat keluar tanpa tekanan berlebih dan tidak cepat lelah. \r\n\r\nSetelah menyelesaikan course ini, peserta memiliki bekal penting untuk mempelajari kontrol aliran udara, agar napas yang sudah baik bisa digunakan secara maksimal saat bernyanyi. ',5),
(107,24,'Udara yang Keluar Terlalu Cepat ','','Salah satu penyebab suara terdengar tidak stabil adalah udara yang keluar terlalu cepat saat bernyanyi. Banyak orang langsung menghabiskan napas di awal kalimat lagu tanpa sadar, sehingga bagian akhir suara terdengar lemah atau terputus. Masalah ini sering disalahartikan sebagai “kurang napas”, padahal yang terjadi adalah kurang kontrol. \r\n\r\nMengontrol aliran udara berarti mengatur seberapa cepat udara dilepaskan bersama suara. Ketika udara bisa bertahan lebih lama, suara pun terdengar lebih rata dan konsisten dari awal hingga akhir frase lagu. ',1),
(108,24,'Menahan vs Mengontrol Napas ','','Mengontrol napas tidak sama dengan menahan napas. Menahan napas membuat tubuh tegang dan suara sulit keluar. Sebaliknya, kontrol napas adalah kemampuan melepaskan udara secara perlahan dan stabil tanpa tekanan. \r\n\r\nBab ini membantu peserta memahami perbedaan penting tersebut. Dengan kontrol yang tepat, suara akan terasa lebih ringan dan tidak cepat lelah meskipun digunakan dalam waktu yang lama. ',2),
(109,24,'Contoh Aliran Udara yang Stabil ','https://youtu.be/nojUovjGU64','Di video ini, peserta akan melihat perbedaan antara aliran udara yang tidak terkontrol dan aliran udara yang stabil. Contoh visual ini membantu peserta lebih mudah memahami konsep yang sebelumnya dijelaskan secara narasi. ',3),
(110,24,'Hubungan Aliran Udara dan Nada ','','Aliran udara yang tidak stabil sering membuat nada terdengar goyah. Ketika udara tiba-tiba habis atau dilepas terlalu cepat, nada sulit dipertahankan. Dengan aliran udara yang lebih terkontrol, nada bisa terdengar lebih rata dan konsisten. \r\n\r\nBab ini menekankan bahwa kontrol udara bukan hanya soal napas, tetapi juga berpengaruh langsung pada kestabilan nada dan kualitas suara secara keseluruhan. ',4),
(111,24,'Kesimpulan — Udara yang Terkontrol, Suara Lebih Aman ','','Mengontrol aliran udara adalah kunci agar suara dapat digunakan dengan lebih aman dan stabil. Bukan dengan menahan napas, tetapi dengan mengalirkan udara secara sadar dan konsisten. \r\n\r\nSetelah menyelesaikan course ini, peserta siap melanjutkan ke pembahasan sinkronisasi napas dan suara, agar teknik pernapasan yang sudah dipelajari bisa digunakan secara lebih efektif dalam bernyanyi. ',5),
(112,25,'Napas Adalah Pondasi Kepercayaan Diri ','','Banyak orang merasa tidak percaya diri saat bernyanyi bukan karena suaranya jelek, tapi karena napasnya tidak stabil. Ketika napas cepat habis atau terasa tercekik, tubuh otomatis panik dan suara ikut goyah. Dari sinilah rasa ragu mulai muncul. \r\n\r\nNapas yang terkontrol membuat tubuh merasa aman. Saat tubuh aman, pikiran lebih tenang, dan suara pun keluar lebih yakin. Bab ini menanamkan pemahaman bahwa kepercayaan diri dalam bernyanyi sangat berkaitan dengan cara kita mengelola napas. ',1),
(113,25,'Bernyanyi Lebih Panjang Tanpa Kehabisan Udara ','','Salah satu tanda napas yang mulai stabil adalah kemampuan menyanyi lebih panjang tanpa rasa kehabisan udara. Ini bukan soal menarik napas sebanyak mungkin, tetapi menggunakan udara secara efisien dan terkontrol. \r\n\r\nPahami bahwa bernyanyi tidak perlu boros napas. Dengan pengaturan yang tepat, frasa panjang dapat dinyanyikan dengan lebih santai dan konsisten, tanpa rasa terburu-buru. ',2),
(114,25,'Contoh Napas Stabil dalam Lagu','https://youtu.be/Z2eHIMCzwEU?si=97RPby80vGY51rhI','Melalui video ini, kalian dapat mendengar perbedaan antara suara yang didukung napas stabil dan suara yang kehabisan kontrol udara. Fokusnya bukan pada nada tinggi, tetapi pada alur napas yang tenang dan terjaga. ',3),
(115,25,'Mengubah Kebiasaan Bernapas Sehari-hari ','','Teknik pernapasan tidak hanya digunakan saat bernyanyi, tetapi juga terbentuk dari kebiasaan sehari-hari. Cara duduk, berdiri, hingga cara berbicara berpengaruh besar pada pola napas. \r\n\r\nBab ini menekankan pentingnya membawa kesadaran napas ke aktivitas harian. Semakin sering tubuh terbiasa bernapas dengan benar, semakin alami teknik vokal terasa saat bernyanyi. ',4),
(116,25,'Kesimpulan: Napas yang Tenang, Suara yang Meyakinkan ','','Pernapasan yang baik bukan hanya soal teknik, tetapi tentang rasa aman dan kontrol dalam bernyanyi. Ketika napas stabil, suara menjadi lebih konsisten, ekspresi lebih bebas, dan kepercayaan diri meningkat. \r\n\r\nDengan selesainya Materi 2, peserta telah memiliki fondasi napas yang kuat untuk melangkah ke materi selanjutnya, yaitu pengembangan kualitas suara dan kontrol nada. ',5),
(117,26,'Apa Itu Pitch? ','','Pitch adalah tinggi-rendahnya sebuah nada. Saat bernyanyi, pitch menentukan apakah suara terdengar tepat, terlalu tinggi, atau terlalu rendah. Banyak orang merasa “nggak bisa nyanyi” padahal sebenarnya hanya belum memahami bagaimana pitch bekerja. \r\n\r\nPitch bukan bakat bawaan semata, tetapi keterampilan yang bisa dilatih. Dengan pemahaman yang benar, telinga dan suara bisa dilatih untuk bekerja sama agar nada yang keluar lebih akurat. ',1),
(118,26,'Nada Tepat vs Nada Fals ','','Nada tepat terdengar selaras dengan musik atau acuan nada, sedangkan nada fals terasa mengganggu meskipun selisihnya kecil. Masalahnya, banyak orang tidak sadar saat dirinya fals. \r\n\r\nBab ini membantu peserta menyadari bahwa fals bukan kegagalan, tapi sinyal bahwa telinga dan kontrol suara belum sinkron. Kesadaran ini adalah langkah awal menuju perbaikan. ',2),
(119,26,'Peran Pendengaran dalam Bernyanyi ','','Bernyanyi bukan hanya soal suara, tapi juga soal mendengar. Telinga berfungsi sebagai “navigator” yang memberi tahu suara apakah nada sudah tepat atau belum. \r\n\r\nDi bab ini, peserta diajak memahami pentingnya mendengarkan nada sebelum dan saat bernyanyi, agar suara tidak berjalan sendiri tanpa arah. ',3),
(120,26,'Contoh Pitch yang Tepat dalam Lagu ','https://youtu.be/0YeiZ46GTK8?si=XcipLiwjYGadOqSg','Video ini memperlihatkan perbedaan jelas antara pitch yang tepat dan pitch yang melenceng, agar peserta bisa mengenali rasanya secara langsung. ',4),
(121,26,' Kesimpulan: Pitch Bisa Dilatih ','','Pitch yang baik bukan soal suara mahal, tetapi soal kesadaran dan latihan yang konsisten. Semakin sering telinga dan suara dilatih bersama, semakin mudah bernyanyi dengan nada yang tepat. \r\n\r\nCourse ini menjadi dasar penting sebelum masuk ke latihan kontrol nada dan intonasi yang lebih dalam. ',5),
(127,28,'Apa Itu Intonasi? ','','Intonasi adalah cara kita mempertahankan nada tetap stabil dari awal sampai akhir. Seseorang bisa saja mengenai nada yang benar di awal, tetapi jika nadanya turun atau naik di tengah, intonasinya dianggap belum stabil. \r\n\r\nBab ini membantu peserta memahami bahwa intonasi bukan tentang tinggi nada, melainkan tentang konsistensi. Suara yang intonasinya baik terdengar lebih profesional, tenang, dan enak didengar meskipun lagunya sederhana. ',1),
(128,28,'Kenapa Nada Sering Turun di Tengah Lagu? ','','Nada yang turun di tengah lagu biasanya bukan karena tidak bisa mencapai nada tersebut, melainkan karena kurangnya kontrol napas dan fokus pendengaran. Saat napas mulai habis, tubuh cenderung menurunkan nada tanpa disadari. \r\n\r\nBab ini mengajak peserta mengenali tanda-tanda ketika intonasi mulai goyah, sehingga bisa segera dikoreksi sebelum suara benar-benar melenceng. ',2),
(129,28,'Menjaga Nada Tetap Stabil ','','Menjaga intonasi membutuhkan kombinasi antara napas yang terkontrol, telinga yang aktif, dan sikap tubuh yang relaks. Ketika salah satu elemen ini terganggu, nada akan ikut terpengaruh. \r\n\r\nDi bab ini, peserta belajar memahami bahwa stabilitas nada datang dari ketenangan tubuh, bukan dari memaksa suara agar “tetap tinggi”. ',3),
(130,28,'Contoh Intonasi Stabil dalam Bernyanyi ','https://youtu.be/NaXPMSgZs9g?si=tmJyjh7Hig1QXZrR','Video ini memperlihatkan bagaimana satu nada yang sama bisa terdengar stabil atau goyah, tergantung pada kontrol intonasi penyanyinya. ',4),
(131,28,'Kesimpulan: Intonasi Membuat Suara Terasa Matang ','','Intonasi yang stabil membuat suara terdengar lebih dewasa dan terkontrol. Bukan soal seberapa tinggi nada yang bisa dicapai, tetapi seberapa konsisten nada tersebut dijaga. \r\n\r\nSetelah menyelesaikan course ini, peserta siap masuk ke tahap menggabungkan pitch dan intonasi dalam satu alur bernyanyi yang utuh. ',5),
(132,29,'Bernyanyi Tidak Pernah Diam di Satu Nada ','','Dalam lagu, nada jarang berdiri sendiri. Hampir selalu ada perpindahan dari satu nada ke nada lain, baik naik maupun turun. Di sinilah banyak suara terdengar ragu atau melompat tanpa arah, meskipun nada awal dan akhirnya benar. \r\n\r\nBernyanyi bukan sekadar menekan nada yang tepat, tetapi mengalir dari satu nada ke nada berikutnya. Ketika perpindahan terasa kasar atau tergesa-gesa, nyanyian terdengar tidak stabil dan kurang nyaman didengar. ',1),
(133,29,'Kenapa Perpindahan Nada Sering Melenceng ','','Perpindahan nada sering meleset bukan karena jarak nadanya terlalu jauh, melainkan karena suara bergerak tanpa persiapan. Nada tujuan belum benar-benar “didengar”, tetapi suara sudah terlanjur bergerak. \r\n\r\nSaat perpindahan dilakukan terlalu cepat, suara cenderung melewati atau mendekati nada tujuan tanpa benar-benar mendarat dengan tepat. Di sinilah fals paling sering muncul, bukan saat menahan nada, tetapi saat berpindah.',2),
(134,29,'Contoh Perpindahan Nada yang Halus','https://youtu.be/FEPqLOHBoGc?si=lltbwjlEoo08J5x5','Video ini memperlihatkan perbedaan antara perpindahan nada yang terburu-buru dan perpindahan nada yang lebih tenang dan terarah. Nada akhirnya bisa sama, tetapi proses menuju nada tersebut terdengar sangat berbeda.',3),
(135,29,'Kesimpulan: Nada Perlu Dituju, Bukan Dikejar ','','Perpindahan nada yang baik tidak terasa dipaksa. Suara bergerak dengan arah yang jelas, bukan dengan usaha mengejar nada setinggi atau serendah mungkin. \r\n\r\nKetika arah nada sudah terbentuk dengan tenang, perpindahan terasa lebih ringan dan alami. Di titik ini, pitch, intonasi, dan alur nada mulai menyatu, menandai penutup Materi 3 sebelum masuk ke pembahasan yang lebih ekspresif. ',4),
(136,27,'Kenapa Telinga Sering “Salah Dengar”? ','','Banyak orang merasa sudah bernyanyi sesuai nada, padahal yang didengar oleh telinga belum tentu sama dengan yang keluar dari suara. Hal ini terjadi karena telinga belum terbiasa mengenali perbedaan kecil antar nada. \r\n\r\nBab ini membantu peserta memahami bahwa ketidakakuratan nada sering kali berasal dari persepsi pendengaran, bukan dari kemampuan suara. Dengan kata lain, yang perlu dilatih pertama kali adalah telinga, bukan tenggorokan. ',1),
(137,27,'Hubungan Telinga dan Suara ','','Telinga dan suara bekerja sebagai satu sistem. Telinga memberi perintah, suara mengeksekusi. Jika perintahnya kurang jelas, hasilnya pun meleset. \r\n\r\nDi bab ini, peserta diajak memahami pentingnya mendengarkan nada acuan dengan penuh fokus sebelum mencoba menirukannya. Semakin jelas nada di kepala, semakin mudah suara mengikutinya. ',2),
(138,27,'Mendengar Sebelum Menyanyi ','','Kesalahan umum saat bernyanyi adalah langsung bersuara tanpa benar-benar “mendengar” nada terlebih dahulu. Padahal, proses mendengar adalah kunci utama ketepatan pitch. \r\n\r\nBab ini menanamkan kebiasaan untuk memberi jeda sejenak: dengar, pahami, baru keluarkan suara. Kebiasaan kecil ini sangat berpengaruh pada akurasi nada. ',3),
(139,27,'Contoh Latihan Mendengar Pitch ','https://youtu.be/C1Wx9-O82qc?si=hTtnsMPqIFKeVxbC','Video ini memperagakan latihan sederhana untuk melatih kepekaan telinga terhadap pitch, tanpa alat musik rumit. ',4),
(140,27,'Kesimpulan: Nada Datang dari Telinga ','','Nada yang akurat bukan dimulai dari suara, tetapi dari telinga. Semakin terlatih telinga mendengar dengan benar, semakin otomatis suara mengikuti arah yang tepat. \r\n\r\nDengan menyelesaikan course ini, peserta memiliki fondasi pendengaran yang lebih kuat untuk mengontrol pitch dan intonasi di course berikutnya. ',5);

/*Table structure for table `tb_user` */

DROP TABLE IF EXISTS `tb_user`;

CREATE TABLE `tb_user` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `username` varchar(75) DEFAULT NULL,
  `passwd` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `role` enum('Admin','Mentor','Student') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `foto` text,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `tb_user` */

insert  into `tb_user`(`id_user`,`name`,`username`,`passwd`,`email`,`role`,`foto`,`created_at`) values 
(1,'John Doe','doejohn123','$2y$10$lC6duQTI6nxuLv3MfKG58Oxa.QxgdaH3tFXeT5A7UaT0B5FRh54iu','johndoe@gmail.com','Admin',NULL,'2025-12-19 02:34:23'),
(2,'Neil Sims','neilsims','$2y$10$lC6duQTI6nxuLv3MfKG58Oxa.QxgdaH3tFXeT5A7UaT0B5FRh54iu','neil.sims@flowbite.com','Mentor','https://flowbite.com/docs/images/people/profile-picture-1.jpg','2025-12-23 17:38:10'),
(4,'Jese Leos','jeseleos','$2y$10$lC6duQTI6nxuLv3MfKG58Oxa.QxgdaH3tFXeT5A7UaT0B5FRh54iu','jese@flowbite.com','Student','https://flowbite.com/docs/images/people/profile-picture-2.jpg','2025-12-23 17:38:10'),
(5,'Thomas Lean','thomasl','$2y$10$lC6duQTI6nxuLv3MfKG58Oxa.QxgdaH3tFXeT5A7UaT0B5FRh54iu','thames@flowbite.com','Student','https://flowbite.com/docs/images/people/profile-picture-5.jpg','2025-12-23 17:38:10'),
(6,'Leslie Livingston','leslie','$2y$10$lC6duQTI6nxuLv3MfKG58Oxa.QxgdaH3tFXeT5A7UaT0B5FRh54iu','leslie@flowbite.com','Student','https://flowbite.com/docs/images/people/profile-picture-4.jpg','2025-12-23 17:38:10'),
(7,'Roberta Casas','robertac','$2y$10$lC6duQTI6nxuLv3MfKG58Oxa.QxgdaH3tFXeT5A7UaT0B5FRh54iu','roberta@flowbite.com','Student','https://flowbite.com/docs/images/people/profile-picture-1.jpg','2025-12-23 17:38:10'),
(8,'Michael Gough','michaelg','$2y$10$lC6duQTI6nxuLv3MfKG58Oxa.QxgdaH3tFXeT5A7UaT0B5FRh54iu','michael@flowbite.com','Student','https://flowbite.com/docs/images/people/profile-picture-3.jpg','2025-12-23 17:38:10'),
(9,'Helene Engels','helene','$2y$10$lC6duQTI6nxuLv3MfKG58Oxa.QxgdaH3tFXeT5A7UaT0B5FRh54iu','helene@flowbite.com','Student','https://flowbite.com/docs/images/people/profile-picture-2.jpg','2025-12-23 17:38:10'),
(10,'Lana Byrd','lanabyrd','$2y$10$lC6duQTI6nxuLv3MfKG58Oxa.QxgdaH3tFXeT5A7UaT0B5FRh54iu','lana@flowbite.com','Student','https://flowbite.com/docs/images/people/profile-picture-5.jpg','2025-12-23 17:38:10'),
(11,'Karen Nelson','karenn','$2y$10$lC6duQTI6nxuLv3MfKG58Oxa.QxgdaH3tFXeT5A7UaT0B5FRh54iu','karen@flowbite.com','Student','https://flowbite.com/docs/images/people/profile-picture-4.jpg','2025-12-23 17:38:10'),
(12,'Joseph McFall','josephm','$2y$10$lC6duQTI6nxuLv3MfKG58Oxa.QxgdaH3tFXeT5A7UaT0B5FRh54iu','joseph@flowbite.com','Student','https://flowbite.com/docs/images/people/profile-picture-1.jpg','2025-12-23 17:38:10'),
(13,'Robert Brown','robertb','$2y$10$lC6duQTI6nxuLv3MfKG58Oxa.QxgdaH3tFXeT5A7UaT0B5FRh54iu','robert.brown@example.com','Mentor','https://flowbite.com/docs/images/people/profile-picture-3.jpg','2025-12-23 17:38:10'),
(14,'Emily Davis','emilyd','$2y$10$lC6duQTI6nxuLv3MfKG58Oxa.QxgdaH3tFXeT5A7UaT0B5FRh54iu','emily.davis@example.com','Mentor','https://flowbite.com/docs/images/people/profile-picture-2.jpg','2025-12-23 17:38:10'),
(15,'Daniel Warchester','warchesterd','$2y$10$lC6duQTI6nxuLv3MfKG58Oxa.QxgdaH3tFXeT5A7UaT0B5FRh54iu','warchester.dan@example.com','Admin','dist/img/20251227-172948USER-e5dc6904-49d5-4b48-bf2d-0b12706a0c7f.jpeg','2025-12-23 17:38:10');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
