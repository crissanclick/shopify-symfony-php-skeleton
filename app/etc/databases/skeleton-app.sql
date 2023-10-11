
CREATE TABLE `sessions` (
    `id` bigint unsigned NOT NULL AUTO_INCREMENT,
    `session_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `shop` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `is_online` tinyint(1) NOT NULL,
    `state` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    `scope` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `access_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `expires_at` datetime DEFAULT NULL,
    `user_id` bigint DEFAULT NULL,
    `user_first_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `user_last_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `user_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `user_email_verified` tinyint(1) DEFAULT NULL,
    `account_owner` tinyint(1) DEFAULT NULL,
    `locale` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `collaborator` tinyint(1) DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `sessions_session_id_unique` (`session_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
