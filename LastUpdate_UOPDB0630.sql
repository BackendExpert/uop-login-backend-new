-- MySQL dump 10.13  Distrib 8.0.40, for Win64 (x86_64)
--
-- Host: localhost    Database: uop_db
-- ------------------------------------------------------
-- Server version	8.0.40

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cirtificate`
--

DROP TABLE IF EXISTS `cirtificate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cirtificate` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `image` varchar(150) NOT NULL,
  `link` varchar(100) NOT NULL,
  `is_active` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cirtificate`
--

LOCK TABLES `cirtificate` WRITE;
/*!40000 ALTER TABLE `cirtificate` DISABLE KEYS */;
INSERT INTO `cirtificate` VALUES (1,'Certificate in Photography','Certificate in Photography Description about Photography','uploads/pexels-gya-den-768256-2386141.jpg','https://www.google.com/',1),(2,'Certificate in Science','Certificate in Science Description','uploads/wp9503102-tragic-wallpapers.jpg','https://www.google.com/',1),(3,'Certificate in Science 2','Certificate in Science 2Certificate in Science 2Certificate in Science 2Certificate in Science 2Certificate in Science 2Certificate in Science 2Certificate in Science 2Certificate in Science 2','uploads/wp9503102-tragic-wallpapers.jpg','https://www.google.com/',1),(4,'Certificate in IT','Certificate in ITCertificate in ITCertificate in ITCertificate in ITCertificate in ITCertificate in IT','uploads/Hdr8.jpg','https://www.google.com/',0);
/*!40000 ALTER TABLE `cirtificate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `diploma`
--

DROP TABLE IF EXISTS `diploma`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `diploma` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `description` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `link` varchar(150) NOT NULL,
  `is_active` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `diploma`
--

LOCK TABLES `diploma` WRITE;
/*!40000 ALTER TABLE `diploma` DISABLE KEYS */;
INSERT INTO `diploma` VALUES (1,'Diploma in IT','Diploma in IT Description','uploads/pexels-gya-den-768256-2386141.jpg','https://www.google.com/',0),(2,'Diploma Computer Science','Diploma Computer Science Description','uploads/wp9503102-tragic-wallpapers.jpg','https://www.google.com/',0),(3,'dip in CS','','uploads/wp9503102-tragic-wallpapers.png','https://www.google.com/',1);
/*!40000 ALTER TABLE `diploma` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `events` (
  `event_id` int NOT NULL AUTO_INCREMENT,
  `event_title` varchar(255) NOT NULL,
  `event_date` date NOT NULL,
  `envet_desc` varchar(1000) NOT NULL,
  `event_link` varchar(255) NOT NULL,
  `event_img` varchar(255) NOT NULL,
  `is_accepted` int NOT NULL,
  `add_by` varchar(45) NOT NULL,
  PRIMARY KEY (`event_id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `events`
--

LOCK TABLES `events` WRITE;
/*!40000 ALTER TABLE `events` DISABLE KEYS */;
INSERT INTO `events` VALUES (35,'Postgraduate Programmes','2025-06-27','Postgraduate ProgrammesPostgraduate ProgrammesPostgraduate ProgrammesPostgraduate Programmes','https://www.google.com/','uploads/174814375556442446.jpg',1,'dvcnew@123.com'),(36,'New Event 2 asd asd asdasd','2025-06-21','New Event 2 asd asd asdasdNew Event 2 asd asd asdasd','https://www.google.com/','uploads/CiscoMarch-2025-web-735x1024.jpg',0,'dvcnew@123.com');
/*!40000 ALTER TABLE `events` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `faq`
--

DROP TABLE IF EXISTS `faq`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `faq` (
  `id` int NOT NULL AUTO_INCREMENT,
  `question` varchar(500) NOT NULL,
  `answer` varchar(1500) NOT NULL,
  `link` varchar(150) NOT NULL,
  `category` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=124 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `faq`
--

LOCK TABLES `faq` WRITE;
/*!40000 ALTER TABLE `faq` DISABLE KEYS */;
INSERT INTO `faq` VALUES (1,'What is the color of banana','Yellow','https://www.google.com/',''),(3,'why important of sri lanka ','Sri Lanka is important due to its strategic geographic location, rich cultural heritage, and economic potential, particularly in tourism and trade. Its central position in the Indian Ocean makes it a vital waterway hub and a crossroads for maritime trade. The country\'s diverse landscapes, ancient history, and vibrant culture attract tourists and contribute to its economic growth. ','https://www.google.com/',''),(4,'How do I apply for undergraduate courses?','You can apply through the UGC application portal: https://ugc.ac.lk','https://www.google.com','Admissions'),(5,'Where can I find research highlights for 2024?','Visit: https://www.pdn.ac.lk/research for the latest updates.','https://www.google.com','Research'),(6,'What is the admission process for international students?','International applicants should contact the International Relations Office (InRO) at least three months before the semester starts. Required documents include academic transcripts, passport copies, and a statement of purpose.','https://www.google.com','Admissions'),(7,'What faculties does the university have?','The university has the following faculties: Agriculture, Allied Health Sciences, Arts, Dental Sciences, Engineering, Management, Medicine, Science, and Veterinary Medicine and Animal Science.','https://www.google.com','General Information'),(8,'Who is the Vice-Chancellor of the university?','As of August 1, 2024, Professor W.M.T. Madhujith is the 23rd Vice-Chancellor of the University of Peradeniya.','https://www.google.com','General Information'),(9,'How can I contact the university?','Contact details are available on the official website: https://www.pdn.ac.lk.','https://www.google.com','General Information'),(10,'What is the official website of the university?','The official website is: https://www.pdn.ac.lk.','https://www.google.com','General Information'),(11,'How long does it take to complete an undergraduate program?','Undergraduate program durations vary by faculty: Engineering (4 years), Medicine (5 years), Dental Sciences (5 years), Arts and Science (3 to 4 years).','https://www.google.com','Admissions'),(12,'Does the university offer international programs?','Yes, the university offers various international programs and has an International Relations Office to facilitate global collaborations.','https://www.google.com','General Information'),(13,'Are there any part-time or external degree options?','Yes, the Centre for Distance and Continuing Education (CDCE) offers external degree programs, including the Bachelor of Business Administration (BBA) online degree program.','https://www.google.com','Admissions'),(14,'How do I get updates on admission deadlines?','Admission deadlines and updates are posted on the university\'s official website and the International Relations Office page.','https://www.google.com','Admissions'),(15,'What postgraduate programs are available?','The university offers various postgraduate programs through its faculties and institutes, including:\n\n- Postgraduate Institute of Science (PGIS): M.Sc., M.Phil., Ph.D., diplomas, and certificates. [sci.pdn.ac.lk](https://sci.pdn.ac.lk)\n- Faculty of Arts: Postgraduate Diploma, Master of Arts, M.Phil., Ph.D. [Faculty of Arts](https://arts.pdn.ac.lk)\n- Faculty of Engineering: PG Diploma, M.Sc.Eng., M.Phil., Ph.D.\n- Faculty of Management: PGDM, PGDAF, MBA, M.Acc.&Fin., M.Sc. [mgt.pdn.ac.lk](https://mgt.pdn.ac.lk)','https://www.google.com','Postgraduate Studies'),(16,'How to apply for a Master\'s program?','Application procedures vary by faculty. Generally, applicants must download the application form from the respective institute\'s website, complete it, and submit it along with required documents and a processing fee. [pgis.pdn.ac.lk](https://pgis.pdn.ac.lk)','https://www.google.com','Postgraduate Studies'),(17,'What are the fees for postgraduate programs?','Fees differ based on the program and faculty. For instance, PGIS programs have specific fees listed in their announcements. [pgis.pdn.ac.lk](https://pgis.pdn.ac.lk)','https://www.google.com','Postgraduate Studies'),(18,'Are research degrees offered?','Yes, research degrees such as M.Phil. and Ph.D. are available across various faculties and institutes. [sci.pdn.ac.lk](https://sci.pdn.ac.lk)','https://www.google.com','Postgraduate Studies'),(19,'What is the Institute of Postgraduate Studies?','The university has two main postgraduate institutes:\n- Postgraduate Institute of Science (PGIS) [pgis.pdn.ac.lk](https://pgis.pdn.ac.lk)\n- Postgraduate Institute of Agriculture (PGIA) [pgia.pdn.ac.lk](https://pgia.pdn.ac.lk)','https://www.google.com','Postgraduate Studies'),(20,'Is there a list of available supervisors?','Prospective research students should consult the respective faculty or institute to identify available supervisors in their field of interest.','https://www.google.com','Postgraduate Studies'),(21,'Can international students apply for postgraduate courses?','Yes, international students are welcome to apply. The International Relations Office provides guidance and support throughout the application process.','https://www.google.com','Postgraduate Studies'),(22,'Is there financial aid for postgraduates?','Scholarships and financial aid opportunities are available for eligible postgraduate students. Details can be found on the International Relations Office\'s scholarships page.','https://www.google.com','Postgraduate Studies'),(23,'How do I register for postgraduate programs?','After acceptance, students must complete the registration process as outlined by the respective faculty or institute, which includes submitting necessary documents and paying fees.','https://www.google.com','Postgraduate Studies'),(24,'Is there an online application portal for PG studies?','While applications are typically submitted via downloadable forms, some faculties may offer online submission options. Applicants should refer to the specific faculty\'s website for details.','https://www.google.com','Postgraduate Studies'),(25,'What certificate programs are available?','The Centre for Distance and Continuing Education (CDCE) offers certificate programs such as:\n\n- Advanced Certificate in Laboratory Handling\n- Certificate Course in Basic Tamil\n\nFor more details, visit the CDCE Certificate Programs page: [cdce.pdn.ac.lk/certificate.php](https://cdce.pdn.ac.lk/certificate.php)','https://www.google.com','Certificates & Diplomas'),(26,'Does the university offer online certificate courses?','Yes, CDCE provides online learning platforms for certain certificate courses. For specific offerings and access, refer to the CDCE website: [cdce.pdn.ac.lk](https://cdce.pdn.ac.lk)','https://www.google.com','Certificates & Diplomas'),(27,'How to apply for a diploma?','Applications for diploma programs can be submitted through the CDCE. Detailed application procedures are available on their website: [cdce.pdn.ac.lk/diploma2.php](https://cdce.pdn.ac.lk/diploma2.php)','https://www.google.com','Certificates & Diplomas'),(28,'What is the duration of certificate courses?','The duration varies by program. For instance, the Diploma in Management and Development spans 18 months. Specific durations for certificate courses can be found on the respective program pages.','https://www.google.com','Certificates & Diplomas'),(29,'Are there English language programs?','While the CDCE offers various programs, for English language courses, it\'s advisable to check directly with the CDCE or the Faculty of Arts for current offerings.','https://www.google.com','Certificates & Diplomas'),(30,'What is the fee structure for these programs?','Fees differ based on the program. For detailed fee structures, consult the specific program pages on the CDCE website.','https://www.google.com','Certificates & Diplomas'),(31,'Can I apply as a working professional?','Yes, many programs are designed to accommodate working professionals, offering flexible schedules.','https://www.google.com','Certificates & Diplomas'),(32,'Do these programs have evening classes?','Some programs may offer evening classes to suit working individuals. Details are available on the respective program pages.','https://www.google.com','Certificates & Diplomas'),(33,'Are these UGC-approved?','Programs offered through the University of Peradeniya, including those by the CDCE, are recognized by the University Grants Commission (UGC) of Sri Lanka.','https://www.google.com','Certificates & Diplomas'),(34,'How to find the list of currently open certificate courses?','The CDCE website regularly updates available courses. Visit [cdce.pdn.ac.lk](https://cdce.pdn.ac.lk) and navigate to the Certificate Programs section for the latest offerings.','https://www.google.com','Certificates & Diplomas'),(35,'How to find academic staff details?','Each faculty provides a directory of academic staff on their respective websites. For example, the Faculty of Science lists its staff here: [sci.pdn.ac.lk/academic-staff.php](https://sci.pdn.ac.lk/academic-staff.php)','https://www.google.com','Staff & Administration'),(36,'Where can I find email addresses of lecturers?','Email addresses are typically listed alongside staff profiles on faculty websites. For instance, the Faculty of Management provides contact details here: [mgt.pdn.ac.lk/staff/contact_accadamic.php](https://mgt.pdn.ac.lk/staff/contact_accadamic.php)','https://www.google.com','Staff & Administration'),(37,'Who is the Dean of each faculty?','Deans\' information is available on individual faculty websites. For the most accurate and current details, refer to the specific faculty\'s official page.','https://www.google.com','Staff & Administration'),(38,'How to reach the registrar?','The Registrar\'s Office can be contacted at:\n\n- Phone: +94 81 2387395\n- Email: registrar@pdn.ac.lk','https://www.google.com','Staff & Administration'),(39,'What is the structure of the university council?','Details about the University Council\'s structure can be found on the official university website or by contacting the administrative offices directly.','https://www.google.com','Staff & Administration'),(40,'Are there staff development programs?','The university offers various staff development initiatives. For specifics, it\'s best to consult the Human Resources Division or the respective faculty\'s administration. [pgia.pdn.ac.lk](https://pgia.pdn.ac.lk)','https://www.google.com','Staff & Administration'),(41,'Can I apply for a staff position?','Yes, job vacancies are posted on the university\'s official website. Regularly check [pdn.ac.lk](https://pdn.ac.lk) for updates.','https://www.google.com','Staff & Administration'),(42,'Where are job vacancies posted?','Vacancies are listed under the \'Vacancies\' section on the university\'s main website: [pdn.ac.lk](https://pdn.ac.lk)','https://www.google.com','Staff & Administration'),(43,'How to contact the administrative divisions?','Contact details for various administrative divisions are available in the university\'s telephone directory: [site.pdn.ac.lk/directory.php](https://site.pdn.ac.lk/directory.php)','https://www.google.com','Staff & Administration'),(44,'Where is the HR office located?','The Human Resources Division is situated within the university\'s administrative complex. For exact location and contact details, refer to the university\'s directory: [site.pdn.ac.lk/directory.php](https://site.pdn.ac.lk/directory.php)','https://www.google.com','Staff & Administration'),(45,'What are the university’s research centers?','The University of Peradeniya hosts several interdisciplinary research centers, including:\n\n- Postgraduate Institute of Agriculture (PGIA)\n- Centre for Research in Oral Cancer (CROC)\n- Postgraduate Institute of Science (PGIS)\n- Engineering Design Centre (EDC)\n- Agricultural Biotechnology Centre\n- Centre for Environmental Sustainability\n- Centre for Research and Development in Humanities and Social Sciences (CRDHSS)\n\nVisit: [www.pdn.ac.lk/research](https://www.pdn.ac.lk/research)','https://www.google.com','Research & Institutes'),(46,'What is the PGIA?','The Postgraduate Institute of Agriculture (PGIA) is an institute affiliated with the University of Peradeniya offering:\n- M.Sc., M.Phil., and Ph.D. programs in agriculture-related fields.\n- Collaborative research and training.\n\nWebsite: [pgia.ac.lk](https://pgia.ac.lk)','https://www.google.com','Research & Institutes'),(47,'Are there funding opportunities for research?','Yes, the university offers various funding schemes:\n- Research Grants from UGC and National Science Foundation (NSF)\n- Faculty-level research funding\n- Postgraduate scholarships via PGIA and PGIS\n- International funding bodies (e.g., DAAD, Erasmus+, JICA)\n\nContact your faculty or visit [research.pdn.ac.lk](https://research.pdn.ac.lk) for calls and guidelines.','https://www.google.com','Research & Institutes'),(48,'How to join a research project?','• Contact a research supervisor or faculty member.\n• Enroll in a postgraduate program (PGIS or PGIA).\n• Check faculty websites and project listings for available openings.\n• Volunteer or apply for Research Assistant positions.','https://www.google.com','Research & Institutes'),(49,'What is the research publication repository?','The university maintains a Digital Research Repository for theses, dissertations, and academic publications.\n\nRepository Access: [dlib.pdn.ac.lk](https://dlib.pdn.ac.lk)','https://www.google.com','Research & Institutes'),(50,'How to find research supervisors?','• Visit faculty websites (e.g., [sci.pdn.ac.lk](https://sci.pdn.ac.lk)) to explore staff profiles.\n• PGIA and PGIS list available supervisors by research area.\n• Contact them directly via email.','https://www.google.com','Research & Institutes'),(51,'Can undergraduate students join research labs?','Yes, many departments encourage:\n- Final-year research projects\n- Volunteering in labs\n- Internships or part-time assistantships\n\nTalk to your department head or course coordinator.','https://www.google.com','Research & Institutes'),(52,'What is the UGC-approved journal list?','The University Grants Commission (UGC) of Sri Lanka provides a list of accredited journals accepted for academic evaluations.\n\nCheck: [ugc.ac.lk](https://ugc.ac.lk)','https://www.google.com','Research & Institutes'),(53,'Where can I access university research reports?','• Annual reports are available on the University Research Council or each faculty\'s research division.\n• PGIS and PGIA publish conference proceedings and research highlights.\n\nPGIS Research: [pgis.pdn.ac.lk](https://pgis.pdn.ac.lk)\nPGIA Reports: [pgia.ac.lk](https://pgia.ac.lk)','https://www.google.com','Research & Institutes'),(54,'How to collaborate with the university in research?','• Submit a collaboration proposal via the Research Council or the relevant Faculty Dean.\n• Joint research, training, or industry-funded projects are welcome.\n• International MOU processes are facilitated by the International Relations Office.\n\nInternational Office: [int.pdn.ac.lk](https://int.pdn.ac.lk)\nContact Research Council: [research.pdn.ac.lk/contact](https://research.pdn.ac.lk/contact)','https://www.google.com','Research & Institutes'),(55,'What is the Student Union?','The Student Union serves as the representative body for the student community, advocating for student rights and organizing academic, cultural, and social activities. Each faculty also has its own student union to address faculty-specific matters.','https://www.google.com','Research & Institutes'),(56,'What student societies are available?','The university encourages student engagement through various societies and clubs, such as:\n- Faculty of Science Societies: Robotics Society, Photographic Society, Rotaract Club, and more.\n- Faculty of Arts Societies: Commerce Society, History Society, Economics Society, English Literary Association, etc.\n- Faculty of Allied Health Sciences Societies: Buddhist Association, Faculty Students\' Union, AHS Welfare Association, Pharmaceutical Society, and others.','https://www.google.com','Research & Institutes'),(57,'What sports facilities are provided?','The Department of Physical Education provides a wide range of sports facilities, including:\n- Outdoor Facilities: Cricket ground, soccer/rugby/football pitch, hockey pitch, tennis courts.\n- Indoor Facilities: Gymnasium for various sports.\n- Swimming Pool: A 50-meter swimming pool donated by the Ministry of Sports.','https://www.google.com','Research & Institutes'),(58,'What medical services are available?','The University Health Centre offers comprehensive healthcare services, including:\n- Curative Services: General medical consultations and treatments.\n- Preventive Healthcare: Health education and disease prevention programs.\n- Laboratory Services: Diagnostic testing facilities.\n- 24-Hour Ambulance Service: Emergency medical transportation available around the clock.','https://www.google.com','Research & Institutes'),(59,'What is the canteen system like?','The university provides canteen facilities across the campus, offering meals at subsidized rates. Each faculty and hostel typically has its own canteen or dining area. For more details, refer to the respective faculty or hostel administration.','https://www.google.com','Research & Institutes'),(60,'What are the hostel facilities?','• Accommodation Capacity: The university maintains 23 hostels accommodating approximately 8,600 undergraduate students.\n• Gender-Specific Hostels: 14 for male students, 9 for female students.\n• Allocation Criteria: Based on distance from the student’s residence, priority is given to those living farther away.\n• Application Process: Apply through the university\'s accommodation portal.','https://www.google.com','Research & Institutes'),(61,'What is the campus security like?','The university prioritizes the safety and well-being of its students through a dedicated security team that monitors the campus to ensure a safe environment.','https://www.google.com','Campus Safety'),(62,'What health services are available?','The University Health Centre provides medical assistance and emergency services for students.','https://www.google.com','Campus Safety'),(63,'What counseling services are offered?','The Counseling and Psychological Support Unit (CaPSU) offers mental health support to students, including:\n- Professional Counseling: Sessions with qualified mental health professionals.\n- Walk-In Services: Available during designated hours for immediate support.\n- Emergency Contact: Students can reach out via the dedicated phone line: 070 1 343 444.','https://www.google.com','Campus Safety'),(64,'What is the Learning Management System (LMS)?','The University utilizes Moodle-based LMS platforms for various faculties. For instance, the Faculty of Science uses SCILMS, and the Faculty of Allied Health Sciences uses FAHS Moodle.','https://www.google.com','IT & Digital Services'),(65,'How to reset LMS passwords?','Password reset procedures may vary by faculty. For general university services, you can reset your password via the SSO Login Portal.','https://www.google.com','IT & Digital Services'),(66,'What is the University’s Wi-Fi policy?','Students must register on the University Portal to access the \'UoP-WiFi\' network. Detailed guidelines are available on the NCSU Wi-Fi Page.','https://www.google.com','IT & Digital Services'),(67,'How to access the digital library?','The university\'s digital library, including e-resources, can be accessed through the Library Network.','https://www.google.com','IT & Digital Services'),(68,'What online portals are available for students?','• Student Information System: [stud.pdn.ac.lk](https://stud.pdn.ac.lk)\n• Faculty of Arts IMS: [learner.arts.pdn.ac.lk](https://learner.arts.pdn.ac.lk), [stud.pdn.ac.lk](https://stud.pdn.ac.lk), [learner.arts.pdn.ac.lk](https://learner.arts.pdn.ac.lk)','https://www.google.com','IT & Digital Services'),(69,'How to access exam results online?','For CDCE exams, visit [cdce.pdn.ac.lk/results1.php](https://cdce.pdn.ac.lk/results1.php). For Faculty of Arts, results are available at [arts.pdn.ac.lk/services/results.php](https://arts.pdn.ac.lk/services/results.php).','https://www.google.com','IT & Digital Services'),(70,'Where can I find the official university email login?','Access your university email via the SSO Login Portal: [auth.pdn.ac.lk](https://auth.pdn.ac.lk)','https://www.google.com','IT & Digital Services'),(71,'What is the UoP VPN service?','The university provides VPN services for departmental access. Instructions are available at [Connect to Department VPN](https://www.pdn.ac.lk).','https://www.google.com','IT & Digital Services'),(72,'Is there an online feedback system?','Students can submit feedback and complaints through the Student Services Page.','https://www.google.com','IT & Digital Services'),(73,'Can alumni access IT services?','Alumni can stay connected through the Alumni Relations Office, though access to specific IT services may vary. Visit [aro.pdn.ac.lk](https://aro.pdn.ac.lk) for more information.','https://www.google.com','IT & Digital Services'),(74,'What are the tuition fees?','Tuition fees vary by program. For postgraduate programs, refer to the PGIA Fee Structure: [pgia.pdn.ac.lk](https://pgia.pdn.ac.lk).','https://www.google.com','Finance & Fees'),(75,'Are there any registration fees?','Yes, registration fees apply. For example, the Faculty of Science charges a registration fee as detailed in their notice: [sci.pdn.ac.lk](https://sci.pdn.ac.lk).','https://www.google.com','Finance & Fees'),(76,'How can I pay my fees?','Fees can be paid online via the UOP Payment Gateway or through bank deposits using paying-in vouchers: [fin.pdn.ac.lk](https://fin.pdn.ac.lk).','https://www.google.com','Finance & Fees'),(77,'Are there payment plans available?','Payment plans may be available for certain programs. It\'s advisable to consult the respective faculty or the Finance Division for details.','https://www.google.com','Finance & Fees'),(78,'Where is the Finance Division located?','The Finance Division is situated within the university premises. Contact details are available on the Finance Division Page: [fin.pdn.ac.lk](https://fin.pdn.ac.lk).','https://www.google.com','Finance & Fees'),(79,'Can I pay online?','Yes, online payments can be made through the UOP Payment Gateway.','https://www.google.com','Finance & Fees'),(80,'What are the refund policies?','Refund policies are subject to university regulations. For specific cases, contact the Finance Division.','https://www.google.com','Finance & Fees'),(81,'How to apply for scholarships?','Scholarship information is typically provided by individual faculties. For instance, the Faculty of Engineering details scholarships on their website.','https://www.google.com','Finance & Fees'),(82,'Are financial aid options available?','Yes, various financial aid options are available. Students should consult their respective faculties or the Student Services Page for more information.','https://www.google.com','Finance & Fees'),(83,'Are hostel fees separate?','Yes, hostel fees are separate from tuition and other fees. Details can be obtained from the Student Accommodation Page.','https://www.google.com','Finance & Fees'),(84,'Does the university accept foreign students?','Yes, the University of Peradeniya accepts international students for both undergraduate and postgraduate programs. Applicants must possess qualifications equivalent to the Sri Lankan G.C.E. Advanced Level examination. Detailed information is available in the Foreign Admissions Flyer.','https://www.google.com','International Student Admissions'),(85,'How to get a student visa?','To obtain a student visa:\n1. Receive an acceptance letter from the University.\n2. Submit required documents, including a police clearance report, passport bio page, and acceptance letter, to the International Relations Office (InRO).\n3. InRO will facilitate the visa approval process with the Department of Immigration.\n4. Upon approval, apply for the visa at the Sri Lankan mission in your country.\nComprehensive guidelines are provided on the InRO Visa Information Page.','https://www.google.com','International Student Admissions'),(86,'What are the English proficiency requirements?','Applicants should have:\n- A minimum of an \'S\' grade in English at the G.C.E. O-Level examination or an equivalent qualification.\nSpecific programs may have additional requirements; it\'s advisable to consult the relevant faculty for detailed criteria.','https://www.google.com','International Student Admissions'),(87,'Can I apply online from abroad?','Yes, international applicants can apply online. The application process and necessary forms are accessible through the International Relations Office website.','https://www.google.com','International Student Admissions'),(88,'Are there international student societies?','Yes, the university hosts several societies catering to international students, including:\n- Students\' International Interaction Club\n- International Students\' Forum (ISF)\nThese societies provide platforms for cultural exchange and community building.','https://www.google.com','International Student Support'),(89,'Is there an International Affairs Office?','Yes, the International Relations Office (InRO) manages international collaborations and supports international students. More information can be found on the InRO website.','https://www.google.com','International Student Support'),(90,'What support is offered to international students?','InRO offers various services, including:\n- Assistance with visa processing and renewals.\n- Orientation programs for new students.\n- Guidance on accommodation and campus facilities.\n- Support for academic and cultural integration.','https://www.google.com','International Student Support'),(91,'Are exchange programs available?','Yes, the university participates in several exchange programs, such as:\n- Erasmus+\n- International Credit Mobility Programmes\n- Intercollegiate Sri Lanka Education (ISLE) Program\nThese programs facilitate student exchanges with partner institutions worldwide.','https://www.google.com','Academic Mobility & Recognition'),(92,'How can I convert foreign transcripts?','Applicants must provide certified copies of their academic transcripts. The university evaluates these documents to determine equivalency with Sri Lankan qualifications. For detailed procedures, refer to the Foreign Admissions Flyer.','https://www.google.com','Academic Mobility & Recognition'),(93,'Are foreign degrees recognized?','Yes, foreign degrees are recognized, provided they meet the university\'s equivalency standards. The University Grants Commission (UGC) of Sri Lanka oversees the recognition process. Applicants should ensure their qualifications align with the university\'s admission requirements.','https://www.google.com','Academic Mobility & Recognition'),(94,'How can I contact the International Relations Office?','For personalized assistance, you can contact the International Relations Office at:\n- Phone: +94 81 239 2000\n- Email: [Contact email address]','https://www.google.com','Academic Mobility & Recognition'),(95,'How to register for the library?','You may need to register with your student ID, either online or in person at the library.','https://www.google.com','Library & Academic Resources'),(96,'What are the library opening hours?','Most university libraries are open during weekdays, with extended hours during exam periods.','https://www.google.com','Library & Academic Resources'),(97,'How many books can I borrow?','Students usually can borrow multiple books for a specific duration, often a few weeks.','https://www.google.com','Library & Academic Resources'),(98,'Does the library provide eBooks/e-Journals?','Yes, many university libraries provide access to digital resources, including eBooks and online journals.','https://www.google.com','Library & Academic Resources'),(99,'How to search the library catalog?','The university likely has an online catalog for searching books, journals, and other academic resources.','https://www.google.com','Library & Academic Resources'),(100,'Are there study spaces in the library?','Yes, the library often has designated quiet areas or group study rooms.','https://www.google.com','Library & Academic Resources'),(101,'How to request a book purchase?','If a book is not available, libraries usually have a process for requesting new books.','https://www.google.com','Library & Academic Resources'),(102,'Can alumni access library services?','Alumni can sometimes access certain library services, often on a limited basis.','https://www.google.com','Library & Academic Resources'),(103,'Are there printing services in the library?','Yes, printing services are often available at the library, sometimes requiring a print card or payment.','https://www.google.com','Library & Academic Resources'),(104,'Where are university news and events posted?','University news and events are typically posted on the official university website or the student portal. They might also be available via social media channels, email newsletters, or physical bulletin boards.','https://www.google.com','Events & Announcements'),(105,'How to register for university events?','Event registration is usually handled through the university\'s online system, such as the student portal, event-specific websites, or direct links provided by event organizers. In some cases, physical registration might also be available.','https://www.google.com','Events & Announcements'),(106,'Are convocations held annually?','Most universities hold convocations or graduation ceremonies annually. Specific dates and details are typically provided well in advance on the official website or through student communications.','https://www.google.com','Events & Announcements'),(107,'How to watch convocation live?','Convocations are often streamed online through the university’s official YouTube channel, Facebook page, or a dedicated livestream link provided by the university’s media or IT departments.','https://www.google.com','Events & Announcements'),(108,'Where to find recent circulars?','Circulars are usually available on the university\'s official website or through the student portal. They can also be posted on notice boards around campus or distributed through email.','https://www.google.com','Events & Announcements'),(109,'Are faculty-specific events posted separately?','Faculty-specific events are typically posted on their respective department or faculty websites. Some universities also have separate mailing lists or social media groups for faculty events.','https://www.google.com','Events & Announcements'),(110,'Where to find student notices?','Student notices are commonly posted on the university’s online student portal, bulletin boards, or sent via email. Some universities also have apps for student communications.','https://www.google.com','Events & Announcements'),(111,'How to submit an event for publication?','Event submission processes vary but often involve submitting event details via an online form on the university website or sending the event information directly to the student affairs or communications office.','https://www.google.com','Events & Announcements'),(112,'Is there a university newsletter?','Many universities have newsletters for students and staff that are sent out regularly via email or available on their websites. You can usually subscribe to them through the university\'s communication section.','https://www.google.com','Events & Announcements'),(113,'Can parents attend university events?','Most universities allow parents to attend certain events like convocations, open houses, and special lectures. However, attendance at other events may be restricted to students or faculty.','https://www.google.com','Events & Announcements'),(114,'What is the University of Peradeniya Alumni Association?','The University of Peradeniya Alumni Association is an organization that connects graduates of the university. It provides a platform for alumni to network, stay updated on university news, participate in events, and support current students and university initiatives.','https://www.google.com','Alumni & Outreach'),(115,'How can I register as an alumnus?','You can typically register as an alumnus through the university\'s Alumni Association website or by filling out a registration form. Contacting the Alumni Relations Office directly for guidance on the process is also an option.','https://www.google.com','Alumni & Outreach'),(116,'Are there alumni scholarships?','Some universities offer scholarships or financial assistance to alumni for further studies, research, or educational development. You would need to inquire with the Alumni Relations Office or check the university’s alumni portal for any available opportunities.','https://www.google.com','Alumni & Outreach'),(117,'Can alumni use university facilities?','Many universities allow alumni to use certain facilities, like the library, gym, or event spaces, though sometimes these services may be limited or require membership. Contact the Alumni Relations Office for specifics regarding access to facilities at Peradeniya.','https://www.google.com','Alumni & Outreach'),(118,'Are alumni events held annually?','Alumni events, such as reunions or networking gatherings, are often held annually. These events are a great way for alumni to stay connected with each other and the university. Details about these events are usually shared through alumni newsletters or the official website.','https://www.google.com','Alumni & Outreach'),(119,'How to donate to the university?','Donations to the university can typically be made through their official website, where you may find options for online donations or endowment funds. Alternatively, the Alumni Relations Office can provide guidance on how to donate.','https://www.google.com','Alumni & Outreach'),(121,'How to contact the Alumni Relations Office?','You can contact the Alumni Relations Office through email, phone, or their office on campus. The university website usually provides contact details for this office.','https://www.google.com','Alumni & Outreach'),(122,'Is there an alumni email service?','Many universities provide alumni with an official email service or forwarding address. This is often managed through the Alumni Relations Office or the university’s IT department. Check the alumni website for specific information on email services for alumni.','https://www.google.com','Alumni & Outreach'),(123,'Can alumni mentor current students?','Many universities have mentoring programs that allow alumni to volunteer as mentors for current students. This is often facilitated through the Alumni Relations Office or student support services. Contact them to learn how you can participate in mentoring opportunities.','https://www.google.com','Alumni & Outreach');
/*!40000 ALTER TABLE `faq` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `home_slider_img`
--

DROP TABLE IF EXISTS `home_slider_img`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `home_slider_img` (
  `id` int NOT NULL AUTO_INCREMENT,
  `img` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `imgdesc` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `home_slider_img`
--

LOCK TABLES `home_slider_img` WRITE;
/*!40000 ALTER TABLE `home_slider_img` DISABLE KEYS */;
INSERT INTO `home_slider_img` VALUES (5,'uploads/Hdr2.jpg','Join Us','Be a part of our journey towards greatness.','https://www.google.com/'),(6,'uploads/Hdr3.jpg','Become a Leader','We are shaping the leaders of tomorrow.','https://www.google.com/'),(7,'uploads/Hdr4.jpg','Student Life','A journey of academic achievements and innovation.','https://www.google.com/'),(8,'uploads/Hdr5.jpg','Legacy of Excellence','A journey of academic achievements and innovation.','https://www.google.com/'),(9,'uploads/Hdr6.jpg','Most Beautiful University in Sri Lanka','Beauty of University of Peradeniya','https://www.google.com/'),(15,'uploads/Hdr7.jpg','Not Only Education','Mindfulness isn\'t difficult','https://www.google.com/'),(16,'uploads/Hdr1.jpg','Welcome to uop','Welcome to university of Peradeniya','https://www.google.com/');
/*!40000 ALTER TABLE `home_slider_img` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `news`
--

DROP TABLE IF EXISTS `news`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `news` (
  `id` int NOT NULL AUTO_INCREMENT,
  `news_title` varchar(255) NOT NULL,
  `news_desc` varchar(1000) NOT NULL,
  `news_link` varchar(1000) NOT NULL,
  `news_img` varchar(100) NOT NULL,
  `news_date` date NOT NULL,
  `is_active` int NOT NULL,
  `addby` varchar(45) NOT NULL,
  `img2` varchar(100) NOT NULL,
  `img3` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `news`
--

LOCK TABLES `news` WRITE;
/*!40000 ALTER TABLE `news` DISABLE KEYS */;
INSERT INTO `news` VALUES (28,'New News of month of March Middle','New News of month of March MiddleNew News of month of March MiddleNew News of month of March MiddleNew News of month of March MiddleNew News of month of March Middle','https://www.google.com/','uploads/CiscoMarch-2025-web-735x1024.jpg','2025-06-27',1,'dvcnew@123.com','uploads/CiscoMarch-2025-web-735x1024.jpg','uploads/Vice-Chancellors-Lecture-Series-7_May-2025.jpg'),(29,'New NEWS for all','New NEWS for allNew NEWS for allNew NEWS for allNew NEWS for allNew NEWS for all','https://www.google.com/','uploads/CiscoMarch-2025-web-735x1024.jpg','2025-07-04',0,'dvcnew@123.com','uploads/DELT CONFERENCE FLYER (1).jpg','uploads/pngwing.com (8).png');
/*!40000 ALTER TABLE `news` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notice`
--

DROP TABLE IF EXISTS `notice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notice` (
  `notice_id` int NOT NULL AUTO_INCREMENT,
  `notice_title` varchar(255) NOT NULL,
  `notice_link` varchar(1000) NOT NULL,
  `notice_desc` varchar(1000) NOT NULL,
  `notice_date` date NOT NULL,
  `is_accepted` int NOT NULL,
  `addby` varchar(45) NOT NULL,
  PRIMARY KEY (`notice_id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notice`
--

LOCK TABLES `notice` WRITE;
/*!40000 ALTER TABLE `notice` DISABLE KEYS */;
INSERT INTO `notice` VALUES (27,'Postgraduate Research Fellowships -2025','https://www.pdn.ac.lk/invitation-for-bids-for-providing-canteen-services-2025-lalith-athulathmudali-canteen/','Postgraduate Research Fellowships -2025Postgraduate Research Fellowships -2025Postgraduate Research Fellowships -2025Postgraduate Research Fellowships -2025Postgraduate ','2025-06-27',1,'dvcnew@123.com'),(28,'Notice for every university Students for April','https://www.google.com/','Notice for every university Students for AprilNotice for every university Students for AprilNotice for every university Students for April','2025-06-28',0,'dvcnew@123.com');
/*!40000 ALTER TABLE `notice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `opt_tbl`
--

DROP TABLE IF EXISTS `opt_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `opt_tbl` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `otp` varchar(120) NOT NULL,
  `gettime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `opt_tbl`
--

LOCK TABLES `opt_tbl` WRITE;
/*!40000 ALTER TABLE `opt_tbl` DISABLE KEYS */;
INSERT INTO `opt_tbl` VALUES (8,'dvcnew@123.com','$2y$10$XaPXv5.9dDWBk3EdAi5uv..5l0Nlo76YToGNMFJVXrKGJnZFz2x6m','2025-05-26 07:30:23');
/*!40000 ALTER TABLE `opt_tbl` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `program_slider`
--

DROP TABLE IF EXISTS `program_slider`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `program_slider` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(45) NOT NULL,
  `pdesc` varchar(1000) NOT NULL,
  `img` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `addby` varchar(45) NOT NULL,
  `is_accepted` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `program_slider`
--

LOCK TABLES `program_slider` WRITE;
/*!40000 ALTER TABLE `program_slider` DISABLE KEYS */;
INSERT INTO `program_slider` VALUES (1,'CCNA','The CCNA—which stands for Cisco Certified Network Associate—is an entry-level information technology (IT) certification from networking hardware company Cisco','uploads/482080646_1046139057550490_363341665058339028_n.jpg','https://www.google.com/','',1),(3,'Enhancing Science ','Enhancing science can involve improving scientific literacy, fostering scientific inquiry, and promoting scientific rigor across various disciplines, ultimately leading to a more knowledgeable and scientifically informed society. ','uploads/L2.jpg','https://www.google.com/','',0),(4,'Postgraduate Programmes','The Postgraduate Institute of Science (PGIS) is considered to be the Postgraduate arm of the Faculty of Science. PGIS is a National Institute attached to the University of Peradeniya, Sri Lanka. ','uploads/L3.jpg','https://www.google.com/','',0),(5,'Important Notice','Applications for Postgraduate Diploma','uploads/L4.jpg','https://www.google.com/','',0),(6,'Diploma in Photography','Diploma in Photography','uploads/L5.jpg','https://www.google.com/','',0),(9,'Engineering Postgraduate Programmes','Engineering Postgraduate Programme','uploads/462287211_2471460793059498_4365790166913377060_n.jpg','https://www.google.com/','',0),(11,'Workshop on Empowering Data-Driven Decisions','Empowering data-driven decisions means making strategic choices based on data analysis and interpretation,','uploads/psss1.jpg','https://www.google.com/','',0),(12,'Diploma in Computer and Electronics','Electronic device is an overarching term that refers to a hardware whose function is to control the flow of electrical energy for the purpose of processing information or controlling a system.','uploads/pssss2.jpg','https://www.google.com/','',0),(13,'PImage CS','PImage CSPImage CSPImage CSPImage CSPImage CSPImage CSPImage CSPImage CSPImage CSPImage CSPImage CSPImage CS','uploads/pexels-gya-den-768256-2386141.jpg','https://www.google.com/','csmember@pdn.ac.lk',0);
/*!40000 ALTER TABLE `program_slider` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `publications`
--

DROP TABLE IF EXISTS `publications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `publications` (
  `id` int NOT NULL AUTO_INCREMENT,
  `pub_name` varchar(500) NOT NULL,
  `desc` varchar(500) DEFAULT NULL,
  `year` varchar(45) NOT NULL,
  `file` varchar(450) NOT NULL,
  `upload_at` datetime NOT NULL,
  `pub_type` varchar(500) NOT NULL,
  `coverimge` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `publications`
--

LOCK TABLES `publications` WRITE;
/*!40000 ALTER TABLE `publications` DISABLE KEYS */;
INSERT INTO `publications` VALUES (8,'New Pub 2022','New Pub 2022New Pub 2022New Pub 2022New Pub 2022','2024','uploads/1751217608_Jehan Weerasuriya - coverletter- CEO.pdf','2025-06-29 19:20:08','Journals','uploads/1751217608_cover_imgtest.PNG');
/*!40000 ALTER TABLE `publications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `research`
--

DROP TABLE IF EXISTS `research`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `research` (
  `research_id` int NOT NULL AUTO_INCREMENT,
  `res_titile` varchar(255) NOT NULL,
  `res_desc` varchar(1000) NOT NULL,
  `res_img` varchar(255) NOT NULL,
  `res_link` varchar(255) NOT NULL,
  `res_faculty` varchar(255) NOT NULL,
  `is_accepted` int NOT NULL,
  `addby` varchar(45) NOT NULL,
  PRIMARY KEY (`research_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `research`
--

LOCK TABLES `research` WRITE;
/*!40000 ALTER TABLE `research` DISABLE KEYS */;
INSERT INTO `research` VALUES (3,'Sustainable Smart Cities','Research on using IoT, AI, and renewable energy to design eco-friendly and efficient urban spaces.','uploads/Research2.jpg','https://www.google.com/','Faculty of Engineering',1,''),(4,'Next-Gen Battery Technology','Developing high-capacity, fast-charging, and long-lasting battery solutions for electric vehicles and smart devices.','uploads/Research1.jpg','https://www.google.com/','Faculty of Engineering',1,''),(5,'Artificial Photosynthesis for Clean Energy','Exploring how plants convert sunlight into energy and applying it to create sustainable fuel sources.','uploads/wp7534295.jpg','https://www.google.com/','Faculty of Science',0,''),(6,'Microplastic Pollution and Its Impact ','Investigating the presence of microplastics in water sources and their long-term effects on human health.','uploads/wp7534295.jpg','https://www.google.com/','Faculty of Science',0,''),(7,'AI in Disease Diagnosis ','Researching how artificial intelligence can assist doctors in early detection of diseases like cancer and Alzheimer’s.','uploads/wp7534312.jpg','https://www.google.com/','Faculty of Medicine & Health Sciences',0,''),(8,'Mental Health in University Students','Studying stress, anxiety, and coping mechanisms among students to develop better campus wellness programs.','uploads/wp7534312.jpg','https://www.google.com/','Faculty of Medicine & Health Sciences',0,''),(9,'Quantum Computing Applications',' Exploring how quantum computing can revolutionize problem-solving in cryptography, AI, and simulations.','uploads/wp2015494.jpg','https://www.google.com/','Faculty of Information Technology & Computer Science',1,''),(10,'Cybersecurity in Smart Devices ','Researching vulnerabilities in IoT devices and developing new protocols to prevent hacking threats.','uploads/wp2015494.jpg','https://www.google.com/','Faculty of Information Technology & Computer Science',0,''),(11,'The Impact of Cryptocurrency on Global Markets ','Analyzing how Bitcoin, Ethereum, and digital assets influence financial stability.','uploads/wp3396930.jpg','https://www.google.com/','Faculty of Business & Economics',0,''),(12,'AI in Customer Service','Studying how AI-powered chatbots and virtual assistants are changing consumer interactions and business efficiency.','uploads/wp3396930.jpg','https://www.google.com/','Faculty of Business & Economics',0,''),(13,'Climate Change and Coastal Erosion','Investigating how rising sea levels affect coastal cities and proposing mitigation strategies.','uploads/wp7534295.jpg','https://www.google.com/','Faculty of Environmental Science',0,''),(15,'New Reseach CS','New Reseach CSNew Reseach CSNew Reseach CSNew Reseach CSNew Reseach CS','uploads/pexels-gya-den-768256-2386141.jpg','https://www.google.com/','Faculty of Science',0,'csmember@pdn.ac.lk');
/*!40000 ALTER TABLE `research` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `research_heightlight`
--

DROP TABLE IF EXISTS `research_heightlight`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `research_heightlight` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ResearchJournals` varchar(100) DEFAULT NULL,
  `ResearchPublications` varchar(100) DEFAULT NULL,
  `Citations` varchar(100) DEFAULT NULL,
  `ResearchRanking` varchar(100) DEFAULT NULL,
  `no_researchers` varchar(100) DEFAULT NULL,
  `AnnualResearchConferences` varchar(100) DEFAULT NULL,
  `AnnualResearchCollaborations` varchar(100) DEFAULT NULL,
  `ResearchAwardsRecognitions` varchar(100) DEFAULT NULL,
  `AnnualWorkshops` varchar(100) DEFAULT NULL,
  `CapitalgrantsResearch` varchar(100) DEFAULT NULL,
  `year` varchar(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `research_heightlight`
--

LOCK TABLES `research_heightlight` WRITE;
/*!40000 ALTER TABLE `research_heightlight` DISABLE KEYS */;
/*!40000 ALTER TABLE `research_heightlight` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `research_stats`
--

DROP TABLE IF EXISTS `research_stats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `research_stats` (
  `id` int NOT NULL AUTO_INCREMENT,
  `year` year NOT NULL,
  `research_journals` int DEFAULT NULL,
  `research_publications` int DEFAULT NULL,
  `citations` int DEFAULT NULL,
  `research_ranking` int DEFAULT NULL,
  `number_of_researchers_top2_percent` int DEFAULT NULL,
  `annual_research_conferences` int DEFAULT NULL,
  `annual_research_collaborations` int DEFAULT NULL,
  `research_awards_and_recognitions` int DEFAULT NULL,
  `annual_workshops_seminars` int DEFAULT NULL,
  `capital_grants_for_research` decimal(15,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `research_stats`
--

LOCK TABLES `research_stats` WRITE;
/*!40000 ALTER TABLE `research_stats` DISABLE KEYS */;
INSERT INTO `research_stats` VALUES (1,2024,5,4,5,88,5,8,8,8,84,4.00),(2,2023,3,55,4,2,4,3,2,3,6,2.00),(3,2022,2,1,5,1,9,3,8,5,7,6.00);
/*!40000 ALTER TABLE `research_stats` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `servicequicklink`
--

DROP TABLE IF EXISTS `servicequicklink`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `servicequicklink` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `link` varchar(100) NOT NULL,
  `main_type` varchar(100) NOT NULL,
  `services_type` varchar(100) DEFAULT NULL,
  `is_active` int DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `servicequicklink`
--

LOCK TABLES `servicequicklink` WRITE;
/*!40000 ALTER TABLE `servicequicklink` DISABLE KEYS */;
INSERT INTO `servicequicklink` VALUES (1,'Reseaches','https://www.google.co.uk/','',NULL,0),(3,'new Serivice for Student','https://www.google.com/','Services','StudentServices',0),(4,'new quick link 1','https://www.google.com/','QuickLinks','',1),(5,'new service','https://www.google.com/','Services','PublicServices',1),(6,'new service 2','https://www.google.com/','Services','StaffServices',1);
/*!40000 ALTER TABLE `servicequicklink` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `societies`
--

DROP TABLE IF EXISTS `societies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `societies` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `image` varchar(150) NOT NULL,
  `link` varchar(150) NOT NULL,
  `faculty` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `societies`
--

LOCK TABLES `societies` WRITE;
/*!40000 ALTER TABLE `societies` DISABLE KEYS */;
INSERT INTO `societies` VALUES (4,'Faculty of Agriculture Society 1','uploads/DELT CONFERENCE FLYER (1).jpg','https://www.google.com','Faculty of Agriculture'),(5,'Faculty of Agriculture Society 2','uploads/DELT CONFERENCE FLYER (1).jpg','https://www.google.com','Faculty of Agriculture'),(6,'Faculty of Allied Health Sciences Society 1','uploads/DELT CONFERENCE FLYER (1).jpg','https://www.google.com','Faculty of Allied Health Sciences'),(7,'Faculty of Allied Health Sciences Society 2','uploads/DELT CONFERENCE FLYER (1).jpg','https://www.google.com','Faculty of Allied Health Sciences'),(8,'Faculty of Arts Society 1','uploads/DELT CONFERENCE FLYER (1).jpg','https://www.google.com','Faculty of Arts'),(9,'Faculty of Arts Society 2','uploads/DELT CONFERENCE FLYER (1).jpg','https://www.google.com','Faculty of Arts'),(10,'Faculty of Dental Sciences Society 1','uploads/DELT CONFERENCE FLYER (1).jpg','https://www.google.com','Faculty of Dental Sciences'),(11,'Faculty of Dental Sciences Society 2','uploads/DELT CONFERENCE FLYER (1).jpg','https://www.google.com','Faculty of Dental Sciences'),(12,'Faculty of Engineering Society 1','uploads/DELT CONFERENCE FLYER (1).jpg','https://www.google.com','Faculty of Engineering'),(13,'Faculty of Engineering Society 2','uploads/DELT CONFERENCE FLYER (1).jpg','https://www.google.com','Faculty of Engineering'),(14,'Faculty of Medicine Society 1','uploads/DELT CONFERENCE FLYER (1).jpg','https://www.google.com','Faculty of Medicine'),(15,'Faculty of Medicine Society 2','uploads/DELT CONFERENCE FLYER (1).jpg','https://www.google.com','Faculty of Medicine'),(16,'Faculty of Science Society 1','uploads/DELT CONFERENCE FLYER (1).jpg','https://www.google.com','Faculty of Science'),(17,'Faculty of Science Society 2','uploads/DELT CONFERENCE FLYER (1).jpg','https://www.google.com','Faculty of Science'),(18,'Faculty of Veterinary Medicine and Animal Science Society 1','uploads/DELT CONFERENCE FLYER (1).jpg','https://www.google.com','Faculty of Veterinary Medicine and Animal Science'),(19,'Faculty of Veterinary Medicine and Animal Science Society 2','uploads/DELT CONFERENCE FLYER (1).jpg','https://www.google.com','Faculty of Veterinary Medicine and Animal Science'),(20,'Faculty of Management Society 1','uploads/DELT CONFERENCE FLYER (1).jpg','https://www.google.com','Faculty of Management'),(21,'Faculty of Management Society 2','uploads/DELT CONFERENCE FLYER (1).jpg','https://www.google.com','Faculty of Management');
/*!40000 ALTER TABLE `societies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `statistics`
--

DROP TABLE IF EXISTS `statistics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `statistics` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(45) NOT NULL,
  `countData` varchar(45) NOT NULL,
  `visibale` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `statistics`
--

LOCK TABLES `statistics` WRITE;
/*!40000 ALTER TABLE `statistics` DISABLE KEYS */;
INSERT INTO `statistics` VALUES (2,'Staff','500',1);
/*!40000 ALTER TABLE `statistics` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `password` varchar(150) NOT NULL,
  `is_active` int NOT NULL DEFAULT '0',
  `role` varchar(45) NOT NULL DEFAULT 'user',
  `Faculty` varchar(100) NOT NULL,
  `isEmailVerfy` int DEFAULT '0',
  PRIMARY KEY (`id`,`email`,`username`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (11,'admin','admin@gmail.com','$2y$10$Fx4hEqBbmefEwhUuW/xEyOeY/ra.UkxkuG8zH9I0MBh84xlyOFjMO',1,'admin','',1),(12,'dvc','dvc@gmail.com','$2y$10$JBqbism/fFEw8zyVgYD.uufG4pATvTwH.TcXhMtg.Gy9RE2/G9fDm',1,'dvc','',1),(16,'csmember','csmember@pdn.ac.lk','$2y$10$Id2/0d.aoBhuw4cOgqCAEuOcUekVnDTkZXiFaWxth4kO.c04V6kdG',1,'user','Department of Computer Science',1),(21,'jkandy','jkandymusic@gmail.com','$2y$10$ml/abBAK4eGZFuRyE6qFOeeBZhzi0XZj.dGSF0cSlN31S5eUMGpIq',0,'user','Admin',1),(22,'newdvc','dvcnew@123.com','$2y$10$EVxC4yHDhYzB6SZRE9X8YOypCFNxbtLt9G5a4x41aqMkBeAxc5DB6',1,'dvc','Admin',1);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vacancies`
--

DROP TABLE IF EXISTS `vacancies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vacancies` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `notice` varchar(255) NOT NULL,
  `application` varchar(255) NOT NULL,
  `closingdate` datetime NOT NULL,
  `desc` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vacancies`
--

LOCK TABLES `vacancies` WRITE;
/*!40000 ALTER TABLE `vacancies` DISABLE KEYS */;
INSERT INTO `vacancies` VALUES (1,'Computer Programmer','Apply for Computer Programmer','uploads/JEHAN WEERASURIYA DEC Update CV.pdf','2025-05-30 00:00:00',''),(2,'NEw Vacancy ','','uploads/Jehan Weerasuriya FEB 2025 (1).pdf','2025-06-26 00:00:00',''),(3,'ok Vacancy ','uploads/JEHAN WEERASURIYA DEC Update CV.pdf','uploads/Jehan Weerasuriya FEB 2025 (1).pdf','2025-06-27 00:00:00',''),(4,'New Vacancy','uploads/JEHAN WEERASURIYA DEC Update CV.pdf','uploads/Profile.pdf','2025-07-04 00:00:00',''),(5,'Vacancy Title','1749536776_dash new.PNG','1749536776_JEHAN WEERASURIYA DEC Update CV.pdf','2025-06-24 00:00:00','Description\r\n'),(6,'New final Test all ok','1749537621_ssssssssssssssssssssssssssssssssssssssssssssssssssssssssss.PNG','1749537621_aplicationnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnn.pdf','2025-07-03 00:00:00','New final Test all okNew final Test all okNew final Test all okNew final Test all okNew final Test all okNew final Test all okNew final Test all okNew final Test all okNew final Test all okNew final Test all okNew final Test all okNew final Test all okNew final Test all okNew final Test all okNew final Test all ok'),(7,'Last ok new job','ssssssssssssssssssssssssssssssssssssssssssssssssssssssssss.PNG','aplicationnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnn.pdf','2025-06-25 00:00:00','Last ok new jobLast ok new jobLast ok new jobLast ok new jobLast ok new jobLast ok new jobLast ok new jobLast ok new jobLast ok new jobLast ok new jobLast ok new jobLast ok new jobLast ok new jobLast ok new jobLast ok new jobLast ok new jobLast ok new jobLast ok new jobLast ok new jobLast ok new jobLast ok new jobLast ok new jobLast ok new jobLast ok new job'),(8,'Vacancy TitleVacancy TitleVacancy Title','ssssssssssssssssssssssssssssssssssssssssssssssssssssssssss.PNG','aplicationnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnn.pdf','2025-06-25 00:00:00','Vacancy TitleVacancy TitleVacancy TitleVacancy TitleVacancy TitleVacancy TitleVacancy TitleVacancy TitleVacancy TitleVacancy TitleVacancy TitleVacancy Title');
/*!40000 ALTER TABLE `vacancies` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-06-29 23:15:47
