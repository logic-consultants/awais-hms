DROP TABLE IF EXISTS academic_years;

CREATE TABLE `academic_years` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `session` varchar(50) NOT NULL,
  `school_id` int(11) NOT NULL,
  `year` varchar(10) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO academic_years VALUES('1','2024 - 2025','1','2024-25','2024-08-16 00:17:43','2024-08-19 22:36:45');



DROP TABLE IF EXISTS account_detail;

CREATE TABLE `account_detail` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `school_id` int(11) NOT NULL,
  `account_number` varchar(200) NOT NULL,
  `account_name` varchar(200) NOT NULL,
  `account_type` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




DROP TABLE IF EXISTS account_types;

CREATE TABLE `account_types` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `account_type` varchar(200) NOT NULL,
  `master_account` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




DROP TABLE IF EXISTS assign_subjects;

CREATE TABLE `assign_subjects` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `subject_id` int(11) NOT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `section_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE IF EXISTS assignments;

CREATE TABLE `assignments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `session_id` int(11) NOT NULL,
  `school_id` int(11) NOT NULL,
  `title` varchar(191) NOT NULL,
  `description` longtext DEFAULT NULL,
  `deadline` date NOT NULL,
  `class_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `file` varchar(191) NOT NULL,
  `file_2` varchar(191) DEFAULT NULL,
  `file_3` varchar(191) DEFAULT NULL,
  `file_4` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE IF EXISTS bank_cash_accounts;

CREATE TABLE `bank_cash_accounts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `school_id` int(11) NOT NULL,
  `account_name` varchar(50) NOT NULL,
  `opening_balance` decimal(8,2) NOT NULL,
  `note` text DEFAULT NULL,
  `create_user_id` int(11) NOT NULL,
  `update_user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `show_on_dashboard` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE IF EXISTS book_categories;

CREATE TABLE `book_categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `school_id` int(11) NOT NULL,
  `category_name` varchar(80) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE IF EXISTS book_issues;

CREATE TABLE `book_issues` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `school_id` int(11) NOT NULL,
  `library_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `note` text DEFAULT NULL,
  `issue_date` date NOT NULL,
  `due_date` date NOT NULL,
  `return_date` date DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE IF EXISTS books;

CREATE TABLE `books` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `school_id` int(11) NOT NULL,
  `name` varchar(80) NOT NULL,
  `category_id` int(11) NOT NULL,
  `author` varchar(80) NOT NULL,
  `publisher` varchar(80) NOT NULL,
  `rack_no` varchar(20) NOT NULL,
  `quantity` varchar(12) NOT NULL,
  `description` text DEFAULT NULL,
  `publish_date` date NOT NULL,
  `photo` varchar(50) NOT NULL DEFAULT 'book.png',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE IF EXISTS chart_of_accounts;

CREATE TABLE `chart_of_accounts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `school_id` int(11) NOT NULL,
  `name` varchar(191) NOT NULL,
  `type` varchar(10) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `show_on_dashboard` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE IF EXISTS class_days;

CREATE TABLE `class_days` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `day` varchar(10) NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE IF EXISTS class_routines;

CREATE TABLE `class_routines` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `school_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `day` varchar(10) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE IF EXISTS classes;

CREATE TABLE `classes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `school_id` int(11) NOT NULL,
  `class_name` varchar(191) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO classes VALUES('2','1','Basement','1','2024-08-19 21:16:10','2024-11-09 22:00:40');
INSERT INTO classes VALUES('3','1','Ground FLoor','1','2024-11-09 22:01:26','2024-11-09 22:01:26');
INSERT INTO classes VALUES('4','1','First Floor','1','2024-11-09 22:01:41','2024-11-09 22:01:41');



DROP TABLE IF EXISTS custom_fields;

CREATE TABLE `custom_fields` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `field_name` varchar(191) NOT NULL,
  `field_type` varchar(20) NOT NULL,
  `field_data` text DEFAULT NULL,
  `field_value` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE IF EXISTS departments;

CREATE TABLE `departments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `school_id` int(11) DEFAULT NULL,
  `department_name` varchar(100) DEFAULT NULL,
  `school_logo` varchar(100) DEFAULT NULL,
  `bank_name` varchar(100) DEFAULT NULL,
  `bank_account` varchar(100) DEFAULT NULL,
  `bank_logo` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO departments VALUES('1','1','JOBIAN','555896712_1614967826.png','MEEZAN','Bait-ul-Hareem Girls Hostel','1986830427_1615020138.png','2024-08-19 22:34:55','2024-08-19 22:34:55');
INSERT INTO departments VALUES('2','1','Student','1935191138_1724074572.jpeg','Meezan','Bait-ul-Hareem Girls Hostel','1346702764_1724074572.jpeg','2024-08-19 22:36:12','2024-08-19 22:36:12');



DROP TABLE IF EXISTS email_logs;

CREATE TABLE `email_logs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `school_id` int(11) NOT NULL,
  `receiver_email` varchar(191) NOT NULL,
  `subject` text NOT NULL,
  `message` longtext NOT NULL,
  `sender_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE IF EXISTS events;

CREATE TABLE `events` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `school_id` int(11) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `name` text NOT NULL,
  `details` longtext NOT NULL,
  `location` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE IF EXISTS exam_attendances;

CREATE TABLE `exam_attendances` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `school_id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `attendance` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE IF EXISTS exam_schedules;

CREATE TABLE `exam_schedules` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `school_id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `room` varchar(10) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE IF EXISTS exams;

CREATE TABLE `exams` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `school_id` int(11) NOT NULL,
  `name` varchar(191) NOT NULL,
  `note` text DEFAULT NULL,
  `session_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE IF EXISTS fee_types;

CREATE TABLE `fee_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `school_id` int(11) NOT NULL,
  `fee_type` varchar(50) NOT NULL,
  `fee_code` varchar(20) NOT NULL,
  `note` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO fee_types VALUES('1','1','Monthly Rent','MR01','','2024-08-24 22:01:05','2024-08-24 22:01:05');
INSERT INTO fee_types VALUES('2','1','Security Fee','SF001','','2024-08-24 22:01:34','2024-08-24 22:01:34');
INSERT INTO fee_types VALUES('3','1','Admission Fee','AF001','','2024-08-24 22:02:02','2024-08-24 22:02:02');
INSERT INTO fee_types VALUES('4','1','Ac Charges','ac001','','2024-08-24 22:03:15','2024-08-24 22:03:15');
INSERT INTO fee_types VALUES('5','1','Fine/Deduction','FD001','','2024-08-24 22:03:46','2024-08-24 22:03:46');
INSERT INTO fee_types VALUES('6','1','Security Fee','4532','Security fee','2025-01-13 13:09:52','2025-01-13 13:09:52');



DROP TABLE IF EXISTS grades;

CREATE TABLE `grades` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `school_id` int(11) NOT NULL,
  `grade_name` varchar(20) NOT NULL,
  `marks_from` decimal(8,2) NOT NULL,
  `marks_to` decimal(8,2) NOT NULL,
  `point` decimal(8,2) NOT NULL,
  `note` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE IF EXISTS hostel_categories;

CREATE TABLE `hostel_categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `school_id` int(11) NOT NULL,
  `hostel_id` int(11) NOT NULL,
  `standard` varchar(20) NOT NULL,
  `hostel_fee` decimal(8,2) NOT NULL,
  `note` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE IF EXISTS hostel_members;

CREATE TABLE `hostel_members` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `school_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `hostel_id` int(11) NOT NULL,
  `hostel_category_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE IF EXISTS hostels;

CREATE TABLE `hostels` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `school_id` int(11) NOT NULL DEFAULT 0,
  `hostel_name` varchar(80) NOT NULL,
  `type` varchar(20) NOT NULL,
  `address` longtext NOT NULL,
  `note` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE IF EXISTS invoice_items;

CREATE TABLE `invoice_items` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `school_id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `fee_id` int(11) NOT NULL,
  `amount` decimal(8,2) NOT NULL,
  `discount` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE IF EXISTS invoices;

CREATE TABLE `invoices` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `school_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL,
  `due_date` date NOT NULL,
  `payment_date` datetime DEFAULT NULL,
  `receipt_no` varchar(50) DEFAULT NULL,
  `title` varchar(191) NOT NULL,
  `description` text DEFAULT NULL,
  `total` decimal(8,2) NOT NULL,
  `paid` decimal(8,2) DEFAULT NULL,
  `status` varchar(10) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE IF EXISTS library_members;

