**Installation** 

- SQL :

 ``CREATE TABLE `seyna_requests` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `uri` varchar(255) NOT NULL,
    `method` varchar(255) NOT NULL,
    `httpStatus` varchar(255) NOT NULL,
    `response` text NOT NULL,
    `body` text NOT NULL,
    `error` varchar(255) NOT NULL,
    `stamp` int(11) NOT NULL,
    PRIMARY KEY (`id`)
   ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4``
   
   