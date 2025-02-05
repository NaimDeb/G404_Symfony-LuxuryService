CREATE TABLE `applicant`(
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `id_user` BIGINT NOT NULL,
    `gender_id` INT NOT NULL,
    `firstName` VARCHAR(255) NOT NULL,
    `lastName` VARCHAR(255) NOT NULL,
    `adress` VARCHAR(255) NOT NULL,
    `country` VARCHAR(255) NOT NULL,
    `nationality` VARCHAR(255) NOT NULL,
    `passportFilename` VARCHAR(255) NULL,
    `curriculumVitaeFilename` VARCHAR(255) NOT NULL,
    `profilPictureFilename` VARCHAR(255) NOT NULL,
    `currentLocation` VARCHAR(255) NOT NULL,
    `placeOfBirth` VARCHAR(255) NOT NULL,
    `availibility` BOOLEAN NOT NULL,
    `category_id` INT NOT NULL,
    `experience` VARCHAR(255) NOT NULL,
    `shortDescription` VARCHAR(255) NOT NULL,
    `notes` TEXT NULL,
    `createdAt` DATETIME NOT NULL,
    `updatedAt` DATETIME NULL,
    `deletedAt` DATETIME NULL
);
CREATE TABLE `jobOffer`(
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `id_client` BIGINT NOT NULL,
    `description` VARCHAR(255) NOT NULL,
    `jobTitle` VARCHAR(255) NOT NULL,
    `jobType` VARCHAR(255) NOT NULL,
    `location` VARCHAR(255) NULL,
    `category_id` INT NOT NULL,
    `salary` BIGINT NOT NULL,
    `createdAt` DATETIME NOT NULL,
    `isActive` BOOLEAN NOT NULL,
    `notes` TEXT NOT NULL
);
ALTER TABLE
    `jobOffer` ADD INDEX `joboffer_id_client_index`(`id_client`);
CREATE TABLE `jobApplication`(
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `offer_id` BIGINT NOT NULL,
    `applicant_id` BIGINT NOT NULL,
    `createdAt` DATETIME NOT NULL,
    `deletedAt` DATETIME NULL
);
ALTER TABLE
    `jobApplication` ADD INDEX `jobapplication_offer_id_index`(`offer_id`);
ALTER TABLE
    `jobApplication` ADD INDEX `jobapplication_applicant_id_index`(`applicant_id`);
CREATE TABLE `user`(
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `email` VARCHAR(255) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `role` JSON NOT NULL
);
ALTER TABLE
    `user` ADD UNIQUE `user_email_unique`(`email`);
CREATE TABLE `client`(
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `user_id` BIGINT NOT NULL,
    `companyName` VARCHAR(255) NOT NULL,
    `activityType` VARCHAR(255) NOT NULL,
    `job` VARCHAR(255) NOT NULL,
    `phoneNumber` VARCHAR(255) NOT NULL,
    `notes` TEXT NULL
);
ALTER TABLE
    `client` ADD INDEX `client_user_id_index`(`user_id`);
CREATE TABLE `jobCategory`(
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL
);
CREATE TABLE `gender`(
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL
);
ALTER TABLE
    `applicant` ADD CONSTRAINT `applicant_gender_id_foreign` FOREIGN KEY(`gender_id`) REFERENCES `gender`(`id`);
ALTER TABLE
    `jobApplication` ADD CONSTRAINT `jobapplication_offer_id_foreign` FOREIGN KEY(`offer_id`) REFERENCES `jobOffer`(`id`);
ALTER TABLE
    `jobOffer` ADD CONSTRAINT `joboffer_id_client_foreign` FOREIGN KEY(`id_client`) REFERENCES `client`(`id`);
ALTER TABLE
    `applicant` ADD CONSTRAINT `applicant_id_user_foreign` FOREIGN KEY(`id_user`) REFERENCES `user`(`id`);
ALTER TABLE
    `applicant` ADD CONSTRAINT `applicant_category_id_foreign` FOREIGN KEY(`category_id`) REFERENCES `jobCategory`(`id`);
ALTER TABLE
    `client` ADD CONSTRAINT `client_user_id_foreign` FOREIGN KEY(`user_id`) REFERENCES `user`(`id`);
ALTER TABLE
    `jobApplication` ADD CONSTRAINT `jobapplication_applicant_id_foreign` FOREIGN KEY(`applicant_id`) REFERENCES `applicant`(`id`);
ALTER TABLE
    `jobOffer` ADD CONSTRAINT `joboffer_category_id_foreign` FOREIGN KEY(`category_id`) REFERENCES `jobCategory`(`id`);