--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE `comments` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `body` mediumtext,
  `created_at` datetime DEFAULT NULL,
  `news_id` int(10) DEFAULT NULL,
  `user_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
TRUNCATE TABLE comments;

INSERT INTO comments (body, created_at, news_id, user_id)
VALUES ('This is a great news!', '2024-03-26 18:45:21', 1, 1),
       ('Wow, amazing content!', '2024-03-26 18:46:21', 1, 1),
       ('I agree with this article.', '2024-03-26 18:47:21', 1, 1);

INSERT INTO comments (body, created_at, news_id, user_id)
VALUES ('Interesting news, thanks for sharing.', '2024-03-26 18:48:21', 2, 2),
       ('I found this article very informative.', '2024-03-26 18:49:21', 2, 2),
       ('Can''t wait to read more from you!', '2024-03-26 18:50:21', 2, 2);

INSERT INTO comments (body, created_at, news_id, user_id)
VALUES ('This news is mind-blowing!', '2024-03-26 18:51:21', 3, 3),
       ('I had no idea about this, thanks for sharing.', '2024-03-26 18:52:21', 3, 3),
       ('Great work, keep it up!', '2024-03-26 18:53:21', 3, 3);

UNLOCK TABLES;

--
-- Table structure for table `news`
--

DROP TABLE IF EXISTS `news`;
CREATE TABLE `news` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(511) DEFAULT NULL,
  `body` mediumtext,
  `user_id` int(10) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `news`
--

LOCK TABLES `news` WRITE;
TRUNCATE TABLE news;
INSERT INTO news (title, body, user_id, created_at)
VALUES ('Sample News Title 1', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus placerat aliquam ipsum eu ultricies. Maecenas tincidunt, lorem eget vehicula suscipit, nunc lorem tincidunt nisi, nec suscipit libero turpis non risus. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Nam in eros vitae magna fermentum varius. Sed auctor justo vel tellus ullamcorper, vel tincidunt nulla fermentum. Nam ultrices arcu sit amet enim consequat, sed consequat dui vestibulum. Integer hendrerit sapien nisi, ac convallis metus volutpat a.', 1, '2024-03-26 18:44:21'),
       ('Sample News Title 2', 'Praesent aliquet auctor tellus sed laoreet. Sed fringilla tincidunt urna, eu cursus neque sollicitudin eget. Sed suscipit lacinia justo, at hendrerit velit tincidunt ut. Integer fermentum tempor nunc, eget laoreet arcu eleifend nec. Mauris nec erat nec sapien varius posuere non eu nisi. Vestibulum nec gravida magna. Ut vitae tincidunt orci. Ut in tortor non elit sollicitudin rhoncus.', 2, '2024-03-26 18:44:21'),
       ('Sample News Title 3', 'Fusce nec aliquet ante. Curabitur lacinia varius eros eget lacinia. Integer laoreet urna ut sapien bibendum vehicula. Sed in ante vitae odio tincidunt malesuada. In et mauris sit amet quam placerat iaculis. Vivamus id justo ac arcu egestas elementum. Ut accumsan aliquet nibh, sed laoreet lorem faucibus sit amet. Nam nec dolor nec magna iaculis venenatis.', 3, '2024-03-26 18:44:21');

UNLOCK TABLES;


--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(511) DEFAULT NULL,
  `password` varchar(511) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
TRUNCATE TABLE users;
INSERT INTO `users` (`username`, `password`) VALUES 
('admin', 'admin'),
('user', 'user'),
('demo', 'demo');

UNLOCK TABLES;