CREATE TABLE `library_members` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `school_id` int(11) NOT NULL,
  `library_id` int(11) NOT NULL,
  `member_type` varchar(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE IF EXISTS mark_details;

CREATE TABLE `mark_details` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `school_id` int(11) NOT NULL,
  `mark_id` int(11) NOT NULL,
  `mark_type` varchar(50) NOT NULL,
  `mark_value` decimal(8,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE IF EXISTS mark_distributions;

CREATE TABLE `mark_distributions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `school_id` int(11) NOT NULL,
  `mark_distribution_type` varchar(50) NOT NULL,
  `mark_percentage` decimal(8,2) NOT NULL,
  `is_exam` varchar(3) NOT NULL DEFAULT 'no',
  `is_active` varchar(3) NOT NULL DEFAULT 'yes',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE IF EXISTS marks;

CREATE TABLE `marks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `school_id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE IF EXISTS master_account_level;

CREATE TABLE `master_account_level` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `master_account` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO master_account_level VALUES('1','Assets','2025-02-05 13:25:40','2025-02-12 18:22:30');
INSERT INTO master_account_level VALUES('2','Liabilities','2025-02-05 13:43:26','2025-02-05 13:43:26');
INSERT INTO master_account_level VALUES('3','Expenses','2025-02-05 13:43:57','2025-02-05 13:43:57');
INSERT INTO master_account_level VALUES('4','Income','2025-02-05 13:44:08','2025-02-05 13:44:08');



DROP TABLE IF EXISTS messages;

CREATE TABLE `messages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `school_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `subject` varchar(191) NOT NULL,
  `body` longtext NOT NULL,
  `sender_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE IF EXISTS migrations;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE IF EXISTS notices;

CREATE TABLE `notices` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `school_id` int(11) NOT NULL,
  `heading` text NOT NULL,
  `content` longtext NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE IF EXISTS packages;

CREATE TABLE `packages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(80) NOT NULL,
  `max_user` int(11) DEFAULT 0,
  `price` double DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE IF EXISTS page_contents;

CREATE TABLE `page_contents` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `page_id` int(11) NOT NULL,
  `page_title` text NOT NULL,
  `page_content` longtext DEFAULT NULL,
  `meta_data` longtext DEFAULT NULL,
  `seo_meta_keywords` text DEFAULT NULL,
  `seo_meta_description` text DEFAULT NULL,
  `language` varchar(191) NOT NULL DEFAULT 'english',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE IF EXISTS pages;

CREATE TABLE `pages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(191) NOT NULL,
  `page_status` varchar(20) NOT NULL,
  `page_template` varchar(191) NOT NULL DEFAULT 'default',
  `featured_image` varchar(191) DEFAULT NULL,
  `author_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE IF EXISTS parents;

CREATE TABLE `parents` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `school_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `parent_name` varchar(60) NOT NULL,
  `f_name` varchar(191) NOT NULL,
  `m_name` varchar(191) NOT NULL,
  `f_profession` varchar(191) DEFAULT NULL,
  `m_profession` varchar(191) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO parents VALUES('1','1','907','Test Entery','Default','Default','Default','1111100090901119','10921092019','Noone','2025-02-16 17:20:10','2025-02-16 17:20:10');



DROP TABLE IF EXISTS password_resets;

CREATE TABLE `password_resets` (
  `email` varchar(191) NOT NULL,
  `token` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE IF EXISTS payee_payers;

CREATE TABLE `payee_payers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `school_id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `type` varchar(8) NOT NULL,
  `note` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE IF EXISTS payment_methods;

CREATE TABLE `payment_methods` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `school_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO payment_methods VALUES('1','BANK','1','2021-06-17 01:43:59','2021-06-17 01:43:59');
INSERT INTO payment_methods VALUES('4','CASH','1','2021-06-17 01:49:06','2021-06-17 01:49:06');



DROP TABLE IF EXISTS permission_roles;

CREATE TABLE `permission_roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `school_id` int(11) NOT NULL,
  `role_name` varchar(191) NOT NULL,
  `note` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO permission_roles VALUES('1','1','Accountant','','2020-01-04 15:04:31','2020-01-05 14:53:21');
INSERT INTO permission_roles VALUES('2','1','admin 2','','2020-04-11 13:50:52','2020-04-11 13:50:52');
INSERT INTO permission_roles VALUES('3','1','Super Admin','','2020-04-11 14:14:21','2020-04-11 14:14:21');
INSERT INTO permission_roles VALUES('5','1','Testing','','2020-04-11 15:20:39','2020-04-11 15:20:39');
INSERT INTO permission_roles VALUES('6','1','students','','2021-03-07 09:09:23','2021-03-07 09:09:23');
INSERT INTO permission_roles VALUES('7','1','Manager','','2021-06-17 02:13:04','2021-06-17 02:13:04');
INSERT INTO permission_roles VALUES('8','1','Chef','','2021-06-17 02:13:17','2021-06-17 02:13:17');
INSERT INTO permission_roles VALUES('9','1','Cook','','2021-06-17 02:13:26','2021-06-17 02:13:26');
INSERT INTO permission_roles VALUES('10','1','Cook Helper','','2021-06-17 02:13:37','2021-06-17 02:13:37');
INSERT INTO permission_roles VALUES('11','1','Sweeper','','2021-06-17 02:13:48','2021-06-17 02:13:48');
INSERT INTO permission_roles VALUES('12','1','Guard','','2021-06-17 02:13:57','2021-06-17 02:13:57');
INSERT INTO permission_roles VALUES('13','1','HOUSE KEEPER','','2022-03-01 18:00:24','2022-03-01 18:00:24');
INSERT INTO permission_roles VALUES('14','1','WAITER','','2022-03-01 18:00:42','2022-03-01 18:00:42');
INSERT INTO permission_roles VALUES('15','1','SUPERVISOR','','2022-03-01 18:00:57','2022-03-01 18:00:57');
INSERT INTO permission_roles VALUES('16','1','Warden','','2024-08-19 22:40:52','2024-08-19 22:40:52');



DROP TABLE IF EXISTS permissions;

CREATE TABLE `permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `school_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `permission` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1584 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO permissions VALUES('432','1','1','invoices.index','2021-01-21 05:09:01','2021-01-21 05:09:01');
INSERT INTO permissions VALUES('431','1','1','fee_types.destroy','2021-01-21 05:09:01','2021-01-21 05:09:01');
INSERT INTO permissions VALUES('4','2','1','users.edit','2020-01-04 15:04:55','2020-01-04 15:04:55');
INSERT INTO permissions VALUES('430','1','1','fee_types.edit','2021-01-21 05:09:01','2021-01-21 05:09:01');
INSERT INTO permissions VALUES('429','1','1','fee_types.show','2021-01-21 05:09:01','2021-01-21 05:09:01');
INSERT INTO permissions VALUES('428','1','1','fee_types.create','2021-01-21 05:09:01','2021-01-21 05:09:01');
INSERT INTO permissions VALUES('427','1','1','fee_types.index','2021-01-21 05:09:01','2021-01-21 05:09:01');
INSERT INTO permissions VALUES('426','1','1','transactions.destroy','2021-01-21 05:09:01','2021-01-21 05:09:01');
INSERT INTO permissions VALUES('425','1','1','transactions.edit','2021-01-21 05:09:01','2021-01-21 05:09:01');
INSERT INTO permissions VALUES('424','1','1','transactions.show','2021-01-21 05:09:01','2021-01-21 05:09:01');
INSERT INTO permissions VALUES('423','1','1','transactions.store','2021-01-21 05:09:01','2021-01-21 05:09:01');
INSERT INTO permissions VALUES('422','1','1','transactions.add_expense','2021-01-21 05:09:01','2021-01-21 05:09:01');
INSERT INTO permissions VALUES('421','1','1','transactions.add_income','2021-01-21 05:09:01','2021-01-21 05:09:01');
INSERT INTO permissions VALUES('420','1','1','transactions.manage_expense','2021-01-21 05:09:01','2021-01-21 05:09:01');
INSERT INTO permissions VALUES('419','1','1','transactions.manage_income','2021-01-21 05:09:01','2021-01-21 05:09:01');
INSERT INTO permissions VALUES('418','1','1','payee_payers.destroy','2021-01-21 05:09:01','2021-01-21 05:09:01');
INSERT INTO permissions VALUES('417','1','1','payee_payers.edit','2021-01-21 05:09:01','2021-01-21 05:09:01');
INSERT INTO permissions VALUES('416','1','1','payee_payers.show','2021-01-21 05:09:01','2021-01-21 05:09:01');
INSERT INTO permissions VALUES('415','1','1','payee_payers.create','2021-01-21 05:09:01','2021-01-21 05:09:01');
INSERT INTO permissions VALUES('414','1','1','payee_payers.index','2021-01-21 05:09:01','2021-01-21 05:09:01');
INSERT INTO permissions VALUES('413','1','1','payment_methods.destroy','2021-01-21 05:09:01','2021-01-21 05:09:01');
INSERT INTO permissions VALUES('412','1','1','payment_methods.edit','2021-01-21 05:09:01','2021-01-21 05:09:01');
INSERT INTO permissions VALUES('411','1','1','payment_methods.show','2021-01-21 05:09:01','2021-01-21 05:09:01');
INSERT INTO permissions VALUES('410','1','1','payment_methods.create','2021-01-21 05:09:01','2021-01-21 05:09:01');
INSERT INTO permissions VALUES('409','1','1','payment_methods.index','2021-01-21 05:09:01','2021-01-21 05:09:01');
INSERT INTO permissions VALUES('408','1','1','chart_of_accounts.destroy','2021-01-21 05:09:01','2021-01-21 05:09:01');
INSERT INTO permissions VALUES('407','1','1','chart_of_accounts.edit','2021-01-21 05:09:01','2021-01-21 05:09:01');
INSERT INTO permissions VALUES('406','1','1','chart_of_accounts.show','2021-01-21 05:09:01','2021-01-21 05:09:01');
INSERT INTO permissions VALUES('405','1','1','chart_of_accounts.create','2021-01-21 05:09:01','2021-01-21 05:09:01');
INSERT INTO permissions VALUES('404','1','1','chart_of_accounts.index','2021-01-21 05:09:01','2021-01-21 05:09:01');
INSERT INTO permissions VALUES('403','1','1','accounts.destroy','2021-01-21 05:09:01','2021-01-21 05:09:01');
INSERT INTO permissions VALUES('402','1','1','accounts.edit','2021-01-21 05:09:01','2021-01-21 05:09:01');
INSERT INTO permissions VALUES('401','1','1','accounts.show','2021-01-21 05:09:01','2021-01-21 05:09:01');
INSERT INTO permissions VALUES('400','1','1','accounts.create','2021-01-21 05:09:01','2021-01-21 05:09:01');
INSERT INTO permissions VALUES('399','1','1','accounts.index','2021-01-21 05:09:01','2021-01-21 05:09:01');
INSERT INTO permissions VALUES('398','1','1','users.index','2021-01-21 05:09:01','2021-01-21 05:09:01');
INSERT INTO permissions VALUES('1459','1','2','students.create','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1458','1','2','students.promote','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1457','1','2','students.index','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1456','1','2','students.view_assign_fees','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1455','1','2','students.view_id_card','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1454','1','2','parents.destroy','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1453','1','2','parents.edit','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1452','1','2','parents.show','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1451','1','2','parents.create','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1450','1','2','parents.index','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1449','1','2','teachers.destroy','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1448','1','2','teachers.edit','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1447','1','2','teachers.show','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1348','1','3','permission_roles.destroy','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1347','1','3','permission_roles.edit','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1346','1','3','permission_roles.show','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1345','1','3','permission_roles.create','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1344','1','3','permission_roles.index','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1343','1','3','permission.manage','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1342','1','3','reports.generate_report','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1341','1','3','reports.report_area','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1340','1','3','reports.account_balance','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1339','1','3','reports.expense_report','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1338','1','3','reports.income_report','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1337','1','3','reports.exam_routine','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1336','1','3','reports.class_routine','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1335','1','3','reports.progress_card','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1334','1','3','reports.exam_report','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1333','1','3','reports.student_id_card','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1332','1','3','reports.staff_attendance_report','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1331','1','3','reports.student_attendance_report','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1330','1','3','events.destroy','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1329','1','3','events.edit','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1328','1','3','events.create','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1327','1','3','events.index','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1326','1','3','notices.destroy','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1325','1','3','notices.edit','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1324','1','3','notices.create','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1323','1','3','notices.index','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1322','1','3','email.view_logs','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1321','1','3','email.compose','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1320','1','3','sms.view_logs','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1319','1','3','sms.compose','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1318','1','3','student_payments.destroy','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1317','1','3','student_payments.edit','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1316','1','3','student_payments.show','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1315','1','3','student_payments.index','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1314','1','3','student_payments.create','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1313','1','3','student_ledger_print','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1312','1','3','student_ledger','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1311','1','3','invoices.fee_receipt_store','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1310','1','3','invoices.fee_receipt','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1309','1','3','invoices.as_assigned','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1308','1','3','invoices.destroy','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1307','1','3','invoices.edit','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1306','1','3','invoices.show','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1305','1','3','invoices.create','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1304','1','3','invoices.feeBill','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1303','1','3','invoices.index','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1302','1','3','fee_types.destroy','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1301','1','3','fee_types.edit','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1300','1','3','fee_types.show','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1299','1','3','fee_types.create','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1298','1','3','fee_types.index','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1297','1','3','transactions.destroy','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1296','1','3','transactions.edit','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1295','1','3','transactions.show','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1294','1','3','transactions.store','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1293','1','3','transactions.add_expense','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1292','1','3','transactions.add_income','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1291','1','3','transactions.manage_expense','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1290','1','3','transactions.manage_income','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1289','1','3','payee_payers.destroy','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1288','1','3','payee_payers.edit','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1287','1','3','payee_payers.show','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1286','1','3','payee_payers.create','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1285','1','3','payee_payers.index','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1284','1','3','payment_methods.destroy','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1283','1','3','payment_methods.edit','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1282','1','3','payment_methods.show','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1281','1','3','payment_methods.create','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1280','1','3','payment_methods.index','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1279','1','3','chart_of_accounts.destroy','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1278','1','3','chart_of_accounts.edit','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1277','1','3','chart_of_accounts.show','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1276','1','3','chart_of_accounts.create','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1275','1','3','chart_of_accounts.index','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1274','1','3','accounts.destroy','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1273','1','3','accounts.edit','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1272','1','3','accounts.show','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1271','1','3','accounts.create','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1270','1','3','accounts.index','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1269','1','3','marks.show','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1268','1','3','marks.index','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1267','1','3','marks.create','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1266','1','3','marks.view_student_rank','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1265','1','3','mark_distributions.destroy','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1264','1','3','mark_distributions.edit','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1263','1','3','mark_distributions.show','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1262','1','3','mark_distributions.create','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1261','1','3','mark_distributions.index','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1260','1','3','grades.destroy','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1259','1','3','grades.edit','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1258','1','3','grades.show','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1257','1','3','grades.create','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1256','1','3','grades.index','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1255','1','3','exams.destroy','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1254','1','3','exams.edit','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1253','1','3','exams.show','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1252','1','3','exams.create','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1251','1','3','exams.index','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1250','1','3','exams.store_exam_schedule','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1249','1','3','exams.store_exam_attendance','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1248','1','3','exams.view_schedule','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1247','1','3','hostelmembers.destroy','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1246','1','3','hostelmembers.edit','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1245','1','3','hostelmembers.show','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1244','1','3','hostelmembers.create','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1243','1','3','hostelmembers.index','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1242','1','3','hostelcategories.destroy','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1241','1','3','hostelcategories.edit','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1240','1','3','hostelcategories.show','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1239','1','3','hostelcategories.create','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1238','1','3','hostelcategories.index','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1237','1','3','hostels.destroy','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1236','1','3','hostels.edit','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1235','1','3','hostels.show','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1234','1','3','hostels.create','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1233','1','3','hostels.index','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1232','1','3','transportmembers.destroy','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1231','1','3','transportmembers.edit','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1230','1','3','transportmembers.show','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1229','1','3','transportmembers.create','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1228','1','3','transportmembers.index','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1227','1','3','transports.destroy','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1226','1','3','transports.edit','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1225','1','3','transports.show','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1224','1','3','transports.create','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1223','1','3','transports.index','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1222','1','3','transportvehicles.destroy','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1221','1','3','transportvehicles.edit','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1220','1','3','transportvehicles.show','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1219','1','3','transportvehicles.create','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1218','1','3','transportvehicles.index','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1217','1','3','bookcategories.destroy','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1216','1','3','bookcategories.edit','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1215','1','3','bookcategories.show','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1214','1','3','bookcategories.create','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1213','1','3','bookcategories.index','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1212','1','3','bookissues.destroy','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1211','1','3','bookissues.edit','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1210','1','3','bookissues.show','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1209','1','3','bookissues.create','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1208','1','3','bookissues.return','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1207','1','3','bookissues.index','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1206','1','3','books.destroy','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1205','1','3','books.edit','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1204','1','3','books.show','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1203','1','3','books.create','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1202','1','3','books.index','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1201','1','3','librarymembers.destroy','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1200','1','3','librarymembers.show','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1199','1','3','librarymembers.create','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1198','1','3','librarymembers.index','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1197','1','3','librarymembers.view_library_card','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1196','1','3','picklists.destroy','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1195','1','3','picklists.edit','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1194','1','3','picklists.show','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1193','1','3','picklists.create','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1192','1','3','picklists.index','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1191','1','3','languages.destroy','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1190','1','3','languages.edit','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1189','1','3','languages.create','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1188','1','3','languages.index','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1184','1','3','staff_attendance.create','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1185','1','3','general_settings.update','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1186','1','3','theme_option.update','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1187','1','3','utility.backup_database','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1446','1','2','teachers.create','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1445','1','2','teachers.index','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1444','1','2','users.destroy','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1443','1','2','users.edit','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1442','1','2','users.show','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1441','1','2','users.create','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1440','1','2','users.index','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('369','1','4','students.view_id_card','2020-04-11 15:09:41','2020-04-11 15:09:41');
INSERT INTO permissions VALUES('370','1','4','students.index','2020-04-11 15:09:41','2020-04-11 15:09:41');
INSERT INTO permissions VALUES('371','1','4','students.promote','2020-04-11 15:09:41','2020-04-11 15:09:41');
INSERT INTO permissions VALUES('372','1','4','students.create','2020-04-11 15:09:41','2020-04-11 15:09:41');
INSERT INTO permissions VALUES('373','1','4','students.show','2020-04-11 15:09:41','2020-04-11 15:09:41');
INSERT INTO permissions VALUES('374','1','4','students.edit','2020-04-11 15:09:41','2020-04-11 15:09:41');
INSERT INTO permissions VALUES('375','1','4','students.destroy','2020-04-11 15:09:41','2020-04-11 15:09:41');
INSERT INTO permissions VALUES('376','1','4','class.index','2020-04-11 15:09:41','2020-04-11 15:09:41');
INSERT INTO permissions VALUES('377','1','4','class.store','2020-04-11 15:09:41','2020-04-11 15:09:41');
INSERT INTO permissions VALUES('378','1','4','class.edit','2020-04-11 15:09:41','2020-04-11 15:09:41');
INSERT INTO permissions VALUES('379','1','4','class.destroy','2020-04-11 15:09:41','2020-04-11 15:09:41');
INSERT INTO permissions VALUES('380','1','5','transports.index','2020-04-11 15:22:50','2020-04-11 15:22:50');
INSERT INTO permissions VALUES('381','1','5','transports.create','2020-04-11 15:22:50','2020-04-11 15:22:50');
INSERT INTO permissions VALUES('382','1','5','transports.show','2020-04-11 15:22:50','2020-04-11 15:22:50');
INSERT INTO permissions VALUES('383','1','5','transports.edit','2020-04-11 15:22:50','2020-04-11 15:22:50');
INSERT INTO permissions VALUES('384','1','5','transports.destroy','2020-04-11 15:22:50','2020-04-11 15:22:50');
INSERT INTO permissions VALUES('385','1','5','transactions.manage_income','2020-04-11 15:22:50','2020-04-11 15:22:50');
INSERT INTO permissions VALUES('386','1','5','transactions.manage_expense','2020-04-11 15:22:50','2020-04-11 15:22:50');
INSERT INTO permissions VALUES('387','1','5','transactions.add_income','2020-04-11 15:22:50','2020-04-11 15:22:50');
INSERT INTO permissions VALUES('388','1','5','transactions.add_expense','2020-04-11 15:22:50','2020-04-11 15:22:50');
INSERT INTO permissions VALUES('389','1','5','transactions.store','2020-04-11 15:22:50','2020-04-11 15:22:50');
INSERT INTO permissions VALUES('390','1','5','transactions.show','2020-04-11 15:22:50','2020-04-11 15:22:50');
INSERT INTO permissions VALUES('391','1','5','transactions.edit','2020-04-11 15:22:50','2020-04-11 15:22:50');
INSERT INTO permissions VALUES('392','1','5','transactions.destroy','2020-04-11 15:22:50','2020-04-11 15:22:50');
INSERT INTO permissions VALUES('393','1','5','student_payments.create','2020-04-11 15:22:50','2020-04-11 15:22:50');
INSERT INTO permissions VALUES('394','1','5','student_payments.index','2020-04-11 15:22:50','2020-04-11 15:22:50');
INSERT INTO permissions VALUES('395','1','5','student_payments.show','2020-04-11 15:22:50','2020-04-11 15:22:50');
INSERT INTO permissions VALUES('396','1','5','student_payments.edit','2020-04-11 15:22:50','2020-04-11 15:22:50');
INSERT INTO permissions VALUES('397','1','5','student_payments.destroy','2020-04-11 15:22:50','2020-04-11 15:22:50');
INSERT INTO permissions VALUES('433','1','1','invoices.create','2021-01-21 05:09:01','2021-01-21 05:09:01');
INSERT INTO permissions VALUES('434','1','1','invoices.show','2021-01-21 05:09:01','2021-01-21 05:09:01');
INSERT INTO permissions VALUES('435','1','1','invoices.edit','2021-01-21 05:09:01','2021-01-21 05:09:01');
INSERT INTO permissions VALUES('436','1','1','student_payments.create','2021-01-21 05:09:01','2021-01-21 05:09:01');
INSERT INTO permissions VALUES('437','1','1','student_payments.index','2021-01-21 05:09:01','2021-01-21 05:09:01');
INSERT INTO permissions VALUES('438','1','1','student_payments.show','2021-01-21 05:09:01','2021-01-21 05:09:01');
INSERT INTO permissions VALUES('439','1','1','student_payments.edit','2021-01-21 05:09:01','2021-01-21 05:09:01');
INSERT INTO permissions VALUES('440','1','1','student_payments.destroy','2021-01-21 05:09:01','2021-01-21 05:09:01');
INSERT INTO permissions VALUES('1350','1','6','student_ledger','2023-04-06 10:02:55','2023-04-06 10:02:55');
INSERT INTO permissions VALUES('1349','1','6','invoices.show','2023-04-06 10:02:55','2023-04-06 10:02:55');
INSERT INTO permissions VALUES('1183','1','3','student_attendance.create','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1182','1','3','class_routines.create','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1181','1','3','class_routines.edit','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1180','1','3','class_routines.index','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1178','1','3','student_groups.edit','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1179','1','3','student_groups.destroy','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1177','1','3','student_groups.show','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1176','1','3','student_groups.create','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1175','1','3','student_groups.index','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1174','1','3','academic_years.destroy','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1173','1','3','academic_years.edit','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1171','1','3','academic_years.create','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1172','1','3','academic_years.show','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1170','1','3','academic_years.index','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1169','1','3','assignments.destroy','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1168','1','3','assignments.edit','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1167','1','3','assignments.show','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1166','1','3','assignments.create','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1165','1','3','assignments.index','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1164','1','3','syllabus.destroy','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1163','1','3','syllabus.edit','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1162','1','3','syllabus.show','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1161','1','3','syllabus.create','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1160','1','3','syllabus.index','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1159','1','3','assignsubjects.destroy','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1158','1','3','assignsubjects.edit','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1156','1','3','assignsubjects.create','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1157','1','3','assignsubjects.show','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1155','1','3','assignsubjects.index','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1154','1','3','subjects.destroy','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1153','1','3','subjects.edit','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1152','1','3','subjects.show','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1151','1','3','subjects.create','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1150','1','3','subjects.index','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1149','1','3','sections.destroy','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1148','1','3','sections.edit','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1147','1','3','sections.store','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1146','1','3','sections.index','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1145','1','3','class.destroy','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1144','1','3','class.edit','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1143','1','3','class.store','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1142','1','3','class.index','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1141','1','3','students.destroy','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1140','1','3','students.edit','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1139','1','3','students.show','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1138','1','3','students.create','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1137','1','3','students.promote','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1136','1','3','students.index','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1135','1','3','students.view_id_card','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1134','1','3','parents.destroy','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1133','1','3','parents.edit','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1132','1','3','parents.show','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1131','1','3','parents.create','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1130','1','3','parents.index','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1129','1','3','teachers.destroy','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1128','1','3','teachers.edit','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1127','1','3','teachers.show','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1126','1','3','teachers.create','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1125','1','3','teachers.index','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1124','1','3','users.destroy','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1123','1','3','users.edit','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1122','1','3','users.show','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1121','1','3','users.create','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1120','1','3','users.index','2021-04-05 22:27:30','2021-04-05 22:27:30');
INSERT INTO permissions VALUES('1351','1','6','notices.index','2023-04-06 10:02:55','2023-04-06 10:02:55');
INSERT INTO permissions VALUES('1352','1','6','notices.create','2023-04-06 10:02:55','2023-04-06 10:02:55');
INSERT INTO permissions VALUES('1353','1','7','teachers.index','2024-08-19 22:57:37','2024-08-19 22:57:37');
INSERT INTO permissions VALUES('1354','1','7','teachers.create','2024-08-19 22:57:37','2024-08-19 22:57:37');
INSERT INTO permissions VALUES('1355','1','7','parents.index','2024-08-19 22:57:37','2024-08-19 22:57:37');
INSERT INTO permissions VALUES('1356','1','7','parents.create','2024-08-19 22:57:37','2024-08-19 22:57:37');
INSERT INTO permissions VALUES('1357','1','7','parents.show','2024-08-19 22:57:37','2024-08-19 22:57:37');
INSERT INTO permissions VALUES('1358','1','7','students.view_id_card','2024-08-19 22:57:37','2024-08-19 22:57:37');
INSERT INTO permissions VALUES('1359','1','7','students.view_assign_fees','2024-08-19 22:57:37','2024-08-19 22:57:37');
INSERT INTO permissions VALUES('1360','1','7','students.index','2024-08-19 22:57:37','2024-08-19 22:57:37');
INSERT INTO permissions VALUES('1361','1','7','students.create','2024-08-19 22:57:37','2024-08-19 22:57:37');
INSERT INTO permissions VALUES('1362','1','7','students.show','2024-08-19 22:57:37','2024-08-19 22:57:37');
INSERT INTO permissions VALUES('1363','1','7','class.index','2024-08-19 22:57:37','2024-08-19 22:57:37');
INSERT INTO permissions VALUES('1364','1','7','sections.index','2024-08-19 22:57:37','2024-08-19 22:57:37');
INSERT INTO permissions VALUES('1365','1','7','subjects.index','2024-08-19 22:57:37','2024-08-19 22:57:37');
INSERT INTO permissions VALUES('1366','1','7','subjects.create','2024-08-19 22:57:37','2024-08-19 22:57:37');
INSERT INTO permissions VALUES('1367','1','7','subjects.show','2024-08-19 22:57:37','2024-08-19 22:57:37');
INSERT INTO permissions VALUES('1368','1','7','assignsubjects.index','2024-08-19 22:57:37','2024-08-19 22:57:37');
INSERT INTO permissions VALUES('1369','1','7','assignsubjects.create','2024-08-19 22:57:37','2024-08-19 22:57:37');
INSERT INTO permissions VALUES('1370','1','7','assignsubjects.show','2024-08-19 22:57:37','2024-08-19 22:57:37');
INSERT INTO permissions VALUES('1371','1','7','syllabus.index','2024-08-19 22:57:37','2024-08-19 22:57:37');
INSERT INTO permissions VALUES('1372','1','7','syllabus.create','2024-08-19 22:57:37','2024-08-19 22:57:37');
INSERT INTO permissions VALUES('1373','1','7','syllabus.show','2024-08-19 22:57:37','2024-08-19 22:57:37');
INSERT INTO permissions VALUES('1374','1','7','assignments.index','2024-08-19 22:57:37','2024-08-19 22:57:37');
INSERT INTO permissions VALUES('1375','1','7','assignments.show','2024-08-19 22:57:37','2024-08-19 22:57:37');
INSERT INTO permissions VALUES('1376','1','7','academic_years.index','2024-08-19 22:57:37','2024-08-19 22:57:37');
INSERT INTO permissions VALUES('1377','1','7','academic_years.show','2024-08-19 22:57:37','2024-08-19 22:57:37');
INSERT INTO permissions VALUES('1378','1','7','student_groups.index','2024-08-19 22:57:37','2024-08-19 22:57:37');
INSERT INTO permissions VALUES('1379','1','7','student_groups.show','2024-08-19 22:57:37','2024-08-19 22:57:37');
INSERT INTO permissions VALUES('1380','1','7','departments.index','2024-08-19 22:57:37','2024-08-19 22:57:37');
INSERT INTO permissions VALUES('1381','1','7','departments.show','2024-08-19 22:57:37','2024-08-19 22:57:37');
INSERT INTO permissions VALUES('1382','1','7','class_routines.index','2024-08-19 22:57:37','2024-08-19 22:57:37');
INSERT INTO permissions VALUES('1383','1','7','student_attendance.create','2024-08-19 22:57:37','2024-08-19 22:57:37');
INSERT INTO permissions VALUES('1384','1','7','staff_attendance.create','2024-08-19 22:57:37','2024-08-19 22:57:37');
INSERT INTO permissions VALUES('1385','1','7','general_settings.update','2024-08-19 22:57:37','2024-08-19 22:57:37');
INSERT INTO permissions VALUES('1386','1','7','languages.index','2024-08-19 22:57:37','2024-08-19 22:57:37');
INSERT INTO permissions VALUES('1387','1','7','hostels.index','2024-08-19 22:57:37','2024-08-19 22:57:37');
INSERT INTO permissions VALUES('1388','1','7','hostels.show','2024-08-19 22:57:37','2024-08-19 22:57:37');
INSERT INTO permissions VALUES('1389','1','7','hostelcategories.index','2024-08-19 22:57:37','2024-08-19 22:57:37');
INSERT INTO permissions VALUES('1390','1','7','hostelcategories.show','2024-08-19 22:57:37','2024-08-19 22:57:37');
INSERT INTO permissions VALUES('1391','1','7','accounts.index','2024-08-19 22:57:37','2024-08-19 22:57:37');
INSERT INTO permissions VALUES('1392','1','7','accounts.show','2024-08-19 22:57:37','2024-08-19 22:57:37');
INSERT INTO permissions VALUES('1393','1','7','chart_of_accounts.index','2024-08-19 22:57:37','2024-08-19 22:57:37');
INSERT INTO permissions VALUES('1394','1','7','chart_of_accounts.create','2024-08-19 22:57:37','2024-08-19 22:57:37');
INSERT INTO permissions VALUES('1395','1','7','chart_of_accounts.show','2024-08-19 22:57:37','2024-08-19 22:57:37');
INSERT INTO permissions VALUES('1396','1','7','payment_methods.index','2024-08-19 22:57:37','2024-08-19 22:57:37');
INSERT INTO permissions VALUES('1397','1','7','payment_methods.create','2024-08-19 22:57:37','2024-08-19 22:57:37');
INSERT INTO permissions VALUES('1398','1','7','payment_methods.show','2024-08-19 22:57:37','2024-08-19 22:57:37');
INSERT INTO permissions VALUES('1399','1','7','payee_payers.create','2024-08-19 22:57:37','2024-08-19 22:57:37');
INSERT INTO permissions VALUES('1400','1','7','transactions.manage_income','2024-08-19 22:57:37','2024-08-19 22:57:37');
INSERT INTO permissions VALUES('1401','1','7','transactions.manage_expense','2024-08-19 22:57:37','2024-08-19 22:57:37');
INSERT INTO permissions VALUES('1402','1','7','transactions.add_income','2024-08-19 22:57:37','2024-08-19 22:57:37');
INSERT INTO permissions VALUES('1403','1','7','transactions.add_expense','2024-08-19 22:57:37','2024-08-19 22:57:37');
INSERT INTO permissions VALUES('1404','1','7','transactions.store','2024-08-19 22:57:37','2024-08-19 22:57:37');
INSERT INTO permissions VALUES('1405','1','7','transactions.show','2024-08-19 22:57:37','2024-08-19 22:57:37');
INSERT INTO permissions VALUES('1406','1','7','fee_types.index','2024-08-19 22:57:37','2024-08-19 22:57:37');
INSERT INTO permissions VALUES('1407','1','7','fee_types.create','2024-08-19 22:57:37','2024-08-19 22:57:37');
INSERT INTO permissions VALUES('1408','1','7','fee_types.show','2024-08-19 22:57:37','2024-08-19 22:57:37');
INSERT INTO permissions VALUES('1409','1','7','invoices.index','2024-08-19 22:57:37','2024-08-19 22:57:37');
INSERT INTO permissions VALUES('1410','1','7','invoices.feeBill','2024-08-19 22:57:37','2024-08-19 22:57:37');
INSERT INTO permissions VALUES('1411','1','7','invoices.create','2024-08-19 22:57:37','2024-08-19 22:57:37');
INSERT INTO permissions VALUES('1412','1','7','invoices.show','2024-08-19 22:57:37','2024-08-19 22:57:37');
INSERT INTO permissions VALUES('1413','1','7','invoices.as_assigned','2024-08-19 22:57:37','2024-08-19 22:57:37');
INSERT INTO permissions VALUES('1414','1','7','invoices.fee_receipt','2024-08-19 22:57:37','2024-08-19 22:57:37');
INSERT INTO permissions VALUES('1415','1','7','invoices.fee_receipt_store','2024-08-19 22:57:37','2024-08-19 22:57:37');
INSERT INTO permissions VALUES('1416','1','7','student_ledger','2024-08-19 22:57:37','2024-08-19 22:57:37');
INSERT INTO permissions VALUES('1417','1','7','student_ledger_print','2024-08-19 22:57:37','2024-08-19 22:57:37');
INSERT INTO permissions VALUES('1418','1','7','student_payments.create','2024-08-19 22:57:37','2024-08-19 22:57:37');
INSERT INTO permissions VALUES('1419','1','7','student_payments.index','2024-08-19 22:57:37','2024-08-19 22:57:37');
INSERT INTO permissions VALUES('1420','1','7','student_payments.show','2024-08-19 22:57:37','2024-08-19 22:57:37');
INSERT INTO permissions VALUES('1421','1','7','sms.view_logs','2024-08-19 22:57:37','2024-08-19 22:57:37');
INSERT INTO permissions VALUES('1422','1','7','email.compose','2024-08-19 22:57:37','2024-08-19 22:57:37');
INSERT INTO permissions VALUES('1423','1','7','email.view_logs','2024-08-19 22:57:37','2024-08-19 22:57:37');
INSERT INTO permissions VALUES('1424','1','7','notices.index','2024-08-19 22:57:37','2024-08-19 22:57:37');
INSERT INTO permissions VALUES('1425','1','7','notices.create','2024-08-19 22:57:37','2024-08-19 22:57:37');
INSERT INTO permissions VALUES('1426','1','7','reports.student_attendance_report','2024-08-19 22:57:37','2024-08-19 22:57:37');
INSERT INTO permissions VALUES('1427','1','7','reports.staff_attendance_report','2024-08-19 22:57:37','2024-08-19 22:57:37');
INSERT INTO permissions VALUES('1428','1','7','reports.student_id_card','2024-08-19 22:57:37','2024-08-19 22:57:37');
INSERT INTO permissions VALUES('1429','1','7','reports.exam_report','2024-08-19 22:57:37','2024-08-19 22:57:37');
INSERT INTO permissions VALUES('1430','1','7','reports.progress_card','2024-08-19 22:57:37','2024-08-19 22:57:37');
INSERT INTO permissions VALUES('1431','1','7','reports.class_routine','2024-08-19 22:57:37','2024-08-19 22:57:37');
INSERT INTO permissions VALUES('1432','1','7','reports.exam_routine','2024-08-19 22:57:37','2024-08-19 22:57:37');
INSERT INTO permissions VALUES('1433','1','7','reports.income_report','2024-08-19 22:57:37','2024-08-19 22:57:37');
INSERT INTO permissions VALUES('1434','1','7','reports.expense_report','2024-08-19 22:57:37','2024-08-19 22:57:37');
INSERT INTO permissions VALUES('1435','1','7','reports.account_balance','2024-08-19 22:57:37','2024-08-19 22:57:37');
INSERT INTO permissions VALUES('1436','1','7','reports.report_area','2024-08-19 22:57:37','2024-08-19 22:57:37');
INSERT INTO permissions VALUES('1437','1','7','reports.generate_report','2024-08-19 22:57:37','2024-08-19 22:57:37');
INSERT INTO permissions VALUES('1438','1','7','permission.manage','2024-08-19 22:57:37','2024-08-19 22:57:37');
INSERT INTO permissions VALUES('1439','1','7','permission_roles.index','2024-08-19 22:57:37','2024-08-19 22:57:37');
INSERT INTO permissions VALUES('1460','1','2','students.show','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1461','1','2','students.edit','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1462','1','2','class.index','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1463','1','2','class.store','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1464','1','2','class.edit','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1465','1','2','class.destroy','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1466','1','2','sections.index','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1467','1','2','sections.store','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1468','1','2','sections.edit','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1469','1','2','student_groups.index','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1470','1','2','student_groups.create','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1471','1','2','student_groups.show','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1472','1','2','student_groups.edit','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1473','1','2','student_groups.destroy','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1474','1','2','departments.index','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1475','1','2','departments.create','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1476','1','2','departments.show','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1477','1','2','departments.edit','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1478','1','2','departments.destroy','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1479','1','2','student_attendance.create','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1480','1','2','staff_attendance.create','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1481','1','2','general_settings.update','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1482','1','2','theme_option.update','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1483','1','2','utility.backup_database','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1484','1','2','languages.index','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1485','1','2','languages.create','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1486','1','2','languages.edit','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1487','1','2','languages.destroy','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1488','1','2','picklists.index','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1489','1','2','picklists.create','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1490','1','2','picklists.show','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1491','1','2','picklists.edit','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1492','1','2','picklists.destroy','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1493','1','2','books.index','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1494','1','2','books.create','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1495','1','2','books.show','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1496','1','2','books.edit','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1497','1','2','transports.index','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1498','1','2','transports.create','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1499','1','2','transports.show','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1500','1','2','transports.edit','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1501','1','2','hostels.index','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1502','1','2','hostels.create','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1503','1','2','hostels.show','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1504','1','2','hostels.edit','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1505','1','2','hostelcategories.index','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1506','1','2','hostelcategories.create','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1507','1','2','hostelcategories.show','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1508','1','2','hostelcategories.edit','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1509','1','2','hostelmembers.index','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1510','1','2','hostelmembers.create','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1511','1','2','hostelmembers.show','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1512','1','2','hostelmembers.edit','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1513','1','2','grades.index','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1514','1','2','grades.create','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1515','1','2','grades.show','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1516','1','2','grades.edit','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1517','1','2','accounts.index','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1518','1','2','accounts.create','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1519','1','2','accounts.show','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1520','1','2','accounts.edit','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1521','1','2','chart_of_accounts.index','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1522','1','2','chart_of_accounts.create','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1523','1','2','chart_of_accounts.show','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1524','1','2','chart_of_accounts.edit','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1525','1','2','payment_methods.index','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1526','1','2','payment_methods.create','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1527','1','2','payment_methods.show','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1528','1','2','payment_methods.edit','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1529','1','2','payee_payers.index','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1530','1','2','payee_payers.create','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1531','1','2','payee_payers.show','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1532','1','2','payee_payers.edit','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1533','1','2','transactions.manage_income','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1534','1','2','transactions.manage_expense','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1535','1','2','transactions.add_income','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1536','1','2','transactions.add_expense','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1537','1','2','transactions.store','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1538','1','2','transactions.show','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1539','1','2','transactions.edit','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1540','1','2','fee_types.index','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1541','1','2','fee_types.create','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1542','1','2','fee_types.show','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1543','1','2','fee_types.edit','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1544','1','2','invoices.index','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1545','1','2','invoices.feeBill','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1546','1','2','invoices.create','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1547','1','2','invoices.show','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1548','1','2','invoices.edit','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1549','1','2','invoices.destroy','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1550','1','2','invoices.as_assigned','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1551','1','2','invoices.fee_receipt','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1552','1','2','invoices.fee_receipt_store','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1553','1','2','student_ledger','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1554','1','2','student_ledger_print','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1555','1','2','student_payments.create','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1556','1','2','student_payments.index','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1557','1','2','student_payments.show','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1558','1','2','student_payments.edit','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1559','1','2','sms.compose','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1560','1','2','sms.view_logs','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1561','1','2','email.compose','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1562','1','2','email.view_logs','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1563','1','2','notices.index','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1564','1','2','notices.create','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1565','1','2','notices.edit','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1566','1','2','events.index','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1567','1','2','events.create','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1568','1','2','events.edit','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1569','1','2','reports.student_attendance_report','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1570','1','2','reports.staff_attendance_report','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1571','1','2','reports.student_id_card','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1572','1','2','reports.exam_report','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1573','1','2','reports.progress_card','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1574','1','2','reports.class_routine','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1575','1','2','reports.exam_routine','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1576','1','2','reports.income_report','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1577','1','2','reports.expense_report','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1578','1','2','reports.account_balance','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1579','1','2','reports.report_area','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1580','1','2','reports.generate_report','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1581','1','2','permission_roles.index','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1582','1','2','permission_roles.create','2024-11-09 22:52:40','2024-11-09 22:52:40');
INSERT INTO permissions VALUES('1583','1','2','permission_roles.show','2024-11-09 22:52:40','2024-11-09 22:52:40');



DROP TABLE IF EXISTS picklists;

CREATE TABLE `picklists` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `school_id` int(11) NOT NULL,
  `type` varchar(191) NOT NULL,
  `value` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO picklists VALUES('1','1','Religion','MUSLIM','2021-08-04 18:46:14','2021-08-04 18:46:14');
INSERT INTO picklists VALUES('2','1','Religion','NON MUSLIM','2021-08-04 18:46:55','2021-08-04 18:46:55');
INSERT INTO picklists VALUES('3','1','Designation','MANAGER','2021-08-04 18:47:32','2021-08-04 18:47:32');
INSERT INTO picklists VALUES('4','1','Designation','COOK','2021-08-04 18:47:57','2021-08-04 18:47:57');
INSERT INTO picklists VALUES('5','1','Designation','SWEEPER','2021-08-04 18:48:22','2021-08-04 18:48:22');
INSERT INTO picklists VALUES('6','1','Designation','MALI','2021-08-04 18:48:41','2022-03-01 18:07:09');
INSERT INTO picklists VALUES('7','1','Designation','SUPERVISOR','2022-03-01 18:03:32','2022-03-01 18:03:32');
INSERT INTO picklists VALUES('8','1','Designation','RECEPTIONIST','2022-03-01 18:03:52','2022-03-01 18:03:52');
INSERT INTO picklists VALUES('9','1','Designation','ACCOUNTANT','2022-03-01 18:04:04','2022-03-01 18:04:04');
INSERT INTO picklists VALUES('10','1','Designation','COOK HELPER','2022-03-01 18:05:14','2022-03-01 18:05:14');
INSERT INTO picklists VALUES('11','1','Designation','WAITER','2022-03-01 18:05:27','2022-03-01 18:05:27');
INSERT INTO picklists VALUES('12','1','Designation','HOUSE KEEPER','2022-03-01 18:05:48','2022-03-01 18:05:48');
INSERT INTO picklists VALUES('13','1','Designation','ELECTRICIAN','2022-03-01 18:06:08','2022-03-01 18:06:08');
INSERT INTO picklists VALUES('14','1','Designation','GUARD','2022-03-01 18:06:31','2022-03-01 18:06:31');
INSERT INTO picklists VALUES('15','1','Designation','Warden','2024-08-19 22:39:08','2024-08-19 22:39:08');



DROP TABLE IF EXISTS post_categories;

CREATE TABLE `post_categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category` varchar(191) NOT NULL,
  `trans_category` text DEFAULT NULL,
  `note` varchar(191) DEFAULT NULL,
  `type` varchar(191) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE IF EXISTS post_contents;

CREATE TABLE `post_contents` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `post_title` text NOT NULL,
  `post_content` longtext DEFAULT NULL,
  `meta_data` longtext DEFAULT NULL,
  `language` varchar(191) NOT NULL DEFAULT 'english',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE IF EXISTS posts;

CREATE TABLE `posts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `school_id` int(11) NOT NULL,
  `slug` varchar(191) NOT NULL,
  `post_type` varchar(191) NOT NULL,
  `post_status` varchar(20) NOT NULL,
  `featured_image` varchar(191) DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE IF EXISTS school_invoices;

CREATE TABLE `school_invoices` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `school_id` int(11) NOT NULL,
  `package_id` int(11) DEFAULT NULL,
  `invoice_no` varchar(50) DEFAULT NULL,
  `billing_period` int(11) DEFAULT 0,
  `invoice_date` date DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `description` mediumtext DEFAULT NULL,
  `total` decimal(8,2) DEFAULT 0.00,
  `paid` decimal(8,2) DEFAULT 0.00,
  `status` enum('Due','Paid') DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE IF EXISTS sections;

CREATE TABLE `sections` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `school_id` int(11) DEFAULT NULL,
  `section_name` varchar(191) NOT NULL,
  `room_no` varchar(100) DEFAULT NULL,
  `class_id` int(11) NOT NULL,
  `class_teacher_id` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `rank` int(11) DEFAULT NULL,
  `capacity` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO sections VALUES('1','1','101 Attach','101','2','','1','','6','2024-08-19 21:16:41','2024-11-09 22:11:21');
INSERT INTO sections VALUES('2','1','102 Common','102 Common','2','','1','','2','2024-08-19 21:19:17','2024-11-09 22:11:44');
INSERT INTO sections VALUES('3','1','103 common','103','2','','1','','1','2024-08-19 21:28:11','2024-11-09 22:12:40');
INSERT INTO sections VALUES('59','1','104 common','104','2','','1','','1','2024-11-10 20:57:59','2024-11-10 20:57:59');
INSERT INTO sections VALUES('5','1','105 Common','105','2','','1','','1','2024-08-19 21:30:42','2024-11-09 22:14:19');
INSERT INTO sections VALUES('6','1','106 Common','106','2','','1','','1','2024-08-19 21:43:20','2024-11-09 22:14:42');
INSERT INTO sections VALUES('7','1','107 common','107','2','','1','','2','2024-08-19 21:46:17','2024-11-09 22:15:20');
INSERT INTO sections VALUES('8','1','108 Common','108','2','','1','','2','2024-08-19 21:47:06','2024-11-09 22:28:30');
INSERT INTO sections VALUES('9','1','109 Common','109','2','','1','','1','2024-08-19 21:50:57','2024-11-09 22:35:08');
INSERT INTO sections VALUES('10','1','110 Common','110','2','','1','','1','2024-08-19 21:52:32','2024-11-09 22:30:02');
INSERT INTO sections VALUES('11','1','111 Common','111','2','','1','','2','2024-08-19 21:53:18','2024-11-09 22:36:25');
INSERT INTO sections VALUES('12','1','112 Common','112','2','','1','','1','2024-08-19 21:57:59','2024-11-09 22:37:01');
INSERT INTO sections VALUES('13','1','113 Common','113','2','','1','','1','2024-08-19 21:58:39','2024-11-09 22:37:26');
INSERT INTO sections VALUES('14','1','114 Common','114','2','','1','','1','2024-11-09 22:38:14','2024-11-09 22:38:14');
INSERT INTO sections VALUES('15','1','115 Common','115','2','','1','','2','2024-11-09 22:38:39','2024-11-09 22:38:39');
INSERT INTO sections VALUES('16','1','116 Common','116','2','','1','','3','2024-11-09 22:39:02','2024-11-09 22:39:02');
INSERT INTO sections VALUES('17','1','117 Common','117','2','','1','','3','2024-11-09 22:39:18','2024-11-09 22:40:23');
INSERT INTO sections VALUES('18','1','118 Common','118','2','','1','','2','2024-11-09 22:39:38','2024-11-09 22:39:38');
INSERT INTO sections VALUES('19','1','119 Common','119','2','','1','','3','2024-11-09 22:41:10','2024-11-09 22:41:10');
INSERT INTO sections VALUES('20','1','120 Common','120','2','','1','','1','2024-11-09 22:41:31','2024-11-09 22:41:31');
INSERT INTO sections VALUES('21','1','121 Common','121','2','','1','','2','2024-11-09 22:41:55','2024-11-09 22:41:55');
INSERT INTO sections VALUES('22','1','122 Common','122','2','','1','','1','2024-11-09 22:42:35','2024-11-09 22:42:35');
INSERT INTO sections VALUES('23','1','123 Common','123','2','','1','','1','2024-11-09 22:43:00','2024-11-09 22:43:00');
INSERT INTO sections VALUES('24','1','201 attach','201','3','','1','','3','2024-11-09 23:05:57','2024-11-09 23:05:57');
INSERT INTO sections VALUES('35','1','206 common','206','3','','1','','2','2024-11-10 20:43:27','2024-11-10 20:43:27');
INSERT INTO sections VALUES('31','1','202 attach','202','3','','1','','6','2024-11-10 20:39:56','2024-11-10 20:41:06');
INSERT INTO sections VALUES('32','1','203 common','203','3','','1','','3','2024-11-10 20:40:34','2024-11-10 20:40:34');
INSERT INTO sections VALUES('33','1','204 common','204','3','','1','','3','2024-11-10 20:42:17','2024-11-10 20:42:17');
INSERT INTO sections VALUES('34','1','205 attach','207','3','','1','','7','2024-11-10 20:42:59','2024-11-10 20:42:59');
INSERT INTO sections VALUES('36','1','207 common','207','3','','1','','2','2024-11-10 20:43:50','2024-11-10 20:43:50');
INSERT INTO sections VALUES('37','1','208 common','208','3','','1','','3','2024-11-10 20:44:30','2024-11-10 20:44:30');
INSERT INTO sections VALUES('38','1','209 common','209','3','','1','','3','2024-11-10 20:44:54','2024-11-10 20:44:54');
INSERT INTO sections VALUES('39','1','210 common','210','3','','1','','1','2024-11-10 20:45:14','2024-11-10 20:45:14');
INSERT INTO sections VALUES('40','1','211 common','211','3','','1','','2','2024-11-10 20:45:33','2024-11-10 20:45:33');
INSERT INTO sections VALUES('41','1','212 common','212','3','','1','','2','2024-11-10 20:45:54','2024-11-10 20:45:54');
INSERT INTO sections VALUES('42','1','213 common','213','3','','1','','2','2024-11-10 20:46:14','2024-11-10 20:46:14');
INSERT INTO sections VALUES('43','1','214 common','214','3','','1','','4','2024-11-10 20:46:48','2024-11-10 20:46:48');
INSERT INTO sections VALUES('44','1','215 common','215','3','','1','','3','2024-11-10 20:48:11','2024-11-10 20:48:11');
INSERT INTO sections VALUES('45','1','301 attach','301','4','','1','','3','2024-11-10 20:48:32','2024-11-10 20:48:32');
INSERT INTO sections VALUES('46','1','302 attach','302','4','','1','','5','2024-11-10 20:49:08','2024-11-10 20:49:08');
INSERT INTO sections VALUES('47','1','303 common','303','4','','1','','4','2024-11-10 20:49:30','2024-11-10 20:49:30');
INSERT INTO sections VALUES('48','1','304 common','304','4','','1','','4','2024-11-10 20:49:51','2024-11-10 20:49:51');
INSERT INTO sections VALUES('49','1','305 common','305','4','','1','','2','2024-11-10 20:50:17','2024-11-10 20:51:00');
INSERT INTO sections VALUES('50','1','306 attach','306','4','','1','','7','2024-11-10 20:51:20','2024-11-10 20:51:20');
INSERT INTO sections VALUES('51','1','307 common','307','4','','1','','1','2024-11-10 20:51:49','2024-11-10 20:51:49');
INSERT INTO sections VALUES('52','1','308 common','308','4','','1','','1','2024-11-10 20:52:10','2024-11-10 20:52:10');
INSERT INTO sections VALUES('53','1','309  common','309','4','','1','','1','2024-11-10 20:52:36','2024-11-10 20:52:36');
INSERT INTO sections VALUES('54','1','310 attach','310','4','','1','','6','2024-11-10 20:52:55','2024-11-10 20:52:55');
INSERT INTO sections VALUES('55','1','311 common','311','4','','1','','1','2024-11-10 20:53:14','2024-11-10 20:53:14');
INSERT INTO sections VALUES('56','1','312 common','312','4','','1','','2','2024-11-10 20:53:32','2024-11-10 20:53:32');
INSERT INTO sections VALUES('57','1','313 attach','313','4','','1','','7','2024-11-10 20:53:54','2024-11-10 20:53:54');
INSERT INTO sections VALUES('58','1','314 attach','314','4','','1','','7','2024-11-10 20:54:16','2024-11-10 20:54:16');
INSERT INTO sections VALUES('60','1','315','315 common','4','','1','','2','2024-12-31 08:51:07','2024-12-31 08:51:07');



DROP TABLE IF EXISTS settings;

CREATE TABLE `settings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `academic_year` int(11) DEFAULT NULL,
  `timezone` varchar(50) DEFAULT NULL,
  `currency_symbol` varchar(50) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `backend_direction` varchar(30) DEFAULT NULL,
  `active_theme` varchar(30) DEFAULT NULL,
  `disabled_website` varchar(30) DEFAULT NULL,
  `copyright_text` text DEFAULT NULL,
  `school_name` text DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `package_id` int(11) DEFAULT NULL,
  `site_title` text DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(70) DEFAULT NULL,
  `language` varchar(50) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `home_page` varchar(50) DEFAULT NULL,
  `sidebar_color` varchar(10) DEFAULT NULL,
  `sidebar_text_color` varchar(10) DEFAULT NULL,
  `sidebar_border_color` varchar(10) DEFAULT NULL,
  `active_sidebar_background` varchar(10) DEFAULT NULL,
  `custom_backend_css` longtext DEFAULT NULL,
  `value` longtext NOT NULL,
  `mail_type` varchar(50) DEFAULT NULL,
  `from_email` varchar(100) DEFAULT NULL,
  `from_name` varchar(100) DEFAULT NULL,
  `smtp_host` varchar(100) DEFAULT NULL,
  `smtp_port` varchar(20) DEFAULT NULL,
  `smtp_username` varchar(100) DEFAULT NULL,
  `smtp_password` varchar(100) DEFAULT NULL,
  `smtp_encryption` varchar(50) DEFAULT NULL,
  `email_footer` text DEFAULT NULL,
  `TWILIO_SID` varchar(150) DEFAULT NULL,
  `TWILIO_TOKEN` varchar(150) DEFAULT NULL,
  `TWILIO_MOBILE` varchar(20) DEFAULT NULL,
  `paypal_active` varchar(10) DEFAULT NULL,
  `paypal_currency` varchar(30) DEFAULT NULL,
  `paypal_email` varchar(50) DEFAULT NULL,
  `stripe_active` varchar(10) DEFAULT NULL,
  `stripe_currency` varchar(30) DEFAULT NULL,
  `stripe_secret_key` varchar(150) DEFAULT NULL,
  `stripe_publishable_key` varchar(150) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO settings VALUES('1','academic_year','1','Asia/Karachi','Rs.','1556705924_1.png','ltr','default','','','Bait-ul-Hareem Girls Hostel','2021-10-24','5','Bait-ul-Hareem Girls Hostel','+92301 2793333','baitulhareem77@gmail.com','English','House #31, Street #25 F-8/2, Islamabad','','#ffffff','#000000','#dddddd','#e78421','','1','smtp','admin@hostalmanager.pk','Bait-ul-Hareem Girls Hostel','Bait-ul-Hareem','465','Bait-ul-Hareem','123456','tls','Best Regards','','','','No','USD','test@gmail.com','No','USD','','','','2025-02-16 17:28:05');



DROP TABLE IF EXISTS site_navigation_items;

CREATE TABLE `site_navigation_items` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `navigation_id` int(11) NOT NULL,
  `menu_label` varchar(191) NOT NULL,
  `link` text DEFAULT NULL,
  `page_id` int(11) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `css_class` varchar(191) DEFAULT NULL,
  `css_id` varchar(191) DEFAULT NULL,
  `menu_order` int(11) NOT NULL DEFAULT 100,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE IF EXISTS site_navigations;

CREATE TABLE `site_navigations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `menu_name` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE IF EXISTS sms_logs;

CREATE TABLE `sms_logs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `school_id` int(11) NOT NULL,
  `receiver` varchar(20) NOT NULL,
  `message` text NOT NULL,
  `sender_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE IF EXISTS staff_attendances;

CREATE TABLE `staff_attendances` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `school_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `attendance` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO staff_attendances VALUES('1','1','822','2025-02-13','1','2025-02-17 15:37:25','2025-02-17 15:37:25');
INSERT INTO staff_attendances VALUES('2','1','319','2025-02-13','1','2025-02-17 15:37:25','2025-02-17 15:37:25');



DROP TABLE IF EXISTS student_attendances;

CREATE TABLE `student_attendances` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `school_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `attendance` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE IF EXISTS student_fee_assigns;

CREATE TABLE `student_fee_assigns` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `school_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `fee_id` int(11) NOT NULL,
  `amount` double(8,2) NOT NULL DEFAULT 0.00,
  `discount` double(8,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE IF EXISTS student_groups;

CREATE TABLE `student_groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `school_id` int(11) NOT NULL,
  `group_name` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE IF EXISTS student_payments;

CREATE TABLE `student_payments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `school_id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `amount` decimal(8,2) NOT NULL,
  `note` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE IF EXISTS student_sessions;

CREATE TABLE `student_sessions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `school_id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `roll` varchar(50) NOT NULL,
  `optional_subject` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=125 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO student_sessions VALUES('1','1','1','1','2','1','2','6120635','','2024-08-20 22:41:43','2024-08-20 22:41:43');
INSERT INTO student_sessions VALUES('2','1','1','2','2','5','1','19891334','','2024-08-20 22:51:07','2024-08-20 22:51:07');
INSERT INTO student_sessions VALUES('3','1','1','3','3','31','2','','','2024-08-20 22:59:02','2024-11-14 04:53:40');
INSERT INTO student_sessions VALUES('4','1','1','4','2','1','2','97226908','','2024-08-20 23:08:40','2024-08-20 23:08:40');
INSERT INTO student_sessions VALUES('5','1','1','5','2','12','2','78254957','','2024-08-21 17:01:50','2024-08-21 17:01:50');
INSERT INTO student_sessions VALUES('6','1','1','6','2','2','2','80972803','','2024-08-21 17:16:16','2024-08-21 17:16:16');
INSERT INTO student_sessions VALUES('7','1','1','7','2','5','1','41423436','','2024-08-21 17:24:04','2024-08-21 17:24:04');
INSERT INTO student_sessions VALUES('8','1','1','8','2','6','1','40104061','','2024-08-21 18:49:50','2024-08-21 18:49:50');
INSERT INTO student_sessions VALUES('9','1','1','9','2','6','2','2302293','','2024-08-21 18:59:22','2024-08-29 22:22:01');
INSERT INTO student_sessions VALUES('10','1','1','10','2','4','2','26042659','','2024-08-22 13:21:57','2024-08-22 13:21:57');
INSERT INTO student_sessions VALUES('11','1','1','11','2','2','2','56671398','','2024-08-22 14:04:40','2024-08-22 14:04:40');
INSERT INTO student_sessions VALUES('12','1','1','12','2','1','2','67086466','','2024-08-22 15:30:09','2024-08-22 15:30:09');
INSERT INTO student_sessions VALUES('13','1','1','13','2','2','2','2317421','','2024-08-22 15:36:03','2024-08-22 15:36:03');
INSERT INTO student_sessions VALUES('14','1','1','14','2','8','2','80029821','','2024-08-22 15:41:41','2024-08-25 15:46:00');
INSERT INTO student_sessions VALUES('15','1','1','15','2','8','2','28555293','','2024-08-22 15:48:14','2024-08-25 15:51:12');
INSERT INTO student_sessions VALUES('16','1','1','16','2','5','2','10105400','','2024-08-22 18:36:22','2024-08-22 18:36:22');
INSERT INTO student_sessions VALUES('17','1','1','17','2','11','2','45289767','','2024-08-22 18:49:22','2024-08-22 18:49:22');
INSERT INTO student_sessions VALUES('18','1','1','18','2','13','1','96578638','','2024-08-23 15:26:57','2024-08-23 15:26:57');
INSERT INTO student_sessions VALUES('19','1','1','19','2','3','2','4979356','','2024-08-23 19:39:21','2024-08-23 19:39:21');
INSERT INTO student_sessions VALUES('20','1','1','20','2','8','1','38305590','','2024-08-23 19:43:51','2024-08-25 15:48:44');
INSERT INTO student_sessions VALUES('21','1','1','21','2','3','2','12813150','','2024-08-23 19:48:58','2024-08-23 19:48:58');
INSERT INTO student_sessions VALUES('22','1','1','22','2','5','2','47393654','','2024-08-27 16:20:25','2024-08-27 16:20:25');
INSERT INTO student_sessions VALUES('23','1','1','23','2','4','1','62320126','','2024-08-27 16:46:05','2024-08-27 16:46:05');
INSERT INTO student_sessions VALUES('24','1','1','24','2','12','1','43447281','','2024-08-27 16:51:34','2024-08-27 16:51:34');
INSERT INTO student_sessions VALUES('25','1','1','25','2','9','2','8032228','','2024-08-29 14:16:25','2024-08-29 14:16:25');
INSERT INTO student_sessions VALUES('26','1','1','26','2','4','1','24943824','','2024-11-09 23:20:52','2024-11-09 23:20:52');
INSERT INTO student_sessions VALUES('27','1','1','27','2','1','2','32120426','','2024-11-10 21:10:16','2024-11-10 21:10:16');
INSERT INTO student_sessions VALUES('28','1','1','28','2','1','2','22380344','','2024-11-10 21:38:08','2024-11-10 21:38:08');
INSERT INTO student_sessions VALUES('29','1','1','29','2','6','2','27952886','','2024-11-10 21:58:13','2024-11-10 21:58:13');
INSERT INTO student_sessions VALUES('30','1','1','30','2','1','2','54246305','','2024-11-10 22:09:17','2024-11-10 22:09:17');
INSERT INTO student_sessions VALUES('31','1','1','31','2','8','2','52298607','','2024-11-10 22:15:39','2024-11-10 22:15:39');
INSERT INTO student_sessions VALUES('32','1','1','32','2','8','2','62228974','','2024-11-10 22:37:07','2024-11-10 22:37:07');
INSERT INTO student_sessions VALUES('33','1','1','33','4','57','2','90655870','','2024-11-10 23:07:32','2024-11-10 23:07:32');
INSERT INTO student_sessions VALUES('34','1','1','34','4','51','2','20409271','','2024-11-10 23:13:30','2024-11-10 23:13:30');
INSERT INTO student_sessions VALUES('35','1','1','35','4','46','2','20846641','','2024-11-10 23:18:57','2024-11-10 23:18:57');
INSERT INTO student_sessions VALUES('36','1','1','36','4','58','1','91578984','','2024-11-10 23:28:46','2024-11-10 23:28:46');
INSERT INTO student_sessions VALUES('37','1','1','37','4','56','2','22645749','','2024-11-10 23:35:19','2024-11-10 23:35:19');
INSERT INTO student_sessions VALUES('38','1','1','38','4','56','2','31077350','','2024-11-10 23:40:03','2024-11-10 23:40:03');
INSERT INTO student_sessions VALUES('39','1','1','39','4','54','2','72751538','','2024-11-10 23:44:04','2024-11-10 23:44:04');
INSERT INTO student_sessions VALUES('40','1','1','40','4','47','2','34310126','','2024-11-10 23:50:53','2024-11-10 23:50:53');
INSERT INTO student_sessions VALUES('41','1','1','41','4','46','2','41790274','','2024-11-11 00:04:25','2024-11-11 00:04:25');
INSERT INTO student_sessions VALUES('42','1','1','42','4','54','2','46273862','','2024-11-11 00:17:44','2024-11-11 00:17:44');
INSERT INTO student_sessions VALUES('43','1','1','43','4','46','2','85342393','','2024-11-11 00:22:56','2024-11-11 00:22:56');
INSERT INTO student_sessions VALUES('44','1','1','44','4','57','2','80275055','','2024-11-11 00:27:56','2024-11-11 00:27:56');
INSERT INTO student_sessions VALUES('45','1','1','45','4','54','2','21620270','','2024-11-11 00:32:36','2024-11-11 00:32:36');
INSERT INTO student_sessions VALUES('46','1','1','46','4','47','2','50036793','','2024-11-11 00:38:46','2024-11-11 00:38:46');
INSERT INTO student_sessions VALUES('47','1','1','47','4','45','2','83283399','','2024-11-11 00:44:30','2024-11-11 00:44:30');
INSERT INTO student_sessions VALUES('48','1','1','48','4','49','2','30346997','','2024-11-11 00:48:20','2024-11-11 00:48:20');
INSERT INTO student_sessions VALUES('49','1','1','49','4','49','2','30346998','','2024-11-11 00:49:14','2024-11-17 16:12:54');
INSERT INTO student_sessions VALUES('50','1','1','50','4','47','2','33063067','','2024-11-11 01:03:47','2024-11-11 01:03:47');
INSERT INTO student_sessions VALUES('51','1','1','51','4','57','2','18309047','','2024-11-11 01:06:40','2024-11-11 01:06:40');
INSERT INTO student_sessions VALUES('52','1','1','52','4','57','2','3760646','','2024-11-11 01:13:07','2024-11-11 01:13:07');
INSERT INTO student_sessions VALUES('53','1','1','53','4','47','2','10076622','','2024-11-11 01:23:27','2024-11-11 01:23:27');
INSERT INTO student_sessions VALUES('54','1','1','54','4','58','2','62556963','','2024-11-11 01:35:40','2024-11-11 01:35:40');
INSERT INTO student_sessions VALUES('55','1','1','55','4','58','2','53501306','','2024-11-11 01:43:07','2024-11-11 01:43:07');
INSERT INTO student_sessions VALUES('56','1','1','56','4','50','2','35219385','','2024-11-11 01:53:36','2024-11-11 01:53:36');
INSERT INTO student_sessions VALUES('57','1','1','57','4','50','2','35219386','','2024-11-11 01:55:14','2024-11-11 01:55:14');
INSERT INTO student_sessions VALUES('58','1','1','58','4','50','2','35219390','','2024-11-11 01:55:59','2024-11-11 01:55:59');
INSERT INTO student_sessions VALUES('59','1','1','59','4','57','2','89941014','','2024-11-11 02:00:07','2024-11-11 02:00:07');
INSERT INTO student_sessions VALUES('60','1','1','60','4','50','2','28105188','','2024-11-11 02:02:48','2024-11-11 02:02:48');
INSERT INTO student_sessions VALUES('61','1','1','61','4','58','2','74551754','','2024-11-11 02:09:02','2024-11-11 02:09:02');
INSERT INTO student_sessions VALUES('62','1','1','62','4','58','2','45252074','','2024-11-11 02:15:58','2024-11-11 02:15:58');
INSERT INTO student_sessions VALUES('63','1','1','63','4','57','2','42449566','','2024-11-11 02:32:31','2024-11-11 02:32:31');
INSERT INTO student_sessions VALUES('64','1','1','64','4','57','2','95483590','','2024-11-11 02:43:29','2024-11-11 02:43:29');
INSERT INTO student_sessions VALUES('65','1','1','65','4','48','2','3612360','','2024-11-11 02:53:38','2024-11-11 02:53:38');
INSERT INTO student_sessions VALUES('66','1','1','66','4','48','2','86523660','','2024-11-11 03:11:01','2024-11-11 03:11:01');
INSERT INTO student_sessions VALUES('67','1','1','67','4','45','2','37162356','','2024-11-11 03:20:07','2024-11-11 03:20:07');
INSERT INTO student_sessions VALUES('68','1','1','68','3','34','2','23756753','','2024-11-12 03:57:25','2024-11-12 03:57:25');
INSERT INTO student_sessions VALUES('69','1','1','69','2','1','1','30407319','','2024-11-12 04:09:28','2024-11-12 04:09:28');
INSERT INTO student_sessions VALUES('70','1','1','70','2','17','2','10040378','','2024-11-12 04:19:24','2024-11-12 04:19:24');
INSERT INTO student_sessions VALUES('71','1','1','71','2','2','1','8464203','','2024-11-12 04:26:20','2024-11-12 04:26:20');
INSERT INTO student_sessions VALUES('72','1','1','72','3','44','2','','','2024-11-12 04:39:07','2024-11-14 05:20:44');
INSERT INTO student_sessions VALUES('73','1','1','73','3','38','2','9757683','','2024-11-12 04:51:08','2024-11-12 04:51:08');
INSERT INTO student_sessions VALUES('74','1','1','74','3','43','2','56852654','','2024-11-12 05:05:22','2024-11-12 05:05:22');
INSERT INTO student_sessions VALUES('75','1','1','75','3','34','2','73416816','','2024-11-12 05:09:16','2024-11-12 05:09:16');
INSERT INTO student_sessions VALUES('76','1','1','76','3','34','2','75015952','','2024-11-12 05:13:36','2024-11-12 05:13:36');
INSERT INTO student_sessions VALUES('77','1','1','77','3','33','2','73989040','','2024-11-12 05:46:03','2024-11-12 05:46:03');
INSERT INTO student_sessions VALUES('78','1','1','78','2','37','2','94714224','','2024-11-12 05:58:25','2024-11-12 05:58:25');
INSERT INTO student_sessions VALUES('79','1','1','79','2','37','2','94714227','','2024-11-12 05:59:47','2024-11-12 05:59:47');
INSERT INTO student_sessions VALUES('80','1','1','80','3','34','1','','','2024-11-14 02:52:15','2024-11-14 05:26:09');
INSERT INTO student_sessions VALUES('81','1','1','81','4','50','2','32409967','','2024-11-14 02:53:16','2024-11-14 02:53:16');
INSERT INTO student_sessions VALUES('82','1','1','82','4','45','2','88423605','','2024-11-14 02:59:02','2024-11-14 02:59:02');
INSERT INTO student_sessions VALUES('83','1','1','83','3','36','2','31507525','','2024-11-14 03:07:22','2024-11-14 03:07:22');
INSERT INTO student_sessions VALUES('84','1','1','84','3','43','2','31878079','','2024-11-14 03:10:15','2024-11-14 03:10:15');
INSERT INTO student_sessions VALUES('85','1','1','85','4','53','1','40585050','','2024-11-14 03:27:22','2024-11-14 03:27:22');
INSERT INTO student_sessions VALUES('86','1','1','86','3','24','2','49881606','','2024-11-14 03:33:27','2024-11-14 03:33:27');
INSERT INTO student_sessions VALUES('87','1','1','87','3','24','2','7028384','','2024-11-14 03:37:06','2024-11-14 03:37:06');
INSERT INTO student_sessions VALUES('88','1','1','88','3','24','2','7028388','','2024-11-14 03:38:11','2024-11-14 03:38:11');
INSERT INTO student_sessions VALUES('89','1','1','89','3','33','2','61559124','','2024-11-14 03:44:49','2024-11-14 03:44:49');
INSERT INTO student_sessions VALUES('90','1','1','90','3','33','2','16468796','','2024-11-14 04:11:46','2024-11-14 04:11:46');
INSERT INTO student_sessions VALUES('91','1','1','91','4','46','2','85748515','','2024-11-14 04:24:47','2024-11-14 04:24:47');
INSERT INTO student_sessions VALUES('92','1','1','92','2','5','1','38922300','','2024-11-21 12:47:57','2024-11-21 12:47:57');
INSERT INTO student_sessions VALUES('93','1','1','93','3','34','2','69785911','','2024-11-21 14:47:59','2024-11-21 14:47:59');
INSERT INTO student_sessions VALUES('94','1','1','94','2','1','2','70983123','','2024-12-01 08:11:11','2024-12-01 08:11:11');
INSERT INTO student_sessions VALUES('95','1','1','95','2','1','2','15068492','','2024-12-01 08:20:58','2024-12-01 08:20:58');
INSERT INTO student_sessions VALUES('96','1','1','96','2','2','2','49228192','','2024-12-01 08:40:41','2024-12-01 08:40:41');
INSERT INTO student_sessions VALUES('97','1','1','97','2','59','1','36992212','','2024-12-01 11:22:13','2024-12-01 11:22:13');
INSERT INTO student_sessions VALUES('98','1','1','98','2','7','1','52287217','','2024-12-01 11:25:25','2024-12-01 11:25:25');
INSERT INTO student_sessions VALUES('99','1','1','99','2','7','1','55799683','','2024-12-01 11:28:49','2024-12-01 11:28:49');
INSERT INTO student_sessions VALUES('100','1','1','100','2','18','2','75369716','','2024-12-01 11:37:16','2024-12-01 11:37:16');
INSERT INTO student_sessions VALUES('101','1','1','101','2','18','2','64876615','','2024-12-01 11:41:07','2024-12-01 11:41:07');
INSERT INTO student_sessions VALUES('102','1','1','102','2','19','2','90771832','','2024-12-01 11:44:38','2024-12-01 11:44:38');
INSERT INTO student_sessions VALUES('103','1','1','103','2','23','2','84212106','','2024-12-01 11:59:34','2024-12-01 11:59:34');
INSERT INTO student_sessions VALUES('104','1','1','104','2','22','2','34586256','','2024-12-01 12:03:18','2024-12-01 12:03:18');
INSERT INTO student_sessions VALUES('105','1','1','105','2','21','2','90196982','','2024-12-01 14:05:38','2024-12-01 14:05:38');
INSERT INTO student_sessions VALUES('106','1','1','106','2','21','1','71697168','','2024-12-01 14:07:41','2024-12-01 14:07:41');
INSERT INTO student_sessions VALUES('107','1','1','107','2','3','1','80798607','','2024-12-31 08:43:39','2024-12-31 08:43:39');
INSERT INTO student_sessions VALUES('108','1','1','108','4','60','2','66430558','','2024-12-31 08:56:00','2024-12-31 08:56:00');
INSERT INTO student_sessions VALUES('109','1','1','110','2','9','1','24558182','','2025-02-17 11:24:43','2025-02-17 11:24:43');
INSERT INTO student_sessions VALUES('110','1','1','111','2','11','2','85428333','','2025-02-17 11:34:29','2025-02-17 11:34:29');
INSERT INTO student_sessions VALUES('111','1','1','112','2','11','2','17757430','','2025-02-17 11:40:06','2025-02-17 11:40:06');
INSERT INTO student_sessions VALUES('112','1','1','113','2','12','1','64716920','','2025-02-17 11:43:53','2025-02-17 11:43:53');
INSERT INTO student_sessions VALUES('113','1','1','114','2','13','2','31516293','','2025-02-17 11:53:03','2025-02-17 11:53:03');
INSERT INTO student_sessions VALUES('114','1','1','115','2','14','2','42260738','','2025-02-17 12:31:54','2025-02-17 12:31:54');
INSERT INTO student_sessions VALUES('115','1','1','116','2','15','2','69455089','','2025-02-17 12:56:56','2025-02-17 12:56:56');
INSERT INTO student_sessions VALUES('116','1','1','117','2','15','1','49473456','','2025-02-17 13:02:26','2025-02-17 13:02:26');
INSERT INTO student_sessions VALUES('117','1','1','118','2','10','1','24944525','','2025-02-17 13:20:17','2025-02-17 13:20:17');
INSERT INTO student_sessions VALUES('118','1','1','119','3','44','2','31233938','','2025-02-17 13:45:25','2025-02-17 13:45:25');
INSERT INTO student_sessions VALUES('119','1','1','120','3','36','1','15298821','','2025-02-17 13:55:03','2025-02-17 13:55:03');
INSERT INTO student_sessions VALUES('120','1','1','121','2','17','2','9162377','','2025-02-17 14:45:29','2025-02-17 14:45:29');
INSERT INTO student_sessions VALUES('121','1','1','122','2','18','1','63942108','','2025-02-17 14:58:33','2025-02-17 14:58:33');
INSERT INTO student_sessions VALUES('122','1','1','123','2','19','2','47407515','','2025-02-17 15:02:06','2025-02-17 15:02:06');
INSERT INTO student_sessions VALUES('123','1','1','124','3','24','2','33177215','','2025-02-17 15:34:32','2025-02-17 15:34:32');
INSERT INTO student_sessions VALUES('124','1','1','125','2','17','2','55376175','','2025-02-17 15:41:14','2025-02-17 15:41:14');



DROP TABLE IF EXISTS students;

CREATE TABLE `students` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `school_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `first_name` varchar(191) NOT NULL,
  `last_name` varchar(191) DEFAULT NULL,
  `father_name` varchar(191) DEFAULT NULL,
  `birthday` date NOT NULL,
  `gender` varchar(10) NOT NULL,
  `status` tinyint(4) DEFAULT 1,
  `blood_group` varchar(4) DEFAULT NULL,
  `religion` varchar(20) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `home_phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `state` varchar(191) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `register_no` varchar(50) NOT NULL,
  `group` varchar(191) DEFAULT NULL,
  `activities` varchar(191) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=126 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO students VALUES('1','1','2','796','1','0','Sabeeka Fatima','','Zahoor Ahmed','2001-04-08','Female','0','','','923193457488','','42 Lodhi colony','Punjab','Pakistan','6120635','','36602-2136012-0','','2024-08-20 22:41:43','2024-11-09 23:00:16');
INSERT INTO students VALUES('2','1','2','797','1','0','Ayesha Younis','','Muhammad Younis','2000-07-19','Female','0','','','923144988694','923412888023','E-24Engro Employees Colony, Daharki','Sindh','Pakistan','19891334','','35202-2352972-2','','2024-08-20 22:51:07','2024-11-09 22:59:48');
INSERT INTO students VALUES('3','1','2','798','1','0','AFIFA FATIMA','','ASHRAF ALI','2005-08-28','Female','0','N/A','MUSLIM','923018407780','','ASKARI TOWER DHA PHASE 5 FLOOR 6','PUNJAB','Pakistan','83202960','1','33401-0734880-4','','2024-08-20 22:59:02','2024-11-14 04:50:57');
INSERT INTO students VALUES('4','1','2','799','1','0','Khadija Bibi','','Asghar Ali','2003-03-13','Female','0','','','923303787068','923352999009      92','Engro Employees Colony Daharki, District Ghotki','Sindh','Pakistan','97226908','','45101-3525227-0','','2024-08-20 23:08:40','2024-11-09 23:02:24');
INSERT INTO students VALUES('5','1','2','801','1','0','Ayesha','','Sajid','2006-02-20','Female','0','','MUSLIM','923155556516','923436696516','House 3 street 5 Satara Colony Toba tex sing','Punjab','Pakistan','78254957','1','33105-2938213-8','','2024-08-21 17:01:50','2024-11-09 22:59:23');
INSERT INTO students VALUES('6','1','2','802','1','0','Laiba Nadir Mazari','','Nadir Ali Khan','2004-02-05','Female','0','','MUSLIM','923186686933','','Chief Family Post Office, Coat Karam Khan, Tehsil Rahem Yar Khan, District Yar khan','Punjab','Pakistan','80972803','1','31303-1461452-4','','2024-08-21 17:16:16','2024-11-09 22:58:22');
INSERT INTO students VALUES('7','1','2','803','1','0','Huma Aimen','','Muhammad Ismail','2001-03-12','Female','0','','MUSLIM','923367902461','','House#3/42 Muhallah Munshi, Mandi Bahawaldeen','Punjab','Pakistan','41423436','1','34402-8307342-0','','2024-08-21 17:24:04','2024-11-09 22:59:37');
INSERT INTO students VALUES('8','1','2','804','1','0','Lubna Rehman','','Abdul Rehman','1999-11-03','Female','0','','MUSLIM','923015851823','','Post Office, Riazabad,625 tda, Tehsil and District Muzaffargarh','Punjab','Pakistan','40104061','1','32303-7795212-8','','2024-08-21 18:49:50','2024-11-09 22:59:11');
INSERT INTO students VALUES('9','1','2','805','1','0','Aqsa Mehreen','','Zahid Aslam Khokhar','2000-09-25','Female','0','','MUSLIM','923165196344','','Flat no 2, Block 65-B, G-10/3 Islamabad','Punjab','Pakistan','2302293','','37405-9975702-4','','2024-08-21 18:59:22','2024-11-09 23:00:58');
INSERT INTO students VALUES('10','1','2','806','1','0','Laveeza Arif','','Muhammad Arif','1999-12-24','Female','0','','MUSLIM','923355565603','923161113206','House 633, sector 4 KhalaBhat township Haripur','KPK','Pakistan','26042659','','42301-0133037-2','','2024-08-22 13:21:57','2024-11-09 23:01:57');
INSERT INTO students VALUES('11','1','2','807','1','0','Misbah','','Misbah Isfaq','2004-08-18','Female','0','','MUSLIM','923110674953','','Chief Family, Tc, District Rajan Por, Rahim Yar Khan','Pujab','Pakistan','56671398','','','','2024-08-22 14:04:40','2024-11-09 22:57:16');
INSERT INTO students VALUES('12','1','2','808','1','0','Malaika Ahsan','','Jaffer Hussain','2004-02-10','Female','0','','','923134755536','923007597413','Burewala city','Punjab','Pakistan','67086466','','36601-3346647-4','','2024-08-22 15:30:09','2024-11-09 23:00:00');
INSERT INTO students VALUES('13','1','2','809','1','0','Saleha Ishfaq','','Ishfaq Ahmed','2004-07-04','Female','0','','','923150674953','03333032225','Sui Balochistan','Balochistan','Pakistan','2317421','','31303-4020748-0','','2024-08-22 15:36:03','2024-11-09 22:58:34');
INSERT INTO students VALUES('14','1','2','810','1','0','Imamma Zahir','','Zahir','2001-06-15','Female','0','','MUSLIM','923285691190','923065468556','b/17 Islamabad','Punjab','Pakistan','80029821','','61101-3558471-8','','2024-08-22 15:41:41','2024-11-09 23:02:58');
INSERT INTO students VALUES('15','1','2','811','1','0','Imama','','Mirza Hussain','2001-07-05','Female','0','','MUSLIM','923099589116','923058693588','b/17 Islamabad','Punjab','Pakistan','28555293','','21303-6625403-0','','2024-08-22 15:48:14','2024-11-09 22:58:09');
INSERT INTO students VALUES('16','1','2','812','1','0','Muneeza','','Sajjad Ali','2002-12-11','Female','0','','MUSLIM','923027657697','923342534389','E-98 Engro Colony','Punjab','Pakistan','10105400','','45101-7374529-4','','2024-08-22 18:36:22','2024-11-09 23:02:40');
INSERT INTO students VALUES('17','1','2','813','1','0','Duaa Altaf','','Altaf Bhatt','1999-07-29','Female','0','','MUSLIM','923421652888','923015620398','Ward no 29 Muzaffarabad','Azad Kashmir','Pakistan','45289767','','82203-3461462-2','','2024-08-22 18:49:22','2024-11-09 23:03:46');
INSERT INTO students VALUES('18','1','2','814','1','0','Samina Maryam','','Ghulam Mehdi','1994-02-09','Female','0','','MUSLIM','923415399844','','River Garden Islamabad','Punjab','Pakistan','96578638','','21103-9020674-0','','2024-08-23 15:26:57','2024-11-09 22:57:51');
INSERT INTO students VALUES('19','1','2','815','1','0','Tooba Bukhari','','Tahir Hussain Shah','1989-07-29','Female','0','','','923556014466','923118839451','Al-Sadat general store upper domail syedan Muzaffarabad','Azaad Khasmir','Pakistan','4979356','','82202-4880118-6','','2024-08-23 19:39:21','2024-11-09 23:03:34');
INSERT INTO students VALUES('20','1','2','816','1','0','Sana','','Zahir','1998-06-26','Female','0','','MUSLIM','923058693588','923078020686','B/17 Islamabad','Punjab','Pakistan','38305590','','61101-4764568-8','','2024-08-23 19:43:51','2024-11-09 23:03:20');
INSERT INTO students VALUES('21','1','2','817','1','0','Zoha','','Shahid Imran Malik','2005-05-02','Female','0','','','923255868858','923015364066','Chachi Mahalah near Al- Ain Hospital, house no. Cb338','Punjab','Pakistan','12813150','','37406-2696074-8','','2024-08-23 19:48:58','2024-11-09 23:01:24');
INSERT INTO students VALUES('22','1','2','818','1','0','Aneeza','','Sajjad Ali','2002-12-11','Female','0','','MUSLIM','923027657697','','E-98 Engro Colony','Balochistan','Pakistan','47393654','','','','2024-08-27 16:20:25','2024-11-09 22:56:59');
INSERT INTO students VALUES('23','1','2','819','1','0','Ahlam','','Muhammad Yousaf','2003-05-29','Female','0','','','923493103680','','House no 166/A-39, Gulshan-heeded, Karachi','Sindh','Pakistan','62320126','','41302-4534624-6','','2024-08-27 16:46:05','2024-11-09 23:01:39');
INSERT INTO students VALUES('24','1','2','820','1','0','Shehrbano Abbas','','Mazhar Abbas','2003-06-21','Female','0','','','923333742203','','Tehsil Jand District Attock','Punjab','Pakistan','43447281','','37104-5368434-2','','2024-08-27 16:51:34','2024-11-09 23:00:34');
INSERT INTO students VALUES('25','1','2','821','1','0','Khadija Iftikhar','','Muhammad Iftikhar','2002-03-23','Female','0','','MUSLIM','923094248136','','177 gp','Punjab','Pakistan','8032228','','','','2024-08-29 14:16:25','2024-11-14 05:13:33');
INSERT INTO students VALUES('26','1','2','823','1','0','SANIA NISAR','','NISAR MUZAFFAR','1998-11-25','Female','1','A+','MUSLIM','923177656292','','E 196 P.A.E.C NEW COLONY CHASHMA MIANWALI','PUNJAB','Pakistan','24943824','','34201-4825621-0','','2024-11-09 23:20:52','2024-11-09 23:20:52');
INSERT INTO students VALUES('27','1','2','824','1','0','SUMAIYA ARSHAD','','ARSHAD MEHMOOD','2005-07-11','Female','1','A+','MUSLIM','923420443405','','HEER ROAD BEHIND TELEPHONE EXCHANGE DALOWALI SIALKOT','PUNJAB','Pakistan','32120426','1','37302-2595487-4','','2024-11-10 21:10:16','2024-11-10 21:10:16');
INSERT INTO students VALUES('28','1','2','825','1','0','SALEHA ZULFIQAR','','DSR ZULFIQAR BHALI','2005-04-14','Female','1','A+','MUSLIM','923196543459','','RASULPUR BHALLIYAN KIGRA ROAD SIALKOT','PUNJAB','Pakistan','22380344','1','34603-4873120-8','','2024-11-10 21:38:08','2024-11-10 21:38:08');
INSERT INTO students VALUES('29','1','2','826','1','0','ZAINAB MURTAZA','','GULAM MURTAZA','2005-10-01','Female','1','A+','MUSLIM','923484218728','','POST OFFICE CHAHAL KALON THATHA DISTRICT GUJRAWALA','PUNJAB','Pakistan','27952886','','34101-3222006-8','','2024-11-10 21:58:13','2024-11-10 21:58:13');
INSERT INTO students VALUES('30','1','2','827','1','0','JAYSHA WASEEM','','WASEEM IMRAN','2004-12-24','Female','1','A+','MUSLIM','923256101686','','PASRUR ROAD NAEEM SHAHEED CHOWK SIALKOL','PUNJAB','Pakistan','54246305','1','34603-6431339-2','','2024-11-10 22:09:17','2024-11-10 22:09:17');
INSERT INTO students VALUES('31','1','2','828','1','0','MARYAM AZHAR','','AZHAR MEHMOOD','2006-01-23','Female','1','A+','MUSLIM','923365658944','','NOOR COLONY NEHR ROAD HARIPUR','PUNJAB','Pakistan','52298607','1','13302-0474656-3','','2024-11-10 22:15:39','2024-11-10 22:15:39');
INSERT INTO students VALUES('32','1','2','829','1','0','ASFIYA NOOR','','TARIQ MEHMOOD','2005-11-28','Female','1','A+','MUSLIM','923209156828','','HARIPUR','PUNJAB','Pakistan','62228974','1','13302-5856350-6','','2024-11-10 22:37:07','2024-11-10 22:37:07');
INSERT INTO students VALUES('33','1','2','830','1','0','ANSHARA ZAHOOR','','ZAHOOR KHAN','2007-07-28','Female','1','A+','MUSLIM','923021208901','','A-24 BLOCK 01 CLIFTON KARACHI','SINDH','Pakistan','90655870','1','42301-3648477-4','','2024-11-10 23:07:32','2024-11-10 23:07:32');
INSERT INTO students VALUES('34','1','2','831','1','0','FIZA SAQIB','','MIRZA MUHAMMAD SAQIB','2003-09-30','Female','1','A+','MUSLIM','923315722494','','HOUSE 123 STREET 10 DOTTS PHASE 1 MALIR CANTT KARACHI','SINDH','Pakistan','20409271','1','42301-1371633-8','','2024-11-10 23:13:30','2024-11-10 23:13:30');
INSERT INTO students VALUES('35','1','2','832','1','0','NOOR-UL-AIN','','JABER ALI','2005-04-16','Female','1','A+','MUSLIM','923127464440','','D-20 NEW COLONY CHASHMA DIST MIANWALI','PUNJAB','Pakistan','20846641','1','37406-0824242-8','','2024-11-10 23:18:57','2024-11-10 23:18:57');
INSERT INTO students VALUES('36','1','2','833','1','0','AQSA SHABIR','','GULAM SHABIR','1993-04-16','Female','1','A+','MUSLIM','923427244604','','MOHALA CHCHAN WALA TAUNSA DGK','PUNJAB','Pakistan','91578984','1','32103-9169153-8','','2024-11-10 23:28:46','2024-11-10 23:28:46');
INSERT INTO students VALUES('37','1','2','834','1','0','LAIBA KHATAK','','IHSAN-UD-DIN KHATAK','2006-02-03','Female','1','A+','MUSLIM','923048690071','','BEHRAM KHAIL VILLAGE CHERAT BAKHTI TEHSIL PABBI DIST NOWSHERA KPK','KPK','Pakistan','22645749','1','17202-0636134-2','','2024-11-10 23:35:19','2024-11-10 23:35:19');
INSERT INTO students VALUES('38','1','2','835','1','0','MARIA NAZIR','','MUBASHIR NAZIR','2004-09-05','Female','1','A+','MUSLIM','923071678830','','HOUSE 776 WOODS BLOCK PARAGON CITY BARKY ROAD LAHORE','PUNJAB','Pakistan','31077350','1','42201-8591938-2','','2024-11-10 23:40:03','2024-11-10 23:40:03');
INSERT INTO students VALUES('39','1','2','836','1','0','NIMRA SHAFQAT','','SHAFQAT RASOOL','2002-06-11','Female','1','A+','MUSLIM','923262035430','','P-109 YOUSAF TOWN MAIN BAZAR SATYANA ROAD FAISLABAD','PUMJAB','Pakistan','72751538','1','33100-8519949-0','','2024-11-10 23:44:04','2024-11-10 23:44:04');
INSERT INTO students VALUES('40','1','2','837','1','0','SANA SADIQ','','HAMID RASHEED AWAN','2003-08-21','Female','1','A+','MUSLIM','923037402790','','MUHALLA QAZIA WALLA NEAR POST OYYICE KUFRI TEHSIL NAUSHERA DIST KHUSHAB','PUNJAB','Pakistan','34310126','1','38403-2650796-2','','2024-11-10 23:50:53','2024-11-10 23:50:53');
INSERT INTO students VALUES('41','1','2','838','1','0','SYEDA MAHEEN ZALRA','','SYED SHAKEEL SALMA','2004-01-25','Female','1','A+','MUSLIM','92323509905','','SHADMAAN SUFI BLOCK STREET 01 HOUSE O2 GUJRAT','PUNJAB','Pakistan','41790274','1','34201-0105601-0','','2024-11-11 00:04:25','2024-11-21 10:27:00');
INSERT INTO students VALUES('42','1','2','839','1','0','HASEENA SAFDAR','','SAFDAR JEHAN','1999-04-25','Female','1','A+','MUSLIM','923324273362','','EID GAH ROAD IMAN HOUSE MOHALA SULTAN ABAD MARDAN','KPK','Pakistan','46273862','1','17101-5093411-8','','2024-11-11 00:17:44','2024-11-11 00:17:44');
INSERT INTO students VALUES('43','1','2','840','1','0','NOOR FATIMA','','JAVAID IQBAL','2001-05-05','Female','1','A+','MUSLIM','923026566119','','MUHALA LHOTA KARKHANA STREET 1 HOUSE 3 PIR MAHAL TOBA TEK SINGH','PUNJAB','Pakistan','85342393','1','33302-6309004-4','','2024-11-11 00:22:56','2024-11-11 00:22:56');
INSERT INTO students VALUES('44','1','2','841','1','0','BUSHRA','','FAZAL KHAN','2001-10-10','Female','1','A+','MUSLIM','923217399325','','STREET 20 HOUSE 2 GULBERG TOWN KAMRA CANTT','PUNJAB','Pakistan','80275055','','16202-6617835-8','','2024-11-11 00:27:56','2024-11-11 00:27:56');
INSERT INTO students VALUES('45','1','2','842','1','0','NOOR-UL-HUDA','','ABDUL QUDDOOS RANA','2001-01-31','Female','1','A+','MUSLIM','923020985522','','HOUSE 1 STREET 26QASIM TOWN OFF RATTA ROAD GUJRANWALA','PUNJAB','Pakistan','21620270','1','34608-7851251-0','','2024-11-11 00:32:36','2024-11-11 00:32:36');
INSERT INTO students VALUES('46','1','2','843','1','0','SURAIYA BANO','','IMTIAZ HUSSAIN','2002-02-15','Female','1','A+','MUSLIM','923498906495','','NOOR COLONY JUTIAL GILGIT','GILGIT','Pakistan','50036793','1','71501-8123057-2','','2024-11-11 00:38:46','2024-11-11 00:38:46');
INSERT INTO students VALUES('47','1','2','844','1','0','SABA RIAZ','','RIAZ AHMAD','2005-01-24','Female','1','A+','MUSLIM','923007554262','','DERA BAHAWALLA NEAR SHAN PETROLEUM MANDI BAHAUDIN','PUNJAB','Pakistan','83283399','1','34402-3529586-6','','2024-11-11 00:44:30','2024-11-11 00:44:30');
INSERT INTO students VALUES('48','1','2','845','1','0','MAHNOOR SHAHID','','SHAHID BACHA','2001-01-15','Female','0','A+','MUSLIM','923159972444','','MOHALLA YAQOOB KHAN GARHI SAZ GULBERG TOWN MARDAN','KPK','Pakistan','30346997','1','16101-2180702-4','','2024-11-11 00:48:20','2024-11-17 16:16:00');
INSERT INTO students VALUES('49','1','2','846','1','0','MAHNOOR SHAHID','','SHAHID BACHA','2001-01-15','Female','1','A+','MUSLIM','923159972444','','MOHALLA YAQOOB KHAN GARHI SAZ GULBERG TOWN MARDAN','KPK','Pakistan','30346998','1','16101-2180702-4','','2024-11-11 00:49:14','2024-11-11 00:49:14');
INSERT INTO students VALUES('50','1','2','847','1','0','SHEHZADI EMAAN FATIMA','','MUHAMMAD ILYAS','2007-12-23','Female','1','A+','MUSLIM','923118859410','','ILYAS HOUSE NEAR ABDULLAH HOSPITAL SKARDU','GILGIT-BALTISTAN','Pakistan','33063067','1','71103-9771780-4','','2024-11-11 01:03:47','2024-11-11 01:03:47');
INSERT INTO students VALUES('51','1','2','848','1','0','SAYEDA LAIBA BUKHARI','','SYED TASSAWAR BUKHARI','2004-07-23','Female','1','A+','MUSLIM','923028787509','','MUZZAFFRABAD AZAD KASHMIR','KASHMIR','Pakistan','18309047','1','82203-1556878-6','','2024-11-11 01:06:40','2024-11-11 01:06:40');
INSERT INTO students VALUES('52','1','2','849','1','0','ALISHBA KANWAL','','MUHAMMAD SHAFI','2005-03-14','Female','1','A+','MUSLIM','92304679424','','CHAH BOOTIAN WALA DHAKANA QURESHI WALA MALIK PURR TEHSIL \' DIST LODHRAN','PUNJAB','Pakistan','3760646','1','36203-8572163-2','','2024-11-11 01:13:07','2024-11-11 01:13:07');
INSERT INTO students VALUES('53','1','2','850','1','0','HINA ZAHRA','','MUHAMMAD ALI','2007-02-22','Female','1','A+','MUSLIM','923481233119','','7-71-73 ALAMADAR ROAD QUETTA','BLOCHISTAN','Pakistan','10076622','1','54401-5089720-8','','2024-11-11 01:23:27','2024-11-11 01:23:27');
INSERT INTO students VALUES('54','1','2','851','1','0','TAHIRA MUMTAZ','','MUMTAZ AHMED','1999-01-01','Female','1','A+','MUSLIM','923150160454','','MUMTAZ HOUSE MAIN STREET GHOSIA SULTANA TOWN SADIQABD','PUNJAB','Pakistan','62556963','1','31304-7523074-2','','2024-11-11 01:35:40','2024-11-11 01:35:40');
INSERT INTO students VALUES('55','1','2','852','1','0','EISHA JUNEJO','','JAM SHAHZAD RAZA','2004-09-06','Female','1','A+','','923173766534','','HOUSE 287  BLOCK 19 UNIT 8 LATIFABAD HYDRERABAD','SINDH','Pakistan','53501306','1','42000-6695426-2','','2024-11-11 01:43:07','2024-11-21 11:31:16');
INSERT INTO students VALUES('56','1','2','853','1','0','FARYAL FATIMA','','SHAFQAT IQBAL','2005-02-25','Female','0','A+','MUSLIM','923441001002','','DERA PAJEKA PO KHAAS  RUKKAN TEHSIL MALAKWAL DIST MANDIBAHAUDDIN','PUNJAB','Pakistan','35219385','1','34401-9013384-0','','2024-11-11 01:53:36','2024-11-14 03:15:46');
INSERT INTO students VALUES('57','1','2','854','1','0','FARYAL FATIMA','','SHAFQAT IQBAL','2005-02-25','Female','0','A+','MUSLIM','923441001002','','DERA PAJEKA PO KHAAS  RUKKAN TEHSIL MALAKWAL DIST MANDIBAHAUDDIN','PUNJAB','Pakistan','35219386','1','34401-9013384-0','','2024-11-11 01:55:14','2024-11-20 16:31:41');
INSERT INTO students VALUES('58','1','2','855','1','0','FARYAL FATIMA','','SHAFQAT IQBAL','2005-02-25','Female','1','A+','MUSLIM','923441001002','','DERA PAJEKA PO KHAAS  RUKKAN TEHSIL MALAKWAL DIST MANDIBAHAUDDIN','PUNJAB','Pakistan','35219390','1','34401-9013384-0','','2024-11-11 01:55:59','2024-11-11 01:55:59');
INSERT INTO students VALUES('59','1','2','856','1','0','TANZEELA KHAN','','AYUB KHAN','2003-02-22','Female','1','A+','MUSLIM','923443247175','','H-41 S0BRA CITY TARBELA DAM TEHSIL GHAZI DIST HARIPUR','PUNJAB','Pakistan','89941014','','16102-3170899-0','','2024-11-11 02:00:07','2024-11-11 02:00:07');
INSERT INTO students VALUES('60','1','2','857','1','0','ZEBA AWAN','','MUMTAZ GUL','2005-11-07','Female','1','A+','MUSLIM','923421972991','','NEAR ASLAM MARWT HOSPITAL MADNI COLONY DIST ATTOCK','PUNJAB','Pakistan','28105188','1','37101-2147728-4','','2024-11-11 02:02:48','2024-11-11 02:02:48');
INSERT INTO students VALUES('61','1','2','858','1','0','ANVISHA HAMEED','','ABDUL HAMEED','2003-12-24','Female','1','A+','MUSLIM','923119733181','','VILLAGE GORHI TEHSEED \' DIST MAZAFARABAD','PUNJAB','Pakistan','74551754','1','82203-8312947-8','','2024-11-11 02:09:02','2024-11-11 02:09:02');
INSERT INTO students VALUES('62','1','2','859','1','0','IMAAN FATIMA','','M. MAZHAR SHOIB KHAN','2005-08-17','Female','1','A+','MUSLIM','923334479123','','HOUSE NO 6 STREET NO 1 BLOCK B GULSHAN-E-MADINA COLONY MULTAN','PUNJAB','Pakistan','45252074','1','32103-2478551-4','','2024-11-11 02:15:58','2024-11-11 02:15:58');
INSERT INTO students VALUES('63','1','2','860','1','0','HAFSA ABID','','M.ABID','2006-10-22','Female','1','A+','MUSLIM','923008757351','','346A KARIM BLOCK LAHORE','PUNJAB','Pakistan','42449566','1','36401-5259555-4','','2024-11-11 02:32:31','2024-11-11 02:32:31');
INSERT INTO students VALUES('64','1','2','861','1','0','NOOR FATIMA AGHA','','SAHAIL AHMED AGHA','2004-02-28','Female','1','A+','MUSLIM','923168922807','','HOUSE 517 NEAR AGP SADDAR CANTT HYDERABAD','SINDH','Pakistan','95483590','1','41302-5843293-2','','2024-11-11 02:43:29','2024-11-11 02:43:29');
INSERT INTO students VALUES('65','1','2','862','1','0','RANIA ASGHAR','','ASGHAR ALI KHAN','2006-01-16','Female','1','A+','MUSLIM','923169179310','','MURID JAFFRAN WALI MASJID GULBERG','PUNJAB','Pakistan','3612360','1','37201-2534769-0','','2024-11-11 02:53:38','2024-11-11 02:53:38');
INSERT INTO students VALUES('66','1','2','863','1','0','NABEHA FATIMA','','ZULFIQAR HAIDER','2005-03-19','Female','1','A+','MUSLIM','923061859571','','SATTELITE  TOWN 193 RAHEEM YAAR KHAN','PUNJAB','Pakistan','86523660','1','31303-7207606-8','','2024-11-11 03:11:01','2024-11-11 03:11:01');
INSERT INTO students VALUES('67','1','2','864','1','0','SANIA SAEED','','SAEED-UR-REHMAN','2005-10-10','Female','1','A+','MUSLIM','923199476471','','P/O BULANI TEHSIL SARAI ALAMGIR DIST GUJRAT','PUNJAB','Pakistan','37162356','','34203-9973128-4','','2024-11-11 03:20:07','2024-11-11 03:20:07');
INSERT INTO students VALUES('68','1','2','865','1','0','MOMINA NAQVI','','HABIB HUSSAIN SHAH','2005-06-26','Female','1','A+','MUSLIM','923465142877','','SEHNSA KOTTI AZAD JAMMU KASHMIR','AZAD KASHMIR','Pakistan','23756753','2','31203-7440210-2','','2024-11-12 03:57:25','2024-11-12 03:57:25');
INSERT INTO students VALUES('69','1','2','866','1','0','MAHNOOR','','SUHAIL AHMED','2005-02-12','Female','1','A+','MUSLIM','923063495098','','WARD NO 6 DIST NAUSHEHROZE CITY BHIRIA ROAD','SINDH','Pakistan','30407319','2','45301-3139751-0','','2024-11-12 04:09:28','2024-11-12 04:09:28');
INSERT INTO students VALUES('70','1','2','867','1','0','HINA NAEEM','','NAEEM ULLAH','2005-07-25','Female','1','A+','MUSLIM','923061620121','','HOUSE 563 STREET 12 FAROOQ COLONY  PHASE B','PUNJAB','Pakistan','10040378','2','38405-6747935-6','','2024-11-12 04:19:24','2024-11-12 04:19:24');
INSERT INTO students VALUES('71','1','2','868','1','0','ALIZA ZAFAR','','ZAFAR IQBAL','2002-06-20','Female','1','A+','MUSLIM','923044199939','','IQBAL PURA SANGLA HILL D-NANKANA SAHIB','PUNJAB','Pakistan','8464203','1','35503-0178230-0','','2024-11-12 04:26:20','2024-11-12 04:26:20');
INSERT INTO students VALUES('72','1','2','869','1','0','ARSHIA NOOR','','M ANWAR KHAN','2004-11-20','Female','1','N/A','MUSLIM','923466204808','','CIVIL OFFICER COLONY MAINUSMANABAD ROAD ATB','PUNJAB','Pakistan','9757676','1','12101-7042205-0','','2024-11-12 04:39:07','2024-11-14 05:20:44');
INSERT INTO students VALUES('73','1','2','870','1','0','LAIBA JALAL','','MAQBOOL JALAL','2006-11-24','Female','1','A+','MUSLIM','923489036025','','NEAR UPPER CHITRAL BOONI CHITRAL','KPK','Pakistan','9757683','1','15202-146847-6','','2024-11-12 04:51:08','2024-11-12 04:51:08');
INSERT INTO students VALUES('74','1','2','871','1','0','RAMEEN ISHAQ','','M ISHAQ','2006-06-03','Female','1','A+','MUSLIM','923283844447','','HOUSE 23 STREET 20 BLOCK D ALFAISAL TOWN LAHORE','PUNJAB','Pakistan','56852654','1','35201-7750540-2','','2024-11-12 05:05:22','2024-11-12 05:05:22');
INSERT INTO students VALUES('75','1','2','872','1','0','ZAINAB','','M. SARFRAZ','2004-07-10','Female','1','A+','MUSLIM','923237813727','','24 NB SARGODHA','PUNJAB','Pakistan','73416816','2','38401-3940031-0','','2024-11-12 05:09:16','2024-11-12 05:09:16');
INSERT INTO students VALUES('76','1','2','873','1','0','MALIAKA AKRAM','','M. AKRAM KHAN','2005-09-11','Female','1','A+','MUSLIM','92300681248','','NEAR YADGAR CHOWK MUZAFRABAD','PUNJAB','Pakistan','75015952','2','32302-7769712-6','','2024-11-12 05:13:36','2024-11-12 05:13:36');
INSERT INTO students VALUES('77','1','2','874','1','0','INSHA KHAN','','AMJAD KHAN','2003-10-27','Female','1','A+','MUSLIM','923275760449','','HOUSE NO 249COMMETTI CHOWK','PUNJAB','Pakistan','73989040','1','13303-1039236-8','','2024-11-12 05:46:03','2024-11-12 05:46:03');
INSERT INTO students VALUES('78','1','2','875','1','0','MARRIUM WAJAHAT','','MALIK WAJAHAT MANZOOR','2003-08-14','Female','0','A+','','923186849587','','DERA AZMAT WASTI ROAD BACK SIDE OF KHABUR OFFICE MULTAN','PUNJAB','Pakistan','94714224','1','36302-7348056-8','','2024-11-12 05:58:25','2024-11-21 10:50:52');
INSERT INTO students VALUES('79','1','2','876','1','0','MARRIUM WAJAHAT','','MALIK WAJAHAT MANZOOR','2003-08-14','Female','1','A+','','923186849587','','DERA AZMAT WASTI ROAD BACK SIDE OF KHABUR OFFICE MULTAN','PUNJAB','Pakistan','94714227','1','36302-7348056-8','','2024-11-12 05:59:47','2024-11-12 05:59:47');
INSERT INTO students VALUES('80','1','2','877','1','0','AIMEN NADEEM','','NADEEM IFTEKHAR','1998-04-03','Female','1','N/A','MUSLIM','923056144587','','SPO HARIYAWALA GUJRAT','PUNJAB','Pakistan','32409963','1','34201-5641662-2','','2024-11-14 02:52:15','2024-11-14 05:26:09');
INSERT INTO students VALUES('81','1','2','878','1','0','ZAINAB NOOR','','NOOR MUHAMMAD','1995-04-30','Female','1','A+','MUSLIM','923485878855','','E 3-F SHAMSHER BLOCK SHAMI ROAD PESHAWAR CANTT','KPK','Pakistan','32409967','2','15042-4247859-8','','2024-11-14 02:53:16','2024-11-14 02:53:16');
INSERT INTO students VALUES('82','1','2','879','1','0','AIN-UL-NOOR','','ATTA-UL-MUATAFA','2006-03-14','Female','1','A+','MUSLIM','923412313242','','DAK KHANA KHAS MAJHI TEHSIL MALAKWAL ZILA MANADI BAHAUDDIN','PUNJAB','Pakistan','88423605','2','34401-1468578-0','','2024-11-14 02:59:02','2024-11-14 02:59:02');
INSERT INTO students VALUES('83','1','2','880','1','0','SIMRITY SINGH CHOPRA','','ARAISH KUMAR','2006-09-24','Female','1','A+','NON MUSLIM','923185099679','','HOUSE NO 15 STREET NO 1 SECTOR R SHEIKH MALTOON TOWN  MARDAN','KPK','Pakistan','31507525','1','91506-0417686-0','','2024-11-14 03:07:22','2024-11-21 11:48:47');
INSERT INTO students VALUES('84','1','2','881','1','0','AMNA BIBI','','NOOR AHMED','2005-10-23','Female','1','A+','MUSLIM','923259552562','','TALAGANG','KPK','Pakistan','31878079','1','37203-3934219-2','','2024-11-14 03:10:15','2024-11-14 03:10:15');
INSERT INTO students VALUES('85','1','2','882','1','0','SANIA AKHTAR','','SALAH-UD-AWAN','1993-01-09','Female','1','A+','MUSLIM','923085838625','','PO-BOX KOT NAJIBULLAH DIST OF TEHSIL HARIPUR VILLAGE TODO','PUNJAB','Pakistan','40585050','1','13302-1155686-6','','2024-11-14 03:27:22','2024-11-14 03:27:22');
INSERT INTO students VALUES('86','1','2','883','1','0','AROOBA ANJUM','','ANJUM PERVAIZ','2003-06-18','Female','1','A+','MUSLIM','923338737959','','HOUSE 11 INDUS ROAD CANTT DERA ISMAIL KHAN','PUNJAB','Pakistan','49881606','1','12101-5577524-0','','2024-11-14 03:33:27','2024-11-14 03:33:27');
INSERT INTO students VALUES('87','1','2','884','1','0','FATIMA NADEEM','','MUHAMMAD NADEEM','2006-10-11','Female','0','A+','MUSLIM','923117714911','','SCHEME 2 HOUSE 191 GULSHAN IQBAL RAHIM YAR KHAN','PUNJAN','Pakistan','7028384','1','31303-5566160-2','','2024-11-14 03:37:06','2024-11-18 18:38:50');
INSERT INTO students VALUES('88','1','2','885','1','0','FATIMA NADEEM','','MUHAMMAD NADEEM','2006-10-11','Female','1','A+','MUSLIM','923117714911','','SCHEME 2 HOUSE 191 GULSHAN IQBAL RAHIM YAR KHAN','PUNJAN','Pakistan','7028388','1','31303-5566160-2','','2024-11-14 03:38:11','2024-11-14 03:38:11');
INSERT INTO students VALUES('89','1','2','886','1','0','HINA KHAN','','MUHAMMAD TUFAIL KHAN','2002-03-12','Female','1','A+','MUSLIM','923405613025','','HAJEERA AZAD KASHMIR','KASHMIR','Pakistan','61559124','1','82302-9885829-8','','2024-11-14 03:44:49','2024-11-14 03:44:49');
INSERT INTO students VALUES('90','1','2','887','1','0','WANIAH MARYAM','','MUHAMMAD TARIQ','2005-10-29','Female','1','A+','MUSLIM','923364209008','','DERA GHAZIKAN','PUNJAB','Pakistan','16468796','1','32104-0398800-8','','2024-11-14 04:11:46','2024-11-14 04:11:46');
INSERT INTO students VALUES('91','1','2','888','1','0','MALEEHA RIZWAN','','M RIZWAN UDDIN SHAMS','2004-04-07','Female','1','A+','MUSLIM','923249862719','','VILLAGE GUMBAS BROZE TEHSIL AND DIST LOWER CHITRAL','PUNJAB','Pakistan','85748515','1','15201-3874713-4','','2024-11-14 04:24:47','2024-11-14 04:24:47');
INSERT INTO students VALUES('92','1','2','889','1','0','ANEEZA ABRAR','','ABRAR AHMED','2000-09-12','Female','1','A+','MUSLIM','023042756345','','REHMO WALT ROAD GHOIKT HOUSE NO 02','PUNJAB','Pakistan','38922300','1','45102-9121354-8','','2024-11-21 12:47:57','2024-11-21 12:47:57');
INSERT INTO students VALUES('93','1','2','890','1','0','MOMINA NAQVI','','HABIB HUSSAIN','2005-06-26','Female','1','A+','MUSLIM','023465142877','','SEHNSA KOTTI AZAD JAMMU KASHMIR','KASHMIR','Pakistan','69785911','2','31203-7440210-2','','2024-11-21 14:47:59','2024-11-21 14:47:59');
INSERT INTO students VALUES('94','1','2','891','1','0','MARYAM NOOR','','MANZAR KHAN','2005-12-01','Female','1','A+','MUSLIM','923251710364','','XYZ','KPK','Pakistan','70983123','1','11111-1111111-1','','2024-12-01 08:11:11','2024-12-01 08:11:11');
INSERT INTO students VALUES('95','1','2','892','1','0','NOOR-UL-AIN','','XYZ','2024-12-01','Female','1','A+','MUSLIM','923197499919','','XYZ','XYZ','Pakistan','15068492','1','22222-2222222-2','','2024-12-01 08:20:58','2024-12-01 08:20:58');
INSERT INTO students VALUES('96','1','2','893','1','0','HARRAM','','MUSHTAQ AHMED','1999-12-14','Female','1','A+','MUSLIM','923443256084','','HOUSE 152 SECTOR F/2 MIRPUR AJK','PUNJAB','Pakistan','49228192','1','81302-3128047-4','','2024-12-01 08:40:41','2024-12-01 08:46:25');
INSERT INTO students VALUES('97','1','2','894','1','0','SANIA NISAR','','NISAR MUZAFFAR','1998-11-25','Female','1','A+','MUSLIM','923177656292','','E 196 P.A.E.C NEW COLONY CHASMA','KPK','Pakistan','36992212','2','34201-4825621-0','','2024-12-01 11:22:13','2024-12-01 11:22:13');
INSERT INTO students VALUES('98','1','2','895','1','0','DR ESHA','','XYZ','2001-12-03','Female','1','A+','MUSLIM','020000000000','','XYZ','PUNJAB','Pakistan','52287217','1','22222-2222222-2','','2024-12-01 11:25:25','2024-12-01 11:25:25');
INSERT INTO students VALUES('99','1','2','896','1','0','SEEMAB AHMAD','','IFTIKHAR AHMAD','2000-10-28','Female','1','O+','MUSLIM','923016135160','','KHARIAN','PUNJAB','Pakistan','55799683','1','34202-4958858-0','','2024-12-01 11:28:49','2024-12-01 11:28:49');
INSERT INTO students VALUES('100','1','2','897','1','0','EBRAR  BERIKA','','XYZ','2005-12-05','Female','0','A+','MUSLIM','525555555555','','TURKEY','TURKEY','Turkey','75369716','1','00000-0000000-0','','2024-12-01 11:37:16','2025-02-17 14:34:32');
INSERT INTO students VALUES('101','1','2','898','1','0','AYSE NUR','','XYZ','2005-12-04','Female','0','A+','MUSLIM','525555555555','','XYZ','XYZ','Turkey','64876615','1','66666-6666666-6','','2024-12-01 11:41:07','2025-02-17 14:35:06');
INSERT INTO students VALUES('102','1','2','899','1','0','HOORIAN','','XYZ','2000-12-30','Female','1','A+','MUSLIM','626666666666','','XYZ','PUNJAB','Pakistan','90771832','1','66666-6666666-6','','2024-12-01 11:44:38','2024-12-01 11:44:38');
INSERT INTO students VALUES('103','1','2','900','1','0','KHADIJA','','XYZ','2000-12-02','Female','1','A+','MUSLIM','525555555555','','XYZ','XYZ','Pakistan','84212106','1','00000-0000000-0','','2024-12-01 11:59:34','2024-12-01 11:59:34');
INSERT INTO students VALUES('104','1','2','901','1','0','MAHAM','','XYZ','2000-12-01','Female','1','A+','MUSLIM','121111111111','','XYZ','XYZ','Pakistan','34586256','1','11111-1111111-1','','2024-12-01 12:03:18','2024-12-01 12:03:18');
INSERT INTO students VALUES('105','1','2','902','1','0','AROONA','','XYZ','2000-12-01','Female','0','A+','MUSLIM','323333333333','','XYZ','XYZ','Pakistan','90196982','1','11111-1111111-1','','2024-12-01 14:05:38','2025-02-17 15:14:54');
INSERT INTO students VALUES('106','1','2','903','1','0','AYESHA SAJAAD','','M SAJAAD','2000-12-02','Female','0','A+','MUSLIM','121111111111','','XYZ','XYZ','Pakistan','71697168','1','22222-2222222-2','','2024-12-01 14:07:41','2025-02-17 15:15:34');
INSERT INTO students VALUES('107','1','2','904','1','0','ALEEZA','','XYZ','2004-12-01','Female','1','A+','MUSLIM','020000000000','XYZ','XYZ','XYZ','Pakistan','80798607','1','00000-0000000-0','','2024-12-31 08:43:39','2024-12-31 08:43:39');
INSERT INTO students VALUES('108','1','2','905','1','0','DUA FATIMA','','ABC','2000-12-01','Female','1','A+','MUSLIM','020000000000','','XYZ','XYZ','Pakistan','66430558','1','00000-0000000-0','','2024-12-31 08:56:00','2024-12-31 08:56:00');
INSERT INTO students VALUES('109','1','2','908','1','0','Test','','Test 2','1985-07-17','Female','1','A+','MUSLIM','923003939393','929191091091','Stress','Punjab','Pakistan','62710267','1','11111-1234567-8','','2025-02-16 17:21:36','2025-02-16 17:21:36');
INSERT INTO students VALUES('110','1','0','909','1','0','AYESHA NASREEN','','M. ARSHAD','1997-02-17','Female','1','A+','MUSLIM','023000097101','03041876510','101 NB SARGODHA','PUNJAB','Pakistan','24558182','','38403-5257403-5','','2025-02-17 11:24:43','2025-02-17 11:24:43');
INSERT INTO students VALUES('111','1','0','910','1','0','TOOBA IRFAN','','IRFANULLAH','2004-03-05','Female','1','A+','MUSLIM','923259307842','','KPK DISTRICT MALAKAND TEHSIL BATKHELA','KPK','Pakistan','85428333','','15402-9822642-7','','2025-02-17 11:34:29','2025-02-17 11:34:29');
INSERT INTO students VALUES('112','1','0','911','1','0','ISHAL IMRAN','','MUHAMMAD IMRAN','2004-11-05','Female','1','A+','MUSLIM','923098400449','','GHULAM MUHAMMAD COLONY DISTRICT GUJRANWALA','PUNJAB','Pakistan','17757430','','3410-4145702-6','','2025-02-17 11:40:06','2025-02-17 11:40:06');
INSERT INTO students VALUES('113','1','0','912','1','0','DR RABIA AYOUB','','M. AYOUB CH','1995-03-23','Female','1','A+','MUSLIM','923340004915','','HOUSE NO 13/3 STREET 76 G7/1 ISLAMBAD','ISLAMBAD','Pakistan','64716920','','81202-0392405-8','','2025-02-17 11:43:53','2025-02-17 11:43:53');
INSERT INTO students VALUES('114','1','0','913','1','0','AREEBA NADEEM HASHMI','','NADEEM HUSSAIN SHAH','2003-01-25','Female','1','A+','MUSLIM','923048532000','','MIANA CHOWK HOUSE NO 4 STREET 5 ISLAMPURA KHUSHAB','PUNJAB','Pakistan','31516293','','38201-8076322-6','','2025-02-17 11:53:03','2025-02-17 11:53:03');
INSERT INTO students VALUES('115','1','0','914','1','0','MAHRUKH ALI BAIG','','ALI BAIG','2007-03-12','Female','1','A+','MUSLIM','923452655089','','NAVEED SHAHEED ROAD ZULFIQARABAD JUTIAL GILGIT','GILGIT','Pakistan','42260738','','71103-7933431-4','','2025-02-17 12:31:54','2025-02-17 12:31:54');
INSERT INTO students VALUES('116','1','0','915','1','0','MISBAH KARIM','','KARIM PANAH','2005-05-06','Female','1','A+','MUSLIM','923709539753','','SHERQILLA PUNIYAL DISTRICT GHIZER GILGIT','GILGIT','Pakistan','69455089','','71501-8133386-4','','2025-02-17 12:56:56','2025-02-17 12:56:56');
INSERT INTO students VALUES('117','1','0','916','1','0','AYESHA SAJAD','','SAJAD AKHTAR IQBAL','2002-08-01','Female','1','A+','MUSLIM','92311919716','','HOUSE NO 38A CIVIL QUARTERS PESHAWAR','KPK','Pakistan','49473456','','17301-7002596-6','','2025-02-17 13:02:26','2025-02-17 13:02:26');
INSERT INTO students VALUES('118','1','0','917','1','0','SHUMAILA ISLAM','','CH M ISLAM','1992-12-22','Female','1','A+','MUSLIM','923224193300','','PAK TOWN KAMANKI GUJRANWALA','PUNJAB','Pakistan','24944525','','34102-8118847-0','','2025-02-17 13:20:17','2025-02-17 13:20:17');
INSERT INTO students VALUES('119','1','0','918','1','0','AYESHA WAJID','','WAJID AZIZ','2006-06-10','Female','1','A+','MUSLIM','923249575305','','NEAR CHASHMA CHOWK NALVUCHI MUZAFFARABAD AJK','PUNJAB','Pakistan','31233938','','82203-2161299-0','','2025-02-17 13:45:25','2025-02-17 13:45:25');
INSERT INTO students VALUES('120','1','0','919','1','0','MAHAM MUMTAZ','','MUMTAZ AHMED','2001-06-25','Female','1','A+','MUSLIM','923096510937','','NEW SHADAB COLONY STREET 2 MDA MULTAN','PUNJAB','Pakistan','15298821','','36302-8937042-8','','2025-02-17 13:55:03','2025-02-17 13:55:03');
INSERT INTO students VALUES('121','1','0','920','1','0','MARIYAM FATIMA','','MEHAR ALI','2006-03-03','Female','1','A+','MUSLIM','923333888470','','LARKANA SINDH','SINDH','Pakistan','9162377','','42201-4062502-2','','2025-02-17 14:45:29','2025-02-17 14:45:29');
INSERT INTO students VALUES('122','1','0','921','1','0','DUR-E-SHAHWAR','','IFTIKHAR AHMED','1997-12-25','Female','1','A+','MUSLIM','923336926951','','G7/2 STREET 15 BLOCK E2 HOUSE 2 ISLAMABAD','ISLAMABAD','Pakistan','63942108','','17101-3243109-0','','2025-02-17 14:58:33','2025-02-17 14:58:33');
INSERT INTO students VALUES('123','1','0','922','1','0','AYESHA ADAN','','JALIL AHMED','2001-10-04','Female','1','A+','MUSLIM','923007848995','','HOUSE NO 182 NEAR SAKINA HOSPITAL MIANWALI','PUNJAB','Pakistan','47407515','','38302-1899536-2','','2025-02-17 15:02:06','2025-02-17 15:02:06');
INSERT INTO students VALUES('124','1','0','923','1','0','HIRA IMTIAZ','','IMTIAZ','2006-07-11','Female','1','A+','MUSLIM','923005496715','','SHINKIARI MANSEHRA','KPK','Pakistan','33177215','','13503-2577429-6','','2025-02-17 15:34:32','2025-02-17 15:34:32');
INSERT INTO students VALUES('125','1','0','924','1','0','ANIQA IRSHAD','','M. IRSHAD','2007-02-07','Female','1','A+','MUSLIM','923302121717','','USMANIA VILLA HOUSE 55 DG KHAN','PUNJAB','Pakistan','55376175','','32102-7587929-4','','2025-02-17 15:41:14','2025-02-17 15:41:14');



DROP TABLE IF EXISTS subjects;

CREATE TABLE `subjects` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `school_id` int(11) NOT NULL,
  `subject_name` varchar(40) NOT NULL,
  `subject_code` varchar(20) NOT NULL,
  `subject_type` varchar(15) NOT NULL,
  `class_id` int(11) NOT NULL,
  `full_mark` int(11) NOT NULL,
  `pass_mark` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE IF EXISTS syllabus;

CREATE TABLE `syllabus` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `school_id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL,
  `title` varchar(191) NOT NULL,
  `description` longtext DEFAULT NULL,
  `class_id` int(11) NOT NULL,
  `file` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE IF EXISTS teachers;

CREATE TABLE `teachers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `school_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(191) NOT NULL,
  `designation` varchar(191) NOT NULL,
  `birthday` date NOT NULL,
  `gender` varchar(20) NOT NULL,
  `religion` varchar(20) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `joining_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO teachers VALUES('1','1','281','M.SHAHBAZ','MANAGER','1996-01-25','Male','MUSLIM','923170000419','ISLAMABAD','2021-02-24','2021-08-04 18:54:40','2021-08-04 18:54:40');
INSERT INTO teachers VALUES('2','1','282','M.NASIR','COOK','2021-08-10','Male','MUSLIM','923009528624','LAHORE','2021-01-01','2021-08-04 18:56:56','2021-08-04 18:56:56');
INSERT INTO teachers VALUES('3','1','283','MATIUALLAH','COOK','1990-07-25','Male','MUSLIM','923411672629','HARIPUR','2021-01-01','2021-08-04 18:59:29','2021-08-04 18:59:29');
INSERT INTO teachers VALUES('4','1','284','MUZAMIL','QARI','1998-07-22','Male','MUSLIM','923117728227','VEHARI','2021-06-18','2021-08-04 19:02:21','2021-08-04 19:02:21');
INSERT INTO teachers VALUES('5','1','285','KHIZAR','COOK','1990-06-26','Male','MUSLIM','923497604118','HARIPUR','2021-07-01','2021-08-04 19:05:00','2021-08-04 19:05:00');
INSERT INTO teachers VALUES('6','1','286','IFTIKHAR','SWEEPER','1990-02-20','Male','NON MUSLIM','923035823453','ISLAMABAD','2021-01-11','2021-08-04 19:19:52','2021-08-04 19:19:52');
INSERT INTO teachers VALUES('7','1','287','SABAR','SWEEPER','1989-07-12','Male','NON MUSLIM','923412274725','RAWALPINDI','2021-06-22','2021-08-04 19:24:29','2021-08-04 19:24:29');
INSERT INTO teachers VALUES('8','1','635','Ahmed faraz','MANAGER','1998-04-25','Male','MUSLIM','03111689150','Pakpattan','2021-10-01','2021-10-04 23:28:41','2021-10-04 23:28:41');
INSERT INTO teachers VALUES('9','1','636','Muhammad maqsood','COOK','1988-02-26','Male','MUSLIM','03495826178','Dhk qasim po same, mohra noori dist Rawalpindi','2021-10-01','2021-10-04 23:33:18','2021-10-04 23:33:18');
INSERT INTO teachers VALUES('12','1','787','ELYAS KHAN','MANAGER','2000-02-20','Male','MUSLIM','923077178384','HATAN DHARA SARKO UPPER DIR','2023-06-15','2023-08-04 17:35:56','2023-08-04 17:35:56');
INSERT INTO teachers VALUES('13','1','794','Jawaria Khalid','Warden','2000-09-25','Female','MUSLIM','923325076045','House near Al Hamd School Malkiyar, Haripur','2024-08-15','2024-08-19 23:03:14','2024-08-25 15:19:23');
INSERT INTO teachers VALUES('14','1','800','Neelam Shahzadi','Warden','1992-06-22','Female','MUSLIM','923427339379','Village post office Mujahid Tehsil, district Rawalpindi','2024-04-28','2024-08-20 23:19:18','2024-08-20 23:19:18');



DROP TABLE IF EXISTS transactions;

CREATE TABLE `transactions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `school_id` int(11) NOT NULL,
  `trans_date` date NOT NULL,
  `account_id` int(11) NOT NULL,
  `trans_type` varchar(20) NOT NULL,
  `receipt_no` varchar(30) DEFAULT NULL,
  `invoice_id` int(11) DEFAULT NULL,
  `trans_source_type` enum('Income','Expense','Student','Teacher') NOT NULL,
  `amount` decimal(8,2) NOT NULL,
  `dr_cr` varchar(2) NOT NULL,
  `chart_id` text NOT NULL,
  `payee_payer_id` int(11) DEFAULT NULL,
  `payment_method_id` int(11) DEFAULT NULL,
  `create_user_id` int(11) NOT NULL,
  `update_user_id` int(11) DEFAULT NULL,
  `reference` varchar(100) DEFAULT NULL,
  `attachment` text DEFAULT NULL,
  `note` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE IF EXISTS transport_members;

CREATE TABLE `transport_members` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `school_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `member_type` varchar(20) NOT NULL,
  `transport_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE IF EXISTS transport_vehicles;

CREATE TABLE `transport_vehicles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `school_id` int(11) NOT NULL,
  `vehicle_name` varchar(100) NOT NULL,
  `serial_number` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE IF EXISTS transports;

CREATE TABLE `transports` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `school_id` int(11) NOT NULL,
  `road_name` varchar(100) NOT NULL,
  `vehicle_id` int(11) NOT NULL,
  `road_fare` decimal(8,2) NOT NULL,
  `note` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE IF EXISTS user_messages;

CREATE TABLE `user_messages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `message_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `read` varchar(1) NOT NULL DEFAULT 'n',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE IF EXISTS user_notices;

CREATE TABLE `user_notices` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `notice_id` int(11) NOT NULL,
  `user_type` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO user_notices VALUES('11','3','Accountant','2022-01-19 18:30:49','2022-01-19 18:30:49');
INSERT INTO user_notices VALUES('9','2','Admin','2022-01-19 18:25:50','2022-01-19 18:25:50');
INSERT INTO user_notices VALUES('8','2','Employee','2022-01-19 18:25:50','2022-01-19 18:25:50');
INSERT INTO user_notices VALUES('7','2','Accountant','2022-01-19 18:25:50','2022-01-19 18:25:50');
INSERT INTO user_notices VALUES('6','2','Parent','2022-01-19 18:25:50','2022-01-19 18:25:50');
INSERT INTO user_notices VALUES('12','3','Admin','2022-01-19 18:30:49','2022-01-19 18:30:49');
INSERT INTO user_notices VALUES('13','4','Accountant','2022-01-19 19:21:57','2022-01-19 19:21:57');
INSERT INTO user_notices VALUES('14','4','Admin','2022-01-19 19:21:57','2022-01-19 19:21:57');
INSERT INTO user_notices VALUES('15','5','Accountant','2022-01-19 19:39:25','2022-01-19 19:39:25');
INSERT INTO user_notices VALUES('16','5','Admin','2022-01-19 19:39:25','2022-01-19 19:39:25');
INSERT INTO user_notices VALUES('17','6','Accountant','2022-01-19 19:49:32','2022-01-19 19:49:32');
INSERT INTO user_notices VALUES('18','6','Admin','2022-01-19 19:49:32','2022-01-19 19:49:32');
INSERT INTO user_notices VALUES('19','7','Accountant','2022-01-19 19:52:35','2022-01-19 19:52:35');
INSERT INTO user_notices VALUES('20','7','Admin','2022-01-19 19:52:35','2022-01-19 19:52:35');
INSERT INTO user_notices VALUES('21','8','Accountant','2022-01-19 19:55:14','2022-01-19 19:55:14');
INSERT INTO user_notices VALUES('22','8','Admin','2022-01-19 19:55:14','2022-01-19 19:55:14');
INSERT INTO user_notices VALUES('23','9','Accountant','2022-02-24 10:59:25','2022-02-24 10:59:25');



DROP TABLE IF EXISTS users;

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `school_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL DEFAULT 0,
  `name` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `password` varchar(191) NOT NULL,
  `user_type` varchar(191) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `image` varchar(191) NOT NULL,
  `facebook` varchar(191) DEFAULT NULL,
  `twitter` varchar(191) DEFAULT NULL,
  `linkedin` varchar(191) DEFAULT NULL,
  `google_plus` varchar(191) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=925 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO users VALUES('319','1','3','Super Admin','admin@hostalmanager.pk','$2y$10$wBXfaZo6Dgup1Rzjk.obU.sse0jQgrFQzKxh3sxVQ/GV1D6NKdOtm','Admin','+923218510485','1','users/profile.png','#','#','#','#','ynWU7lRcPwoYXmdzAOxtSoLCZFCtraG5bEmA1jiFbpY37NSQvMNMg3XRVHtC','2021-09-30 13:46:18','2021-10-04 21:43:03');
INSERT INTO users VALUES('793','1','0','Default','123@hostalmanager.pk','$2y$10$Ke64opsM5Qxeqct1gzZNgOtPM9MLxerKgkzI1sZgkB/Lt244YLTyW','Parent','923219951809','1','parents/profile.png','','','','','','2024-08-19 22:29:29','2024-08-19 22:29:29');
INSERT INTO users VALUES('822','1','2','Memoona Iqbal','mem@gmail.com','$2y$10$NlRVQjLWigIFTFgNHIJbmevU/aZdhY7ATQT8D1Ed3Q/86pJjE81Qa','Admin','923040033026','1','users/profile.png','#','#','#','#','McGW1HGQXBGFB2FDc52XJhxfodTkoeV2VcfS51WvuJSMzk5pak5Q8AwyulPH','2024-11-09 22:45:58','2024-11-09 22:45:58');
INSERT INTO users VALUES('823','1','0','SANIA NISAR ','24943824@logic.com','$2y$10$TvmowQFZtvfavdmlthJJx.xQyZH/BPdWZBsQuTa4dziesGBYiWJRS','Student','923177656292','1','students/profile.png','','','','','','2024-11-09 23:20:52','2024-11-09 23:20:52');
INSERT INTO users VALUES('824','1','0','SUMAIYA ARSHAD ','32120426@logic.com','$2y$10$UUDBsL1CsHqVRZBrPl6g2.L4ASoR1TqiLJQU1c1M.eTiVISCzoKLC','Student','923420443405','1','students/profile.png','','','','','','2024-11-10 21:10:16','2024-11-10 21:10:16');
INSERT INTO users VALUES('796','1','0','Sabeeka Fatima ','6120635@logic.com','$2y$10$612ZhnMbMnU1pp.Wu041de2C5aStSOxe9ePsHqkBHmIFEBZK9yoeC','Student','923193457488','0','students/profile.png','','','','','','2024-08-20 22:41:43','2024-11-09 23:00:16');
INSERT INTO users VALUES('797','1','0','Ayesha Younis ','19891334@logic.com','$2y$10$t4rFzxlvDS669uxz1oyIwuo8YvxJO4/X6EqEk1xK3dJCW7kccW4XO','Student','923144988694','0','students/profile.png','','','','','','2024-08-20 22:51:07','2024-11-09 22:59:48');
INSERT INTO users VALUES('798','1','0','AFIFA FATIMA ','83202960@logic.com','$2y$10$qFkzbtLVoUIgzReKSWPOPuYbnE1ufDu6fJ25S4JMrtXRJTu4sbyei','Student','923018407780','0','students/profile.png','','','','','','2024-08-20 22:59:02','2024-11-14 04:50:57');
INSERT INTO users VALUES('799','1','0','Khadija Bibi ','97226908@logic.com','$2y$10$Q.5fnbuN3DL1hZZf.Wq9U.7zULLDYOPm5AnZvpRLNAkKrS3/BP7Cm','Student','923303787068','0','students/profile.png','','','','','','2024-08-20 23:08:40','2024-11-09 23:02:24');
INSERT INTO users VALUES('800','1','0','Neelam Shahzadi','neelamshahzadi01234@gmail.com','$2y$10$MS00vRkJ1zYG0VV0oYo7dOTj/YVC65jb2Vm9t6AdIP5fp3bg8wnDW','Teacher','923427339379','1','teachers/profile.png','','','','','','2024-08-20 23:19:18','2024-08-20 23:19:18');
INSERT INTO users VALUES('801','1','0','Ayesha ','78254957@logic.com','$2y$10$SOaCpBqGziauGK7FSnFROebk/4IkDKW08zNJKvXKNZzkljdx5KdOm','Student','923155556516','0','students/profile.png','','','','','','2024-08-21 17:01:50','2024-11-09 22:59:23');
INSERT INTO users VALUES('802','1','0','Laiba Nadir Mazari ','80972803@logic.com','$2y$10$3BEnX52XFL3jsCf7HRgNG.iv2DcLFgeAoMmumkPuvSFHLsYsGIRTq','Student','923186686933','0','students/profile.png','','','','','','2024-08-21 17:16:16','2024-11-09 22:58:22');
INSERT INTO users VALUES('803','1','0','Huma Aimen ','41423436@logic.com','$2y$10$qZfwDjjdZL4PM/67IjBXkOKeG12gFonkdvZ0Xmrlm/gtuj5lInQsG','Student','923367902461','0','students/profile.png','','','','','','2024-08-21 17:24:04','2024-11-09 22:59:37');
INSERT INTO users VALUES('804','1','0','Lubna Rehman ','40104061@logic.com','$2y$10$NbYEdc7AywuC3o8vZzPE..8u3nTwm8vHqoko6UF3OuL2Fi69paYHO','Student','923015851823','0','students/profile.png','','','','','','2024-08-21 18:49:50','2024-11-09 22:59:11');
INSERT INTO users VALUES('805','1','0','Aqsa Mehreen ','2302293@logic.com','$2y$10$ueBfV05rcXtullfRLJ0rQOkNrZNhZm8yvXpFAtQ5Po7XIbhNSC9YG','Student','923165196344','0','students/profile.png','','','','','','2024-08-21 18:59:22','2024-11-09 23:00:58');
INSERT INTO users VALUES('821','1','0','Khadija Iftikhar ','8032228@logic.com','$2y$10$w8M5VPoH2T4Voty89j0QVeFr1YMMMaFa8aBEi6AntCdVAoyldfWZK','Student','923094248136','1','students/profile.png','','','','','','2024-08-29 14:16:25','2025-01-22 14:27:19');
INSERT INTO users VALUES('820','1','0','Shehrbano Abbas ','43447281@logic.com','$2y$10$SCKdYms/yMq6hG17Xf4Pd.LncAaXN/bi1U15rhA7JIQx4yWmYP7Jm','Student','923333742203','0','students/profile.png','','','','','','2024-08-27 16:51:34','2024-11-09 23:00:34');
INSERT INTO users VALUES('819','1','0','Ahlam ','62320126@logic.com','$2y$10$MT5jIdmGZwiRsx4.f3ck3.0lTpJecrui9Hz5N.ORhVw0ejZHldUZq','Student','923493103680','0','students/profile.png','','','','','','2024-08-27 16:46:05','2024-11-09 23:01:39');
INSERT INTO users VALUES('818','1','0','Aneeza ','47393654@logic.com','$2y$10$p6v21u5y4q6lOPJqH0ViY.XS4o6yKmE4G6jTX/BBYMR.HefK5Ft5O','Student','923027657697','0','students/profile.png','','','','','','2024-08-27 16:20:25','2024-11-09 22:56:59');
INSERT INTO users VALUES('817','1','0','Zoha ','12813150@logic.com','$2y$10$dbuXk8edxPN5HotA5aAHbOy6evA/NKczI0jb5abImBQdUyPq5Ly6y','Student','923255868858','0','students/profile.png','','','','','','2024-08-23 19:48:58','2024-11-09 23:01:24');
INSERT INTO users VALUES('816','1','0','Sana ','38305590@logic.com','$2y$10$TpKtVrJ1K3zwW8KouIo42.tm8gc3uhpYJmQpO329C5JbBgBNQslYq','Student','923058693588','0','students/profile.png','','','','','','2024-08-23 19:43:51','2024-11-09 23:03:20');
INSERT INTO users VALUES('815','1','0','Tooba Bukhari ','4979356@logic.com','$2y$10$DHXYa1TvP/3XizNRrDrgHOPVkgRcrcwp1x6J.5NbtO5DMs7ZhGTV.','Student','923556014466','0','students/profile.png','','','','','','2024-08-23 19:39:21','2024-11-09 23:03:34');
INSERT INTO users VALUES('814','1','0','Samina Maryam ','96578638@logic.com','$2y$10$5WfZZtp4M9WY4qY8TdWrKujmt4Ye0BVeof3AejVwgpYEE3fJ67EPe','Student','923415399844','0','students/profile.png','','','','','','2024-08-23 15:26:57','2024-11-09 22:57:51');
INSERT INTO users VALUES('813','1','0','Duaa Altaf ','45289767@logic.com','$2y$10$uw2lBoSOmPrciVuLDLEx2OS/JunpcsQF0FxLiGSgfMguVmMKhNZIO','Student','923421652888','0','students/profile.png','','','','','','2024-08-22 18:49:22','2024-11-09 23:03:46');
INSERT INTO users VALUES('812','1','0','Muneeza ','10105400@logic.com','$2y$10$fOamDnw78Q3z/nv2WVhiw.IZrmTAUAi5s8WaPYSZLuARebZzb4v1G','Student','923027657697','0','students/profile.png','','','','','','2024-08-22 18:36:22','2024-11-09 23:02:40');
INSERT INTO users VALUES('811','1','0','Imama ','28555293@logic.com','$2y$10$.yu0rpqR2mJxt.AySnJtpu8Y6WhES3GedCU58s1mHQ2oMZvYhq49a','Student','923099589116','0','students/profile.png','','','','','','2024-08-22 15:48:14','2024-11-09 22:58:09');
INSERT INTO users VALUES('810','1','0','Imamma Zahir ','80029821@logic.com','$2y$10$W2/uNB4hSx3jL07xtSL07.OTVWpib8eBbiD9CBqBsxiewCFZg16KG','Student','923285691190','0','students/profile.png','','','','','','2024-08-22 15:41:41','2024-11-09 23:02:58');
INSERT INTO users VALUES('809','1','0','Saleha Ishfaq ','2317421@logic.com','$2y$10$F2u/X5tJPCUVeMcponPYtub/BsdM4sefanABcw1IAGwIM7S9xN5zS','Student','923150674953','0','students/profile.png','','','','','','2024-08-22 15:36:03','2024-11-09 22:58:34');
INSERT INTO users VALUES('808','1','0','Malaika Ahsan ','67086466@logic.com','$2y$10$RkcPHGemEzEmwBH8eWNC.ugJaaP8hdZS6.TONHP9EqspMyRQPZcoG','Student','923134755536','0','students/profile.png','','','','','','2024-08-22 15:30:09','2024-11-09 23:00:00');
INSERT INTO users VALUES('807','1','0','Misbah ','56671398@logic.com','$2y$10$WoNrJTT32o/afJgeSjhyxejzdzEZX1d1iHmHUkmhua03NnhLxx7F.','Student','923110674953','0','students/profile.png','','','','','','2024-08-22 14:04:40','2024-11-09 22:57:16');
INSERT INTO users VALUES('806','1','0','Laveeza Arif ','26042659@logic.com','$2y$10$Fb/7sq2Hy6pM/u5PAD38kOub7P.u4mq6sMfCVHBw9.aKZ77poOSAy','Student','923355565603','0','students/profile.png','','','','','','2024-08-22 13:21:57','2024-11-09 23:01:57');
INSERT INTO users VALUES('825','1','0','SALEHA ZULFIQAR ','22380344@logic.com','$2y$10$Ssiz6HnlrxPpOSWmjCIAZuwbktYkRWROiFDUtK1Mq/FAKSRhyW0Om','Student','923196543459','1','students/profile.png','','','','','','2024-11-10 21:38:08','2024-11-10 21:38:08');
INSERT INTO users VALUES('826','1','0','ZAINAB MURTAZA ','27952886@logic.com','$2y$10$RhukLG1EcxI6H6G3EkWmXeabkSPiJeaI/409mSNUDOD6zf5xU6umq','Student','923484218728','1','students/profile.png','','','','','','2024-11-10 21:58:13','2024-11-10 21:58:13');
INSERT INTO users VALUES('827','1','0','JAYSHA WASEEM ','54246305@logic.com','$2y$10$G8cEG4dG/COucbW/QVfKrOW4Eo/GBZIKVkKeR9qbkZ24iWftEb4P6','Student','923256101686','1','students/profile.png','','','','','','2024-11-10 22:09:17','2024-11-10 22:09:17');
INSERT INTO users VALUES('828','1','0','MARYAM AZHAR ','52298607@logic.com','$2y$10$luw2XqlLEVxaGXuoJoRY/OERLEF1SHV7m/G5ohp6.oSf4crEaNaVW','Student','923365658944','1','students/profile.png','','','','','','2024-11-10 22:15:39','2024-11-10 22:15:39');
INSERT INTO users VALUES('829','1','0','ASFIYA NOOR ','62228974@logic.com','$2y$10$6h4cZrhU31h4pWfXJWbcI.k2R7rCcoXH7Q7G6SUPOAHRlHGCAIui6','Student','923209156828','1','students/profile.png','','','','','','2024-11-10 22:37:07','2024-11-10 22:37:07');
INSERT INTO users VALUES('830','1','0','ANSHARA ZAHOOR ','90655870@logic.com','$2y$10$h58xIK3rBusC2Pk8AtIUh.zQV344nBTwHurww.lRV0JT8h4k5jPZC','Student','923021208901','1','students/profile.png','','','','','','2024-11-10 23:07:32','2024-11-10 23:07:32');
INSERT INTO users VALUES('831','1','0','FIZA SAQIB ','20409271@logic.com','$2y$10$JGfFzjLqxljBCeuIK05MHOrRoL.j4T.ZebCRzz8MsTAf97vYijXFm','Student','923315722494','1','students/profile.png','','','','','','2024-11-10 23:13:30','2024-11-10 23:13:30');
INSERT INTO users VALUES('832','1','0','NOOR-UL-AIN ','20846641@logic.com','$2y$10$JIA2EoL6wtMboIcpNDDna.n7JVNfj87EjsTJ1TRwzj.FS6RIZ7xyW','Student','923127464440','1','students/profile.png','','','','','','2024-11-10 23:18:57','2024-11-10 23:18:57');
INSERT INTO users VALUES('833','1','0','AQSA SHABIR ','91578984@logic.com','$2y$10$jfJBy1hB1mbps0YnGhBeEOtENS2uWjJR4pQWMiz1lyHPxR5fjp.R6','Student','923427244604','1','students/profile.png','','','','','','2024-11-10 23:28:46','2024-11-10 23:28:46');
INSERT INTO users VALUES('834','1','0','LAIBA KHATAK ','22645749@logic.com','$2y$10$ZCGelt3imzt54FxWhNfDoO5VjbBKq..uWbS2/zb2ylE/igJA9Tx0q','Student','923048690071','1','students/profile.png','','','','','','2024-11-10 23:35:19','2024-11-10 23:35:19');
INSERT INTO users VALUES('835','1','0','MARIA NAZIR ','31077350@logic.com','$2y$10$jn1BLHPXQQy/diTag0Fa9OvUImjDnPiNlWlv6lu5XOvxq2P0w4dwK','Student','923071678830','1','students/profile.png','','','','','','2024-11-10 23:40:03','2024-11-10 23:40:03');
INSERT INTO users VALUES('836','1','0','NIMRA SHAFQAT ','72751538@logic.com','$2y$10$akXwu.RjWnlas08Ssq/tVe/fnFs1yTPIODSCL.IPxDXPmyf76hJEG','Student','923262035430','1','students/profile.png','','','','','','2024-11-10 23:44:04','2024-11-10 23:44:04');
INSERT INTO users VALUES('837','1','0','SANA SADIQ ','34310126@logic.com','$2y$10$QyhWlm5Dtb1g2bs8CXuhHuHt7fVkHQ8JzeLi5PUzngISkAZ9Jk5dS','Student','923037402790','1','students/profile.png','','','','','','2024-11-10 23:50:53','2024-11-10 23:50:53');
INSERT INTO users VALUES('838','1','0','SYEDA MAHEEN ZALRA ','41790274@logic.com','$2y$10$C9HGwmRT1NMV0uptQnFveOXXQQP81jQqpVz3k2ol8A4rkITT.VFu.','Student','92323509905','1','students/profile.png','','','','','','2024-11-11 00:04:25','2024-11-11 00:04:25');
INSERT INTO users VALUES('839','1','0','HASEENA SAFDAR ','46273862@logic.com','$2y$10$b5cwx1JmpazwhBUIO6HdPOVvCSSS.Au1IZTlmNeQ8T5T5a1jzYE.i','Student','923324273362','1','students/profile.png','','','','','','2024-11-11 00:17:44','2024-11-11 00:17:44');
INSERT INTO users VALUES('840','1','0','NOOR FATIMA ','85342393@logic.com','$2y$10$BXsn5UmQcbqi7bwYw6FZqu68cXHA0yQpsjj0EqgTH5Rb1T.vLlSH.','Student','923026566119','1','students/profile.png','','','','','','2024-11-11 00:22:56','2024-11-11 00:22:56');
INSERT INTO users VALUES('841','1','0','BUSHRA ','80275055@logic.com','$2y$10$GV2s2u76wpW20ST2ckPu7OYyqwrZYr0C8/jgU/Tq5pJXcVJljCROW','Student','923217399325','1','students/profile.png','','','','','','2024-11-11 00:27:56','2024-11-11 00:27:56');
INSERT INTO users VALUES('842','1','0','NOOR-UL-HUDA ','21620270@logic.com','$2y$10$SAmDdjkxWXSAcc5Cd9Amhe02auopvr0ekcuCM/6VENN6Ltt6fHp.2','Student','923020985522','1','students/profile.png','','','','','','2024-11-11 00:32:36','2024-11-11 00:32:36');
INSERT INTO users VALUES('843','1','0','SURAIYA BANO ','50036793@logic.com','$2y$10$l71LSz0V5XOnoufG3uxAJOfoigKAbqX9ktBTKDxnLIyWzs1WMUrai','Student','923498906495','1','students/profile.png','','','','','','2024-11-11 00:38:46','2024-11-11 00:38:46');
INSERT INTO users VALUES('844','1','0','SABA RIAZ ','83283399@logic.com','$2y$10$n0e2.ioz/t04Div0fhLR/OjUokUvO4sPpZ6tfaZBZjn6FgO5PyLU2','Student','923007554262','1','students/profile.png','','','','','','2024-11-11 00:44:30','2024-11-11 00:44:30');
INSERT INTO users VALUES('845','1','0','MAHNOOR SHAHID ','20201@logic.com','$2y$10$o4BXTbCfHnsYT8WPSlhqcu.CgWb6yUi2rjRPdVLEenEoUT1zZdLL6','Student','923159972444','1','students/profile.png','','','','','','2024-11-11 00:48:20','2025-01-22 14:29:40');
INSERT INTO users VALUES('846','1','0','MAHNOOR SHAHID ','30346998@logic.com','$2y$10$vW7i8XLjwF9tSaC5qV6sIORlmuTMXTL/LQh/Rg7D5nBBFuk2qQsYe','Student','923159972444','1','students/profile.png','','','','','','2024-11-11 00:49:14','2024-11-11 00:49:14');
INSERT INTO users VALUES('847','1','0','SHEHZADI EMAAN FATIMA ','33063067@logic.com','$2y$10$9O1PLffVcHlqwA73PnL4NOV3o6ZrEtIExmS4jzZUpW34ViMAS3/Xa','Student','923118859410','1','students/profile.png','','','','','','2024-11-11 01:03:47','2024-11-11 01:03:47');
INSERT INTO users VALUES('848','1','0','SAYEDA LAIBA BUKHARI ','18309047@logic.com','$2y$10$NaB9WoX3.gG00Q2WGi2fAevjZ009fn/nPSeX4/MdgN0daoO3rUP/e','Student','923028787509','1','students/profile.png','','','','','','2024-11-11 01:06:40','2024-11-11 01:06:40');
INSERT INTO users VALUES('849','1','0','ALISHBA KANWAL ','3760646@logic.com','$2y$10$oEUop4zITBdzU5wn5Y5DPuTPopd3FC5ag/ZSUB8ts2CbSKl9spf1C','Student','92304679424','1','students/profile.png','','','','','','2024-11-11 01:13:07','2024-11-11 01:13:07');
INSERT INTO users VALUES('850','1','0','HINA ZAHRA ','10076622@logic.com','$2y$10$y.EDSNy0ckuPhVCkrlU8CeqfdwkD8ssQQK5INv82dW5.5A8Q/viZG','Student','923481233119','1','students/profile.png','','','','','','2024-11-11 01:23:27','2024-11-11 01:23:27');
INSERT INTO users VALUES('851','1','0','TAHIRA MUMTAZ ','62556963@logic.com','$2y$10$rzcsQWCQQp.SoAoPkQDms.COYWtmvsJk7TbeSMCm862YHHYMMh762','Student','923150160454','1','students/profile.png','','','','','','2024-11-11 01:35:40','2024-11-11 01:35:40');
INSERT INTO users VALUES('852','1','0','EISHA JUNEJO ','53501306@logic.com','$2y$10$9.IDKEgTBt8VHKa.rmLE1ORYqaZ0DS703fUvAn1GN3GrM6.MAEaOG','Student','923173766534','1','students/profile.png','','','','','','2024-11-11 01:43:07','2024-11-11 01:43:07');
INSERT INTO users VALUES('853','1','0','FARYAL FATIMA ','35219385@logic.com','$2y$10$DEUeIth8RhU3H1SBd7rxAea/CMn6AxPuBMuI0/iFPknc2GSHoPnd2','Student','923441001002','0','students/profile.png','','','','','','2024-11-11 01:53:36','2024-11-14 03:15:46');
INSERT INTO users VALUES('854','1','0','FARYAL FATIMA ','35219386@logic.com','$2y$10$r/uTi2OmEB276t.16S8FQebFhWOpIFgkOGrUAhP9OWJyOTWn9vkwC','Student','923441001002','0','students/profile.png','','','','','','2024-11-11 01:55:14','2024-11-20 16:31:41');
INSERT INTO users VALUES('855','1','0','FARYAL FATIMA ','35219390@logic.com','$2y$10$QohRal5fsdRYZ22FPjaF7.0HU/oRRYRW032J691curdt.QBWFlH/C','Student','923441001002','1','students/profile.png','','','','','','2024-11-11 01:55:59','2024-11-11 01:55:59');
INSERT INTO users VALUES('856','1','0','TANZEELA KHAN ','89941014@logic.com','$2y$10$UDRXcRciBa6PPEHBQoEeNewWTsvxJ0LCXbvuZFv9Xp.5b/iAwoGHO','Student','923443247175','1','students/profile.png','','','','','','2024-11-11 02:00:07','2024-11-11 02:00:07');
INSERT INTO users VALUES('857','1','0','ZEBA AWAN ','28105188@logic.com','$2y$10$3ZZLEl8Nnyl/d6d81Kb3EecUBjKAAVn/bD.EwSmcS/5wdP15e2IO.','Student','923421972991','1','students/profile.png','','','','','','2024-11-11 02:02:48','2024-11-11 02:02:48');
INSERT INTO users VALUES('858','1','0','ANVISHA HAMEED ','74551754@logic.com','$2y$10$VecTGMFx0f88hgYo8Bpabu57bYFzCr5v9x1d.8qJzVQitZ8B6r3He','Student','923119733181','1','students/profile.png','','','','','','2024-11-11 02:09:02','2024-11-11 02:09:02');
INSERT INTO users VALUES('859','1','0','IMAAN FATIMA ','45252074@logic.com','$2y$10$tcQxc3N9ut0Tfng77wfZheK0TXSvRTY0uBSNE6uRRqXtb91qa1YK2','Student','923334479123','1','students/profile.png','','','','','','2024-11-11 02:15:58','2024-11-11 02:15:58');
INSERT INTO users VALUES('860','1','0','HAFSA ABID ','42449566@logic.com','$2y$10$Kjgdy1s.UUaSKp.iLp3iyuL3pqmLU2anfc2x0ZBkYZu4iuETEtpVu','Student','923008757351','1','students/profile.png','','','','','','2024-11-11 02:32:31','2024-11-11 02:32:31');
INSERT INTO users VALUES('861','1','0','NOOR FATIMA AGHA ','95483590@logic.com','$2y$10$KVT/bVOvs6G/Mz4cqvUa4.M.ZH0dlZ8APhQHweKGd5QSdWG63Nm82','Student','923168922807','1','students/profile.png','','','','','','2024-11-11 02:43:29','2024-11-11 02:43:29');
INSERT INTO users VALUES('862','1','0','RANIA ASGHAR ','3612360@logic.com','$2y$10$L23bsBFfKoo/zTB/6vtCWO.qiBovCBYfXXJLtRs7o7dtgIZ7dM8Sa','Student','923169179310','1','students/profile.png','','','','','','2024-11-11 02:53:38','2024-11-11 02:53:38');
INSERT INTO users VALUES('863','1','0','NABEHA FATIMA ','86523660@logic.com','$2y$10$zec.p.btAfMiWMvoLWB8NuOY9CzVHc11LUyxpVufpMTA0n.DCH.ru','Student','923061859571','1','students/profile.png','','','','','','2024-11-11 03:11:01','2024-11-11 03:11:01');
INSERT INTO users VALUES('864','1','0','SANIA SAEED ','37162356@logic.com','$2y$10$qjXCPQNEhJPGOa53jlSjYOI11eZeMJhoEC7xjuTyvFMQwOgY0vPH2','Student','923199476471','1','students/profile.png','','','','','','2024-11-11 03:20:07','2024-11-11 03:20:07');
INSERT INTO users VALUES('865','1','0','MOMINA NAQVI ','23756753@logic.com','$2y$10$P4aHIzWGzxwb9W2Jc26Y4euSRpjfa/ATPOC4EKthU1yxkF69XMdh.','Student','923465142877','1','students/profile.png','','','','','','2024-11-12 03:57:25','2024-11-12 03:57:25');
INSERT INTO users VALUES('866','1','0','MAHNOOR ','30407319@logic.com','$2y$10$6pXeaBFe5p8Ab1rsQz1DHuicL5sJ.X76h1X9uyMeuupEmiiqQ1ixO','Student','923063495098','1','students/profile.png','','','','','','2024-11-12 04:09:28','2024-11-12 04:09:28');
INSERT INTO users VALUES('867','1','0','HINA NAEEM ','10040378@logic.com','$2y$10$BkGPAG02LUzBA9W5jfnm9ewvndQI0i2NSdxvIQLik.Ihe2yiJ9MVG','Student','923061620121','1','students/profile.png','','','','','','2024-11-12 04:19:24','2024-11-12 04:19:24');
INSERT INTO users VALUES('868','1','0','ALIZA ZAFAR ','8464203@logic.com','$2y$10$5YdjGEVvt7nVjwcJHn5YZezfYu8FqORaeKuByepwFOJif8.rPSyRq','Student','923044199939','1','students/profile.png','','','','','','2024-11-12 04:26:20','2024-11-12 04:26:20');
INSERT INTO users VALUES('869','1','0','ARSHIA NOOR ','9757676@logic.com','$2y$10$Ud.l3L9JaeIbKCuQf.h4/e49IkZZ62SQxFvL1cH9fawR6n2.kpcqu','Student','923466204808','1','students/profile.png','','','','','','2024-11-12 04:39:07','2024-11-14 05:20:44');
INSERT INTO users VALUES('870','1','0','LAIBA JALAL ','9757683@logic.com','$2y$10$1j1gXwBsjSV7c192XQWgce5XIPjmT.KJOJ48YWTKggDI8dmvGy4Ti','Student','923489036025','1','students/profile.png','','','','','','2024-11-12 04:51:08','2024-11-12 04:51:08');
INSERT INTO users VALUES('871','1','0','RAMEEN ISHAQ ','56852654@logic.com','$2y$10$ppTj5JPB7Js4Y8qFUvAZd.71QVXyyUjkSWeN.YXJJFYrvrdCM8ozu','Student','923283844447','1','students/profile.png','','','','','','2024-11-12 05:05:22','2024-11-12 05:05:22');
INSERT INTO users VALUES('872','1','0','ZAINAB ','73416816@logic.com','$2y$10$9X.iE7bs1rdZ7pategST4OUgxYGVWY0gr7B6W7ReHTiKqh2UAiMEy','Student','923237813727','1','students/profile.png','','','','','','2024-11-12 05:09:16','2024-11-12 05:09:16');
INSERT INTO users VALUES('873','1','0','MALIAKA AKRAM ','75015952@logic.com','$2y$10$Nmi3yjdqY0/UFHDx6RJclOB6Fm5Yg.juUAU2WjtWRZlveQ7cHhqTu','Student','92300681248','1','students/profile.png','','','','','','2024-11-12 05:13:36','2024-11-12 05:13:36');
INSERT INTO users VALUES('874','1','0','INSHA KHAN ','73989040@logic.com','$2y$10$2vCfwefFuHILMZsKugo/LeHQKvOgIZ.v1FFdR2d5ygYwy6DRCWWGC','Student','923275760449','1','students/profile.png','','','','','','2024-11-12 05:46:03','2024-11-12 05:46:03');
INSERT INTO users VALUES('875','1','0','MARRIUM WAJAHAT ','94714224@logic.com','$2y$10$Ukqkz.nNLGMCkCddgWBPdupjvCtkDzfzYAG3Eq.yLSXYEQx6EkocC','Student','923186849587','0','students/profile.png','','','','','','2024-11-12 05:58:25','2024-11-21 10:50:52');
INSERT INTO users VALUES('876','1','0','MARRIUM WAJAHAT ','94714227@logic.com','$2y$10$U7b/.DnmA0gVKX5Yv2bS4uub/4Misf9kY9dKp.eiiCpg118n5pgEe','Student','923186849587','1','students/profile.png','','','','','','2024-11-12 05:59:47','2024-11-12 05:59:47');
INSERT INTO users VALUES('877','1','0','AIMEN NADEEM ','32409963@logic.com','$2y$10$Qm/HQog8T49zL6/DTnXolOk/uNbniHfAnY/gfdN5hZovjRlzE1Zca','Student','923056144587','1','students/profile.png','','','','','','2024-11-14 02:52:15','2024-11-14 05:26:09');
INSERT INTO users VALUES('878','1','0','ZAINAB NOOR ','32409967@logic.com','$2y$10$eMJSVdUSKJFHFs0TCPq6TOTdHnLkTqY6yvgt3JxGJX0sQ.bkzAi1a','Student','923485878855','1','students/profile.png','','','','','','2024-11-14 02:53:16','2024-11-14 02:53:16');
INSERT INTO users VALUES('879','1','0','AIN-UL-NOOR ','88423605@logic.com','$2y$10$7.sjIYmyGGqoGLqc8NFFVu3Slam9lNWLVRATHAdtWd7S204Q7znLe','Student','923412313242','1','students/profile.png','','','','','','2024-11-14 02:59:02','2024-11-14 02:59:02');
INSERT INTO users VALUES('880','1','0','SIMRITY SINGH CHOPRA ','31507525@logic.com','$2y$10$BNVYnRJPrlPCEmTVA6IB5uZZGru5C3JuZsD84nQyKQ06SxIRTzsVa','Student','923185099679','1','students/profile.png','','','','','','2024-11-14 03:07:22','2024-11-14 03:07:22');
INSERT INTO users VALUES('881','1','0','AMNA BIBI ','31878079@logic.com','$2y$10$ObGDuugHq5hE7JDjOGFpyuym1GQPCYi6ejt9wrpiJFVrkr/zh7CgC','Student','923259552562','1','students/profile.png','','','','','','2024-11-14 03:10:15','2024-11-14 03:10:15');
INSERT INTO users VALUES('882','1','0','SANIA AKHTAR ','40585050@logic.com','$2y$10$dZbpQ9pR3KYDI8rNXez2FegHmdd4T2f80o6KuU61Hjfqb9IzDKUcC','Student','923085838625','1','students/profile.png','','','','','','2024-11-14 03:27:22','2024-11-14 03:27:22');
INSERT INTO users VALUES('883','1','0','AROOBA ANJUM ','49881606@logic.com','$2y$10$BG2N5fTuz/ZzTJiA81ESm.O1hmAlYJCsYP9z44YcWEz4dJUMHu02G','Student','923338737959','1','students/profile.png','','','','','','2024-11-14 03:33:27','2024-11-14 03:33:27');
INSERT INTO users VALUES('884','1','0','FATIMA NADEEM ','7028384@logic.com','$2y$10$ApcgYEaNRJSX5lXxKxluouop/YMcV0oHhprGrgozq3lEygqZFIjta','Student','923117714911','0','students/profile.png','','','','','','2024-11-14 03:37:06','2024-11-18 18:38:50');
INSERT INTO users VALUES('885','1','0','FATIMA NADEEM ','7028388@logic.com','$2y$10$8JHzE1WSDbrDOceEuA1K3uyLmIJomQ/af6e1m0cSwq9RoRyIfjK9C','Student','923117714911','1','students/profile.png','','','','','','2024-11-14 03:38:11','2024-11-14 03:38:11');
INSERT INTO users VALUES('886','1','0','HINA KHAN ','61559124@logic.com','$2y$10$CCamYpwiqCTPPesOcr8FlOegZCT8Rn3bKtNWK/i/gu779X40g1Jpy','Student','923405613025','1','students/profile.png','','','','','','2024-11-14 03:44:49','2024-11-14 03:44:49');
INSERT INTO users VALUES('887','1','0','WANIAH MARYAM ','16468796@logic.com','$2y$10$jLGtkUiwbDfQrLESajXs5ujPTQyr/SnuUN1OBbXT3nR91/8DbsapG','Student','923364209008','1','students/profile.png','','','','','','2024-11-14 04:11:46','2024-11-14 04:11:46');
INSERT INTO users VALUES('888','1','0','MALEEHA RIZWAN ','85748515@logic.com','$2y$10$PdMhzFgmLqDlwGv8rVGnROYR/5jskiazEAqwCmqB6WOI.y4YfqFc2','Student','923249862719','1','students/profile.png','','','','','','2024-11-14 04:24:47','2024-11-14 04:24:47');
INSERT INTO users VALUES('889','1','0','ANEEZA ABRAR ','38922300@logic.com','$2y$10$r0NCYE9M.FtyZ1ljbDDDHuHF6bdkJFLtQaQ.UvDhM0LwzUfJW3rR.','Student','023042756345','1','students/profile.png','','','','','','2024-11-21 12:47:57','2024-11-21 12:47:57');
INSERT INTO users VALUES('890','1','0','MOMINA NAQVI ','69785911@logic.com','$2y$10$mCwOpv8fu.ae9YeL3u5hJ.yWrTEGasJaFe4Iwyjhi7KLBmul6BF1K','Student','023465142877','1','students/profile.png','','','','','','2024-11-21 14:47:59','2024-11-21 14:47:59');
INSERT INTO users VALUES('891','1','0','MARYAM NOOR ','70983123@logic.com','$2y$10$srI.rwoSOrq7Uq8Sk98kD.OiSHCyjJjzG0e1tbHWntL4vrwjijd6u','Student','923251710364','1','students/profile.png','','','','','','2024-12-01 08:11:11','2024-12-01 08:11:11');
INSERT INTO users VALUES('892','1','0','NOOR-UL-AIN ','15068492@logic.com','$2y$10$DpfUl1Dj9HEFpfRa432IeuX9iSCTPX.RK9D6nVoySm26ZBCOe0PMu','Student','923197499919','1','students/profile.png','','','','','','2024-12-01 08:20:58','2024-12-01 08:20:58');
INSERT INTO users VALUES('893','1','0','HARRAM ','49228192@logic.com','$2y$10$gJM3W8k4N0i1Pjv6X/rM6.BVmu5oZGasaflJRXZl6pj8AuiRXMOla','Student','923443256084','1','students/profile.png','','','','','','2024-12-01 08:40:41','2024-12-01 08:40:41');
INSERT INTO users VALUES('894','1','0','SANIA NISAR ','36992212@logic.com','$2y$10$XovucFaB8lcKgrDXUXWx2uHXgTJ/M0FJUm6sBXZvLz.0Wf3QdTFs.','Student','923177656292','1','students/profile.png','','','','','','2024-12-01 11:22:13','2024-12-01 11:22:13');
INSERT INTO users VALUES('895','1','0','DR ESHA ','52287217@logic.com','$2y$10$aiSwnWYE087zJg/UgfVG0uVhwsaIU9K/r3VNTBNhfYukQZSPpZ.di','Student','020000000000','1','students/profile.png','','','','','','2024-12-01 11:25:25','2024-12-01 11:25:25');
INSERT INTO users VALUES('896','1','0','SEEMAB AHMAD ','55799683@logic.com','$2y$10$mW7FKBP1BBvoosAoglrXKeCStKpOfgn0O.qZoVbMwBOzkoRDrheVC','Student','923016135160','1','students/profile.png','','','','','','2024-12-01 11:28:48','2024-12-01 11:28:48');
INSERT INTO users VALUES('897','1','0','EBRAR  BERIKA ','75369716@logic.com','$2y$10$.Diuxujf0fx1m5tr0vFUuudOFSX1hJVLmtVnmDh4FZDddmZ45XeW2','Student','525555555555','0','students/profile.png','','','','','','2024-12-01 11:37:16','2025-02-17 14:34:32');
INSERT INTO users VALUES('898','1','0','AYSE NUR ','64876615@logic.com','$2y$10$J4GzeLDWHDByPeeo65.KM.hf7SEqKcXLHeDAClFPxrrNTjs9BdaqO','Student','525555555555','0','students/profile.png','','','','','','2024-12-01 11:41:07','2025-02-17 14:35:06');
INSERT INTO users VALUES('899','1','0','HOORIAN ','90771832@logic.com','$2y$10$heY2.HDg5e3x/APffYQ1h.rcxDNvj.HsfzfrY5wGnHdnfmB31zFd6','Student','626666666666','1','students/profile.png','','','','','','2024-12-01 11:44:38','2024-12-01 11:44:38');
INSERT INTO users VALUES('900','1','0','KHADIJA ','84212106@logic.com','$2y$10$YSH1.wjg4QUxFew9oTfwhu7IC/j9UCRNuO1IDcI8FRPRJpIUG6b.K','Student','525555555555','1','students/profile.png','','','','','','2024-12-01 11:59:34','2024-12-01 11:59:34');
INSERT INTO users VALUES('901','1','0','MAHAM ','34586256@logic.com','$2y$10$vg2XxcG5LFO5WnS/RgGdMe2aLzMOI6bcU1aWwP6EUF5Sx64CAHBcK','Student','121111111111','1','students/profile.png','','','','','','2024-12-01 12:03:18','2024-12-01 12:03:18');
INSERT INTO users VALUES('902','1','0','AROONA ','90196982@logic.com','$2y$10$r/ufGxSYrLfNAp29RpPsjuB1F2IgVKLLLleQose4aWK2oLN7hY/cy','Student','323333333333','0','students/profile.png','','','','','','2024-12-01 14:05:38','2025-02-17 15:14:54');
INSERT INTO users VALUES('903','1','0','AYESHA SAJAAD ','71697168@logic.com','$2y$10$K.IfjmS5dXS5OPyFuygi/e3s5lnMjax8sWB0YEeEIj5Cf/IZw5FBu','Student','121111111111','0','students/profile.png','','','','','','2024-12-01 14:07:41','2025-02-17 15:15:34');
INSERT INTO users VALUES('904','1','0','ALEEZA ','80798607@logic.com','$2y$10$39ZVXzzgSok4o1I8dRlIYeAss6lkwqziw5KS3wgkL4TK3f4VHmwKW','Student','020000000000','1','students/1738241619.jpg','','','','','','2024-12-31 08:43:39','2025-01-30 12:53:39');
INSERT INTO users VALUES('905','1','0','DUA FATIMA ','consultant@logic.com','$2y$10$fa9WfbKzFMSesGLqNta9.OFFw3Wz4hX.MnGoQrKgDxhVFA9ZfaopC','Student','020000000000','1','students/1738235684.PNG','#','#','#','#','oUZGWtkXCiG823SPS8XSD6DUY4YPwshYZo2xG9gWm8bSlOKMcfJkS3rhkdAS','2024-12-31 08:56:00','2025-01-30 11:14:45');
INSERT INTO users VALUES('906','1','0','Sanaulla Salma','fatimasna@gmail.com','$2y$10$yQdUq0y8REuWNPPPQZZy9e.iAU40/EsraKCH7.RpOM.Axdh7r8EyW','Parent','03007632938','1','parents/profile.png','','','','','','2025-01-07 10:54:14','2025-01-07 10:54:14');
INSERT INTO users VALUES('907','1','0','Test Entery','default@hostelmanager.pk','$2y$10$./sxYmKcIthjc.iFFUMc7e1o3KhHjUI8OvNPq5l4SUITiS5jJc03e','Parent','10921092019','1','parents/profile.png','','','','','','2025-02-16 17:20:10','2025-02-16 17:20:10');
INSERT INTO users VALUES('908','1','0','Test ','62710267@logic.com','$2y$10$Q/H2E52AgGwRS404TjGeeORlngewFZAhP7fJxEgR7v2UFGlDp9eoe','Student','923003939393','1','students/profile.png','','','','','','2025-02-16 17:21:36','2025-02-16 17:21:36');
INSERT INTO users VALUES('909','1','0','AYESHA NASREEN ','24558182@logic.com','$2y$10$gcmurZF8/tllyJS6v6HBz.Jc597ZAbqTrCe.epmZb8x0d56CYd.m2','Student','023000097101','1','students/profile.png','','','','','','2025-02-17 11:24:43','2025-02-17 11:24:43');
INSERT INTO users VALUES('910','1','0','TOOBA IRFAN ','85428333@logic.com','$2y$10$NrxHJ./paPJRD3NMw95xaeM8okuLWstO9Akjqpg0ROCz2YS0mz43W','Student','923259307842','1','students/profile.png','','','','','','2025-02-17 11:34:29','2025-02-17 11:34:29');
INSERT INTO users VALUES('911','1','0','ISHAL IMRAN ','17757430@logic.com','$2y$10$P9AAGM1coTDqJefhKQvLEufYbL8.sRloq3mdqzgLpfTY/y9i9.I9W','Student','923098400449','1','students/profile.png','','','','','','2025-02-17 11:40:06','2025-02-17 11:40:06');
INSERT INTO users VALUES('912','1','0','DR RABIA AYOUB ','64716920@logic.com','$2y$10$yWVPawPvpZgD4mzx81oL0u/VxGYj5jjUxipVaQMRwzBgJkBVpKK.m','Student','923340004915','1','students/profile.png','','','','','','2025-02-17 11:43:53','2025-02-17 11:43:53');
INSERT INTO users VALUES('913','1','0','AREEBA NADEEM HASHMI ','31516293@logic.com','$2y$10$tv1W7xuijGDPNu3ozhQyWOCFykm7qHMnMA.9upHY9lHtazQ4Q5vNm','Student','923048532000','1','students/profile.png','','','','','','2025-02-17 11:53:03','2025-02-17 11:53:03');
INSERT INTO users VALUES('914','1','0','MAHRUKH ALI BAIG ','42260738@logic.com','$2y$10$wl4XFbDN5/YnBywXPOGvRu9cp7lf.wSm5dB7V.0e54U1CuAyu.XRq','Student','923452655089','1','students/profile.png','','','','','','2025-02-17 12:31:54','2025-02-17 12:31:54');
INSERT INTO users VALUES('915','1','0','MISBAH KARIM ','69455089@logic.com','$2y$10$JowbcwbbQQm8HDTmBcwW/.3IrfCDO/y1g3CGRD.3zFW5WocolhI0m','Student','923709539753','1','students/profile.png','','','','','','2025-02-17 12:56:56','2025-02-17 12:56:56');
INSERT INTO users VALUES('916','1','0','AYESHA SAJAD ','49473456@logic.com','$2y$10$yArEIzGxwqs.kkSmkIQkx.tOlP3wV.gnJrbD4pXkYon.HOXvKqyAC','Student','92311919716','1','students/profile.png','','','','','','2025-02-17 13:02:26','2025-02-17 13:02:26');
INSERT INTO users VALUES('917','1','0','SHUMAILA ISLAM ','24944525@logic.com','$2y$10$KwgASGCwmmuFxvHMIIhJq.1zHL3fVkiMDcD8na.wr6I5Vv4b2WRde','Student','923224193300','1','students/profile.png','','','','','','2025-02-17 13:20:17','2025-02-17 13:20:17');
INSERT INTO users VALUES('918','1','0','AYESHA WAJID ','31233938@logic.com','$2y$10$IK4Gp.K5qRpkU.mGH/F0Le1qFuJ.ZCr/jbxeGfo/uVl1IxLv5UISW','Student','923249575305','1','students/profile.png','','','','','','2025-02-17 13:45:25','2025-02-17 13:45:25');
INSERT INTO users VALUES('919','1','0','MAHAM MUMTAZ ','15298821@logic.com','$2y$10$5O4iT7GzNtl2lkzjW7Dm9O.ShybR5UoYyUyxyrt2qq3RTgslnIw1C','Student','923096510937','1','students/profile.png','','','','','','2025-02-17 13:55:03','2025-02-17 13:55:03');
INSERT INTO users VALUES('920','1','0','MARIYAM FATIMA ','9162377@logic.com','$2y$10$H5GpwIzreU/pPK0.d5SEm.6eH0ep1qDxfapp5SsAwrHcmZJyki7kC','Student','923333888470','1','students/profile.png','','','','','','2025-02-17 14:45:29','2025-02-17 14:45:29');
INSERT INTO users VALUES('921','1','0','DUR-E-SHAHWAR ','63942108@logic.com','$2y$10$MXFh5P6tinDk8ahtz4/pO.Fre.CxQTmqpNA8MnC/TK/b0h/h7Teya','Student','923336926951','1','students/profile.png','','','','','','2025-02-17 14:58:33','2025-02-17 14:58:33');
INSERT INTO users VALUES('922','1','0','AYESHA ADAN ','47407515@logic.com','$2y$10$vcueLSqz5pXxMj1BSos1uOo0dKSOqV3VgNdqyOV6FFFOmaBmrY2s.','Student','923007848995','1','students/profile.png','','','','','','2025-02-17 15:02:06','2025-02-17 15:02:06');
INSERT INTO users VALUES('923','1','0','HIRA IMTIAZ ','33177215@logic.com','$2y$10$L5v8Bo3.JBgDYbTtu5PoJ.Fn8pWKTGHT5oBP7gMpJNGUAmVFIoQbS','Student','923005496715','1','students/profile.png','','','','','','2025-02-17 15:34:32','2025-02-17 15:34:32');
INSERT INTO users VALUES('924','1','0','ANIQA IRSHAD ','55376175@logic.com','$2y$10$7lXFMdITejCSl4aA9kMIEOwdqdF.gfQWaOS7vqhZKZAeQZQVeiZBe','Student','923302121717','1','students/profile.png','','','','','','2025-02-17 15:41:14','2025-02-17 15:41:14');



DROP TABLE IF EXISTS website_languages;

CREATE TABLE `website_languages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `language` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




