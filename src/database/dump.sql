CREATE TABLE
    `users`(
        `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
        `admin` TINYINT NOT NULL,
        `username` VARCHAR(255) NOT NULL,
        `email` VARCHAR(255) NOT NULL,
        `password` VARCHAR(255) NOT NULL,
        `created_at` TIMESTAMP NOT NULL,
        PRIMARY KEY (`id`)
    );

CREATE TABLE
    IF NOT EXISTS `posts` (
        `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
        `authorId` INT UNSIGNED NOT NULL,
        `title` VARCHAR(255) NOT NULL,
        `content` TEXT NOT NULL,
        `created_at` TIMESTAMP NOT NULL,
        PRIMARY KEY (`id`),
        FOREIGN KEY (`authorId`) REFERENCES `users`(`id`)
    );