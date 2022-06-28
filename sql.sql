CREATE TABLE `testdb`.`tb1` (
                                `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
                                `sum` DECIMAL UNSIGNED NOT NULL,
                                `type` VARCHAR(255) NOT NULL,
                                `comment` VARCHAR(45) NOT NULL,
                                PRIMARY KEY (`id`),
                                UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE)
    ENGINE = InnoDB
    DEFAULT CHARACTER SET = utf8;